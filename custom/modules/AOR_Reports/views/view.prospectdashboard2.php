<?php

// Date: Created on : 27th FEB 2018

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');

//error_reporting(-1);
//ini_set('display_errors', 'On');

class AOR_ReportsViewprospectdashboard2 extends SugarView
{

    var $report_to_id;
    var $counsellors_arr;

    public function __construct()
    {
        parent::SugarView();
    }

    function minutes($time)
    {
        //$time = explode(':', $time);
        //return ($time[0]*60) + ($time[1]) + ($time[2]/60);

        return $seconds = strtotime("1970-01-01 $time UTC");
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
    function getAgentsUser($year = '', $month = '', $yesterday = '', $today = '', $selected_councellors = array(), $current_userAccess = array(), $CouncellorsList = array())
    {
        global $db, $current_user;

        $wherex   = '';
        $userSlug = "";

        //echo 'dd=='.$current_userAccess['slug'];


        if (!empty($selected_councellors) && $userSlug != 'CCC')
        {
            $wherex .= " AND  users.id IN ('" . implode("','", $selected_councellors) . "')";
        }
        if (!empty($current_userAccess['slug']) && $current_userAccess['slug'] == 'CCC')
        {
            //echo 'xxx'.
            $wherex .= " AND  users.id ='$current_user->id'";
        }
        //print_r($CouncellorsList);
        if (!empty($current_userAccess['slug']) && $current_userAccess['slug'] == 'CCM' && empty($selected_councellors))
        {
            //echo 'xxx'.
            $managersAgent = array();
            foreach ($CouncellorsList as $key => $val)
            {
                $managersAgent[] = $key;
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
            $batchOptions[$row['user']]['user_id']    = $row['user_id'];
        }
        return $batchOptions;
    }

    function getMonthToDateProspect($year = '', $month = '', $yesterday = '', $today = '', $selected_councellors = array(), $current_userAccess = array(), $CouncellorsList = array())
    {
        global $db, $current_user;

        $wherex   = '';
        $userSlug = "";


        //echo '$year='.$year.'$month='.$month.'$yesterday='.$yesterday.'$yesterday='.$yesterday;
        //echo 'dd=='.$current_userAccess['slug'];
        if (!empty($month))
        {
            $wherex .= " AND month(leads.date_of_prospect) = '$month' ";
        }
        if (!empty($year))
        {
            $wherex .= " AND year(leads.date_of_prospect)='$year' ";
        }
        if (!empty($yesterday))
        {

            $wherex .= " AND date(leads.date_of_prospect)= '$yesterday' ";
        }
        if (!empty($today))
        {
            $wherex .= " AND date(leads.date_of_prospect)= '$today' ";
        }

        if (!empty($selected_councellors) && $userSlug != 'CCC')
        {
            $wherex .= " AND  leads.assigned_user_id IN ('" . implode("','", $selected_councellors) . "')";
        }
        if (!empty($current_userAccess['slug']) && $current_userAccess['slug'] == 'CCC')
        {
            //echo 'xxx'.
            $wherex .= " AND  leads.assigned_user_id ='$current_user->id'";
        }
        //print_r($CouncellorsList);
        if (!empty($current_userAccess['slug']) && $current_userAccess['slug'] == 'CCM' && empty($selected_councellors))
        {
            //echo 'xxx'.
            $managersAgent = array();
            foreach ($CouncellorsList as $key => $val)
            {
                $managersAgent[] = $key;
            }
            //print_r($managersAgent);
            $wherex .= " AND  leads.assigned_user_id IN ('" . implode("','", $managersAgent) . "')";
        }


        //$pinchedArr = array('Converted');
        //echo '<pre>'.
        $batchSql     = "SELECT 
                            users.user_name,
                            leads.status_description,
                                month(leads.date_of_prospect) monthwise,
                                year(leads.date_of_prospect) yearwise,
                            count(leads.id) leadCont
                     FROM leads
                     INNER JOIN users ON leads.assigned_user_id =users.id
                     INNER JOIN leads_cstm ON leads.id= leads_cstm.id_c
                     WHERE leads.deleted=0
                       and leads.assigned_user_id!=''
                       AND users.deleted=0
                       AND users.status='Active'
		       AND users.department='CC'
                       AND leads.status_description ='Prospect'
                      $wherex
                     GROUP BY leads.assigned_user_id,leads.status_description,month(leads.date_of_prospect)
                     order by leads.assigned_user_id,leads.status_description,month(leads.date_of_prospect);";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        $pitchedCount = 0;
        while ($row          = $db->fetchByAssoc($batchObj))
        {

            $batchOptions[$row['user_name']]['prospect'] += $row['leadCont'];
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

        $batchSql     = "SELECT 
                            users.user_name,
                            apr.target_pitched,
                            apr.target_prospects,
                            apr.target_unit,
                            apr.target_gsv,
                            apr.conversion_rate,
                            apr.connected_calls,
                            apr.talk_time,
                            apr.quality_score,
                            apr.working_days
                     FROM agent_productivity_report apr
                     INNER JOIN users ON apr.user_id =users.id
                     WHERE apr.status=1
                       AND apr.deleted=0 $wherex
                     ORDER BY apr.created_date DESC;";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        while ($row          = $db->fetchByAssoc($batchObj))
        {
            $batchOptions[$row['user_name']]['target_unit']     += $row['target_unit'];
            $batchOptions[$row['user_name']]['Prospects']       += $row['target_prospects'];
            $batchOptions[$row['user_name']]['conversion_rate'] += $row['conversion_rate'];
            $batchOptions[$row['user_name']]['connected_calls'] += $row['connected_calls'];
            //$batchOptions[$row['user_name']]['talk_time']       += ($row['talk_time'] * 3600);
            $batchOptions[$row['user_name']]['talk_time']       += $row['talk_time'];
            $batchOptions[$row['user_name']]['quality_score']   += $row['quality_score'];
            $batchOptions[$row['user_name']]['working_days']       += $row['working_days'];
        }
        return $batchOptions;
    }
    
    function clean($string){
      return preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.
    }

    //getamyeoCallHistoryCount
    function getamyeoCallHistoryCount($year = '', $month = '', $yesterday = '', $today = '')
    {
        global $db;

        $wherex = '';

        //echo 'dd=='.$current_userAccess['slug'];
        if (!empty($month))
        {
            $wherex .= " AND month(ach.calling_date) = '$month' ";
        }
        if (!empty($year))
        {
            $wherex .= " AND year(ach.calling_date)='$year' ";
        }

        if (!empty($today))
        {
            $wherex .= " AND ach.calling_date= '$today' ";
        }

        if (!empty($selected_councellors) && $userSlug != 'CCC')
        {
            $wherex .= " AND  ach.counsellor_id IN ('" . implode("','", $selected_councellors) . "')";
        }
        if (!empty($current_userAccess['slug']) && $current_userAccess['slug'] == 'CCC')
        {
            //echo 'xxx'.
            $wherex .= " AND  ach.counsellor_id ='$current_user->id'";
        }
        //print_r($CouncellorsList);
        if (!empty($current_userAccess['slug']) && $current_userAccess['slug'] == 'CCM' && empty($selected_councellors))
        {
            //echo 'xxx'.
            $managersAgent = array();
            foreach ($CouncellorsList as $key => $val)
            {
                $managersAgent[] = $key;
            }
            //print_r($managersAgent);
            $wherex .= " AND  ach.counsellor_id IN ('" . implode("','", $managersAgent) . "')";
        }


        $batchSql     = "SELECT 
                            *
                     FROM te_amyeo_calls_history ach
                     LEFT JOIN users ON ach.counsellor_id =users.id
                     WHERE ach.deleted=0 $wherex
                     ORDER BY ach.calling_date DESC;";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        while ($row          = $db->fetchByAssoc($batchObj))
        {

            $batchOptions[$row['counsellor']]['total_calls_dialed'] += $row['total_calls_dialed'];
            $batchOptions[$row['counsellor']]['inbound_time']       += $this->minutes($row['inbound_time']);
            $batchOptions[$row['counsellor']]['outbound_time']      += $this->minutes($row['outbound_time']);
            $batchOptions[$row['counsellor']]['autodial_time']      += $this->minutes($row['autodial_time']);
            $batchOptions[$row['counsellor']]['total_call_time']    += $this->minutes($row['total_call_time']);
            $batchOptions[$row['counsellor']]['average_talk_time']  += $this->minutes($row['average_talk_time']);
        }
        return $batchOptions;
    }

    function getActualConverts($year = '', $month = '', $yesterday = '', $today = '', $selected_councellors = array(), $current_userAccess = array(), $CouncellorsList = array())
    {
        global $db, $current_user;

        $wherex   = '';
        $userSlug = "";


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

        if (!empty($selected_councellors) && $userSlug != 'CCC')
        {
            $wherex .= " AND  leads.assigned_user_id IN ('" . implode("','", $selected_councellors) . "')";
        }
        if (!empty($current_userAccess['slug']) && $current_userAccess['slug'] == 'CCC')
        {
            //echo 'xxx'.
            $wherex .= " AND  leads.assigned_user_id ='$current_user->id'";
        }
        //print_r($CouncellorsList);
        if (!empty($current_userAccess['slug']) && $current_userAccess['slug'] == 'CCM' && empty($selected_councellors))
        {
            //echo 'xxx'.
            $managersAgent = array();
            foreach ($CouncellorsList as $key => $val)
            {
                $managersAgent[] = $key;
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
		       AND users.department='CC'
                       AND leads.status_description ='Converted'
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
    
    
    function  getProspectComments($month = '',$year = '')
    {
        global $db;

        $wherex = '';

        //echo 'dd=='.$current_userAccess['slug'];
        if (!empty($month))
        {
            $wherex .= " AND prc.month = '$month' ";
        }
        if (!empty($year))
        {
            $wherex .= " AND prc.year='$year' ";
        }


        $batchSql     = "SELECT *
                        FROM te_prospect_repo_comments prc
                        WHERE prc.deleted=0 $wherex;";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        while ($row          = $db->fetchByAssoc($batchObj))
        {

            $batchOptions[$row['user_email']]['comments']  = $row['comments'];
            
        }
        return $batchOptions;
    }

    ///////New task end


    public function display()
    {

        global $sugar_config, $app_list_strings, $current_user, $db;

        //die('Report is under maintenance!');
        $where              = "";
        $wherecl            = "";
        $campaignID         = array();
        $leadID             = array();
        $current_userAccess = "";
        $userSlug           = "";
        $getUsersRole       = getUsersRole();
        

        $current_userAccess = isset($getUsersRole[$current_user->id]) ? $getUsersRole[$current_user->id] : array();
        $userSlug           = $current_userAccess['slug'];


        //$BatchListData = $this->getBatch();
        $is_manger = $this->checkManager();
        $error     = array();

        $managerSList = $this->getManagers();

        if ($userSlug == 'CCM')
        {
            $CouncellorsList = $this->getCouncelor($current_user->id);
        }
        else
        {
            $CouncellorsList = $this->getCouncelor($_SESSION['cccon_managers']);
        }




        if (isset($_POST['button']) || isset($_POST['export']))
        {
            $_SESSION['cccon_from_date']   = $_REQUEST['from_date'];
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
            $selected_month = date('m');
        }
        if (!empty($_SESSION['cccon_years']))
        {
            $selected_years = $_SESSION['cccon_years'];
        }
        else
        {
            $selected_years = date('Y');
        }

        if ($is_manger == 1)
        {
            $selected_managers = array($current_user->id);
        }

        $theFInalArray = array();



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
        $getAgentsUser = $this->getAgentsUser($selected_years, $selected_month, '', '', $selected_councellors, $current_userAccess, $CouncellorsList);

        # Month wise Report to be poplated 



        $getTargetCount = $this->getMonthToDateTargetCount($selected_years, $selected_month, '', '');


        $amyeoMonthwise = $this->getamyeoCallHistoryCount($selected_years, $selected_month, '', '', $selected_councellors, $current_userAccess, $CouncellorsList);
        $amyeoDaywise   = $this->getamyeoCallHistoryCount('', '', '', $selected_date, '', $current_userAccess, '');

        $getMonthwiseProspect = $this->getMonthToDateProspect($selected_years, $selected_month, '', '', $selected_councellors, $current_userAccess, $CouncellorsList);
        $getDayWiseProspect   = $this->getMonthToDateProspect('', '', '', $selected_date, '', $current_userAccess, '');


        $getMonthwiseConverts = $this->getActualConverts($selected_years, $selected_month, '', '', $selected_councellors, $current_userAccess, $CouncellorsList);
        $getDayWiseConverts   = $this->getActualConverts('', '', '', $selected_date, '', $current_userAccess, '');


        $getProspectComments = $this->getProspectComments($selected_month,$selected_years);
        //echo '<pre>'; print_r($getProspectComments);  die;
        $theFInalArray = array();
        foreach ($getAgentsUser as $key => $val)
        {

            $theFInalArray[$key]['Agent_Name']    = isset($val['Agent_Name']) ? $val['Agent_Name'] : 0;
            $theFInalArray[$key]['Agent_ID']      = isset($val['user_id']) ? $val['user_id'] : 0;
            $quality_score  = isset($getTargetCount[$key]['quality_score']) ? $getTargetCount[$key]['quality_score'] : 0;
            
            $theFInalArray[$key]['usercomments']  = isset($getProspectComments[$key]['comments']) ? $this->clean($getProspectComments[$key]['comments']) : '';




            $monthly_prospect_target = isset($getTargetCount[$key]['Prospects']) ? $getTargetCount[$key]['Prospects'] : 0;
            $daywise_prospect_target = isset($getTargetCount[$key]['Prospects']) ? ($getTargetCount[$key]['Prospects'] / 30) : 0;
            $monthly_actual_prospect = isset($getMonthwiseProspect[$key]['prospect']) ? $getMonthwiseProspect[$key]['prospect'] : 0;
            $daywise_actual_prospect = isset($getDayWiseProspect[$key]['prospect']) ? $getDayWiseProspect[$key]['prospect'] : 0;



            $monthly_targeted_calls = isset($getTargetCount[$key]['connected_calls']) ? $getTargetCount[$key]['connected_calls'] : 0;
            $daywise_targeted_calls = isset($getTargetCount[$key]['connected_calls']) ? ($getTargetCount[$key]['connected_calls'] / 30) : 0;
            $monthly_actual_calls   = isset($amyeoMonthwise[$key]['total_calls_dialed']) ? $amyeoMonthwise[$key]['total_calls_dialed'] : 0;
            $daywise_actual_calls   = isset($amyeoDaywise[$key]['total_calls_dialed']) ? $amyeoDaywise[$key]['total_calls_dialed'] : 0;


            $monthly_targeted_talktime = isset($getTargetCount[$key]['talk_time']) ? ($getTargetCount[$key]['talk_time']*$getTargetCount[$key]['working_days']) : 0;
            $monthly_targeted_talktime=round($monthly_targeted_talktime);
            $monthly_targeted_talktime = sprintf('%02d:%02d:%02d', ($monthly_targeted_talktime/3600),($monthly_targeted_talktime/60%60), $monthly_targeted_talktime%60);
            $daywise_targeted_talktime = isset($getTargetCount[$key]['talk_time']) ? ($getTargetCount[$key]['talk_time'] ) : 0;
            $daywise_targeted_talktime=round($daywise_targeted_talktime);
            $daywise_targeted_talktime = sprintf('%02d:%02d:%02d', ($daywise_targeted_talktime/3600),($daywise_targeted_talktime/60%60), $daywise_targeted_talktime%60);
            $monthly_actual_talktime   = isset($amyeoMonthwise[$key]['total_call_time']) ? $amyeoMonthwise[$key]['total_call_time'] : 0;
            $daywise_actual_talktime   = isset($amyeoDaywise[$key]['total_call_time']) ? $amyeoDaywise[$key]['total_call_time'] : 0;


            $monthly_targeted_conversion = isset($getTargetCount[$key]['target_unit']) ? $getTargetCount[$key]['target_unit'] : 0;
            $daywise_targeted_conversion = isset($getTargetCount[$key]['target_unit']) ? ($getTargetCount[$key]['target_unit'] / 30) : 0;
            $monthly_actual_conversion   = isset($getMonthwiseConverts[$key]['Converts']) ? $getMonthwiseConverts[$key]['Converts'] : 0;
            $daywise_actual_conversion   = isset($getDayWiseConverts[$key]['Converts']) ? $getDayWiseConverts[$key]['Converts'] : 0;
            


            // Start of Prospect section ///////////////////////////////////////////////////////////////////////////////////////////////
            if (($monthly_actual_prospect < $monthly_prospect_target) && ($monthly_actual_prospect != 0 || $monthly_prospect_target != 0))
            {
                $theFInalArray[$key]['monthly_prospect']         = 'false';
                $theFInalArray[$key]['monthly_prospect_tooltip'] = "Target: $monthly_prospect_target <br> Actual: $monthly_actual_prospect ";
            }
            elseif (($monthly_actual_prospect >= $monthly_prospect_target) && ($monthly_actual_prospect != 0 || $monthly_prospect_target != 0))
            {
                $theFInalArray[$key]['monthly_prospect']         = 'true';
                $theFInalArray[$key]['monthly_prospect_tooltip'] = "Target: $monthly_prospect_target <br> Actual: $monthly_actual_prospect ";
            }
            else
            {
                $theFInalArray[$key]['monthly_prospect']         = 'false';
                $theFInalArray[$key]['monthly_prospect_tooltip'] = "Target: $monthly_prospect_target <br> Actual: $monthly_actual_prospect ";
            }

            //Day wise Prospect
            if (($daywise_actual_prospect < $daywise_prospect_target) && ($daywise_actual_prospect != 0 || $daywise_prospect_target != 0))
            {
                $theFInalArray[$key]['daywise_prospect']         = 'false';
                $theFInalArray[$key]['daywise_prospect_tooltip'] = "Target: $daywise_prospect_target <br> Actual: $daywise_actual_prospect ";
            }
            elseif (($daywise_actual_prospect >= $daywise_prospect_target) && ($daywise_actual_prospect != 0 || $daywise_prospect_target != 0))
            {
                $theFInalArray[$key]['daywise_prospect']         = 'true';
                $theFInalArray[$key]['daywise_prospect_tooltip'] = "Target: $daywise_prospect_target <br> Actual: $daywise_actual_prospect ";
            }
            else
            {
                $theFInalArray[$key]['daywise_prospect']         = 'false';
                $theFInalArray[$key]['daywise_prospect_tooltip'] = "Target: $daywise_prospect_target <br> Actual: $daywise_actual_prospect ";
            }


            // Number of connected Calls section ///////////////////////////////////////////////////////////////////////////////////////////
            if (($monthly_actual_calls < $monthly_targeted_calls) && ($monthly_actual_calls != 0 || $monthly_targeted_calls != 0))
            {
                $theFInalArray[$key]['monthly_totalcalls']         = 'false';
                $theFInalArray[$key]['monthly_totalcalls_tooltip'] = "Target: $monthly_targeted_calls <br> Actual: $monthly_actual_calls ";
            }
            elseif (($monthly_actual_calls >= $monthly_targeted_calls) && ($monthly_actual_calls != 0 || $monthly_targeted_calls != 0))
            {
                $theFInalArray[$key]['monthly_totalcalls']         = 'true';
                $theFInalArray[$key]['monthly_totalcalls_tooltip'] = "Target: $monthly_targeted_calls <br> Actual: $monthly_actual_calls ";
            }
            else
            {
                $theFInalArray[$key]['monthly_totalcalls']         = 'false';
                $theFInalArray[$key]['monthly_totalcalls_tooltip'] = "Target: $monthly_targeted_calls <br> Actual: $monthly_actual_calls ";
            }

            /* Day wise */
            if (($daywise_actual_calls < $daywise_targeted_calls) && ($daywise_actual_calls != 0 || $daywise_targeted_calls != 0))
            {
                $theFInalArray[$key]['daywise_totalcalls']         = 'false';
                $theFInalArray[$key]['daywise_totalcalls_tooltip'] = "Target: $daywise_targeted_calls <br> Actual: $daywise_actual_calls ";
            }
            elseif (($daywise_actual_calls >= $daywise_targeted_calls) && ($daywise_actual_calls != 0 || $daywise_targeted_calls != 0))
            {
                $theFInalArray[$key]['daywise_totalcalls']         = 'true';
                $theFInalArray[$key]['daywise_totalcalls_tooltip'] = "Target: $daywise_targeted_calls <br> Actual: $daywise_actual_calls ";
            }
            else
            {
                $theFInalArray[$key]['daywise_totalcalls']         = 'false';
                $theFInalArray[$key]['daywise_totalcalls_tooltip'] = "Target: $daywise_targeted_calls <br> Actual: $daywise_actual_calls ";
            }


            // Number of Talk Time section ///////////////////////////////////////////////////////////////////////////////////////////
            if (($monthly_actual_talktime < $monthly_targeted_talktime) && ($monthly_actual_talktime != 0 || $monthly_targeted_talktime != 0))
            {
                $theFInalArray[$key]['monthly_talktime']         = 'false';
                $theFInalArray[$key]['monthly_talktime_tooltip'] = "Target: " . gmdate("H:i:s", $monthly_targeted_talktime) . " <br> Actual: " . gmdate("H:i:s", $monthly_actual_talktime);
            }
            elseif (($monthly_actual_talktime >= $monthly_targeted_talktime) && ($monthly_actual_talktime != 0 || $monthly_targeted_talktime != 0))
            {
                $theFInalArray[$key]['monthly_talktime']         = 'true';
                $theFInalArray[$key]['monthly_talktime_tooltip'] = "Target: " . gmdate("H:i:s", $monthly_targeted_talktime) . " <br> Actual: " . gmdate("H:i:s", $monthly_actual_talktime);
            }
            else
            {
                $theFInalArray[$key]['monthly_talktime']         = 'false';
                $theFInalArray[$key]['monthly_talktime_tooltip'] = "Target: " . gmdate("H:i:s", $monthly_targeted_talktime) . " <br> Actual: " . gmdate("H:i:s", $monthly_actual_talktime);
            }

            /* Day wise */
            if (($daywise_actual_talktime < $daywise_targeted_talktime) && ($daywise_actual_talktime != 0 || $daywise_targeted_talktime != 0))
            {
                $theFInalArray[$key]['daywise_talktime']         = 'false';
                $theFInalArray[$key]['daywise_talktime_tooltip'] = "Target:  " . gmdate("H:i:s", $daywise_targeted_talktime) . " <br> Actual:  " . gmdate("H:i:s", $daywise_actual_talktime);
            }
            elseif (($daywise_actual_talktime >= $daywise_targeted_talktime) && ($daywise_actual_talktime != 0 || $daywise_targeted_talktime != 0))
            {
                $theFInalArray[$key]['daywise_talktime']         = 'true';
                $theFInalArray[$key]['daywise_talktime_tooltip'] = "Target:  " . gmdate("H:i:s", $daywise_targeted_talktime) . " <br> Actual:  " . gmdate("H:i:s", $daywise_actual_talktime);
            }
            else
            {
                $theFInalArray[$key]['daywise_talktime']         = 'false';
                $theFInalArray[$key]['daywise_talktime_tooltip'] = "Target:  " . gmdate("H:i:s", $daywise_targeted_talktime) . " <br> Actual:  " . gmdate("H:i:s", $daywise_actual_talktime);
            }



            // Conversion section ///////////////////////////////////////////////////////////////////////////////////////////

            if (($monthly_actual_conversion < $monthly_targeted_conversion) && ($monthly_actual_conversion != 0 || $monthly_targeted_conversion != 0))
            {
                $theFInalArray[$key]['monthly_conversion']         = 'false';
                $theFInalArray[$key]['monthly_conversion_tooltip'] = "Target: $monthly_targeted_conversion <br> Actual: $monthly_actual_conversion ";
            }
            elseif (($monthly_actual_conversion >= $monthly_targeted_conversion) && ($monthly_actual_conversion != 0 || $monthly_targeted_conversion != 0))
            {
                $theFInalArray[$key]['monthly_conversion']         = 'true';
                $theFInalArray[$key]['monthly_conversion_tooltip'] = "Target: $monthly_targeted_conversion <br> Actual: $monthly_actual_conversion ";
            }
            else
            {
                $theFInalArray[$key]['monthly_conversion']         = 'false';
                $theFInalArray[$key]['monthly_conversion_tooltip'] = "Target: $monthly_targeted_conversion <br> Actual: $monthly_actual_conversion ";
            }

            /* Day wise */
            if (($daywise_actual_conversion < $daywise_targeted_conversion) && ($daywise_actual_conversion != 0 || $daywise_targeted_conversion != 0))
            {
                $theFInalArray[$key]['daywise_conversion']         = 'false';
                $theFInalArray[$key]['daywise_conversion_tooltip'] = "Target: $daywise_targeted_conversion <br> Actual: $daywise_actual_conversion ";
            }
            elseif (($daywise_actual_talktime >= $daywise_targeted_talktime) && ($daywise_actual_talktime != 0 || $daywise_targeted_talktime != 0))
            {
                $theFInalArray[$key]['daywise_conversion']         = 'true';
                $theFInalArray[$key]['daywise_conversion_tooltip'] = "Target: $daywise_targeted_conversion <br> Actual: $daywise_actual_conversion ";
            }
            else
            {
                $theFInalArray[$key]['daywise_conversion']         = 'false';
                $theFInalArray[$key]['daywise_conversion_tooltip'] = "Target: $daywise_targeted_conversion <br> Actual: $daywise_actual_conversion ";
            }

            // Call Quality Score ///////////////////////////////////////////////////////////////////////////////////////////
            
            if($quality_score){
            $theFInalArray[$key]['quality_score_tooltip'] = "Score: $quality_score ";
            }
        }

        //        if ((!isset($_SESSION['cccon_managers']) && empty($_SESSION['cccon_managers'])) && (!isset($_SESSION['cccon_councellors']) && empty($_SESSION['cccon_councellors'])))
        //        {
        //            $theFInalArray = array();
        //        }
        //echo '<pre>'; print_r($theFInalArray);
        #PS @Pawan
        
        if(empty($selected_councellors)){
            $theFInalArray = array();
        }

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
        
         $sugarSmarty->assign("current_user_id", $current_user->id);

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
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/prospectdashboard2.tpl');
    }

}
?>

