<?php 
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');
global  $current_user;
global $db;
require_once('custom/modules/te_ExpensePO/te_Expenseproverride.php');
require_once('modules/te_Expense_approvall/te_Expense_approvall.php');
require_once('modules/ACLRoles/ACLRole.php');
require_once('modules/te_ExpensePO/te_ExpensePO.php');

$obkExp= new te_Expenseproverride();

if(isset($_POST['type']) && $_POST['type']=='approve' && $_POST['record']){
	$recordId=$obkExp->checkACLDetailView($_POST['record'],$current_user->id);
	if(!$recordId ){
			$response['error']=1;
			$response['msg']='Unauthrozied access!';
	}else{
	  	
	  	if($recordId['staus']!=0){
			$response['error']=1;
			$response['msg']='This PO has already approved!';
			echo json_encode($response); exit();
		}
	  	
	  	try{
			$db->query('start transaction');
			$exapObj = new te_Expense_approvall(); 
			$exapObj->id=$recordId['id'];
			$exapObj->approver=$current_user->id;
			$exapObj->staus=1;
			$exapObj->save();
			
			
			$roles=new ACLRole();
			$objExp=new te_Expenseproverride();		
			$department=$current_user->rel_fields_before_value['te_department_expense_users_1te_department_expense_ida'];  
			$roleArr=$roles->getUserRole($current_user->id);
			//print_r($roleArr);
		 if(isset($_POST['facility']) && $_POST['facility']==1){
			 $approvers=$objExp->getFacilityApprovers($roleArr['parent_role'],1,0); 
		 }else{
			
			if($roleArr['parent_role'] &&  $roleArr['sendtofin']==0 && $roleArr['isfacility']==0){// for submitter and approver  
                               
                                 $parentRole=$roles->retrieve($roleArr['parent_role']);
                                 if($parentRole->parent_role==null || $parent_role->parent_role=='-Select-'){
                                     $approvers=$objExp->getAllApprovers($department,$roleArr['parent_role']);
                                 }else{

                                   $approvers=$objExp->getAllApprovers('',$roleArr['parent_role']);
                                 }
	


			}else if($roleArr['isfacility']>0){ // for fin
				
					$approvers=$objExp->getFacilityApprovers($roleArr['parent_role'],2,1);
				
			}else if($roleArr['sendtofin']==1 ){ // for ceo
				$approvers=$objExp->getFacilityApprovers($roleArr['parent_role'],1,0); 
			}
	   }		
		 
                        //print_r($approvers);die; 			
			if($approvers && count($approvers)>0){
				foreach($approvers as $appvrs){
					$exapprovers = new te_Expense_approvall(); 
					$exapprovers->name='approver';
					$exapprovers->date_entered=date('Y-m-d H:i:s');	
					$exapprovers->created_by=$current_user->id;
					$exapprovers->deleted=0;
					$exapprovers->assigned_user_id=$appvrs['id'];					
					$exapprovers->expense_id=$_POST['record'];
					$exapprovers->staus=0;
					$exapprovers->save();
				}
			}else{
				//approve all
				
				$query="update te_expense_approvall set staus=2 where expense_id='". $_POST['record'] ."'";
				$db->query($query);
				$query="update te_expensepo set status=2 where id='". $_POST['record'] ."'";
				$db->query($query);				
				
			}			
			
			$db->query('commit');
			$response['error'] =0;
			$response['msg']='This PO has been approved successfully!';
	   }catch(Exception $e){
		    $db->query('rollback');
		   	$response['error'] =1;
			$response['msg']='Something gone wrong. Please try agaain!';
		   
	   }
	}
	
	
}else if(isset($_POST['type']) && $_POST['type']=='cancel' && $_POST['record']){
	
	
	$recordId=$obkExp->checkACLDetailViewSubmitter($_POST['record'],$current_user->id);
	if(!$recordId ){
			$response['error']=1;
			$response['msg']='Unauthrozied access!';
	}else{
		
		$role=new ACLRole();
		$userRole=$role->getUserRole($current_user->id);
			
		$department=$current_user->rel_fields_before_value['te_department_expense_users_1te_department_expense_ida']; 
		if($userRole['sendtofin']==1){
			$approvers=$obkExp->getFacilityApprovers($userRole['parent_role'],1,0); 
		}else{
			$approvers=$obkExp->getAllApprovers($department,$userRole['parent_role']);
		}
		  
		$inQuery='';
		if($approvers && count($approvers)>0){
			foreach($approvers as $appvrs){
				$inQuery.="'".$appvrs['id']."',";
			}
		}			
		$inQuery=substr($inQuery,0, strlen($inQuery)-1);
		
		if(!$obkExp->getStatusForEdit($_POST['record'],$inQuery)){
			$response['error']=1;
			$response['msg']='This Po can\'t be cancel!';
			echo json_encode($response); exit();			
		}
		 
		 
		 
		
		try{
			$db->query('start transaction');
			$exapObj = new te_Expense_approvall(); 
			$exapObj->id=$recordId['id'];
			$exapObj->approver=$current_user->id;
			$exapObj->staus=3;
			$exapObj->reason=$_POST['reason'];
			$exapObj->save();
			
				$query="update te_expense_approvall set staus=3 where expense_id='". $_POST['record'] ."'";
				$db->query($query);
				
				$sttusChange = new te_ExpensePO();
				$sttusChange->id=$_POST['record'];
				$sttusChange->reason_rejection=$_POST['reason'];
				$sttusChange->status=3;
				$sttusChange->save();	
				
			$db->query('commit');
			$response['error'] =0;
			$response['msg']='This PO has been cancelled successfully!';
			
		}catch(Exception $e){
		    $db->query('rollback');
		   	$response['error'] =1;
			$response['msg']='Something gone wrong. Please try agaain!';
		   
		}	
		
		
	}	
	
}else if(isset($_POST['type']) && $_POST['type']=='reject' && $_POST['record']){
	
	$recordId=$obkExp->checkACLDetailView($_POST['record'],$current_user->id);
	if(!$recordId ){
			$response['error']=1;
			$response['msg']='Unauthrozied access!';
	}else{
		
		if($recordId['staus']!=0){
			$response['error']=1;
			$response['msg']='This PO has already rejected!';
			echo json_encode($response); exit();
		}
		
		try{
			$db->query('start transaction');
			$exapObj = new te_Expense_approvall(); 
			$exapObj->id=$recordId['id'];
			$exapObj->approver=$current_user->id;
			$exapObj->staus=-1;
			$exapObj->reason=$_POST['reason'];
			$exapObj->save();
			
				$query="update te_expense_approvall set staus=-1 where expense_id='". $_POST['record'] ."'";
				$db->query($query);
				
				$sttusChange = new te_ExpensePO();
				$sttusChange->id=$_POST['record'];
				$sttusChange->reason_rejection=$_POST['reason'];
				$sttusChange->status=0;
				$sttusChange->save();	
				
			$db->query('commit');
			$response['error'] =0;
			$response['msg']='This PO has been rejected successfully!';
			
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

