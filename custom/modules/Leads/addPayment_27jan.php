<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
ini_set("display_errors",0);
require_once('custom/include/Email/sendmail.php'); 
class addPaymentClass{
	
	function addPaymentFunc($bean, $event, $argument){
		$paidAmount=0;
		$student_id="";
		$student_name="";
		$student_email="";
		$student_batch_id="";
		$student_country="";
		if(!empty($bean->payment_type)||!empty($bean->date_of_payment)||!empty($bean->reference_number)){
			$payment = new te_payment_details();
			$payment->payment_type 	   = $bean->payment_type;
			$payment->payment_source   = $bean->payment_source;
			$payment->transaction_id   = $bean->transaction_id;
			$payment->date_of_payment  = $bean->date_of_payment;
			$payment->reference_number = $bean->reference_number;
			$payment->amount 		   = $bean->amount;
			$payment->name 		   	   = $bean->amount;
			$payment->payment_realized = $bean->payment_realized;
			$payment->leads_te_payment_details_1leads_ida = $bean->id;
			$payment->save();	
			
			$paidAmount=$bean->amount;
			$GLOBALS['db']->query("UPDATE leads SET payment_type='',transaction_id='',payment_source='',date_of_payment='',reference_number='',amount='',payment_realized=''");
			
			$sqlRel = "SELECT p.id FROM te_payment_details p INNER JOIN leads_te_payment_details_1_c lp ON p.id=lp.leads_te_payment_details_1te_payment_details_idb WHERE lp.leads_te_payment_details_1leads_ida='".$bean->id."' AND p.payment_realized= 0 ";
			$rel= $GLOBALS['db']->query($sqlRel);
			if($GLOBALS['db']->getRowCount($rel) > 0){
				$s = "UPDATE leads SET payment_realized_check=0 WHERE id='".$bean->id."'";
				$GLOBALS['db']->query($s);
			}else{
				$s = "UPDATE leads SET payment_realized_check=1 WHERE id='".$bean->id."'";
				$GLOBALS['db']->query($s);
			}			
		}
		
		if(!isset($_REQUEST['import_module'])&&$_REQUEST['module']!="Import"){
			#update fee & attendance when record is being created manually 
			$batchSql="SELECT fees_inr,fees_in_usd,minimum_attendance_criteria as minimum_attendance FROM te_ba_batch
			WHERE id='".$bean->te_ba_batch_id_c."' AND deleted=0";
			$batchObj = $bean->db->Query($batchSql);
			$batch = $GLOBALS['db']->fetchByAssoc($batchObj);
			$bean->fee_inr = strstr($batch['fees_inr'],'.',true);
			$bean->fee_usd = strstr($batch['fees_in_usd'],'.',true);
			$bean->minimum_attendance = strstr($batch['minimum_attendance_criteria'],'.',true);
			if($bean->status=='Converted'){
				$bean->converted_date=date("Y-m-d");
				#create student
				$duplicateStudentSql = "SELECT id,name,email,country FROM te_student WHERE deleted=0 AND email='".$bean->email1."'";
				$duplicateStudentObj= $GLOBALS['db']->query($duplicateStudentSql);
				#check duplicate student
				if($GLOBALS['db']->getRowCount($duplicateStudentObj) > 0){
					$duplicateStudent = $GLOBALS['db']->fetchByAssoc($duplicateStudentObj);
					$student_id=$duplicateStudent['id'];
					$student_name=$duplicateStudent['name'];
					$student_email=$duplicateStudent['email'];
					$student_country=$duplicateStudent['country'];
					
					$duplicateBatchSql = "SELECT id FROM te_student_batch WHERE deleted=0 AND te_ba_batch_id_c='".$bean->te_ba_batch_id_c."'";
					$duplicateBatchObj= $GLOBALS['db']->query($duplicateBatchSql);				
					if($GLOBALS['db']->getRowCount($duplicateBatchObj) == 0){	#If no duplicate batch	
			
						#create batch of student
						$vendorSql = "SELECT id FROM te_vendor WHERE deleted=0 AND name='".$bean->vendor."'";
						$vendorObj= $GLOBALS['db']->query($vendorSql);
						$vendor = $GLOBALS['db']->fetchByAssoc($vendorObj);
						#get Institute, Program and batch details
						$batchSql = "SELECT b.id as batch_id,b.name as batch_name,b.batch_code,b.fees_inr,b.fees_in_usd,b.initial_payment_inr,b.initial_payment_usd,b.initial_payment_date,p.id as program_id,i.id as institute_id,b.total_sessions_planned,b.batch_start_date FROM te_ba_batch b INNER JOIN te_pr_programs_te_ba_batch_1_c pbr ON pbr.te_pr_programs_te_ba_batch_1te_ba_batch_idb=b.id INNER JOIN te_pr_programs p ON pbr.te_pr_programs_te_ba_batch_1te_pr_programs_ida=p.id INNER JOIN te_in_institutes_te_ba_batch_1_c bir ON b.id=bir.te_in_institutes_te_ba_batch_1te_ba_batch_idb INNER JOIN te_in_institutes i ON bir.te_in_institutes_te_ba_batch_1te_in_institutes_ida=i.id WHERE b.deleted=0 AND b.id='".$bean->te_ba_batch_id_c."'";
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
						$studentBatchObj->te_vendor_id_c=$vendor['id'];
						$studentBatchObj->status="Active";
						$studentBatchObj->total_session_required=$batchDetails['total_sessions_planned'];
						$studentBatchObj->te_student_te_student_batch_1te_student_ida=$duplicateStudent['id'];
						$studentBatchObj->save();
						#get new student batch id
						$student_batch_id=$studentBatchObj->id;
					}else{
						#get existing student batch id
						$existingStudentBatch=$GLOBALS['db']->fetchByAssoc($duplicateBatchObj);
						$student_batch_id=$existingStudentBatch['id'];
					}
					
				}else{
					$duplicateStudent = $GLOBALS['db']->fetchByAssoc($duplicateStudentObj);				
					$studentObj=new te_student();
					$studentObj->name=$bean->first_name." ".$bean->last_name;
					$studentObj->email=$bean->email1;
					$studentObj->mobile=$bean->phone_mobile;
					$studentObj->status='Active';
					$studentObj->lead_id_c=$bean->id;
					$studentObj->dob=$bean->birthdate;
					$studentObj->gender=$bean->gender;
					$studentObj->company=$bean->company_c;
					$studentObj->state=$bean->primary_address_state;
					$studentObj->city=$bean->primary_address_city;
					$studentObj->country=$bean->primary_address_country;
					$studentObj->save();				
					$student_id=$studentObj->id;
					$student_name=$studentObj->name;
					$student_email=$studentObj->email;
					$student_country=$studentObj->country;
					
					#create batch of student
					$vendorSql = "SELECT id FROM te_vendor WHERE deleted=0 AND name='".$bean->vendor."'";
					$vendorObj= $GLOBALS['db']->query($vendorSql);
					$vendor = $GLOBALS['db']->fetchByAssoc($vendorObj);
					#get Institute, Program and batch details
					$batchSql = "SELECT b.id as batch_id,b.name as batch_name,b.batch_code,b.fees_inr,b.fees_in_usd,b.initial_payment_inr,b.initial_payment_usd,b.initial_payment_date,p.id as program_id,i.id as institute_id,b.total_sessions_planned,b.batch_start_date FROM te_ba_batch b INNER JOIN te_pr_programs_te_ba_batch_1_c pbr ON pbr.te_pr_programs_te_ba_batch_1te_ba_batch_idb=b.id INNER JOIN te_pr_programs p ON pbr.te_pr_programs_te_ba_batch_1te_pr_programs_ida=p.id INNER JOIN te_in_institutes_te_ba_batch_1_c bir ON b.id=bir.te_in_institutes_te_ba_batch_1te_ba_batch_idb INNER JOIN te_in_institutes i ON bir.te_in_institutes_te_ba_batch_1te_in_institutes_ida=i.id WHERE b.deleted=0 AND b.id='".$bean->te_ba_batch_id_c."'";
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
					$studentBatchObj->te_vendor_id_c=$vendor['id'];
					$studentBatchObj->status="Active";
					$studentBatchObj->total_session_required=$batchDetails['total_sessions_planned'];
					$studentBatchObj->te_student_te_student_batch_1te_student_ida=$student_id;
					$studentBatchObj->save();
					#get new student batch id
					$student_batch_id=$studentBatchObj->id;
				}				
			}
		}
		#update student payment history
		$id=create_guid();
		$insertSql="INSERT INTO te_student_payment SET id='".$id."', name='".$bean->reference_number."', date_entered='".date('Y-m-d H:i:s')."', date_modified='".date('Y-m-d H:i:s')."', te_student_batch_id_c='".$student_batch_id."',date_of_payment='".$bean->date_of_payment."', amount='".$bean->amount."', reference_number='".$bean->reference_number."', payment_type='".$bean->payment_type."', payment_realized='".$this->payment_realized."', transaction_id='".$bean->transaction_id."', payment_source='".$bean->payment_source."'";
		$GLOBALS['db']->Query($insertSql);
		#Update relationship record
		$insertRelSql="INSERT INTO te_student_te_student_payment_1_c SET id='".create_guid()."', 	date_modified='".date('Y-m-d H:i:s')."',deleted=0,te_student_te_student_payment_1te_student_ida='".$student_id."', te_student_te_student_payment_1te_student_payment_idb='".$id."'";
		$GLOBALS['db']->Query($insertRelSql);
		
		if($paidAmount>0 && $bean->payment_realized==1){
			$paymentDetails=array(
				'batch_id'=>$bean->te_ba_batch_id_c,
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
			$amount=($amount-$tax);
			
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
					$initial_paymen=1;
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
					if(!$initial_paymen){
						$this->sendWelcomEmail($student_email,$batch_id,$student_id,$student_name,$student_country);
					}
				}else{				
					$GLOBALS['db']->Query("UPDATE te_student_payment_plan SET paid_amount_inr=paid_amount_inr+".$amount." WHERE id='".$row['id']."'");
					$amount=0;
					if(!$initial_paymen){
						$this->sendWelcomEmail($student_email,$batch_id,$student_id,$student_name,$student_country);
					}
				}			
				#update balanced amount
				$GLOBALS['db']->Query("UPDATE te_student_payment_plan SET balance_inr=due_amount_inr-paid_amount_inr WHERE id='".$row['id']."'");
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
			generatePdf($params,"Yes");
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
					$initial_paymen=1;
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
					if(!$initial_paymen){
						$this->sendWelcomEmail($student_email,$batch_id,$student_id,$student_name,$student_country);
					}
				}else{				
					$GLOBALS['db']->Query("UPDATE te_student_payment_plan SET paid_amount_usd=paid_amount_usd+".$amount." WHERE id='".$row['id']."'");
					$amount=0;
					if(!$initial_paymen){
						$this->sendWelcomEmail($student_email,$batch_id,$student_id,$student_name,$student_country);
					}
				}			
				#update balanced amount
				$GLOBALS['db']->Query("UPDATE te_student_payment_plan SET balance_usd=due_amount_usd-paid_amount_usd WHERE id='".$row['id']."'");
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
			generatePdf($params,"Yes");
			
		}	
	}
	
	function checkDuplicateFunc($bean, $event, $argument){
		ini_set("display_errors",0);
		if(isset($_REQUEST['import_module'])&&$_REQUEST['module']=="Import"){				
			#update fee & attendance
			$utmSql="SELECT  u.name as utm,u.te_ba_batch_id_c as batch, v.name as vendor from  te_utm u INNER JOIN te_vendor_te_utm_1_c uvr ON u.id=uvr.te_vendor_te_utm_1te_utm_idb INNER JOIN te_vendor v ON uvr.te_vendor_te_utm_1te_vendor_ida=v.id WHERE uvr.deleted=0 AND u.deleted=0 AND u.name='".$bean->utm."'";
			$utmObj = $bean->db->Query($utmSql);
			$utmDetails = $GLOBALS['db']->fetchByAssoc($utmObj);	
			#check duplicate leads
			$sql = "SELECT leads.id as id FROM leads INNER JOIN leads_cstm ON leads.id = leads_cstm.id_c ";
			if($bean->email1!=""){
				$sql.=" INNER JOIN email_addr_bean_rel ON email_addr_bean_rel.bean_id = leads.id AND email_addr_bean_rel.bean_module ='Leads' ";
				$sql.=" INNER JOIN email_addresses ON email_addresses.id =  email_addr_bean_rel.email_address_id ";
			}			
			$sql .=" WHERE leads.deleted = 0 AND leads_cstm.te_ba_batch_id_c = '".$utmDetails['batch']."' AND DATE(date_entered) = '".date('Y-m-d')."'";
			if($bean->phone_mobile!=""){
				$sql.=" AND leads.phone_mobile = '{$bean->phone_mobile}'";
			}
			if($bean->email1!=""){
				$sql.=" AND email_addresses.email_address='".$bean->email1."'";
			}
			$re = $GLOBALS['db']->query($sql);
			if($GLOBALS['db']->getRowCount($re)>0){
				$bean->status = 'Duplicate';
				$bean->status_description = 'Duplicate';
			}
			$bean->vendor = $utmDetails['vendor'];
			$bean->te_ba_batch_id_c = $utmDetails['batch'];
			$bean->assigned_user_id = 'NULL';
		
		}else{
			if(empty($bean->fetched_row['id'])){
				$sql = "SELECT id FROM leads INNER JOIN leads_cstm ON leads.id = leads_cstm.id_c WHERE leads.deleted = 0 AND leads_cstm.te_ba_batch_id_c = '".$utmDetails['batch']."' AND date_entered LIKE '".date('Y-m-d')."%'";
				if($bean->phone_mobile!=""){
					$sql.=" AND leads.phone_mobile = '{$bean->phone_mobile}'";
				}			
				$re = $GLOBALS['db']->query($sql);
				if($GLOBALS['db']->getRowCount($re)>0){
					$ro = $GLOBALS['db']->fetchByAssoc($re);
					$lid = $ro['id'];
					require_once('include/SugarEmailAddress/SugarEmailAddress.php');
					$emailAddress = new SugarEmailAddress();
					$lead_list = $emailAddress->getRelatedId($bean->email1, 'leads');
					if(is_array($lead_list) && in_array($lid,$lead_list)){
						$bean->status = 'Duplicate';
						$bean->status_description = 'Duplicate';
					}
				}					
			}
		}
	}
	
	function addDispositionFunc($bean, $event, $argument){
		ini_set('display_errors',"off");
		#If record is being created manually
		if(!isset($_REQUEST['import_module'])&&$_REQUEST['module']!="Import"){
			if(($bean->fetched_row['status'] != $bean->status) || ($bean->fetched_row['status_description'] != $bean->status_description) ){
				$disposition = new te_disposition();
				$disposition->status 	   = $bean->status;
				$disposition->status_detail  = $bean->status_description;
				if(isset($bean->note)){
				$disposition->description			 = $bean->note;
				}
				$disposition->date_of_callback			 = $bean->date_of_callback;
				$disposition->date_of_followup			 = $bean->date_of_followup;
				$disposition->date_of_prospect			 = $bean->date_of_prospect;
				$disposition->name 		   	 = $bean->status;
				$disposition->te_disposition_leadsleads_ida 		   	 = $bean->id;
				$disposition->save();
				//~ die;
			}
		}
	}
	function sendWelcomEmail($email,$batch_id,$student_id,$student_name,$student_country){		
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
		$subject="Welcom in batch - ".$batch_name;
		$mail = new NetCoreEmail();			
		$mail->sendEmail($email,$subject,$template);
	}
}
