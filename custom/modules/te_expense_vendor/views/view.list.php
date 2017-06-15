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
require_once ('modules/ACLRoles/ACLRole.php');
require_once ('custom/modules/te_expense_vendor/te_expense_vendor_cls.php');
class te_Expense_VendorViewList extends ViewList
{ 
 
 
 
  public function listViewProcess() {
        global $current_user;
        $this->processSearchForm();
       
         if(!$current_user->is_admin){
           $this->params['custom_from'] = "  inner join te_expense_vendor_approval on te_expense_vendor.id=te_expense_vendor_approval.expense_id AND te_expense_vendor_approval.assigned_user_id = '". $current_user->id ."'";
          }else{
			// $this->params['custom_from'] = "  inner join te_expense_vendor_approval on te_expense_vendor.id=te_expense_vendor_approval.expense_id";// and assigned_user_id = '". $current_user->id ."'";

		  } 
		  
		  //$this->params['custom_where'] = " assigned_user_id = '". $current_user->id ."'";
		  
		  //print_r($this->params);die;
			 
        if (empty($_REQUEST['search_form_only']) || $_REQUEST['search_form_only'] == false) {
            $this->lv->setup($this->seed, 'custom/modules/te_expense_vendor/tpls/listing.tpl', $this->where, $this->params);
            $savedSearchName = empty($_REQUEST['saved_search_select_name']) ? '' : (' - ' . $_REQUEST['saved_search_select_name']);
            echo $this->lv->display();
        }
    }
 	

}
//tpl file function

function getStatus($id){
	  global $current_user;
	  if($current_user->is_admin) return te_expense_vendor_cls::getStatus($id);
	return te_expense_vendor_cls::getStatus($id,$current_user->id);
	
}

function getStatussubmitter($id){
	  global $current_user;
	  if($current_user->is_admin) return te_expense_vendor_cls::getStatus($id);
	return te_expense_vendor_cls::getStatus($id,$current_user->id,1);
	
}


function checkParentApproved($id){
	global $current_user;
	$roleUsr=new ACLRole();
	$expObj=new te_expense_vendor_cls();
	$userRole=$roleUsr->getUserRole($current_user->id,1);	
	
	 
	$approvers=$expObj->getAllApprovers('',$userRole['parent_role']);
	 
	  
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
