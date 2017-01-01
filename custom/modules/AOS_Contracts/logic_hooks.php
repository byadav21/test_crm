<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
$hook_version = 1; 
$hook_array = Array(); 

$hook_array['after_save'] = Array(); 
$hook_array['after_save'][] = Array(1, 'Rename the document', 'custom/modules/AOS_Contracts/contracts_hook.php','ContractHook', 'renameDocument');

$hook_array['before_save'] = Array(); 
//$hook_array['before_save'][] = Array(1, 'Update Contract Rate', 'custom/modules/AOS_Contracts/contracts_hook.php','ContractHook', 'updateRate');
?>
