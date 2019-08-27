<?php 
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');
global  $current_user;
global $db;
require_once ('custom/modules/te_expense_vendor/te_expense_vendor_cls.php');
require_once('modules/te_expense_vendor_approval/te_expense_vendor_approval.php');
require_once('modules/ACLRoles/ACLRole.php');

$obkExp= new te_expense_vendor_cls();

if(isset($_POST['type']) && $_POST['type']=='approve' && $_POST['record']){
	$recordId=$obkExp->checkACLDetailView($_POST['record'],$current_user->id);
//print_r($recordId);die;
	if(!$recordId ){
			$response['error']=1;
			$response['msg']='Unauthrozied access!';
	}else{
	  	
	  	if($recordId['staus']!=0){
			$response['error']=1;
			$response['msg']='This vendor has already approved!';
			echo json_encode($response); exit();
		}
	  	
	  	try{
			$db->query('start transaction');
			$exapObj = new te_expense_vendor_approval(); 
			$exapObj->id=$recordId['id'];
			$exapObj->approver=$current_user->id;
			$exapObj->staus=1;
			$exapObj->save();
			
			
			$roles=new ACLRole();
			$objExp=new te_expense_vendor_cls();		
		  
			$roleArr=$roles->getUserRole($current_user->id,1);
			//print_r($roleArr);
			$approvers=$objExp->getAllApprovers('',$roleArr['parent_role']);
	 	       // print_r($approvers);
		      //  die; 
			
			if($approvers && count($approvers)>0){
				foreach($approvers as $appvrs){
					$exapprovers = new te_expense_vendor_approval(); 
					$exapprovers->name='approver';
					$exapprovers->date_entered=date('Y-m-d H:i:s');	
					$exapprovers->created_by=$current_user->id;
					$exapprovers->deleted=0;
					$exapprovers->assigned_user_id=$appvrs['id'];					
					$exapprovers->expense_id=$_POST['record'];
					$exapprovers->staus=0;
					$exapprovers->save();
				}
                                //echo 'Testing.....1....';
                                
                                if($_POST['reason']) $query="update te_expense_vendor set  glcode='". $_POST['reason'] ."' where id='". $_POST['record'] ."'";
                                $db->query($query);
                                if($_POST['cost_center']) $query="update te_expense_vendor set  cost_center='". $_POST['cost_center'] ."' where id='". $_POST['record'] ."'";
				$db->query($query);
                                
			}else{
				//approve all
				//echo 'Testing.....2....';
				$query="update te_expense_vendor_approval set staus=2 where expense_id='". $_POST['record'] ."'";
				$db->query($query);
				$query="update te_expense_vendor set status=2  where id='". $_POST['record'] ."'";
				$db->query($query);
				if($_POST['reason']) $query="update te_expense_vendor set  glcode='". $_POST['reason'] ."' where id='". $_POST['record'] ."'";
                                $db->query($query);
                                if($_POST['cost_center']) $query="update te_expense_vendor set  cost_center='". $_POST['cost_center'] ."' where id='". $_POST['record'] ."'";
				$db->query($query);				
				
			}			
			
			$db->query('commit');
			$response['error'] =0;
			$response['msg']='This vendor has been approved successfully!';
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
		$userRole=$role->getUserRole($current_user->id,1);
			
		
		$approvers=$obkExp->getAllApprovers('',$userRole['parent_role']);
		
		  
		$inQuery='';
		if($approvers && count($approvers)>0){
			foreach($approvers as $appvrs){
				$inQuery.="'".$appvrs['id']."',";
			}
		}			
		$inQuery=substr($inQuery,0, strlen($inQuery)-1);
		
		if(!$obkExp->getStatusForEdit($_POST['record'],$inQuery)){
			$response['error']=1;
			$response['msg']='This vendor can\'t be cancel!';
			echo json_encode($response); exit();			
		}
		 
		 
		 
		
		try{
			$db->query('start transaction');
			$exapObj = new te_expense_vendor_approval(); 
			$exapObj->id=$recordId['id'];
			$exapObj->approver=$current_user->id;
			$exapObj->staus=3;
			$exapObj->reason=$_POST['reason'];
			$exapObj->save();
			
				$query="update te_expense_vendor_approval set staus=3 where expense_id='". $_POST['record'] ."'";
				$db->query($query);
				
				$sttusChange = new te_expense_vendor();
				$sttusChange->id=$_POST['record'];
				$sttusChange->reason_rejection=$_POST['reason'];
				$sttusChange->status=3;
				$sttusChange->save();	
				
			$db->query('commit');
			$response['error'] =0;
			$response['msg']='This vendor has been cancelled successfully!';
			
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
			$response['msg']='This vendor has already rejected!';
			echo json_encode($response); exit();
		}
		
		try{
			$db->query('start transaction');
			$exapObj = new te_expense_vendor_approval(); 
			$exapObj->id=$recordId['id'];
			$exapObj->approver=$current_user->id;
			$exapObj->staus=-1;
			$exapObj->reason=$_POST['reason'];
			$exapObj->save();
			
				$query="update te_expense_vendor_approval set staus=-1 where expense_id='". $_POST['record'] ."'";
				$db->query($query);
				
				$sttusChange = new te_expense_vendor();
				$sttusChange->id=$_POST['record'];
				$sttusChange->reason_rejection=$_POST['reason'];
				$sttusChange->status=0;
				$sttusChange->save();	
				
			$db->query('commit');
			$response['error'] =0;
			$response['msg']='This vendor has been rejected successfully!';
			
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

