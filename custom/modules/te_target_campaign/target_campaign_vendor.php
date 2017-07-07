<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class TaggetCampaignVendor {

    function getNameVendor(&$bean, $event, $arguments) {		
			
		//$bean->vendor= "JJJJ";
		//$bean->vendor=$this->;
		
	
		/* $targetCampaignSql="SELECT tc.batch,v.name as vendor,tc.template FROM te_target_campaign tc INNER JOIN te_vendor v ON tc.vendor=v.id WHERE tc.id='".$_REQUEST['campaignId']."' AND tc.deleted=0";
		 $targetCampaignObj =$db->query($targetCampaignSql);
		 $targetCampaign =$db->fetchByAssoc($targetCampaignObj);
		*/
		 /* Vendor ID Batch and templet Find*/
		 	
    }
  /*  
	function getVendor($id){
		$valVandCT =str_replace('^', '', $id) ;
		$valVandCTArr = explode(',',$valVandCT);
		$imp = "'" . implode( "','", $valVandCTArr ) . "'";
		//$valVandCT =str_replace("'"," ",$id);
		
		$vendorSql = "SELECT GROUP_CONCAT(name)name FROM te_vendor WHERE id IN($imp)";
		$vendorObj = $GLOBALS['db']->query($vendorSql);
		$row = $GLOBALS['db']->fetchByAssoc($vendorObj);
		return $row['name'];
	}
	*/ 
	
}
