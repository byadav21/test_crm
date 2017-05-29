<?php 
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');
global  $current_user;

//Check role for PO upload
require_once ('custom/modules/te_expense_vendor/te_expense_vendor_cls.php');
require_once ('modules/ACLRoles/ACLRole.php');
 
ignore_user_abort(true);
set_time_limit(0); // disable the time limit for this script

//check PO is approved for upload PO
 
if(isset($_REQUEST['record']) && $_REQUEST['record'] ){
	
	$obkExp= new te_expense_vendor(); 
	$recordId=$obkExp->retrieve($_REQUEST['record']);
	if($recordId->id){
		 
		$pan['pan']=json_decode(html_entity_decode($recordId->panpdf));
		$pan['stax']=json_decode(html_entity_decode($recordId->staxpdf));
		$pan['gst']=json_decode(html_entity_decode($recordId->ccheckdoc));
		$pan['cc']=json_decode(html_entity_decode($recordId->gstndoc));
		$pan['reg']=json_decode(html_entity_decode($recordId->reg_cert));
		$file_url = 'upload/vendors/'.$recordId->id.'_'.$pan[$_REQUEST['type']]->path;
		$name= $pan[$_REQUEST['type']]->name;		
		header('Content-Type: application/octet-stream');
		header("Content-Transfer-Encoding: Binary"); 
		header("Content-disposition: attachment; filename=\"" . $name . "\""); 
		readfile($file_url);
		exit(); 
		 
	}
	
	
}else{
 
	  echo '<h1>You are not authorised to download vendor</h1>';
}



