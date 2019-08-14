<?php
if(!defined('sugarEntry'))define('sugarEntry', true);
require_once('include/entryPoint.php');
if($_GET['student_batch']!=''){
	$student_batch	= $_GET['student_batch'];
}else{
	echo "Wrong URL";exit; 
}
$query = "SELECT sb.name as old_program_name,sb.batch_code as old_batch_code, bb.name as new_program_name, bb.batch_code as new_batch_code, s.name as student_name, s.email, s.mobile, tb.status from te_student_batch sb, te_student s,te_transfer_batch tb,te_ba_batch bb where sb.id='".$student_batch."' and sb.leads_id=s.lead_id_c and tb.batch_id_rel=sb.id and bb.id=tb.te_ba_batch_id_c";
$result = $db->query($query);
$row = $db->fetchByAssoc($result);

echo "<pre>";print_r($row);echo "</pre>";
?>