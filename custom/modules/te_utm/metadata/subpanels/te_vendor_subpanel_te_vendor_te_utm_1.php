<?php
// created: 2016-11-17 07:09:20
$subpanel_layout['list_fields'] = array (
  'name' => 
  array (
    'vname' => 'LBL_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => '20%',
    'default' => true,
  ),
  'utm_status' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'vname' => 'LBL_UTM_STATUS',
    'width' => '10%',
    'default' => true,
  ),
  'te_vendor_te_utm_1_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'vname' => 'LBL_TE_VENDOR_TE_UTM_1_FROM_TE_VENDOR_TITLE',
    'id' => 'TE_VENDOR_TE_UTM_1TE_VENDOR_IDA',
    'width' => '10%',
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'te_vendor',
    'target_record_key' => 'te_vendor_te_utm_1te_vendor_ida',
  ),
  'contract' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'vname' => 'LBL_CONTRACT',
    'id' => 'AOS_CONTRACTS_ID_C',
    'link' => true,
    'width' => '10%',
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'AOS_Contracts',
    'target_record_key' => 'aos_contracts_id_c',
  ),
  'batch' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'vname' => 'LBL_BATCH',
    'id' => 'TE_BA_BATCH_ID_C',
    'link' => true,
    'width' => '10%',
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'te_ba_Batch',
    'target_record_key' => 'te_ba_batch_id_c',
  ),
);