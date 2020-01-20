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
$hook_array['before_save'][] = Array(9, 'updateGeocodeInfo', 'modules/Leads/LeadsJjwg_MapsLogicHook.php','LeadsJjwg_MapsLogicHook', 'updateGeocodeInfo');
$hook_array['before_save'][] = Array(3, 'Leads push feed','custom/modules/Leads/addPayment.php','addPaymentClass', 'checkDuplicateFunc');
$hook_array['before_save'][] = Array(14, 'Source Lead Assignment Rule','custom/modules/Leads/sourceAssignment.php','leadAssignmentClass', 'leadassignmentruleFunc');
$hook_array['after_save'][] = Array(8, 'updateRelatedMeetingsGeocodeInfo', 'modules/Leads/LeadsJjwg_MapsLogicHook.php','LeadsJjwg_MapsLogicHook', 'updateRelatedMeetingsGeocodeInfo');
$hook_array['after_save'][] = Array(4, 'add payment details', 'custom/modules/Leads/addPayment.php','addPaymentClass', 'addPaymentFunc');
$hook_array['after_save'][] = Array(5, 'add Disposition details', 'custom/modules/Leads/addPayment.php','addPaymentClass', 'addDispositionFunc');
//$hook_array['after_save'][] = Array(12, 'add leads details', 'custom/modules/Leads/eloqua/eloqua_hook.php','eloqua_contact','add_leads_eloqua');
$hook_array['after_save'][] = Array(11, 'add leads indivialids', 'custom/modules/Leads/individual_id_hook.php','individualIdClass','add_individual_id');
$hook_array['after_retrieve'][] = Array(10, 'leads details', 'custom/modules/Leads/program_istitute.php','detail_view','detail_pro_ins');
$hook_array['process_record'][] = Array(6, 'statusoleads', 'custom/modules/Leads/lead_report.php','listviewlead', 'lead_report');
$hook_array['after_relationship_add'][] = Array(7, 'abcd', 'custom/modules/Leads/refree_lead.php','Alogic', 'Bmethod');
$hook_array['after_save'][] = Array(13, 'add leads primary vendor', 'custom/modules/Leads/save_primary_vendor.php','saveVendorClass','save_primary_vendor');
//$hook_array['after_save'][] = Array(14, 'add leads in report', 'custom/modules/Leads/add_leads_in_report_lead_tbl.php','saveLeadClass','add_lead');
//$hook_array['after_save'][] = Array(15, 'mark duplicate leads', 'custom/modules/Leads/check_zapier_duplicate.php','checkZapierLeads','check_duplicate_leads');
$hook_array['before_save'][] = Array(16, 'stop pushing lead without mobile','custom/modules/Leads/stop_push_lead_without_mobile.php','checkLeadsMobile', 'check_leads_mobile');
$hook_array['after_save'][] = Array(17, 'Push Lead to Clevertap', 'custom/modules/Leads/push_leads_clevertap.php','pushLeadClevertap','pushLead');
?>
