<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

ini_set('memory_limit','1024M');
require_once('include/entryPoint.php');
require_once('custom/include/Email/sendmail.php'); 
require_once('modules/EmailTemplates/EmailTemplate.php'); 
global $db,$sugar_config;;

echo $contractSql = "SELECT id,expiry_alert,renewal_reminder_date FROM aos_contracts WHERE deleted=0";
$contractObj = $db->query($contractSql);
$expiry_alert=array();
while($contract = $db->fetchByAssoc($contractObj)){
	$alert_date1 = date('Y-m-d', strtotime('-15 day', strtotime($contract['renewal_reminder_date'])));
	$alert_date2 = date('Y-m-d', strtotime('-30 day', strtotime($contract['renewal_reminder_date'])));
	if($alert_date1==date("Y-m-d")){
		$aParam['contract_expiry_template_id'] = $sugar_config['contract_expiry_template_id'];
		$aParam['contract_id'] = $contract['id'];
		$aParam['dayAlert']=15;
		$mail=send_email($aParam);
	}elseif($alert_date2==date("Y-m-d")){
		$aParam['contract_expiry_template_id'] = $sugar_config['contract_expiry_template_id'];
		$aParam['contract_id'] = $contract['id'];
		$aParam['dayAlert']=30;
		$mail=send_email($aParam);
	}	
	echo"<br>".$mail;
}
function send_email($aParam) {
	$email_template_bean = get_email_template($aParam);
	if (!$email_template_bean || empty($email_template_bean -> id)) {
		return false;
	}
	$subject=$email_template_bean->subject;
	$body = wordwrap($email_template_bean ->body_html, 900);
	$to='ravibhushanblevel@gmail.com';
	$mail = new NetCoreEmail();
	$mail -> sendEmail($to,$subject,$body);
	return TRUE;
}
function get_email_template($aParam) {
	global $sugar_config;	
	if (empty($aParam['contract_expiry_template_id'])) {
		return false;
	}
	$email_template_bean = new EmailTemplate;
	$email_template_bean -> retrieve($aParam['contract_expiry_template_id']);
	if (empty($email_template_bean -> id)) {
		return false;
	}
	
	//$email_template_bean -> body_html = str_ireplace('$site_url', rtrim($sugar_config['site_url'], "/"), $email_template_bean -> body_html);
	//User Parse Body HTML
	$contract_bean = BeanFactory::getBean('AOS_Contracts', $aParam['contract_id']);
	$email_template_bean->body_html = str_replace('$aos_contracts_expiry_alert ', $aParam['dayAlert'] , $email_template_bean->body_html);
	
	$email_template_bean -> body_html = $email_template_bean -> parse_template_bean($email_template_bean -> body_html, $contract_bean -> module_dir, $contract_bean);	
	
	$email_template_bean -> body_html = from_html($email_template_bean -> body_html);
	return $email_template_bean;
}