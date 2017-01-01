<?php
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');
global $app_list_strings,$current_user,$sugar_config,$db;

if(isset($_REQUEST['campaignId']) && $_REQUEST['campaignId']!=""){
	$targetCampaignSql="SELECT tc.batch,v.name as vendor,tc.template FROM te_target_campaign tc INNER JOIN te_vendor v ON tc.vendor=v.id WHERE tc.id='".$_REQUEST['campaignId']."' AND tc.deleted=0";
	$targetCampaignObj =$db->query($targetCampaignSql);
	$targetCampaign =$db->fetchByAssoc($targetCampaignObj);
	
	$leadSql = "SELECT leads.first_name as name,email_address as email FROM leads INNER JOIN leads_cstm ON leads.id = leads_cstm.id_c INNER JOIN email_addr_bean_rel ON email_addr_bean_rel.bean_id = leads.id AND email_addr_bean_rel.bean_module ='Leads'  INNER JOIN email_addresses ON email_addresses.id =  email_addr_bean_rel.email_address_id WHERE leads.deleted = 0 AND leads_cstm.te_ba_batch_id_c = '".$targetCampaign['batch']."' AND leads.vendor='".$targetCampaign['vendor']."'";
	$leadObj =$db->query($leadSql);
	while($row =$db->fetchByAssoc($leadObj)){ 
		$targetCampaignListObj = new te_target_campaign_list();
		$targetCampaignListObj->name=$row['name'];
		$targetCampaignListObj->email=$row['email'];
		$targetCampaignListObj->status="In Queue";
		$targetCampaignListObj->template=$targetCampaign['template'];
		$targetCampaignListObj->te_target_b188ampaign_ida=$_REQUEST['campaignId'];
		$targetCampaignListObj->save();
		unset($targetCampaignListObj);
	}
	$db->query("UPDATE te_target_campaign SET send_email='Sent'");
	$utmOptions['status']='Sent';
	echo json_encode($utmOptions);
	return false;
}
?>
