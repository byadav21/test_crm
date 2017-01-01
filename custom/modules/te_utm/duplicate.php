<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

ini_set('memory_limit','1024M');
require_once('include/entryPoint.php');
global $db;
$utmSql = "SELECT name,utm_campaign FROM te_utm WHERE ";
if(isset($_REQUEST['utm_campaign'])&&$_REQUEST['utm_campaign']!=""){
	$utmSql.= "utm_campaign='".$_REQUEST['utm_campaign']."'";
	$utmObj = $db->query($utmSql);
	if($utmObj->num_rows>0){
		$utm = $db->fetchByAssoc($utmObj);
		echo json_encode(array('utm_campaign'=>$utm['utm_campaign']));
	}else{
		echo json_encode(array('utm_campaign'=>''));	
	}
}
if(isset($_REQUEST['name'])&&$_REQUEST['name']!=""){
	$utmSql.= "name='".$_REQUEST['name']."'";
	$utmObj = $db->query($utmSql);
	if($utmObj->num_rows>0){
		$utm = $db->fetchByAssoc($utmObj);
		echo json_encode(array('name'=>$utm['name']));
	}else{
		echo json_encode(array('name'=>''));	
	}
}

