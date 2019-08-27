<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
$hook_version = 1; 
$hook_array['before_save'] = Array(); 
$hook_array['before_save'][] = Array(1, 'validation', 'custom/modules/te_utm/utmhook.php','MakeUtmLive', 'validate');
$hook_array['before_save'][] = Array(1, 'makeutmlive', 'custom/modules/te_utm/utmhook.php','MakeUtmLive', 'updateLiveOn');

$hook_array['after_save'] = Array(); 
$hook_array['after_save'][] = Array(1, 'Create Campaign', 'custom/modules/te_utm/create_campaign.php','CreateCampaign', 'create');

?>


