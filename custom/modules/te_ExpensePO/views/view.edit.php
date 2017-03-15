<?php
ini_set ( 'display_errors', 'off' );
require_once ('include/MVC/View/views/view.edit.php');
require_once ('custom/modules/te_ExpensePO/te_Expenseproverride.php');
require_once ('modules/ACLRoles/ACLRole.php');
class te_ExpensePOViewEdit extends ViewEdit {
	
	
	public function preDisplay()
    {
        $metadataFile = $this->getMetaDataFile();
        $this->ev = $this->getEditView();
        $this->ev->ss =& $this->ss;
        $this->ev->setup($this->module, $this->bean, $metadataFile, 'custom/modules/te_ExpensePO/tpls/EditView.tpl');
    }
	
	
	function display() {
		
		 
		global $current_user;
		$expObj=new te_Expenseproverride();
		$roleUsr=new ACLRole();
		$taxes=[]; 
		$items=[];
		$saveID=[];
		$document='[]';
		$docuarray=[];
	 
 
		if(!empty($_REQUEST['record'])){
		 
			$var=$_REQUEST['record'];	
			$itemDeiail=$expObj->getAllItems($var);
			$taxes=$itemDeiail['taxes'];
			$items=$itemDeiail['items'];
			$document= $this->bean->documents;		 
			$docuarray=json_decode(html_entity_decode( $this->bean->documents));
			
			if( $this->bean->status==2 || $this->bean->status==-1){
				echo '<h1>Expense PO >> Edit</h1><br><br><br><span style="color:red">Error: This PO can\'t be edited</span>'; exit();	
			}
			
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
			
			if(!$expObj->getStatusForEdit($this->bean->id,$inQuery)){
					echo '<h1>Expense PO >> Edit</h1><br><br><br><span style="color:red">Error: You can\'t edit this PO dueto approved by your Supervisor</span>'; exit();	
			}
			 
			
			
			
			
		}
		
		$this->ss->assign('taxes', $GLOBALS['app_list_strings']['item_taxes']);		 
		$this->ss->assign('taxesarr', $taxes);
			 
		$this->ss->assign('items', $items);	
		 
		$this->ss->assign('document', $document);		 
		$this->ss->assign('docuarray', $docuarray);		 
		$this->ss->assign('beanid', $this->bean->id);		 
		  
		 
		$this->ev->process();
		echo $this->ev->display($this->showTitle);
		
	}
	
	
	
}
?>
