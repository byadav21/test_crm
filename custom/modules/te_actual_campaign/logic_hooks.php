<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
$hook_version = 1; 
$hook_array = Array(); 

$hook_array['after_save'] = Array(); 
$hook_array['after_save'][] = Array(1, 'actual_campaign_hook', 'custom/modules/te_actual_campaign/actual_campaign_hook.php','AutoCalculate', 'calculateCPA');


?>
