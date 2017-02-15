<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/MVC/View/views/view.list.php');
require_once('custom/modules/Leads/customfunctionforcrm.php');
			
class EmployeesViewList extends ViewList{
             
 	/*
 	 * Override listViewProcess with addition to where clause to exclude project templates
 	 */
    function listViewProcess()
    {
		global $current_user; 
		$user_name = $current_user->user_name;
		$id = $current_user->id;
		unset($_REQUEST['open_only_active_users_basic']);
		$this->processSearchForm();
		$this->reportingUser($id);
		$this->report_to_id[$id] = $current_user->name;
		$reportingUserIds = $this->report_to_id;
		$user_ids = implode("', '", array_keys($reportingUserIds));				
		$this->params['custom_where'] =" AND users.reports_to_id IN ('".$user_ids."')"; 
		   
		$this->lv->searchColumns = $this->searchForm->searchColumns;
		if(!$this->headers)
			return;				
		if(empty($_REQUEST['search_form_only']) || $_REQUEST['search_form_only'] == false){
			$this->params['overrideOrder']='1';
			$this->params['sortOrder']='DESC';
			$this->lv->searchColumns = $this->searchForm->searchColumns;
			$tplFile = 'include/ListView/ListViewGeneric.tpl';
			$this->lv->setup($this->seed, $tplFile, $this->where, $this->params);			
			echo $this->lv->display();
	
		}
			
	}                   
    function reportingUser($currentUserId){
			$userObj = new User();
			$userObj->disable_row_level_security = true;
			$userList = $userObj->get_full_list("", "users.reports_to_id='".$currentUserId."'");	
			if(!empty($userList)){
				foreach($userList as $record){
					if(!empty($record->reports_to_id)){
						$this->report_to_id[$record->id] = $record->name."(".$record->osscube_member_id.")";
						$this->reportingUser($record->id);
						
					}
				}
			}
		}
		


}
?>
