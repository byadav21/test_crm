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
        $batchSql     = "SELECT id,name,batch_code,d_campaign_id,d_lead_id FROM te_ba_batch WHERE batch_status='enrollment_in_progress' AND deleted=0 order by name";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        while ($row          = $db->fetchByAssoc($batchObj))
        {
            $batchOptions[] = $row;
        }
        return $batchOptions;
    }

    function getConversion()
    {
        global $db;
        $leadList = array();
        $key      = '';
        if (isset($_SESSION['cccon_managers']) && !empty($_SESSION['cccon_managers']) && empty($_SESSION['cccon_councellors']))
        {
            //echo "ddd";
            $key = 'batch_code,';
        }
        $leadSql = "SELECT COUNT(leads.id) AS Convertedcount,
                                    leads.assigned_user_id user_id,
                                    MONTH(leads.converted_date) AS Converted_month,
                                    YEAR(leads.converted_date) AS Converted_Year,
                                    IF(te_ba_batch.batch_code IS NULL,'NULL',te_ba_batch.batch_code) AS batch_code,
                                    SUM(te_ba_batch.fees_inr) AS GSV,
                                    te_ba_batch.fees_inr
                             FROM leads
                             LEFT JOIN leads_cstm ON leads.id = leads_cstm.id_c
                             LEFT JOIN te_ba_batch ON leads_cstm.te_ba_batch_id_c = te_ba_batch.id
                             WHERE leads.deleted=0
                               AND leads.status='Converted'
                               AND leads.deleted=0
                               #AND YEAR(leads.converted_date)='2017'
                             GROUP BY $key user_id,
                                           Converted_month,
                                           Converted_Year ";

        $leadObj = $db->query($leadSql);



        while ($row = $db->fetchByAssoc($leadObj))
        {
            if (isset($_SESSION['cccon_managers']) && !empty($_SESSION['cccon_managers']) && empty($_SESSION['cccon_councellors']))
            {
                $leadList[$row['user_id'] . '_' . $row['Converted_month'] . '_' . $row['Converted_Year'] . '_' . $row['batch_code']]['Convertedcount'] = $row['Convertedcount'];
                $leadList[$row['user_id'] . '_' . $row['Converted_month'] . '_' . $row['Converted_Year'] . '_' . $row['batch_code']]['gsv']            = round($row['GSV'], 2);
                $leadList[$row['user_id'] . '_' . $row['Converted_month'] . '_' . $row['Converted_Year'] . '_' . $row['batch_code']]['batch_code']     = $row['batch_code'];
            }
            else
            {
                $leadList[$row['user_id'] . '_' . $row['Converted_month'] . '_' . $row['Converted_Year']]['Convertedcount'] = $row['Convertedcount'];
                $leadList[$row['user_id'] . '_' . $row['Converted_month'] . '_' . $row['Converted_Year']]['gsv']            = round($row['GSV'], 2);
                $leadList[$row['user_id'] . '_' . $row['Converted_month'] . '_' . $row['Converted_Year']]['batch_code']     = $row['batch_code'];
            }
        }

        return $leadList;
    }
    
    
    ///////New task start
    function getConnectedCalls()
    {
        global $db;
        $batchSql     = "select user,
                            count(lead_id) leadCont
                            from attempt_log 
                            where dispositionName='CONNECTED' 
                              #AND dispositionCode IN ('Fallout','Follow Up','Cross Sell','Prospect','Converted')
                            and year(reg_date)='2019' and month(reg_date)='12'
                           group by user,month(reg_date);";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        while ($row          = $db->fetchByAssoc($batchObj))
        {
            $batchOptions[$row['user']] = $row['leadCont'];
        }
        return $batchOptions;
    }
    
   function getMonthToDateActualCount($month='',$year='',$yesterday='',$today='')
    {
        global $db;
        
        $wherex='';
        
        if(empty($month)){
             $where .=" AND month(leads.date_entered)>='$month' ";
        }
        if(empty($year)){
             $wherex .=" AND year(leads.date_entered)='$year' ";
        }
        if(empty($yesterday)){
             
             $wherex .=" AND date(leads.date_entered)= '$yesterday' ";
        }
        if(empty($today)){
             $wherex .=" AND date(leads.date_entered)= '$today' ";
        }
        
        $pinchedArr   = array('Fallout', 'Follow Up', 'Cross Sell', 'Prospect', 'Converted');
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
                       AND users.user_name='pawan.kumar@talentedge.in'
                       AND leads.status_description IN ('Fallout','Follow Up','Cross Sell','Prospect','Converted')
                      $wherex
                     and month(leads.date_entered)>='1' 
                     
                     
                     GROUP BY leads.assigned_user_id,leads.status_description,month(leads.date_entered)
                     order by leads.assigned_user_id,leads.status_description,month(leads.date_entered);";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        while ($row          = $db->fetchByAssoc($batchObj))
        {
            if (in_array($row['status_description'], $pinchedArr))
            {
                $batchOptions[$row['user_name']]['pitched'] = +$row['leadCont'];
            }
            else if ($row['status_description'] == 'Prospect')
            {
                $batchOptions[$row['user_name']]['Prospects'] = +$row['leadCont'];
            }
            else if ($row['status_description'] == 'Converted')
            {

                $batchOptions[$row['user_name']]['Converts'] = $row['leadCont'];
            }
        }
        return $batchOptions;
    }
    
    function getMonthToDateTargetCount()
    {
        global $db;

        $batchSql     = "SELECT target_pitched,target_prospects,target_unit
                     FROM agent_productivity_report
                     where status=1 and deleted=0 order by created_date desc;";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        while ($row          = $db->fetchByAssoc($batchObj))
        {
            $batchOptions[$row['user_name']]['pitched']   = +$row['target_pitched'];
            $batchOptions[$row['user_name']]['Prospects'] = +$row['target_prospects'];
            $batchOptions[$row['user_name']]['Converts']  = +$row['target_unit'];
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

        $BatchListData = $this->getBatch();
        $is_manger = $this->checkManager();
        $error = array();
        
        $managerSList    = $this->getManagers();
        $CouncellorsList = $this->getCouncelor($_SESSION['cccon_managers']);
  
        

        if (isset($_POST['button']) || isset($_POST['export']))
        {
            $_SESSION['cccon_from_date']   = $_REQUEST['from_date'];
            $_SESSION['cccon_to_date']     = $_REQUEST['to_date'];
            $_SESSION['cccon_batch']       = $_REQUEST['batch'];
            $_SESSION['cccon_batch_code']  = $_REQUEST['batch_code'];
            $_SESSION['cccon_managers']    = $_REQUEST['managers'];
            $_SESSION['cccon_councellors'] = $_REQUEST['councellors'];
            $_SESSION['cccon_status']      = $_REQUEST['status'];
            $_SESSION['cccon_status']      = $_REQUEST['status'];

            $_SESSION['cccon_month'] = $_REQUEST['month'];
            $_SESSION['cccon_years'] = $_REQUEST['years'];
        }

      


        $findBatch = array();

        if (!empty($_SESSION['cccon_batch_code']))
        {
            $selected_batch_code = $_SESSION['cccon_batch_code'];
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
        if (!empty($_SESSION['cccon_month']))
        {
            $selected_month = $_SESSION['cccon_month'];
        }
        if (!empty($_SESSION['cccon_years']))
        {
            $selected_years = $_SESSION['cccon_years'];
        }

        if ($is_manger == 1)
        {
            $selected_managers = array($current_user->id);
        }

        $leadList   = array();
        $StatusList = array();


        if (!empty($selected_batch_code))
        {
            $wherecl .= " AND  batch_id IN ('" . implode("','", $selected_batch_code) . "')";
        }



        if (!empty($selected_councellors))
        {
            $wherecl .= " AND  user_id IN ('" . implode("','", $selected_councellors) . "')";
        }
        
        if (!empty($selected_month))
        {
            $wherecl .= " AND  month IN ('" . implode("','", $selected_month) . "')";
        }
        if (!empty($selected_years))
        {
            $wherecl .= " AND  year IN ('" . implode("','", $selected_years) . "')";
        }


        $months = array(1  => 'January', 2  => 'February', 3  => 'March', 4  => 'April', 5  => 'May', 6  => 'June', 7  => 'July',
            8  => 'August', 9  => 'September', 10 => 'October', 11 => 'November', 12 => 'December');

        $current_year = date('Y');
        $range        = range($current_year, $current_year - 5);
        $yearsList    = array_combine($range, $range);


        //The new code will go here..
        
         $getConnectedCalls = $this->getConnectedCalls();
         $getMonthToDateActualCount = $this->getMonthToDateActualCount();
         $getMonthToDateTargetCount = $this->getMonthToDateTargetCount();
         
         $getMonthToDateActualYesterdayCount = $this->getMonthToDateActualCount();
         $getMonthToDateActualTodayCount     = $this->getMonthToDateActualCount();
         
         
            echo '<pre>'; print_r($getMonthToDateActualCount); 
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

                $theFInalArray[$key]['yesterday_pitched']  = isset($getConnectedCalls[$key]) ? $getConnectedCalls[$key] : 0;
                $theFInalArray[$key]['yesterday_prospect'] = isset($getConnectedCalls[$key]) ? $getConnectedCalls[$key] : 0;
                $theFInalArray[$key]['yesterday_converts'] = isset($getConnectedCalls[$key]) ? $getConnectedCalls[$key] : 0;

                $theFInalArray[$key]['today_pitched']  = isset($getConnectedCalls[$key]) ? $getConnectedCalls[$key] : 0;
                $theFInalArray[$key]['today_prospect'] = isset($getConnectedCalls[$key]) ? $getConnectedCalls[$key] : 0;
                $theFInalArray[$key]['today_converts'] = isset($getConnectedCalls[$key]) ? $getConnectedCalls[$key] : 0;
            }
        echo '<pre>';
        print_r($theFInalArray);

        if ((!isset($_SESSION['cccon_managers']) && empty($_SESSION['cccon_managers'])) && (!isset($_SESSION['cccon_councellors']) && empty($_SESSION['cccon_councellors'])))
        {
            $leadList = array();
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

