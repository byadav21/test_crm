<?php
//~ print_r($_REQUEST);
$disposition = new te_disposition();
$disposition->disable_row_level_security=true;
$disposition->retrieve($_REQUEST['disposition_id']);
$unique_call_id = $disposition->unique_call_id;

$sqlDispo = "SELECT unique_id FROM neox_call_details_update WHERE unique_id ='".$unique_call_id."'";
$resDispo = $GLOBALS['db']->query($sqlDispo);
if($GLOBALS['db']->getRowCount($resDispo)>0){
	if(isset($_REQUEST['disposition_id']) && !empty($_REQUEST['disposition_id'])){
		$disposition = new te_disposition();
		$disposition->disable_row_level_security=true;
		$disposition->retrieve($_REQUEST['disposition_id']);
		$unique_call_id = $disposition->unique_call_id;
		$disposition->status 	   = $_REQUEST['status'];
		$disposition->status_detail  = $_REQUEST['status_detail'];

		$disposition->description			 = $_REQUEST['description'];
		//$callback = date('Y-m-d H:i:s',strtotime($_REQUEST['callback']));
		$disposition->date_of_callback=date('Y-m-d H:i:s',strtotime('-5 hour -30 minutes',strtotime($_REQUEST['callback'])));	 
		$disposition->date_of_followup	 = date('Y-m-d H:i:s',strtotime('-5 hour -30 minutes',strtotime($_REQUEST['followup'])));
		$disposition->date_of_prospect	 = date('Y-m-d H:i:s',strtotime('-5 hour -30 minutes',strtotime($_REQUEST['prospect'])));
		$disposition->name 		   	 = $_REQUEST['status'];
		//~ $disposition->unique_call_id 		   	 = $_REQUEST['call_id'];
		//~ $disposition->te_disposition_leadsleads_ida 		   	 = $_REQUEST['lead_id'];
		$disposition->save();
		
		if((isset($_REQUEST['status_detail']) && !empty($_REQUEST['status_detail'])) && ($_REQUEST['status_detail']=='Call Back' || $_REQUEST['status_detail']=='Prospect' || $_REQUEST['status_detail']=='Follow Up')){
		$call  = new Call();
		$call->name = $_REQUEST['status'];
			if((isset($_REQUEST['status_detail']) && !empty($_REQUEST['status_detail'])) && $_REQUEST['status_detail']=='Call Back')
			{
				$call->date_start =date('Y-m-d H:i:s',strtotime('-5 hour -30 minutes',strtotime($_REQUEST['callback'])));
			}
			if((isset($_REQUEST['status_detail']) && !empty($_REQUEST['status_detail'])) && $_REQUEST['status_detail']=='Follow Up')
			{
				$call->date_start =date('Y-m-d H:i:s',strtotime('-5 hour -30 minutes',strtotime($_REQUEST['followup'])));
			}
			if((isset($_REQUEST['status_detail']) && !empty($_REQUEST['status_detail'])) && $_REQUEST['status_detail']=='Prospect')
			{
				$call->date_start =date('Y-m-d H:i:s',strtotime('-5 hour -30 minutes',strtotime($_REQUEST['prospect'])));
			}
			
			
		$call->duration_minutes = "15";
		$call->status = "Planned";
		$call->direction = "Outbound";
		$call->parent_type = "Leads";
		$call->parent_id = $_REQUEST['lead_id'];
		$call->assigned_user_id = $GLOBALS['current_user']->id;
		$call_id = $call->save();
		
		$reminder = new Reminder();
		$reminder->popup = '1';
		$reminder->timer_popup = '300';
		$reminder->related_event_module = 'Calls';
		$reminder->related_event_module_id = $call_id;
		$reminder_id = $reminder->save();

		$reminder_invitee = new Reminder_Invitee();
		$reminder_invitee->reminder_id = $reminder_id;
		$reminder_invitee->related_invitee_module = 'Users';
		$reminder_invitee->related_invitee_module_id = '1';
		$reminder_invitee = $reminder_invitee->save();
	   }
		
	// Call Resume API	

		
			$server_ip 		= $GLOBALS['sugar_config']['neox']['server_ip'];
			$event          = "neox_agent_pause";
			$user           = $GLOBALS['current_user']->neox_user;
			$password       = $GLOBALS['current_user']->neox_password;
			$value_pr       = "Resume"; 
			$neoxKey   		= $GLOBALS['sugar_config']['neox']['secret_key'];
			$URL = "http://$server_ip:9090/Neox_DialCenter_API/agent_pause_resume.php?secret_key=".$neoxKey;
			$QUERY_PARAM = "data={\"event\":\"$event\",\"user\":\"$user\",\"value_pr\":\"$value_pr\"}";
			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL,"$URL");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, "$QUERY_PARAM");
			$buffer = curl_exec($ch);
		
	//----------------	
		echo "1";
	}
	else{
		echo "Disposition Id and Status should not empty";	
	}
}
else{
	echo "2";
}
?>
