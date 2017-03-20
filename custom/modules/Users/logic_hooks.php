<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['after_login'] = Array(); 
$hook_array['after_login'][] = Array(1, 'SugarFeed old feed entry remover', 'modules/SugarFeed/SugarFeedFlush.php','SugarFeedFlush', 'flushStaleEntries'); 
//$hook_array['after_login'][] = Array(2, 'Login to the Neox sytem ','custom/modules/Users/neoxLogin.php','neoxLogin', 'neoxLoginFunc'); 

$hook_array['before_save'] = Array(); 
$hook_array['before_save'][] = Array(1, 'Change user name as email id', 'custom/modules/Users/userHook.php','UserHook', 'changeUserName'); 


?>
