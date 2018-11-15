<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
set_time_limit(0); 
ini_set('memory_limit','1024M');
require_once('include/entryPoint.php');

global $db;
$studentSql="SELECT id AS migration_id,name,batch_code,mobile,email,currency,batch_id FROM te_migrate_student WHERE is_completed=0 AND is_payment_deleted=0 limit 0,100";
$studentObj= $GLOBALS['db']->query($studentSql);
while($row=$GLOBALS['db']->fetchByAssoc($studentObj)){
$studentDetails[] =$row;
}

if($studentDetails){
  foreach ($studentDetails as $key => $value) {
   $lead_detail = __get_lead_details(trim($value['email']),trim($value['mobile']),trim($value['batch_id']));
   if($lead_detail){
	$imp = implode(",",$lead_detail);
	$GLOBALS['db']->Query("UPDATE leads_te_payment_details_1_c SET deleted = 4 WHERE leads_te_payment_details_1leads_ida IN ($imp) ");

	$GLOBALS['db']->Query("UPDATE te_student_batch SET deleted=4 WHERE leads_id IN ($imp)");

	$GLOBALS['db']->Query("UPDATE te_migrate_student SET is_payment_deleted=1 WHERE id='".$value['migration_id']."'");
   }
   else{
	$GLOBALS['db']->Query("UPDATE te_migrate_student SET is_payment_deleted=4 WHERE id='".$value['migration_id']."'");
   }
  }
}


function __get_lead_details($student_email=NULL,$student_mobile=NULL,$batch_id=NULL){
 	$get_lead_sql = "SELECT leads.id FROM leads INNER JOIN leads_cstm ON leads.id=leads_cstm.id_c WHERE leads.deleted=0 AND te_ba_batch_id_c='".$batch_id."' and (email_add_c='".$student_email."' or phone_mobile='".$student_mobile."')";
	$get_lead_sql_Obj= $GLOBALS['db']->query($get_lead_sql);
	$leadArr = [];
	while($get_lead=$GLOBALS['db']->fetchByAssoc($get_lead_sql_Obj)){
		$leadArr[]="'".$get_lead['id']."'";
	}
	return $leadArr;
}
