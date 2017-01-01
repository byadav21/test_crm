<?php
$module_name = 'te_actual_campaign';
$listViewDefs [$module_name] = 
array (
  'TE_UTM_TE_ACTUAL_CAMPAIGN_1_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_TE_UTM_TE_ACTUAL_CAMPAIGN_1_FROM_TE_UTM_TITLE',
    'id' => 'TE_UTM_TE_ACTUAL_CAMPAIGN_1TE_UTM_IDA',
    'width' => '10%',
    'default' => true,
  ),
  'batch' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_BATCH',
    'id' => 'LBL_BATCH_TE_BA_BATCH_ID',
    'width' => '10%',
    'default' => true,
  ), 
  'PLAN_DATE' => 
  array (
    'type' => 'date',
    'label' => 'LBL_PLAN_DATE',
    'width' => '10%',
    'default' => true,
  ),
  'batch' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_BATCH',
    'id' => 'LBL_BATCH_TE_BA_BATCH_ID',
    'width' => '10%',
    'default' => true,
  ), 
  'VOLUME' => 
  array (
    'type' => 'int',
    'label' => 'LBL_VOLUME',
    'width' => '10%',
    'default' => true,
  ),
  'RATE' => 
  array (
    'type' => 'int',
    'label' => 'LBL_RATE',
    'width' => '10%',
    'default' => true,
  ),
  'TOTAL_COST' => 
  array (
    'type' => 'int',
    'label' => 'LBL_TOTAL_COST',
    'width' => '10%',
    'default' => true,
  ),
  'TYPE' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_TYPE',
    'width' => '10%',
    'default' => true,
  ),
  'CPL' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_CPL',
    'width' => '10%',
    'default' => true,
  ),
);
?>
