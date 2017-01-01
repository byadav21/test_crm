<?php
$module_name = 'te_budgeted_campaign';
$listViewDefs [$module_name] = 
array (
  'YEAR' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_YEAR',
    'width' => '10%',
    'default' => true,
  ),
  'WEEK' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_WEEK',
    'width' => '10%',
    'default' => true,
  ),
  'TE_UTM_TE_BUDGETED_CAMPAIGN_1_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_TE_UTM_TE_BUDGETED_CAMPAIGN_1_FROM_TE_UTM_TITLE',
    'id' => 'TE_UTM_TE_BUDGETED_CAMPAIGN_1TE_UTM_IDA',
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
  'LEADS' => 
  array (
    'type' => 'int',
    'label' => 'LBL_LEADS',
    'width' => '10%',
    'default' => true,
  ),
  'COST' => 
  array (
    'type' => 'int',
    'label' => 'LBL_COST',
    'width' => '10%',
    'default' => true,
  ),
  'CONVERSION' => 
  array (
    'type' => 'int',
    'label' => 'LBL_CONVERSION',
    'width' => '10%',
    'default' => true,
  ),
  'CONVERSION_RATE' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_CONVERSION_RATE',
    'width' => '10%',
    'default' => true,
  ),
  'CLP' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_CLP',
    'width' => '10%',
    'default' => true,
  ),
  'CPA' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_CPA',
    'width' => '10%',
    'default' => true,
  ),
);
?>
