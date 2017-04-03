<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
//require_once('custom/modules/te_Api/sso.php');


if($_REQUEST['amyoaction']=='callStart'){
	
	$querystring=explode('&',$_SERVER['QUERY_STRING']);
	unset($querystring[0]);
	unset($querystring[1]);
	$newurl=implode('&',$querystring);
	
	header('Location: index.php?module=Leads&action=leadCRM&'. $newurl);
	
}else{
	
	header('Location: index.php');
}
