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

//print_r($recordId);
	if($recordId->id){
		// print_r($_REQUEST);
		$pan['pan']=json_decode(html_entity_decode($recordId->panpdf));
		$pan['stax']=json_decode(html_entity_decode($recordId->staxpdf));
		$pan['cc']=json_decode(html_entity_decode($recordId->ccheckdoc));
	 $pan['gst']=json_decode(html_entity_decode($recordId->gstndoc));
		$pan['reg']=json_decode(html_entity_decode($recordId->reg_cert));



// $types= $pan[$_REQUEST['type']]->path;die;

//print_r($_REQUEST);


	 $file_url = 'upload/vendors/'.$pan[$_REQUEST['type']]->path;//die;

if(!$pan[$_REQUEST['type']]->path){


  header('Content-Type: text/pdf');
                header("Content-Transfer-Encoding: Binary");
header('Pragma: no-cache');
header("Content-disposition: attachment; filename=\"" . basename( $file_url) . '.pdf'  . "\"");


 readfile($file_url);die;
}
echo '<script>';
?>
   window.open('<?php echo $file_url ?>'); window.history.back();
<?php

echo '</script>';
die;

	$name= $pan[$_REQUEST['type']]->name;		
//$ext=explode('.',$name);
		header('Content-Type: text/pdf');
		header("Content-Transfer-Encoding: Binary"); 
header('Pragma: no-cache');		
header("Content-disposition: attachment; filename=\"" . basename( $file_url) . '.pdf'  . "\""); 
		echo readfile($file_url);
		exit(); 
		 
	}
	
	
}else{
 
	  echo '<h1>You are not authorised to download vendor</h1>';
}



