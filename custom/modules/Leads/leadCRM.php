<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('custom/modules/te_Api/te_Api.php');
require_once('custom/modules/te_student/te_student_override.php');

global $current_user,$db;
$customerId= $_REQUEST['customerId'];
$userID= $_REQUEST['userId'];

//if($userID==$)

		
$getUserIDs= "select id from users where user_name='$userID'";
$getUserID=$db->query($getUserIDs);
if($db->getRowCount($getUserID) > 0){
	$userid=$db->fetchByAssoc($getUserID);
		
	$lead="select id from  leads where  dristi_customer_id='$customerId'";
	$res=$db->query($lead);
	if($db->getRowCount($res) > 0){	
		$records=$db->fetchByAssoc($res);		
		$db->query("update leads set dristi_request='".  json_encode($_REQUEST) ."',assigned_user_id='". $userid['id'] ."' where id='". $records['id'] ."'");		
		header('Location: index.php?module=Leads&action=DetailView&record='. $records['id']);
	}	
}else{
	
	echo 'Unauthrozied Access';
}
	
 
 
