<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['before_save'] = Array(); 
$hook_array['before_save'][] = Array(1, 'duplicatevalidation', 'custom/modules/Leads/addPayment.php','addPaymentClass', 'checkduplicate'); 
//$hook_array['before_save'][] = Array(1, 'validation', 'custom/modules/Leads/addPayment.php','addPaymentClass', 'checkAmyoFunc'); 
$hook_array['before_save'][] = Array(2, 'Leads push feed', 'modules/Leads/SugarFeeds/LeadFeed.php','LeadFeed', 'pushFeed'); 
$hook_array['before_save'][] = Array(77, 'updateGeocodeInfo', 'modules/Leads/LeadsJjwg_MapsLogicHook.php','LeadsJjwg_MapsLogicHook', 'updateGeocodeInfo'); 
$hook_array['before_save'][] = Array(2, 'Leads push feed','custom/modules/Leads/addPayment.php','addPaymentClass', 'checkDuplicateFunc'); 
$hook_array['after_save'] = Array(); 
$hook_array['after_save'][] = Array(77, 'updateRelatedMeetingsGeocodeInfo', 'modules/Leads/LeadsJjwg_MapsLogicHook.php','LeadsJjwg_MapsLogicHook', 'updateRelatedMeetingsGeocodeInfo'); 
$hook_array['after_save'][] = Array(1, 'add payment details', 'custom/modules/Leads/addPayment.php','addPaymentClass', 'addPaymentFunc'); 
$hook_array['after_save'][] = Array(2, 'add Disposition details', 'custom/modules/Leads/addPayment.php','addPaymentClass', 'addDispositionFunc'); 
$hook_array['after_retrieve'][] = Array(23, 'leads details', 'custom/modules/Leads/program_istitute.php','detail_view','detail_pro_ins');
$hook_array['process_record'] = Array(); 
$hook_array['process_record'][] = Array(2, 'statusoleads', 'custom/modules/Leads/lead_report.php','listviewlead', 'lead_report');
$hook_array['after_relationship_add'][] = Array(8, 'abcd', 'custom/modules/Leads/refree_lead.php','Alogic', 'Bmethod'); 
?>
