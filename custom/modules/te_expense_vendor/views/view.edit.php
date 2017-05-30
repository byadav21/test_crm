<?php
ini_set ( 'display_errors', 'off' );
require_once ('include/MVC/View/views/view.edit.php');
require_once ('custom/modules/te_expense_vendor/te_expense_vendor_cls.php');
require_once ('modules/ACLRoles/ACLRole.php');
class te_Expense_VendorViewEdit extends ViewEdit {
	
	public function preDisplay()
    {
        $metadataFile = $this->getMetaDataFile();
        $this->ev = $this->getEditView();
        $this->ev->ss =& $this->ss;
        $this->ev->setup($this->module, $this->bean, $metadataFile, 'custom/modules/te_expense_vendor/tpls/EditView.tpl');
    }
	
	
	
	function display() {
		
		 
		global $current_user;
		$expObj=new te_expense_vendor_cls();
		$roleUsr=new ACLRole();
	 
	 
 
		if(!empty($_REQUEST['record'])){
		 
			$var=$_REQUEST['record'];	
		 
			
			if( $this->bean->status==2 || $this->bean->status==-1){
				echo '<h1>Expense PO >> Edit</h1><br><br><br><span style="color:red">Error: This vendor can\'t be edited</span>'; exit();	
			}
			$this->ss->assign('overview', $this->bean);	
			$userRole=$roleUsr->getUserRole($current_user->id,1);
			$approvers=$expObj->getAllApprovers($department,$userRole['parent_role']);
			
			  
			$inQuery='';
			if($approvers && count($approvers)>0){
				foreach($approvers as $appvrs){
					$inQuery.="'".$appvrs['id']."',";
				}
			}			
			$inQuery=substr($inQuery,0, strlen($inQuery)-1);
			
			if(!$expObj->getStatusForEdit($this->bean->id,$inQuery)){
					echo '<h1>Expense Vendor >> Edit</h1><br><br><br><span style="color:red">Error: You can\'t edit this vendor dueto this is in Supervisor approval</span>'; exit();	
			}
			
		}
		
	
		parent::display();
	}
	
	
	
}
?>
