<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

ini_set('memory_limit','1024M');
require_once('custom/include/Email/sendmail.php');
require_once('include/entryPoint.php');
global $db;

$old_batch_id=$_REQUEST['old_batch'];
$new_batch_id=$_REQUEST['new_batch'];
$student_id=$_REQUEST['student_id'];
$cbid=$_REQUEST['cbid'];
//$student_country=$_REQUEST['student_country'];

$studentSql="SELECT * FROM te_student WHERE id='".$_REQUEST['student_id']."' AND deleted=0";
$studentObj= $GLOBALS['db']->query($studentSql);
$studentDetails = $GLOBALS['db']->fetchByAssoc($studentObj);
$student_country=$studentDetails['country'];
$studentemail=$studentDetails['email'];

$studentBatchObj=new te_transfer_batch();
$studentBatchObj->te_student_batch_id_c=$old_batch_id;
$studentBatchObj->old_batch_records=$old_batch_id;
$studentBatchObj->batch_id_rel=$cbid;
$studentBatchObj->te_ba_batch_id_c=$new_batch_id;
$studentBatchObj->te_student_id_c=$student_id;
$studentBatchObj->status="Pending";

# Mail sent for Panding/
			$template="<p>Dear ".$studentDetails['name']."</p>
						<p>Greetings!</p>
						<p>This is in response to your request for Batch Transfer</p>
						<p>Batch Transfer Request status is Panding</p>
						
						<p>The terms and conditions which are explicitly mentioned in the Talentedge website, </p><p>and have been agreed upon by you while registering for the programme-
						https://talentedge.in/end-user-agreement/ </p>

						<p>Please feel free to reach out to your counsellor for any other information.</p>

						<p>Regards,</p>
						<p>Student Relations Manager</p>
						<p>Enquiries and Customer Support, Contact No: +91-8376000600</p>";
			$mail = new NetCoreEmail();
			$mail->sendEmail($studentemail," Trasfer Batch Request Panding",$template);

$studentBatchObj->country=$student_country;
$studentBatchObj->save();
$utmOptions['status']="queued";

echo json_encode($utmOptions);
return false;
