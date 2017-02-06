<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
ini_set("display_errors",0);
class addPaymentClass{
	
	function addPaymentFunc($bean, $event, $argument){
		$paidAmount=0;
		$student_id="";
		if(!empty($bean->payment_type)||!empty($bean->date_of_payment)||!empty($bean->reference_number)){
			$payment = new te_payment_details();
			$payment->payment_type 	   = $bean->payment_type;
			$payment->payment_source 	   = $bean->payment_source;
			$payment->transaction_id 	   = $bean->transaction_id;
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
				$duplicateStudentSql = "SELECT id FROM te_student WHERE deleted=0 AND email='".$bean->email1."'";
				$duplicateStudentObj= $GLOBALS['db']->query($duplicateStudentSql);
				#check duplicate student
				if($GLOBALS['db']->getRowCount($duplicateStudentObj) > 0){
					$duplicateStudent = $GLOBALS['db']->fetchByAssoc($duplicateStudentObj);
					$student_id=$duplicateStudent['id'];
					
					$duplicateBatchSql = "SELECT id FROM te_student_batch WHERE deleted=0 AND te_ba_batch_id_c='".$bean->te_ba_batch_id_c."'";
					$duplicateBatchObj= $GLOBALS['db']->query($duplicateBatchSql);				
					if($GLOBALS['db']->getRowCount($duplicateBatchObj) == 0){	#If no duplicate batch	
			
						#create batch of student
						$vendorSql = "SELECT id FROM te_vendor WHERE deleted=0 AND name='".$bean->vendor."'";
						$vendorObj= $GLOBALS['db']->query($vendorSql);
						$vendor = $GLOBALS['db']->fetchByAssoc($vendorObj);
						#get Institute, Program and batch details
						$batchSql = "SELECT b.id as batch_id,b.name as batch_name,b.batch_code,b.fees_inr,b.fees_in_usd,b.initial_payment_inr,b.initial_payment_usd,b.initial_payment_date,p.id as program_id,i.id as institute_id FROM te_ba_batch b INNER JOIN te_pr_programs_te_ba_batch_1_c pbr ON pbr.te_pr_programs_te_ba_batch_1te_ba_batch_idb=b.id INNER JOIN te_pr_programs p ON pbr.te_pr_programs_te_ba_batch_1te_pr_programs_ida=p.id INNER JOIN te_in_institutes_te_ba_batch_1_c bir ON b.id=bir.te_in_institutes_te_ba_batch_1te_ba_batch_idb INNER JOIN te_in_institutes i ON bir.te_in_institutes_te_ba_batch_1te_in_institutes_ida=i.id WHERE b.deleted=0 AND b.id='".$bean->te_ba_batch_id_c."'";
						$batchObj= $GLOBALS['db']->query($batchSql);
						$batchDetails = $GLOBALS['db']->fetchByAssoc($batchObj);
						$studentBatchObj=new te_student_batch();
						$studentBatchObj->name=$batchDetails['batch_name'];
						$studentBatchObj->batch_code=$batchDetails['batch_code'];
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
						$studentBatchObj->te_student_te_student_batch_1te_student_ida=$duplicateStudent['id'];
						$studentBatchObj->save();
					}
					
				}else{
					$duplicateStudent = $GLOBALS['db']->fetchByAssoc($duplicateStudentObj);				
					$studentObj=new te_student();
					$studentObj->name=$bean->first_name." ".$bean->last_name;
					$studentObj->email=$bean->email1;
					$studentObj->mobile=$bean->phone_mobile;
					$studentObj->status='Inactive';
					$studentObj->lead_id_c=$bean->id;
					$studentObj->dob=$bean->birthdate;
					$studentObj->gender=$bean->gender;
					$studentObj->company=$bean->company_c;
					$studentObj->state=$bean->primary_address_state;
					$studentObj->city=$bean->primary_address_city;
					$studentObj->country=$bean->primary_address_country;
					$studentObj->save();				
					$student_id=$studentObj->id;
					#create batch of student
					$vendorSql = "SELECT id FROM te_vendor WHERE deleted=0 AND name='".$bean->vendor."'";
					$vendorObj= $GLOBALS['db']->query($vendorSql);
					$vendor = $GLOBALS['db']->fetchByAssoc($vendorObj);
					#get Institute, Program and batch details
					$batchSql = "SELECT b.id as batch_id,b.name as batch_name,b.batch_code,b.fees_inr,b.fees_in_usd,b.initial_payment_inr,b.initial_payment_usd,b.initial_payment_date,p.id as program_id,i.id as institute_id FROM te_ba_batch b INNER JOIN te_pr_programs_te_ba_batch_1_c pbr ON pbr.te_pr_programs_te_ba_batch_1te_ba_batch_idb=b.id INNER JOIN te_pr_programs p ON pbr.te_pr_programs_te_ba_batch_1te_pr_programs_ida=p.id INNER JOIN te_in_institutes_te_ba_batch_1_c bir ON b.id=bir.te_in_institutes_te_ba_batch_1te_ba_batch_idb INNER JOIN te_in_institutes i ON bir.te_in_institutes_te_ba_batch_1te_in_institutes_ida=i.id WHERE b.deleted=0 AND b.id='".$bean->te_ba_batch_id_c."'";
					$batchObj= $GLOBALS['db']->query($batchSql);
					$batchDetails = $GLOBALS['db']->fetchByAssoc($batchObj);
					$studentBatchObj=new te_student_batch();
					$studentBatchObj->name=$batchDetails['batch_name'];
					$studentBatchObj->batch_code=$batchDetails['batch_code'];
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
					$studentBatchObj->te_student_te_student_batch_1te_student_ida=$student_id;
					$studentBatchObj->save();
				}				
			}
		}
		if($paidAmount>0)
			$this->updateStudentPaymentPlan($bean->te_ba_batch_id_c,$student_id,$paidAmount);
	}
	function updateStudentPaymentPlan($batch_id,$student_id,$amount){
		$paymentPlanSql="SELECT s.name,s.id,s.te_student_id_c,due_amount_inr,paid_amount_inr,paid,s.due_date FROM te_student_batch sb INNER JOIN te_student_batch_te_student_payment_plan_1_c rel ON sb.id=rel.te_student_batch_te_student_payment_plan_1te_student_batch_ida INNER JOIN `te_student_payment_plan` s ON s.id=rel.te_student9d1ant_plan_idb WHERE s.deleted=0 AND s.te_student_id_c='".$student_id."' AND sb.te_ba_batch_id_c='".$batch_id."' ORDER BY s.due_date";
		
		$paymentPlanObj = $GLOBALS['db']->Query($paymentPlanSql);
		$tempAmt=0;
		while($row=$GLOBALS['db']->fetchByAssoc($paymentPlanObj)){
			echo"<br>Amount: ".$amount;
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
	
	function checkDuplicateFunc($bean, $event, $argument){
		ini_set("display_errors",0);
// Save the disposition record when the Lead open from the pusher		
		if(isset($_REQUEST['disposition_id']) && !empty($_REQUEST['disposition_id'])){
			$disposition = new te_disposition();
			$disposition->retrieve($_REQUEST['disposition_id']);
			$disposition->name 		   	 = $_REQUEST['status_d'];
			$disposition->status 		 = $_REQUEST['status_d'];
			$disposition->status_detail = $_REQUEST['status_detail_d'];
			$disposition->description	= $_REQUEST['description_d'];
			$callBack = $_REQUEST['date_of_callback_date_d']." ".$_REQUEST['date_of_callback_hours_d'].":".$_REQUEST['date_of_callback_minutes_d'].":00";;
			$disposition->date_of_callback = $callBack;
			$followup = $_REQUEST['date_of_followup_date_d']." ".$_REQUEST['date_of_followup_hours_d'].":".$_REQUEST['date_of_followup_minutes_d'].":00";
			$disposition->date_of_followup = $followup;
			$prospect = $_REQUEST['date_of_prospect_date_d']." ".$_REQUEST['date_of_prospect_hours_d'].":".$_REQUEST['date_of_prospect_minutes_d'].":00";;
			$disposition->date_of_prospect = $prospect;
			$disposition->te_disposition_leadsleads_ida = $bean->id;
			$disposition_id = $disposition->save();
			
		// Call Resume API	
			$server_ip 		= $GLOBALS['sugar_config']['neox']['server_ip'];
			$event          = "neox_agent_pause";
			$user           = $GLOBALS['current_user']->neox_user;
			$password       = $GLOBALS['current_user']->neox_password;
			$value_pr       = "Resume"; 
			$neoxKey   		= $GLOBALS['sugar_config']['neox']['secret_key'];
			$URL = "http://$server_ip:9090/Neox_DialCenter_API/agent_pause_resume.php?secret_key=".$neoxKey;
			$QUERY_PARAM = "data={\"event\":\"$event\",\"user\":\"$user\",\"value_pr\":\"$value_pr\"}";
			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL,"$URL");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, "$QUERY_PARAM");
			$buffer = curl_exec($ch);
			//~ echo $buffer."----";die;

		}
		
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
				if($bean->assigned_user_id!="")
					$bean->assigned_date=date("Y-m-d");
			}else{
				$lead_bean=$bean->fetched_row['id'];
				if($lead_bean->assigned_user_id!=$bean->assigned_user_id){
					$bean->assigned_date=date("Y-m-d");
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
	
}
