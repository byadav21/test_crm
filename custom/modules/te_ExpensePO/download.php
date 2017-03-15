<?php 
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');
global  $current_user;

//Check role for PO upload
require_once('custom/modules/te_ExpensePO/te_Expenseproverride.php');
require_once ('modules/ACLRoles/ACLRole.php');
require_once('modules/te_ExpensePO/te_ExpensePO.php');
ignore_user_abort(true);
set_time_limit(0); // disable the time limit for this script

//check PO is approved for upload PO
 
if(isset($_REQUEST['records']) && $_REQUEST['records'] ){
	
	if($_REQUEST['type']=='invoice'){
		require_once('custom/modules/te_ExpencePoPayment/te_ExpencePoPaymentprOverride.php');
		$obkExp= new te_ExpencePoPaymentprOverride(); 
		$recordId=$obkExp->retrieve($_REQUEST['records']);
		$status=te_Expenseproverride::getStatus($recordId->exenseid,$current_user->id,1);		
		if($status==2){
			$poDoc=json_decode(htmlspecialchars_decode($recordId->invocedocs_c));
			$fname=$poDoc[0];
			$file_url = 'upload/po_invoce/'.$fname->filename;
			header('Content-Type: application/octet-stream');
			header("Content-Transfer-Encoding: Binary"); 
			header("Content-disposition: attachment; filename=\"" . $fname->orgname . "\""); 
			readfile($file_url);
			exit(); 
			
		}
		
		
	}else{
	
		
		$status=te_Expenseproverride::getStatus($_REQUEST['records'],$current_user->id,1);
		if(($status!=-2 && isset($_REQUEST['type']) && $_REQUEST['type']=='attch') || $current_user->is_admin){
						$podetail= te_Expenseproverride::getPO($_REQUEST['records']);
						$poDoc=json_decode(htmlspecialchars_decode($podetail['documents']));
						$fname=$poDoc[intval($_REQUEST['id'])];
						$file_url = 'upload/po_files/'.$fname->name;
						header('Content-Type: application/octet-stream');
						header("Content-Transfer-Encoding: Binary"); 
						header("Content-disposition: attachment; filename=\"" . $fname->nameOrg . "\""); 
						readfile($file_url); 
		}
			
		if(($status==2 && !isset($_REQUEST['type']) )   || $current_user->is_admin){
			$podetail= te_Expenseproverride::getPO($_REQUEST['records']);
			
			if($podetail['porequired']=='yes'){
				
					 if(isset($_REQUEST['id'])  ){
						 
						 $poDoc=json_decode(htmlspecialchars_decode($podetail['podocument']));
						 $fname=$poDoc[intval($_REQUEST['id'])];
						 $file_url = 'upload/po_doc/'.$fname->file;
							header('Content-Type: application/octet-stream');
							header("Content-Transfer-Encoding: Binary"); 
							header("Content-disposition: attachment; filename=\"" . $fname->orgname . "\""); 
							readfile($file_url);
						 
					 }else{
						 
						 $poDoc=json_decode(htmlspecialchars_decode($podetail['podocument']));
						 $fname=$poDoc[intval($_REQUEST['id'])];
						 $file_url = 'upload/po_doc/'.$fname->file;
							header('Content-Type: application/octet-stream');
							header("Content-Transfer-Encoding: Binary"); 
							header("Content-disposition: attachment; filename=\"" . $fname->orgname . "\""); 
							readfile($file_url);
						 
					 }	
				 
				
				
			}else{
				
					 echo '<h1>No PO found!</h1>';
				
			}
			
		}
	}
	
}else{
 
	  echo '<h1>You are not authorised to download PO</h1>';
}



