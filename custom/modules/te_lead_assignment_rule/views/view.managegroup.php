<?php
if (!defined('sugarEntry') || !sugarEntry)
	die('Not A Valid Entry Point');

class te_lead_assignment_ruleViewManagegroup extends SugarView {
	
	public function __construct() {
		
		parent::SugarView();
	}
	
	public function display() {
		//~ echo "----------------";die;
		global $db;
		#Get vendor drop down option
		//~ $batchStatusList=$GLOBALS['app_list_strings']['batch_status_list'];		
		//~ $reportDataList=array();
		//~ $vendorOptionList=array();
		//~ $selected_vendor="";
		//~ $selected_batch="";
		//~ $selected_status="";
		//~ $search_date="";
		//~ 
		
		$groupSql = "SELECT s.*,u.first_name,u.last_name FROM securitygroups s LEFT JOIN users u ON s.assigned_user_id=u.id WHERE s.deleted = 0 AND u.deleted =0";
		//~ echo $groupSql;die;
		$groupObj =$db->query($groupSql);
		//~ $batchOptions=array();
		while($row =$db->fetchByAssoc($groupObj)){ 
			$groupDataList[]=$row;
		}
		//~ echo "<pre>";
		//~ print_r($groupDataList);
		//~ echo "</pre>";
		$sugarSmarty = new Sugar_Smarty();
		//~ $sugarSmarty->assign("batchList",$batchList);
		//~ $sugarSmarty->assign("vendorOptionList",$vendorList);
		//~ $sugarSmarty->assign("batchStatusList",$batchStatusList);
		$sugarSmarty->assign("groupDataList",$groupDataList);
		//~ $sugarSmarty->assign("selected_batch",$selected_batch);
		//~ $sugarSmarty->assign("selected_vendor",$selected_vendor);
		//~ $sugarSmarty->assign("selected_status",$selected_status);
		//~ $sugarSmarty->assign("selected_date",$search_date);
		//~ 
		$sugarSmarty->display('custom/modules/te_lead_assignment_rule/tpls/managegroup.tpl');
	}
}
?>
