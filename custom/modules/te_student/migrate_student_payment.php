<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
set_time_limit(0); 
ini_set('memory_limit','1024M');
require_once('include/entryPoint.php');

global $db;
$studentDetails=[];
$Insert_student_counter=0;
$studentSql="SELECT id AS migration_id,batch,mobile,email,country,state,payment,payment_tax,payment_mode,payment_date,order_no,paymodes,invoice_no,transaction_id FROM te_migrate_student_part_pay WHERE is_completed=0 limit 0,10";
$studentObj= $GLOBALS['db']->query($studentSql);
while($row=$GLOBALS['db']->fetchByAssoc($studentObj)){
$studentDetails[] =$row;
}

if($studentDetails){
  $i = 0;
  foreach ($studentDetails as $key => $value) {
   $lead_detail = __get_lead_details(trim($value['email']),trim($value['mobile']),trim($value['batch'])); 
   if($lead_detail){
	$studentDetails[$i]['lead_details'] = $lead_detail;
	$get_student =  __get_student_details($lead_detail['id']);
        if($get_student){
		$studentDetails[$i]['student_details'] = $get_student;
		$get_total_pay =  __get_lead_payments($lead_detail['id']);
		$studentDetails[$i]['total_payment'] = (isset($get_total_pay['amount'])) ? $get_total_pay['amount'] :0;
		$totalPayment = $studentDetails[$i]['total_payment'] + $studentDetails[$i]['payment'] + $studentDetails[$i]['payment_tax'];
		$currentPayment = $studentDetails[$i]['payment'] + $studentDetails[$i]['payment_tax'];
		  //echo "<pre>";print_r($studentDetails);exit();
		  $id=create_guid();
		  //echo $currentPayment;exit();
                  $payment = new te_payment_details();
                  $payment->payment_type 	   = $studentDetails[$i]['payment_mode'];
                  $payment->payment_source 	   = $studentDetails[$i]['paymodes'];
                  $payment->transaction_id 	   = $studentDetails[$i]['transaction_id'];
                  $payment->date_of_payment        = $studentDetails[$i]['payment_date'];
		  $payment->invoice_order_number   = $studentDetails[$i]['order_no'];
                  $payment->invoice_number         = $studentDetails[$i]['invoice_no'];
		  $payment->is_sent_web  = 1;
                  $payment->amount 		   = $currentPayment;
                  $payment->name 		   = $currentPayment;
                  $payment->payment_realized = 1;
                  $payment->leads_te_payment_details_1leads_ida = $studentDetails[$i]['lead_details']['id'];
                  $payment->student_payment_id = $id;
                  $payment->save();

                  $lead_payment_details_id=$payment->id;
                  $payment_realized=1;
                  $student_id=$studentDetails[$i]['student_details']['s_id'];
		  $student_batch_id=$studentDetails[$i]['student_details']['sb_id'];
                  $student_country=$studentDetails[$i]['student_details']['country'];
                  $transaction_id=$payment->transaction_id;

                  $date_of_payment=$payment->date_of_payment;
                  $payment_type=$payment->payment_type;
                  $payment_source=$payment->payment_source;
		  //echo $studentDetails[$i]['student_details']['country'];exit();
                  $insertSql="INSERT INTO te_student_payment SET id='".$id."',lead_payment_details_id='".$lead_payment_details_id."', name='".$currentPayment."', date_entered='".date('Y-m-d H:i:s')."', date_modified='".date('Y-m-d H:i:s')."', te_student_batch_id_c='".$student_batch_id."',date_of_payment='".$date_of_payment."', amount='".$currentPayment."', reference_number='".$reference_number."', payment_type='".$payment_type."', payment_realized=1, transaction_id='".$transaction_id."', payment_source='".$payment_source."'";
                  $GLOBALS['db']->Query($insertSql);
                  #Update relationship record of student payment history
                  $insertRelSql="INSERT INTO te_student_te_student_payment_1_c SET id='".create_guid()."', 	date_modified='".date('Y-m-d H:i:s')."',deleted=0,te_student_te_student_payment_1te_student_ida='".$student_id."', te_student_te_student_payment_1te_student_payment_idb='".$id."'";
                  $GLOBALS['db']->Query($insertRelSql);
                  
		  updateStudentPaymentPlan($value['batch'],$student_id,$totalPayment,$student_country);

		  $update_migrate_paymentSql="UPDATE te_migrate_student_part_pay SET is_completed=1 WHERE id='".$value['migration_id']."'";
                  $GLOBALS['db']->Query($update_migrate_paymentSql);
		/*echo '<pre>';
		print_r($studentDetails);
	   	die;*/ 
	}
	else{
	    $update_migrate_studentSql="UPDATE te_migrate_student SET is_completed=3,reason='Student Batch not found' WHERE id='".$value['migration_id']."'";
            $GLOBALS['db']->Query($update_migrate_studentSql);
	}
	
   }
   else{
	$update_migrate_studentSql="UPDATE te_migrate_student SET is_completed=2,reason='lead not found' WHERE id='".$value['migration_id']."'";
        $GLOBALS['db']->Query($update_migrate_studentSql);
   }
	$i++; 
  }
        echo $i.' Record Affected';
}


function __get_student_details($lead_id){
	$get_student_sql = "SELECT s.id AS s_id,sb.id AS sb_id,s.country FROM te_student AS s INNER JOIN te_student_te_student_batch_1_c AS sbr ON sbr.te_student_te_student_batch_1te_student_ida=s.id INNER JOIN te_student_batch AS sb ON sb.id=sbr.te_student_te_student_batch_1te_student_batch_idb AND sb.deleted=0 AND sbr.deleted=0 WHERE sb.leads_id='".$lead_id."' ";
	$get_student_sql_Obj= $GLOBALS['db']->query($get_student_sql);
	$get_student=$GLOBALS['db']->fetchByAssoc($get_student_sql_Obj);
	return $get_student;
}

function __get_lead_payments($lead_id){
	$get_student_sql = "SELECT sum(p.amount)amount FROM te_payment_details AS p INNER JOIN leads_te_payment_details_1_c AS lp ON lp.leads_te_payment_details_1te_payment_details_idb=p.id AND lp.deleted=0 WHERE lp.leads_te_payment_details_1leads_ida='".$lead_id."' AND p.payment_realized=1 ";
	$get_student_sql_Obj= $GLOBALS['db']->query($get_student_sql);
	$get_student=$GLOBALS['db']->fetchByAssoc($get_student_sql_Obj);
	return $get_student;
}

function __get_lead_details($student_email=NULL,$student_mobile=NULL,$batch_id=NULL){
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


#update student payment plan
function updateStudentPaymentPlan($batch_id,$student_id,$amount,$student_country){
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

