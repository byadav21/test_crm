<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('custom/modules/te_Api/te_Api.php');
require_once('custom/modules/te_student/te_student_override.php');

global $current_user,$db;
$customerId= $_REQUEST['customerId'];
$userID= $_REQUEST['userId'];
$phone= $_REQUEST['phone'];
$callType= $_REQUEST['callType']; 

 

		
$getUserIDs= "select id from users where user_name='$userID'";
$getUserID=$db->query($getUserIDs);
if($db->getRowCount($getUserID) > 0){
	$userid=$db->fetchByAssoc($getUserID);
	if($callType=='outbound.auto.dial'){	
		$lead="select id from  leads where  dristi_customer_id='$customerId'";
	}else if($callType=='inbound.call.dial'){	
		$lead="select id,assigned_user_id from  leads where ( phone_home='$phone' or  phone_mobile='$phone' or  phone_work='$phone' or  phone_other='$phone' ) ";
	}	
	$res=$db->query($lead);
	if($db->getRowCount($res) > 0){	
		$records=$db->fetchByAssoc($res);	
		if($callType=='outbound.auto.dial'){		
			$db->query("update leads set dristi_request='".  json_encode($_REQUEST) ."',assigned_user_id='". $userid['id'] ."' where id='". $records['id'] ."'");		
			header('Location: index.php?module=Leads&action=DetailView&record='. $records['id']);
		}else if($callType=='inbound.call.dial'){
			
			if(empty($records['assigned_user_id'])){
				
				$db->query("update leads set dristi_request='".  json_encode($_REQUEST) ."',assigned_user_id='". $userid['id'] ."' where id='". $records['id'] ."'");		
				header('Location: index.php?module=Leads&action=DetailView&record='. $records['id']);
				
			}else if($records['assigned_user_id']!=$userid['id']){
				
				header('Location: index.php?module=te_student_batch&action=search_leads&search_leads=1&mobile_number='. $phone);
				 
			}else{
				header('Location: index.php?module=Leads&action=DetailView&record='. $records['id']);
			}
			
		}
	}	
}else{
	
	echo 'Unauthrozied Access';
}
	
 
 
