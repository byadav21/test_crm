<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
$hook_version = 1; 
$hook_array = Array(); 
$hook_array['before_save'] = Array(); 
$hook_array['process_record'] = Array(); 
$hook_array['before_save'][] = Array(1, 'updateInitialPyment', 'custom/modules/te_ba_Batch/update_initial_payment.php','UpdateInitialPyment', 'updatePayment'); 
$hook_array['after_save'][] = Array(2, 'updateInstallments', 'custom/modules/te_ba_Batch/update_installments.php','UpdateInstallments', 'updatePayments');
$hook_array['after_save'][] = Array(3, 'update batch_completion date', 'custom/modules/te_ba_Batch/update_batch_completion_date.php','UpdateBatchCompletionDate', 'updateDate');
$hook_array['process_record'][] = Array(4, 'statusof_batch', 'custom/modules/te_ba_Batch/listview_status_batch.php','status_listview', 'display_list');
  
?>
