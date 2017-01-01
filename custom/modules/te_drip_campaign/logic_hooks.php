<?php
$hook_version = 1; 
$hook_array = Array(); 
$hook_array['after_save'] = Array(); 
$hook_array['after_save'][] = Array(1, 'update drip campaign list', 'custom/modules/te_drip_campaign/update_drip_campaign_list.php','UpdateDripCampaign', 'updateList');
  
?>
