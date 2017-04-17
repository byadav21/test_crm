<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

ini_set('memory_limit','1024M');
require_once('include/entryPoint.php');
require_once('custom/include/Email/sendmail.php');
global $db;

$dropoutSql="UPDATE te_student_batch SET is_new_approved=1,dropout_status='".$_REQUEST['request_status']."',refund_date='".$GLOBALS['timedate']->to_db_date($_REQUEST['refund_date'],false)."',refund_amount='".$_REQUEST['refund_amount']."',dropout_type='".$_REQUEST['dropout_type']."', approved_by='".$_REQUEST['current_user_id']."' WHERE id='".$_REQUEST['request_id']."'";
$GLOBALS['db']->query($dropoutSql);

$lead_id = $_REQUEST['lead_id'];

#update lead status as Dropout
//$GLOBALS['db']->query("UPDATE leads SET status='".$_REQUEST['request_status']."' AND status_description='".$_REQUEST['request_status']."' WHERE id='".$lead_id."'");
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
	
$dropoutStatue['status']="Approved";

#mail for dropot apporoved /reject

if(isset($_REQUEST['request_status']) &&$_REQUEST['request_status']=="Rejected"){
	global $db;
			
			$studentSql="SELECT email,name FROM `te_student` WHERE lead_id_c = '".$lead_id."'";
			$studentObj = $db->query($studentSql);
			$student = $db->fetchByAssoc($studentObj);
			$studentemail=$student['email'];
			
			$template="<p>Hello ".$student['name']."</p>
						<p>Your Dropout Request Rejected </p>
						<p>Please have a look and take action accordingly</p>
						<p></p><p>Thanks & Regards</p>
						<p>SRM Team</p>";
					
			$mail = new NetCoreEmail();
			$mail->sendEmail($studentemail,"Request",$template);
	
		
		}
#mail for dropot apporoved /reject -2 ++

if(isset($_REQUEST['request_status']) && $_REQUEST['request_status']=="Approved"){
	
	global $db;
			
			$studentSql="SELECT email,name FROM `te_student` WHERE lead_id_c = '".$lead_id."'";
			$studentObj = $db->query($studentSql);
			$student = $db->fetchByAssoc($studentObj);
			$studentemail=$student['email'];
			
			$template="<p>Hello ".$student['name']."</p>
					    <p> Refaund Amount - ".$_REQUEST['refund_amount']."</p>
					     <p> Refaund date - ".$_REQUEST['refund_date']."</p>
						<p>Your Dropout hasbeen Approved</p>
						<p>Please Waite For Appovel </p>
						<p>Please have a look and take action accordingly</p>
						<p></p><p>Thanks & Regards</p>
						<p>SRM Team</p>";
					
			$mail = new NetCoreEmail();
			$mail->sendEmail($studentemail,"Dropout Request",$template);
		
		}	

echo json_encode($dropoutStatue);
return false;

?>
