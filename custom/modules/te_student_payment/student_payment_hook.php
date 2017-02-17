<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php'); 
class StudentPayment{
	function updateName($bean, $event, $argument){
		$bean->name=$bean->reference_number;
	}
	function UpdatePaymentDetails($bean, $event, $argument){
		$paidAmount=0;
		$payment_realized=0;
		$student_id=$_REQUEST['te_student_te_student_payment_1te_student_ida'];		
		$studentSql = "SELECT lead_id_c,country FROM te_student WHERE id='".$student_id."' AND deleted=0";
		$studentObj= $GLOBALS['db']->query($studentSql);
		$studentRes = $GLOBALS['db']->fetchByAssoc($studentObj);
		$student_country=$studentRes['country'];
					
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
		$payment_realized=$bean->payment_realized;
		$payment->save();	
		
		if($paidAmount>0 && $payment_realized==1){
			$studentBatchSql = "SELECT te_ba_batch_id_c FROM te_student_batch WHERE id='".$bean->te_student_batch_id_c."' AND deleted=0";
			$studentBatchObj= $GLOBALS['db']->query($studentBatchSql);
			$studentBatch = $GLOBALS['db']->fetchByAssoc($studentBatchObj);				
			
			$paymentDetails=array(
				'batch_id'=>$studentBatch['te_ba_batch_id_c'],
				'student_id'=>$student_id,
				'amount'=>$paidAmount,
				'student_country'=>$student_country,
				'payment_source'=>$bean->payment_source
			);
			$this->updateStudentPaymentPlan($paymentDetails);
		}
	}
	function updateStudentPaymentPlan($paymentDetails){
		#Service Tax deduction
		$amount=$paymentDetails['amount'];
		$student_country=$paymentDetails['student_country'];
		$batch_id=$paymentDetails['batch_id'];
		$student_id=$paymentDetails['student_id'];
		$payment_source=$paymentDetails['payment_source'];
		
		global $sugar_config;
		#for Indian student only need to calculate service tax
		if($student_country!="" && ($student_country=="India"||$student_country=="india")){
			$service_tax=$sugar_config['tax']['service'];	
			$tax=(($amount*$service_tax)/100);
			#$amount=($amount-$tax);
			
			$paymentPlanSql="SELECT s.name as student_name,s.email,s.mobile,sb.name as batch_name,sp.name,sp.id,sp.te_student_id_c,sp.due_amount_inr,sp.paid_amount_inr,sp.paid,sp.due_date FROM te_student_batch sb INNER JOIN te_student_batch_te_student_payment_plan_1_c rel ON sb.id=rel.te_student_batch_te_student_payment_plan_1te_student_batch_ida INNER JOIN `te_student_payment_plan` sp ON sp.id=rel.te_student9d1ant_plan_idb INNER JOIN te_student s ON sp.te_student_id_c=s.id WHERE sp.deleted=0 AND sp.te_student_id_c='".$student_id."' AND sb.te_ba_batch_id_c='".$batch_id."' ORDER BY sp.due_date";
			
			$paymentPlanObj = $GLOBALS['db']->Query($paymentPlanSql);
			$tempAmt=0;
			$initial_payment=0;
			$student_email="";
			$student_name="";
			$student_mobile="";
			$student_batch="";
			$paid_amount=$amount;
			while($row=$GLOBALS['db']->fetchByAssoc($paymentPlanObj)){
				if($row['due_amount_inr']==$row['paid_amount_inr']){
					$initial_payment=1;
					continue;
				}		
				$student_email=$row['email'];
				$student_name=$row['student_name'];
				$student_mobile=$row['mobile'];
				$student_batch=$row['batch_name'];
				
				$restAmt=($row['due_amount_inr']-$row['paid_amount_inr']);
				if($amount>=$restAmt){
					$GLOBALS['db']->Query("UPDATE te_student_payment_plan SET paid_amount_inr=paid_amount_inr+".$restAmt.", paid='Yes' WHERE id='".$row['id']."'");
					$amount=$amount-$restAmt;
				}else{				
					$GLOBALS['db']->Query("UPDATE te_student_payment_plan SET paid_amount_inr=paid_amount_inr+".$amount." WHERE id='".$row['id']."'");
					$amount=0;
				}			
				#update balanced amount
				$GLOBALS['db']->Query("UPDATE te_student_payment_plan SET balance_inr=due_amount_inr-paid_amount_inr, due_amount_inr=due_amount_inr-paid_amount_inr WHERE id='".$row['id']."'");
				if($amount==0)
					break;
			}			
			require('custom/modules/Leads/fppdf/generateInvoiceFunction.php');
			$params=array(
				'invoice_to' => $student_name, 
				'mobile' => $student_mobile,
				'invoiceNumber' => '1',
				'cost' => $paid_amount,
				'total' => $paid_amount,
				'subtotal' => $paid_amount,
				'tax' => $tax,
				'gross' => ($paid_amount+$tax),
				'program_name' => $student_batch,
				'payment_source' => $payment_source,
				'payment_made' => 'Yes'
			);	
			$filename=generatePdf($params,"Yes");

			$this->sendWelcomEmail($student_email,$batch_id,$student_id,$student_name,$student_country,$filename);
			
			#send welcome email on first payment 				
			if(!$initial_payment){
				$this->sendWelcomEmail($student_email,$batch_id,$student_id,$student_name,$student_country,$filename);
			}else{
				$this->sendInvoice($student_email,$student_name,$filename);
			}
		}else{
			# Payment for non indian student will be on USD
			$paymentPlanSql="SELECT s.name as student_name,s.email,s.mobile,sb.name as batch_name,sp.name,s.idp,sp.te_student_id_c,sp.due_amount_usd,sp.paid_amount_usd,sp.paid,sp.due_date FROM te_student_batch sb INNER JOIN te_student_batch_te_student_payment_plan_1_c rel ON sb.id=rel.te_student_batch_te_student_payment_plan_1te_student_batch_ida INNER JOIN `te_student_payment_plan` sp ON sp.id=rel.te_student9d1ant_plan_idb INNER JOIN te_student s ON sp.te_student_id_c=s.id WHERE sp.deleted=0 AND sp.te_student_id_c='".$student_id."' AND sb.te_ba_batch_id_c='".$batch_id."' ORDER BY sp.due_date";
		
			$paymentPlanObj = $GLOBALS['db']->Query($paymentPlanSql);
			$tempAmt=0;
			$initial_payment=0;
			$student_email="";
			$student_name="";
			$student_mobile="";
			$student_batch="";
			$paid_amount=$amount;
			
			while($row=$GLOBALS['db']->fetchByAssoc($paymentPlanObj)){
				if($row['due_amount_usd']==$row['paid_amount_usd']){
					$initial_payment=1;	#to check initial payment has been done and welcome email has sent
					continue;
				}			
				$student_email=$row['email'];
				$student_name=$row['student_name'];
				$student_mobile=$row['mobile'];
				$student_batch=$row['batch_name'];
				
				$restAmt=($row['due_amount_usd']-$row['paid_amount_usd']);
				if($amount>=$restAmt){
					$GLOBALS['db']->Query("UPDATE te_student_payment_plan SET paid_amount_usd=paid_amount_usd+".$restAmt.", paid='Yes' WHERE id='".$row['id']."'");
					$amount=$amount-$restAmt;
				}else{				
					$GLOBALS['db']->Query("UPDATE te_student_payment_plan SET paid_amount_usd=paid_amount_usd+".$amount." WHERE id='".$row['id']."'");
					$amount=0;
					
				}
				
				#update balanced amount
				$GLOBALS['db']->Query("UPDATE te_student_payment_plan SET balance_usd=due_amount_usd-paid_amount_usd, due_amount_usd=due_amount_usd-paid_amount_usd  WHERE id='".$row['id']."'");
				if($amount==0)
					break;
			}
			require('custom/modules/Leads/fppdf/generateInvoiceFunction.php');
			$params=array(
				'invoice_to' => $student_name, 
				'mobile' => $student_mobile,
				'invoiceNumber' => '1',
				'cost' => $paid_amount,
				'total' => $paid_amount,
				'subtotal' => $paid_amount,
				'tax' => 0,
				'gross' => ($paid_amount),
				'program_name' => $student_batch,
				'payment_source' => $payment_source,
				'payment_made' => 'Yes'
			);	
			$filename=generatePdf($params,"Yes");
	
			#send welcome email on first payment 				
			if(!$initial_payment){
				$this->sendWelcomEmail($student_email,$batch_id,$student_id,$student_name,$student_country,$filename);
			}else{
				$this->sendInvoice($student_email,$student_name,$filename);
			}
		}	
	}
	function sendWelcomEmail($email,$batch_id,$student_id,$student_name,$student_country,$attachment=""){		
		$paymentPlanSql="SELECT sb.name as batch_name,s.name as payment_name,s.id,s.te_student_id_c,s.due_amount_inr,s.paid_amount_inr,s.paid,s.due_date,s.balance_inr,s.due_amount_usd,s.paid_amount_usd,s.balance_usd,s.description as notes FROM te_student_batch sb INNER JOIN te_student_batch_te_student_payment_plan_1_c rel ON sb.id=rel.te_student_batch_te_student_payment_plan_1te_student_batch_ida INNER JOIN `te_student_payment_plan` s ON s.id=rel.te_student9d1ant_plan_idb WHERE s.deleted=0 AND s.te_student_id_c='".$student_id."' AND sb.te_ba_batch_id_c='".$batch_id."' ORDER BY s.due_date";		
		$paymentPlanObj = $GLOBALS['db']->Query($paymentPlanSql);
		
		$template='<p>Hello '.$student_name.'</p>
			<p>Thanks for making payment.Please have a look on your payment details:</p>
			<table cellpadding="0" cellspacing="0" width="100%" border="1">
			<tr height="20">
				<th><strong>Batch</strong></th><th><strong>Payment</strong></th><th><strong>Due Amount</strong></th>
				<th><strong>Paid Amount</strong></th><th><strong>Paid</strong></th><th><strong>Balance Amount</strong></th><th>
				<strong>Notes</strong></th><th><strong>Due Date</strong></th> 
			</tr>';
		$batch_name=0;	
		if($student_country!="" && ($student_country=="India" || $student_country=="india")){
			while($row=$GLOBALS['db']->fetchByAssoc($paymentPlanObj)){
				$batch_name=$row['batch_name'];
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
			}
		}else{
			while($row=$GLOBALS['db']->fetchByAssoc($paymentPlanObj)){
				$batch_name=$row['batch_name'];
				$template.='<tr height="20">
				   <td align="left" valign="top" >'.$row['batch_name'].'</td>
				   <td align="left" valign="top" >'.$row['payment_name'].'</td> 
				   <td align="left" valign="top">'.$row['due_amount_usd'].'</td>		
				   <td align="left" valign="top" >'.$row['paid_amount_usd'].'</td>
				   <td align="left" valign="top">'.$row['paid'].'</td>	
				   <td align="left" valign="top" >'.$row['balance_usd'].'</td> 
				   <td align="left" valign="top">'.$row['notes'].'</td>	
				   <td align="left" valign="top">'.$row['due_date'].'</td>				   
				</tr>';	
			}
		}
		$template.="</table>";
		$subject="Welcome in batch - ".$batch_name;
		$mail = new NetCoreEmail();			
		$mail->sendEmail($email,$subject,$template,$attachment);
	}
	#function to send invoice
	function sendInvoice($email,$student_name,$attachment=""){				
		$template='<p>Hello '.$student_name.'</p>
			<p>Thanks for making payment.Please have a look on attached invoice</p>
			<p>Thanks & Regards</p>
			<p>SRM Team</p>';
			
		$subject="Payment Invoice";
		$mail = new NetCoreEmail();			
		$mail->sendEmail($email,$subject,$template,$attachment);
	}
}
