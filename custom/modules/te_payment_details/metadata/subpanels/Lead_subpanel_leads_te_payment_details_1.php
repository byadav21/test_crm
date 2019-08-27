<?php
// created: 2017-09-18 11:24:00
$subpanel_layout['list_fields'] = array (
  'payment_type' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'vname' => 'LBL_PAYMENT_TYPE',
    'width' => '15%',
    'default' => true,
  ),
  'reference_number' => 
  array (
    'type' => 'varchar',
    'vname' => 'LBL_REFERENCE_NUMBER',
    'width' => '15%',
    'default' => true,
  ),
  'amount' => 
  array (
    'type' => 'decimal',
    'vname' => 'LBL_AMOUNT',
    'width' => '10%',
    'default' => true,
  ),
  'payment_realized' => 
  array (
    'type' => 'bool',
    'default' => true,
    'vname' => 'LBL_PAYMENT_REALIZED',
    'width' => '15%',
  ),
  'date_of_payment' => 
  array (
    'type' => 'date',
    'vname' => 'LBL_DATE_OF_PAYMENT',
    'width' => '15%',
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
  'edit_button' => 
  array (
    'vname' => 'LBL_EDIT_BUTTON',
    'widget_class' => 'SubPanelEditButton',
    'module' => 'te_payment_details',
    'width' => '4%',
    'default' => true,
  ),
  'remove_button' => 
  array (
    'vname' => 'LBL_REMOVE',
    'widget_class' => 'SubPanelRemoveButton',
    'module' => 'te_payment_details',
    'width' => '5%',
    'default' => true,
  ),
);