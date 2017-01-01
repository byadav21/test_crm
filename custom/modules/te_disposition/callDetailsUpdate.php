<?php
if(!defined('sugarEntry')) {
	define('sugarEntry', true);
}
ini_set('display_errors', 0);
ini_set("memory_limit","512M");
global $db;

//~ print_r($_REQUEST);
if(isset($_REQUEST) && !empty($_REQUEST['list_id'])){
	//~ echo "Hello";
	$insertSQL = "INSERT INTO neox_call_details_update SET 
					list_id ='".$_REQUEST['list_id']."',
					campaign_id='".$_REQUEST['campaign_id']."',
					group_id ='".$_REQUEST['group_id']."',
					call_date='".$_REQUEST['call_date']."',
					customer_time='".$_REQUEST['customer_time']."',
					status='".$_REQUEST['status']."',
					phone_number='".$_REQUEST['phone_number']."',
					user='".$_REQUEST['user']."',
					unique_id='".$_REQUEST['unique_id']."',
					extension='".$_REQUEST['extension']."',
					term_reason='".$_REQUEST['term_reason']."',
					talk_duration='".$_REQUEST['talk_duration']."',
					recording_file='".$_REQUEST['recording_file']."'";
					if($db->query($insertSQL)){
						echo "Success";	
					}
					else{
						echo "Error";
					}
					
}
else{
		echo "list_id should not be empty";
}
?>
