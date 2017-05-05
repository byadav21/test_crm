<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

ini_set('memory_limit','1024M');
require_once('custom/include/Email/sendmail.php');
require_once('include/entryPoint.php');
global $db;
$transferSql="SELECT * FROM te_transfer_batch WHERE id='".$_REQUEST['request_id']."' AND deleted=0";
$transferObj= $GLOBALS['db']->query($transferSql);
$transferDetails = $GLOBALS['db']->fetchByAssoc($transferObj);

$old_batch_id=$transferDetails['te_student_batch_id_c'];
$new_batch_id=$transferDetails['te_ba_batch_id_c'];
$student_id=$transferDetails['te_student_id_c'];
$student_batch_id_old=$transferDetails['batch_id_rel'];
$student_country=strtolower($transferDetails['country']);
if($student_country=='india' || empty($student_country)){
  $currency='INR';
}
else{
  $currency='USD';
}
# Find program And istitute
            $sql_program="SELECT Ts.name as institute,Ps.name as program,Sb.id FROM `te_student_batch` Sb INNER JOIN te_pr_programs Ps ON Ps.id=Sb.te_pr_programs_id_c INNER JOIN te_in_institutes Ts ON Ts.id=Sb.te_in_institutes_id_c WHERE Sb.id='".$student_batch_id_old."'";
			$programObj = $db->query($sql_program);
			$progrm_result = $db->fetchByAssoc($programObj);
			$program_mail=$progrm_result['program'];
			$institute_mail=$progrm_result['institute'];


#find student old batch details
$oldBatchSql="SELECT * FROM te_student_batch WHERE id='".$student_batch_id_old."' AND deleted=0";
$oldBatchObj= $GLOBALS['db']->query($oldBatchSql);
$oldBatchDetails = $GLOBALS['db']->fetchByAssoc($oldBatchObj);

#If request is for Reject the case.
if(isset($_REQUEST['request_status']) && $_REQUEST['request_status']=="Rejected"){
	$GLOBALS['db']->query("UPDATE te_transfer_batch SET status='".$_REQUEST['request_status']."',is_new_approved=1, te_student_batch_id_c='".$student_batch_id."' WHERE id='".$_REQUEST['request_id']."'");
	$utmOptions['status']="Transferred";

			# Mail sent for Rejected/

			$studentSql="select * FROM `te_student` WHERE id ='".$student_id."' AND deleted=0";
			$studentObj= $GLOBALS['db']->query($studentSql);
			$studentDetails = $GLOBALS['db']->fetchByAssoc($studentObj);
			$studentemail=$studentDetails['email'];
			$template="<p>Dear ".$studentDetails['name'].",</p>

                        <p>Greetings!</p>

                        <p>This is to inform you that your request for batch transfer of your currently enrolled programme ".$program_mail."".$institute_mail." to a future batch of the same programme has not been approved.</p>

                        <p>The terms and conditions are mentioned in the website just for your reference: https://talentedge.in/end-user-agreement/.</p>

                        <p>Please feel free to contact your Admissions Counsellor or your Student Relations Manager for any other query.</p>

                        <p>Regards,</p>
                        <p>Student Relations Manager</p>
                        <p>Enquiries and Customer Support, Contact No: +91-8376000600</p>";

			$mail = new NetCoreEmail();
			$mail->sendEmail($studentemail," Trasfer Batch Request Rejected",$template);

	echo json_encode($utmOptions);
	return false;
}

#create new student batch
$srm_auto_ass_useridSql = "SELECT * FROM te_srm_auto_assignment WHERE te_ba_batch_id_c='".$new_batch_id."' AND deleted=0";
$srm_auto_assObj= $GLOBALS['db']->query($srm_auto_ass_useridSql);
$srm_auto_Details = $GLOBALS['db']->fetchByAssoc($srm_auto_assObj);
#create batch of student
/* $vendorSql = "SELECT id FROM te_vendor WHERE deleted=0 AND name='".$bean->vendor."'";
$vendorObj= $GLOBALS['db']->query($vendorSql);
$vendor = $GLOBALS['db']->fetchByAssoc($vendorObj); */
#get Institute, Program and batch details
$batchSql = "SELECT b.id as batch_id,b.name as batch_name,b.batch_code,b.fees_inr,b.fees_in_usd,b.initial_payment_inr,b.initial_payment_usd,b.initial_payment_date,p.id as program_id,i.id as institute_id,b.total_sessions_planned,b.batch_start_date,b.minimum_attendance_criteria FROM te_ba_batch b INNER JOIN te_pr_programs_te_ba_batch_1_c pbr ON pbr.te_pr_programs_te_ba_batch_1te_ba_batch_idb=b.id INNER JOIN te_pr_programs p ON pbr.te_pr_programs_te_ba_batch_1te_pr_programs_ida=p.id INNER JOIN te_in_institutes_te_ba_batch_1_c bir ON b.id=bir.te_in_institutes_te_ba_batch_1te_ba_batch_idb INNER JOIN te_in_institutes i ON bir.te_in_institutes_te_ba_batch_1te_in_institutes_ida=i.id WHERE b.deleted=0 AND b.id='".$new_batch_id."'";
$batchObj= $GLOBALS['db']->query($batchSql);
$batchDetails = $GLOBALS['db']->fetchByAssoc($batchObj);
$studentBatchObj=new te_student_batch();
$studentBatchObj->name=$batchDetails['batch_name'];
$studentBatchObj->batch_code=$batchDetails['batch_code'];
$studentBatchObj->batch_start_date=$batchDetails['batch_start_date'];
$studentBatchObj->fee_inr=$batchDetails['fees_inr'];
$studentBatchObj->fee_usd=$batchDetails['fees_in_usd'];
$studentBatchObj->initial_payment_inr=$batchDetails['initial_payment_inr'];
$studentBatchObj->initial_payment_usd=$batchDetails['initial_payment_usd'];
$studentBatchObj->initial_payment_date=$batchDetails['initial_payment_date'];
$studentBatchObj->te_ba_batch_id_c=$batchDetails['batch_id'];
$studentBatchObj->te_pr_programs_id_c=$batchDetails['program_id'];
$studentBatchObj->te_in_institutes_id_c=$batchDetails['institute_id'];
//$studentBatchObj->te_vendor_id_c=$vendor['id'];
$studentBatchObj->status="Active";
if($srm_auto_Details){
$studentBatchObj->assigned_user_id=$srm_auto_Details['assigned_user_id'];
}
if($oldBatchDetails){
$studentBatchObj->study_kit_address=$oldBatchDetails['study_kit_address'];
$studentBatchObj->study_kit_address_country=$oldBatchDetails['study_kit_address_country'];
$studentBatchObj->study_kit_address_state=$oldBatchDetails['study_kit_address_state'];
$studentBatchObj->study_kit_address_postalcode=$oldBatchDetails['study_kit_address_postalcode'];
$studentBatchObj->study_kit_address_city=$oldBatchDetails['study_kit_address_city'];
$studentBatchObj->leads_id=$oldBatchDetails['leads_id'];
}
$studentBatchObj->total_session_required=$batchDetails['total_sessions_planned'];
$studentBatchObj->te_student_te_student_batch_1te_student_ida=$student_id;
$studentBatchObj->save();
#get new student batch id
$student_batch_id=$studentBatchObj->id;

#transfer payment from old batch to new batch
$studentPaymentSql="SELECT SUM(te_student_payment.amount) AS total FROM te_student_payment, te_student_te_student_payment_1_c WHERE te_student_payment.id = te_student_te_student_payment_1_c.te_student_te_student_payment_1te_student_payment_idb AND te_student_payment.te_student_batch_id_c='".$student_batch_id_old."' AND te_student_payment.payment_realized=1 AND te_student_payment.deleted=0";
$studentPaymentObj= $GLOBALS['db']->query($studentPaymentSql);
$studentPayment = $GLOBALS['db']->fetchByAssoc($studentPaymentObj);

if(isset($studentPayment['total']) && $studentPayment['total']>0){
	updateStudentPaymentPlan($new_batch_id,$student_id,$studentPayment['total'],$student_country);
}

#unlink old lead payment
$GLOBALS['db']->query("UPDATE te_payment_details, leads_te_payment_details_1_c SET te_payment_details.deleted = 1,leads_te_payment_details_1_c.deleted=1 WHERE te_payment_details.id = leads_te_payment_details_1_c.leads_te_payment_details_1te_payment_details_idb AND leads_te_payment_details_1_c.leads_te_payment_details_1leads_ida='".$oldBatchDetails['leads_id']."'");

#update leads
$GLOBALS['db']->query("UPDATE leads,leads_cstm SET leads.fee_usd='".$batchDetails['fees_in_usd']."',leads.fee_inr='".$batchDetails['fees_inr']."',leads.minimum_attendance='".$batchDetails['minimum_attendance_criteria']."',leads_cstm.min_attendance_c='".$batchDetails['minimum_attendance_criteria']."',leads_cstm.te_ba_batch_id_c = '".$batchDetails['batch_id']."' WHERE leads_cstm.id_c=leads.id AND leads_cstm.id_c='".$oldBatchDetails['leads_id']."'");

#update new student payment history
$id=create_guid();
$payment = new te_payment_details();
$payment->payment_type 	   = 'Batch Transfer';
$payment->payment_source 	   = 'Batch Transfer';
$payment->transaction_id 	   = 'Transferred Payment';
$payment->date_of_payment  = date('Y-m-d');
$payment->reference_number = 'Transferred Payment';
$payment->amount 		   = $studentPayment['total'];
$payment->name 		   	   = $studentPayment['total'];
$payment->payment_realized = 1;
$payment->leads_te_payment_details_1leads_ida = $oldBatchDetails['leads_id'];
$paidAmount=$payment->amount;
$payment_realized=1;
$payment->student_payment_id = $id;
$payment->save();
$lead_payment_details_id=$payment->id;

$insertSql="INSERT INTO te_student_payment SET id='".$id."',lead_payment_details_id='".$lead_payment_details_id."', name='Transferred Payment', date_entered='".date('Y-m-d H:i:s')."', date_modified='".date('Y-m-d H:i:s')."', te_student_batch_id_c='".$student_batch_id."',date_of_payment='".date('Y-m-d')."', amount='".$studentPayment['total']."', reference_number='Transferred Payment', payment_type='Transfer', payment_realized=1, transaction_id='0', payment_source='Batch Transfer'";
$GLOBALS['db']->Query($insertSql);
#Update relationship record of student payment history
$insertRelSql="INSERT INTO te_student_te_student_payment_1_c SET id='".create_guid()."', 	date_modified='".date('Y-m-d H:i:s')."',deleted=0,te_student_te_student_payment_1te_student_ida='".$student_id."', te_student_te_student_payment_1te_student_payment_idb='".$id."'";
$GLOBALS['db']->Query($insertRelSql);


#unlink old student batch from student
$GLOBALS['db']->query("UPDATE te_student_batch, te_student_te_student_batch_1_c SET te_student_batch.status = 'Inactive_transfer',te_student_batch.deleted = 0,te_student_te_student_batch_1_c.deleted=0 WHERE te_student_batch.id = te_student_te_student_batch_1_c.te_student_te_student_batch_1te_student_batch_idb AND te_student_te_student_batch_1_c.te_student_te_student_batch_1te_student_ida='".$student_id."' AND te_student_te_student_batch_1_c.te_student_te_student_batch_1te_student_batch_idb='".$student_batch_id_old."' AND te_student_batch.id='".$student_batch_id_old."'");

#unlink old student batch plan from student batch
$GLOBALS['db']->query("UPDATE te_student_payment_plan, te_student_batch_te_student_payment_plan_1_c SET te_student_payment_plan.deleted = 1,te_student_batch_te_student_payment_plan_1_c.deleted=1 WHERE te_student_payment_plan.id = te_student_batch_te_student_payment_plan_1_c.te_student9d1ant_plan_idb AND te_student_batch_te_student_payment_plan_1_c.te_student_batch_te_student_payment_plan_1te_student_batch_ida='".$student_batch_id_old."' AND te_student_payment_plan.te_student_id_c='".$student_id."'");

#unlink old student from student payment for old batch payment
$GLOBALS['db']->query("UPDATE te_student_payment, te_student_te_student_payment_1_c SET te_student_payment.deleted = 1,te_student_te_student_payment_1_c.deleted=1 WHERE te_student_payment.id = te_student_te_student_payment_1_c.te_student_te_student_payment_1te_student_payment_idb AND te_student_payment.te_student_batch_id_c='".$student_batch_id_old."' AND te_student_te_student_payment_1_c.te_student_te_student_payment_1te_student_ida='".$student_id."'");

#update currency
$GLOBALS['db']->query("UPDATE te_student_payment_plan, te_student_batch_te_student_payment_plan_1_c SET te_student_payment_plan.currency ='".$currency."'  WHERE te_student_payment_plan.id = te_student_batch_te_student_payment_plan_1_c.te_student9d1ant_plan_idb AND te_student_batch_te_student_payment_plan_1_c.te_student_batch_te_student_payment_plan_1te_student_batch_ida='".$student_batch_id."' AND te_student_payment_plan.te_student_id_c='".$student_id."'");


#update batch transfer request status
$GLOBALS['db']->query("UPDATE te_transfer_batch SET is_new_approved=1,status='".$_REQUEST['request_status']."', te_student_batch_id_c='".$student_batch_id."' WHERE id='".$_REQUEST['request_id']."'");
$utmOptions['status']="Transferred";

# Mail sent for Approved/

			$studentSql="select * FROM `te_student` WHERE id ='".$student_id."' AND deleted=0";
			$studentObj= $GLOBALS['db']->query($studentSql);
			$studentDetails = $GLOBALS['db']->fetchByAssoc($studentObj);
			$studentemail=$studentDetails['email'];
			$template="<p>Dear ".$studentDetails['name'].",</p>
                        <p>Greetings!</p>

                        <p>This is to confirm that owing your inability to participate in the programme for the existing batch you have enrolled for, your request for batch transfer from ".$program_mail."".$institute_mail." to the forthcoming/future batch of the same programme has been approved, subject to the future batch being offered by Talentedge.</p> 

                        <p>To facilitate this, you are requested to pay the batch transfer fee of Rs 5,000 plus taxes, and share the payment details with your Admissions Counsellor.</p>

                        <p>Please feel free to contact your Admissions Counsellor, or your Student Relations Manager for any other queries.</p>

                        <p>Regards,</p>
                        <p>Student Relations Manager</p>
                        <p>Enquiries and Customer Support, Contact No: +91-8376000600</p>";
			$mail = new NetCoreEmail();
			$mail->sendEmail($studentemail," Trasfer Batch Request Approved",$template);


echo json_encode($utmOptions);
return false;

#update student payment plan
function updateStudentPaymentPlan($batch_id,$student_id,$amount,$student_country){
	#Service Tax deduction
	global $sugar_config;
	#for Indian student only need to calculate service tax
	if($student_country=="" || strtolower($student_country)=="india"){
		$paymentPlanSql="SELECT s.name,s.id,s.te_student_id_c,s.due_amount_inr,s.paid_amount_inr,s.paid,s.due_date FROM te_student_batch sb INNER JOIN te_student_batch_te_student_payment_plan_1_c rel ON sb.id=rel.te_student_batch_te_student_payment_plan_1te_student_batch_ida INNER JOIN `te_student_payment_plan` s ON s.id=rel.te_student9d1ant_plan_idb WHERE s.deleted=0 AND s.te_student_id_c='".$student_id."' AND sb.te_ba_batch_id_c='".$batch_id."' ORDER BY s.due_date";

		$paymentPlanObj = $GLOBALS['db']->Query($paymentPlanSql);
		$tempAmt=0;
		while($row=$GLOBALS['db']->fetchByAssoc($paymentPlanObj)){
			if($row['due_amount_inr']==$row['paid_amount_inr']){
				continue;
			}
			$restAmt=($row['due_amount_inr']-$row['paid_amount_inr']);
			if($amount>=$restAmt){
				$GLOBALS['db']->Query("UPDATE te_student_payment_plan SET paid_amount_inr=paid_amount_inr+".$restAmt.", paid='Yes' WHERE id='".$row['id']."'");
				$amount=$amount-$restAmt;
			}else{
				$GLOBALS['db']->Query("UPDATE te_student_payment_plan SET paid_amount_inr=paid_amount_inr+".$amount." WHERE id='".$row['id']."'");
				$amount=0;
			}
			#update balanced amount
			$GLOBALS['db']->Query("UPDATE te_student_payment_plan SET balance_inr=due_amount_inr-paid_amount_inr WHERE id='".$row['id']."'");
			if($amount==0)
				break;
		}
	}else{
		# Payment for non indian student will be on USD
		$paymentPlanSql="SELECT s.name,s.id,s.te_student_id_c,s.due_amount_usd,s.paid_amount_usd,s.paid,s.due_date FROM te_student_batch sb INNER JOIN te_student_batch_te_student_payment_plan_1_c rel ON sb.id=rel.te_student_batch_te_student_payment_plan_1te_student_batch_ida INNER JOIN `te_student_payment_plan` s ON s.id=rel.te_student9d1ant_plan_idb WHERE s.deleted=0 AND s.te_student_id_c='".$student_id."' AND sb.te_ba_batch_id_c='".$batch_id."' ORDER BY s.due_date";
		$paymentPlanObj = $GLOBALS['db']->Query($paymentPlanSql);
		$tempAmt=0;
		while($row=$GLOBALS['db']->fetchByAssoc($paymentPlanObj)){
			if($row['due_amount_usd']==$row['paid_amount_usd']){
				continue;
			}
			$restAmt=($row['due_amount_usd']-$row['paid_amount_usd']);

			if($amount>=$restAmt){
				$GLOBALS['db']->Query("UPDATE te_student_payment_plan SET paid_amount_usd=paid_amount_usd+".$restAmt.", paid='Yes' WHERE id='".$row['id']."'");
				$amount=$amount-$restAmt;
			}else{
				$GLOBALS['db']->Query("UPDATE te_student_payment_plan SET paid_amount_usd=paid_amount_usd+".$amount." WHERE id='".$row['id']."'");
				$amount=0;
			}
			#update balanced amount
			$GLOBALS['db']->Query("UPDATE te_student_payment_plan SET balance_usd=due_amount_usd-paid_amount_usd WHERE id='".$row['id']."'");
			if($amount==0)
				break;
		}
	}
}
