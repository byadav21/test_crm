<?php

// Date: Created on : 27th FEB 2018

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');

//error_reporting(-1);
//ini_set('display_errors', 'On');

class AOR_ReportsViewagentdashboardreport extends SugarView
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
        global $db, $current_user;


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
        $batchSql     = "SELECT id,name,batch_code,d_campaign_id,d_lead_id FROM te_ba_batch WHERE batch_status='enrollment_in_progress' AND deleted=0 order by name";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        while ($row          = $db->fetchByAssoc($batchObj))
        {
            $batchOptions[] = $row;
        }
        return $batchOptions;
    }

    ///////New task start
    function getConnectedCalls($month = '', $year = '')
    {
        global $db;

        $wherex = '';

        if (!empty($month))
        {
            $where .= " and month(reg_date)='$month' ";
        }
        if (!empty($year))
        {
            $wherex .= " and year(reg_date)='$year' ";
        }

        //#AND dispositionCode IN ('Fallout','Follow Up','Cross Sell','Prospect','Converted')

        $batchSql     = "select user,
                            count(lead_id) leadCont
                            from attempt_log 
                            where dispositionName='CONNECTED' 
                            $wherex
                           group by user,month(reg_date);";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        while ($row          = $db->fetchByAssoc($batchObj))
        {
            $batchOptions[$row['user']] = $row['leadCont'];
        }
        return $batchOptions;
    }

    function getMonthToDateActualCount($year = '', $month = '', $yesterday = '', $today = '',$selected_councellors=array())
    {
        global $db;

        $wherex = '';
        //echo '$year='.$year.'$month='.$month.'$yesterday='.$yesterday.'$yesterday='.$yesterday;
        if (!empty($month))
        {
            $wherex .= " AND month(leads.date_entered)>= '$month' ";
        }
        if (!empty($year))
        {
            $wherex .= " AND year(leads.date_entered)='$year' ";
        }
        if (!empty($yesterday))
        {

            $wherex .= " AND date(leads.date_entered)= '$yesterday' ";
        }
        if (!empty($today))
        {
            $wherex .= " AND date(leads.date_entered)= '$today' ";
        }
        
        if (!empty($selected_councellors))
        {
            $wherex .= " AND  leads.assigned_user_id IN ('" . implode("','", $selected_councellors) . "')";
        }

        $pinchedArr = array('Fallout', 'Follow Up', 'Cross Sell', 'Prospect', 'Converted');

        //echo '<pre>'.
        $batchSql     = "SELECT 
                            users.user_name,
                            leads.status_description,
                                month(leads.date_entered) monthwise,
                                year(leads.date_entered) yearwise,
                            count(leads.id) leadCont
                     FROM leads
                     LEFT JOIN users ON leads.assigned_user_id =users.id
                     LEFT JOIN leads_cstm ON leads.id= leads_cstm.id_c
                     WHERE leads.deleted=0
                       and leads.assigned_user_id!=''
                       AND leads.status_description IN ('Fallout','Follow Up','Cross Sell','Prospect','Converted')
                      $wherex
                     GROUP BY leads.assigned_user_id,leads.status_description,month(leads.date_entered)
                     order by leads.assigned_user_id,leads.status_description,month(leads.date_entered);";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        $pitchedCount = 0;
        while ($row          = $db->fetchByAssoc($batchObj))
        {


            if (in_array($row['status_description'], $pinchedArr))
            {

                $batchOptions[$row['user_name']]['pitched'] += $row['leadCont'];
            }
            if ($row['status_description'] == 'Prospect')
            {
                $batchOptions[$row['user_name']]['Prospects'] += $row['leadCont'];
            }
            if ($row['status_description'] == 'Converted')
            {

                $batchOptions[$row['user_name']]['Converts'] += $row['leadCont'];
            }
        }
        return $batchOptions;
    }

    function getMonthToDateTargetCount($year = '', $month = '', $yesterday = '', $today = '')
    {
        global $db;

        $wherex = '';

        if (!empty($month))
        {
            $where .= " AND apr.month >= '$month' ";
        }
        if (!empty($year))
        {
            $wherex .= " AND apr.year = '$year' ";
        }

        $batchSql     = "SELECT users.user_name,apr.target_pitched,apr.target_prospects,apr.target_unit
                     FROM agent_productivity_report apr
                     INNER JOIN users ON apr.user_id =users.id
                     where apr.status=1 and apr.deleted=0 
                     $wherex
                    order by apr.created_date desc;";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        while ($row          = $db->fetchByAssoc($batchObj))
        {
            $batchOptions[$row['user_name']]['pitched']   += $row['target_pitched'];
            $batchOptions[$row['user_name']]['Prospects'] += $row['target_prospects'];
            $batchOptions[$row['user_name']]['Converts']  += $row['target_unit'];
        }
        return $batchOptions;
    }

    ///////New task end


    public function display()
    {

        global $sugar_config, $app_list_strings, $current_user, $db;


        $where      = "";
        $wherecl    = "";
        $campaignID = array();
        $leadID     = array();

        //$BatchListData = $this->getBatch();
        $is_manger     = $this->checkManager();
        $error         = array();

        $managerSList    = $this->getManagers();
        $CouncellorsList = $this->getCouncelor($_SESSION['cccon_managers']);



        if (isset($_POST['button']) || isset($_POST['export']))
        {
            //$_SESSION['cccon_from_date']   = $_REQUEST['from_date'];
            //$_SESSION['cccon_to_date']     = $_REQUEST['to_date'];
            //$_SESSION['cccon_batch']       = $_REQUEST['batch'];
            //$_SESSION['cccon_batch_code']  = $_REQUEST['batch_code'];
            $_SESSION['cccon_managers']    = $_REQUEST['managers'];
            $_SESSION['cccon_councellors'] = $_REQUEST['councellors'];
            //$_SESSION['cccon_status']      = $_REQUEST['status'];
           
            $_SESSION['cccon_month'] = $_REQUEST['month'];
            $_SESSION['cccon_years'] = $_REQUEST['years'];
        }




        $findBatch = array();

        
        if (!empty($_SESSION['cccon_councellors']))
        {
            $selected_councellors = $_SESSION['cccon_councellors'];
        }
        if (!empty($_SESSION['cccon_managers']))
        {
            $selected_managers = $_SESSION['cccon_managers'];
        }
        if (!empty($_SESSION['cccon_month']))
        {
            $selected_month = $_SESSION['cccon_month'];
        }
        else
        {
            $selected_month = $current_year   = date('m');
        }
        if (!empty($_SESSION['cccon_years']))
        {
            $selected_years = $_SESSION['cccon_years'];
        }
        else
        {
            $selected_years = $current_year   = date('Y');
        }

        if ($is_manger == 1)
        {
            $selected_managers = array($current_user->id);
        }

        $theFInalArray = array();
       


       

      

        $months = array(1  => 'January', 2  => 'February', 3  => 'March', 4  => 'April', 5  => 'May', 6  => 'June', 7  => 'July',
            8  => 'August', 9  => 'September', 10 => 'October', 11 => 'November', 12 => 'December');

        $current_year = date('Y');
        $range        = range($current_year, $current_year - 1);
        $yearsList    = array_combine($range, $range);

        $todayDate  = date('Y-m-d');
        $yesterDate = date('Y-m-d', strtotime("-1 days"));
        
        if (empty($selected_month))
        {
             $selected_month = date('m');
        }
        if (empty($selected_years))
        {
             $selected_years = date('Y');
        }
        //The new code will go here..
        //echo '$selected_month='.$selected_month.'$selected_years='.$selected_years;
        //## All Connected
        $getConnectedCalls = $this->getConnectedCalls($selected_month, $selected_years);

        //## Actual Month wise leads
        $getMonthToDateActualCount = $this->getMonthToDateActualCount($selected_years, $selected_month, '','',$selected_councellors);

        //## Target month wise leads
        $getMonthToDateTargetCount = $this->getMonthToDateTargetCount($selected_years, $selected_month, '','');

        //### Yeastday real counts leads
        $getMonthToDateActualYesterdayCount = $this->getMonthToDateActualCount( '', '', date('Y-m-d', strtotime("-1 days")),'');
        //#### Today Real counts of leads
        $getMonthToDateActualTodayCount     = $this->getMonthToDateActualCount('','','', date('Y-m-d'));


        //echo '<pre>'; print_r($getMonthToDateActualYesterdayCount);  die;
        $theFInalArray = array();
        foreach ($getMonthToDateActualCount as $key => $val)
        {
            $theFInalArray[$key]['total_connected_calls'] = isset($getConnectedCalls[$key]) ? $getConnectedCalls[$key] : 0;

            $theFInalArray[$key]['target_pitched'] = isset($getMonthToDateTargetCount[$key]['pitched']) ? $getMonthToDateTargetCount[$key]['pitched'] : 0;
            $theFInalArray[$key]['actual_pitched'] = isset($getMonthToDateActualCount[$key]['pitched']) ? $getMonthToDateActualCount[$key]['pitched'] : 0;

            $theFInalArray[$key]['target_prospect'] = isset($getMonthToDateTargetCount[$key]['Prospects']) ? $getMonthToDateTargetCount[$key]['Prospects'] : 0;
            $theFInalArray[$key]['actual_prospect'] = isset($getMonthToDateActualCount[$key]['Prospects']) ? $getMonthToDateActualCount[$key]['Prospects'] : 0;

            $theFInalArray[$key]['target_converts'] = isset($getMonthToDateTargetCount[$key]['Converts']) ? $getMonthToDateTargetCount[$key]['Converts'] : 0;
            $theFInalArray[$key]['actual_converts'] = isset($getMonthToDateActualCount[$key]['Converts']) ? $getMonthToDateActualCount[$key]['Converts'] : 0;

            $theFInalArray[$key]['yesterday_pitched']  = isset($getMonthToDateActualYesterdayCount[$key]['pitched']) ? $getMonthToDateActualYesterdayCount[$key]['pitched'] : 0;
            $theFInalArray[$key]['yesterday_prospect'] = isset($getMonthToDateActualYesterdayCount[$key]['Prospects']) ? $getMonthToDateActualYesterdayCount[$key]['Prospects'] : 0;
            $theFInalArray[$key]['yesterday_converts'] = isset($getMonthToDateActualYesterdayCount[$key]['Converts']) ? $getMonthToDateActualYesterdayCount[$key]['Converts'] : 0;

            $theFInalArray[$key]['today_pitched']  = isset($getMonthToDateActualTodayCount[$key]['pitched']) ? $getMonthToDateActualTodayCount[$key]['pitched'] : 0;
            $theFInalArray[$key]['today_prospect'] = isset($getMonthToDateActualTodayCount[$key]['Prospects']) ? $getMonthToDateActualTodayCount[$key]['Prospects'] : 0;
            $theFInalArray[$key]['today_converts'] = isset($getMonthToDateActualTodayCount[$key]['Converts']) ? $getMonthToDateActualTodayCount[$key]['Converts'] : 0;
        }
     
        //        if ((!isset($_SESSION['cccon_managers']) && empty($_SESSION['cccon_managers'])) && (!isset($_SESSION['cccon_councellors']) && empty($_SESSION['cccon_councellors'])))
        //        {
        //            $theFInalArray = array();
        //        }
        //echo '<pre>'; print_r($theFInalArray);
 
        
        if (isset($_POST['export']))
        {

            $file     = "AgentDashboard_Report";
            $where    = '';
            $filename = $file . "_" . $selected_years . "_" . $selected_month;


            $StatusList = $statusHeader;

            $data .= "Counsellor Name";
            $data .= ",Total connected";
            $data .= ",Target Pitched";
            $data .= ",Actual Pitched";
            $data .= ",Target Prospects";
            $data .= ",Actual Prospects";
            $data .= ",Target Converts";
            $data .= ",Actual Converts";

            $data .= ",yesterday Pitched";
            $data .= ",yesterday Prospects";
            $data .= ",yesterday Converts";

            $data .= ",Today Pitched";
            $data .= ",Today Prospects";
            $data .= ",Today Converts";

            $data .= "\n";


            foreach ($theFInalArray as $key => $values)
            {
                $data .= "\"" . $key;
                $data .= "\",\"" . $values['total_connected_calls'];
                $data .= "\",\"" . $values['target_pitched'];
                $data .= "\",\"" . $values['actual_pitched'];
                $data .= "\",\"" . $values['target_prospect'];
                $data .= "\",\"" . $values['actual_prospect'];
                $data .= "\",\"" . $values['target_converts'];
                $data .= "\",\"" . $values['actual_converts'];

                $data .= "\",\"" . $values['yesterday_pitched'];
                $data .= "\",\"" . $values['yesterday_prospect'];
                $data .= "\",\"" . $values['yesterday_converts'];

                $data .= "\",\"" . $values['today_pitched'];
                $data .= "\",\"" . $values['today_prospect'];
                $data .= "\",\"" . $values['today_converts'];

                $data .= "\"\n";
            }

            ob_end_clean();
            header("Content-type: application/csv");
            header('Content-disposition: attachment;filename=" ' . $filename . '.csv";');
            echo $data;
            exit;
        } // End Of Export Func
        #PS @Pawan

        $total     = count($theFInalArray); #total records
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

        $theFInalArray = array_slice($theFInalArray, $start, $per_page);
        if ($total > $per_page)
        {
            $current = "(" . ($start + 1) . "-" . ($start + $per_page) . " of " . $total . ")";
        }
        else
        {
            $current = "(" . ($start + 1) . "-" . count($theFInalArray) . " of " . $total . ")";
        }
        #pE

        $sugarSmarty = new Sugar_Smarty();

        $sugarSmarty->assign("error", $error);
        $sugarSmarty->assign("theFInalArray", $theFInalArray);



        $sugarSmarty->assign("BatchListData", $BatchListData);

        $sugarSmarty->assign("StatusList", $StatusList);


        $sugarSmarty->assign("selected_batch_code", $selected_batch_code);
        $sugarSmarty->assign("selected_from_date", $selected_from_date);
        $sugarSmarty->assign("selected_to_date", $selected_to_date);
        $sugarSmarty->assign("lead_source_type", $lead_source);



        $sugarSmarty->assign("selected_status", $selected_status);

        $sugarSmarty->assign("selected_source", $selected_source);
        $sugarSmarty->assign("selected_managers", $selected_managers);
        $sugarSmarty->assign("selected_councellors", $selected_councellors);
        
        $sugarSmarty->assign("selected_month", $selected_month);
        $sugarSmarty->assign("selected_years", $selected_years);

        $sugarSmarty->assign("CouncellorsList", $CouncellorsList);
        $sugarSmarty->assign("managerSList", $managerSList);
        $sugarSmarty->assign("month", $months);
        $sugarSmarty->assign("years", $yearsList);

        $sugarSmarty->assign("current_records", $current);
        $sugarSmarty->assign("page", $page);
        $sugarSmarty->assign("pagenext", $pagenext);
        $sugarSmarty->assign("right", $right);
        $sugarSmarty->assign("left", $left);
        $sugarSmarty->assign("last_page", $last_page);
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/agentdashboardreport.tpl');
    }

}
?>

