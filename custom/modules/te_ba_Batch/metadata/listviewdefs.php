<?php
$module_name = 'te_ba_Batch';
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
  'TE_PR_PROGRAMS_TE_BA_BATCH_1_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_TE_PR_PROGRAMS_TE_BA_BATCH_1_FROM_TE_PR_PROGRAMS_TITLE',
    'id' => 'TE_PR_PROGRAMS_TE_BA_BATCH_1TE_PR_PROGRAMS_IDA',
    'width' => '10%',
    'default' => true,
  ),
  'TE_IN_INSTITUTES_TE_BA_BATCH_1_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_TE_IN_INSTITUTES_TE_BA_BATCH_1_FROM_TE_IN_INSTITUTES_TITLE',
    'id' => 'TE_IN_INSTITUTES_TE_BA_BATCH_1TE_IN_INSTITUTES_IDA',
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
  'ENROLLED_STUDENTS_C' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_ENROLLED_STUDENTS',
    'width' => '10%',
  ),
  'BATCH_CODE' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_BATCH_CODE',
    'width' => '10%',
    'default' => false,
  ),
);
?>
