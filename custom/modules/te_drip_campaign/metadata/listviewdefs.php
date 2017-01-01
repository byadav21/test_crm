<?php
$module_name = 'te_drip_campaign';
$listViewDefs [$module_name] = 
array (
  'NAME' => 
  array (
    'width' => '20%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
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
  'total_mailers' => 
  array (
    'width' => '10%',
    'label' => 'LBL_TOTAL_MAILERS',
    'default' => true,
    'link' => false,
  ),
);
?>
