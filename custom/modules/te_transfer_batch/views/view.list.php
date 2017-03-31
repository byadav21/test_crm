<?php
require_once('include/MVC/View/views/view.list.php');
class te_transfer_batchViewList extends ViewList
{
    public function preDisplay(){
		echo '<script type="text/javascript" src="custom/modules/te_transfer_batch/transfer_batch.js"></script>';
		echo '<style>.footable-last-column{display:none}</style>';
        parent::preDisplay();
    }
    function listViewProcess()
    {
      global $current_user,$db;
      $this->report_to_id[]=$current_user->id;
      $reporting_UserIds = $this->reportingUser($current_user->id);
      $uid=$this->report_to_id;
      $user_ids = "'" . implode("','", $uid) . "'";
  		$this->processSearchForm();
      if($current_user->is_admin==0 && $current_user->designation!="BUH"){
        if($this->where!=""){
          $this->where .= " AND te_transfer_batch.created_by IN($user_ids) ";
        }
        else{
          $this->where .= " te_transfer_batch.created_by IN($user_ids) ";
        }
      }
      #echo $this->where;die;
  		$this->lv->searchColumns = $this->searchForm->searchColumns;
  		if(!$this->headers)
  			return;
  		if(empty($_REQUEST['search_form_only']) || $_REQUEST['search_form_only'] == false){

  			/*$this->params['orderBy']='LEAD_NUMBER_C';
  			$this->params['overrideOrder']='1';
  			$this->params['sortOrder']='DESC';*/

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
