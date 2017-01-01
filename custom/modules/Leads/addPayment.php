<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
ini_set("display_errors",0);
class addPaymentClass{
	
	function addPaymentFunc($bean, $event, $argument){
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
			//~ $payment_realized_check    = $bean->payment_realized;
			//~ ,payment_realized_check={$payment_realized_check}
			$payment->save();
			$GLOBALS['db']->query("UPDATE leads SET payment_type='',transaction_id='',payment_source='',date_of_payment='',reference_number='',amount='',payment_realized=''");
			
			$sqlRel = "SELECT p.id FROM te_payment_details p INNER JOIN leads_te_payment_details_1_c lp ON p.id=lp.leads_te_payment_details_1te_payment_details_idb WHERE lp.leads_te_payment_details_1leads_ida='".$bean->id."' AND p.payment_realized= 0 ";
			//~ echo $sqlRel."<br>";
			$rel= $GLOBALS['db']->query($sqlRel);
			if($GLOBALS['db']->getRowCount($rel) > 0){
				$s = "UPDATE leads SET payment_realized_check=0 WHERE id='".$bean->id."'";
				//~ echo $s;
				$GLOBALS['db']->query($s);
			}
			else{
				$s = "UPDATE leads SET payment_realized_check=1 WHERE id='".$bean->id."'";
				//~ echo $s;
				$GLOBALS['db']->query($s);
			}
			//~ die;
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
			}
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
			if($bean->email1=="dec@one.com"){
			//~ echo $sql;					
			}
			
			$re = $GLOBALS['db']->query($sql);
			if($GLOBALS['db']->getRowCount($re)>0){
				//~ $ro = $GLOBALS['db']->fetchByAssoc($re);
				//~ $lid = $ro['id'];
				//~ require_once('include/SugarEmailAddress/SugarEmailAddress.php');
				//~ $emailAddress = new SugarEmailAddress();
				//~ $lead_list = $emailAddress->getRelatedId($bean->email1, 'leads');
				//~ if(is_array($lead_list) && in_array($lid,$lead_list)){
					$bean->status = 'Duplicate';
					$bean->status_description = 'Duplicate';
				//~ }
			}
			$bean->vendor = $utmDetails['vendor'];
			$bean->te_ba_batch_id_c = $utmDetails['batch'];
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
					//~ echo $lid;
					require_once('include/SugarEmailAddress/SugarEmailAddress.php');
					$emailAddress = new SugarEmailAddress();
					$lead_list = $emailAddress->getRelatedId($bean->email1, 'leads');
					//~ print_r($lead_list);
					
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
	
}
