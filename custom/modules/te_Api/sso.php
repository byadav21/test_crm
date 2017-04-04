<?php

require_once('modules/Users/authentication/AuthenticationController.php');
require_once('custom/modules/te_Api/te_Api.php');
$crmSession=$_REQUEST['crmSessionId'];
global $current_user, $db;

$loginObj= new AuthenticationController();

if(empty($current_user->id) || ($current_user->user_name!=$_REQUEST['userId'] ||  !$loginObj->sessionAuthenticate() )){
	// echo '<br> in login check';
	$obj=new te_Api_override();
	$pass= $obj->getUserCredential($crmSession);
	 //echo '<br> pass='. $pass;
	if($pass){	
			 //echo '<br> now login';
			 //echo '<br>';
	  $loginObj->login($_REQUEST['userId'],$pass);//?1:0;
	  //$session=$_REQUEST['sessionId'];
	 // $db->query("update te_api set dristi_session='$session'")
	}
}
