<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['process_record'] = Array(); 
$hook_array['process_record'][] = Array(2, 'Websiteurl', 'custom/modules/te_UTM_System/websiteurl.php','website_listview','display_weburl');
$hook_array['after_retrieve'] = Array(); 
$hook_array['after_retrieve'][] = Array(4, 'Websiteurldetailpage', 'custom/modules/te_UTM_System/detailview_website.php','website_detailview','display_weburldetail');
?>


