<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
$hook_version = 1; 
$hook_array = Array(); 

$hook_array['before_save'] = Array(); 
$hook_array['after_save'] = Array(); 
$hook_array['before_save'][] = Array(1, 'budgeted_campaign_hook', 'custom/modules/te_budgeted_campaign/budgeted_campaign_hook.php','MapUtm', 'assignUtm');
$hook_array['after_save'][] = Array(1, 'Update Relationship', 'custom/modules/te_budgeted_campaign/budgeted_campaign_hook.php','MapUtm', 'updateRelation');

?>
