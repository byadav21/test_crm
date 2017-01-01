<?php
$module_name = 'te_in_institutes';
$listViewDefs [$module_name] = 
array (
  'DATE_ENTERED' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_ENTERED',
    'width' => '10%',
    'default' => true,
  ),
  'NAME' => 
  array (
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'ENROLLMENT_IN_PROGRESS_C' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_ENROLLMENT_IN_PROGRESS',
    'width' => '10%',
  ),
  'BATCH_STATUS_CLASS_C' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_BATCH_STATUS_CLASS',
    'width' => '10%',
  ),
  'PLANNED_BATCH_C' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_PLANNED_BATCH',
    'width' => '10%',
  ),
  'TOTAL_PROGRAMS_C' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_TOTAL_PROGRAMS',
    'width' => '10%',
  ),
);
?>
