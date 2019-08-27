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
	 
		 $error     = 'You are not authorised to add Payment';	 
		 
	}else if(isset($_POST['record']) && $_POST['record'] ){
		$status=te_Expenseproverride::getStatus($_POST['record'],$current_user->id,1);
		if($status!=2){		 
			$error     = 'Payment can\'t be added in this PO';	 
		}else{
			$podetail= $exprObj->retrieve($_POST['record']);
			 
			if($podetail->porequired=='yes' && $podetail->podocument==''){
					$error     = 'Payment can\'t be added in this PO untill PO not added';	
			}	
		}	
		
	}
	
	if($paymentObj->getLastPayment($_POST['record'])){
		 
		$error     = 'Payment can\'t be added you already added last payment';	
	}else{
		//check total amount
		 
		$totalraised=$paymentObj->getRaisedPayment($_POST['record']); 
		
		if(floatval($totalraised)>0){		
			if( (floatval($_POST['data']['amount'])+floatval($_POST['data']['tax']))  > (floatval($podetail->amount) - floatval($totalraised))){
				
					$error     = 'You can\'t add more then PO total amount';	
			}	
		}
	}



if($error){
  echo json_encode(['error'=>1, 'msg'=>$error]); exit()	;
}
try{
	$dataObj=[];
	
	//$paymentObj->date_entered=false;
	//$paymentObj->name=$dataObj['name']=date('Y-m-d',strtotime($_POST['data']['date_entered']));	
	$paymentObj->date_entered_c=$dataObj['date_entered']=date('Y-m-d',strtotime($_POST['data']['date_entered']));	 
	$paymentObj->amount=$dataObj['amount']=floatval($_POST['data']['amount']);	 
	$paymentObj->tax=$dataObj['tax']=floatval($_POST['data']['tax']);	 
	$paymentObj->is_last_payment=$dataObj['is_last_payment']=$_POST['data']['is_last_payment'];	 
	$paymentObj->taxlabel=$dataObj['taxlabel']=$_POST['data']['taxlabel'];	 
	$paymentObj->invoice_no=$dataObj['invoice_no']=$_POST['data']['invoice_no'];	 
	$paymentObj->exenseid=$dataObj['exenseid']=$_POST['record']; 
	$paymentObj->status_c=1;
	$paymentObj->invocedocs_c=json_encode($_POST['invoice']);
	$paymentObj->assigned_user_id=$current_user->id;
	$paymentObj->save();
	$dataObj['lastpaym']=($_POST['data']['is_last_payment']==1)?'Yes':'';
	$dataObj['id']=$paymentObj->id;
	$dataObj['amtTotal']=floatval($dataObj['amount']) + floatval($dataObj['tax']);
	echo json_encode(['error'=>0, 'msg'=>'Payment has been successfully added','obj'=>['data'=>$dataObj]]); exit();
}catch(Exception $e){
	echo json_encode(['error'=>1, 'msg'=>'something gone wrong. Please try agagin']); exit();
}	
	
