<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
ini_set('display_errors', '1');

error_reporting(E_ALL);
global $app_list_strings, $current_user, $sugar_config, $db;


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
    
    $condition='';
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
    $RowID = $_POST['RowID'];

    if ($RecordID!='')
    {
        $updateSql = "UPDATE agent_productivity_report SET deleted=1,status=0,modified_date='" . date('Y-m-d H:i:s') . "' where id=$RecordID";
        $usObj = $GLOBALS['db']->Query($updateSql);
       
        if($usObj){
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
    $RowID = $_POST['RowID'];

    if ($RecordID!='')
    {
        $updateSql = "UPDATE source_lead_assignment_rule SET deleted=1,status=0 where id=$RecordID";
        $usObj = $GLOBALS['db']->Query($updateSql);
       
        if($usObj){
            echo $RowID;
        }
    }
    die;
}
if (isset($_POST['action']) && $_POST['action'] == 'updateStudentEligibility')
{
    global $db,$current_user;
    $option = '';
    //RecordID: RecordID, RowID:RowID
   //echo 'xxx='.$current_user->id;
   
    $curruserID= $_SESSION['authenticated_user_id'];
    $studentBatchID = $_POST['studentBatchID']; 
    $eligStatus = $_POST['ISeligible'];
    
    //$eligStatus= ($ISeligible==1)? 0 : 1;
    
    if ($studentBatchID!='')
    {
       $updateSql = "UPDATE  te_student_batch  SET srm_is_eligible='$eligStatus',date_modified=NOW(),modified_user_id='$curruserID'  where id='$studentBatchID'";
        $usObj = $GLOBALS['db']->Query($updateSql);
       
        if($usObj){
            //echo $studentID;
            echo json_encode(array('status'=>'success','student_batch_id'=>$studentBatchID)); 
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
    $RowID = $_POST['RowID'];

    if ($RecordID!='')
    {
        $updateSql = "UPDATE report_access_log  SET is_enabled=0,modified_date='" . date('Y-m-d H:i:s') . "' where id=$RecordID";
        $usObj = $GLOBALS['db']->Query($updateSql);
       
        if($usObj){
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
   
    $leadID = $_POST['leadID'];
    $CallTime = $_POST['CallTime'];
    $dismissID = $_POST['dismissID'];

    if ($leadID!='' && $CallTime!='')
    {
         $updateSql = "UPDATE callback_log SET deleted=1,is_seen=1 where lead_id='$leadID' and callback_date_time='$CallTime'";
        $usObj = $GLOBALS['db']->Query($updateSql);
       
        if($usObj){
            echo $dismissID;
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


    if ($callbackID!='')
    {
        $updateSql = "UPDATE callback_log SET deleted=1,is_seen=1 where id='$callbackID'";
        $usObj = $GLOBALS['db']->Query($updateSql);
       
        if($usObj){
            echo $callbackID;
        }
    }
    die;
}
?>
