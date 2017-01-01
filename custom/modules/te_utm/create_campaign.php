
<?php
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');

class CreateCampaign {
    function create(&$bean, $event, $arguments){
		if($_REQUEST['utm_status']=="Live"){
			$campaignObj = new Campaign();
			$campaignObj->disable_row_level_security = true;
			$campaignObj->retrieve_by_string_fields(array('name' => $this->bean->name));
			if($campaignObj->id==""){
				$campaignObj->name = $bean->name;	
				$campaignObj->status = "Planning";
				$campaignObj->save();
			}
		}		
	}
}
