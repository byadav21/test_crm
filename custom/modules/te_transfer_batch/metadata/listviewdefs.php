<?php
$module_name = 'te_transfer_batch';
$listViewDefs [$module_name] = 
array (
  'STUDENT' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_STUDENT',
    'id' => 'TE_STUDENT_ID_C',
    'link' => true,
    'width' => '20%',
    'default' => true,
  ),
  'DATE_ENTERED' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_ENTERED',
    'width' => '10%',
    'default' => true,
  ),
  'OLD_BATCH' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_OLD_BATCH',
    'id' => 'TE_STUDENT_BATCH_ID_C',
    'link' => false,
    'width' => '20%',
    'default' => true,
  ),
  'NEW_BATCH' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_NEW_BATCH',
    'id' => 'TE_BA_BATCH_ID_C',
    'link' => false,
    'width' => '20%',
    'default' => true,
  ),
  'COUNTRY' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_COUNTRY',
    'width' => '10%',
    'default' => true,
  ),
  'STATUS' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_STATUS',
    'width' => '10%',
    'default' => true,
  ),
);
?>
