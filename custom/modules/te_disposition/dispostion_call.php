<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
class dispostionClass{
function dispostionFunc($bean, $event, $argument){
	
	//if((isset($_REQUEST['status_detail']) && !empty($_REQUEST['status_detail'])) && ($_REQUEST['status_detail']=='Call Back' || $_REQUEST['status_detail']=='Prospect' || $_REQUEST['status_detail']=='Follow Up')){
	$staus=$_REQUEST['status'];
	$discription=$_REQUEST['description'];
	//$status_details=$_REQUEST['status_detail'];
	
	
	if((isset($_REQUEST['status_detail']) && !empty($_REQUEST['status_detail'])) && ($_REQUEST['status_detail']=='Call Back' || $_REQUEST['status_detail']=='Prospect' || $_REQUEST['status_detail']=='Follow Up')){
	//$datoff=$_REQUEST['date_of_callback'];
	//$datoff=$_REQUEST['date_of_followup'];
	//$datoff=$_REQUEST['date_of_prospect'];
	if($_REQUEST['status_detail']=="Call Back")
		{
		$datoff=$_REQUEST['date_of_callback'];
		
		}
	if($_REQUEST['status_detail']=="Follow Up")
		{
		$datoff=$_REQUEST['date_of_followup'];
		
		}
	if($_REQUEST['status_detail']=="Prospect")
		{
		$datoff=$_REQUEST['date_of_prospect'];
		}
	
	
	
	$call  = new Call();
	/*
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
	
	*/
	// value save in call 
	
	
	$call->name =$staus;
	$call->date_start=$datoff;
	$call->description=	$discription;
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
			}	
	
	
}
