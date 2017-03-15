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
require_once('custom/modules/te_student/te_student_override.php');
require_once('modules/te_pr_Programs/te_pr_Programs.php');
require_once ('modules/ACLRoles/ACLRole.php');
class te_StudentViewList extends ViewList
{ 
 
 
 
  public function listViewProcess() {
	  
        global $current_user;
        $this->processSearchForm();
         
         

         
			 
        if (empty($_REQUEST['search_form_only']) || $_REQUEST['search_form_only'] == false) {
            $this->lv->setup($this->seed, 'custom/modules/te_student/tpls/listing.tpl', $this->where, $this->params);
            $savedSearchName = empty($_REQUEST['saved_search_select_name']) ? '' : (' - ' . $_REQUEST['saved_search_select_name']);
            echo $this->lv->display();
        }
    }
    
    public function displayHeader(){
		$obj=new te_student_override();
		$newconv=$obj->newConversion();
		$newreg='<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
						<div class="count">'.intval($newconv['newconv']).'</div>
						<span class="count_top"> New Conversion</span>
					</div>';
	 
		$sugarSmarty = new Sugar_Smarty();
		$sugarSmarty->assign("convWiseCount",$newreg);
		parent::displayHeader();
		
	}
    
 
 

 
 	
}

//tpl fun
function getisSent($id){
	global $current_user;	 
	$obj=new  te_student_override();
	$data=$obj->getApproval($id);
	echo (!$data) ? '<a href="javascript:void(0)" class=" " ng-click="openTransfer(\''. $id .'\')">Transfer Batch</a>' : 'Pending';
	
	
}
 

?>
