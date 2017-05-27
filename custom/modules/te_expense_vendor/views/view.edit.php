<?php
ini_set ( 'display_errors', 'off' );
require_once ('include/MVC/View/views/view.edit.php');
require_once ('custom/modules/te_expense_vendor/te_expense_vendor_cls.php');
require_once ('modules/ACLRoles/ACLRole.php');
class tte_Expense_VendorViewEdit extends ViewEdit {
	
	function display() {
		
		 
		global $current_user;
		$expObj=new te_expense_vendor_cls();
		$roleUsr=new ACLRole();
	 
	 
 
		if(!empty($_REQUEST['record'])){
		 
			$var=$_REQUEST['record'];	
		 
			
			if( $this->bean->status==2 || $this->bean->status==-1){
				echo '<h1>Expense PO >> Edit</h1><br><br><br><span style="color:red">Error: This vendor can\'t be edited</span>'; exit();	
			}
			
			$userRole=$roleUsr->getUserRole($current_user->id);
			$approvers=$expObj->getAllApprovers($department,$userRole['parent_role']);
			
			  
			$inQuery='';
			if($approvers && count($approvers)>0){
				foreach($approvers as $appvrs){
					$inQuery.="'".$appvrs['id']."',";
				}
			}			
			$inQuery=substr($inQuery,0, strlen($inQuery)-1);
			
			if(!$expObj->getStatusForEdit($this->bean->id,$inQuery)){
					echo '<h1>Expense PO >> Edit</h1><br><br><br><span style="color:red">Error: You can\'t edit this vendor dueto approved by your Supervisor</span>'; exit();	
			}
			
		}
		
	
		parent::display();
	}
	
	
	
}
?>
