<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['before_save'] = Array(); 
$hook_array['process_record'] = Array(); 
$hook_array['process_record'][] = Array(1, 'Show the dates in same field', 'custom/modules/te_disposition/updateStatus.php','updateStatusClass', 'showDates'); 
//~ print_r($hook_array);die;
$hook_array['after_save'] = Array(); 
$hook_array['after_save'][] = Array(2, 'add Disposition details in Leads', 'custom/modules/te_disposition/updateStatus.php','updateStatusClass', 'updateStatusFunc'); 
$hook_array['after_save'][] = Array(2, 'send Disposition to dristi', 'custom/modules/te_disposition/updateStatus.php','updateStatusClass', 'sendDisposition'); 
$hook_array['after_relationship_add'][] = Array(10, 'adddoispostion', 'custom/modules/te_disposition/dispostion_call.php', 'dispostionClass', 'dispostionFunc');

?>
