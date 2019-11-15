<?php
$module_name = 'te_student_batch';
$listViewDefs [$module_name] = 
array (
  'TE_STUDENT_TE_STUDENT_BATCH_1_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_TE_STUDENT_TE_STUDENT_BATCH_1_FROM_TE_STUDENT_TITLE',
    'id' => 'TE_STUDENT_TE_STUDENT_BATCH_1TE_STUDENT_IDA',
    'width' => '10%',
    'default' => true,
  ),
  'EMAIL' => 
  array (
    'type' => 'varchar',
    'studio' => 'visible',
    'label' => 'Email',
    'width' => '10%',
    'default' => true,
  ),
  'MOBILE' => 
  array (
    'type' => 'varchar',
    'studio' => 'visible',
    'label' => 'Phone',
    'width' => '10%',
    'default' => true,
  ),
  'INSTITUTE' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_INSTITUTE',
    'id' => 'TE_IN_INSTITUTES_ID_C',
    'link' => true,
    'width' => '10%',
    'default' => true,
  ),
  'PROGRAM' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_PROGRAM',
    'id' => 'TE_PR_PROGRAMS_ID_C',
    'link' => true,
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
  'STATUS' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_STATUS',
    'width' => '10%',
    'default' => true,
  ),
  'DROPOUT_TYPE' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_DROPOUT_TYPE',
    'width' => '10%',
    'default' => true,
  ),
  'FEEPAID' => 
  array (
    'type' => 'varchar',
    'studio' => 'visible',
    'label' => 'Fee-Paid',
    'width' => '10%',
    'default' => true,
  ),
  'KIT_STATUS' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'Kit Status',
    'width' => '10%',
    'default' => true,
  ),
);
?>
