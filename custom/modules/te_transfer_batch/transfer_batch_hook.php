<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
 
class BatchTransferRequest{	
	function approveBatchTransferRequest($bean, $event, $argument){	
		global $db;
		 
		  $programmeOld="select p.te_pr_programs_te_ba_batch_1te_pr_programs_ida as id from te_ba_batch as b inner join te_pr_programs_te_ba_batch_1_c as p on p.te_pr_programs_te_ba_batch_1te_ba_batch_idb=b.id where b.id='".$bean->oldbackup."' and b.deleted=0";
		 $programObj=$db->query($programmeOld);
		 $programObjOld=$db->fetchByAssoc($programObj);
		
		
		  $programmeNew="select p.te_pr_programs_te_ba_batch_1te_pr_programs_ida as id from te_ba_batch as b inner join te_pr_programs_te_ba_batch_1_c as p on p.te_pr_programs_te_ba_batch_1te_ba_batch_idb=b.id where b.id='".$bean->te_ba_batch_id_c."' and b.deleted=0";
		$programObj=$db->query($programmeNew);
		$programObjNew=$db->fetchByAssoc($programObj);
		$bean->country=($programObjOld['id']==$programObjNew['id']) ? 'Batch'	: 'Programme';
	 
		
		$data=$db->fetchByAssoc($programObj);
					
		if($bean->status=="Pending"){
			 global $current_user;
			// print_r($_SESSION['ACL'][$current_user->id]['te_transfer_batch']); 
			 
			 
			if(ACLController::checkAccess('te_transfer_batch','edit')){
				
				$batch_action_list =$GLOBALS['app_list_strings']['dropuout_status_list'];
				$action="<span id='batch_transfer_request_".$bean->id."'></span><select name='status' id='".$bean->id."' onchange='return changeTransferStatus(this.id,this.value);'><option value='' style='width:30px;'>--select--</option>";
				foreach($batch_action_list as $key=>$value){
					if($bean->status==$key)
						$action.="<option value='".$key."' selected>".$value."</option>";
					else
						$action.="<option value='".$key."'>".$value."</option>";			
				}
				$action.="</select>";
				$bean->status=$action;
				
			} 
			
			
			
		}
		
		$sql="select name from te_ba_batch where id='".$bean->te_student_batch_id_c."' and deleted=0";
		$programObj=$db->query($sql);
		$data=$db->fetchByAssoc($programObj);
		
		$bean->old_batch=$data['name'];
			
	}		
}
