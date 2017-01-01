<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['process_record'] = Array(); 

$hook_array['process_record'][] = Array(4, 'statusofprograms', 'custom/modules/te_pr_Programs/listview_status_programs.php','status_listview_program', 'display_list_program');
$hook_array['before_save'][] = Array(6, 'duplicate', 'custom/modules/te_pr_Programs/first_logic.php','first_logic', 'first_logic_method'); 

?>
