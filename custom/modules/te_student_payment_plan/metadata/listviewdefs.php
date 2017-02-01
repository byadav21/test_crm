<?php
$module_name = 'te_student_payment_plan';
$listViewDefs [$module_name] = 
array (
  'STUDENT' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_STUDENT',
    'id' => 'TE_STUDENT_ID_C',
    'link' => true,
    'width' => '10%',
    'default' => true,
  ),
  'TE_STUDENT_BATCH_TE_STUDENT_PAYMENT_PLAN_1_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_TE_STUDENT_BATCH_TE_STUDENT_PAYMENT_PLAN_1_FROM_TE_STUDENT_BATCH_TITLE',
    'id' => 'TE_STUDENT_BATCH_TE_STUDENT_PAYMENT_PLAN_1TE_STUDENT_BATCH_IDA',
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
  'DUE_AMOUNT_INR' => 
  array (
    'type' => 'int',
    'label' => 'LBL_DUE_AMOUNT_INR',
    'width' => '10%',
    'default' => true,
  ),
  'PAID' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_PAID',
    'width' => '10%',
    'default' => true,
  ),
  'PAID_AMOUNT_INR' => 
  array (
    'type' => 'int',
    'label' => 'LBL_PAID_AMOUNT_INR',
    'width' => '10%',
    'default' => true,
  ),
  'BALANCE_INR' => 
  array (
    'type' => 'int',
    'label' => 'LBL_BALANCE_INR',
    'width' => '10%',
    'default' => true,
  ),
  'currency' => 
  array (
    'type' => 'varchar',
    'studio' => 'visible',
    'label' => 'LBL_CURRENCY',
    'sortable' => false,
    'width' => '10%',
    'default' => true,
  ),
  'DUE_DATE' => 
  array (
    'type' => 'date',
    'label' => 'LBL_DUE_DATE',
    'width' => '10%',
    'default' => true,
  ),
);
?>
