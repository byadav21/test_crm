<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

require_once('custom/modules/te_student/te_student_override.php');

global  $current_user;
$obj=new te_student_override();
$currentUserId = $current_user->id;
$reportingUserIds = array();			 
$obj->reportingUser($currentUserId);
$obj->report_to_id[$currentUserId] = $current_user->name;
$reportingUserIds = $obj->report_to_id;
$user_ids = implode("', '", array_keys($reportingUserIds)); 

 

$page=(isset($_REQUEST['page']) && intval($_REQUEST['page'])>0)? intval($_REQUEST['page']) : 1;
$noofRow=18;

//$email= (isset($_REQUEST['emails']) && $_REQUEST['emails']) ? addslashes($_REQUEST['emails']) : '';
$batches= (isset($_REQUEST['batches']) && $_REQUEST['batches']) ? addslashes($_REQUEST['batches']) : '';
 // $installment= (isset($_REQUEST['installment']) && $_REQUEST['installment']) ? addslashes($_REQUEST['installment']) : ''; 
$start=$noofRow*($page-1);
$isadmin=($current_user->is_admin)?1:0;
$results=$obj->getAllStudentInstallmentSummary($isadmin,$batches,$user_ids,$start,$noofRow);
$isload=($results && count($results)>17)?1 :0;
$page=$page+1;
//print_r($results);
echo json_encode(['data'=>$results,'page'=>$page,'isload'=>$isload]);die;
