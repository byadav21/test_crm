<?php
$popupMeta = array (
    'moduleMain' => 'AOS_Contracts',
    'varName' => 'AOS_Contracts',
    'orderBy' => 'aos_contracts.name',
    'whereClauses' => array (
  'name' => 'aos_contracts.name',
  'status' => 'aos_contracts.status',
  'total_contract_value' => 'aos_contracts.total_contract_value',
  'start_date' => 'aos_contracts.start_date',
  'end_date' => 'aos_contracts.end_date',
),
    'searchInputs' => array (
  1 => 'name',
  3 => 'status',
  4 => 'total_contract_value',
  5 => 'start_date',
  6 => 'end_date',
),
    'searchdefs' => array (
  'name' => 
  array (
    'type' => 'name',
    'label' => 'LBL_NAME',
    'width' => '10%',
    'name' => 'name',
  ),
  'status' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_STATUS',
    'sortable' => false,
    'width' => '10%',
    'name' => 'status',
  ),
  'start_date' => 
  array (
    'type' => 'date',
    'label' => 'LBL_START_DATE',
    'width' => '10%',
    'name' => 'start_date',
  ),
  'end_date' => 
  array (
    'type' => 'date',
    'label' => 'LBL_END_DATE',
    'width' => '10%',
    'name' => 'end_date',
  ),
),
    'listviewdefs' => array (
  'NAME' => 
  array (
    'width' => '15%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
    'name' => 'name',
  ),
  'CONTRACT_TYPE' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_CONTRACT_TYPE',
    'width' => '10%',
  ),
  'TE_VENDOR_AOS_CONTRACTS_1_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_TE_VENDOR_AOS_CONTRACTS_1_FROM_TE_VENDOR_TITLE',
    'id' => 'TE_VENDOR_AOS_CONTRACTS_1TE_VENDOR_IDA',
    'width' => '10%',
    'default' => true,
    'name' => 'te_vendor_aos_contracts_1_name',
  ),
  'STATUS' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_STATUS',
    'sortable' => false,
    'width' => '10%',
    'name' => 'status',
  ),
  'TOTAL_CONTRACT_VALUE' => 
  array (
    'label' => 'LBL_TOTAL_CONTRACT_VALUE',
    'currency_format' => true,
    'width' => '10%',
    'default' => true,
    'name' => 'total_contract_value',
  ),
  'START_DATE' => 
  array (
    'type' => 'date',
    'label' => 'LBL_START_DATE',
    'width' => '10%',
    'default' => true,
    'name' => 'start_date',
  ),
  'END_DATE' => 
  array (
    'type' => 'date',
    'label' => 'LBL_END_DATE',
    'width' => '10%',
    'default' => true,
    'name' => 'end_date',
  ),
),
);
