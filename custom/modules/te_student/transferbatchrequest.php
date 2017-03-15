<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

ini_set('memory_limit','1024M');
require_once('include/entryPoint.php');
global $db;
$old_batch_id=$_REQUEST['old_batch'];
$new_batch_id=$_REQUEST['new_batch'];
$student_id=$_REQUEST['student_id'];
$student_country=$_REQUEST['student_country'];

$studentBatchObj=new te_transfer_batch();
$studentBatchObj->te_student_batch_id_c=$old_batch_id;
$studentBatchObj->te_ba_batch_id_c=$new_batch_id;
$studentBatchObj->te_student_id_c=$student_id;
$studentBatchObj->status="Pending";
$studentBatchObj->country=$student_country;
$studentBatchObj->save();
$utmOptions['status']="queued";
echo json_encode($utmOptions);
return false;


