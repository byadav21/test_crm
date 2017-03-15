<?php 
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');
global  $current_user;

//Check role for PO upload
require_once('custom/modules/te_ExpensePO/te_Expenseproverride.php');
require_once ('modules/ACLRoles/ACLRole.php');
require_once('modules/te_ExpensePO/te_ExpensePO.php');

$role=new ACLRole();
$userRole=$role->getUserRole($current_user->id);
 
if(intval($userRole['isfacility'])==0){
	 $response['success']      = false;
	 $response['message']      = 'You are not authorised to upload PO';	 
	 echo json_encode($response); exit();
}
//check PO is approved for upload PO
 
if(isset($_POST['records']) && $_POST['records'] ){
	
	$status=te_Expenseproverride::getStatus($_POST['records'],$current_user->id,1);
	if($status==2){
		$podetail= te_Expenseproverride::getPO($_POST['records']);
		if($podetail['porequired']=='yes'){
			 
			if(isset($_FILES['qqfile']) && count($_FILES['qqfile'])>0){
	
				if($_FILES['qqfile']['error']>0){
						 $response['success']      = false;
						 $response['message']      = 'Invalid File Type';
				}elseif($_FILES['qqfile']['size']> 1024 * 1024 * 20){
						$response['success']      = false;
						$response['message']      = 'You can upload file upto 20 MB';
				}else{
					  $uploads_dir = $_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['SCRIPT_NAME']);
					  $filename=$current_user->id . '_'. date('ymdHis') . '_po.' . substr(strrchr($PATH, "."), 1); 
					
					if(move_uploaded_file($_FILES['qqfile']['tmp_name'],$uploads_dir .'/upload/po_doc/'.$filename)){
						$response['success']      = true;
						$response['message']      = 'File has been uploaded succesfuly';
						$response['filename']      = $filename;
						$response['url']      = 'upload/po_doc/'.$filename;
						
						$response['orgfilename']     =  str_replace('"','',str_replace(' ','', str_replace("'",'', $_FILES['qqfile']['name'])));
						$expo = new te_ExpensePO();
					 
						$poDoc=json_decode(htmlspecialchars_decode($podetail['podocument']));
					 
						$poDoc[]=array('file'=>$response['filename'],'orgname'=>$response['orgfilename']);
					 
						 
						$expo->id=$_POST['records'];
						$expo->status=2;
						$expo->podocument=json_encode($poDoc);
						$expo->save();
						$response['id']      = count($poDoc)-1;
						
						
					}else{
						$response['success']      = false;
						$response['message']      = 'Something gone wrong. Please try again';
					}
					
				}
				
			}else{
				
						$response['success']      = false;
						$response['message']      = 'Something gone wrong. Please try again';	
			}

			echo json_encode($response); exit();
			
			
		}else{
			
				 $response['success']      = false;
				 $response['message']      = 'No PO required';	 
				 echo json_encode($response); exit();
			
		}
		
	}
	
}else{
	 $response['success']      = false;
	 $response['message']      = 'You are not authorised to upload PO';	 
	 echo json_encode($response); exit();	
}



