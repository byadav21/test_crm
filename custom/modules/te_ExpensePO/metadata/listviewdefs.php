<?php
$module_name = 'te_ExpensePO';
$listViewDefs [$module_name] = 
array (
  'NAME' => 
  array (
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'VENDOR_C' => 
  array (
    'type' => 'relate',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_VENDOR',
    'id' => 'TE_EXPENSE_VENDOR_ID_C',
    'link' => true,
    'width' => '10%',
  ),
  'DATED' => 
  array (
    'type' => 'date',
    'label' => 'LBL_DATED',
    'width' => '10%',
    'default' => true,
  ),
  'AMOUNT' => 
  array (
    'type' => 'decimal',
    'label' => 'LBL_AMOUNT',
    'width' => '10%',
    'default' => true,
  ),
  'STATUS' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_STATUS',
    'width' => '10%',
  ),
  'EXPENSE_TYPE' => 
  array (
    'label' => 'expense_type',
    'type' => 'enum',
    'default' => true,
    'width' => '10%',
  ),
  'POREQUIRED' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_POREQUIRED',
    'width' => '10%',
    'default' => true,
  ),
  'REFRENCEID' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_REFRENCEID',
    'width' => '10%',
    'default' => false,
  ),
  'CREATED_BY_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_CREATED',
    'id' => 'CREATED_BY',
    'width' => '10%',
    'default' => false,
  ),
  'PODOCUMENT' => 
  array (
    'type' => 'text',
    'studio' => 'visible',
    'label' => 'LBL_PODOCUMENT',
    'sortable' => false,
    'width' => '10%',
    'default' => false,
  ),
);
?>
