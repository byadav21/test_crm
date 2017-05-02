<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
ini_set('memory_limit','1024M');
require_once('include/entryPoint.php');
global $db;
$data = json_decode(file_get_contents('php://input'), true);
$error_fields=[];
if(!isset($data['action']) || empty($data['action'])){
	$error_fields['action']=['action field is required.'];
	
}
else{
	if(!isset($data['crm_lead_id']) || empty($data['crm_lead_id'])){
		$error_fields['crm_lead_id']=['crm_lead_id field is required.'];
	}
	if(!isset($data['batch_crm_id']) || empty($data['batch_crm_id'])){
		$error_fields['batch_crm_id']=['batch_crm_id field is required.'];
	}
	if(!isset($data['amount']) || empty($data['amount'])){
		$error_fields['amount']=['amount field is required.'];
		
	}
	if(!isset($data['payment_date']) || empty($data['payment_date'])){
		$error_fields['payment_date']=['payment_date field is required.'];
		
	}
	if(!isset($data['payment_realized']) || empty($data['payment_realized'])){
		$error_fields['payment_realized']=['payment_realized field is required.'];	
	}
	if(!isset($data['payment_source']) || empty($data['payment_source'])){
		$error_fields['payment_source']=['payment_source field is required.'];	
	}
	if(!isset($data['payment_referencenum']) || empty($data['payment_referencenum'])){
		$error_fields['payment_referencenum']=['payment_referencenum field is required.'];	
	}
	if(!isset($data['payment_id']) || empty($data['payment_id'])){
		$error_fields['payment_id']=['payment_id field is required.'];	
	}
	if($data['action']=='update'){
		if(!isset($data['crm_payment_id']) || empty($data['crm_payment_id'])){
			$error_fields['crm_payment_id']=['crm_payment_id field is required.'];	
		}
	}
}

if($error_fields){
	$response_result = array('status' => '400','result' => $error_fields);
	echo json_encode($response_result);
	exit();
}
else{
	$lead_id=$data['crm_lead_id'];
	$batch_id=$data['batch_crm_id'];
	
	/*check valid crm_payment_id in case of update*/
	if($data['action']=='update'){
		$check_payment_sql = "SELECT p.* FROM `leads_te_payment_details_1_c` AS lpr INNER JOIN te_payment_details AS p ON p.id=lpr.`leads_te_payment_details_1te_payment_details_idb` WHERE lpr.`leads_te_payment_details_1te_payment_details_idb` ='".$data['crm_payment_id']."' AND lpr.`leads_te_payment_details_1leads_ida`='".$lead_id."'";
		$check_payment_Obj= $GLOBALS['db']->query($check_payment_sql);
		$check_payment_row=$GLOBALS['db']->fetchByAssoc($check_payment_Obj);
		if(!$check_payment_row){
			$errors=array('type'=>'Invalid crm_payment_id');
			$response_result = array('status' => '0','result' => $errors);
			echo json_encode($response_result);
			exit();
		}
	}
	/*check valid crm_payment_id ends here*/
	
	
	$lead_data = __get_lead_details($lead_id,$batch_id);
	if($lead_data){	
		if(strtolower($data['currency'])=='inr' || empty($lead_data['primary_address_country'])){
          $lead_data['student_country']='india';
        }
        else{
          $lead_data['student_country']=$lead_detail['primary_address_country'];
        }
		$student_email_sql = "SELECT ea.email_address FROM email_addr_bean_rel eabr JOIN email_addresses ea ON (ea.id = eabr.email_address_id) WHERE  eabr.deleted = 0 AND eabr.bean_module='Leads' AND eabr.bean_id='".$lead_data['id']."'";
		$student_email_Obj= $GLOBALS['db']->query($student_email_sql);
		$row=$GLOBALS['db']->fetchByAssoc($student_email_Obj);
		$lead_data['student_email']=$row['email_address'];
		$student_detail = __get_student_id($lead_data);
		$student_batch_detail = __get_student_batch_id($student_detail);
		if($data['action']=='add'){
			$ins_res = insert_payment($student_batch_detail,$student_detail,$data);
			$response_result = array('status' => '1','result' => 'success','payment_id'=>$ins_res);
			echo json_encode($response_result);
			exit();
		}
		else{
			$update_res = update_payment($student_batch_detail,$student_detail,$data,$check_payment_row);
			$response_result = array('status' => '1','result' => 'success','payment_id'=>$update_res);
			echo json_encode($response_result);
			exit();
		}
		
	}
	else{
		$errors=array('type'=>'Invalid Lead with batch id');
		$response_result = array('status' => '0','result' => $errors);
		echo json_encode($response_result);
		exit();
	}
	
}

function insert_payment($student_batch_detail=array(),$student_detail=array(),$data=array()){
	/*$get_student_payment_sql = "SELECT SUM(amount)amount FROM `te_student_payment` WHERE `te_student_batch_id_c`='".$student_batch_detail['batch_id']."' AND deleted=0 AND payment_realized= 1";
	$get_student_payment_Obj= $GLOBALS['db']->query($get_student_payment_sql);
	$row_get_student_payment=$GLOBALS['db']->fetchByAssoc($get_student_payment_Obj);*/
	
	if($data['payment_realized']=='yes'){
		$payment_realized = 1;
		$total_amt=$data['amount'];
	}
	else{
		$payment_realized = 0;
	}
	

	  #update new student payment history
	  $payment_val= $data['amount'];
	  $id=create_guid();
	  $payment = new te_payment_details();
	  $payment->payment_type 	   = 'Online';
	  $payment->payment_source 	   = $data['payment_source'];
	  $payment->transaction_id 	   = $data['payment_referencenum'];
	  $payment->date_of_payment  = $data['payment_date'];
	  $payment->reference_number = $data['payment_referencenum'];
	  $payment->amount 		   = $payment_val;
	  $payment->name 		   	   = $payment_val;
	  $payment->payment_realized = $payment_realized;
	  $payment->leads_te_payment_details_1leads_ida = $student_detail['lead_id'];
	  $payment->student_payment_id = $id;
	  $payment->save();

	  $lead_payment_details_id=$payment->id;
	  $paidAmount=$payment_val;
	  $payment_realized=1;
	  $student_id=$student_detail['id'];
	  $student_batch_id=$student_batch_detail['batch_id'];
	  $transaction_id=$data['payment_referencenum'];
	  $reference_number=$data['payment_referencenum'];
	  $date_of_payment=$data['payment_date'];
	  $payment_type='Online';
	  $payment_source=$data['payment_source'];

	  $insertSql="INSERT INTO te_student_payment SET id='".$id."',lead_payment_details_id='".$lead_payment_details_id."', name='".$paidAmount."', date_entered='".date('Y-m-d H:i:s')."', date_modified='".date('Y-m-d H:i:s')."', te_student_batch_id_c='".$student_batch_id."',date_of_payment='".$date_of_payment."', amount='".$paidAmount."', reference_number='".$reference_number."', payment_type='".$payment_type."', payment_realized=1, transaction_id='".$transaction_id."', payment_source='".$payment_source."'";
	  $GLOBALS['db']->Query($insertSql);
	  #Update relationship record of student payment history
	  $insertRelSql="INSERT INTO te_student_te_student_payment_1_c SET id='".create_guid()."', 	date_modified='".date('Y-m-d H:i:s')."',deleted=0,te_student_te_student_payment_1te_student_ida='".$student_id."', te_student_te_student_payment_1te_student_payment_idb='".$id."'";
	  $GLOBALS['db']->Query($insertRelSql);
	  
	  
		
		
	if($total_amt>0){
		updateStudentPaymentPlan($student_batch_detail['te_ba_batch_id_c'],$student_detail['id'],$total_amt,$student_detail['country']);
	}
	return $lead_payment_details_id;
	
}

function update_payment($student_batch_detail=array(),$student_detail=array(),$data=array(),$check_payment_row=array()){
	if($data['payment_realized']=='yes'){
		$payment_realized = 1;
	}
	else{
		$payment_realized = 0;
	}
	$GLOBALS['db']->query("UPDATE te_payment_details SET amount='".$data['amount']."',payment_realized='".$payment_realized."' WHERE id='".$data['crm_payment_id']."'");
	$GLOBALS['db']->query("UPDATE te_student_payment SET amount='".$data['amount']."',payment_realized='".$payment_realized."' WHERE id='".$check_payment_row['student_payment_id']."'");
	
	$get_student_payment_sql = "SELECT SUM(amount)amount FROM `te_student_payment` WHERE `te_student_batch_id_c`='".$student_batch_detail['batch_id']."' AND deleted=0 AND payment_realized= 1";
	
	$get_student_payment_Obj= $GLOBALS['db']->query($get_student_payment_sql);
	
	$row_get_student_payment=$GLOBALS['db']->fetchByAssoc($get_student_payment_Obj);
	
	$total_amt=$row_get_student_payment['amount'];
	removePaymentPlan($student_detail['id'],$student_batch_detail['te_ba_batch_id_c'],$student_detail['country']);
	updateStudentPaymentPlan($student_batch_detail['te_ba_batch_id_c'],$student_detail['id'],$total_amt,$student_detail['country']);
	return $data['crm_payment_id'];
}

#return student_id with additional details
function __get_student_id($student_arr=array()){
  $find_student_sql = "SELECT s.id,s.name,s.email,s.country FROM te_student as s WHERE s.email='".$student_arr['student_email']."' AND s.deleted=0";
  $find_student_Obj= $GLOBALS['db']->query($find_student_sql);
  $find_student=$GLOBALS['db']->fetchByAssoc($find_student_Obj);
  $state='';
  if(!empty($student_arr['primary_address_state'])){
    $state = $student_arr['primary_address_state'];
  }
  else{
    $state = $student_arr['alt_address_state'];
  }
  if($find_student){

    return array(
      'id'=>$find_student['id'],
      'name'=>$find_student['name'],
      'email'=>$find_student['email'],
      'country'=>$find_student['country'],
      'batch_id'=>$student_arr['batch_id'],
      'lead_id'=>$student_arr['id'],
      'vendor'=>$student_arr['vendor'],
      'student_country'=>$student_arr['student_country'],
      'student_city'=>$student_arr['city_c'],
      'student_state'=>$state
    );
  }
  else{
    $studentObj=new te_student();
    $studentObj->name=$student_arr['first_name']." ".$student_arr['last_name'];
    $studentObj->email=$student_arr['student_email'];
    $studentObj->mobile=$student_arr['phone_mobile'];
    $studentObj->status='Active';
    $studentObj->lead_id_c=$student_arr['id'];
    $studentObj->dob=$student_arr['birthdate'];
    $studentObj->gender=$student_arr['gender'];
    $studentObj->company=$student_arr['company_c'];
    $studentObj->state=$student_arr['primary_address_state'];
    $studentObj->city=$student_arr['primary_address_city'];
    $studentObj->country=$student_arr['student_country'];
    $studentObj->education=$student_arr['education_c'];
    $studentObj->work_experience=$student_arr['work_experience_c'];
    $studentObj->functional_area=$student_arr['functional_area_c'];
    $studentObj->phone_other=$student_arr['phone_other'];
    $studentObj->save();
    return array(
      'id'=>$studentObj->id,
      'name'=>$studentObj->name,
      'email'=>$studentObj->email,
      'country'=>$studentObj->country,
      'batch_id'=>$student_arr['batch_id'],
      'lead_id'=>$student_arr['id'],
      'vendor'=>$student_arr['vendor'],
      'student_country'=>$student_arr['student_country'],
      'student_city'=>$student_arr['city_c'],
      'student_state'=>$state
    );
  }
}

function __get_student_batch_id($student_arr=array()){
  $find_student_batch_sql = "SELECT s.id AS student_id,sb.id AS student_batch_id,sb.te_ba_batch_id_c FROM te_student AS s INNER JOIN te_student_te_student_batch_1_c AS sbr ON sbr.te_student_te_student_batch_1te_student_ida=s.id INNER JOIN te_student_batch AS sb ON sb.id=sbr.te_student_te_student_batch_1te_student_batch_idb WHERE sb.leads_id='".$student_arr['lead_id']."' AND s.deleted=0 AND sb.deleted=0 LIMIT 0,1";
  $find_student_batch_Obj= $GLOBALS['db']->query($find_student_batch_sql);
  $find_student_batch=$GLOBALS['db']->fetchByAssoc($find_student_batch_Obj);
  if($find_student_batch){
    return array(
      'batch_id'=>$find_student_batch['student_batch_id'],
      'te_ba_batch_id_c'=>$find_student_batch['te_ba_batch_id_c']
    );
  }
  else{
    #create batch of student
    $vendorSql = "SELECT id FROM te_vendor WHERE deleted=0 AND name='".$student_arr['vendor']."'";
    $vendorObj= $GLOBALS['db']->query($vendorSql);
    $vendor = $GLOBALS['db']->fetchByAssoc($vendorObj);
    #get Institute, Program and batch details
    $batchSql = "SELECT b.id as batch_id,b.name as batch_name,b.batch_code,b.fees_inr,b.fees_in_usd,b.initial_payment_inr,b.initial_payment_usd,b.initial_payment_date,p.id as program_id,i.id as institute_id,b.total_sessions_planned,b.batch_start_date FROM te_ba_batch b INNER JOIN te_pr_programs_te_ba_batch_1_c pbr ON pbr.te_pr_programs_te_ba_batch_1te_ba_batch_idb=b.id INNER JOIN te_pr_programs p ON pbr.te_pr_programs_te_ba_batch_1te_pr_programs_ida=p.id INNER JOIN te_in_institutes_te_ba_batch_1_c bir ON b.id=bir.te_in_institutes_te_ba_batch_1te_ba_batch_idb INNER JOIN te_in_institutes i ON bir.te_in_institutes_te_ba_batch_1te_in_institutes_ida=i.id WHERE b.deleted=0 AND b.id='".$student_arr['batch_id']."'";
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
    $studentBatchObj->assigned_user_id=getSrmUser($batchDetails['batch_id']);
    $studentBatchObj->total_session_required=$batchDetails['total_sessions_planned'];
    $studentBatchObj->study_kit_address_state=$student_arr['student_state'];
    $studentBatchObj->study_kit_address_city=$student_arr['student_city'];
    $studentBatchObj->study_kit_address_country=$student_arr['student_country'];
    $studentBatchObj->te_student_te_student_batch_1te_student_ida=$student_arr['id'];
    $studentBatchObj->leads_id=$student_arr['lead_id'];
    $studentBatchObj->save();
	
	$disposition = new te_disposition();
	$disposition->status 	   = 'Converted';
	$disposition->status_detail  = 'Converted';
	$disposition->name 		   	 = 'Converted';
	$disposition->te_disposition_leadsleads_ida = $student_arr['lead_id'];
	$disposition->save();
	
	$GLOBALS['db']->query("UPDATE leads SET status='Converted',status_description='Converted' ,converted_date='".date('Y-m-d')."' WHERE id='".$student_arr['lead_id']."'");
    #get new student batch id
    return array(
      'batch_id'=>$studentBatchObj->id,
      'te_ba_batch_id_c'=>$studentBatchObj->te_ba_batch_id_c
    );
  }
}

function __get_lead_details($lead_id=NULL,$batch_id=NULL){
    $get_lead_sql = "SELECT leads.*,leads_cstm.te_ba_batch_id_c AS batch_id FROM leads INNER JOIN leads_cstm ON leads.id=leads_cstm.id_c WHERE leads.id='".$lead_id."' AND leads_cstm.te_ba_batch_id_c='".$batch_id."'";
    $get_lead_sql_Obj= $GLOBALS['db']->query($get_lead_sql);
    $get_lead=$GLOBALS['db']->fetchByAssoc($get_lead_sql_Obj);
    return $get_lead;
}
function getSrmUser($batch_id){
  $srmSql = "SELECT assigned_user_id FROM te_srm_auto_assignment WHERE deleted=0 AND te_ba_batch_id_c='".$batch_id."'";
  $srmObj= $GLOBALS['db']->query($srmSql);
  $srmUser = $GLOBALS['db']->fetchByAssoc($srmObj);
  return $srmUser['assigned_user_id'];
}

#update student payment plan
function updateStudentPaymentPlan($batch_id,$student_id,$amount,$student_country){
	#Service Tax deduction
	global $sugar_config;
	#for Indian student only need to calculate service tax
	if($student_country=="" || strtolower($student_country)=="india"){
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
