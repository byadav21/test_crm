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
  'REFRENCEID' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_REFRENCEID',
    'width' => '10%',
    'default' => true,
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
  'POREQUIRED' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_POREQUIRED',
    'width' => '10%',
    'default' => true,
  ),
);
?>
