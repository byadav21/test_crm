<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
ini_set("display_errors",0);
class addStudentPaymentClass{
	
	function makePayment($bean, $event, $argument){		
		if(!isset($_REQUEST['import_module'])&&$_REQUEST['module']!="Import"){
			$paymentInstallmentSql = "SELECT te_installments.* FROM te_installments INNER JOIN te_ba_batch_te_installments_1_c rel ON te_installments.id=rel.te_ba_batch_te_installments_1te_installments_idb WHERE rel.te_ba_batch_te_installments_1te_ba_batch_ida= '".$bean->te_ba_batch_id_c."' ORDER BY te_installments.due_date";
			$installments=array('1'=>'1st','2'=>'2nd','3'=>'3rd','4'=>'4th','5'=>'5th','6'=>'6th','7'=>'7th');			
			$paymentInstallmentObj= $GLOBALS['db']->query($paymentInstallmentSql);
			
			$studentPaymentObj=new te_student_payment_plan();
			$studentPaymentObj->name='Initial Payment';
			$studentPaymentObj->paid='Yes';
			$studentPaymentObj->due_date=$bean->initial_payment_date;;
			$studentPaymentObj->description='Testing';
			$studentPaymentObj->due_amount_inr=$bean->initial_payment_inr;
			$studentPaymentObj->due_amount_usd=$bean->initial_payment_usd;
			$studentPaymentObj->paid_amount_inr=$bean->initial_payment_inr;
			$studentPaymentObj->paid_amount_inr=$bean->initial_payment_usd;
			$studentPaymentObj->te_student_id_c=$bean->te_student_te_student_batch_1te_student_ida;
			$studentPaymentObj->te_student_batch_te_student_payment_plan_1te_student_batch_ida=$bean->id;
			$studentPaymentObj->save();
			$index=1;
			while($paymentInstallments = $GLOBALS['db']->fetchByAssoc($paymentInstallmentObj)){
				$studentPaymentObj=new te_student_payment_plan();
				$studentPaymentObj->name=$installments[$index].' Installment';
				$studentPaymentObj->paid='No';
				$studentPaymentObj->due_date=$paymentInstallments['due_date'];
				$studentPaymentObj->description='Testing';
				$studentPaymentObj->due_amount_inr=$paymentInstallments['payment_inr'];
				$studentPaymentObj->due_amount_usd=$paymentInstallments['payment_usd'];
				$studentPaymentObj->paid_amount_inr=0;
				$studentPaymentObj->paid_amount_inr=0;
				$studentPaymentObj->te_student_id_c=$bean->te_student_te_student_batch_1te_student_ida;	
				$studentPaymentObj->te_student_batch_te_student_payment_plan_1te_student_batch_ida=$bean->id;
				$studentPaymentObj->save();
				unset($studentBatchObj);
				$index++;
			}						
		}
	}		
}
