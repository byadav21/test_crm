<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['process_record'] = Array(); 
$hook_array['process_record'][] = Array(2, 'statusofprograms', 'custom/modules/te_in_institutes/listview_status.php','status_listview', 'display_list');
$hook_array['before_save'][] = Array(8, 'duplicate', 'custom/modules/te_in_institutes/duplicate_logic.php','duplicate_logic', 'duplicate_logic_method'); 
?>


