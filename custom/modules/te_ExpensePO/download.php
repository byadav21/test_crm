<?php 
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');
global  $current_user;

//Check role for PO upload
require_once('custom/modules/te_ExpensePO/te_Expenseproverride.php');
require_once ('modules/ACLRoles/ACLRole.php');
require_once('modules/te_ExpensePO/te_ExpensePO.php');
ignore_user_abort(true);
set_time_limit(0); // disable the time limit for this script

//check PO is approved for upload PO
 
if(isset($_REQUEST['records']) && $_REQUEST['records'] ){
	
	if($_REQUEST['type']=='invoice'){
		require_once('custom/modules/te_ExpencePoPayment/te_ExpencePoPaymentprOverride.php');
		$obkExp= new te_ExpencePoPaymentprOverride(); 
		$recordId=$obkExp->retrieve($_REQUEST['records']);
		$status=te_Expenseproverride::getStatus($recordId->exenseid,$current_user->id,1);		
		if($status==2){
			$poDoc=json_decode(htmlspecialchars_decode($recordId->invocedocs_c));
			$fname=$poDoc[0];
			$file_url = 'upload/po_invoce/'.$fname->filename;
			output_file($file_url,$fname->orgname);			
			exit(); 
			
		}
		
		
	}else{
	
		
		$status=te_Expenseproverride::getStatus($_REQUEST['records'],$current_user->id,1);
		if(($status!=-2 && isset($_REQUEST['type']) && $_REQUEST['type']=='attch') || $current_user->is_admin){
						$podetail= te_Expenseproverride::getPO($_REQUEST['records']);
						$poDoc=json_decode(htmlspecialchars_decode($podetail['documents']));
						$fname=$poDoc[intval($_REQUEST['id'])];
						$file_url = 'upload/po_files/'.$fname->name;
						header('Content-Type: application/octet-stream');
						header("Content-Transfer-Encoding: Binary"); 
						header("Content-disposition: attachment; filename=\"" . $fname->nameOrg . "\""); 
						readfile($file_url); 
		}
			
		if(($status==2 && !isset($_REQUEST['type']) )   || $current_user->is_admin){
			$podetail= te_Expenseproverride::getPO($_REQUEST['records']);
			
			if($podetail['porequired']=='yes'){
				
					 if(isset($_REQUEST['id'])  ){
						 
						 $poDoc=json_decode(htmlspecialchars_decode($podetail['podocument']));
						 $fname=$poDoc[intval($_REQUEST['id'])];
						 $file_url = 'upload/po_doc/'.$fname->file;
						output_file($file_url,$fname->orgname);
						 
					 }else{
						 
						 $poDoc=json_decode(htmlspecialchars_decode($podetail['podocument']));
						 $fname=$poDoc[intval($_REQUEST['id'])];
						 $file_url = 'upload/po_doc/'.$fname->file;
						 output_file($file_url,$fname->orgname);
							
						 
					 }	
				 
				
				
			}else{
				
					 echo '<h1>No PO found!</h1>';
				
			}
			
		}
	}
	
}else{
 
	  echo '<h1>You are not authorised to download PO</h1>';
}



function output_file($file, $name, $mime_type='')
{
	 /*
	 This function takes a path to a file to output ($file),  the filename that the browser will see ($name) and  the MIME type of the file ($mime_type, optional).
	 */
	 
	 //Check the file premission
	 if(!is_readable($file)) die('File not found or inaccessible!');
	 
	 $size = filesize($file);
	 $name = rawurldecode($name);
	 
	 /* Figure out the MIME type | Check in array */
	 $known_mime_types=array(
		"pdf" => "application/pdf",
		"txt" => "text/plain",
		"html" => "text/html",
		"htm" => "text/html",
		"exe" => "application/octet-stream",
		"zip" => "application/zip",
		"doc" => "application/msword",
		"xls" => "application/vnd.ms-excel",
		"ppt" => "application/vnd.ms-powerpoint",
		"gif" => "image/gif",
		"png" => "image/png",
		"jpeg"=> "image/jpg",
		"jpg" =>  "image/jpg",
		"php" => "text/plain"
	 );
	 
	 if($mime_type==''){
		 $file_extension = strtolower(substr(strrchr($file,"."),1));
		 if(array_key_exists($file_extension, $known_mime_types)){
			$mime_type=$known_mime_types[$file_extension];
		 } else {
			$mime_type="application/force-download";
		 };
	 };
	 
	 //turn off output buffering to decrease cpu usage
	 @ob_end_clean(); 
	 
	 // required for IE, otherwise Content-Disposition may be ignored
	 if(ini_get('zlib.output_compression'))
	  ini_set('zlib.output_compression', 'Off');
	 
	 header('Content-Type: ' . $mime_type);
	 header('Content-Disposition: attachment; filename="'.$name.'"');
	 header("Content-Transfer-Encoding: binary");
	 header('Accept-Ranges: bytes');
	 
	 /* The three lines below basically make the 
		download non-cacheable */
	 header("Cache-control: private");
	 header('Pragma: private');
	 header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	 
	 // multipart-download and download resuming support
	 if(isset($_SERVER['HTTP_RANGE']))
	 {
		list($a, $range) = explode("=",$_SERVER['HTTP_RANGE'],2);
		list($range) = explode(",",$range,2);
		list($range, $range_end) = explode("-", $range);
		$range=intval($range);
		if(!$range_end) {
			$range_end=$size-1;
		} else {
			$range_end=intval($range_end);
		}
		 
 
		$new_length = $range_end-$range+1;
		header("HTTP/1.1 206 Partial Content");
		header("Content-Length: $new_length");
		header("Content-Range: bytes $range-$range_end/$size");
	 } else {
		$new_length=$size;
		header("Content-Length: ".$size);
	 }
	 
	 /* Will output the file itself */
	 $chunksize = 1*(1024*1024); //you may want to change this
	 $bytes_send = 0;
	 if ($file = fopen($file, 'r'))
	 {
		if(isset($_SERVER['HTTP_RANGE']))
		fseek($file, $range);
	 
		while(!feof($file) && 
			(!connection_aborted()) && 
			($bytes_send<$new_length)
			  )
		{
			$buffer = fread($file, $chunksize);
			print($buffer); //echo($buffer); // can also possible
			flush();
			$bytes_send += strlen($buffer);
		}
	 fclose($file);
	 } else
	 //If no permissiion
	 die('Error - can not open file.');
	 //die
	die();
}


