<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class TaggetCampaign {

    function getName(&$bean, $event, $arguments) {		
		if($bean->send_email==""){
			$bean->send_email='<span id="send_email'.$bean->id.'"><input  title="Send Email" type="button" name="send_email" id="'.$bean->id.'" value="Send" onclick="return sendEmail(this.id)"></span>';
		}	
		
		$bean->program=$this->getProgram($bean->program);
		$bean->batch=$this->getBatch($bean->batch);
		$bean->vendor=$this->getVendor($bean->vendor);
		$bean->template=$this->getTemplate($bean->template);
    }
	function getVendor($id){
		$vendorSql = "SELECT name FROM te_vendor WHERE id = '".$id."'";
		$vendorObj = $GLOBALS['db']->query($vendorSql);
		$row = $GLOBALS['db']->fetchByAssoc($vendorObj);
		return $row['name'];
	}
	function getBatch($id){
		$batchSql = "SELECT name FROM te_ba_batch WHERE id = '".$id."'";
		$batchObj = $GLOBALS['db']->query($batchSql);
		$row = $GLOBALS['db']->fetchByAssoc($batchObj);
		return $row['name'];
	}
	function getTemplate($id){
		$batchSql = "SELECT name FROM email_templates WHERE id = '".$id."'";
		$batchObj = $GLOBALS['db']->query($batchSql);
		$row = $GLOBALS['db']->fetchByAssoc($batchObj);
		return $row['name'];
	}
	function getProgram($id) {		
		$programSql = "SELECT name FROM te_pr_programs WHERE id = '".$id."'";
		$programObj = $GLOBALS['db']->query($programSql);
		$row = $GLOBALS['db']->fetchByAssoc($programObj);
		return $row['name'];
    }
}
