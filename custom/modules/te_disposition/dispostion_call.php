<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
class dispostionClass{
		
function dispostionFunc($bean, $event, $argument){
	global $db;
	
	
	$value=$bean->id;
	
	$Quer1 =$db->query("SELECT te_disposition_leadsleads_ida FROM te_disposition_leads_c where te_disposition_leadste_disposition_idb  = '".$bean->id."' AND deleted =0");
	$result1 =$db->fetchByAssoc($Quer1);
	$leadid=$result1['te_disposition_leadsleads_ida'];
	

// leads first name 
//echo $er="SELECT name,(SELECT leads.first_name FROM leads WHERE leads.id='".$leadid."')leads_name FROM te_ba_batch WHERE id=(SELECT `te_ba_batch_id_c` FROM leads_cstm WHERE id_c='".$leadid."' AND deleted = 0")";
	$Quer10 =$db->query("SELECT name,(SELECT leads.first_name FROM leads WHERE leads.id='".$leadid."')leads_name FROM te_ba_batch WHERE id=(SELECT te_ba_batch_id_c FROM leads_cstm WHERE id_c='".$leadid."' AND deleted = 0)");
	$result10 =$db->fetchByAssoc($Quer10);

	$fstname=$result10['leads_name'];
	$batch=$result10['name'];


	//if((isset($_REQUEST['status_detail']) && !empty($_REQUEST['status_detail'])) && ($_REQUEST['status_detail']=='Call Back' || $_REQUEST['status_detail']=='Prospect' || $_REQUEST['status_detail']=='Follow Up')){
	$staus=$_REQUEST['status'];
	//$discription=$_REQUEST['description'];
	//$sta=$_REQUEST['record'];
	
	if((isset($_REQUEST['status_description']) && !empty($_REQUEST['status_description'])) && ($_REQUEST['status_description']=='Call Back' || $_REQUEST['status_description']=='Prospect' || $_REQUEST['status_description']=='Follow Up')){
	//$datoff=$_REQUEST['date_of_callback'];
	//$datoff=$_REQUEST['date_of_followup'];
	//$datoff=$_REQUEST['date_of_prospect'];
	if($_REQUEST['status_description']=="Call Back")
		{
		$datoff=$_REQUEST['date_of_callback'];
		
		}
	if($_REQUEST['status_description']=="Follow Up")
		{
		$datoff=$_REQUEST['date_of_followup'];
		
		}
	if($_REQUEST['status_description']=="Prospect")
		{
		$datoff=$_REQUEST['date_of_prospect'];
		}
	
	
	$call  = new Call();
	
	
	$call->name =$fstname."-".$staus;
	$call->date_start=$datoff;
	$call->description=	"Name- ".$fstname." Batch- ".$batch;
	$call->duration_minutes = "15";
	$call->status = "Planned";
	$call->direction = "Outbound";
	$call->parent_type = "Leads";
	$call->parent_id =$leadid;
	$call->assigned_user_id = $GLOBALS['current_user']->id;
	$call_id = $call;
	$call_id = $call->save();
	$date = date('Y-m-d H:i:s');
	$Quer1 =$db->query("INSERT INTO calls_leads (id,call_id,lead_id,required,accept_status,date_modified) VALUES ('".$call_id."','".$call_id."','".$leadid."',1,'none','".$date."')");
		
	//echo $Q="INSERT INTO calls_leads (id,call_id,lead_id,required,accept_status) VALUES ('".$call_id."','".$call_id."','".$leadid."',1,'none')";
		//die();
	
	$reminder = new Reminder();
	$reminder->popup = '1';
	$reminder->timer_popup = '300';
	$reminder->related_event_module = 'Calls';
	$reminder->related_event_module_id = $call_id;
	$reminder_id = $reminder->save();

	$reminder_invitee = new Reminder_Invitee();
	$reminder_invitee->reminder_id = $reminder_id;
	$reminder_invitee->related_invitee_module = 'Users';
	$reminder_invitee->related_invitee_module_id = $GLOBALS['current_user']->id;
	$reminder_invitee = $reminder_invitee->save();
	
	
	
	
		}
	
		
			}
	
				
	
	
}
