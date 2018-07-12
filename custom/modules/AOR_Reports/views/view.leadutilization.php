<?php

// Date: Created on : 27th FEB 2018

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
ini_set('memory_limit', '1024M');
require_once('custom/include/Email/sendmail.php');

//error_reporting(-1);
//ini_set('display_errors', 'On');

class AOR_ReportsViewleadutilization extends SugarView
{

    var $report_to_id;
    var $counsellors_arr;

    public function __construct()
    {
        parent::SugarView();
    }

    function checkManager()
    {
        global $db, $current_user;
        $userSql = "SELECT u.id
                        FROM users AS u
                    INNER JOIN acl_roles_users AS aru ON aru.user_id=u.id
                    INNER JOIN acl_roles ON aru.role_id=acl_roles.id
                    INNER JOIN users AS ru ON ru.id=u.reports_to_id
                    WHERE aru.`role_id` IN ('7e225ca3-69fa-a75d-f3f2-581d88cafd9a')
                      AND u.deleted=0
                      AND u.id='" . $current_user->id . "'
                      AND aru.deleted=0
                      AND acl_roles.deleted=0 ";

        $userObj = $db->query($userSql);
        return $db->getRowCount($userObj);
    }

    function getManagers($role = '')
    {
        global $db, $current_user;

        $is_manger = $this->checkManager();
        $conditons = '';
        if ($is_manger == 1)
        {
            $conditons = 'AND u.id="' . $current_user->id . '"';
        }

        $userSql  = "SELECT u.first_name,
                                u.last_name,
                                u.id,
                                ru.first_name AS reporting_firstname,
                                ru.last_name AS reporting_lastname,
                                ru.id AS reporting_id
                         FROM users AS u
                         INNER JOIN acl_roles_users AS aru ON aru.user_id=u.id
 			 INNER join acl_roles on aru.role_id=acl_roles.id
                         INNER JOIN users AS ru ON ru.id=u.reports_to_id
                         WHERE aru.`role_id` IN ('7e225ca3-69fa-a75d-f3f2-581d88cafd9a')
                           AND u.deleted=0 $conditons
                           AND aru.deleted=0 
                           AND acl_roles.deleted=0 
                           AND u.deleted=0  
                           AND u.employee_status='Active'";
        $userObj  = $db->query($userSql);
        $usersArr = [];
        while ($user     = $db->fetchByAssoc($userObj))
        {

            $usersArr[$user['id']]['id']             = $user['id'];
            $usersArr[$user['id']]['name']           = $user['first_name'] . ' ' . $user['last_name'];
            $usersArr[$user['id']]['reporting_id']   = $user['reporting_id'];
            $usersArr[$user['id']]['reporting_name'] = $user['reporting_firstname'] . ' ' . $user['reporting_lastname'];
        }
        return $usersArr;
    }

    function getCouncelor($selectedMangers = array())
    {
        global $db,$current_user;

         $is_manger = $this->checkManager();
         $conditons = '';
        //print_r($selectedMangers);

        if ($is_manger == 1)
        {
            $conditons = 'AND ru.id="' . $current_user->id . '"';
        }
        else if (!empty($selectedMangers))
        {


            $conditons = "AND ru.id in ('" . implode("','", $selectedMangers) . "')";
        }

        $userSql  = "SELECT u.first_name,
                                u.last_name,
                                u.id,
                                ru.first_name AS reporting_firstname,
                                ru.last_name AS reporting_lastname,
                                ru.id AS reporting_id
                         FROM users AS u
                         INNER JOIN acl_roles_users AS aru ON aru.user_id=u.id
 			 INNER join acl_roles on aru.role_id=acl_roles.id
                         INNER JOIN users AS ru ON ru.id=u.reports_to_id
                         WHERE aru.`role_id` IN ('270ce9dd-7f7d-a7bf-f758-582aeb4f2a45')
                           AND u.deleted=0 $conditons
                           AND aru.deleted=0 
                           AND acl_roles.deleted=0 
                           AND u.deleted=0 
                           AND u.employee_status='Active'";
        $userObj  = $db->query($userSql);
        $usersArr = [];
        while ($user     = $db->fetchByAssoc($userObj))
        {

            $usersArr[$user['id']]['id']             = $user['id'];
            $usersArr[$user['id']]['name']           = $user['first_name'] . ' ' . $user['last_name'];
            $usersArr[$user['id']]['reporting_id']   = $user['reporting_id'];
            $usersArr[$user['id']]['reporting_name'] = $user['reporting_firstname'] . ' ' . $user['reporting_lastname'];
        }
        return $usersArr;
    }

    function getBatch()
    {
        global $db;
        $batchSql     = "SELECT id,name,batch_code,d_campaign_id,d_lead_id FROM te_ba_batch WHERE batch_status='enrollment_in_progress' AND deleted=0 order by name";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        while ($row          = $db->fetchByAssoc($batchObj))
        {
            $batchOptions[] = $row;
        }
        return $batchOptions;
    }

    function getFresh($selected_batch_code,$selected_councellors)
    {
        global $db;
        $leadList = array();
        
        $and='';
        if(!empty($selected_councellors)){
            
              $and .= " AND  leads.assigned_user_id IN ('" . implode("','", $selected_councellors) . "')";
        }
        if(!empty($selected_batch_code)){
            
              //$and .= " AND  te_ba_batch.batch_code IN ('" . implode("','", $selected_batch_code) . "')";
        }
        
        $leadSql  = "SELECT COUNT(leads.id) AS fresh_lead_count,
                            te_ba_batch.id AS batch_id
                     FROM leads
                     INNER JOIN leads_cstm ON leads.id = leads_cstm.id_c
                     INNER JOIN te_ba_batch ON leads_cstm.te_ba_batch_id_c = te_ba_batch.id
                     WHERE leads.date_entered >= '" . $_SESSION['cccon_from_date'] . " 00:00:00'
                       AND leads.date_entered <= '" . $_SESSION['cccon_to_date'] . " 23:59:59'
                      and leads.status_description in ('New Lead','Follow Up','Prospect')
                       and leads.deleted=0
                       and leads_cstm.attempts_c=''
                       $and
                     GROUP  by  batch_code";

        $leadObj = $db->query($leadSql) or die(mysqli_error());



        while ($row = $db->fetchByAssoc($leadObj))
        {
            $leadList[$row['batch_id']] = $row['fresh_lead_count'];
        }

        return $leadList;
    }

    function getAttempts($selected_batch_code,$selected_councellors)
    {

        global $db;
        //$leadList   = array();
        $attemplist = array();
        
        $and='';
        if(!empty($selected_councellors)){
            
              $and .= " AND  leads.assigned_user_id IN ('" . implode("','", $selected_councellors) . "')";
        }
        if(!empty($selected_batch_code)){
            
              //$and .= " AND  te_ba_batch.batch_code IN ('" . implode("','", $selected_batch_code) . "')";
        }
        
        //echo '<pre>'.
                $leadSql    = "SELECT 
                            te_ba_batch.batch_code AS batch_code,
                            te_ba_batch.id AS batch_id,
			    leads.id lead_id,
                            leads.date_entered,
 		            leads_cstm.`attempts_c`,
			    dis.date_entered as dispo_date,
				dis.status,
				dis.status_detail
                     FROM leads
                     INNER JOIN leads_cstm ON leads.id = leads_cstm.id_c
                     INNER JOIN te_ba_batch ON leads_cstm.te_ba_batch_id_c = te_ba_batch.id and te_ba_batch.deleted=0
                     INNER join te_disposition_leads_c disrel on disrel.te_disposition_leadsleads_ida=leads.id and disrel.deleted=0
                     INNER join te_disposition dis on disrel.te_disposition_leadste_disposition_idb=dis.id and dis.deleted=0
                     WHERE leads.date_entered >= '" . $_SESSION['cccon_from_date'] . " 00:00:00'
                       AND leads.date_entered <= '" . $_SESSION['cccon_to_date'] . " 23:59:59'
                       AND leads.`deleted`=0 
                       AND leads_cstm.`attempts_c`>=1 
                       $and
                         group by leads.id order by dispo_date ";


        $leadObj      = $db->query($leadSql);
        $leadsBybatch = array();
        $attemplist   = array();

        while ($row = $db->fetchByAssoc($leadObj))
        {
            $leadsBybatch[$row['batch_code']][] = $row;
        }
        $TAT = 1;
        //echo '<pre>';
        //echo print_r($leadsBybatch);
        foreach ($leadsBybatch as $key => $val)
        {

            $outside_TAT      = array();
            $attempted_1_3    = array();
            $attempted_4_6    = array();
            $attempted_more_6 = array();
            foreach ($val as $key => $data)
            {

                //echo '<pre>';
                //print_r($val); echo 'bat='.$val[$key]['batch_code'];die;
                $mintsdiff = round(abs((strtotime($val[$key]['date_entered']) - strtotime($val[$key]['dispo_date']))) / 60);
                //echo 'date_entered='.$val[$key]['date_entered'].'  dispo_date='.$val[$key]['dispo_date'].' $mintsdiff=' . $mintsdiff.'attempts_c='.$val[$key]['attempts_c'].'<br>';
                //else if ($mintsdiff <= 1440 && ($val[$key]['attempts_c'] >= 1 && $val[$key]['attempts_c'] <= 3))
                if ($val[$key]['attempts_c'] >= 1 && $val[$key]['attempts_c'] <= 3)
                {
                    $attempted_1_3[]                                           = 1;
                    $attemplist[$val[$key]['batch_id']]['leads_attempted_1_3'] = (count($attempted_1_3));
                }
                //else if ($mintsdiff <= 1440 && ($val[$key]['attempts_c'] >= 4 && $val[$key]['attempts_c'] <= 6))
                else if ($val[$key]['attempts_c'] >= 4 && $val[$key]['attempts_c'] <= 6)
                {
                    $attempted_4_6[]                                           = 1;
                    $attemplist[$val[$key]['batch_id']]['leads_attempted_4_6'] = (count($attempted_4_6));
                }
                //else if ($mintsdiff <= 1440 && $row['attempts_c'] >= 6)
                else if ($val[$key]['attempts_c'] > 6)
                {   //echo 'helllooo';
                    $attempted_more_6[]                                                = 1;
                    $attemplist[$val[$key]['batch_id']]['leads_attempted_more_than_6'] = (count($attempted_more_6));
                }
                if ($mintsdiff > 1440)
                {   //echo 'total=='.$toal; 
                    $outside_TAT[]                                                   = 1;
                    $attemplist[$val[$key]['batch_id']]['leads_dialled_outside_TAT'] = (count($outside_TAT));
                }
                //echo '$toal='.$toal;
            }
        }

        return $attemplist;
        ///echo '<pre>';
        //print_r($attemplist);
    }

    public function display()
    {

        global $sugar_config, $app_list_strings, $current_user, $db;

        $is_manger = $this->checkManager();

        $where      = "";
        $wherecl    = "";
        $campaignID = array();
        $leadID     = array();

        $BatchListData = $this->getBatch();

        $error = array();

        $managerSList    = $this->getManagers();
        $CouncellorsList = $this->getCouncelor($_SESSION['cccon_managers']);
        $lead_source     = $GLOBALS['app_list_strings']['lead_source_custom_dom'];

        foreach ($lead_source as $key => $value)
        {
            $exp_key = explode('_', $key);
            if ($exp_key[0] == 'CC')
            {
                $arr_result[$key] = $value;
            }
        }
        $lead_source = $arr_result;

        



        if (!isset($_SESSION['cccon_from_date']))
        {
            $_SESSION['cccon_from_date'] = date('Y-m-d', strtotime('-1 days'));
        }
        if (!isset($_SESSION['cccon_to_date']))
        {
            $_SESSION['cccon_to_date'] = date('Y-m-d', strtotime('-1 days'));
        }
        if (isset($_POST['button']) || isset($_POST['export']))
        {
            $_SESSION['cccon_from_date']   = $_REQUEST['from_date'];
            $_SESSION['cccon_to_date']     = $_REQUEST['to_date'];
            $_SESSION['cccon_batch']       = $_REQUEST['batch'];
            $_SESSION['cccon_batch_code']  = $_REQUEST['batch_code'];
            $_SESSION['cccon_managers']    = $_REQUEST['managers'];
            $_SESSION['cccon_councellors'] = $_REQUEST['councellors'];
            $_SESSION['cccon_status']      = $_REQUEST['status'];
            $_SESSION['cccon_lead_source_types']      = $_REQUEST['lead_source_types'];
        }

        //$_SESSION['cccon_from_date']='2017-10-11';
        //$_SESSION['cccon_to_date']='2017-10-11'; 

        if ($_SESSION['cccon_from_date'] != "" && $_SESSION['cccon_to_date'] != "")
        {
            $selected_from_date = $_SESSION['cccon_from_date'];
            $selected_to_date   = $_SESSION['cccon_to_date'];
            $from_date          = date('Y-m-d', strtotime(str_replace('/', '-', $_SESSION['cccon_from_date'])));
            $to_date            = date('Y-m-d', strtotime(str_replace('/', '-', $_SESSION['cccon_to_date'])));
            //$from_date          = "2017-10-01";
            //$to_date            = "2017-10-05";
            $wherecl            .= " AND DATE(leads.date_entered) >= '" . $from_date . "' AND DATE(leads.date_entered) <= '" . $to_date . "'";
        }
        elseif ($_SESSION['cccon_from_date'] != "" && $_SESSION['cccon_to_date'] == "")
        {
            $selected_from_date = $_SESSION['cccon_from_date'];
            $from_date          = date('Y-m-d', strtotime(str_replace('/', '-', $_SESSION['cccon_from_date'])));
            $wherecl            .= " AND DATE(leads.date_entered) >= '" . $from_date . "' ";
        }
        elseif ($_SESSION['cccon_from_date'] == "" && $_SESSION['cccon_to_date'] != "")
        {
            $selected_to_date = $_SESSION['cccon_to_date'];
            $to_date          = date('Y-m-d', strtotime(str_replace('/', '-', $_SESSION['cccon_to_date'])));
            $wherecl          .= " AND DATE(leads.date_entered) <= '" . $to_date . "' ";
        }



        $findBatch = array();

        if (!empty($_SESSION['cccon_batch_code']))
        {
            $selected_batch_code = $_SESSION['cccon_batch_code'];
        }

        if (!empty($_SESSION['cccon_source']))
        {
            $selected_source = $_SESSION['cccon_source'];
        }

        if (!empty($_SESSION['cccon_status']))
        {
            $selected_status = $_SESSION['cccon_status'];
        }
        if (!empty($_SESSION['cccon_councellors']))
        {
            $selected_councellors = $_SESSION['cccon_councellors'];
        }
        if (!empty($_SESSION['cccon_managers']))
        {
            $selected_managers = $_SESSION['cccon_managers'];
        }
        if (!empty($_SESSION['cccon_status']))
        {
            $selected_status = $_SESSION['cccon_status'];
        }
        if (!empty($_SESSION['cccon_lead_source_types']))
        {
            $selected_lead_source_types = $_SESSION['cccon_lead_source_types'];
        }

        if ($is_manger == 1)
        {
            $selected_managers = array($current_user->id);
        }

        $leadList   = array();
        $StatusList = array();


        if (!empty($selected_batch_code))
        {
            $wherecl .= " AND  te_ba_batch.id IN ('" . implode("','", $selected_batch_code) . "')";
        }



        if (!empty($selected_source))
        {
            $wherecl .= " AND  leads.lead_source IN ('" . implode("','", $selected_source) . "')";
        }

        if (!empty($selected_councellors))
        {
            $wherecl .= " AND  leads.assigned_user_id IN ('" . implode("','", $selected_councellors) . "')";
        }
        
        if (!empty($selected_lead_source_types))
        {
            $wherecl .= " AND  leads.lead_source_types IN ('" . implode("','", $selected_lead_source_types) . "')";
        }


         $lead_source_typesArr = array('NULL'=>'NULL','CC'=>'CC','OO'=>'OO','CO'=>'CO');



                 //echo '<pre>'.  
                 $leadSql = "SELECT COUNT(leads.id) AS lead_count,
                            leads.date_entered,
                            te_ba_batch.id AS batch_id,
                            te_ba_batch.name AS batch_name,
                            te_ba_batch.batch_code
                     FROM leads
                     INNER JOIN leads_cstm ON leads.id = leads_cstm.id_c
                     INNER JOIN te_ba_batch ON leads_cstm.te_ba_batch_id_c = te_ba_batch.id and te_ba_batch.deleted=0
                     WHERE leads.deleted=0 $wherecl
                     GROUP  by  batch_code";

        $leadObj = $db->query($leadSql) or die(mysqli_error());

        $FresleadArr = $this->getFresh($selected_batch_code,$selected_councellors);
        $attemptArr  = $this->getAttempts($selected_batch_code,$selected_councellors);

        while ($row = $db->fetchByAssoc($leadObj))
        {

            $leadList[$row['batch_id']]['batch_id']     = $row['batch_id'];
            $leadList[$row['batch_id']]['date_entered'] = $row['date_entered'];
            $leadList[$row['batch_id']]['lead_count']   = $row['lead_count'];
            $leadList[$row['batch_id']]['batch_name']   = $row['batch_name'];
            $leadList[$row['batch_id']]['batch_code']   = $row['batch_code'];
            $leadList[$row['batch_id']]['fresh_leads']  = isset($FresleadArr[$row['batch_id']]) ? $FresleadArr[$row['batch_id']] : 0;

            $leadList[$row['batch_id']]['leads_dialled_outside_TAT']   = isset($attemptArr[$row['batch_id']]['leads_dialled_outside_TAT']) ? $attemptArr[$row['batch_id']]['leads_dialled_outside_TAT'] : 0;
            $leadList[$row['batch_id']]['leads_attempted_1_3']         = isset($attemptArr[$row['batch_id']]['leads_attempted_1_3']) ? $attemptArr[$row['batch_id']]['leads_attempted_1_3'] : 0;
            $leadList[$row['batch_id']]['leads_attempted_4_6']         = isset($attemptArr[$row['batch_id']]['leads_attempted_4_6']) ? $attemptArr[$row['batch_id']]['leads_attempted_4_6'] : 0;
            $leadList[$row['batch_id']]['leads_attempted_more_than_6'] = isset($attemptArr[$row['batch_id']]['leads_attempted_more_than_6']) ? $attemptArr[$row['batch_id']]['leads_attempted_more_than_6'] : 0;
        }

        //echo '<pre>';
        //print_r($leadList);
        #PS @Pawan
        $total     = count($leadList); #total records
        $start     = 0;
        $per_page  = 60;
        $page      = 1;
        $pagenext  = 1;
        $last_page = ceil($total / $per_page);

        if (isset($_REQUEST['page']) && $_REQUEST['page'] > 0)
        {
            $start    = $per_page * ($_REQUEST['page'] - 1);
            $page     = ($_REQUEST['page'] - 1);
            $pagenext = ($_REQUEST['page'] + 1);
        }
        else
        {

            $pagenext++;
        }
        if (($start + $per_page) < $total)
        {
            $right = 1;
        }
        else
        {
            $right = 0;
        }
        if (isset($_REQUEST['page']) && $_REQUEST['page'] == 1)
        {
            $left = 0;
        }
        elseif (isset($_REQUEST['page']))
        {

            $left = 1;
        }

        $leadList = array_slice($leadList, $start, $per_page);
        if ($total > $per_page)
        {
            $current = "(" . ($start + 1) . "-" . ($start + $per_page) . " of " . $total . ")";
        }
        else
        {
            $current = "(" . ($start + 1) . "-" . count($leadList) . " of " . $total . ")";
        }
        #pE

        $sugarSmarty = new Sugar_Smarty();

        $sugarSmarty->assign("error", $error);
        $sugarSmarty->assign("leadList", $leadList);



        $sugarSmarty->assign("BatchListData", $BatchListData);

        $sugarSmarty->assign("StatusList", $StatusList);
        $sugarSmarty->assign("leadList", $leadList);

        $sugarSmarty->assign("selected_batch_code", $selected_batch_code);
        $sugarSmarty->assign("selected_from_date", $selected_from_date);
        $sugarSmarty->assign("selected_to_date", $selected_to_date);
        $sugarSmarty->assign("lead_source_type", $lead_source);
        
        $sugarSmarty->assign("lead_source_types", $lead_source_typesArr);
        
        $sugarSmarty->assign("selected_lead_source_types", $selected_lead_source_types);
        
        

        $sugarSmarty->assign("selected_status", $selected_status);

        $sugarSmarty->assign("selected_source", $selected_source);
        $sugarSmarty->assign("selected_managers", $selected_managers);
        $sugarSmarty->assign("selected_councellors", $selected_councellors);



        $sugarSmarty->assign("CouncellorsList", $CouncellorsList);
        $sugarSmarty->assign("managerSList", $managerSList);


        $sugarSmarty->assign("current_records", $current);
        $sugarSmarty->assign("page", $page);
        $sugarSmarty->assign("pagenext", $pagenext);
        $sugarSmarty->assign("right", $right);
        $sugarSmarty->assign("left", $left);
        $sugarSmarty->assign("last_page", $last_page);
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/leadutilization.tpl');
    }

}
?>

