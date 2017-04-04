<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
class UpdatePaymentName{
	
	function UpdatePaymentFunc($bean, $event, $argument){
		$lead_id="";		
		if(!empty($bean->name)){
			$sa = "UPDATE te_payment_details SET name='".$bean->reference_number."' WHERE id='".$bean->id."'";
				//~ echo $s;
				$GLOBALS['db']->query($sa);
			//~ $bean->name = $bean->reference_number;
		}
		# if payment details is being updated. Update the same payment in student payment module
		if(isset($_REQUEST['record'])&&$_REQUEST['record']!=""){
			$GLOBALS['db']->query("UPDATE te_student_payment SET amount='".$bean->amount."' WHERE lead_payment_details_id='".$_REQUEST['record']."'");
		}
		
		$leadSql = "SELECT leads_te_payment_details_1leads_ida as lid FROM leads_te_payment_details_1_c WHERE leads_te_payment_details_1te_payment_details_idb = '".$bean->id."' AND deleted = 0";
		$relLead= $GLOBALS['db']->query($leadSql);
		
		if($GLOBALS['db']->getRowCount($relLead) > 0){
			$leadRow = $GLOBALS['db']->fetchByAssoc($relLead);
			$lead_id = $leadRow['lid'];
			$sqlRel = "SELECT p.id FROM te_payment_details p INNER JOIN leads_te_payment_details_1_c lp ON p.id=lp.leads_te_payment_details_1te_payment_details_idb WHERE lp.leads_te_payment_details_1leads_ida='".$leadRow['lid']."' AND p.payment_realized= 0 ";
			//~ echo $sqlRel."<br>";
			$rel= $GLOBALS['db']->query($sqlRel);
			if($GLOBALS['db']->getRowCount($rel) > 0){
				$s = "UPDATE leads SET payment_realized_check=0 WHERE id='".$leadRow['lid']."'";
				//~ echo $s;
				$GLOBALS['db']->query($s);
			}
			else{
				$s = "UPDATE leads SET payment_realized_check=1 WHERE id='".$leadRow['lid']."'";
				//~ echo $s;
				$GLOBALS['db']->query($s);
			}
		}
		if($lead_id!=""){
			
			$paymentSql = "SELECT SUM(p.amount) as amount FROM te_payment_details p INNER JOIN leads_te_payment_details_1_c lp ON p.id=lp.leads_te_payment_details_1te_payment_details_idb WHERE lp.leads_te_payment_details_1leads_ida='".$lead_id."' AND p.payment_realized= 1";
			$paymentObj= $GLOBALS['db']->query($paymentSql);
			$paymentRes=$GLOBALS['db']->fetchByAssoc($paymentObj);
			
			$studentDetails=$this->getStudentId($lead_id);
			$batch_id=$this->getBatchId($lead_id);
			$student_batch_id=$this->getStudentBatchId($studentDetails['id'],$batch_id);
			if($bean->payment_realized==1){				
				$paymentDetails=array(
					'batch_id'=>$batch_id,
					'student_id'=>$studentDetails['id'],
					'amount'=>$paymentRes['amount'],
					'student_country'=>$studentDetails['country'],
					'payment_source'=>$bean->payment_source,
					'student_batch_id'=>$student_batch_id
				);			
				$this->removePaymentPlan($studentDetails['id'],$batch_id,$studentDetails['country']);
		
				$this->updateStudentPaymentPlan($paymentDetails);
			}
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
		$student_batch_id=$paymentDetails['student_batch_id'];

		global $sugar_config;
		#for Indian student only need to calculate service tax
		if(empty($student_country) || $student_country=="india"){

			$service_tax=$sugar_config['tax']['service'];
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
				$GLOBALS['db']->Query("UPDATE te_student_payment_plan SET balance_inr=due_amount_inr-paid_amount_inr WHERE id='".$row['id']."'");
				if($amount==0)
					break;
			}
			#update payment currency as INR
			if($payment_currency==""){
				$GLOBALS['db']->query("UPDATE te_student_payment_plan, te_student_batch_te_student_payment_plan_1_c SET te_student_payment_plan.currency = 'INR' WHERE te_student_payment_plan.id = te_student_batch_te_student_payment_plan_1_c.te_student9d1ant_plan_idb AND te_student_batch_te_student_payment_plan_1_c.te_student_batch_te_student_payment_plan_1te_student_batch_ida='".$student_batch_id."' AND te_student_payment_plan.te_student_id_c='".$student_id."'");
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
			#update payment currency as USD
			if($payment_currency==""){
				$GLOBALS['db']->query("UPDATE te_student_payment_plan, te_student_batch_te_student_payment_plan_1_c SET te_student_payment_plan.currency = 'USD' WHERE te_student_payment_plan.id = te_student_batch_te_student_payment_plan_1_c.te_student9d1ant_plan_idb AND te_student_batch_te_student_payment_plan_1_c.te_student_batch_te_student_payment_plan_1te_student_batch_ida='".$student_batch_id."' AND te_student_payment_plan.te_student_id_c='".$student_id."'");
			}
		}
	}
	public function getStudentId($leadId){
		$studentSql = "SELECT id,country FROM te_student WHERE deleted=0 AND lead_id_c='".$leadId."'";
		$studentObj= $GLOBALS['db']->query($studentSql);
		$student = $GLOBALS['db']->fetchByAssoc($studentObj);	
		return $student;
	}
	public function getBatchId($leadId){
		$studentSql = "SELECT te_ba_batch_id_c  FROM leads_cstm WHERE id_c='".$leadId."'";
		$studentObj= $GLOBALS['db']->query($studentSql);
		$student = $GLOBALS['db']->fetchByAssoc($studentObj);	
		return $student['te_ba_batch_id_c'];
	}
	public function getStudentBatchId($student_id,$batch_id){
		$studentBatchSql = "SELECT sb.id as student_batch_id FROM te_student_te_student_batch_1_c sbr INNER JOIN te_student_batch sb ON sbr.te_student_te_student_batch_1te_student_batch_idb=sb.id  WHERE sb.deleted=0 AND sbr.te_student_te_student_batch_1te_student_ida='".$student_id."' AND sb.te_ba_batch_id_c='".$batch_id."'";
		$studentBatchObj= $GLOBALS['db']->query($studentBatchSql);
		$studentBatch = $GLOBALS['db']->fetchByAssoc($studentBatchObj);	
		return $studentBatch['student_batch_id'];
	}
}
