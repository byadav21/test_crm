<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('include/MVC/View/views/view.detail.php');
require_once('include/utils.php');
require_once('include/DetailView/DetailView2.php');
require_once ('custom/modules/te_expense_vendor/te_expense_vendor_cls.php');
require_once ('modules/ACLRoles/ACLRole.php');
class te_Expense_VendorViewDetail extends ViewDetail {


    public function preDisplay()
    {
 	    global $current_user;
 	    $role=new ACLRole();
		$userRole=$role->getUserRole($current_user->id);		 
 	      
 	    $metadataFile = $this->getMetaDataFile();
 	    $this->dv = new DetailView2();
 	    $this->dv->ss =&  $this->ss; 	    
 	    $this->dv->setup($this->module, $this->bean, $metadataFile, get_custom_file_if_exists('custom/modules/te_expense_vendor/tpls/DetailView.tpl'));
    }  


	  
	public function display(){
		global $current_user;
		$expObj=new te_expense_vendor_cls();
		if(!$expObj->checkACLDetailView($this->bean->id,$current_user->id) && !$current_user->is_admin){
			//echo 'UNAUTHORIZED ACCESS !!';die;
			 
		}
	 
			 
		  if($current_user->is_admin){
			 $statusr=te_expense_vendor_cls::getStatus( $this->bean->id);
		  }else{
			 $statusr=te_expense_vendor_cls::getStatus( $this->bean->id,$current_user->id);  
		  } 
		
		$this->ss->assign('roleStatus', $statusr);
		$this->ss->assign('overview', $this->bean);
		$role=new ACLRole();
		$userRole=$role->getUserRole($current_user->id);
		$approver=0;		
		if($this->bean->created_by!=$current_user->id  && $userRole['isapprove']==1){
			$approver=1;
		}
		 
		$this->ss->assign('approver', $approver);		
		$this->ss->assign('status', $this->bean->status);
		
		
		$approvers=$expObj->getAllApprovers('',$userRole['parent_role']);
		
		  
		$inQuery='';
		if($approvers && count($approvers)>0){
			foreach($approvers as $appvrs){
				$inQuery.="'".$appvrs['id']."',";
			}
		}			
		$inQuery=substr($inQuery,0, strlen($inQuery)-1);
		
		$isCancel=(!$expObj->getStatusForEdit($this->bean->id,$inQuery))? 0: 1;
		$this->ss->assign('isCancel', $isCancel);	
		
		
		parent::display();
		
	}
	
}
  

?>
