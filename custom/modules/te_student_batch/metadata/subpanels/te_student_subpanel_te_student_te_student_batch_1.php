<?php
// created: 2016-12-27 19:51:33
$subpanel_layout['list_fields'] = array (
  'name' => 
  array (
    'type' => 'name',
    'link' => true,
    'vname' => 'LBL_NAME',
    'width' => '10%',
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => NULL,
    'target_record_key' => NULL,
  ),
  'institute' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'vname' => 'LBL_INSTITUTE',
    'id' => 'TE_IN_INSTITUTES_ID_C',
    'link' => true,
    'width' => '10%',
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'te_in_institutes',
    'target_record_key' => 'te_in_institutes_id_c',
  ),
  'program' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'vname' => 'LBL_PROGRAM',
    'id' => 'TE_PR_PROGRAMS_ID_C',
    'link' => true,
    'width' => '10%',
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'te_pr_Programs',
    'target_record_key' => 'te_pr_programs_id_c',
  ),
  'batch_code' => 
  array (
    'type' => 'varchar',
    'vname' => 'LBL_BATCH_CODE',
    'width' => '10%',
    'default' => true,
  ),
  'source' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'vname' => 'LBL_SOURCE',
    'id' => 'TE_VENDOR_ID_C',
    'link' => true,
    'width' => '10%',
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'te_vendor',
    'target_record_key' => 'te_vendor_id_c',
  ),
  'fee_inr' => 
  array (
    'type' => 'decimal',
    'vname' => 'LBL_FEE_INR',
    'width' => '10%',
    'default' => true,
  ),
  'fee_usd' => 
  array (
    'type' => 'decimal',
    'vname' => 'LBL_FEE_USD',
    'width' => '10%',
    'default' => true,
  ),
);