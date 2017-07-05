<?php
$module_name = 'te_utm';
$listViewDefs [$module_name] = 
array (
  'NAME' => 
  array (
    'width' => '32%',
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
    'width' => '10%',
    'default' => true,
    'id' => 'TE_VENDOR_TE_UTM_1TE_VENDOR_IDA',
  ),
  'CONTRACT_TYPE' => 
  array (
    'type' => 'enum',
    'label' => 'UTM Medium',
    'width' => '10%',
    'default' => true,
  ),
);
?>
