<?php 
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');
global  $current_user;
global $db;

require_once('modules/ACLRoles/ACLRole.php');
require_once('custom/modules/te_ExpencePoPayment/te_ExpencePoPaymentprOverride.php');

$role=new ACLRole();
$userRole=$role->getUserRole($current_user->id);
if($userRole['isfacility']!=1){
	$response['error']=1;
	$response['msg']='You can\'t approve this invoice!';
	echo json_encode($response); exit();
}

$obkExp= new te_ExpencePoPaymentprOverride();
$record=base64_decode($_POST['record']);
 
if(isset($_POST['type']) && $_POST['type']=='approve' && $record){
	$recordId=$obkExp->retrieve($record);
     
	if(!$recordId ){
			$response['error']=1;
			$response['msg']='Unauthrozied access!';
	}else{
	  	 
	  	if($recordId->status_c!=1){
			$response['error']=1;
			$response['msg']='This invoice can\'t be approved!';
			echo json_encode($response); exit();
		}
	  	
	  	try{
			$db->query('start transaction');
			 
			$obkExp->id=$record;		
			$obkExp->status_c=2;
			$obkExp->save();
			
			$db->query('commit');
			$response['error'] =0;
			$response['msg']='This invoice has been approved successfully!';
	   }catch(Exception $e){
		    $db->query('rollback');
		   	$response['error'] =1;
			$response['msg']='Something gone wrong. Please try agaain!';
		   
	   }
	}
	
	

	
}else if(isset($_POST['type']) && $_POST['type']=='reject' && $record){
	
	
	$recordId=$obkExp->retrieve($record);
	if(!$recordId ){
			$response['error']=1;
			$response['msg']='Unauthrozied access!';
	}else{
	  	
	  	if($recordId->status_c!=1){
			$response['error']=1;
			$response['msg']='This invoice can\'t be rejected!';
			echo json_encode($response); exit();
		}
	  	
	  	try{
			$db->query('start transaction');
			 
			$obkExp->id=$record;		
			$obkExp->status_c=0;
			$obkExp->reject_reason_c=$_POST['reason'];
			$obkExp->save();
			
			$db->query('commit');
			$response['error'] =0;
			$response['msg']='This invoice has been rejected successfully!';
	   }catch(Exception $e){
		    $db->query('rollback');
		   	$response['error'] =1;
			$response['msg']='Something gone wrong. Please try agaain!';
		   
	   }
	}	
	
	
	
}else{
	$response['error'] =1;
	$response['msg']='Unauthrozied access!';
	
}

echo json_encode($response); exit();

