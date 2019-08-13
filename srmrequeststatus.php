<?php
if(!defined('sugarEntry'))define('sugarEntry', true);
require_once('include/entryPoint.php');
if($_GET['student_batch']!=''){
	$student_batch	= $_GET['student_batch'];
}else{
	echo "Wrong URL";exit; 
}
echo "<pre>";print_r($_REQUEST);echo "</pre>";
?>