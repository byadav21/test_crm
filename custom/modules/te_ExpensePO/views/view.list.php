<?php
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Enterprise Subscription
 * Agreement ("License") which can be viewed at
 * http://www.sugarcrm.com/crm/products/sugar-enterprise-eula.html
 * By installing or using this file, You have unconditionally agreed to the
 * terms and conditions of the License, and You may not use this file except in
 * compliance with the License.  Under the terms of the license, You shall not,
 * among other things: 1) sublicense, resell, rent, lease, redistribute, assign
 * or otherwise transfer Your rights to the Software, and 2) use the Software
 * for timesharing or service bureau purposes such as hosting the Software for
 * commercial gain and/or for the benefit of a third party.  Use of the Software
 * may be subject to applicable fees and any use of the Software without first
 * paying applicable fees is strictly prohibited.  You do not have the right to
 * remove SugarCRM copyrights from the source code or user interface.
 *
 * All copies of the Covered Code must include on each user interface screen:
 *  (i) the "Powered by SugarCRM" logo and
 *  (ii) the SugarCRM copyright notice
 * in the same form as they appear in the distribution.  See full license for
 * requirements.
 *
 * Your Warranty, Limitations of liability and Indemnity are expressly stated
 * in the License.  Please refer to the License for the specific language
 * governing these rights and limitations under the License.  Portions created
 * by SugarCRM are Copyright (C) 2004-2009 SugarCRM, Inc.; All Rights Reserved.
 ********************************************************************************/
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('include/MVC/View/views/view.list.php');
require_once('custom/modules/te_ExpensePO/te_Expenseproverride.php');
require_once ('modules/ACLRoles/ACLRole.php');
class te_ExpensePOViewList extends ViewList
{ 
 
 
 
  public function listViewProcess() {
        global $current_user;
        $this->processSearchForm();
         
          if(!$current_user->is_admin){
           $this->params['custom_from'] = '  inner join te_expense_approvall on te_expensepo.id=te_expense_approvall.expense_id AND te_expense_approvall.assigned_user_id = "'. $current_user->id .'"  ';
          }else{
			 $this->params['custom_from'] = '  inner join te_expense_approvall on te_expensepo.id=te_expense_approvall.expense_id ';
		 
         
		  } 
	 
        if (empty($_REQUEST['search_form_only']) || $_REQUEST['search_form_only'] == false) {
            $this->lv->setup($this->seed, 'custom/modules/te_ExpensePO/tpls/listing.tpl', $this->where, $this->params);
            $savedSearchName = empty($_REQUEST['saved_search_select_name']) ? '' : (' - ' . $_REQUEST['saved_search_select_name']);
            echo $this->lv->display();
        }
    }
    

 
 /*	
 public function display(){
		
		if(!$this->bean || !$this->bean->ACLAccess('list')){
            ACLController::displayNoAccess();
        } else {
            $this->listViewPrepare();
            
        $this->processSearchForm();
        $this->lv->searchColumns = $this->searchForm->searchColumns;

        if(!$this->headers) return false;
        
            $this->lv->ss->assign("SEARCH",true);
            $this->lv->setup($this->seed, 'custom/modules/te_Expensepr/tpls/listing.tpl', $this->where, $this->params);
            $savedSearchName = empty($_REQUEST['saved_search_select_name']) ? '' : (' - ' . $_REQUEST['saved_search_select_name']);
            echo $this->lv->display(); 
             
        }
	}*/
 
 	
}

//tpl file function

function getStatus($id){
	  global $current_user;
	  if($current_user->is_admin) return te_Expenseproverride::getStatus($id);
	return te_Expenseproverride::getStatus($id,$current_user->id);
	
}

function getStatussubmitter($id){
	  global $current_user;
	  if($current_user->is_admin) return te_Expenseproverride::getStatus($id);
	return te_Expenseproverride::getStatus($id,$current_user->id,1);
	
}

function getFinStatus($id){
	  global $current_user;
	  $role=new ACLRole();
	  $userRole=$role->getUserRole($current_user->id);
	  return $userRole['isfacility'];
	
}

function checkParentApproved($id){
	global $current_user;
	$roleUsr=new ACLRole();
	$expObj=new te_Expenseproverride();
	$userRole=$roleUsr->getUserRole($current_user->id);	
	
	$department=$current_user->rel_fields_before_value['te_department_expense_users_1te_department_expense_ida']; 
	if($userRole['sendtofin']==1){
		$approvers=$expObj->getFacilityApprovers($userRole['parent_role'],1,0); 
	}else{
		$approvers=$expObj->getAllApprovers($department,$userRole['parent_role']);
	}
	  
	$inQuery='';
	if($approvers && count($approvers)>0){
		foreach($approvers as $appvrs){
			$inQuery.="'".$appvrs['id']."',";
		}
	}			
	$inQuery=substr($inQuery,0, strlen($inQuery)-1);
	
	return (!$expObj->getStatusForEdit($id,$inQuery))?0 :1;
	
}
 

?>
