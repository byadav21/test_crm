<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('custom/modules/te_Api/sso.php');
require_once('custom/modules/te_Api/te_Api.php');
$objapi= new te_Api_override();
$objapi->createLog(print_r($_REQUEST,true),"call Initiate",$_REQUEST); 
//print_r($_REQUEST);die;
if($_REQUEST['amyoaction']=='callStart'){
	  
	$querystring=explode('&',$_SERVER['QUERY_STRING']);
	$redqr='';
	foreach($querystring as $qr){
	   $parms=explode('=',$qr);
	   if($parms[0]=='entryPoint' || $parms[0]=='amyoaction' )	continue;
	   $redqr .='&'.$qr;
	}
 
 
	header('Location: index.php?module=Leads&to_pdf=1&action=leadCRM&'. $redqr);
	
}else{
	
	$_SESSION['amyoSID']=$_REQUEST['sessionId'];
	$_SESSION['amyoCID']=$_REQUEST['campaignId'];
//	print_r($_SESSION);die;
	header('Location: index.php');
}
