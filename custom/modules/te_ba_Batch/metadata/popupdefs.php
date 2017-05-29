<?php
$popupMeta = array (
    'moduleMain' => 'te_ba_Batch',
    'varName' => 'te_ba_Batch',
    'orderBy' => 'te_ba_batch.name',
    'whereClauses' => array (
  'name' => 'te_ba_batch.name',
  'te_in_institutes_te_ba_batch_1_name' => 'te_ba_batch.te_in_institutes_te_ba_batch_1_name',
  'batch_status' => 'te_ba_batch.batch_status',
),
    'searchInputs' => array (
  1 => 'name',
  4 => 'te_in_institutes_te_ba_batch_1_name',
  5 => 'batch_status',
),
    'searchdefs' => array (
  'name' => 
  array (
    'name' => 'name',
    'width' => '10%',
  ),
  'te_in_institutes_te_ba_batch_1_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_TE_IN_INSTITUTES_TE_BA_BATCH_1_FROM_TE_IN_INSTITUTES_TITLE',
    'id' => 'TE_IN_INSTITUTES_TE_BA_BATCH_1TE_IN_INSTITUTES_IDA',
    'width' => '10%',
    'name' => 'te_in_institutes_te_ba_batch_1_name',
  ),
  'batch_status' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_BATCH_STATUS',
    'width' => '10%',
    'name' => 'batch_status',
  ),
),
);
