<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
ini_set('memory_limit','1024M');
require_once('include/entryPoint.php');
global $db;
$data = json_decode(file_get_contents('php://input'), true);
$error_fields=[];
$discount=' 0';


 $fp = fopen('invoice_API_log_.txt', 'a'); 
            fwrite($fp, print_r($cResponse, TRUE)); 
            fclose($fp);
            
if(!isset($data['action']) || empty($data['action'])){
	$error_fields['action']=['action field is required.'];

}
else{
	/*if(!isset($data['crm_lead_id']) || empty($data['crm_lead_id'])){
		$error_fields['crm_lead_id']=['crm_lead_id field is required.'];
	}*/
	if(!isset($data['email']) || empty($data['email'])){
		$error_fields['email']=['email field is required.'];
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
	$email=$data['email'];
	$mobile=$data['mobile'];

	/*check valid crm_payment_id in case of update*/
	if($data['action']=='update'){
		$check_payment_sql = "SELECT p.* FROM `leads_te_payment_details_1_c` AS lpr INNER JOIN te_payment_details AS p ON p.id=lpr.`leads_te_payment_details_1te_payment_details_idb` WHERE lpr.`leads_te_payment_details_1te_payment_details_idb` ='".$data['crm_payment_id']."'";
		$check_payment_Obj= $GLOBALS['db']->query($check_payment_sql);
		$check_payment_row=$GLOBALS['db']->fetchByAssoc($check_payment_Obj);
		if(!$check_payment_row){
			$errors=array('type'=>'Invalid crm_payment_id');
			$response_result = array('status' => '0','result' => $errors);
			echo json_encode($response_result);
			exit();
		}
	}
	


