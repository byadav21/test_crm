<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('custom/modules/te_Api/te_Api.php');
require_once('modules/Users/authentication/AuthenticationController.php');
$crmSession=$_REQUEST['crmSessionId'];

global $current_user, $db;
$loginObj= new AuthenticationController();
if(empty($current_user->id) || ($current_user->user_name!=$_REQUEST['userId'] ||  !$loginObj->sessionAuthenticate() )){
	 
	$obj=new te_Api_override();
	$pass= $obj->getUserCredential($crmSession);
	
	if($pass){	
	  $loginObj->login($_REQUEST['userId'],$pass);
	  //$session=$_REQUEST['sessionId'];
	 // $db->query("update te_api set dristi_session='$session'")
	}
}
if($_REQUEST['amyoaction']=='callStart'){
	
	header('Location: index.php?module=Leads&action=leadCRM&phone='.  $_REQUEST['phone'].'&crtObjectId='.  $_REQUEST['crtObjectId'].'&campaignId='.  $_REQUEST['campaignId'].'&customerId='.  $_REQUEST['customerId'].'&userId=' . $_REQUEST['userId']);
	
}else{
	
	header('Location: index.php');
}
