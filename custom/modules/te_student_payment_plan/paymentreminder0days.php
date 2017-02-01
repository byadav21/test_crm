<?php
if(!defined('sugarEntry')) {
	define('sugarEntry', true);
}
require_once('custom/include/Email/sendmail.php'); 
ini_set("memory_limit","512M");
global $db;

$paymentPlanSql="SELECT s.name as student_name,s.email,sb.name as batch_name,sp.name as payment_name,sp.id,sp.te_student_id_c,sp.due_amount_inr,sp.paid_amount_inr,sp.paid,sp.due_date,sp.balance_inr,sp.description as notes FROM te_student s INNER JOIN te_student_te_student_batch_1_c sbr ON s.id=sbr.te_student_te_student_batch_1te_student_ida INNER JOIN te_student_batch sb ON sbr.te_student_te_student_batch_1te_student_batch_idb=sb.id  INNER JOIN te_student_batch_te_student_payment_plan_1_c rel ON sb.id=rel.te_student_batch_te_student_payment_plan_1te_student_batch_ida INNER JOIN `te_student_payment_plan` sp ON sp.id=rel.te_student9d1ant_plan_idb WHERE sp.deleted=0 AND sp.due_date='".date( "Y-m-d")."' AND sp.paid='No' ORDER BY sp.due_date";

$paymentPlanObj = $GLOBALS['db']->Query($paymentPlanSql);
$batch_name="";	
$mail = new NetCoreEmail();	
while($row=$GLOBALS['db']->fetchByAssoc($paymentPlanObj)){
	$template='<p>Hello '.$row['student_name'].'</p>
	<p>This is a gentle reminder email of your '.$row['payment_name'].' payment</p>	
	<p>Please have a look in below details: </p>
	<table cellpadding="0" cellspacing="0" width="100%" border="1">
	<tr height="20">
		<th><strong>Batch</strong></th><th><strong>Payment</strong></th><th><strong>Due Amount</strong></th>
		<th><strong>Paid Amount</strong></th><th><strong>Paid</strong></th><th><strong>Balance Amount</strong></th><th>
		<strong>Notes</strong></th><th><strong>Due Date</strong></th> 
	</tr>';
	$email=$row['email']
	$template.='<tr height="20">
	   <td align="left" valign="top" >'.$row['batch_name'].'</td>
	   <td align="left" valign="top" >'.$row['payment_name'].'</td> 
	   <td align="left" valign="top">'.$row['due_amount_inr'].'</td>		
	   <td align="left" valign="top" >'.$row['paid_amount_inr'].'</td>
	   <td align="left" valign="top">'.$row['paid'].'</td>	
	   <td align="left" valign="top" >'.$row['balance_inr'].'</td> 
	   <td align="left" valign="top">'.$row['notes'].'</td>	
	   <td align="left" valign="top">'.$row['due_date'].'</td>				   
	</tr>';	
	$template.="</table>
	<p>Please ignore if you have already paid</p>
	<p>Thanks & Regards</p>
	<p>SRM Team</p>";
	$subject=" Payment Reminder of the ".$batch_name." Batch";		
	$mail->sendEmail($email,$subject,$template);
}
?>
