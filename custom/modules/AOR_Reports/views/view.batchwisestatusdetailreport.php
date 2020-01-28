<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');

//error_reporting(-1);
//ini_set('display_errors', 'On');

class AOR_ReportsViewBatchwisestatusdetailreport extends SugarView
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


        //print_r($selectedMangers);
        $is_manger = $this->checkManager();
        $conditons = '';

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
        $batchSql     = "SELECT id,name,batch_code FROM te_ba_batch WHERE batch_status='enrollment_in_progress' AND deleted=0";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        while ($row          = $db->fetchByAssoc($batchObj))
        {
            $batchOptions[] = $row;
        }
        return $batchOptions;
    }

    function getProgram()
    {
        global $db;
        $proSql      = "SELECT id,name FROM te_pr_programs WHERE deleted=0";
        $pro_Obj     = $db->query($proSql);
        $pro_Options = array();
        while ($row         = $db->fetchByAssoc($pro_Obj))
        {
            $pro_Options[] = $row;
        }
        return $pro_Options;
    }

    function clean($string)
    {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9-]/', '', $string); // Removes special chars.
    }
    
    function getNotconnected($wherecl)
    {
        global $db;
        $leadList = array();
        $leadSql  = "SELECT COUNT(l.id) AS lead_count, 
                         IF(te_ba_batch.id IS NULL,'NA',te_ba_batch.id) AS batch_id,
                         te_ba_batch.batch_code
                         FROM leads l
                         INNER JOIN leads_cstm AS lc ON l.id=lc.id_c
                         INNER JOIN te_ba_batch ON lc.te_ba_batch_id_c = te_ba_batch.id
                         WHERE l.deleted=0 $wherecl 
                             and l.status_description!='Re-Enquired' 
                             and (l.dispositionName!='CONNECTED' || l.dispositionName IS NULL)
                         GROUP BY te_ba_batch.id";

        $leadObj = $db->query($leadSql);



        while ($row = $db->fetchByAssoc($leadObj))
        {
            $leadList[$row['batch_id']] = $row['lead_count'];
        }

        return $leadList;
    }
   
    public function display()
    {

        global $sugar_config, $app_list_strings, $current_user, $db;
        
         //~~~~~~~
            $report_action = '';
            $reportAccess  = reportAccessLog();

            $current_user_id = $current_user->id;
            $report_action   = isset($GLOBALS['action']) ? $GLOBALS['action'] : '';


                if (!in_array($current_user->id, $reportAccess[$report_action]) && ($current_user->is_admin != 1))
                {
                    echo 'You are not authorized to access!';
                    return;
                }
            //~~~~~~~

                
        $where             = "";
        $wherecl           = "";
        $BatchListData     = $this->getBatch();
        $ProgrammeListData = $this->getProgram();
        $is_manger = $this->checkManager();
        $managerSList    = $this->getManagers();
        $CouncellorsList   = $this->getCouncelor($_SESSION['cccon_managers']);
        
        $selected_batch='';
        $selected_status='';
        $selected_vendor='';
        $selected_medium_val='';$selected_source='';$selected_batch_code='';$selected_program='';$selected_councellors='';$left='';
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
            $_SESSION['cccon_from_date']  = $_REQUEST['from_date'];
            $_SESSION['cccon_to_date']    = $_REQUEST['to_date'];
             $_SESSION['cccon_batch']      = (isset($_REQUEST['batch']))? $_REQUEST['batch']:'';
            $_SESSION['cccon_program']    = $_REQUEST['program'];
            $_SESSION['cccon_batch_code'] = $_REQUEST['batch_code'];
            $_SESSION['cccon_vendors']    = $_REQUEST['vendors'];
            $_SESSION['cccon_medium_val'] = $_REQUEST['medium_val'];
            $_SESSION['cccon_status']     = $_REQUEST['status'];
            $_SESSION['cccon_managers']   = $_REQUEST['managers'];
            $_SESSION['cccon_councellors'] = $_REQUEST['councellors'];
            
            //print_r($_REQUEST['councellors']); die;
        }
        if ($_SESSION['cccon_from_date'] != "" && $_SESSION['cccon_to_date'] != "")
        {
            $selected_from_date = $_SESSION['cccon_from_date'];
            $selected_to_date   = $_SESSION['cccon_to_date'];
            $from_date          = date('Y-m-d', strtotime(str_replace('/', '-', $_SESSION['cccon_from_date'])));
            $to_date            = date('Y-m-d', strtotime(str_replace('/', '-', $_SESSION['cccon_to_date'])));
            $wherecl            .= " AND DATE(l.date_entered)>='" . $from_date . "' AND DATE(l.date_entered)<='" . $to_date . "'";
        }
        elseif ($_SESSION['cccon_from_date'] != "" && $_SESSION['cccon_to_date'] == "")
        {
            $selected_from_date = $_SESSION['cccon_from_date'];
            $from_date          = date('Y-m-d', strtotime(str_replace('/', '-', $_SESSION['cccon_from_date'])));
            $wherecl            .= " AND DATE(l.date_entered)>='" . $from_date . "' ";
        }
        elseif ($_SESSION['cccon_from_date'] == "" && $_SESSION['cccon_to_date'] != "")
        {
            $selected_to_date = $_SESSION['cccon_to_date'];
            $to_date          = date('Y-m-d', strtotime(str_replace('/', '-', $_SESSION['cccon_to_date'])));
            $wherecl          .= " AND DATE(l.date_entered)<='" . $to_date . "' ";
        }
        if (!empty($_SESSION['cccon_status']))
        {
            $selected_status = $_SESSION['cccon_status'];
        }
        $findBatch = array();
        if (!empty($_SESSION['cccon_batch']))
        {
            $selected_batch = $_SESSION['cccon_batch'];
            //$batches        = $this->getBatch($_SESSION['cccon_batch']);
        }
        if (!empty($_SESSION['cccon_program']))
        {
            $selected_program = $_SESSION['cccon_program'];
        }
        if (!empty($_SESSION['cccon_batch_code']))
        {
            $selected_batch_code = $_SESSION['cccon_batch_code'];
            //$batches        = $this->getBatch($_SESSION['cccon_batch']);
        }
        if (!empty($_SESSION['cccon_councellors']))
        {
            $selected_councellors = $_SESSION['cccon_councellors'];
            
           
        }
        if (!empty($_SESSION['cccon_managers']))
        {
            $selected_managers = $_SESSION['cccon_managers'];
        }
        
         if ($is_manger == 1)
        {
            $selected_managers = array($current_user->id);
        }

        $programList = array();
        $StatusList  = array();

        if (!empty($selected_program))
        {

            $wherecl .= " AND  p.id IN ('" . implode("','", $selected_program) . "')";
        }
        if (!empty($selected_batch))
        {

            $wherecl .= " AND  te_ba_batch.id IN ('" . implode("','", $selected_batch) . "')";
        }
        if (!empty($selected_batch_code))
        {

            $wherecl .= " AND  te_ba_batch.id IN ('" . implode("','", $selected_batch_code) . "')";
        }
        if (!empty($selected_councellors))
        {
            $wherecl .= " AND  leads.assigned_user_id IN ('" . implode("','", $selected_councellors) . "')";
        }

        $StatusList['new_lead']               = 'New Lead';
        $StatusList['follow_up']              = 'Follow-Up';
        $StatusList['prospect']               = 'Prospect';
        
        $StatusList['dead_number']            = 'Dead Number';
        $StatusList['ringing_multiple_times'] = 'Ringing Multiple Times';
        $StatusList['dispositions']            = 'Non-connect';
        
        $StatusList['fallout']                = 'Fallout';       
        $StatusList['not_eligible']           = 'Not Eligible';
        $StatusList['not_enquired']           = 'Not Enquired';
        $StatusList['wrong_number']           = 'Wrong Number';
        
        $StatusList['converted']              = 'Converted';
        //$StatusList['na']                     = 'NA';

//        $StatusList['call_back']              = 'Call-back';
//        $StatusList['retired']                = 'Retired';
//        $StatusList['re_enquired']            = 'Re-Enquired';
//        $StatusList['recycle']                = 'Recycle';
//        $StatusList['dropout']                = 'Dropout';
//        $StatusList['duplicate']              = 'Duplicate';
//        $StatusList['na']                     = 'NA';
           $getNotConnected = $this->getNotconnected($wherecl);
           //echo '<pre>'.print_r($getNotConnected); die;
           $leadSql = "SELECT COUNT(l.id) AS lead_count,
                                l.date_entered,
                                IF(te_ba_batch.id IS NULL,'NA',te_ba_batch.id) AS batch_id,
                                IF(te_ba_batch.name IS NULL,'NA',te_ba_batch.name) AS batch_name,
                                IF(te_ba_batch.batch_code IS NULL,'NA',te_ba_batch.batch_code) AS batch_code,
                                IF(l.status_description IS NULL
                                   OR l.status_description ='', 'NA', l.status_description) AS status_description
                         FROM leads l
                         INNER JOIN leads_cstm AS lc ON l.id=lc.id_c
                         INNER JOIN te_ba_batch ON lc.te_ba_batch_id_c = te_ba_batch.id
                         WHERE l.deleted=0 $wherecl 
                             #and te_ba_batch.batch_code='GSCM-01-0318-01'
                         GROUP BY l.status_description,
                                  te_ba_batch.id";
          
        if (isset($_POST['export']) && $_POST['export'] == "Export")
        {

            $file     = "Lead_connectivity_report";
            $where    = '';
            $filename = $file . "_" . $from_date . "_" . $to_date;

          
            //echo $leadSql;exit();


            $leadObj = $db->query($leadSql);

            $i=1;
            while ($row = $db->fetchByAssoc($leadObj))
            {


                $programList[$row['batch_id']]['id']           = $row['batch_id'];
                $programList[$row['batch_id']]['name']         = $this->clean($row['batch_name']);
                $programList[$row['batch_id']]['batch_code']   = $row['batch_code'];
                #$programList[$row['batch_id']]['program_name'] = $this->clean($row['program_name']);
                
               $programList[$row['batch_id']]['dispositions'] = (isset($getNotConnected[$row['batch_id']]))?$getNotConnected[$row['batch_id']]:0;


                $programList[$row['batch_id']][strtolower(str_replace(array(' ', '-'), '_', $row['status_description']))] = $row['lead_count'];
            }



            # Create heading
            #$data = "Programme Name";
            $data = "Batch Name";
            $data .= ",Batch Code";
            foreach ($StatusList as $key => $statusVal)
            {
                $data .= "," . $statusVal;
            }
            $data .= ",Total";
            $data .= "\n";




            foreach ($programList as $key => $councelor)
            {
                $data .= "\"" .  $this->clean($councelor['name']);
                #$data .= "\",\"" . $councelor['name'];
                $data .= "\",\"" . $councelor['batch_code'];
                $toal = 0;
                foreach ($StatusList as $key1 => $value)
                {
                    $countedLead = (!empty($programList[$key][$key1]) ? $programList[$key][$key1] : 0);
                    $data        .= "\",\"" . $countedLead;
                    $toal        += $countedLead;
                }
                $data .= "\",\"" . $toal;
                $data .= "\"\n";
            }

            ob_end_clean();
            header("Content-type: application/csv");
            header('Content-disposition: attachment;filename=" ' . $filename . '.csv";');
            echo $data;
            exit;
        } // End Of Export Func



        $leadObj = $db->query($leadSql);

        $i=1;
        while ($row = $db->fetchByAssoc($leadObj))
        {


            $programList[$row['batch_id']]['id']           = $row['batch_id'];
            $programList[$row['batch_id']]['name']         = $row['batch_name'];
            $programList[$row['batch_id']]['batch_code']   = $row['batch_code'];
            #$programList[$row['batch_id']]['program_name'] = $row['program_name'];

            //if($row['dispositionName']!='CONNECTED'){
            //$programList[$row['batch_id']]['check_despo'][] = $row['dispositionName'];
            $programList[$row['batch_id']]['dispositions'] = (isset($getNotConnected[$row['batch_id']]))?$getNotConnected[$row['batch_id']]:0;
            //}
            $programList[$row['batch_id']][strtolower(str_replace(array(' ', '-'), '_', $row['status_description']))] = $row['lead_count'];
        }

        //echo '<pre>';
        //print_r($programList); die;

        $total     = count($programList); #total records
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

        $programList = array_slice($programList, $start, $per_page);
        if ($total > $per_page)
        {
            $current = "(" . ($start + 1) . "-" . ($start + $per_page) . " of " . $total . ")";
        }
        else
        {
            $current = "(" . ($start + 1) . "-" . count($programList) . " of " . $total . ")";
        }

        $sugarSmarty = new Sugar_Smarty();

        $sugarSmarty->assign("programList", $programList);

        //print_r($selected_councellors); die;
        $sugarSmarty->assign("BatchListData", $BatchListData);
        $sugarSmarty->assign("ProgrammeListData", $ProgrammeListData);
        $sugarSmarty->assign("StatusList", $StatusList);
        $sugarSmarty->assign("selected_batch", $selected_batch);
        $sugarSmarty->assign("selected_program", $selected_program);
        $sugarSmarty->assign("selected_status", $selected_status);
        $sugarSmarty->assign("selected_from_date", $selected_from_date);
        $sugarSmarty->assign("selected_to_date", $selected_to_date);
        $sugarSmarty->assign("selected_vendor", $selected_vendor);
        $sugarSmarty->assign("selected_medium_val", $selected_medium_val);
        $sugarSmarty->assign("councelorList",$councelorList);
        $sugarSmarty->assign("selected_source", $selected_source);

        $sugarSmarty->assign("selected_batch_code", $selected_batch_code);

        $sugarSmarty->assign("CouncellorsList", $CouncellorsList);
        $sugarSmarty->assign("managerSList", $managerSList);

        $sugarSmarty->assign("selected_managers", $selected_managers);
        $sugarSmarty->assign("selected_councellors", $selected_councellors);

        $sugarSmarty->assign("current_records", $current);
        $sugarSmarty->assign("page", $page);
        $sugarSmarty->assign("pagenext", $pagenext);
        $sugarSmarty->assign("right", $right);
        $sugarSmarty->assign("left", $left);
        $sugarSmarty->assign("last_page", $last_page);
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/batchwisestatusdetailreport.tpl');
    }

}

?>
