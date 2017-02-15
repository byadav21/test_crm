<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
//~ require_once('custom/modules/Accounts/customFunctions.php');
ini_set('display_errors','on');
class te_dispositionListView extends te_disposition{
	function create_new_list_query($order_by, $where,$filter=array(),$params=array(), $show_deleted = 0,$join_type='', $return_array = false,$parentbean, $singleSelect = false) {
        $ret_array = parent::create_new_list_query($order_by, $where,$filter,$params, $show_deleted,$join_type, $return_array,$parentbean, $singleSelect);
			require_once('custom/modules/Leads/customfunctionforcrm.php');
			global $current_user;
			$currentUserId = $current_user->id;
				
			$search = 0;
				//~ $reportingUserIds = array();
				//~ $reportUserObj = new customfunctionforcrm();
				//~ $reportUserObj->reportingUser($currentUserId);
				//~ $reportUserObj->report_to_id[$currentUserId] = $current_user->name;
				//~ $reportingUserIds = $reportUserObj->report_to_id;
				//~ print_r($reportingUserIds);
				//~ $ret_array["where"]  .= " AND te_disposition.assigned_user_id IN ('";
				//~ $ret_array["where"]  .= implode("', '", array_keys($reportingUserIds));
				//~ $ret_array["where"]  .= "')";
			//~ 
			//~ 
			$ret_array["where"]  .= " AND te_disposition.status = 'unsaved'";
			$ret_array["order_by"] =  " ORDER BY te_disposition.date_entered DESC";
			
			return $ret_array;
	}
	
	
	function fill_in_additional_list_fields() {
	
	
	    global $app_list_strings,$current_user,$sugar_config,$db;
		   
		$sql = "SELECT l.phone_mobile,l.first_name,l.last_name,lc.te_ba_batch_id_c as batch,e.email_address FROM leads l LEFT JOIN leads_cstm lc ON l.id=lc.id_c LEFT JOIN email_addr_bean_rel el ON l.id = el.bean_id LEFT JOIN email_addresses e ON el.email_address_id = e.id 
		WHERE l.deleted =0 AND el.deleted=0 AND e.deleted=0 AND el.bean_module='Leads' AND l.id='".$this->te_disposition_leadsleads_ida."'"; 
		//~ echo $sql."<br>";
		$result = $db->query($sql);

		if($db->getRowCount($result)>0){
			$row = $db->fetchByAssoc($result);
			$this->lead_mobile = $row['phone_mobile'];
			$this->lead_email = $row['email_address'];
			if(!empty($row['batch'])){
			$sql_pro = "SELECT te_pr_programs_te_ba_batch_1te_pr_programs_ida,name FROM te_pr_programs p INNER JOIN te_pr_programs_te_ba_batch_1_c  pb ON p.id = pb.te_pr_programs_te_ba_batch_1te_pr_programs_ida WHERE te_pr_programs_te_ba_batch_1te_ba_batch_idb = '".$row['batch']."' AND pb.deleted = 0 AND p.deleted=0";
			$res_pro = $GLOBALS['db']->query($sql_pro);
			$pro = $GLOBALS['db']->fetchByAssoc($res_pro);
			$pid = $pro['te_pr_programs_te_ba_batch_1te_pr_programs_ida'];
			$this->program_name = "<a href='index.php?action=DetailView&module=te_pr_Programs&record={$pid}'>".$pro['name']."</a>";
			$batSql = "SELECT name FROM te_ba_batch WHERE id = '".$row['batch']."' AND deleted = 0";
			$resbat = $GLOBALS['db']->query($batSql);
			$bat = $GLOBALS['db']->fetchByAssoc($resbat);
			$bit = $row['batch'];
			$this->batch_name = "<a href='index.php?action=DetailView&module=te_ba_Batch&record={$bit}'>".$bat['name']."</a>";
			}
			$this->te_disposition_leads_name	 = "<a href='index.php?action=EditView&module=Leads&record={$this->te_disposition_leadsleads_ida}'>".$row['first_name']."&nbsp;".$row['last_name']."</a>";
		}
		
		$this->show_button = '<button type="button" onclick="update_disposition(\''.$this->id.'\')">Update</button></span>';	
	
	}
	
	
}
?>


