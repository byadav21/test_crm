<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
//@Manish Gupta 9650211216

if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');
	global $db;
	


if(isset($_GET['lead_id']) && !empty($_GET['lead_id'])){
$lead_id=$_GET['lead_id'];

//$update_leads=$GLOBALS['db']->Query("UPDATE leads SET is_seen=1 WHERE id='".$lead_id."'");

$update_leads="UPDATE leads SET is_seen=1 WHERE id='".$lead_id."'";
$res_update = $db->query($update_leads);
if($res_update){
	echo "1";
}
else{
echo "0";	
}
	
}


