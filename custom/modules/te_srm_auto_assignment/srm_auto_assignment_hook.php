<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');
class SrmAutoAssignment{
	function setName($bean, $event, $argument){
		if(!isset($_REQUEST['import_module']) && $_REQUEST['module']=="te_srm_auto_assignment"){
			$bean->name=$_REQUEST['batch'];
			if(empty($bean->fetched_row['id'])){
				$duplicateSql = "SELECT id FROM te_srm_auto_assignment WHERE te_ba_batch_id_c='".$_REQUEST['te_ba_batch_id_c']."'";
				$duplicateObj = $GLOBALS['db']->query($duplicateSql);
				if($GLOBALS['db']->getRowCount($duplicateObj)>0){
					SugarApplication::appendErrorMessage('You have been redirected here because of duplicate SRM assignment for the batch');
					SugarApplication::redirect('index.php?module=te_srm_auto_assignment&action=EditView');
				}
			}
		}
	}

	function assignExecutive($bean, $event, $argument){
		if(!isset($_REQUEST['import_module']) && $_REQUEST['module']=="te_srm_auto_assignment"){
			global $db;
			$dropoutSql="UPDATE te_student_batch SET assigned_user_id='".$_REQUEST['assigned_user_id']."' WHERE te_ba_batch_id_c='".$_REQUEST['te_ba_batch_id_c']."'";
			$GLOBALS['db']->query($dropoutSql);
		}
	}
}
