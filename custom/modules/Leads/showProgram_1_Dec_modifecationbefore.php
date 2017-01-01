<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
//~ require_once('custom/modules/Accounts/customFunctions.php');
ini_set('display_errors','on');
class LeadsListView extends Lead{
	function create_new_list_query($order_by, $where,$filter=array(),$params=array(), $show_deleted = 0,$join_type='', $return_array = false,$parentbean, $singleSelect = false) {
        $ret_array = parent::create_new_list_query($order_by, $where,$filter,$params, $show_deleted,$join_type, $return_array,$parentbean, $singleSelect);
			require_once('custom/modules/Leads/customfunctionforcrm.php');
			global $current_user;
			$currentUserId = $current_user->id;
			//~ $ret_array['select'] .= ",  pd_payment_details.tds_deducted_amount ";
			
			//~ $ret_array['where'] .= " AND leads.assigned_user_id = '".$currentUserId."'";
				//~ echo "<pre>";
			//~ print_r($_REQUEST);
			//~ echo "</pre>";
			$search = 0;
			if(isset($_REQUEST['searchFormTab']) && $_REQUEST['searchFormTab'] == 'basic_search' ){
				if((isset($_REQUEST['search_name_basic']) && !empty($_REQUEST['search_name_basic'])) || (isset($_REQUEST['email_basic']) && !empty($_REQUEST['email_basic'])) || (isset($_REQUEST['phone_mobile_basic']) && !empty($_REQUEST['phone_mobile_basic'])))	
				{
					$search = 1;
				}
			}
			else if (isset($_REQUEST['searchFormTab']) && $_REQUEST['searchFormTab'] == 'advanced_search' ){
				if((isset($_REQUEST['first_name_advanced']) && !empty($_REQUEST['first_name_advanced'])) || (isset($_REQUEST['last_name_advanced']) && !empty($_REQUEST['last_name_advanced'])) || (isset($_REQUEST['email_advanced']) && !empty($_REQUEST['email_advanced'])) || (isset($_REQUEST['phone_mobile_advanced']) && !empty($_REQUEST['phone_mobile_advanced'])))	
				{
					$search = 1;
				}
				
			}
			
			if ($search ==0)
    		{
				
				$reportingUserIds = array();
				$reportUserObj = new customfunctionforcrm();
				$reportUserObj->reportingUser($currentUserId);
				$reportUserObj->report_to_id[$currentUserId] = $current_user->name;
				$reportingUserIds = $reportUserObj->report_to_id;
				//~ print_r($reportingUserIds);
				$ret_array["where"]  .= " AND leads.assigned_user_id IN ('";
				$ret_array["where"]  .= implode("', '", array_keys($reportingUserIds));
				$ret_array["where"]  .= "')";
				//~ echo $ret_array['where'];
			}
			//~ echo "<pre>";
			//~ print_r($_REQUEST);
			//~ echo "</pre>";
			//~ if(isset($_REQUEST['status']) && !empty($_REQUEST['status'])){
				//~ $ret_array["where"]  .= " AND leads.status ='".$_REQUEST['status']."'";
			//~ }
			return $ret_array;
	}
	
	
	
	
	
	
	function fill_in_additional_list_fields() {
	
	
	    global $app_list_strings,$current_user,$sugar_config;
	    
	    $sql_ba = "SELECT te_ba_batch_id_c FROM leads_cstm  WHERE id_c = '".$this->id."'";
		$res_ba = $GLOBALS['db']->query($sql_ba);
		$ba = $GLOBALS['db']->fetchByAssoc($res_ba);
	  
		$bid = $ba['te_ba_batch_id_c'];
// Get Institute details based on the Batch			
		$sql_pro = "SELECT te_pr_programs_te_ba_batch_1te_pr_programs_ida,name FROM te_pr_programs p INNER JOIN te_pr_programs_te_ba_batch_1_c  pb ON p.id = pb.te_pr_programs_te_ba_batch_1te_pr_programs_ida WHERE te_pr_programs_te_ba_batch_1te_ba_batch_idb = '{$bid}' AND pb.deleted = 0 AND p.deleted=0";
		$res_pro = $GLOBALS['db']->query($sql_pro);
		$pro = $GLOBALS['db']->fetchByAssoc($res_pro);
		$pid = $pro['te_pr_programs_te_ba_batch_1te_pr_programs_ida'];
		//~ echo $pid; 
		$this->program = "<a href='index.php?action=DetailView&module=te_pr_Programs&record={$pid}'>".$pro['name']."</a>";

// Get Institute details based on the Batch
			
		$sql_ins = "SELECT te_in_institutes_te_ba_batch_1te_in_institutes_ida,name FROM te_in_institutes i INNER JOIN  te_in_institutes_te_ba_batch_1_c ib ON i.id = ib.te_in_institutes_te_ba_batch_1te_in_institutes_ida WHERE te_in_institutes_te_ba_batch_1te_ba_batch_idb = '{$bid}' AND ib.deleted = 0 AND i.deleted=0";
		$res_ins = $GLOBALS['db']->query($sql_ins);
		$ins = $GLOBALS['db']->fetchByAssoc($res_ins);
		$iid = $ins['te_in_institutes_te_ba_batch_1te_in_institutes_ida'];
		$this->institute = "<a href='index.php?action=DetailView&module=te_in_institutes&record={$iid}'>".$ins['name']."</a>";
		if(!empty($this->phone_mobile)){
			$this->phone_mobile .= '  <img src="custom/themes/default/images/phone.png" href="" onclick="clickToCall('.$this->phone_mobile.',\''.$this->id.'\')" alt="Smiley face" height="20" width="20">';
		}
	    
		//~ $this->program = 'test';
		
	
	}
	
	
}
?>


