<?php
//print_r($_REQUEST);die;
require_once('modules/te_ExpensePO/te_ExpensePO.php');
require_once('modules/te_expenseprdetail/te_expenseprdetail.php');
require_once('modules/te_Expense_approvall/te_Expense_approvall.php');
require_once('modules/ACLRoles/ACLRole.php');
require_once ('custom/modules/te_ExpensePO/te_Expenseproverride.php');
require_once('custom/modules/te_ExpencePoPayment/te_ExpencePoPaymentprOverride.php');
require_once('modules/te_ExpencePoPayment/te_ExpencePoPayment.php');
global  $current_user;global $db;

$roles=new ACLRole();
$objExp=new te_Expenseproverride();			
		
//print_r($_REQUEST);die;
$role = new te_ExpensePO();
if(isset($_REQUEST['record']) && $_POST['record']){
	$role->id = $_POST['record'];
	$rolesData=$role->retrieve($_POST['record']);
	if(!$rolesData){
		header("Location: index.php?module=te_ExpensePO&action=DetailView&msg=1&record=". $role->id); exit();
	}
	
	if($_POST['type']=='PO'){
		if( $rolesData->status==2 || $rolesData->status==-1){
				header("Location: index.php?module=te_ExpensePO&action=DetailView&msg=2&record=". $role->id);	exit();
		}
		$approvers=[];	
		$userRole=$roles->getUserRole($current_user->id);	
		$department=$current_user->rel_fields_before_value['te_department_expense_users_1te_department_expense_ida']; 
		if($userRole['sendtofin']==1){
			$approvers=$objExp->getFacilityApprovers($userRole['parent_role'],1,0); 
		}else{
			$approvers=$objExp->getAllApprovers($department,$userRole['parent_role']);
		}
		$inQuery='';
		if($approvers && count($approvers)>0){
			foreach($approvers as $appvrs){
				$inQuery.="'".$appvrs['id']."',";
			}
		}			
		$inQuery=substr($inQuery,0, strlen($inQuery)-1);
		
		if(!$objExp->getStatusForEdit($rolesData->id,$inQuery)){
					header("Location: index.php?module=te_ExpensePO&action=DetailView&msg=2&record=". $role->id);	exit();
		}
	}	
	 
	
}

 //echo '<pre>';
//print_r($_REQUEST);die;
if(!empty($_REQUEST['items'])){

	try{
			
			$db->query('start transaction');
			if(!isset($_REQUEST['record']) || $_REQUEST['record']=='' ){
				 $itemDetal=$db->query("select refrenceid from te_expensepo where deleted='0' order by date_entered desc limit 0,1");
				 $row=$db->fetchByAssoc($itemDetal);
				 $refID= intval(date('Y')).'-';
				 $refID.= intval(date('y'))+1 .'-';
				 if($row && count($row)>0){					 
					 $newRef=explode('-',$row['refrenceid']);
					 if(count($newRef)==3){
						 $refID.=str_pad(intval($newRef[2])+1,3,'0',STR_PAD_LEFT);
					 }else{
						$refID.=str_pad('1',3,'0',STR_PAD_LEFT);	
					 }
				 }else{
				  $refID.=str_pad('1',3,'0',STR_PAD_LEFT);	 
				 }
				 $role->refrenceid = $refID;
                                 $role->name = $refID;
			}
			
			
			$role->date_entered = date('Y-m-d H:i:s');
			if($_POST['record']) $role->date_modified = date('Y-m-d H:i:s');
			$role->modified_user_id = $current_user->id;
			$role->created_by = $current_user->id;
			$role->assigned_user_id = $current_user->id;
			
			$role->inv_num = $_POST['inv_num'];
			$role->dated = $_POST['dated'];
			$role->amount = $_POST['amount'];
			
			if($_POST['type']=='PR'){
				$role->status = 2;
				$role->expense_type='PR';
				$role->porequired = 'no';
			}else{
				$role->status = 1;
				$role->expense_type='PO';
				$role->porequired = $_POST['porequired'];
			}
			$updateddoc=[];
			$document=json_decode(html_entity_decode($_POST['documents']));
			if($document && count($document)>0){
				foreach($document as $doc) 
					if($doc) $updateddoc[]=$doc;
			}
			 
			$role->documents= json_encode($updateddoc);
			if($role->save()){
				 $expID=$role->id;
				 $deletednotid=[];
				 $totalAmt=0; 
				 $totalTax=0; 
                                 
				if(count($_POST['items'])>0){
						$i=0;
						foreach($_POST['items'] as $items){
							if(isset($_POST['savedid'][$i]) && $_POST['savedid'][$i]){
								if($items!='' && $_POST['unit'][$i]>0){
									$itemsExp = new te_expenseprdetail();
									$itemsExp->id=$_POST['savedid'][$i];
									$itemsExp->name=$items;							 
									$itemsExp->date_modified=date('Y-m-d H:i:s');
									$itemsExp->modified_user_id=$current_user->id;							 
									$itemsExp->description=$_POST['itemsd'][$i];		
									$itemsExp->itemtype=0;
									$itemsExp->unit=$_POST['unit'][$i];
									$itemsExp->rate=$_POST['rate'][$i];
									$itemsExp->amounts=floatval($_POST['unit'][$i])*floatval($_POST['rate'][$i]);
									$itemsExp->save();
									$totalAmt +=floatval(floatval($_POST['unit'][$i])*floatval($_POST['rate'][$i]));
									$deletednotid[]=	$_POST['savedid'][$i];	
								}
							}else{
								if($items!='' && $_POST['unit'][$i]>0){
									$itemsExp = new te_expenseprdetail();
									$itemsExp->expenseprid=$role->id;
									$itemsExp->name=$items;
									$itemsExp->date_entered=date('Y-m-d H:i:s');
									$itemsExp->date_modified=date('Y-m-d H:i:s');
									$itemsExp->modified_user_id=$current_user->id;
									$itemsExp->created_by=$current_user->id;
									$itemsExp->assigned_user_id=$current_user->id;
                                                                        $itemsExp->description=$_POST['itemsd'][$i];
									$itemsExp->itemtype=0;
									$itemsExp->unit=$_POST['unit'][$i];
									$itemsExp->rate=$_POST['rate'][$i];
									$itemsExp->amounts=floatval($_POST['unit'][$i])*floatval($_POST['rate'][$i]);
									$itemsExp->save();
									$totalAmt +=floatval(floatval($_POST['unit'][$i])*floatval($_POST['rate'][$i]));
									$deletednotid[]=	$itemsExp->id;
								}	
							}
							$i++;	
						}
						
				}
				
				if(count($_POST['taxesp'])>0){
						$i=0;
						foreach($_POST['taxesp'] as $items){
							if(isset($_POST['savedtaxid'][$i]) && $_POST['savedtaxid'][$i]){
								if($items!='' && $_POST['tax'][$i]>0){
									$itemsExp = new te_expenseprdetail();
									$itemsExp->id=$_POST['savedtaxid'][$i];
									$itemsExp->name=$items;			
											 
									$itemsExp->date_modified=date('Y-m-d H:i:s');
									$itemsExp->modified_user_id=$current_user->id;
									$itemsExp->itemtype=1;
									$itemsExp->amounts=$_POST['tax'][$i];
									$itemsExp->save();
									$totalTax +=floatval($_POST['tax'][$i]);
									$deletednotid[]=	$_POST['savedtaxid'][$i];	
									
									
								}
							}else{
								if($items!='' && $_POST['tax'][$i]>0){
									$itemsExp = new te_expenseprdetail();
									$itemsExp->expenseprid=$role->id;
									$itemsExp->name=$items;		
									$itemsExp->date_entered=date('Y-m-d H:i:s');					 
									$itemsExp->date_modified=date('Y-m-d H:i:s');
									$itemsExp->modified_user_id=$current_user->id;
									$itemsExp->created_by=$current_user->id;
									$itemsExp->assigned_user_id=$current_user->id;
									$itemsExp->itemtype=1;
									$itemsExp->amounts=$_POST['tax'][$i];
									$itemsExp->save();
									$totalTax +=floatval($_POST['tax'][$i]);
									$deletednotid[]=	$itemsExp->id;	
								}				
								
							}	
							 $i++;
						}
				}
				
				//deleted records
				if($deletednotid && count ($deletednotid)>0){
						$var=$role->id;
						$delid='';
						foreach($deletednotid as $did){
							if($did) $delid .="'$did',";
						}
						$delid=substr($delid,0,strlen($delid)-1);
						//echo "update te_expenseprdetail set deleted=1 where expenseprid='$var' and id not in ($delid)";die;
						$db->query("update te_expenseprdetail set deleted=1 where expenseprid='$var' and id not in ($delid) ");
				}
			
			$totalNet=floatval($totalAmt) + floatval($totalTax);
			$db->query("update te_expensepo set amount=". $totalNet ." where id='". $expID ."'");	
				
			if(!isset($_REQUEST['record']) || $_REQUEST['record']=='' ){
				//echo '<pre>';//</pre>
				$exapprovers = new te_Expense_approvall();
				$exapprovers->name='submitter';
				$exapprovers->date_entered=date('Y-m-d H:i:s');	
				$exapprovers->created_by=$current_user->id;
				$exapprovers->deleted=0;
				$exapprovers->assigned_user_id=$current_user->id;
				$exapprovers->expense_id=$expID;
				if($_POST['type']!='PR'){
					$exapprovers->staus=0;
				}else{	
					$exapprovers->staus=2;
				}
				$exapprovers->save();//print_r($exapprovers);die;
				
				if($_POST['type']!='PR'){
					$department=$current_user->rel_fields_before_value['te_department_expense_users_1te_department_expense_ida'];  
					$roleArr=$roles->getUserRole($current_user->id);
					
					 
					$approvers=[];
					if($roleArr['parent_role'] &&  $roleArr['sendtofin']==0){// for submitter and approver  
						$approvers=$objExp->getAllApprovers($department,$roleArr['parent_role']);
					}else if($roleArr['sendtofin']==1){ // for ceo
						$approvers=$objExp->getFacilityApprovers($roleArr['parent_role'],1,0); 
					}
				  //print_r($approvers);die;
					if($approvers && count($approvers)>0){
						foreach($approvers as $appvrs){
							$exapprovers = new te_Expense_approvall(); 
							$exapprovers->name='approver';
							$exapprovers->date_entered=date('Y-m-d H:i:s');	
							$exapprovers->created_by=$current_user->id;
							$exapprovers->deleted=0;
							$exapprovers->assigned_user_id=$appvrs['id'];
							
							$exapprovers->expense_id=$expID;
							$exapprovers->staus=0;
							$exapprovers->save();
						}
					}
				}
			 }	
			
			 if($_POST['type']=='PR'){
				 $paymentObj= new te_ExpencePoPayment();
				if(isset($_REQUEST['record']) && $_POST['record']){
					
					$expInv=$paymentObj->retrieve_by_string_fields(array('exenseid' => $expID ));
					if(isset($expInv->id) && $expInv->id){
				      $paymentObj->id=$expInv->id;		
					}	
				}	 				 
				$paymentObj->date_entered_c=date('Y-m-d',strtotime($_POST['dated']));	 
				$paymentObj->amount=floatval($totalAmt);	 
				$paymentObj->tax=floatval($totalTax);	 
				$paymentObj->is_last_payment=0;
				$paymentObj->taxlabel='Tax';	 
				$paymentObj->invoice_no=$_POST['inv_num'];	 
				$paymentObj->exenseid=$expID;
				$paymentObj->status_c=2;
				$paymentObj->invocedocs_c=json_encode($_POST['documents']);
				$paymentObj->assigned_user_id=$current_user->id;
				$paymentObj->save();				 
			 }	 
			
				
			}
		 
			$db->query('commit');
                        header("Location: index.php?module=te_ExpensePO&action=DetailView&record=". $role->id);
		}catch(Exception $e){
			$db->query('rollback');
                       
                        header("Location: index.php?module=te_ExpensePO&action=ListView");
		}	
	
}else{
ob_clean();	
    $flc_module = 'All';
    foreach($_POST as $name=>$value){
    	if(substr_count($name, 'act_guid') > 0){
    		$name = str_replace('act_guid', '', $name);
    
    		$role->setAction($role->id,$name, $value);
    	}
    	
    }
    echo "result = {role_id:'$role->id', module:'$flc_module'}";
    sugar_cleanup(true);
     header("Location: index.php?module=te_ExpensePO&action=ListView");
}
 

