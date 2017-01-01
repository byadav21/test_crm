<?php
$module_name = 'te_utm';
$listViewDefs [$module_name] = 
array (
  'NAME' => 
  array (
    'width' => '20%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'UTM_STATUS' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_UTM_STATUS',
    'width' => '10%',
    'default' => true,
  ),
  'TE_VENDOR_TE_UTM_1_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_TE_VENDOR_TE_UTM_1_FROM_TE_VENDOR_TITLE',
    'id' => 'TE_VENDOR_TE_UTM_1TE_VENDOR_IDA',
    'width' => '10%',
    'default' => true,
  ),
  'CONTRACT' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_CONTRACT',
    'id' => 'AOS_CONTRACTS_ID_C',
    'link' => true,
    'width' => '10%',
    'default' => true,
  ),
  'BATCH' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_BATCH',
    'id' => 'TE_BA_BATCH_ID_C',
    'link' => true,
    'width' => '10%',
    'default' => true,
  ),
);
?>
