<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
//~ require_once('custom/modules/Accounts/customFunctions.php');

ini_set('display_errors','on');
class LeadsListView extends Lead{
	function create_new_list_query($order_by, $where,$filter=array(),$params=array(), $show_deleted = 0,$join_type='', $return_array = false,$parentbean, $singleSelect = false) {
        $ret_array = parent::create_new_list_query($order_by, $where,$filter,$params, $show_deleted,$join_type, $return_array,$parentbean, $singleSelect);
			require_once('custom/modules/Leads/customfunctionforcrm.php');
                        require_once('modules/ACLRoles/ACLRole.php');
			global $current_user;
			$currentUserId = $current_user->id;
			//~ $ret_array['select'] .= ",  pd_payment_details.tds_deducted_amount ";
			
			//~ $ret_array['where'] .= " AND leads.assigned_user_id = '".$currentUserId."'";
				
			$search = 0;
			//~ if(isset($_REQUEST['searchFormTab']) && $_REQUEST['searchFormTab'] == 'basic_search' ){
				//~ if((isset($_REQUEST['search_name_basic']) && !empty($_REQUEST['search_name_basic'])) || (isset($_REQUEST['email_basic']) && !empty($_REQUEST['email_basic'])) || (isset($_REQUEST['phone_mobile_basic']) && !empty($_REQUEST['phone_mobile_basic'])))	
				//~ {
					//~ $search = 1;
				//~ }
			//~ }
			//~ else if (isset($_REQUEST['searchFormTab']) && $_REQUEST['searchFormTab'] == 'advanced_search' ){
				//~ if((isset($_REQUEST['first_name_advanced']) && !empty($_REQUEST['first_name_advanced'])) || (isset($_REQUEST['last_name_advanced']) && !empty($_REQUEST['last_name_advanced'])) || (isset($_REQUEST['email_advanced']) && !empty($_REQUEST['email_advanced'])) || (isset($_REQUEST['phone_mobile_advanced']) && !empty($_REQUEST['phone_mobile_advanced'])))	
				//~ {
					//~ $search = 1;
				//~ }
				//~ 
			//~ }
			
			//~ if ($search ==0)
    		//~ {
				//~ 
                        
                                $rolObj    = new ACLRole();
                                $role_slug = $rolObj->getUserRoleSlug($currentUserIdid);
                                
				$reportingUserIds = array();
				$reportUserObj = new customfunctionforcrm();
				$reportUserObj->reportingUser($currentUserId);
				$reportUserObj->report_to_id[$currentUserId] = $current_user->name;
				$reportingUserIds = $reportUserObj->report_to_id;
				//~ print_r($reportingUserIds);
                                if ($role_slug != 'mis' && $current_user->is_admin != 1)
                                {
                                $ret_array["where"]  .= " AND leads.assigned_user_id IN ('";
				$ret_array["where"]  .= implode("', '", array_keys($reportingUserIds));
				$ret_array["where"]  .= "')";
                                    
                                }
                                
			//~ }
			//~ 
			//add duplicate serach leads Query seen=o
			if(isset($_REQUEST['status_description_basic'])){
				$ret_array["where"]  .= "AND leads.is_seen=0";
			}
			if(isset($_REQUEST['payment_realized_check_basic'])){
				$ret_array["where"]  .= " AND payment_realized_check = 0 AND  leads.id IN (SELECT DISTINCT leads_te_payment_details_1leads_ida FROM leads_te_payment_details_1_c WHERE deleted = 0)";
			}
			if(isset($_REQUEST['call_back_due'])){
				$ret_array["where"]  .= " AND status_description LIKE 'Call Back' AND DATE(date_of_callback) < '".date('Y-m-d')."' ";
			}
			if(isset($_REQUEST['due_followup'])){
				$ret_array["where"]  .= " AND status_description LIKE 'Follow Up' AND DATE(date_of_followup) < '".date('Y-m-d')."' ";
			}
			if(isset($_REQUEST['over_due_pros'])){
				$ret_array["where"]  .= " AND status_description LIKE 'Prospect' AND DATE(date_of_prospect) < '".date('Y-m-d')."' ";
			}
			if(isset($_REQUEST['pros_today'])){
				$ret_array["where"]  .= " AND status_description LIKE 'Prospect' AND DATE(date_of_prospect) = '".date('Y-m-d')."'";
			}
			if(isset($_REQUEST['follow_today'])){
				$ret_array["where"]  .= " AND status_description LIKE 'Follow Up' AND DATE(date_of_followup) = '".date('Y-m-d')."'";
			}
			if(isset($_REQUEST['call_today'])){
				$ret_array["where"]  .= " AND status_description LIKE 'Call Back' AND DATE(date_of_callback) = '".date('Y-m-d')."' ";
			}
			if(isset($_REQUEST['parent_id'])){
				$ret_array["where"]  .= " AND parent_id LIKE  '".$_REQUEST['parent_id']."' ";
			}
			//~ if(isset($_REQUEST['status']) && !empty($_REQUEST['status'])){
				//~ $ret_array["where"]  .= " AND leads.status ='".$_REQUEST['status']."'";
			//~ }
			return $ret_array;
	}
	
	
	function fill_in_additional_list_fields() {
	
	
	    global $app_list_strings,$current_user,$sugar_config;
	    
	    /* Modified to get batch programe and institue by either utm or batch */
	    //$sql_ba = "SELECT te_ba_batch_id_c FROM leads_cstm  WHERE id_c = '".$this->id."'";
	    $sql_ba = "SELECT b.id batch_id, b.name, l.id FROM leads l INNER JOIN leads_cstm lc ON l.id = lc.id_c AND l.id='".$this->id."' LEFT JOIN te_utm ON l.utm = te_utm.name LEFT JOIN te_ba_batch b ON b.id = CASE WHEN l.utm =  'NA' THEN lc.te_ba_batch_id_c WHEN l.utm !=  'NA' THEN te_utm.te_ba_batch_id_c END";
		$res_ba = $GLOBALS['db']->query($sql_ba);
		$ba = $GLOBALS['db']->fetchByAssoc($res_ba);
	  
		/*Modified to get batch programe and institue by either utm or batch* date-1dec2016 */
		//$bid = $ba['te_ba_batch_id_c']; old
		
		  $bid = $ba['batch_id'];
       // Get programs details based on the Batch			
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
			if(isset($_SESSION['dial_type']) && $_SESSION['dial_type'] =='Predictive'){
				$this->phone_mobile .= '  <img src="custom/themes/default/images/phone.png" href="" onclick="alert(\'You are in Predictive mode\')" alt="Smiley face" height="20" width="20">';
			}
			else{
			$this->phone_mobile .= '  <img src="custom/themes/default/images/phone.png" href="" onclick="clickToCall('.$this->phone_mobile.',\''.$this->id.'\')" alt="Smiley face" height="20" width="20">';
			}
			
		}
		
		  $sql_ins = "SELECT id,te_ba_batch.name FROM te_ba_batch  WHERE id = '".$bid ."'";
			$res_ins = $GLOBALS['db']->query($sql_ins);
			$ins = $GLOBALS['db']->fetchByAssoc($res_ins);
			$iid = $ins['id'];
			  $this->batch = "<a href='index.php?action=DetailView&module=te_ba_Batch&record={$iid}'>".$ins['name']."</a>"; 
			  
	    
		//~ $this->program = 'test';
		
	
	}
	
	
}
?>


