<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class UpdateDripCampaign {

    function updateList(&$bean, $event, $arguments) {
		$res1=$GLOBALS['db']->query("DELETE FROM te_drip_campaign_list");
		$res2=$GLOBALS['db']->query("DELETE FROM te_drip_campaign_te_drip_campaign_list_c
 WHERE te_drip_campaign_te_drip_campaign_listte_drip_campaign_ida='".$bean->id."'");
		
		for($x=1;$x<=$bean->total_mailers;$x++){
			
			$day_index="day_".$x;
			$template_index="template_".$x;
			$templateSql="SELECT name FROM te_utm email_templates WHERE id='".$_REQUEST[$template_index]."' AND deleted=0";
			$templateObj = $bean->db->Query($templateSql);
			$template = $db->fetchByAssoc($templateObj);
			
			$campaignlistObj = new te_drip_campaign_list();
			$campaignlistObj->mailer_day =	$_REQUEST[$day_index];	
			$campaignlistObj->name		 =	$template['name'];
			$campaignlistObj->template_id	=	$_REQUEST[$template_index];
			$campaignlistObj->te_drip_campaign_te_drip_campaign_listte_drip_campaign_ida	=	$bean->id;
			$campaignlistObj->save();
			unset($campaignlistObj);
		}		
    }
}
