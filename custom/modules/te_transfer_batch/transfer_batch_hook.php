<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
class BatchTransferRequest{	
	function approveBatchTransferRequest($bean, $event, $argument){				
		if($bean->status=="Pending"){
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
		global $db;
		$sql="select name from te_ba_batch where id='".$bean->te_student_batch_id_c."' and deleted=0";
		$programObj=$db->query($sql);
		$data=$db->fetchByAssoc($programObj);
		
		$bean->old_batch=$data['name'];
			
	}		
}
