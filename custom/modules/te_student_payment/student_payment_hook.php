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
		$studentSql = "SELECT lead_id_c,country,state FROM te_student WHERE id='".$student_id."' AND deleted=0";
		$studentObj= $GLOBALS['db']->query($studentSql);
		$studentRes = $GLOBALS['db']->fetchByAssoc($studentObj);
		$country    =$studentRes['country'];
                $state      =$studentRes['state'];

		$GetStuBatchSql = "SELECT leads_id FROM te_student_batch WHERE id='".$_REQUEST['te_student_batch_id_c']."' AND deleted=0";
		$GetStuBatchObj= $GLOBALS['db']->query($GetStuBatchSql);
		$GetStuBatchObjRes = $GLOBALS['db']->fetchByAssoc($GetStuBatchObj);

		if(isset($_REQUEST['record'])&&$_REQUEST['record']!=""){
			if($bean->payment_realized==1)
				$payment_realized=1;
			else
				$payment_realized=0;

			$GLOBALS['db']->query("UPDATE te_payment_details SET amount='".$bean->amount."',payment_realized='".$payment_realized."',invoice_number='".$bean->invoice_number."',invoice_url='".$bean->invoice_url."',invoice_order_number='".$bean->invoice_order_number."' WHERE student_payment_id='".$bean->id."'");
		}else{
                    
                             $sqlpaymentState = "SELECT 
                                                s.name,
                                                sp.te_student_batch_id_c AS batch_id ,
                                                sprel.`te_student_te_student_payment_1te_student_ida` AS student_id,
                                                pd.date_of_payment,
                                                pd.amount,
                                                pd.country,
                                                pd.state
                                                FROM `te_student_payment` sp
                                                INNER JOIN `te_payment_details` pd ON pd.student_payment_id=sp.id
                                                INNER JOIN `te_student_batch` sb ON sb.id=sp.te_student_batch_id_c 
                                                INNER JOIN `te_student_te_student_payment_1_c` sprel ON sprel.`te_student_te_student_payment_1te_student_payment_idb`=sp.id
                                                INNER JOIN te_student s ON sprel.`te_student_te_student_payment_1te_student_ida`=s.id
                                                WHERE s.id='".$student_id."'
                                                ORDER BY  pd.`date_entered` DESC limit 1"; 
                                        $stateData    = $GLOBALS['db']->query($sqlpaymentState);
                                        if ($GLOBALS['db']->getRowCount($stateData) > 0)
                                        {
                                            $statedata    = $GLOBALS['db']->fetchByAssoc($stateData);
                                            $state        =$statedata['state'];
                                      
                                        }
                                        /*End of update last state name in payment*/
            
			$payment = new te_payment_details();
			$payment->payment_type 	   = $bean->payment_type;
			$payment->payment_type                        = $bean->payment_type;
            $payment->invoice_number                      = $bean->invoice_number;
            $payment->invoice_order_number                = $bean->invoice_order_number;
            $payment->invoice_url                         = $bean->invoice_url;

			$payment->payment_source 	   = $bean->payment_source;
			$payment->transaction_id 	   = $bean->transaction_id;
			$payment->date_of_payment  = $bean->date_of_payment;
			$payment->reference_number = $bean->reference_number;
			$payment->amount 		   = $bean->amount;
			$payment->name 		   	   = $bean->amount;
			$payment->payment_realized = $bean->payment_realized;
			$payment->leads_te_payment_details_1leads_ida = $GetStuBatchObjRes['leads_id'];
			$paidAmount=$payment->amount;
			$payment_realized=$bean->payment_realized;
			$payment->student_payment_id = $bean->id;
                        $payment->country = $country;
                        $payment->state = $state;
                      
			$payment->save();
			$lead_payment_details_id=$payment->id;
                         /*update last state ID in */
            
        
			#update lead payment if for refference
			$GLOBALS['db']->query("UPDATE te_student_payment SET lead_payment_details_id='".$lead_payment_details_id."' WHERE id='".$bean->id."'");
		}
		if($payment_realized==1){
			$studentBatchSql = "SELECT te_ba_batch_id_c FROM te_student_batch WHERE id='".$bean->te_student_batch_id_c."' AND deleted=0";
			$studentBatchObj= $GLOBALS['db']->query($studentBatchSql);
			$studentBatch = $GLOBALS['db']->fetchByAssoc($studentBatchObj);

			# get total paid amount
			$paymentSql = "SELECT SUM(p.amount) as amount FROM te_payment_details p INNER JOIN leads_te_payment_details_1_c lp ON p.id=lp.leads_te_payment_details_1te_payment_details_idb WHERE lp.leads_te_payment_details_1leads_ida='".$GetStuBatchObjRes['leads_id']."' AND p.payment_realized= 1 AND p.deleted=0";
			$paymentObj= $GLOBALS['db']->query($paymentSql);
			$paymentRes=$GLOBALS['db']->fetchByAssoc($paymentObj);

			$paymentDetails=array(
				'batch_id'=>$studentBatch['te_ba_batch_id_c'],
				'student_id'=>$student_id,
				'amount'=>$paymentRes['amount'],
				'student_country'=>$student_country,
				'payment_source'=>$bean->payment_source
			);
			$this->removePaymentPlan($student_id,$studentBatch['te_ba_batch_id_c'],$student_country);
			$this->updateStudentPaymentPlan($paymentDetails);
		}
	}

	function removePaymentPlan($student_id,$batch_id,$student_country){
		if(empty($student_country) || strtolower($student_country)=="india"){
			$paymentPlanSql="SELECT s.name as student_name,s.email,s.mobile,sb.name as batch_name,sp.name,sp.id,sp.te_student_id_c,sp.due_amount_inr,sp.paid_amount_inr,sp.paid,sp.due_date,sp.currency FROM te_student_batch sb INNER JOIN te_student_batch_te_student_payment_plan_1_c rel ON sb.id=rel.te_student_batch_te_student_payment_plan_1te_student_batch_ida INNER JOIN `te_student_payment_plan` sp ON sp.id=rel.te_student9d1ant_plan_idb INNER JOIN te_student s ON sp.te_student_id_c=s.id WHERE sp.deleted=0 AND sp.te_student_id_c='".$student_id."' AND sb.te_ba_batch_id_c='".$batch_id."' ORDER BY sp.due_date";
			$paymentPlanObj = $GLOBALS['db']->Query($paymentPlanSql);
			while($row=$GLOBALS['db']->fetchByAssoc($paymentPlanObj)){
				$GLOBALS['db']->Query("UPDATE te_student_payment_plan SET paid_amount_inr=0,balance_inr=total_amount,paid='No' WHERE id='".$row['id']."'");
			}
		}else{
			# Payment for non indian student will be on USD
			$paymentPlanSql="SELECT s.name as student_name,s.email,s.mobile,sb.name as batch_name,sp.name,sp.id,sp.te_student_id_c,sp.due_amount_usd,sp.paid_amount_usd,sp.paid,sp.due_date,sp.currency FROM te_student_batch sb INNER JOIN te_student_batch_te_student_payment_plan_1_c rel ON sb.id=rel.te_student_batch_te_student_payment_plan_1te_student_batch_ida INNER JOIN `te_student_payment_plan` sp ON sp.id=rel.te_student9d1ant_plan_idb INNER JOIN te_student s ON sp.te_student_id_c=s.id WHERE sp.deleted=0 AND sp.te_student_id_c='".$student_id."' AND sb.te_ba_batch_id_c='".$batch_id."' ORDER BY sp.due_date";
			$paymentPlanObj = $GLOBALS['db']->Query($paymentPlanSql);
			while($row=$GLOBALS['db']->fetchByAssoc($paymentPlanObj)){
				$GLOBALS['db']->Query("UPDATE te_student_payment_plan SET paid_amount_usd=0,balance_usd=total_amount,paid='No' WHERE id='".$row['id']."'");
			}
		}
	}
	function updateStudentPaymentPlan($paymentDetails){
		#Service Tax deduction
		$amount=$paymentDetails['amount'];
		$student_country=strtolower($paymentDetails['student_country']);
		$batch_id=$paymentDetails['batch_id'];
		$student_id=$paymentDetails['student_id'];
		$payment_source=$paymentDetails['payment_source'];


		global $sugar_config;
		#for Indian student only need to calculate service tax
		if(empty($student_country) || $student_country=="india"){

			 $service_tax=getTaxStatus($student_id); 
			 $tax=(($amount*$service_tax)/100); 
			 #$amount=($amount-$tax); //since tax is already added in fees

			$paymentPlanSql="SELECT s.name as student_name,s.email,s.mobile,sb.name as batch_name,sp.name,sp.id,sp.te_student_id_c,sp.due_amount_inr,sp.paid_amount_inr,sp.paid,sp.due_date,sp.currency FROM te_student_batch sb INNER JOIN te_student_batch_te_student_payment_plan_1_c rel ON sb.id=rel.te_student_batch_te_student_payment_plan_1te_student_batch_ida INNER JOIN `te_student_payment_plan` sp ON sp.id=rel.te_student9d1ant_plan_idb INNER JOIN te_student s ON sp.te_student_id_c=s.id WHERE sp.deleted=0 AND sp.te_student_id_c='".$student_id."' AND sb.te_ba_batch_id_c='".$batch_id."' ORDER BY sp.due_date";

			$paymentPlanObj = $GLOBALS['db']->Query($paymentPlanSql);
			$tempAmt=0;
			$initial_payment=0;
			$student_email="";
			$student_name="";
			$student_mobile="";
			$student_batch="";
			$payment_currency="";
			$paid_amount=$amount;
			while($row=$GLOBALS['db']->fetchByAssoc($paymentPlanObj)){
				$payment_currency=$row['currency'];
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
				$GLOBALS['db']->Query("UPDATE te_student_payment_plan SET balance_inr=due_amount_inr-paid_amount_inr,tax=".$service_tax." WHERE id='".$row['id']."'");
				if($amount==0)
					break;
			}
		}else{
			# Payment for non indian student will be on USD
			$paymentPlanSql="SELECT s.name as student_name,s.email,s.mobile,sb.name as batch_name,sp.name,sp.id,sp.te_student_id_c,sp.due_amount_usd,sp.paid_amount_usd,sp.paid,sp.due_date,sp.currency FROM te_student_batch sb INNER JOIN te_student_batch_te_student_payment_plan_1_c rel ON sb.id=rel.te_student_batch_te_student_payment_plan_1te_student_batch_ida INNER JOIN `te_student_payment_plan` sp ON sp.id=rel.te_student9d1ant_plan_idb INNER JOIN te_student s ON sp.te_student_id_c=s.id WHERE sp.deleted=0 AND sp.te_student_id_c='".$student_id."' AND sb.te_ba_batch_id_c='".$batch_id."' ORDER BY sp.due_date";

			$paymentPlanObj = $GLOBALS['db']->Query($paymentPlanSql);
			$tempAmt=0;
			$initial_payment=0;
			$student_email="";
			$student_name="";
			$student_mobile="";
			$student_batch="";
			$payment_currency="";
			$paid_amount=$amount;

			while($row=$GLOBALS['db']->fetchByAssoc($paymentPlanObj)){
				$payment_currency=$row['currency'];
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
				$GLOBALS['db']->Query("UPDATE te_student_payment_plan SET balance_usd=due_amount_usd-paid_amount_usd WHERE id='".$row['id']."'");
				if($amount==0)
					break;
			}
		}
	}
}
