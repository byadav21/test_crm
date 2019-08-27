<?php
// created: 2017-01-14 18:05:12
$subpanel_layout['list_fields'] = array (
  'batch_id' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'vname' => 'LBL_BATCH_ID',
    'id' => 'TE_STUDENT_BATCH_ID_C',
    'link' => true,
    'width' => '10%',
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'te_student_batch',
    'target_record_key' => 'te_student_batch_id_c',
  ),
  'number_of_kits' => 
  array (
    'type' => 'int',
    'vname' => 'LBL_NUMBER_OF_KITS',
    'width' => '10%',
    'default' => true,
  ),
  'status' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'vname' => 'LBL_STATUS',
    'width' => '10%',
    'default' => true,
  ),
  'address_confirmed' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'vname' => 'LBL_ADDRESS_CONFIRMED',
    'width' => '10%',
    'default' => true,
  ),
);