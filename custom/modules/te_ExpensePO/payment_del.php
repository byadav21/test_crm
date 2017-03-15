<?php
	if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');
	global  $current_user;
	require_once('custom/modules/te_ExpensePO/te_Expenseproverride.php');
	require_once ('modules/ACLRoles/ACLRole.php');
	require_once('modules/te_ExpensePO/te_ExpensePO.php');
	require_once('custom/modules/te_ExpencePoPayment/te_ExpencePoPaymentprOverride.php');

	$role=new ACLRole();
	$exprObj=new te_ExpensePO();
	$userRole=$role->getUserRole($current_user->id);	
	
	$paymentObj= new te_ExpencePoPaymentprOverride();
	if(!isset($userRole['isfacility']) || $userRole['isfacility']!=0){
		 echo '1';
		 $error     = 'You are not authorised to delete Payment';	 
		 
	}else if(isset($_POST['record']) && $_POST['record'] ){
		$status=te_Expenseproverride::getStatus($_POST['record'],$current_user->id,1);
		if($status!=2){		 
			$error     = 'Payment can\'t be deleted in this PO';	 
		}else{
			$podetail= $exprObj->retrieve($_POST['record']);
			 
			if($podetail->porequired=='yes' && $podetail->podocument==''){
					$error     = 'Payment can\'t be deleted in this PO untill PO not added';	
			}	
		}	
		
	}

if($paymentObj->getLastPayment($_POST['record'])){
		 
		$error     = 'Payment can\'t be deleted dueto last payment added';	
}

if($error){
  echo json_encode(['error'=>1, 'msg'=>$error]); exit()	;
}
try{
	
	$dataObj=[];
	if($paymentObj->deletePayment($_POST['record'],$_POST['data'])){
		
		echo json_encode(['error'=>0, 'msg'=>'Payment has been successfully deleted']); exit();
		
	}else{
		echo json_encode(['error'=>1, 'msg'=>'something gone wrong. Please try agagin']); exit();
	} 
	
	
}catch(Exception $e){
	echo json_encode(['error'=>1, 'msg'=>'something gone wrong. Please try agagin']); exit();
}	
	
