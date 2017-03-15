<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

require_once('custom/modules/te_student/te_student_override.php');

global  $current_user;
 

 

$page=(isset($_REQUEST['page']) && intval($_REQUEST['page'])>0)? intval($_REQUEST['page']) : 1;
$noofRow=18;
$obj=new te_student_override();
$email= (isset($_REQUEST['emails']) && $_REQUEST['emails']) ? addslashes($_REQUEST['emails']) : '';
$batches= (isset($_REQUEST['batches']) && $_REQUEST['batches']) ? addslashes($_REQUEST['batches']) : '';
  $installment= (isset($_REQUEST['installment']) && $_REQUEST['installment']) ? addslashes($_REQUEST['installment']) : ''; 
$start=$noofRow*($page-1);
$results=$obj->getAllStudentInstallment($email,$batches,$installment,$start,$noofRow);
$isload=($results && count($results)>17)?1 :0;
$page=$page+1;
//print_r($results);
echo json_encode(['data'=>$results,'page'=>$page,'isload'=>$isload]);die;
