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
	}		
}
