<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');

//error_reporting(E_ALL);
//ini_set('display_errors', 'On');

class AOR_ReportsViewCounsellorwisestatusdetailreport extends SugarView
{

    var $report_to_id;
    var $counsellors_arr;

    public function __construct()
    {
        parent::SugarView();
    }

  
  
    function reportingUser($currentUserId)
    {
        $userObj                             = new User();
        $userObj->disable_row_level_security = true;
        $userList                            = $userObj->get_full_list("", "users.reports_to_id='" . $currentUserId . "'");
        if (!empty($userList))
        {
            foreach ($userList as $record)
            {
                if (!empty($record->reports_to_id) && !empty($record->id))
                {
                    $this->report_to_id[] = $record->id;
                    $this->reportingUser($record->id);
                }
            }
        }
    }

    function getCouncelor($user_id)
    {
        global $db;
        $userSql = "SELECT 
                        CONCAT(first_name, ' ', last_name) AS name
                    FROM users
                    WHERE deleted=0
                      AND id='" . $user_id . "'";
        $userObj = $db->query($userSql);
        $user    = $db->fetchByAssoc($userObj);
        return $user['name'];
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

   function getCouncelorForAdmin($user_id = NULL)
    {
        global $db;
        $userSql  = "SELECT u.first_name,
                            u.last_name,
                            u.id,
                            ru.first_name AS reporting_firstname,
                            ru.last_name AS reporting_lastname,
                            ru.id AS reporting_id
                     FROM users AS u
                     INNER JOIN acl_roles_users AS aru ON aru.user_id=u.id
                     LEFT JOIN users AS ru ON ru.id=u.reports_to_id
                     WHERE aru.`role_id` IN ('7e225ca3-69fa-a75d-f3f2-581d88cafd9a',
                                             '270ce9dd-7f7d-a7bf-f758-582aeb4f2a45',
                                             'cc7133be-0db9-d50a-2684-582c0078e74e')
                       AND u.deleted=0
                       AND aru.deleted=0";
        $userObj  = $db->query($userSql);
        $usersArr = [];
        while ($user     = $db->fetchByAssoc($userObj))
        {
            $usersArr[$user['id']] = array(
                'id'             => $user['id'],
                'name'           => $user['first_name'] . ' ' . $user['last_name'],
                'reporting_id'   => $user['reporting_id'],
                'reporting_name' => $user['reporting_firstname'] . ' ' . $user['reporting_lastname']
            );
        }
        return $usersArr;
    }

    function getCouncelorForUsers($user_ids = array())
    {
        global $db;
        $userSql  = "SELECT u.first_name,
                            u.last_name,
                            u.id,
                            ru.first_name AS reporting_firstname,
                            ru.last_name AS reporting_lastname,
                            ru.id AS reporting_id
                     FROM users AS u
                     LEFT JOIN users AS ru ON ru.id=u.reports_to_id
                     WHERE u.id IN ('" . implode("',
                                    '", $user_ids) . "')
                       AND u.deleted=0";
        $userObj  = $db->query($userSql);
        $usersArr = [];
        while ($user     = $db->fetchByAssoc($userObj))
        {
            $usersArr[$user['id']] = array(
                'id'             => $user['id'],
                'name'           => $user['first_name'] . ' ' . $user['last_name'],
                'reporting_id'   => $user['reporting_id'],
                'reporting_name' => $user['reporting_firstname'] . ' ' . $user['reporting_lastname']
            );
        }
        return $usersArr;
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

                
        $additionalUsr         = array('4fa58025-3c9d-aa2a-d355-59a062393942','581d9edd-a5e4-349a-fe28-5c59b9d2fe37');
        $additionalUsrStatus   = 0;
        $current_user_id       = $current_user->id;
        $current_user_is_admin = $current_user->is_admin;
        $where                 = "";
        $wherecl               = "";
        $usersdd               = "";
        $error                 = array();
        
        if (in_array($current_user_id, $additionalUsr))
        {
             $additionalUsrStatus   = 1;
        }

        $managerSList    = $this->getManagers();
        $CouncellorsList = $this->getCouncelor($_SESSION['cccon_managers']);
        $BatchListData   = $this->getBatch();
        $lead_source     = $GLOBALS['app_list_strings']['lead_source_custom_dom'];
        
        if ($current_user_is_admin == 1 || in_array($current_user_id, $additionalUsr))
        {   //echo  '1';
            $usersdd = $this->getCouncelorForAdmin();
        }
        else
        {
            $this->report_to_id[] = $current_user_id;
            $reportingusersids    = $this->reportingUser($current_user_id);

            $uid = $this->report_to_id;
            //echo  '2';
            $usersdd = $this->getCouncelorForUsers($uid);
        }
        
        //echo "<pre>";print_r($usersdd);


        $is_manger = $this->checkManager();

       

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
            $_SESSION['cccon_from_date']         = isset($_REQUEST['from_date'])? $_REQUEST['from_date'] : $_REQUEST['from_date'];
            $_SESSION['cccon_to_date']           = isset($_REQUEST['to_date'])? $_REQUEST['to_date'] : $_REQUEST['to_date'];
            $_SESSION['cccon_batch']             = isset($_REQUEST['batch'])? $_REQUEST['batch'] : $_REQUEST['batch'];
            $_SESSION['cccon_batch_code']        = isset($_REQUEST['batch_code'])? $_REQUEST['batch_code'] : $_REQUEST['batch_code'];
            $_SESSION['cccon_managers']          = isset($_REQUEST['managers'])? $_REQUEST['managers'] : $_REQUEST['managers'];
            $_SESSION['cccon_councellors']       = isset($_REQUEST['councellors'])? $_REQUEST['councellors'] : $_REQUEST['councellors'];
            $_SESSION['cccon_status']            = isset($_REQUEST['status'])? $_REQUEST['status'] : $_REQUEST['status'];
            $_SESSION['cccon_lead_source_types'] = isset($_REQUEST['lead_source_types'])? $_REQUEST['lead_source_types'] : $_REQUEST['lead_source_types'];
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


        $lead_source_typesArr = array('NULL' => 'NULL', 'CC' => 'CC', 'OO' => 'OO', 'CO' => 'CO');

        $statusArr                            = ['alive', 'dead', 'converted', 'warm', 'recycle', 'dropout'];
        
        $StatusList['call_back']              = 'Call Back';
        $StatusList['follow_up']              = 'Follow Up';
        $StatusList['new_lead']               = 'New Lead'; 
        $StatusList['converted']              = 'Converted';
        $StatusList['instalment_follow_up']   = 'Instalment Follow Up';
        $StatusList['referral_follow_up']     = 'Referral Follow Up';
        $StatusList['null']                   = 'Null';
        $StatusList['prospect']               = 'Prospect';
        $StatusList['re_enquired']            = 'Re-Enquired';
        $StatusList['cross_sell']             = 'Cross Sell';
        $StatusList['dnc']                    = 'DNC';
        $StatusList['fallout']                = 'Fallout';
        $StatusList['next_batch']             = 'Next Batch';
        $StatusList['not_answering']          = 'Not Answering';
        $StatusList['not_eligible']           = 'Not Eligible';
        $StatusList['not_enquired']           = 'Not Enquired';
        $StatusList['not_interested']         = 'Not Interested';
        $StatusList['wrong_number']           = 'Wrong Number';
        $StatusList['auto_retired']           = 'Auto Retired';
        $StatusList['retired']                = 'Retired';
        $StatusList['re-assigned']            = 'Re-Assigned';
        $StatusList['user_forced_logged_off'] = 'user_forced_logged_off'; 
        $StatusList['wrap_timeout']           = 'wrap_timeout';
        $StatusList['recycle']                = 'Recycle';
      
        $leadSql = "SELECT COUNT(leads.id) AS lead_count,
                    COALESCE(te_ba_batch.id,'NA') AS batch_id,
                    COALESCE(te_ba_batch.batch_code,'NA')AS batch_code,
                    leads.status_description,
                    users.user_name,
                    users.first_name,
                    users.last_name,
                    
                    leads.assigned_user_id
                FROM leads 
                INNER JOIN users ON leads.assigned_user_id =users.id
                INNER JOIN leads_cstm AS lc ON leads.id=lc.id_c
                INNER JOIN te_ba_batch ON lc.te_ba_batch_id_c = te_ba_batch.id
                 WHERE leads.deleted=0
                   $wherecl
              GROUP BY leads.status_description,leads.assigned_user_id,te_ba_batch.batch_code order by  te_ba_batch.batch_code ";
        //echo $leadSql;
        //exit();


        $leadObj = $db->query($leadSql);
        while ($row     = $db->fetchByAssoc($leadObj))
        {
            // echo "<pre>"; print_r($row);
            $programList[$row['assigned_user_id'] . '_BATCH_' . $row['batch_id']]['batch_id']                                                                = $row['batch_id'];
            //$programList[$row['assigned_user_id'] . '_BATCH_' . $row['batch_id']]['batch_name']                                                              = $row['batch_name'];
            $programList[$row['assigned_user_id'] . '_BATCH_' . $row['batch_id']]['batch_code']                                                              = $row['batch_code'];
            $programList[$row['assigned_user_id'] . '_BATCH_' . $row['batch_id']]['batch_id']                                                                = $row['batch_id'];
            $programList[$row['assigned_user_id'] . '_BATCH_' . $row['batch_id']]['assigned_user']                                                           = $row['first_name'].' '.$row['last_name'];
            $programList[$row['assigned_user_id'] . '_BATCH_' . $row['batch_id']]['assigned_user_id']                                                        = $row['assigned_user_id'];
            $programList[$row['assigned_user_id'] . '_BATCH_' . $row['batch_id']]['reporting_user']                                                          = isset($usersdd[$row['assigned_user_id']]['reporting_name']) ? $usersdd[$row['assigned_user_id']]['reporting_name'] : 'NA';
            $programList[$row['assigned_user_id'] . '_BATCH_' . $row['batch_id']][strtolower(str_replace(array(' ', '-'), '_', $row['status_description']))] = $row['lead_count'];
        }
// echo "<pre>"; print_r($programList);
        foreach ($programList as $key => $val)
        {
            foreach($val as $keycheck => $valuecheck)
            {
                $total = 0;
                
                if($keycheck == "user.forced.logged.off" || $keycheck == "wrap.timeout")
                {
                    $forced_logged['user_forced_logged_off'] = $valuecheck['user.forced.logged.off'];
                    $wrap_timeout['wrap_timeout']            = $valuecheck['wrap.timeout'];
                    
                    $programList[$key]['user_forced_logged_off']      = $forced_logged['user_forced_logged_off'];
                    $programList[$key]['wrap_timeout']                = $wrap_timeout['wrap_timeout'];
                    
                    unset($programList[$key]['user.forced.logged.off']);
                    unset($programList[$key]['wrap.timeout']);
                }
                foreach ($StatusList as $key1 => $value)
                {
                    $countedLead = (isset($programList[$key][$key1]) && !empty($programList[$key][$key1]) ? $programList[$key][$key1] : 0);
                    $total       += $countedLead;
                }
                $programList[$key]['total'] = $total;
            }
            
        }

        if (isset($_POST['export']) && $_POST['export'] == "Export")
        {

            $file     = "CounselorWiseStatusdetail_report";
            $where    = '';
            $filename = $file . "_" . $from_date . "_" . $to_date;

            
            # Create heading
            $data = "Counsellor Name";
            $data .= ",Reporting Manager";
            //$data .= ",Batch Name";
            $data .= ",Batch Code";
            $data .= ",Total";
            foreach ($StatusList as $statusVal)
            {
                $data .= "," . $statusVal;
            }
            $data .= "\n";



            //echo "<pre>";print_r($programList);exit();
            foreach ($programList as $key => $councelor)
            {
                $data .= "\"" . $councelor['assigned_user'];
                $data .= "\",\"" . $councelor['reporting_user'];
                //$data .= "\",\"" . $councelor['batch_name'];
                $data .= "\",\"" . $councelor['batch_code'];
                $data .= "\",\"" . $councelor['total'];

                foreach ($StatusList as $key1 => $val)
                {
                    $countedLead = (!empty($programList[$key][$key1]) ? $programList[$key][$key1] : 0);
                    $data        .= "\",\"" . $countedLead;
                }
                $data .= "\"\n";
            }

            ob_end_clean();
            header("Content-type: application/csv");
            header('Content-disposition: attachment;filename=" ' . $filename . '.csv";');
            echo $data;
            exit;
        } // End Of Export Func


        $total     = count($programList); #total records
        $start     = 0;
        $per_page  = 30;
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
        #pE
        $sugarSmarty = new Sugar_Smarty();

        $sugarSmarty->assign("programList", $programList);


        $sugarSmarty->assign("date_entered", "date_entered");
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
        $sugarSmarty->assign("current_user_is_admin", $current_user_is_admin); 
        $sugarSmarty->assign("additionalUsrStatus", $additionalUsrStatus); 
        $sugarSmarty->assign("CouncellorsList", $CouncellorsList);
        $sugarSmarty->assign("managerSList", $managerSList);



        $sugarSmarty->assign("current_records", $current);
        $sugarSmarty->assign("page", $page);
        $sugarSmarty->assign("pagenext", $pagenext);
        $sugarSmarty->assign("right", $right);
        $sugarSmarty->assign("left", $left);
        $sugarSmarty->assign("last_page", $last_page);
        $sugarSmarty->assign("statusArr", $statusArr);
        $sugarSmarty->assign("StatusList", $StatusList);
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/counsellorwisestatusdetailreport.tpl');
    }

}

?>
