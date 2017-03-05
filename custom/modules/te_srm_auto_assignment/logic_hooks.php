<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
$hook_array['after_save'] = Array(); 
$hook_array['after_save'][] = Array(1, 'Assign SRM Executives', 'custom/modules/te_srm_auto_assignment/srm_auto_assignment_hook.php','SrmAutoAssignment', 'assignExecutive'); 

$hook_array['before_save'] = Array(); 
$hook_array['before_save'][] = Array(1, 'Set Name of batch', 'custom/modules/te_srm_auto_assignment/srm_auto_assignment_hook.php','SrmAutoAssignment', 'setName'); 

?>
