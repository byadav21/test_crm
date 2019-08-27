<?php
ini_set ( 'display_errors', 'off' );
require_once ('include/MVC/View/views/view.edit.php');
require_once ('custom/modules/te_ExpensePO/te_Expenseproverride.php');
require_once ('modules/ACLRoles/ACLRole.php');
require_once ('modules/te_expense_product/te_expense_product.php');
class te_ExpensePOViewEdit extends ViewEdit {
	
	
	public function preDisplay()
    {
        $metadataFile = $this->getMetaDataFile();
        $this->ev = $this->getEditView();
        $this->ev->ss =& $this->ss;
        $this->ev->setup($this->module, $this->bean, $metadataFile, 'custom/modules/te_ExpensePO/tpls/EditView.tpl');
    }
	
	
	function display() {
		 ?>
                 <script>
                    //batch_status
                   YAHOO.util.Event.addListener(window,"load", function() {
                   //alert('Test.....');
                   document.getElementById('btn_vendor_c').onclick=function(){
                        
                           var popup_request_data = {
                                   'call_back_function' : 'set_vendor_rfq_return',
                                   'form_name' : 'EditView',
                                   'field_to_name_array' : {
                                      'id' : 'id',
                                      'name': 'name',
                                    },
                           };
                   open_popup('te_expense_vendor', 600, 400, '&status_advanced=2', true, false, popup_request_data);
                   }
                   });
                   
                   function set_vendor_rfq_return(popup_reply_data){
                       
                        var name_to_value_array = popup_reply_data.name_to_value_array;
                        var id = name_to_value_array['id'];
                        var name = name_to_value_array['name'];
                        document.getElementById('vendor_c').value= name;
                        document.getElementById('te_expense_vendor_id_c').value = id;
                        
                        $.ajax({
                                 async: false,
                                    type: "POST",
                                    data: { 
                                      id:id,
                                      name:name,
                                      action:'getCostCenter'
                                     },
                                    dataType: "json",
                                    url: 'index.php?module=te_ExpensePO&action=getCostCenter&to_pdf=1',
                                    error: function(data){
                                    $('.countloader').hide(); 
                                    },
                                    success:function(data)
                                    {   
                                       
                                        $('#cost_center').html('');
                                        $('#cost_center').html(data.cost_center);
                                        $('#cost_center').prop('disabled', true);
                                        
                                        $('.itemtxt').html('');
                                        $('.itemtxt').html(data.product_drop);
                                        
                                        
                                        $('#gl_code_c').val('');
                                        $('#gl_code_c').val(data.gl_code);
                                        $('#gl_code_c').prop('disabled', true);
                                       
                                        
                                        

                                    } 
                            });
                        
                    }
                
                   </script>
                 <?php
		global $current_user;
		$expObj=new te_Expenseproverride();
		$roleUsr=new ACLRole();
                $exeProObj = new te_expense_product();
		$taxes=[]; 
		$items=[];
		$saveID=[];
		$document='[]';
		$docuarray=[];
                
		$this->ss->assign('isedit', 0);	
		if(!empty($_REQUEST['record'])){
			$this->ss->assign('isedit', 1);	
			$var=$_REQUEST['record'];	
			$itemDeiail=$expObj->getAllItems($var);
			$taxes=$itemDeiail['taxes'];
			$items=$itemDeiail['items'];
			$document= $this->bean->documents;		 
			$docuarray=json_decode(html_entity_decode( $this->bean->documents));
			if($this->bean->expense_type=='PO'){
				if( ($this->bean->status==2 || $this->bean->status==-1) ){
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
						echo '<h1>Expense PO >> Edit</h1><br><br><br><span style="color:red">Error: You can\'t edit this PO dueto under Supervisor approval</span>'; exit();	
				}
			}	
			 
			
                        $this->ss->assign('prtype', $this->bean->expense_type);
		}else{
			$this->ss->assign('prtype', $_REQUEST['type']);		
			
		}	
                
		$productsBean = BeanFactory::getBean('te_expense_product');
                
                $products = $productsBean->get_full_list();
               
                if ( $products != null ) {
                    
                    $expProDrop='';
                    foreach($products as $val){
			$expProDrop.= '<option value="'.$val->id.'"';
			//if($this->bean->cost_center==$key) $cost_centerddown.= ' selected ';
			$expProDrop.= ' >' . $val->name .'</option>';
		}
                } 
			
		
                
		$this->ss->assign('expProDrop', $expProDrop);
		$this->ss->assign('taxes', $GLOBALS['app_list_strings']['item_taxes']);		 
		$this->ss->assign('taxesarr', $taxes);
			 
		$this->ss->assign('items', $items);	
		 
		$this->ss->assign('document', $document);		 
		$this->ss->assign('docuarray', $docuarray);		 
		$this->ss->assign('beanid', $this->bean->id);		 
		//$this->ss->assign('prtype', $this->bean->expense_type);	 
		  
		 
		$this->ev->process();
		echo $this->ev->display($this->showTitle);
		
	}
	
	
	
}
?>
