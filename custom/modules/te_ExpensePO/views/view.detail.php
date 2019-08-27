<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('include/MVC/View/views/view.detail.php');
require_once('include/utils.php');
require_once('include/DetailView/DetailView2.php');
require_once ('custom/modules/te_ExpensePO/te_Expenseproverride.php');
require_once ('modules/ACLRoles/ACLRole.php');
require_once ('modules/te_expense_product/te_expense_product.php');
class te_ExpensePOViewDetail extends ViewDetail {


    public function preDisplay()
    {
 	    global $current_user;
 	    $role=new ACLRole();
		$userRole=$role->getUserRole($current_user->id);
		 
 	     if($this->bean->status==2 ){ 
				require('custom/modules/te_ExpensePO/views/detailhelperview.php');
		 }
 	    $metadataFile = $this->getMetaDataFile();
 	    $this->dv = new DetailView2();
 	    $this->dv->ss =&  $this->ss; 	    
 	    $this->dv->setup($this->module, $this->bean, $metadataFile, get_custom_file_if_exists('custom/modules/te_ExpensePO/tpls/DetailView/DetailView.tpl'));
    }  


	  
	public function display(){
		global $current_user;
		$expObj=new te_Expenseproverride();
		if(!$expObj->checkACLDetailView($this->bean->id,$current_user->id) && !$current_user->is_admin){
			echo 'UNAUTHORIZED ACCESS !!';die;
			 
		}
		
 
		
		$payments=$expObj->getPayments($this->bean->id);
		//print_r($payments);die;
		$taxes=[]; 
		$items=[];
		$saveID=[];
		$document='[]';
		$docuarray=[];
		$total=0;
		$totaltaxes=0;
 
		if(!empty($_REQUEST['record'])){
			$var=$_REQUEST['record'];	
			$itemDeiail=$expObj->getAllItems($var);
			$taxes=$itemDeiail['taxes'];
			$items=$itemDeiail['items'];
                        $description = $itemDeiail['description'];
			$docuarray=json_decode(html_entity_decode( $this->bean->documents));	
			foreach($items as $itm)	{
			  $total +=floatval($itm['amt']);	
			}	
			foreach($taxes as $itm)	{
			  $totaltaxes +=floatval($itm['amt']);	
			}	
		}
		
		 
	  if($current_user->is_admin){
		 $statusr=te_Expenseproverride::getStatus( $this->bean->id);
      }else{
		 $statusr=te_Expenseproverride::getStatus( $this->bean->id,$current_user->id);  
	  }	  
	  
		 	 
		$this->ss->assign('totalamt', array('nettotal'=>number_format($this->bean->amount, 2, '.',''),'total'=> number_format($total, 2, '.', ','),'taxes'=>number_format($totaltaxes, 2, '.', ',')));			 
		$this->ss->assign('taxesarr', $taxes);	
                //print_r($items);
                
                $proName = new te_expense_product();
                
                foreach ($items as $key=>$val){
                    $proName->retrieve($val['name']);
                   //echo $proName->name;
                    //$items[]=$val;
                    $items[$key]['proname']=$proName->name;
                    
                }
                
               // print_r($items);
                $this->ss->assign('description', $description);	
		$this->ss->assign('items', $items);	
		$this->ss->assign('roleStatus', $statusr);	
		 
		$this->ss->assign('document', $document);		 
		$this->ss->assign('docuarray', $docuarray);	
		$this->bean->amount=number_format($this->bean->amount, 2, '.', '');	
		$this->ss->assign('overview', $this->bean);	
		$this->ss->assign('taxeslbl', $GLOBALS['app_list_strings']['item_taxes']);		
		$role=new ACLRole();
		$userRole=$role->getUserRole($current_user->id);
		
		$approver=0;		
		if($this->bean->created_by!=$current_user->id  && $userRole['isapprove']==1){
			$approver=1;
		}
		 
		$this->ss->assign('approver', $approver);		
		$this->ss->assign('status', $this->bean->status);		
		$this->ss->assign('sendtofin', $userRole['sendtofin']);		
		$this->ss->assign('isfacility', $userRole['isfacility']);
		
		$podocs=json_decode(html_entity_decode($this->bean->podocument));
		
		$this->ss->assign('podocs', $podocs);		
		$podownloader=te_Expenseproverride::getStatus( $this->bean->id,$current_user->id,1);
		$this->ss->assign('podownloader', $podownloader); 		
		$this->ss->assign('payments', $payments); 		
		
		
			
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
		
		$isCancel=(!$expObj->getStatusForEdit($this->bean->id,$inQuery))? 0: 1;
		$this->ss->assign('isCancel', $isCancel);	
		
		
		parent::display();
		
	}
	
}
  

?>
