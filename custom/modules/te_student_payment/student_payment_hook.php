<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
class StudentPayment{
	function updateName($bean, $event, $argument){
		$bean->name=$bean->reference_number;
	}
	function UpdatePaymentDetails($bean, $event, $argument){
		$paidAmount=0;
		$payment_realized=0;
		$student_id=$bean->te_student_te_student_payment_1te_student_ida;
		$studentSql = "SELECT lead_id_c FROM te_student WHERE id='".$student_id."' AND deleted=0";
		$studentObj= $GLOBALS['db']->query($studentSql);
		$studentRes = $GLOBALS['db']->fetchByAssoc($studentObj);
		
		$payment = new te_payment_details();
		$payment->payment_type 	   = $bean->payment_type;
		$payment->payment_source 	   = $bean->payment_source;
		$payment->transaction_id 	   = $bean->transaction_id;
		$payment->date_of_payment  = $bean->date_of_payment;
		$payment->reference_number = $bean->reference_number;
		$payment->amount 		   = $bean->amount;
		$payment->name 		   	   = $bean->amount;
		$payment->payment_realized = $bean->payment_realized;
		$payment->leads_te_payment_details_1leads_ida = $studentRes['lead_id_c'];
		$paidAmount=$payment->amount;
		$payment->save();		
		if($paidAmount>0 && $payment_realized==1)
			$this->updateStudentPaymentPlan($bean->te_student_batch_id_c,$student_id,$paidAmount);
	}
	function updateStudentPaymentPlan($batch_id,$student_id,$amount){
		$paymentPlanSql="SELECT s.name,s.id,s.te_student_id_c,due_amount_inr,paid_amount_inr,paid,s.due_date FROM te_student_batch sb INNER JOIN te_student_batch_te_student_payment_plan_1_c rel ON sb.id=rel.te_student_batch_te_student_payment_plan_1te_student_batch_ida INNER JOIN `te_student_payment_plan` s ON s.id=rel.te_student9d1ant_plan_idb WHERE s.deleted=0 AND s.te_student_id_c='".$student_id."' AND sb.te_ba_batch_id_c='".$batch_id."' ORDER BY s.due_date";
		
		$paymentPlanObj = $GLOBALS['db']->Query($paymentPlanSql);
		$tempAmt=0;
		while($row=$GLOBALS['db']->fetchByAssoc($paymentPlanObj)){
			if($row['due_amount_inr']==$row['paid_amount_inr'])
				continue;
			$restAmt=($row['due_amount_inr']-$row['paid_amount_inr']);
			if($amount>$restAmt){
				$GLOBALS['db']->Query("UPDATE te_student_payment_plan SET paid_amount_inr=paid_amount_inr+".$restAmt.", paid='Yes' WHERE id='".$row['id']."'");
				$amount=$amount-$restAmt;
			}else{
				$GLOBALS['db']->Query("UPDATE te_student_payment_plan SET paid_amount_inr=paid_amount_inr+".$amount." WHERE id='".$row['id']."'");
			}			
		}
	}
}
