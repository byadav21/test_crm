<?php
if(!defined('sugarEntry'))define('sugarEntry', true);
require_once('include/entryPoint.php');
if($_GET['student_batch']!=''){
	$student_batch	= $_GET['student_batch'];
}else{
	echo "Wrong URL";exit; 
}
$query = "SELECT * from te_student_batch where id='".$student_batch."'";
$result = $db->query($query);
$row = $db->fetchByAssoc($result);

echo "<pre>";print_r($row);echo "</pre>";
?>