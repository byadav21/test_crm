<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
$hook_array['after_save'] = Array(); 
$hook_array['after_save'][] = Array(1, 'Update lead fields', 'custom/modules/te_student/student_hook.php','StudentHook', 'updateFields'); 

?>
