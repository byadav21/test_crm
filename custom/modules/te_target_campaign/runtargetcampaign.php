<?php
if(!defined('sugarEntry')) {
	define('sugarEntry', true);
}
ini_set('memory_limit','1024M');
require_once('include/entryPoint.php');
require_once('custom/include/Email/sendmail.php'); 
require_once('modules/EmailTemplates/EmailTemplate.php'); 
global $db;

$targetCampaignListSql="SELECT id,name,email,template FROM te_target_campaign_list WHERE status<>'Sent' AND deleted=0 LIMIT 0,50";
$targetCampaignListObj = $db->query($targetCampaignListSql);
$dripDetails=array();
while($row=$db->fetchByAssoc($targetCampaignListObj)){
	$aParam['template_id'] = $row['template'];
	$aParam['name'] = $row['name'];
	$aParam['email']=$row['email'];
	if($mail=send_email($aParam)){
	 $db->query("UPDATE te_target_campaign_list SET status='Sent' AND sent_date='".date("Y-m-d H:i:s")."' WHERE id='".$row['id']."'");
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
	//$to="manish.outright@gmail.com";
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
	if (empty($email_template_bean -> id)) {`
		return false;
	}
	$email_template_bean->body_html = str_replace('$contact_name', $aParam['name'], $email_template_bean->body_html);
	$email_template_bean -> body_html = from_html($email_template_bean -> body_html);
	return $email_template_bean;
}
?>
