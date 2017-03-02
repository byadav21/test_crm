<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
class DropoutRequest{	
    
	function approveDropoutRequest($bean, $event, $argument){	
	    global $current_user;
		if($bean->dropout_status=="Pending" && $current_user->designation=="BUH"){
			$dropout_action_list =$GLOBALS['app_list_strings']['dropuout_status_list'];
			$action="<span id='dropout_request_".$bean->id."'></span><select name='dropout_status' id='".$bean->id."' onchange='return changeDropoutStatus(this.id,this.value);' style='width:113PX !IMPORTANT'><option value=''>--select--</option>";
			foreach($dropout_action_list as $key=>$value){
				if($bean->dropout_status==$key)
					$action.="<option value='".$key."' selected>".$value."</option>";
				else
					$action.="<option value='".$key."'>".$value."</option>";			
			}
			$action.="</select>";
			$bean->dropout_status=$action;
		}	
	}		
}
