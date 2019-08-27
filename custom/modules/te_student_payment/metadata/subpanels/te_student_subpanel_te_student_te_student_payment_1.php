<?php
// created: 2017-09-18 11:20:05
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
  'amount' => 
  array (
    'type' => 'decimal',
    'vname' => 'LBL_AMOUNT',
    'width' => '10%',
    'default' => true,
  ),
  'date_of_payment' => 
  array (
    'type' => 'date',
    'vname' => 'LBL_DATE_OF_PAYMENT',
    'width' => '10%',
    'default' => true,
  ),
  'payment_type' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'vname' => 'LBL_PAYMENT_TYPE',
    'width' => '10%',
    'default' => true,
  ),
  'payment_source' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'vname' => 'LBL_PAYMENT_SOURCE',
    'width' => '10%',
    'default' => true,
  ),
  'invoice_number' => 
  array (
    'type' => 'int',
    'default' => true,
    'studio' => 'visible',
    'vname' => 'Invoice Number',
    'width' => '10%',
  ),
  'invoice_url' => 
  array (
    'type' => 'varchar',
    'studio' => 'visible',
    'vname' => 'Invoice URL',
    'width' => '10%',
    'default' => true,
  ),
  'created_by_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'vname' => 'LBL_CREATED',
    'id' => 'CREATED_BY',
    'width' => '10%',
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'Users',
    'target_record_key' => 'created_by',
  ),
  'date_entered' => 
  array (
    'type' => 'datetime',
    'vname' => 'LBL_DATE_ENTERED',
    'width' => '10%',
    'default' => true,
  ),
  'edit_button' => 
  array (
    'width' => '4%',
    'vname' => 'LBL_EDIT_BUTTON',
    'default' => true,
    'widget_class' => 'SubPanelEditButton',
  ),
);