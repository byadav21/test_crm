<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
ini_set('display_errors', '1');

error_reporting(E_ALL);
global $app_list_strings, $current_user, $sugar_config, $db;

function __get_user_callback($userID)
{
    global $db, $current_user;
    $todayFrom                   = date('Y-m-d 00:00:00');
    $todayTo                     = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' + 15 minute'));
    $call_backSql                = "SELECT 
                                   date(c.callback_date_time) callback_date,
                                   c.callback_date_time
                            FROM callback_log AS c
                            WHERE c.is_seen=0
                              AND c.deleted=0
                              AND date(c.callback_date_time) <='" . date('Y-m-d') . "'
                              AND c.assigned_user_id='" . $userID . "'
                            ORDER BY c.callback_date_time";
    //echo $call_backSql;exit();
    $call_backObj                = $db->query($call_backSql);
    $call_backOptions            = array();
    $call_backOptions['today']   = array();
    $call_backOptions['overdue'] = array();
    while ($row                         = $db->fetchByAssoc($call_backObj))
    {
        if ($row['callback_date'] == date('Y-m-d'))
        {
            $call_backOptions['today'][] = $row;
        }
        else if ($todayTo > $row['callback_date_time'])
        {
            $call_backOptions['overdue'][] = $row;
        }
    }
    if (!empty($call_backOptions))
    {
        $total = (count($call_backOptions['today']) + count($call_backOptions['overdue']));
        return json_encode(array('today' => count($call_backOptions['today']), 'overdue' => count($call_backOptions['overdue']), 'total' => $total));
    }
    else
    {
        return json_encode(array('today' => 0, 'overdue' => 0, 'total' => 0));
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'batch_code')
{
    $where  = '';
    $option = '';
    $param  = $_POST['param'];
    if ($param && in_array('Active', $param))
    {

        $where = " and batch_status in ('enrollment_in_progress')";
    }
    else if ($param && in_array('All', $param))
    {

        $where = " ";
    }
    else if (empty($param))
    {

        $where = " ";
    }
    else
    {
        $where = " and batch_status in ('closed','completed','enrollment_closed','classes_in_progress','planned')";
    }
    $query_utm = "SELECT `id`, `name`, `batch_code` FROM `te_ba_batch` WHERE `deleted`=0 $where";
    $batch     = $db->query($query_utm);



    while ($data = $db->fetchByAssoc($batch))
    {
        $option .= '<option value="' . $data['id'] . '">' . $data['batch_code'] . '</option>';
    }

    //print_r($_POST['param']);
    echo $option;
    die;
}

if (isset($_POST['action']) && $_POST['action'] == 'councellors')
{
    global $db;
    $option = '';
    $param  = $_POST['param'];

    $condition = '';
    if (!empty($param))
    {
        $condition = "and ru.id in ('" . implode("','", $param) . "')";
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
                           AND u.deleted=0 AND u.employee_status='Active'
                           AND aru.deleted=0 and acl_roles.deleted=0 $condition";
    $userObj  = $db->query($userSql);
    $usersArr = [];
    while ($user     = $db->fetchByAssoc($userObj))
    {
        $option .= '<option value="' . $user['id'] . '">' . $user['first_name'] . ' ' . $user['last_name'] . '</option>';
    }


    echo $option;
    die;
}

if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'managerRole'){
//    $channelHeadArray = array("CH","CP","DIM","SRM","QA","TR","VR");
//    $managerArray = array("CHMGR","CPMGR","DIMMGR","SRMMGR","QAMGR","TRMGR","VRMGR");
//    $teamLeadArray = array("CHTL","CPTL","DIMTL","SRMTL","QATL","TRTL","VRTL");
//    $agentArray = array("CHAGENT","CPAGENT","DIMAGENT","SRMAGENT","QAAGENT","TRAGENT","VRAGENT");
    
    $channelHeadArray = array("CH","SCH","DMH","SRMH","QA","TR","VR");
    $managerArray = array("CHMGR","SCHMGR","DMHMGR","SRMHMGR","QAMGR","TRMGR","VRMGR");
    $teamLeadArray = array("CHTL","SCHTL","DMHTL","SRMHTL","QATL","TRTL","VRTL");
    $agentArray = array("CHAGENT","SCHAGENT","DMHAGENT","SRMHAGENT","QAAGENT","TRAGENT","VRAGENT");
      
    $channelHeadRole = isset($_REQUEST['arg']) ? $_REQUEST['arg'] : "";
    $param = $channelHeadRole;
    $mgUserIds = getCouncelorForUsers($param);
    $mgOption = '';
    $tlOption = '';
    $agentOption = '';
    foreach ($mgUserIds as  $value)
    {
        $getRoleSlug = getUsersRoleData();
        $currentRoleName   = !empty($getRoleSlug[$value['id']]['slug']) ? $getRoleSlug[$value['id']]['slug'] : '';
        if(in_array($currentRoleName ,$managerArray)){
         $mgOption .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
        }elseif(in_array($currentRoleName,$teamLeadArray)){
        $tlOption .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
        }elseif(in_array($currentRoleName,$agentArray)){
        $agentOption .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
        }
    }
    $option = array("mgOption" => $mgOption , "tlOption" => $tlOption,"agentOption" => $agentOption);
    echo json_encode($option);
    die();
}elseif (isset($_POST['action']) && $_POST['action'] == 'teamLeadRole'){
//    $teamLeadArray = array("CHTL","CPTL","DIMTL","SRMTL","QATL","TRTL","VRTL");
//    $agentArray = array("CHAGENT","CPAGENT","DIMAGENT","SRMAGENT","QAAGENT","TRAGENT","VRAGENT");
    $teamLeadArray = array("CHTL","SCHTL","DMHTL","SRMHTL","QATL","TRTL","VRTL");
    $agentArray = array("CHAGENT","SCHAGENT","DMHAGENT","SRMHAGENT","QAAGENT","TRAGENT","VRAGENT");
    $param = array();
    $channelHeadRole = isset($_REQUEST['arg']) ? $_REQUEST['arg'] : array();
    $managerRole = isset($_REQUEST['arg1']) ? $_REQUEST['arg1'] : array();
    $param = array_merge($channelHeadRole,$managerRole);
    $tlOption = '';
    $agentOption = '';
    $option = array();
    $mgUserIds = getCouncelorForUsers($param);
    foreach ($mgUserIds as  $value)
    {
        $getRoleSlug = getUsersRoleData();
        $currentRoleName   = !empty($getRoleSlug[$value['id']]['slug']) ? $getRoleSlug[$value['id']]['slug'] : '';
        if(in_array($currentRoleName,$teamLeadArray)){
            
        $tlOption .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
        }elseif(in_array($currentRoleName,$agentArray)){
        $agentOption .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
        }
    }     
    $option = array("tlOption" => $tlOption,"agentOption" => $agentOption);
    echo json_encode($option);
    die();
}else if (isset($_POST['action']) && $_POST['action'] == 'agentRole'){
    //$agentArray = array("CHAGENT","CPAGENT","DIMAGENT","SRMAGENT","QAAGENT","TRAGENT","VRAGENT");
    $agentArray = array("CHAGENT","SCHAGENT","DMHAGENT","SRMHAGENT","QAAGENT","TRAGENT","VRAGENT");
    $param = array();
    $channelHeadRole = isset($_REQUEST['arg']) ? $_REQUEST['arg'] : array();
    $managerRole = isset($_REQUEST['arg1']) ? $_REQUEST['arg1'] : array();
    $tlRole = isset($_REQUEST['arg2']) ? $_REQUEST['arg2'] : array();
    $param = array_merge($channelHeadRole,$managerRole,$tlRole);
    $option = array();
    $mgUserIds = getCouncelorForUsers($param);
    $agentOption = '';
    foreach ($mgUserIds as  $value)
    {
        $getRoleSlug = getUsersRoleData();
        $currentRoleName   = !empty($getRoleSlug[$value['id']]['slug']) ? $getRoleSlug[$value['id']]['slug'] : '';
        if(in_array($currentRoleName,$agentArray)){
        $agentOption .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
        }
    }
    $option = array("agentOption" => $agentOption);
    echo json_encode($option);
    die();
}

if (isset($_POST['action']) && $_POST['action'] == 'DeleteTargetRepo')
{
    global $db;
    $option = '';
    //RecordID: RecordID, RowID:RowID

    $RecordID = $_POST['RecordID'];
    $RowID    = $_POST['RowID'];

    if ($RecordID != '')
    {
        $updateSql = "UPDATE agent_productivity_report SET deleted=1,status=0,modified_date='" . date('Y-m-d H:i:s') . "' where id=$RecordID";
        $usObj     = $GLOBALS['db']->Query($updateSql);

        if ($usObj)
        {
            echo $RowID;
        }
    }
    die;
}

if (isset($_POST['action']) && $_POST['action'] == 'SourceLeadAssignmentRule')
{
    global $db;
    $option = '';
    //RecordID: RecordID, RowID:RowID

    $RecordID = $_POST['RecordID'];
    $RowID    = $_POST['RowID'];

    if ($RecordID != '')
    {
        $updateSql = "UPDATE source_lead_assignment_rule SET deleted=1,status=0 where id=$RecordID";
        $usObj     = $GLOBALS['db']->Query($updateSql);

        if ($usObj)
        {
            echo $RowID;
        }
    }
    die;
}
if (isset($_POST['action']) && $_POST['action'] == 'updateStudentEligibility')
{
    global $db, $current_user;
    $option = '';
    //RecordID: RecordID, RowID:RowID
    //echo 'xxx='.$current_user->id;

    $curruserID     = $_SESSION['authenticated_user_id'];
    $studentBatchID = $_POST['studentBatchID'];
    $eligStatus     = $_POST['ISeligible'];

    //$eligStatus= ($ISeligible==1)? 0 : 1;

    if ($studentBatchID != '')
    {
        $updateSql = "UPDATE  te_student_batch  SET srm_is_eligible='$eligStatus',date_modified=NOW(),modified_user_id='$curruserID'  where id='$studentBatchID'";
        $usObj     = $GLOBALS['db']->Query($updateSql);

        if ($usObj)
        {
            //echo $studentID;
            echo json_encode(array('status' => 'success', 'student_batch_id' => $studentBatchID));
        }
    }
    die;
}



if (isset($_POST['action']) && $_POST['action'] == 'DeleteRrepotAccessRepo')
{
    global $db;
    $option = '';
    //RecordID: RecordID, RowID:RowID

    $RecordID = $_POST['RecordID'];
    $RowID    = $_POST['RowID'];

    if ($RecordID != '')
    {
        $updateSql = "UPDATE report_access_log  SET is_enabled=0,modified_date='" . date('Y-m-d H:i:s') . "' where id=$RecordID";
        $usObj     = $GLOBALS['db']->Query($updateSql);

        if ($usObj)
        {
            echo $RowID;
        }
    }
    die;
}

if (isset($_POST['action']) && $_POST['action'] == 'dissmisscallback')
{
    global $db;
    $option = '';
    //RecordID: RecordID, RowID:RowID

    $leadID    = $_POST['leadID'];
    $CallTime  = $_POST['CallTime'];
    $dismissID = $_POST['dismissID'];
    $userID    = $_POST['userID'];

    if ($leadID != '' && $CallTime != '')
    {
        $updateSql = "UPDATE callback_log SET deleted=1,is_seen=1 where lead_id='$leadID' and callback_date_time='$CallTime'";
        $usObj     = $GLOBALS['db']->Query($updateSql);

        if ($usObj)
        {
            echo __get_user_callback($userID);
        }
    }
    die;
}
if (isset($_POST['action']) && $_POST['action'] == 'dissmissremainderPop')
{
    global $db;
    $option = '';
    //RecordID: RecordID, RowID:RowID

    $callbackID = $_POST['callbackID'];
    $userID     = $_POST['userID'];


    if ($callbackID != '')
    {
        $updateSql = "UPDATE callback_log SET deleted=1,is_seen=1 where id='$callbackID'";
        $usObj     = $GLOBALS['db']->Query($updateSql);

        if ($usObj)
        {
            echo __get_user_callback($userID);
        }
    }
    die;
}


if (isset($_POST['action']) && $_POST['action'] == 'leadScore')
{
    global $db;
    $option = '';
    //RecordID: RecordID, RowID:RowID
    $param = array();

    $target = $_POST['target'];
    $param  = $_POST['param'];


    $crmDispo = array(
        'Callback_Customer is Busy'         => array('status' => 'Alive', 'sub_status' => 'Call Back'),
        'Callback_RPC not available'        => array('status' => 'Alive', 'sub_status' => 'Call Back'),
        'Callback_Not Answering'            => array('status' => 'Alive', 'sub_status' => 'Call Back'),
        'Followup_Interested Followup'      => array('status' => 'Alive', 'sub_status' => 'Follow Up'),
        'Followup_Need Company Approval'    => array('status' => 'Alive', 'sub_status' => 'Follow Up'),
        'Followup_Not Answering'            => array('status' => 'Alive', 'sub_status' => 'Follow Up'),
        'Prospect'                          => array('status' => 'Warm', 'sub_status' => 'Prospect'),
        'Re-Enquired'                       => array('status' => 'Warm', 'sub_status' => 'Re-Enquired'), //System disposition
        //'Received Full Payment'               => array('status' => 'Converted', 'sub_status' => 'Converted'),
        //'Received Initial EMI'                => array('status' => 'Converted', 'sub_status' => 'Converted'),
        //'Received Partial EMI'                => array('status' => 'Converted', 'sub_status' => 'Converted'),
        'Instalment Payment'                => array('status' => 'Converted', 'sub_status' => 'Converted'),
        'Referral'                          => array('status' => 'Converted', 'sub_status' => 'Converted'),
        'Number belongs to someone else'    => array('status' => 'Dead', 'sub_status' => 'Wrong Number'),
        'invalid number'                    => array('status' => 'Dead', 'sub_status' => 'Wrong Number'),
        'Not Enquired'                      => array('status' => 'Dead', 'sub_status' => 'Not Enquired'),
        'Enquired by Mistake'               => array('status' => 'Dead', 'sub_status' => 'Not Enquired'),
        'Language Barrier'                  => array('status' => 'Dead', 'sub_status' => 'Not Eligible'),
        'Education'                         => array('status' => 'Dead', 'sub_status' => 'Not Eligible'),
        'Experience'                        => array('status' => 'Dead', 'sub_status' => 'Not Eligible'),
        'DNC'                               => array('status' => 'Dead', 'sub_status' => 'DNC'),
        'Not Answering'                     => array('status' => 'Dead', 'sub_status' => 'Not Answering'),
        'Not Interested'                    => array('status' => 'Dead', 'sub_status' => 'Not Interested'),
        'NI_Reason not shared'              => array('status' => 'Dead', 'sub_status' => 'Not Interested'),
        'NI_Time Constraint'                => array('status' => 'Dead', 'sub_status' => 'Not Interested'),
        'NI_Fees is high'                   => array('status' => 'Dead', 'sub_status' => 'Not Interested'),
        'NI_Looking for Job or Placement'   => array('status' => 'Dead', 'sub_status' => 'Not Interested'),
        'NI_Enrolled with other institutes' => array('status' => 'Dead', 'sub_status' => 'Not Interested'),
        'NI_Enrolled with TE'               => array('status' => 'Dead', 'sub_status' => 'Not Interested'),
        'NI_Looking for Degree Courses'     => array('status' => 'Dead', 'sub_status' => 'Not Interested'),
        'NI_Syllabus disinterest'           => array('status' => 'Dead', 'sub_status' => 'Not Interested'),
        'NI_Efforts Exhausted'              => array('status' => 'Dead', 'sub_status' => 'Not Interested'),
        'Next_batch'                        => array('status' => 'Dead', 'sub_status' => 'Next Batch'),
        'Reason not shared'                 => array('status' => 'Dead', 'sub_status' => 'Fallout'),
        'Next batch'                        => array('status' => 'Dead', 'sub_status' => 'Fallout'),
        'Time Constraint'                   => array('status' => 'Dead', 'sub_status' => 'Fallout'),
        'Fees is high'                      => array('status' => 'Dead', 'sub_status' => 'Fallout'),
        'Looking for Job or Placement'      => array('status' => 'Dead', 'sub_status' => 'Fallout'),
        'Enrolled with other institute'     => array('status' => 'Dead', 'sub_status' => 'Fallout'),
        'Enrolled with TE'                  => array('status' => 'Dead', 'sub_status' => 'Fallout'),
        'Looking for Degree Courses'        => array('status' => 'Dead', 'sub_status' => 'Fallout'),
        'Syllabus disinterest'              => array('status' => 'Dead', 'sub_status' => 'Fallout'),
        'Efforts Exhausted'                 => array('status' => 'Dead', 'sub_status' => 'Fallout'),
        'Cross Sell'                        => array('status' => 'Dead', 'sub_status' => 'Cross Sell'),
        'wrap.timeout'                      => array('status' => 'wrap.timeout', 'sub_status' => 'wrap.timeout'),
        'user.forced.logged.off'            => array('status' => 'user.forced.logged.off', 'sub_status' => 'user.forced.logged.off'),
        'Recycle'                           => array('status' => 'Recycle', 'sub_status' => 'Recycle'),
        'Reassigned'                        => array('status' => 'Reassigned', 'sub_status' => 'Reassigned'),
    );


    //print_r($param);
    //echo '$target'.$target;
    //echo '$param'.$param;
    $subStatusArr    = array();
    $statusReasonArr = array();
    echo '<option value="">-Select-</option>';
    foreach ($crmDispo as $key => $value)
    {
        if ($target == 'subStatus')
        {   
            if (in_array($value['status'], $param))
            //if ($param == $value['status'])
            {

                $subStatusArr[$value['sub_status']] = $value['sub_status'];
            }
        }
        if ($target == 'statusReason')
        {
            if (in_array($value['sub_status'], $param))
            //if ($param == $value['sub_status'])
            {
                $statusReasonArr[$key] = $key;
                echo '<option value="' . $key . '">' . $key . '</option>';
            }
        }
    }



    if ($target == 'subStatus')
    {
        foreach ($subStatusArr as $key => $value)
        {
            echo '<option value="' . $key . '">' . $key . '</option>';
        }
    }

    die;
}


if (isset($_POST['action']) && $_POST['action'] == 'proComentBox')
{
    global $db;
    $option = '';
    //RecordID: RecordID, RowID:RowID
    $param = array();

    $msg            = trim($_POST['msg']);
    $selecteddate   = $_POST['selecteddate'];
    $com_by         = $_POST['hidden_com_by'];
    $user_id        = $_POST['hidden_user_id'];
    $user_email        = $_POST['hidden_user_email'];
    
    $selected_years = date('Y', strtotime($selecteddate));

    $selected_month = date('m', strtotime($selecteddate));

    
    // te_prospect_repo_comments
     $lead = "SELECT user_id
                FROM te_prospect_repo_comments
                WHERE user_id='$user_id'
                  AND MONTH='$selected_month'
                  AND YEAR='$selected_years'";
    $res = $db->query($lead);
    
    if ($db->getRowCount($res) > 0)
    {   
        $updateSql = "update te_prospect_repo_comments SET comments='".$msg."' where "
                . "user_id='".$user_id."' "
                . "and month='".$selected_month."' and year='".$selected_years."'";
        $usObj     = $GLOBALS['db']->Query($updateSql);

    }
    else
    {
         $updateSql = "insert into te_prospect_repo_comments SET "
                . "date='" . date('Y-m-d H:i:s') . "',"
                . "user_id='".$user_id."',"
                . "user_email='".$user_email."',"
                . "comments='".$msg."',"
                . "commented_by='".$com_by."',"
                . "month='".$selected_month."',"
                . "year='".$selected_years."',"
                . "comment_date='".date('Y-m-d') ."'";
        $usObj     = $GLOBALS['db']->Query($updateSql);
    }

    
    echo json_encode(array('status' => 'success', 'msg' => 'success!'));
    
   
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
                     WHERE ru.id IN ('" . implode("',
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
    
    function getUsersRoleData()
    {
        global $db;
        $proSql      = "SELECT slug, 
                        user_id, 
                        name role_name
                                                 FROM acl_roles
                                INNER JOIN acl_roles_users ON acl_roles_users.role_id = acl_roles.id
                                AND acl_roles.deleted =0
                                AND acl_roles_users.deleted =0";
        $pro_Obj     = $db->query($proSql);
        $pro_Options = array();
        while ($row         = $db->fetchByAssoc($pro_Obj))
        {
            $pro_Options[$row['user_id']]['user_id']   = $row['user_id'];
            $pro_Options[$row['user_id']]['slug']      = $row['slug'];
            $pro_Options[$row['user_id']]['role_name'] = $row['role_name'];
        }
        return $pro_Options;
    }
?>
