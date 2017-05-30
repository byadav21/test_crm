<?php
require_once ('custom/modules/te_expense_vendor/te_expense_vendor_cls.php');
require_once('modules/te_expense_vendor_approval/te_expense_vendor_approval.php');
require_once('modules/ACLRoles/ACLRole.php');
class clsApproval {
	
	
		function valiDateApproval($bean, $event, $argument){
			
			//echo 'bef';die;
			if($bean->fetched_row['id']){
				global $current_user;
				$objExp=new te_expense_vendor_cls();
				$roles=new ACLRole();
				//echo $bean->id;die;
				$approvers=[];	
				$userRole=$roles->getUserRole($current_user->id,1);	
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
			$uploads_dir = $_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['SCRIPT_NAME']). '/upload/vendors';
			$roles=new ACLRole();
			$objExp=new te_expense_vendor_cls();
			//print_r($_FILES);die;
                    try{
                    $db->query('start transaction');
		    if($_FILES['panpdf_img']['error']==0){				
				$tmp_name = $_FILES["panpdf_img"]["tmp_name"];
				$name = $bean->id.'_pan';
			 
				if(move_uploaded_file($tmp_name, "$uploads_dir/$name")){
					$nameFile=json_encode(array('path'=>$name,'name'=>$_FILES['panpdf_img']['name']));
					$sql="update te_expense_vendor set panpdf='". $nameFile ."' where id='" . $bean->id . "'";
					$db->query($sql);
				}
				 
			}
		    if($_FILES['stax_img']['error']==0){				
				$tmp_name = $_FILES["stax_img"]["tmp_name"];
				$name = $bean->id.'_stax';
				if(move_uploaded_file($tmp_name, "$uploads_dir/$name")){
					$nameFile=json_encode(array('path'=>$name,'name'=>$_FILES['stax_img']['name']));
					$sql="update te_expense_vendor set staxpdf='". $nameFile ."' where id='" . $bean->id . "'";
					$db->query($sql);
				}
			}
		    if($_FILES['gst_img']['error']==0){				
				$tmp_name = $_FILES["gst_img"]["tmp_name"];
				$name = $bean->id.'_gst';
				if(move_uploaded_file($tmp_name, "$uploads_dir/$name")){
					$nameFile=json_encode(array('path'=>$name,'name'=>$_FILES['gst_img']['name']));
					$sql="update te_expense_vendor set gstndoc='". $nameFile ."' where id='" . $bean->id . "'";
					$db->query($sql);
				}
			}
		    if($_FILES['cc_img']['error']==0){				
				$tmp_name = $_FILES["cc_img"]["tmp_name"];
				$name = $bean->id.'_cc';
				if(move_uploaded_file($tmp_name, "$uploads_dir/$name")){
					$nameFile=json_encode(array('path'=>$name,'name'=>$_FILES['cc_img']['name']));
					$sql="update te_expense_vendor set ccheckdoc='". $nameFile ."' where id='" . $bean->id . "'";
					$db->query($sql);
				}
			}
		    if($_FILES['reg_img']['error']==0){				
				$tmp_name = $_FILES["reg_img"]["tmp_name"];
				$name = $bean->id.'_reg';
				if(move_uploaded_file($tmp_name, "$uploads_dir/$name")){
					$nameFile=json_encode(array('path'=>$name,'name'=>$_FILES['reg_img']['name']));
					$sql="update te_expense_vendor set reg_cert='". $nameFile ."' where id='" . $bean->id . "'";
					$db->query($sql);
				}
			}
		 
		 
		 
		 
			if($bean->id){
                                $sql="delete from  te_expense_vendor_approval  where expense_id='" . $bean->id . "'";
                                $db->query($sql);
				$exapprovers = new te_expense_vendor_approval();
				$exapprovers->name='submitter';
				$exapprovers->date_entered=date('Y-m-d H:i:s');	
				$exapprovers->created_by=$current_user->id;
				$exapprovers->deleted=0;
				$exapprovers->assigned_user_id=$current_user->id;
				$exapprovers->expense_id=$bean->id;
				$exapprovers->staus=0;
				$exapprovers->save();//print_r($exapprovers);die;
				
				$roleArr=$roles->getUserRole($current_user->id,1);
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
			$db->query('commit');
		     }catch(Exception $e){
			$db->query('rollback');
		     }
			
			
			
	
		}
	
	
}
