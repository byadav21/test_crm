<?php
require_once ('custom/modules/te_expense_vendor/te_expense_vendor_cls.php');
require_once('modules/te_expense_vendor_approval/te_expense_vendor_approval.php');
require_once('modules/ACLRoles/ACLRole.php');
class clsApproval {
	
	
		function valiDateApproval($bean, $event, $argument){
			if($bean->fetched_row['id']){
				global $current_user;
				$objExp=new te_expense_vendor_cls();
				$roles=new ACLRole();
				//echo $bean->id;die;
				$approvers=[];	
				$userRole=$roles->getUserRole($current_user->id);	
				$approvers=$objExp->getAllApprovers('',$userRole['parent_role']);
				
				$inQuery='';
				if($approvers && count($approvers)>0){
					foreach($approvers as $appvrs){
						$inQuery.="'".$appvrs['id']."',";
					}
				}			
				$inQuery=substr($inQuery,0, strlen($inQuery)-1);
				
				if(!$objExp->getStatusForEdit($bean->id,$inQuery)){
							header("Location: index.php?module=te_expense_vendor&action=DetailView&msg=2&record=". $bean->id);	exit();
				}
	
		  } 
			
		}
			
		function updateApproval($bean, $event, $argument){
			global $current_user,$db;
			$roles=new ACLRole();
			$objExp=new te_expense_vendor_cls();
		// echo 'p';die;
			if($bean->id){
				$exapprovers = new te_expense_vendor_approval();
				$exapprovers->name='submitter';
				$exapprovers->date_entered=date('Y-m-d H:i:s');	
				$exapprovers->created_by=$current_user->id;
				$exapprovers->deleted=0;
				$exapprovers->assigned_user_id=$current_user->id;
				$exapprovers->expense_id=$bean->id;
				$exapprovers->staus=0;
				$exapprovers->save();//print_r($exapprovers);die;
				
				$roleArr=$roles->getUserRole($current_user->id);
				$approvers=$objExp->getAllApprovers($department,$roleArr['parent_role']);
				if($approvers && count($approvers)>0){
					foreach($approvers as $appvrs){
						$exapprovers = new te_expense_vendor_approval(); 
						$exapprovers->name='approver';
						$exapprovers->date_entered=date('Y-m-d H:i:s');	
						$exapprovers->created_by=$current_user->id;
						$exapprovers->deleted=0;
						$exapprovers->assigned_user_id=$appvrs['id'];
						
						$exapprovers->expense_id=$bean->id;
						$exapprovers->staus=0;
						$exapprovers->save();
					}
				}
			} 
			$sql="update te_expense_vendor set assigned_user_id='". $current_user->id ."' where id='" . $bean->id . "'";
			$db->query($sql);
				
		 
			
			
			
	
		}
	
	
}
