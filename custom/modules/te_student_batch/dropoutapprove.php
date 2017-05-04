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

#mail Send for dropot reject Status

if(isset($_REQUEST['request_status']) &&$_REQUEST['request_status']=="Rejected"){
	global $db;
			
		    $studentSql="SELECT email,name FROM `te_student` WHERE lead_id_c = '".$lead_id."'";
			$studentObj = $db->query($studentSql);
			$student = $db->fetchByAssoc($studentObj);
			$studentemail=$student['email'];
			
    # Find program And istitute
            $sql_program="SELECT Ts.name as institute,Ps.name as program,Sb.id FROM `te_student_batch` Sb INNER JOIN te_pr_programs Ps ON Ps.id=Sb.te_pr_programs_id_c INNER JOIN te_in_institutes Ts ON Ts.id=Sb.te_in_institutes_id_c WHERE Sb.id='".$_REQUEST['request_id']."'";
			$programObj = $db->query($sql_program);
			$progrm_result = $db->fetchByAssoc($programObj);
    
            $template= "<p> Dear ".$student['name'].",</p>

			<p>Greetings!</p>

			<p>This is in response to your request for cancellation of enrolment, and refund for the programme  ".$progrm_result['program']." ".$progrm_result['institute'].", you have registered for with Talentedge.</p>
			<p>We would like to inform you that you do not quality for refund as per policy, as governed by the terms & conditions of Talentedge.</p>
			<p>Given below are the relevant excerpts of the cancellation policy that you signed-up & agreed-for while registering for the programme offered by Talentedge.</p>
			<p>Cancellation by the Participant</p>
			<p>Requests for refund of fees on account of cancellation of enrolment shall be considered only if such requests are received prior to closure of registration or 21 days before date of course commencement whichever is earlier.</p>
			<p>In event that such valid requests for refund of fees are received, the application money shall be refunded after deducting a penalty of Rs.5000 and applicable taxes for Indian participants & USD 125 for foreign participants.</p>
			<p>In all other cases, no refund shall be made.
			<p>A participant may opt for rescheduling to a later batch of the same program / another program of prior to commencement of the program. However, such intimation must be made by the participant at least fifteen days prior to the commencement of the program. The amounts paid by the participant shall be considered as advance payment towards the next batch / alternative program. Further, the participant shall have to pay an administrative charge of Rs.5000 plus applicable taxes (Indian participants) or USD 125 (foreign participants) for facilitating such rescheduling.</p>
			<p>Cancellation by the Talentedge & Institute</p>
			<p>Talentedge & the Institute, reserves the right to cancel courses at any time owing to reasons like insufficient enrolments, trainer indisposition or force majeure events. In the event that Talentedge or the Institute cancels a scheduled course, the student will receive full fee refund for the same. All refunds will be processed within 30 days of receipt of a valid refund request.</p>

			<p>The terms and conditions which are explicitly mentioned in the Talentedge website, </p><p>and have been agreed upon by you while registering for the programme-
			https://talentedge.in/end-user-agreement/ </p>

			<p>Please feel free to reach out to your counsellor for any other information.</p>

			<p>Regards,</p>
			<p>Student Relations Manager</p>
			<p>Enquiries and Customer Support, Contact No: +91-8376000600</p>";

			$mail = new NetCoreEmail();
			$mail->sendEmail($studentemail,"Dropout Request Reject",$template);
	
		
		}
#mail for Dropot Apporoved @Manish

if(isset($_REQUEST['request_status']) && $_REQUEST['request_status']=="Approved"){
    $_REQUEST['request_status'];
	global $db;
			
			$studentSql="SELECT email,name FROM `te_student` WHERE lead_id_c = '".$lead_id."'";
			$studentObj = $db->query($studentSql);
			$student = $db->fetchByAssoc($studentObj);
			$studentemail=$student['email'];
			
        # Find program And istitute
            $sql_program="SELECT Ts.name as institute,Ps.name as program,Sb.id FROM `te_student_batch` Sb INNER JOIN te_pr_programs Ps ON Ps.id=Sb.te_pr_programs_id_c INNER JOIN te_in_institutes Ts ON Ts.id=Sb.te_in_institutes_id_c WHERE Sb.id='".$_REQUEST['request_id']."'";
			$programObj = $db->query($sql_program);
			$progrm_result = $db->fetchByAssoc($programObj);
    
			$template="<p> Dear-".$student['name'].",</p>

                        <p>Greetings! $sql_program </p>

                        <p>This is in response to your request for cancellation of enrolment, and refund for the programme ".$progrm_result['program']." ".$progrm_result['institute'].", you have registered for.</p>
                        <p>As a special case, we are processing a Full Refund of the fee paid by you totalling ".$_REQUEST['refund_amount']."</p>
                        <p>Request you to please share your Bank account details with us to process the NEFT transfer of refund amount into your bank account. The amount will be credited in your account within 30 working days post receipt of your Bank account details.</p>
                        <p>Details required from you:</p>
                        <p>Your Name as per bank records-</p>
                        <p>Your Bank’s name-</p>
                        <p>Your Bank a/c no.-</p>
                        <p>Your Bank’s IFSC code-</p>

                         <p>Please feel free to reach out to your counsellor for any other information.</p>

                        <p>Regards,</p>
                        <p>Student Relations Manager</p>
                        <p>Enquiries and Customer Support, Contact No: +91-8376000600</p>";

  		
			$mail = new NetCoreEmail();
			$mail->sendEmail($studentemail,"Dropout Request Approved",$template);
		
		}	

echo json_encode($dropoutStatue);
return false;

?>
