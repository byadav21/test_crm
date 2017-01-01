<?php
$module_name = 'te_ba_Batch';
$listViewDefs [$module_name] = 
array (
  'NAME' => 
  array (
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'BATCH_CODE' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_BATCH_CODE',
    'width' => '10%',
    'default' => true,
  ),
  'BATCH_STATUS' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_BATCH_STATUS',
    'width' => '10%',
  ),
  'DATE_ENTERED' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_ENTERED',
    'width' => '10%',
    'default' => true,
  ),
);
?>
