<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('custom/modules/te_Api/te_Api.php');
require_once('modules/Users/authentication/AuthenticationController.php');
$crmSession=$_REQUEST['crmSessionId'];
echo $_SERVER['QUERY_STRING'];

echo '<br>';echo '<br>';echo '<br>';

print_r($_REQUEST);
global $current_user, $db;

echo '<br>current user='. $current_user->user_name;
echo '<br>request user='. $_REQUEST['userId'] ;
echo '<br>';

$loginObj= new AuthenticationController();
echo ($loginObj->sessionAuthenticate())?1:0;
if(empty($current_user->id) || ($current_user->user_name!=$_REQUEST['userId'] ||  !$loginObj->sessionAuthenticate() )){
	 echo '<br> in login check';
	$obj=new te_Api_override();
	$pass= $obj->getUserCredential($crmSession);
	 echo '<br> pass='. $pass;
	if($pass){	
			 echo '<br> now login';
			 echo '<br>';
	  echo($loginObj->login($_REQUEST['userId'],$pass))?1:0;
	  //$session=$_REQUEST['sessionId'];
	 // $db->query("update te_api set dristi_session='$session'")
	}
}
if($_REQUEST['amyoaction']=='callStart'){
	
	//header('Location: index.php?module=Leads&action=leadCRM&phone='.  $_REQUEST['phone'].'&crtObjectId='.  $_REQUEST['crtObjectId'].'&campaignId='.  $_REQUEST['campaignId'].'&customerId='.  $_REQUEST['customerId'].'&userId=' . $_REQUEST['userId']);
	
}else{
	
	//header('Location: index.php');
}
