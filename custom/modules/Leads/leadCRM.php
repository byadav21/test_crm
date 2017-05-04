<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('custom/modules/te_Api/te_Api.php');
require_once('custom/modules/te_student/te_student_override.php');

global $current_user,$db;
$customerId= $_REQUEST['customerId'];
$userID= $_REQUEST['userId'];
$phone= $_REQUEST['phone'];
$callType= $_REQUEST['callType']; 
$callObjId= $_REQUEST['userCrtObjectId']; 
$mainMenu= $_REQUEST['mainMenu']; 

try{
	$objapi= new te_Api_override();
	$objapi->createLog(print_r($_REQUEST,true),"crm popup url"); 
		
	$getUserIDs= "select id from users where user_name='$userID'";
	$getUserID=$db->query($getUserIDs);
	if($db->getRowCount($getUserID) > 0){
		
		if($mainMenu==1 &&  $callType=='inbound.call.dial'){
			
			$student= "select id,assigned_user_id,name as first_name,'' as last_name,'Active','Student' from  te_student where    mobile='$phone'";
			$res=$db->query($student);
			if($db->getRowCount($res) > 0){
				
				/*if($records['assigned_user_id']!=$userid['id']){
					header('Location: index.php?module=Leads&action=search_leads&Search=1&search_leads=1&mobile_number='. $phone);
				}*/
				$records=$db->fetchByAssoc($res);		
				header('Location: index.php?module=te_student&action=DetailView&record='. $records['id']); exit();	
				
			}else{
				header('Location: index.php?module=Leads&action=search_leads&Search=1&search_leads=1&mobile_number='. $phone);exit();
			}		
			
		}
		
		
		$userid=$db->fetchByAssoc($getUserID);
		if($callType=='outbound.auto.dial'){	
			$lead="select id,assigned_user_id,first_name,last_name,status,status_description from  leads where  dristi_customer_id='$customerId' and duplicate_check=1 ";
			$res=$db->query($lead); 
			
			if($db->getRowCount($res) == 0){	
				 $lead="select id,assigned_user_id,first_name,last_name,status,status_description from  leads where (    phone_mobile='$phone' or    phone_other='$phone' )  and duplicate_check=1 ";
				 $res=$db->query($lead);
			}			
			
			if($db->getRowCount($res) > 1){
				$lead .=" and status!='Duplicate'";
				$res=$db->query($lead); 
			}
			
		}else if($callType=='outbound.manual.dial'){
			$lead="select id,assigned_user_id,first_name,last_name,status,status_description from  leads where  dristi_customer_id='$customerId'  and duplicate_check=1 ";
			$res=$db->query($lead);
			if($db->getRowCount($res) == 0){	
				 $lead="select id,assigned_user_id,first_name,last_name,status,status_description from  leads where (    phone_mobile='$phone' or    phone_other='$phone' )  and duplicate_check=1 ";
				 $res=$db->query($lead);
			}	
			
			if($db->getRowCount($res) > 1){
				$lead .=" and status!='Duplicate'";
				$res=$db->query($lead); 
			}
				
		}else if($callType=='inbound.call.dial'){
			
		 
				$lead="select id,assigned_user_id,first_name,last_name,status,status_description from  leads where (    phone_mobile='$phone' or    phone_other='$phone' )  and duplicate_check=1  ";
				$res=$db->query($lead);
				
				if($db->getRowCount($res) > 1){
					$lead .=" and status!='Duplicate'";
					$res=$db->query($lead); 
				}
		
			
		
		}else if($callType=='outbound.callback.dial'){	
		
			$lead="select id,assigned_user_id,first_name,last_name,status,status_description from  leads where  dristi_customer_id='$customerId'  and duplicate_check=1 ";
			$res=$db->query($lead); 
			
			if($db->getRowCount($res) == 0){	
				 $lead="select id,assigned_user_id,first_name,last_name,status,status_description from  leads where (    phone_mobile='$phone' or    phone_other='$phone' )  and duplicate_check=1 ";
				 $res=$db->query($lead);
			}	
			
			if($db->getRowCount($res) > 1){
				$lead .=" and status!='Duplicate'";
				$res=$db->query($lead); 
			}
		
		}	
	 
	  
	 
		if($db->getRowCount($res) > 0){	
			$records=$db->fetchByAssoc($res);	
			//print_r($records);die;
			if($callType=='outbound.auto.dial' || $callType=='outbound.callback.dial'){		
				$db->query("update leads set call_object_id='". $callObjId  ."' , dristi_request='".  json_encode($_REQUEST) ."',assigned_user_id='". $userid['id'] ."' where id='". $records['id'] ."'");		
				//header('Location: index.php?module=Leads&action=DetailView&record='. $records['id']);
				include_once("custom/modules/Leads/overview.php");
			}else if($callType=='inbound.call.dial' || $callType=='outbound.manual.dial'){
				
				if(empty($records['assigned_user_id']) || $records['assigned_user_id']=='NULL'){
					
					$db->query("update leads set  call_object_id='". $callObjId  ."' , dristi_request='".  json_encode($_REQUEST) ."',assigned_user_id='". $userid['id'] ."' where id='". $records['id'] ."'");		
					////header('Location: index.php?module=Leads&action=DetailView&record='. $records['id']);
					include_once("custom/modules/Leads/overview.php");
				}else if($records['assigned_user_id']!=$userid['id']){
					 
					header('Location: index.php?module=Leads&action=search_leads&Search=1&search_leads=1&mobile_number='. $phone);
					 
				}else{
					
					$db->query("update leads set  call_object_id='". $callObjId  ."' , dristi_request='".  json_encode($_REQUEST) ."',assigned_user_id='". $userid['id'] ."' where id='". $records['id'] ."'");	
					include_once("custom/modules/Leads/overview.php");
					///header('Location: index.php?module=Leads&action=DetailView&record='. $records['id']);
				}
				
			}
		}else{
			 
			header('Location: index.php?module=Leads&action=EditView&return_module=Leads');
		}	
	}else{
		 
		header('Location: index.php');
	}

}catch(Exception $e){
	header('Location: index.php?module=Leads&action=EditView&return_module=Leads');
}
	
 
 
