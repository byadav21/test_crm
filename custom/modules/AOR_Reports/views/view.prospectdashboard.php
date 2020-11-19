<?php

// Date: Created on : 27th FEB 2018

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');

//error_reporting(-1);
//ini_set('display_errors', 'On');

class AOR_ReportsViewprospectdashboard extends SugarView
{

    var $report_to_id;
    var $counsellors_arr;

    public function __construct()
    {
        $accRoles = array("SCH", "SCHMGR", "SCHTL", "SCHAGENT", "CH", "CHMGR", "CHTL", "CHAGENT");
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
        if ($is_manger == 1 && ($current_user->id != "1a5ea8c8-0d37-9447-eed7-5ed50f9cfd3f") && ($current_user->id != "ee49a56d-ad54-5c35-a295-5f5b4ebf2b6f") )// Used Hard code current_user id rohit lall & Prashant Shrivastava
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
                            AND u.department='CC'
                           AND u.employee_status='Active' ";
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
    function getConnectedCalls($year = '', $month = '', $yesterday = '', $today = '',$selected_councellors=array(),$current_userAccess=array(),$CouncellorsList=array())
    {
        global $db,$current_user;
        $accRoles1 = array("SCH", "SCHMGR", "SCHTL", "CH", "CHMGR", "CHTL","CCM");
        $wherex = '';
        $userSlug = "";
        $accRolesUsers = array("SCHAGENT", "CHAGENT","CCC");
        // echo 'dd=='.$current_userAccess['slug'];
   
        if(!empty($selected_councellors) && in_array($current_userAccess['slug'], $accRoles1) )
        // if (!empty($selected_councellors) && $userSlug!='CCC' || (!empty($selected_councellors) && ! in_array($userSlug, $accRoles)))
        {
            $wherex .= " AND  users.id IN ('" . implode("','", $selected_councellors) . "')";
        }
        if ( (!empty($current_userAccess['slug']) && in_array($current_userAccess['slug'], $accRolesUsers) ))
        // if ( (!empty($current_userAccess['slug']) && $current_userAccess['slug'] == 'CCC') || (!empty($current_userAccess['slug']) && in_array($current_userAccess['slug'], $accRoles) ) )
        {
            $wherex .= " AND  users.id ='$current_user->id'";
        }
        //print_r($CouncellorsList);
        if ( (!empty($current_userAccess['slug']) && $current_userAccess['slug'] == 'CCM' && empty($selected_councellors)) || (!empty($current_userAccess['slug']) && in_array($current_userAccess['slug'], $accRoles) && empty($selected_councellors))){ 
             //echo 'xxx'.
             $managersAgent = array();
             foreach ($CouncellorsList as $key=>$val){
                 $managersAgent[]= $key;
             }
              //print_r($managersAgent);
              $wherex .= " AND  users.id IN ('" . implode("','", $managersAgent) . "')";
        }
       

        //#AND dispositionCode IN ('Fallout','Follow Up','Cross Sell','Prospect','Converted')

        $batchSql     = "select 
                            users.id user_id,
                            users.user_name user,
                            concat(IFNULL(users.first_name,''),' ',IFNULL(users.last_name,'')) as Agent_Name
                           
                            from users 
                            where users.deleted=0
                            AND users.status='Active'
                            AND users.department='CC'
                          
                            $wherex ;";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        while ($row          = $db->fetchByAssoc($batchObj))
        {
            
            $batchOptions[$row['user']]['Agent_Name'] = $row['Agent_Name'];
            $batchOptions[$row['user']]['user_id']   = $row['user_id'];
        }
        return $batchOptions;
    }
    
    
    function getMonthToDateActualConverts($year = '', $month = '', $yesterday = '', $today = '',$selected_councellors=array(),$current_userAccess=array(),$CouncellorsList=array())
    {
        global $db,$current_user;

        $wherex = '';
        $userSlug = "";
        $accRoles1 = array("SCH", "SCHMGR", "SCHTL", "CH", "CHMGR", "CHTL","CCM");
        $accRolesUsers = array("SCHAGENT", "CHAGENT","CCC");        
        
        //echo '$year='.$year.'$month='.$month.'$yesterday='.$yesterday.'$yesterday='.$yesterday;
        
        
        //echo 'dd=='.$current_userAccess['slug'];
        if (!empty($month))
        {
            $wherex .= " AND month(leads.converted_date) = '$month' ";
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
        
        // if (!empty($selected_councellors) && $userSlug!='CCC')
        if(!empty($selected_councellors) && in_array($current_userAccess['slug'], $accRoles1) )
        {
            $wherex .= " AND  leads.assigned_user_id IN ('" . implode("','", $selected_councellors) . "')";
        }
        // if ((!empty($current_userAccess['slug']) && $current_userAccess['slug'] == 'CCC') || (!empty($current_userAccess['slug']) && in_array($current_userAccess['slug'], $accRoles) ) )
        if ( (!empty($current_userAccess['slug']) && in_array($current_userAccess['slug'], $accRolesUsers) ))
        {
             //echo 'xxx'.
             $wherex .= " AND  leads.assigned_user_id ='$current_user->id'";
        }
        //print_r($CouncellorsList);
        if ( (!empty($current_userAccess['slug']) && $current_userAccess['slug'] == 'CCM' && empty($selected_councellors)) || (!empty($current_userAccess['slug']) && in_array($current_userAccess['slug'], $accRoles) && empty($selected_councellors)) )
        {
             //echo 'xxx'.
             $managersAgent = array();
             foreach ($CouncellorsList as $key=>$val){
                 $managersAgent[]= $key;
             }
              //print_r($managersAgent);
              $wherex .= " AND  leads.assigned_user_id IN ('" . implode("','", $managersAgent) . "')";
        }
       

        //$pinchedArr = array('Converted');

        //echo '<pre>'.
        $batchSql     = "SELECT 
                            users.user_name,
                            leads.status_description,
                                month(leads.converted_date) monthwise,
                                year(leads.converted_date) yearwise,
                            count(leads.id) leadCont
                     FROM leads
                     INNER JOIN users ON leads.assigned_user_id =users.id
                     INNER JOIN leads_cstm ON leads.id= leads_cstm.id_c
                     WHERE leads.deleted=0
                       and leads.assigned_user_id!=''
                       AND users.deleted=0
                       AND users.status='Active'
		       AND users.department='CC'
                       AND leads.status ='Converted'
                      $wherex
                     GROUP BY leads.assigned_user_id,leads.status_description,month(leads.converted_date)
                     order by leads.assigned_user_id,leads.status_description,month(leads.converted_date);";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        $pitchedCount = 0;
        while ($row          = $db->fetchByAssoc($batchObj))
        {  

            $batchOptions[$row['user_name']]['Converts'] += $row['leadCont'];
           
        }
        return $batchOptions;
    }

    function getMonthToDateTargetCount($year = '', $month = '', $yesterday = '', $today = '')
    {
        global $db;

        $wherex = '';

        if (!empty($month))
        {
            $wherex .= " AND apr.month = '$month' ";
        }
        if (!empty($year))
        {
            $wherex .= " AND apr.year = '$year' ";
        }

        $batchSql     = "SELECT users.user_name,apr.target_pitched,apr.target_prospects,apr.target_unit,apr.target_gsv
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
            $batchOptions[$row['user_name']]['target_gsv']  += $row['target_gsv'];
        }
        return $batchOptions;
    }
    
    
    function getMonthToDateActualRevenue($year = '', $month = '', $yesterday = '', $today = '',$selected_councellors=array(),$current_userAccess=array(),$CouncellorsList=array())
    {
        global $db,$current_user;

        $wherex = '';
        $userSlug = "";
        $accRoles1 = array("SCH", "SCHMGR", "SCHTL", "CH", "CHMGR", "CHTL","CCM");
        $accRolesUsers = array("SCHAGENT", "CHAGENT","CCC");
        
        //echo '$year='.$year.'$month='.$month.'$yesterday='.$yesterday.'$yesterday='.$yesterday;
        
        
        //echo 'dd=='.$current_userAccess['slug'];
        if (!empty($month))
        {
            $wherex .= " AND month(leads.converted_date) = '$month' ";
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
        
        // if (!empty($selected_councellors) && $userSlug!='CCC')
        if(!empty($selected_councellors) && in_array($current_userAccess['slug'], $accRoles1) )
        {
            $wherex .= " AND  leads.assigned_user_id IN ('" . implode("','", $selected_councellors) . "')";
        }
        
        // if ( (!empty($current_userAccess['slug']) && $current_userAccess['slug'] == 'CCC') || (!empty($current_userAccess['slug']) && in_array($current_userAccess['slug'], $accRoles)) )
        if ( (!empty($current_userAccess['slug']) && in_array($current_userAccess['slug'], $accRolesUsers) ))
        {
             //echo 'xxx'.
             $wherex .= " AND  leads.assigned_user_id ='$current_user->id'";
        }
        //print_r($CouncellorsList);
        
        if ( (!empty($current_userAccess['slug']) && $current_userAccess['slug'] == 'CCM' && empty($selected_councellors)) || (!empty($current_userAccess['slug']) && in_array($current_userAccess['slug'], $accRoles) && empty($selected_councellors)) )
        {
             //echo 'xxx'.
             $managersAgent = array();
             foreach ($CouncellorsList as $key=>$val){
                 $managersAgent[]= $key;
             }
              //print_r($managersAgent);
              $wherex .= " AND  leads.assigned_user_id IN ('" . implode("','", $managersAgent) . "')";
        }
       

        //$pinchedArr = array('Converted');

        //echo '<pre>'.
        $batchSql     = "SELECT 
                        users.user_name,
                        SUM( te_ba_batch.fees_inr ) AS revenue,
                            month(leads.converted_date) monthwise,
                            year(leads.converted_date) yearwise
                            
                     FROM leads
                     INNER JOIN users ON leads.assigned_user_id =users.id
                     INNER JOIN leads_cstm ON leads.id= leads_cstm.id_c
                     INNER JOIN te_ba_batch ON leads_cstm.te_ba_batch_id_c = te_ba_batch.id
                     WHERE leads.deleted=0
                       and leads.assigned_user_id!=''
                       AND users.deleted=0
                       AND users.status='Active'
		       AND users.department='CC'
                       AND leads.status ='Converted'
                      $wherex
                     GROUP BY leads.assigned_user_id
                     order by leads.assigned_user_id";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        $pitchedCount = 0;
        while ($row          = $db->fetchByAssoc($batchObj))
        {  

            $batchOptions[$row['user_name']]['revenue'] += $row['revenue'];
           
        }
        return $batchOptions;
    }

    ///////New task end
     function getCouncelorForUsersNew($user_ids = array(),$current_user_id)
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
                                    '", $user_ids) . "') and ru.id = '$current_user_id'
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
    
    function getCouncelorForUsersSRM()
    {
        $channelHeadArray = array("CH","SCH","DMH","SRMH","QA","TR","VR");
        global $db;
        $proSql      = "SELECT
            u.first_name,
            u.last_name,
            u.id,
            slug,
            user_id,
            NAME role_name
            FROM
            acl_roles
            INNER JOIN
            acl_roles_users
            ON
            acl_roles_users.role_id = acl_roles.id
            INNER JOIN
            users u
            ON
            u.id = acl_roles_users.user_id AND acl_roles.deleted = 0 AND acl_roles_users.deleted = 0 where slug IN ('" . implode("',
                                    '", $channelHeadArray) . "')";
        $userObj  = $db->query($proSql);
        $usersArr = [];
        while ($user     = $db->fetchByAssoc($userObj))
        {
            $usersArr[$user['id']] = array(
                'id'             => $user['id'],
                'name'           => $user['first_name'] . ' ' . $user['last_name'],
            );
        }
        return $usersArr;
    }

    public function display()
    {

        global $sugar_config, $app_list_strings, $current_user, $db;

	//die('Report is under maintenance!');
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
       
        // if($userSlug=='CCM'){
        //   $CouncellorsList = $this->getCouncelor($current_user->id);  
        // }
        // else{
        //     $CouncellorsList = $this->getCouncelor($_SESSION['cccon_managers']);  
        // }
        
        $CouncellorsList = $this->getCouncelor($current_user->id);

        $isAdmin = $current_user->is_admin;
        $getRoleSlug = getUsersRole();
        //$chUserIds = $chUserIdsDataSRM;
        $businessHeadArray = array("BH","SM");
        $channelHeadArray = array("CH","SCH","DMH","SRMH","QA","TR","VR");
        $managerArray = array("CHMGR","SCHMGR","DMHMGR","SRMHMGR","QAMGR","TRMGR","VRMGR");
        $teamLeadArray = array("CHTL","SCHTL","DMHTL","SRMHTL","QATL","TRTL","VRTL");
        $agentArray = array("CHAGENT","SCHAGENT","DMHAGENT","SRMHAGENT","QAAGENT","TRAGENT","VRAGENT");
        $usersRole   = '';
        $currentRoleName   = !empty($getRoleSlug[$current_user->id]['slug']) ? $getRoleSlug[$current_user->id]['slug'] : '7e225ca3-69fa-a75d-f3f2-581d88cafd9a';
        $chUserIds = array();
        $mgUserIds = array();
        $tlUserIds = array();
        $agentUserIds = array();
        if($isAdmin == 1 || in_array ($currentRoleName, $businessHeadArray)){
            $chUserIds = array();
            foreach ($getRoleSlug as $userIds){
               if(in_array($userIds['slug'] , $channelHeadArray) && $isAdmin != 1){
                  $chUserIdsData[$userIds['user_id']] = $userIds['user_id'];
                  $chUserIdsss = $this->getCouncelorForUsersNew($chUserIdsData,$current_user->id);
               }
               else if ($isAdmin == 1){
                   $chUserIdsData[$userIds['user_id']] = $userIds['user_id'];
                   $chUserIdsDataSRM = $this->getCouncelorForUsersSRM($chUserIdsData,$current_user->id);
                   $chUserIds = $chUserIdsDataSRM;
               }
            }
        }
        
       if(in_array($currentRoleName, $channelHeadArray)){
            foreach ($getRoleSlug as $userIds){
                if(in_array($userIds['slug'], $managerArray)){
                  $mgUserIdsData[$userIds['user_id']] = $userIds['user_id'];
                  $mgUserIds = $this->getCouncelorForUsersNew($mgUserIdsData,$current_user->id);
               }
            }
        }
        if(in_array($currentRoleName, $managerArray)){
            foreach ($getRoleSlug as $userIds){
               if(in_array($userIds['slug'], $teamLeadArray)){
                  $tlUserIdsData[$userIds['user_id']] = $userIds['user_id'];
                  $tlUserIds = $this->getCouncelorForUsersNew($tlUserIdsData,$current_user->id);
               }
            }
        }
        
         if(in_array($currentRoleName, $teamLeadArray)){
            foreach ($getRoleSlug as $userIds){
               if(in_array($userIds['slug'],$agentArray)){
                  $agentUserIdsData[$userIds['user_id']] = $userIds['user_id'];
                  $agentUserIds = $this->getCouncelorForUsersNew($agentUserIdsData,$current_user->id);
               }
            }
        }


        if (isset($_POST['button']) || isset($_POST['export']))
        {
            $_SESSION['cccon_from_date']   = $_REQUEST['from_date'];
            //$_SESSION['cccon_to_date']     = $_REQUEST['to_date'];
            //$_SESSION['cccon_batch']       = $_REQUEST['batch'];
            //$_SESSION['cccon_batch_code']  = $_REQUEST['batch_code'];
            $_SESSION['cccon_managers']    = $_REQUEST['managers'];//Not use in this code
            $_SESSION['cccon_councellors'] = $_REQUEST['agentRole'];
//            $_SESSION['cccon_councellors'] = $_REQUEST['councellors'];
            //$_SESSION['cccon_status']      = $_REQUEST['status'];
           
            $_SESSION['cccon_month'] = $_REQUEST['month'];
            $_SESSION['cccon_years'] = $_REQUEST['years'];
        }




        $findBatch = array();

       
        if (!empty($_SESSION['cccon_councellors']))
        {
            $selected_councellors = $_SESSION['cccon_councellors'];
        }else{
            $selected_councellors = $current_user->id;
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
       

        
       

      

//        $months = array(1  => 'January', 2  => 'February', 3  => 'March', 4  => 'April', 5  => 'May', 6  => 'June', 7  => 'July',
//            8  => 'August', 9  => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
//
//        $current_year = date('Y');
//        $range        = range($current_year, $current_year - 1);
//        $yearsList    = array_combine($range, $range);
//
//        $todayDate  = date('Y-m-d');
//        $yesterDate = date('Y-m-d', strtotime("-1 days"));
//        
//        if (empty($selected_month))
//        {
//             $selected_month = date('m');
//        }
//        if (empty($selected_years))
//        {
//             $selected_years = date('Y');
//        }
        
         if (!empty($_SESSION['cccon_from_date']))
        {
            $selected_date = $_SESSION['cccon_from_date'];
        }
        else
        {   
            $selected_date = date('Y-m-d', strtotime("-1 days"));
        }
        
        $selected_years = date('Y', strtotime($selected_date));

        $selected_month = date('m', strtotime($selected_date));

        //echo $selected_month.'mm';
        //The new code will go here..
        //echo '$selected_month='.$selected_month.'$selected_years='.$selected_years;
        
        //## All USER List
        $getConnectedCalls = $this->getConnectedCalls($selected_years, $selected_month, '','',$selected_councellors,$current_userAccess,$CouncellorsList);
       
        # Month wise Report to be poplated 
        
        $getMonthToDateActualConverts   = $this->getMonthToDateActualConverts($selected_years, $selected_month, '','',$selected_councellors,$current_userAccess,$CouncellorsList);
        $getMonthToDateActualRevenue    = $this->getMonthToDateActualRevenue($selected_years, $selected_month, '','',$selected_councellors,$current_userAccess,$CouncellorsList);
        $getMonthToDateTargetCount      = $this->getMonthToDateTargetCount($selected_years, $selected_month, '','');

  
        
        
         
         $getDayWsieConvertsCount       = $this->getMonthToDateActualConverts('','','', $selected_date,'',$current_userAccess,'');
         $getDayWsieRevenue             = $this->getMonthToDateActualRevenue('','','', $selected_date,'',$current_userAccess,'');
         

        //echo '<pre>'; print_r($getDayWsieConvertsCount);  die;
        $theFInalArray = array();
        foreach ($getConnectedCalls as $key => $val)
        {
            
            $theFInalArray[$key]['Agent_Name'] = isset($val['Agent_Name']) ? $val['Agent_Name'] : 0;
            $theFInalArray[$key]['Agent_ID'] = isset($val['user_id']) ? $val['user_id'] : 0;
            
            
            
            
            $monthly_target_converts = isset($getMonthToDateTargetCount[$key]['Converts']) ? $getMonthToDateTargetCount[$key]['Converts'] : 0;
            $monthly_actual_converts = isset($getMonthToDateActualConverts[$key]['Converts']) ? $getMonthToDateActualConverts[$key]['Converts'] : 0;
            $monthly_gsv             = isset($getMonthToDateActualRevenue[$key]['revenue']) ? $getMonthToDateActualRevenue[$key]['revenue'] : 0;
            $monthly_target_gsv      = isset($getMonthToDateTargetCount[$key]['target_gsv']) ? $getMonthToDateTargetCount[$key]['target_gsv'] : 0;
            
            
            $daywise_target_converts = isset($getMonthToDateTargetCount[$key]['Converts']) ? ($getMonthToDateTargetCount[$key]['Converts'] / 25) : 0;
            $daywise_actual_converts = isset($getDayWsieConvertsCount[$key]['Converts']) ? $getDayWsieConvertsCount[$key]['Converts'] : 0;
            $daywise_gsv             = isset($getDayWsieRevenue[$key]['revenue']) ? $getDayWsieRevenue[$key]['revenue'] : 0;
            $daywise_target_gsv      = isset($getMonthToDateTargetCount[$key]['target_gsv']) ? ($getMonthToDateTargetCount[$key]['target_gsv']/25) : 0;
            
            //revenue  // revenue tooltip
            if (($monthly_gsv < $monthly_target_gsv) && ($monthly_gsv!=0 || $monthly_target_gsv!=0))
            {
               
                 $theFInalArray[$key]['monthly_revenue'] = 'false';
                 $theFInalArray[$key]['monthly_revenue_tooltip'] = "Target: $monthly_target_gsv <br> Actual: $monthly_gsv ";
                 
            }
            elseif (($monthly_gsv >= $monthly_target_gsv) && ($monthly_gsv!=0 || $monthly_target_gsv!=0) )
            {
                 $theFInalArray[$key]['monthly_revenue'] = 'true';
                 $theFInalArray[$key]['monthly_revenue_tooltip'] = "Target: $monthly_target_gsv <br> Actual: $monthly_gsv ";
            }
            else
            {
                 $theFInalArray[$key]['monthly_revenue'] = 'false';
                 $theFInalArray[$key]['monthly_revenue_tooltip'] = "Target: $monthly_target_gsv <br> Actual: $monthly_gsv ";   
            }

            //admission //admission tooltip
            if (($monthly_actual_converts < $monthly_target_converts) && ($monthly_actual_converts!=0 || $monthly_target_converts!=0))
            {
                 $theFInalArray[$key]['monthly_admission'] = 'false';
                 $theFInalArray[$key]['monthly_admission_tooltip'] = "Target: $monthly_target_converts <br> Actual: $monthly_actual_converts ";
            }
            elseif (($monthly_actual_converts >= $monthly_target_converts) && ($monthly_actual_converts!=0 || $monthly_target_converts!=0))
            {
                 $theFInalArray[$key]['monthly_admission'] = 'true';
                 $theFInalArray[$key]['monthly_admission_tooltip'] = "Target: $monthly_target_converts <br> Actual: $monthly_actual_converts ";
                
            }
            else
            {
                 $theFInalArray[$key]['monthly_admission'] = 'false';
                 $theFInalArray[$key]['monthly_admission_tooltip'] = "Target: $monthly_target_gsv <br> Actual: $monthly_gsv ";   
            }
            
            
            if (($daywise_gsv < $daywise_target_gsv) && ($daywise_gsv!=0 || $daywise_target_gsv!=0))
            {
               
                 $theFInalArray[$key]['daywise_revenue'] = 'false';
                 $theFInalArray[$key]['daywise_revenue_tooltip'] = "Target: ".number_format($daywise_target_gsv,2)." <br> Actual: ".number_format($daywise_gsv,2);
                 
            }
            elseif (($daywise_gsv >= $daywise_target_gsv) && ($daywise_gsv!=0 || $daywise_target_gsv!=0))
            {
                 $theFInalArray[$key]['daywise_revenue'] = 'true';
                 $theFInalArray[$key]['daywise_revenue_tooltip'] = "Target: ".number_format($daywise_target_gsv,2)." <br> Actual: ".number_format($daywise_gsv,2);
            }
            else
            {
                 $theFInalArray[$key]['daywise_revenue'] = 'false';
                 $theFInalArray[$key]['daywise_revenue_tooltip'] = "Target: ".number_format($daywise_target_gsv,2)." <br> Actual: ".number_format($daywise_gsv,2);
            }

            //admission //admission tooltip
            if (($daywise_actual_converts < $daywise_target_converts) && ($daywise_actual_converts!=0 || $daywise_target_converts!=0))
            {
                 $theFInalArray[$key]['daywise_admission'] = 'false';
                 $theFInalArray[$key]['daywise_admission_tooltip'] = "Target: ".number_format($daywise_target_converts,2)." <br> Actual: ".number_format($daywise_actual_converts,2);
            }
            elseif (($daywise_actual_converts >= $daywise_target_converts) && ($daywise_actual_converts!=0 || $daywise_target_converts!=0))
            {
                 $theFInalArray[$key]['daywise_admission'] = 'true';
                 $theFInalArray[$key]['daywise_admission_tooltip'] = "Target: ".number_format($daywise_target_converts,2)." <br> Actual: ".number_format($daywise_actual_converts,2);
                
            }
            else
            {
                
                 $theFInalArray[$key]['daywise_admission'] = 'false';
                 $theFInalArray[$key]['daywise_admission_tooltip'] = "Target: ".number_format($daywise_target_converts,2)." <br> Actual: ".number_format($daywise_actual_converts,2);
            
            }
           

           
        }
     
        //        if ((!isset($_SESSION['cccon_managers']) && empty($_SESSION['cccon_managers'])) && (!isset($_SESSION['cccon_councellors']) && empty($_SESSION['cccon_councellors'])))
        //        {
        //            $theFInalArray = array();
        //        }
        //echo '<pre>'; print_r($theFInalArray);
        
        if(empty($selected_councellors)){
            $theFInalArray = array();
        }

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
        $sugarSmarty->assign("selected_from_date", $selected_date);
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
        
        $sugarSmarty->assign("chUserIds", $chUserIds);
        $sugarSmarty->assign("mgUserIds", $mgUserIds);
        $sugarSmarty->assign("tlUserIds", $tlUserIds);
        $sugarSmarty->assign("agentUserIds", $agentUserIds);
        
        $sugarSmarty->assign("businessHeadArray", $businessHeadArray);
        $sugarSmarty->assign("channelHeadArray", $channelHeadArray);
        $sugarSmarty->assign("managerArray", $managerArray);
        $sugarSmarty->assign("teamLeadArray", $teamLeadArray);
        $sugarSmarty->assign("agentArray", $agentArray);
        $sugarSmarty->assign("isAdmin", $isAdmin);
        $sugarSmarty->assign("currentRoleName", $currentRoleName);

        $sugarSmarty->assign("current_records", $current);
        $sugarSmarty->assign("page", $page);
        $sugarSmarty->assign("pagenext", $pagenext);
        $sugarSmarty->assign("right", $right);
        $sugarSmarty->assign("left", $left);
        $sugarSmarty->assign("last_page", $last_page);
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/prospectdashboard.tpl');
    }

}
?>

