<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

ini_set('memory_limit','1024M');
require_once('include/entryPoint.php');
global $db;

$dropoutSql="UPDATE te_student_batch SET dropout_status='".$_REQUEST['request_status']."',refund_date='".$GLOBALS['timedate']->to_db_date($_REQUEST['refund_date'],false)."',refund_amount='".$_REQUEST['refund_amount']."',dropout_type='".$_REQUEST['dropout_type']."', approved_by='".$_REQUEST['current_user_id']."' WHERE id='".$_REQUEST['request_id']."'";
$GLOBALS['db']->query($dropoutSql);

$lead_id = $_REQUEST['lead_id'];

#update lead status as Dropout
$GLOBALS['db']->query("UPDATE leads SET status='".$_REQUEST['request_status']."' AND status_description='".$_REQUEST['request_status']."' WHERE id='".$lead_id."'");
#Add new Disposition Record
$disposition = new te_disposition();
$disposition->status 	   = 'Dropout';
$disposition->status_detail  = 'Dropout';

$disposition->date_of_callback			 = date('Y-m-d');
$disposition->date_of_followup			 = date('Y-m-d');
$disposition->date_of_prospect			 = date('Y-m-d');
$disposition->name 		   	 = 'Dropout';
$disposition->te_disposition_leadsleads_ida = $lead_id;
$disposition->save();

$sqlL = "UPDATE leads SET status='Dropout',status_description='Dropout' WHERE id ='".$lead_id."'";
$GLOBALS['db']->query($sqlL);
//------------------------------------------------------


$dropoutStatue['status']="Approved";
echo json_encode($dropoutStatue);
return false;

?>