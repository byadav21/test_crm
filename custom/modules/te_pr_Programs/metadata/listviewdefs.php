<?php
$module_name = 'te_pr_Programs';
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
  'TE_IN_INSTITUTES_TE_PR_PROGRAMS_1_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_TE_IN_INSTITUTES_TE_PR_PROGRAMS_1_FROM_TE_IN_INSTITUTES_TITLE',
    'id' => 'TE_IN_INSTITUTES_TE_PR_PROGRAMS_1TE_IN_INSTITUTES_IDA',
    'width' => '10%',
    'default' => true,
  ),
  'ENROLLMENT_IN_PROGRESS_C' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_ENROLLMENT_IN_PROGRESS',
    'width' => '10%',
  ),
  'CLOSED_BATCH_C' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_CLOSED_BATCH',
    'width' => '10%',
  ),
  'CLASSES_IN_PROGRESS_C' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_CLASSES_IN_PROGRESS',
    'width' => '10%',
  ),
  'TOTAL_P_C' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_TOTAL_P',
    'width' => '10%',
  ),
);
?>
