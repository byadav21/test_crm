<?php 
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');
global  $current_user;

if(isset($_FILES['qqfile']) && count($_FILES['qqfile'])>0){
	
	if($_FILES['qqfile']['error']>0){
			 $response['success']      = false;
			 $response['message']      = 'Invalid File Type';
	}elseif($_FILES['qqfile']['size']> 1024 * 1024 * 20){
			$response['success']      = false;
			$response['message']      = 'You can upload file upto 20 MB';
	}else{
		$uploads_dir = $_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['SCRIPT_NAME']);
		$filename=$current_user->id . '_'. date('ymdHis') . '_po.' . substr(strrchr($PATH, "."), 1);
		
		if(move_uploaded_file($_FILES['qqfile']['tmp_name'],$uploads_dir .'/upload/po_files/'.$filename)){
			$response['success']      = true;
			$response['message']      = 'File has been uploaded succesfuly';
			$response['filename']      = $filename;
			$response['orgfilename']     =  str_replace('"','',str_replace(' ','', str_replace("'",'', $_FILES['qqfile']['name'])));
			
		}else{
			$response['success']      = false;
			$response['message']      = 'Something gone wrong. Please try again';
		}
		
	}
	
}else{
	
			$response['success']      = false;
			$response['message']      = 'Something gone wrong. Please try again';	
}

echo json_encode($response); exit();

