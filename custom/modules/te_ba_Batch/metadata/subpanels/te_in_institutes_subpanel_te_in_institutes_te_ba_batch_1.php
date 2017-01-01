<?php
// created: 2016-12-06 01:50:21
$subpanel_layout['list_fields'] = array (
  'name' => 
  array (
    'vname' => 'LBL_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => '45%',
    'default' => true,
  ),
  'te_pr_programs_te_ba_batch_1_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'vname' => 'LBL_TE_PR_PROGRAMS_TE_BA_BATCH_1_FROM_TE_PR_PROGRAMS_TITLE',
    'id' => 'TE_PR_PROGRAMS_TE_BA_BATCH_1TE_PR_PROGRAMS_IDA',
    'width' => '10%',
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'te_pr_Programs',
    'target_record_key' => 'te_pr_programs_te_ba_batch_1te_pr_programs_ida',
  ),
  'te_in_institutes_te_ba_batch_1_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'vname' => 'LBL_TE_IN_INSTITUTES_TE_BA_BATCH_1_FROM_TE_IN_INSTITUTES_TITLE',
    'id' => 'TE_IN_INSTITUTES_TE_BA_BATCH_1TE_IN_INSTITUTES_IDA',
    'width' => '10%',
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'te_in_institutes',
    'target_record_key' => 'te_in_institutes_te_ba_batch_1te_in_institutes_ida',
  ),
  'date_modified' => 
  array (
    'vname' => 'LBL_DATE_MODIFIED',
    'width' => '45%',
    'default' => true,
  ),
  'edit_button' => 
  array (
    'vname' => 'LBL_EDIT_BUTTON',
    'widget_class' => 'SubPanelEditButton',
    'module' => 'te_ba_Batch',
    'width' => '4%',
    'default' => true,
  ),
  'remove_button' => 
  array (
    'vname' => 'LBL_REMOVE',
    'widget_class' => 'SubPanelRemoveButton',
    'module' => 'te_ba_Batch',
    'width' => '5%',
    'default' => true,
  ),
);