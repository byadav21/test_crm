<?php
$listViewDefs ['AOS_Contracts'] = 
array (
  'NAME' => 
  array (
    'width' => '15%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'TE_VENDOR_AOS_CONTRACTS_1_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_TE_VENDOR_AOS_CONTRACTS_1_FROM_TE_VENDOR_TITLE',
    'id' => 'TE_VENDOR_AOS_CONTRACTS_1TE_VENDOR_IDA',
    'width' => '10%',
    'default' => true,
  ),
  'STATUS' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_STATUS',
    'sortable' => false,
    'width' => '10%',
  ),
  'TOTAL_CONTRACT_VALUE' => 
  array (
    'label' => 'LBL_TOTAL_CONTRACT_VALUE',
    'currency_format' => true,
    'width' => '10%',
    'default' => true,
  ),
  'START_DATE' => 
  array (
    'type' => 'date',
    'label' => 'LBL_START_DATE',
    'width' => '10%',
    'default' => true,
  ),
  'END_DATE' => 
  array (
    'type' => 'date',
    'label' => 'LBL_END_DATE',
    'width' => '10%',
    'default' => true,
  ),
  'VENDOR' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_VENDOR',
    'id' => 'TE_VENDOR_ID_C',
    'link' => true,
    'width' => '10%',
    'default' => false,
  ),
);
?>
