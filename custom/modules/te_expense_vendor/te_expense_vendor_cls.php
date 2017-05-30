<?php
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/

/**
 * THIS CLASS IS FOR DEVELOPERS TO MAKE CUSTOMIZATIONS IN
 */
require_once('modules/te_expense_vendor/te_expense_vendor.php');
class te_expense_vendor_cls extends te_ExpensePO {
	
	public $dbinstance;
	function __construct(){
		parent::__construct();
		$this->dbinstance= DBManagerFactory::getInstance();
	}
	
		
	public function getAllApprovers($department='',$role){
		
		$sql="select users.id from users inner join acl_roles_users on  acl_roles_users.user_id= users.id inner join acl_roles  on acl_roles_users.role_id=acl_roles.id and acl_roles.deleted=0 and isvendor=1 and acl_roles_users.role_id='$role' and acl_roles_users.deleted=0 ";	
		$itemDetal=	$this->dbinstance->query($sql);
		$returndata=[];
		while($row=$this->dbinstance->fetchByAssoc($itemDetal)){
			$returndata[]=$row;
		}
		return $returndata;	 
		
	}
	
	public function getStatusForEdit($id,$inQuery){
		
		 $sql="select staus from te_expense_vendor_approval where expense_id='$id' and deleted=0 and assigned_user_id in ($inQuery) ";	
		$itemDetal=	$this->dbinstance->query($sql);
		 
		$returndata=[];
		if($itemDetal && $itemDetal->num_rows>0){
			while($row=$this->dbinstance->fetchByAssoc($itemDetal)){
				if($row['staus']>0) return false;
			}
			return true;
		}else{
			return false;
		}
		
	}
	
 
	public function checkACLDetailView($id,$user){
		global $db;
		$sql="select id,staus from te_expense_vendor_approval where assigned_user_id='$user' and expense_id='$id'";
		$itemDetal=	$db->query($sql);	
		$statrus=$db->fetchByAssoc($itemDetal);			 
		return ($statrus && count($statrus)>0) ? $statrus:false;
		
	}
	public function checkACLDetailViewSubmitter($id,$user){
		global $db;
		$sql="select id,staus from te_expense_vendor_approval where assigned_user_id='$user' and expense_id='$id' and name='submitter'";
		$itemDetal=	$db->query($sql);	
		$statrus=$db->fetchByAssoc($itemDetal);			 
		return ($statrus && count($statrus)>0) ? $statrus:false;
		
	}
	
	 	
	public static function getStatusApproval($id){
		global $db;
		$sql="select staus from te_expense_vendor_approval where  expense_id='$id' and staus<>0";
		$itemDetal=	$db->query($sql);	
		$statrus=$db->fetchByAssoc($itemDetal);
		return ($statrus && count($statrus)>0) ? 1:0;
	}
		
	public static function getStatus($id,$user='',$submit=0){
		global $db;
		 
		if($user==''){
			$sql="select staus from te_expense_vendor_approval where  expense_id='$id'";
			$itemDetal=	$db->query($sql);	
			$statrus=$db->fetchByAssoc($itemDetal);
			return $status= ($statrus && count($statrus)>0) ? (($statrus->status==0)? -2 :$statrus['staus'] ):-2;
		}else{
			if($submit==1){
			 $sql="select staus from te_expense_vendor_approval where assigned_user_id='$user' and expense_id='$id'";
			}else{
			 	$sql="select staus from te_expense_vendor_approval where assigned_user_id='$user' and expense_id='$id' and name='approver'";
			}
			$itemDetal=	$db->query($sql);	
			$statrus=$db->fetchByAssoc($itemDetal);	
			
			return ($statrus && count($statrus)>0) ? $statrus['staus']:-2;
		}	
	}
	
	
}
?>
