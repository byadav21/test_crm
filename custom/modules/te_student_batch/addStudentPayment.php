<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php'); 
class addStudentPaymentClass{
	
	function makePayment($bean, $event, $argument){		
		if(!isset($_REQUEST['import_module']) && $_REQUEST['module']=="Leads"){
		    global $sugar_config;
			$service_tax=$sugar_config['tax']['service'];
			
			#If student's batch first time is being created
			$paymentInstallmentSql = "SELECT te_installments.* FROM te_installments INNER JOIN te_ba_batch_te_installments_1_c rel ON te_installments.id=rel.te_ba_batch_te_installments_1te_installments_idb WHERE rel.te_ba_batch_te_installments_1te_ba_batch_ida= '".$bean->te_ba_batch_id_c."' ORDER BY te_installments.due_date";
	
			$installments=array('1'=>'1st','2'=>'2nd','3'=>'3rd','4'=>'4th','5'=>'5th','6'=>'6th','7'=>'7th');			
			$paymentInstallmentObj= $GLOBALS['db']->query($paymentInstallmentSql);
			
			$studentPaymentObj=new te_student_payment_plan();
			$studentPaymentObj->name='Initial Payment';
			$studentPaymentObj->description='Testing';
			$studentPaymentObj->paid='No';
			
			$studentPaymentObj->due_date=$bean->initial_payment_date;
			
			$initial_payment_inr=$bean->initial_payment_inr;
			$tax=(($initial_payment_inr*$service_tax)/100);
			$total_amount=($initial_payment_inr+$tax);
			$studentPaymentObj->fees=$initial_payment_inr;
			$studentPaymentObj->tax=$service_tax;
			$studentPaymentObj->total_amount=$total_amount;
			$studentPaymentObj->due_amount_inr=$total_amount;
			
			$studentPaymentObj->paid_amount_inr=0;
			
			$studentPaymentObj->due_amount_usd=$bean->initial_payment_usd;
			$studentPaymentObj->paid_amount_usd=0;			
			
			$studentPaymentObj->balance_inr=$studentPaymentObj->due_amount_inr;
			$studentPaymentObj->balance_usd=$studentPaymentObj->due_amount_usd;
			
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
				
				$payment_inr=$paymentInstallments['payment_inr'];				
				$tax=(($payment_inr*$service_tax)/100);
				$total_amount=($payment_inr+$tax);
				$studentPaymentObj->fees=$payment_inr;
				$studentPaymentObj->tax=$service_tax;
				$studentPaymentObj->total_amount=$total_amount;
				$studentPaymentObj->due_amount_inr=$total_amount;
				
				$studentPaymentObj->paid_amount_inr=0;
				
				$studentPaymentObj->due_amount_usd=$paymentInstallments['payment_usd'];				
				$studentPaymentObj->paid_amount_usd=0;				
				
				$studentPaymentObj->balance_inr=$studentPaymentObj->due_amount_inr;
				$studentPaymentObj->balance_usd=$studentPaymentObj->due_amount_usd;
			
				$studentPaymentObj->te_student_id_c=$bean->te_student_te_student_batch_1te_student_ida;	
				$studentPaymentObj->te_student_batch_te_student_payment_plan_1te_student_batch_ida=$bean->id;
				$studentPaymentObj->save();
				unset($studentBatchObj);
				$index++;
			}						
		}elseif($_REQUEST['module']=="te_student_batch" &&$bean->status=="Dropout"&&$bean->dropout_status=="Pending"){
			global $db;
			$userSql = "SELECT username as email, CONCAT(first_name,' ',last_name) as name FROM users WHERE deleted=0 AND status='Active' AND designation='BUH'";
			$userObj = $db->query($userSql);
			$user = $db->fetchByAssoc($userObj);

			$recipients=$user['email'];
			$template="<p>Hello ".$user['name']."</p>
						<p>You have assigned one batch for dropout approval request</p>
						<p>Please have a look and take action accordingly</p>
						<p></p><p>Thanks & Regards</p>
						<p>SRM Team</p>";
			$mail = new NetCoreEmail();			
			$mail->sendEmail($recipients,"Batch Dropout Request",$template);
		}
	}		
}
