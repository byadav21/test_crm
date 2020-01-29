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
                         WHERE 
                            u.deleted=0
                            #AND aru.`role_id` IN ('270ce9dd-7f7d-a7bf-f758-582aeb4f2a45')
                           
                           $conditons
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
        //echo '$month=='.$month;
        if (!empty($month))
        {
            $wherex .= " and month(al.reg_date)='$month' ";
        }
        if (!empty($year))
        {
            $wherex .= " and year(al.reg_date)='$year' ";
        }

        //#AND dispositionCode IN ('Fallout','Follow Up','Cross Sell','Prospect','Converted')

        $batchSql     = "select 
                            al.user,
                            concat(IFNULL(users.first_name,''),' ',IFNULL(users.last_name,'')) as Agent_Name,
                            count(al.lead_id) leadCont
                            from attempt_log al
                            LEFT JOIN users ON al.user =users.user_name
                            where users.deleted=0
                            AND users.status='Active'
                            AND users.department='CC'
                            AND al.dispositionName='CONNECTED' 
                            #and al.user='abhishek.singh@talentedge.in'
                            $wherex
                           group by al.user,month(al.reg_date);";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        while ($row          = $db->fetchByAssoc($batchObj))
        {
            $batchOptions[$row['user']]['leadCont'] = $row['leadCont'];
            $batchOptions[$row['user']]['Agent_Name'] = $row['Agent_Name'];
        }
        return $batchOptions;
    }

    
    function getMonthToDateActualCountXX($year = '', $month = '', $yesterday = '', $today = '',$selected_councellors=array(),$current_userAccess=array(),$CouncellorsList=array())
    {
        global $db,$current_user;

        $wherex = '';
        $userSlug = "";
        
        
        //echo '$year='.$year.'$month='.$month.'$yesterday='.$yesterday.'$yesterday='.$yesterday;
        
        
        //echo 'dd=='.$current_userAccess['slug'];
        if (!empty($month))
        {
            $wherex .= " AND month(leads.date_modified)>= '$month' ";
        }
        if (!empty($year))
        {
            $wherex .= " AND year(leads.date_modified)='$year' ";
        }
        if (!empty($yesterday))
        {

            $wherex .= " AND date(leads.date_modified)= '$yesterday' ";
        }
        if (!empty($today))
        {
            $wherex .= " AND date(leads.date_modified)= '$today' ";
        }
        
        if (!empty($selected_councellors) && $userSlug!='CCC')
        {
            $wherex .= " AND  leads.assigned_user_id IN ('" . implode("','", $selected_councellors) . "')";
        }
        if(!empty($current_userAccess['slug']) && $current_userAccess['slug']=='CCC'){
             //echo 'xxx'.
             $wherex .= " AND  leads.assigned_user_id ='$current_user->id'";
        }
        //print_r($CouncellorsList);
        if(!empty($current_userAccess['slug']) && $current_userAccess['slug']=='CCM' && empty($selected_councellors)){
             //echo 'xxx'.
             $managersAgent = array();
             foreach ($CouncellorsList as $key=>$val){
                 $managersAgent[]= $key;
             }
              //print_r($managersAgent);
              $wherex .= " AND  leads.assigned_user_id IN ('" . implode("','", $managersAgent) . "')";
        }
       

        $pinchedArr = array('Fallout', 'Follow Up', 'Cross Sell', 'Prospect', 'Converted');

        //echo '<pre>'.
        $batchSql     = "SELECT 
                            users.user_name,
                            concat(IFNULL(users.first_name,''),' ',IFNULL(users.last_name,'')) as Agent_Name,
                            leads.status_description,
                                month(leads.date_modified) monthwise,
                                year(leads.date_modified) yearwise,
                            count(leads.id) leadCont
                     FROM leads
                     INNER JOIN attempt_log on leads.id=attempt_log.lead_id
                     INNER JOIN users ON leads.assigned_user_id =users.id
                     INNER JOIN leads_cstm ON leads.id= leads_cstm.id_c
                     WHERE leads.deleted=0
                       and leads.assigned_user_id!=''
                       AND users.deleted=0
                       AND users.status='Active'
		       AND users.department='CC'
                       AND leads.status_description IN ('Fallout','Follow Up','Cross Sell','Prospect')
                      $wherex
                     GROUP BY leads.assigned_user_id,leads.status_description,month(leads.date_modified)
                     order by leads.assigned_user_id,leads.status_description,month(leads.date_modified);";
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
            if ($row['status_description'] == 'Follow Up')
            {

            $batchOptions[$row['user_name']]['follow_up'] += $row['leadCont'];
            }
            
            $batchOptions[$row['user_name']]['Agent_Name'] = $row['Agent_Name'];
        }
        return $batchOptions;
    }
    
    function getMonthToDateActualCount($year = '', $month = '', $yesterday = '', $today = '',$selected_councellors=array(),$current_userAccess=array(),$CouncellorsList=array())
    {
        global $db,$current_user;

        $wherex = '';
        $userSlug = "";
        
        
        //echo '$year='.$year.'$month='.$month.'$yesterday='.$yesterday.'$yesterday='.$yesterday.'<br>';
        
        
        //echo 'dd=='.$current_userAccess['slug'];
        if (!empty($month))
        {
            $wherex .= " AND month(al.reg_date)= '$month' ";
        }
        if (!empty($year))
        {
            $wherex .= " AND year(al.reg_date)='$year' ";
        }
        if (!empty($yesterday))
        {

            $wherex .= " AND date(al.reg_date)= '$yesterday' ";
        }
        if (!empty($today))
        {
            $wherex .= " AND date(al.reg_date)= '$today' ";
        }
        
        if (!empty($selected_councellors) && $userSlug!='CCC')
        {
            $wherex .= " AND  users.id IN ('" . implode("','", $selected_councellors) . "')";
        }
        if(!empty($current_userAccess['slug']) && $current_userAccess['slug']=='CCC'){
             //echo 'xxx'.
             $wherex .= " AND  users.id ='$current_user->id'";
        }
        //print_r($CouncellorsList);
        if(!empty($current_userAccess['slug']) && $current_userAccess['slug']=='CCM' && empty($selected_councellors)){
             //echo 'xxx'.
             $managersAgent = array();
             foreach ($CouncellorsList as $key=>$val){
                 $managersAgent[]= $key;
             }
              //print_r($managersAgent);
              $wherex .= " AND  users.id IN ('" . implode("','", $managersAgent) . "')";
        }
       

        $pinchedArr = array('Fallout', 'Follow Up', 'Cross Sell', 'Prospect');

        //echo '<pre>'.
        $batchSql     = "SELECT 
                        users.user_name,
                        concat(IFNULL(users.first_name,''),' ',IFNULL(users.last_name,'')) as Agent_Name,
                           al.subDisposeCode status_description,
                            month(al.reg_date) monthwise,
                            year(al.reg_date) yearwise,
                        count(al.lead_id) leadCont
                    FROM attempt_log al

                    LEFT JOIN users ON al.user =users.user_name
                    WHERE 
                     users.deleted=0
                    AND users.status='Active'
                    AND users.department='CC'
                    AND al.dispositionName='CONNECTED' 
                    #and al.user='abhishek.singh@talentedge.in'
                    AND al.subDisposeCode IN ('Fallout','Follow Up','Cross Sell','Prospect')
                    $wherex
                    GROUP BY al.user,al.subDisposeCode,month(al.reg_date)
                    order by al.user,al.subDisposeCode,month(al.reg_date);"; 
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
            if ($row['status_description'] == 'Follow Up')
            {

            $batchOptions[$row['user_name']]['follow_up'] += $row['leadCont'];
            }
            
            $batchOptions[$row['user_name']]['Agent_Name'] = $row['Agent_Name'];
        }
        return $batchOptions;
    }
    
    
    
    function getMonthToDateActualConverts($year = '', $month = '', $yesterday = '', $today = '',$selected_councellors=array(),$current_userAccess=array(),$CouncellorsList=array())
    {
        global $db,$current_user;

        $wherex = '';
        $userSlug = "";
        
        
        //echo '$year='.$year.'$month='.$month.'$yesterday='.$yesterday.'$yesterday='.$yesterday;
        
        
        //echo 'dd=='.$current_userAccess['slug'];
        if (!empty($month))
        {
            $wherex .= " AND month(leads.converted_date)>= '$month' ";
        }
        if (!empty($year))
        {
            $wherex .= " AND year(leads.converted_date)='$year' ";
        }
        if (!empty($yesterday))
        {

            $wherex .= " AND leads.converted_date= '$yesterday' ";
        }
        if (!empty($today))
        {
            $wherex .= " AND leads.converted_date= '$today' ";
        }
        
        if (!empty($selected_councellors) && $userSlug!='CCC')
        {
            $wherex .= " AND  leads.assigned_user_id IN ('" . implode("','", $selected_councellors) . "')";
        }
        if(!empty($current_userAccess['slug']) && $current_userAccess['slug']=='CCC'){
             //echo 'xxx'.
             $wherex .= " AND  leads.assigned_user_id ='$current_user->id'";
        }
        //print_r($CouncellorsList);
        if(!empty($current_userAccess['slug']) && $current_userAccess['slug']=='CCM' && empty($selected_councellors)){
             //echo 'xxx'.
             $managersAgent = array();
             foreach ($CouncellorsList as $key=>$val){
                 $managersAgent[]= $key;
             }
              //print_r($managersAgent);
              $wherex .= " AND  leads.assigned_user_id IN ('" . implode("','", $managersAgent) . "')";
        }
       

        $pinchedArr = array('Converted');

        //echo '<pre>'.
        $batchSql     = "SELECT 
                            users.user_name,
                            leads.status_description,
                                month(leads.date_modified) monthwise,
                                year(leads.date_modified) yearwise,
                            count(leads.id) leadCont
                     FROM leads
                     INNER JOIN users ON leads.assigned_user_id =users.id
                     INNER JOIN leads_cstm ON leads.id= leads_cstm.id_c
                     WHERE leads.deleted=0
                       and leads.assigned_user_id!=''
                       AND users.deleted=0
                       AND users.status='Active'
		       AND users.department='CC'
                       AND leads.status_description IN ('Converted')
                      $wherex
                     GROUP BY leads.assigned_user_id,leads.status_description,month(leads.date_modified)
                     order by leads.assigned_user_id,leads.status_description,month(leads.date_modified);";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        $pitchedCount = 0;
        while ($row          = $db->fetchByAssoc($batchObj))
        {


            
            if ($row['status_description'] == 'Converted')
            {

            $batchOptions[$row['user_name']]['Converted'] += $row['leadCont'];
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
            $wherex .= " AND apr.month >= '$month' ";
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
        $current_userAccess = "";
        $userSlug = "";
        $getUsersRole = getUsersRole();
        
        $current_userAccess = isset($getUsersRole[$current_user->id]) ? $getUsersRole[$current_user->id] : array();
        $userSlug = $current_userAccess['slug'];
        
       
        //$BatchListData = $this->getBatch();
        $is_manger     = $this->checkManager();
        $error         = array();

        $managerSList    = $this->getManagers();
       
        if($userSlug=='CCM'){
          $CouncellorsList = $this->getCouncelor($current_user->id);  
        }
        else{
            $CouncellorsList = $this->getCouncelor($_SESSION['cccon_managers']);  
        }
        



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
               $selected_month  = date('m');
        }
        if (!empty($_SESSION['cccon_years']))
        {
            $selected_years = $_SESSION['cccon_years'];
        }
        else
        {
            $selected_years   = date('Y');
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
        //echo $selected_month.'mm';
        //The new code will go here..
        //echo '$selected_month='.$selected_month.'$selected_years='.$selected_years;
        //## All Connected
        $getConnectedCalls = $this->getConnectedCalls($selected_month, $selected_years);
        
        //## Actual Month wise leads // ($year = '', $month = '', $yesterday = '', $today = '',$selected_councellors=array(),$current_userAccess=array())
        $getMonthToDateActualCount = $this->getMonthToDateActualCount($selected_years, $selected_month, '','',$selected_councellors,$current_userAccess,$CouncellorsList);
        $getMonthToDateActualConverts = $this->getMonthToDateActualConverts($selected_years, $selected_month, '','',$selected_councellors,$current_userAccess,$CouncellorsList);

        //## Target month wise leads
        $getMonthToDateTargetCount = $this->getMonthToDateTargetCount($selected_years, $selected_month, '','');

        //### Yeastday real counts leads
        $getMonthToDateActualYesterdayCount = $this->getMonthToDateActualCount( '', '', date('Y-m-d', strtotime("-1 days")),'','',$current_userAccess,'');
        //#### Today Real counts of leads
        $getMonthToDateActualTodayCount     = $this->getMonthToDateActualCount('','','', date('Y-m-d'),'',$current_userAccess,'');


        //echo '<pre>'; print_r($getMonthToDateActualCount);  die;
        $theFInalArray = array();
        foreach ($getConnectedCalls as $key => $val)
        {
            $theFInalArray[$key]['total_connected_calls'] = isset($val['leadCont']) ? $val['leadCont'] : 0;
            $theFInalArray[$key]['Agent_Name'] = isset($val['Agent_Name']) ? $val['Agent_Name'] : 0;

            $theFInalArray[$key]['target_pitched'] = isset($getMonthToDateTargetCount[$key]['pitched']) ? $getMonthToDateTargetCount[$key]['pitched'] : 0;
            $theFInalArray[$key]['actual_pitched'] = isset($getMonthToDateActualCount[$key]['pitched']) ? $getMonthToDateActualCount[$key]['pitched'] : 0;

            $theFInalArray[$key]['target_prospect'] = isset($getMonthToDateTargetCount[$key]['Prospects']) ? $getMonthToDateTargetCount[$key]['Prospects'] : 0;
            $theFInalArray[$key]['actual_prospect'] = isset($getMonthToDateActualCount[$key]['Prospects']) ? $getMonthToDateActualCount[$key]['Prospects'] : 0;

            $theFInalArray[$key]['target_converts'] = isset($getMonthToDateTargetCount[$key]['Converts']) ? $getMonthToDateTargetCount[$key]['Converts'] : 0;
            $theFInalArray[$key]['actual_converts'] = isset($getMonthToDateActualCount[$key]['Converts']) ? $getMonthToDateActualCount[$key]['Converts'] : 0;
            
            $theFInalArray[$key]['target_follow_up'] = isset($getMonthToDateTargetCount[$key]['follow_up']) ? $getMonthToDateTargetCount[$key]['follow_up'] : 0;
            $theFInalArray[$key]['actual_follow_up'] = isset($getMonthToDateActualCount[$key]['follow_up']) ? $getMonthToDateActualCount[$key]['follow_up'] : 0;
            
            $theFInalArray[$key]['yesterday_pitched']  = isset($getMonthToDateActualYesterdayCount[$key]['pitched']) ? $getMonthToDateActualYesterdayCount[$key]['pitched'] : 0;
            $theFInalArray[$key]['yesterday_prospect'] = isset($getMonthToDateActualYesterdayCount[$key]['Prospects']) ? $getMonthToDateActualYesterdayCount[$key]['Prospects'] : 0;
            $theFInalArray[$key]['yesterday_converts'] = isset($getMonthToDateActualConverts[$key]['Converts']) ? $getMonthToDateActualConverts[$key]['Converts'] : 0;
            $theFInalArray[$key]['yesterday_follow_up'] = isset($getMonthToDateActualYesterdayCount[$key]['follow_up']) ? $getMonthToDateActualYesterdayCount[$key]['follow_up'] : 0;

            $theFInalArray[$key]['today_pitched']  = isset($getMonthToDateActualTodayCount[$key]['pitched']) ? $getMonthToDateActualTodayCount[$key]['pitched'] : 0;
            $theFInalArray[$key]['today_prospect'] = isset($getMonthToDateActualTodayCount[$key]['Prospects']) ? $getMonthToDateActualTodayCount[$key]['Prospects'] : 0;
            $theFInalArray[$key]['today_converts'] = isset($getMonthToDateActualConverts[$key]['Converts']) ? $getMonthToDateActualConverts[$key]['Converts'] : 0;
            $theFInalArray[$key]['today_follow_up'] = isset($getMonthToDateActualTodayCount[$key]['follow_up']) ? $getMonthToDateActualTodayCount[$key]['follow_up'] : 0;
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

            $data .= "Counsellor Email";
            $data .= ",Counsellor Name";
            $data .= ",Total connected";
            $data .= ",Target Pitched";
            $data .= ",Actual Pitched";
            $data .= ",Target Prospects";
            $data .= ",Actual Prospects";
            $data .= ",Target Converts";
            $data .= ",Actual Converts";
            $data .= ",Target Follow Up";
            $data .= ",Actual Follow Up";

            $data .= ",yesterday Pitched";
            $data .= ",yesterday Prospects";
            $data .= ",yesterday Converts";
            $data .= ",yesterday Follow Up";

            $data .= ",Today Pitched";
            $data .= ",Today Prospects";
            $data .= ",Today Converts";
            $data .= ",Today Follow Up";

            $data .= "\n";


            foreach ($theFInalArray as $key => $values)
            {
                $data .= "\"" . $key;
                $data .= "\",\"" .  $values['Agent_Name'];
                $data .= "\",\"" . $values['total_connected_calls'];
                $data .= "\",\"" . $values['target_pitched'];
                $data .= "\",\"" . $values['actual_pitched'];
                $data .= "\",\"" . $values['target_prospect'];
                $data .= "\",\"" . $values['actual_prospect'];
                $data .= "\",\"" . $values['target_converts'];
                $data .= "\",\"" . $values['actual_converts'];
                $data .= "\",\"" . $values['target_follow_up'];
                $data .= "\",\"" . $values['actual_follow_up'];

                $data .= "\",\"" . $values['yesterday_pitched'];
                $data .= "\",\"" . $values['yesterday_prospect'];
                $data .= "\",\"" . $values['yesterday_converts'];
                $data .= "\",\"" . $values['yesterday_follow_up'];

                $data .= "\",\"" . $values['today_pitched'];
                $data .= "\",\"" . $values['today_prospect'];
                $data .= "\",\"" . $values['today_converts'];
                $data .= "\",\"" . $values['today_follow_up'];

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
        $sugarSmarty->assign("userSlug", $userSlug);
        
        


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

