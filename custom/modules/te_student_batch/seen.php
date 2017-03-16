<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

require_once('custom/modules/te_student/te_student_override.php');
global  $current_user;
 
$obj=new te_student_override();
global  $current_user;
$currentUserId = $current_user->id;
$reportingUserIds = array();			 
$obj->reportingUser($currentUserId);
$obj->report_to_id[$currentUserId] = $current_user->name;
$reportingUserIds = $obj->report_to_id;
$user_ids = implode("', '", array_keys($reportingUserIds));

 if($_GET['type']=='new'){	 
	 $obj->setSeen('is_new','te_student_batch',$user_ids,'Active');
	 
	 header('Location: index.php?searchFormTab=basic_search&module=te_student_batch&action=index&query=true&status_basic[]=Active');
	 
 }else if($_GET['type']=='dropout'){
	 $obj->setSeen('is_new_dropout','te_student_batch',$user_ids,'Dropout');
	 header('Location: index.php?searchFormTab=basic_search&module=te_student_batch&action=index&query=true&status_basic[]=Dropout');
 }else if($_GET['type']=='call_dropout'){
	  $obj->setSeenDropout('is_new_dropout','leads',$user_ids);
	  header('Location: index.php?module=Leads&action=index');
 }else if($_GET['type']=='refral'){
	  $obj->setSeenRefrals('is_new_referalls','leads',$user_ids);
	   header('Location: index.php?module=te_student_batch&action=viewmyrefferal');
 }	 
