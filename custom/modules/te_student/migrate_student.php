<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
set_time_limit(0); 
ini_set('memory_limit','1024M');
require_once('include/entryPoint.php');
global $db;
$studentDetails=[];
$Insert_student_counter=0;
$studentSql="SELECT id AS migration_id,name,batch_code,mobile,email,currency,batch_id FROM te_migrate_student WHERE is_completed=0 limit 0,1000";
$studentObj= $GLOBALS['db']->query($studentSql);
while($row=$GLOBALS['db']->fetchByAssoc($studentObj)){
$studentDetails[] =$row;
}

if($studentDetails){
  foreach ($studentDetails as $key => $value) {
   $lead_detail = __get_lead_details(trim($value['email']),trim($value['mobile']),trim($value['batch_id']));
   
  // echo '<pre>';
  // print_r($lead_detail);
  //die; 
    if($lead_detail){

        $lead_detail['student_email']=$value['email'];
        $lead_detail['student_name']=$value['name'];
        $lead_detail['student_mobile']=$value['mobile'];
        $lead_detail['batch_id']=$value['batch_id'];
        $lead_detail['migration_id']=$value['migration_id'];

        if(strtolower($value['currency'])=='inr' || empty($lead_detail['primary_address_country'])){
          $lead_detail['student_country']='india';
        }
        else{
          $lead_detail['student_country']=$lead_detail['primary_address_country'];
        }
        /*echo "<pre>";
        print_r($lead_detail);
        echo "----";*/
        $student_detail = __get_student_id($lead_detail);
        if($student_detail){

          $student_batch_detail = __get_student_batch_id($student_detail);
          if($student_batch_detail){
            $migrate_payment_Data=__get_migrate_student_payment($student_detail);
            if($migrate_payment_Data){
              $amt_arr=[];
              $payment = '';
              foreach ($migrate_payment_Data as $key => $migratevalue) {
                if($migratevalue['payment_mode']=='Online'){
                  $amt_arr[]=$migratevalue['payment_tax'];
                  $payment_val = $migratevalue['payment_tax'];
                }
                else{
                  if($migratevalue['payment_realised']=='yes'){
                    $amt_arr[]=$migratevalue['payment_tax'];
                    $payment_val = $migratevalue['payment_tax'];
                  }
                }
                if($payment_val){
                  #update new student payment history
                  $id=create_guid();
                  $payment = new te_payment_details();
                  $payment->payment_type 	   = $migratevalue['payment_mode'];
                  $payment->payment_source 	   = $migratevalue['payment_mode'];
                  $payment->transaction_id 	   = $migratevalue['order_no'].''.$migratevalue['payment_chqno'].''.$migratevalue['payment_remarks'];
                  $payment->date_of_payment  = $migratevalue['payment_date'];
                  $payment->reference_number = $migratevalue['order_no'].''.$migratevalue['payment_chqno'].''.$migratevalue['payment_remarks'];
                  $payment->amount 		   = $payment_val;
                  $payment->name 		   	   = $payment_val;
                  $payment->payment_realized = 1;
                  $payment->leads_te_payment_details_1leads_ida = $student_detail['lead_id'];
                  $payment->student_payment_id = $id;
                  $payment->save();

                  $lead_payment_details_id=$payment->id;
                  $paidAmount=$payment_val;
                  $payment_realized=1;
                  $student_id=$student_detail['id'];
                  $student_batch_id=$student_batch_detail['batch_id'];
                  $transaction_id=$migratevalue['order_no'].''.$migratevalue['payment_chqno'].''.$migratevalue['payment_remarks'];
                  $reference_number=$migratevalue['order_no'].''.$migratevalue['payment_chqno'].''.$migratevalue['payment_remarks'];
                  $date_of_payment=$migratevalue['payment_date'];
                  $payment_type=$migratevalue['payment_mode'];
                  $payment_source=$migratevalue['payment_mode'];

                  $insertSql="INSERT INTO te_student_payment SET id='".$id."',lead_payment_details_id='".$lead_payment_details_id."', name='".$paidAmount."', date_entered='".date('Y-m-d H:i:s')."', date_modified='".date('Y-m-d H:i:s')."', te_student_batch_id_c='".$student_batch_id."',date_of_payment='".$date_of_payment."', amount='".$paidAmount."', reference_number='".$reference_number."', payment_type='".$payment_type."', payment_realized=1, transaction_id='".$transaction_id."', payment_source='".$payment_source."'";
                  $GLOBALS['db']->Query($insertSql);
                  #Update relationship record of student payment history
                  $insertRelSql="INSERT INTO te_student_te_student_payment_1_c SET id='".create_guid()."', 	date_modified='".date('Y-m-d H:i:s')."',deleted=0,te_student_te_student_payment_1te_student_ida='".$student_id."', te_student_te_student_payment_1te_student_payment_idb='".$id."'";
                  $GLOBALS['db']->Query($insertRelSql);

                  $update_migrate_paymentSql="UPDATE te_migrate_student_payments SET is_completed=1 WHERE id='".$migratevalue['id']."'";
                  $GLOBALS['db']->Query($update_migrate_paymentSql);
                }
              }
              $total_amt = array_sum($amt_arr);
              #update Student PaymentPlan
              if($total_amt>0){
                updateStudentPaymentPlan($student_batch_detail['te_ba_batch_id_c'],$student_detail['id'],$total_amt,$student_detail['country']);
                //echo $total_amt.'<br>';
              }


            }
            $update_migrate_studentSql="UPDATE te_migrate_student SET is_completed=1 WHERE id='".$student_detail['migration_id']."'";
            $GLOBALS['db']->Query($update_migrate_studentSql);
            //echo "<pre>";
            //print_r($student_detail);
            //print_r($student_batch_detail);
            //print_r($migrate_payment_Data);
            //echo create_guid();
          }

        }

    }
  }
}

function __get_migrate_student_payment($student_arr=array()){
  $migrate_student_paymentsql = "SELECT * FROM `te_migrate_student_payments` WHERE student_id=".$student_arr['migration_id']." AND is_completed=0 AND `payment_tax`>0 ORDER BY payment_date ASC";
  $migrate_student_payment_Obj= $GLOBALS['db']->query($migrate_student_paymentsql);
  while($row=$GLOBALS['db']->fetchByAssoc($migrate_student_payment_Obj)){
    $migrate_student_payment[]=$row;
  }
  return $migrate_student_payment;
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
      'migration_id'=>$student_arr['migration_id'],
      'student_country'=>$student_arr['student_country'],
      'student_city'=>$student_arr['city_c'],
      'student_state'=>$state
    );
  }
  else{
    $studentObj=new te_student();
    $studentObj->name=$student_arr['student_name'];
    $studentObj->email=$student_arr['student_email'];
    $studentObj->mobile=$student_arr['student_mobile'];
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
      'migration_id'=>$student_arr['migration_id'],
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
    #get new student batch id
    return array(
      'batch_id'=>$studentBatchObj->id,
      'te_ba_batch_id_c'=>$studentBatchObj->te_ba_batch_id_c
    );
  }
}

function __get_lead_details($student_email=NULL,$student_mobile=NULL,$batch_id=NULL){
 /* $lead_id = '';
  $find_lead_by_email_sql="SELECT eabr.bean_id FROM email_addr_bean_rel eabr INNER JOIN email_addresses ea ON (ea.id = eabr.email_address_id) INNER JOIN leads ON leads.id=eabr.bean_id INNER JOIN leads_cstm ON leads_cstm.id_c=leads.id WHERE eabr.deleted = 0 AND eabr.bean_module='Leads' AND ea.email_address='".$student_email."' AND leads_cstm.te_ba_batch_id_c='".$batch_id."'";
  $find_lead_by_email_Obj= $GLOBALS['db']->query($find_lead_by_email_sql);
  $find_lead_by_email=$GLOBALS['db']->fetchByAssoc($find_lead_by_email_Obj);
  if($find_lead_by_email){
    $lead_id = $find_lead_by_email['bean_id'];
  }
  else{
    $find_lead_by_mobile_sql="SELECT leads.id FROM leads INNER JOIN leads_cstm ON leads_cstm.id_c=leads.id WHERE leads_cstm.te_ba_batch_id_c='".$batch_id."' AND leads.phone_mobile='".$student_mobile."'";
    $find_lead_by_mobile_Obj= $GLOBALS['db']->query($find_lead_by_mobile_sql);
    $find_lead_by_mobile=$GLOBALS['db']->fetchByAssoc($find_lead_by_mobile_Obj);
    if($find_lead_by_mobile){
      $lead_id = $find_lead_by_mobile['id'];
    }
  }
  if($lead_id){
    $get_lead_sql = "SELECT leads.*,leads_cstm.company_c,leads_cstm.functional_area_c,leads_cstm.work_experience_c,leads_cstm.education_c,leads_cstm.city_c,leads_cstm.age_c FROM leads INNER JOIN leads_cstm ON leads.id=leads_cstm.id_c WHERE leads.deleted=0 AND leads.id='".$lead_id."'";
    $get_lead_sql_Obj= $GLOBALS['db']->query($get_lead_sql);
    $get_lead=$GLOBALS['db']->fetchByAssoc($get_lead_sql_Obj);
    return $get_lead;
  }*/
  
  
 	$get_lead_sql = "SELECT leads.*,leads_cstm.company_c,leads_cstm.functional_area_c,leads_cstm.work_experience_c,leads_cstm.education_c,leads_cstm.city_c,leads_cstm.age_c FROM leads INNER JOIN leads_cstm ON leads.id=leads_cstm.id_c WHERE leads.deleted=0 AND   te_ba_batch_id_c='".$batch_id."' and status='Converted' and (email_add_c='".$student_email."' or phone_mobile='".$student_mobile."')";
	
	$get_lead_sql_Obj= $GLOBALS['db']->query($get_lead_sql);
	$get_lead=$GLOBALS['db']->fetchByAssoc($get_lead_sql_Obj);
	if($get_lead){
		return $get_lead;
	}else{
	$get_lead_sql = "SELECT leads.*,leads_cstm.company_c,leads_cstm.functional_area_c,leads_cstm.work_experience_c,leads_cstm.education_c,leads_cstm.city_c,leads_cstm.age_c FROM leads INNER JOIN leads_cstm ON leads.id=leads_cstm.id_c WHERE leads.deleted=0 AND   te_ba_batch_id_c='".$batch_id."' and   (email_add_c='".$student_email."' or phone_mobile='".$student_mobile."')";
		$get_lead_sql_Obj= $GLOBALS['db']->query($get_lead_sql);
		return   $get_lead=$GLOBALS['db']->fetchByAssoc($get_lead_sql_Obj);
   }



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

