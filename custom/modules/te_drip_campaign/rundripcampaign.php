<?php
if(!defined('sugarEntry')) {
	define('sugarEntry', true);
}
ini_set('memory_limit','1024M');
require_once('include/entryPoint.php');
require_once('custom/include/Email/sendmail.php'); 
require_once('modules/EmailTemplates/EmailTemplate.php'); 
global $db;

$dripSql="SELECT DATE_FORMAT(drip.date_entered, '%Y-%m-%d') as date_entered,drip.te_ba_batch_id_c as batch_id,driplist.name as template,driplist.mailer_day FROM te_drip_campaign drip INNER JOIN te_drip_campaign_te_drip_campaign_list_c rel ON drip.id=rel.te_drip_campaign_te_drip_campaign_listte_drip_campaign_ida INNER JOIN te_drip_campaign_list driplist ON rel.te_drip_campaign_te_drip_campaign_listte_drip_campaign_list_idb=driplist.id where drip.deleted=0 ORDER BY driplist.mailer_day";
$dripObj = $db->query($dripSql);
$dripDetails=array();
while($row=$db->fetchByAssoc($dripObj)){
	$dripDetails[$row['batch_id']][]=$row;
}
foreach($dripDetails as $batch_id=>$dripList){
	$leadSql="SELECT email_addresses.email_address,leads.id as id,DATE(leads.date_entered) as date_created,leads.mailer_day FROM leads INNER JOIN leads_cstm ON leads.id = leads_cstm.id_c INNER JOIN email_addr_bean_rel ON email_addr_bean_rel.bean_id = leads.id AND email_addr_bean_rel.bean_module ='Leads' INNER JOIN email_addresses ON email_addresses.id =  email_addr_bean_rel.email_address_id WHERE leads.deleted = 0 AND leads_cstm.te_ba_batch_id_c = '".$batch_id."'";
	$leadObj = $db->query($leadSql);

	while($lead=$db->fetchByAssoc($leadObj)){		
		for($x=0;$x<count($dripList);$x++){
			$drip_mailer_day=date( "Y-m-d", strtotime( $lead['date_created']." +".$dripList[$x]['mailer_day']." day" ));
			if($drip_mailer_day==date('Y-m-d')){
				$aParam['template_id'] = $dripList[$x]['template_id'];
				$aParam['lead_id'] = $lead['id'];
				$aParam['email']=$lead['email_address'];
				if($mail=send_email($aParam)){
					$db->query("UPDATE leads SET mailer_day='".$dripList[$x]['mailer_day']."' WHERE id='".$lead['id']."'");
				}				
				break;
			}
		}			
	}
}
function send_email($aParam) {
	$email_template_bean = get_email_template($aParam);
	if (!$email_template_bean || empty($email_template_bean -> id)) {
		return false;
	}
	$subject=$email_template_bean->subject;
	$body = wordwrap($email_template_bean ->body_html, 900);
	$to=$aParam['email'];
	$mail = new NetCoreEmail();
	$mail->sendEmail($to,$subject,$body);
	return TRUE;
}
function get_email_template($aParam) {
	global $sugar_config;	
	if (empty($aParam['template_id'])) {
		return false;
	}
	$email_template_bean = new EmailTemplate;
	$email_template_bean -> retrieve($aParam['template_id']);
	if (empty($email_template_bean -> id)) {
		return false;
	}
	$lead_bean = BeanFactory::getBean('Leads', $aParam['lead_id']);
	
	$email_template_bean -> body_html = $email_template_bean -> parse_template_bean($email_template_bean -> body_html, $lead_bean->module_dir, $lead_bean);	
	
	$email_template_bean -> body_html = from_html($email_template_bean -> body_html);
	return $email_template_bean;
}
?>
