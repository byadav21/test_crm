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



    //echo '$target'.$target;
    //echo '$param'.$param;
    $subStatusArr    = array();
    $statusReasonArr = array();
    echo '<option value="">-Select-</option>';
    foreach ($crmDispo as $key => $value)
    {
        if ($target == 'subStatus')
        {
            if ($param == $value['status'])
            {

                $subStatusArr[$value['sub_status']] = $value['sub_status'];
            }
        }
        if ($target == 'statusReason')
        {

            if ($param == $value['sub_status'])
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
?>
