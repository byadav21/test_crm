<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

ini_set('memory_limit','1024M');
require_once('include/entryPoint.php');
global $db;
$transferSql="SELECT * FROM te_transfer_batch WHERE id='".$_REQUEST['request_id']."' AND deleted=0";
$transferObj= $GLOBALS['db']->query($transferSql);
$transferDetails = $GLOBALS['db']->fetchByAssoc($transferObj);

$old_batch_id=$transferDetails['te_student_batch_id_c'];
$new_batch_id=$transferDetails['te_ba_batch_id_c'];
$student_id=$transferDetails['te_student_id_c'];
$student_country=$transferDetails['country'];

#create new student batch

#create batch of student
/* $vendorSql = "SELECT id FROM te_vendor WHERE deleted=0 AND name='".$bean->vendor."'";
$vendorObj= $GLOBALS['db']->query($vendorSql);
$vendor = $GLOBALS['db']->fetchByAssoc($vendorObj); */
#get Institute, Program and batch details
$batchSql = "SELECT b.id as batch_id,b.name as batch_name,b.batch_code,b.fees_inr,b.fees_in_usd,b.initial_payment_inr,b.initial_payment_usd,b.initial_payment_date,p.id as program_id,i.id as institute_id,b.total_sessions_planned,b.batch_start_date FROM te_ba_batch b INNER JOIN te_pr_programs_te_ba_batch_1_c pbr ON pbr.te_pr_programs_te_ba_batch_1te_ba_batch_idb=b.id INNER JOIN te_pr_programs p ON pbr.te_pr_programs_te_ba_batch_1te_pr_programs_ida=p.id INNER JOIN te_in_institutes_te_ba_batch_1_c bir ON b.id=bir.te_in_institutes_te_ba_batch_1te_ba_batch_idb INNER JOIN te_in_institutes i ON bir.te_in_institutes_te_ba_batch_1te_in_institutes_ida=i.id WHERE b.deleted=0 AND b.id='".$new_batch_id."'";
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
$studentBatchObj->total_session_required=$batchDetails['total_sessions_planned'];
$studentBatchObj->te_student_te_student_batch_1te_student_ida=$student_id;
$studentBatchObj->save();
#get new student batch id
$student_batch_id=$studentBatchObj->id;

#transfer payment from old batch to new batch
$studentPaymentSql="SELECT SUM(te_student_payment_plan.paid_amount_inr) as total FROM te_student_payment_plan, te_student_batch_te_student_payment_plan_1_c WHERE te_student_payment_plan.id = te_student_batch_te_student_payment_plan_1_c.te_student9d1ant_plan_idb AND te_student_batch_te_student_payment_plan_1_c.te_student_batch_te_student_payment_plan_1te_student_batch_ida='".$old_batch_id."' AND te_student_payment_plan.te_student_id_c='".$student_id."'";

$studentPaymentObj= $GLOBALS['db']->query($studentPaymentSql);
$studentPayment = $GLOBALS['db']->fetchByAssoc($studentPaymentObj);
if(isset($studentPayment['total']) && $studentPayment['total']>0){
	updateStudentPaymentPlan($new_batch_id,$student_id,$studentPayment['total'],$student_country);
}
#update new student payment history
$id=create_guid();
$insertSql="INSERT INTO te_student_payment SET id='".$id."', name='Transferred Payment', date_entered='".date('Y-m-d H:i:s')."', date_modified='".date('Y-m-d H:i:s')."', te_student_batch_id_c='".$student_batch_id."',date_of_payment='".date('Y-m-d')."', amount='".$studentPayment['total']."', reference_number='Transferred Payment', payment_type='Transfer', payment_realized=1, transaction_id='0', payment_source='batch Id:".$old_batch_id."'";
$GLOBALS['db']->Query($insertSql);
#Update relationship record of student payment history
$insertRelSql="INSERT INTO te_student_te_student_payment_1_c SET id='".create_guid()."', 	date_modified='".date('Y-m-d H:i:s')."',deleted=0,te_student_te_student_payment_1te_student_ida='".$student_id."', te_student_te_student_payment_1te_student_payment_idb='".$id."'";
$GLOBALS['db']->Query($insertRelSql);


#unlink old student batch from student
$GLOBALS['db']->query("UPDATE te_student_batch, te_student_te_student_batch_1_c SET te_student_batch.deleted = 1,te_student_te_student_batch_1_c.deleted=1 WHERE te_student_batch.id = te_student_te_student_batch_1_c.te_student_te_student_batch_1te_student_batch_idb AND te_student_te_student_batch_1_c.te_student_te_student_batch_1te_student_ida='".$student_id."' AND te_student_te_student_batch_1_c.te_student_te_student_batch_1te_student_batch_idb='".$old_batch_id."' AND te_student_batch.id='".$old_batch_id."'");

#unlink old student batch plan from student batch
$GLOBALS['db']->query("UPDATE te_student_payment_plan, te_student_batch_te_student_payment_plan_1_c SET te_student_payment_plan.deleted = 1,te_student_batch_te_student_payment_plan_1_c.deleted=1 WHERE te_student_payment_plan.id = te_student_batch_te_student_payment_plan_1_c.te_student9d1ant_plan_idb AND te_student_batch_te_student_payment_plan_1_c.te_student_batch_te_student_payment_plan_1te_student_batch_ida='".$old_batch_id."' AND te_student_payment_plan.te_student_id_c='".$student_id."'");

#unlink old student from student payment for old batch payment 
$GLOBALS['db']->query("UPDATE te_student_payment, te_student_te_student_payment_1_c SET te_student_payment.deleted = 1,te_student_te_student_payment_1_c.deleted=1 WHERE te_student_payment.id = te_student_te_student_payment_1_c.te_student_te_student_payment_1te_student_payment_idb AND te_student_payment.te_student_batch_id_c='".$old_batch_id."' AND statuste_student_te_student_payment_1_c.te_student_te_student_payment_1te_student_ida='".$student_id."'");

#update batch transfer request status 
$GLOBALS['db']->query("UPDATE te_transfer_batch SET status='".$_REQUEST['request_status']."', te_student_batch_id_c='".$student_batch_id."'");
$utmOptions['status']="Transferred";
echo json_encode($utmOptions);
return false;

#update student payment plan
function updateStudentPaymentPlan($batch_id,$student_id,$amount,$student_country){	
	#Service Tax deduction
	global $sugar_config;
	#for Indian student only need to calculate service tax
	if($student_country!="" && ($student_country=="India"||$student_country=="india")){
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

