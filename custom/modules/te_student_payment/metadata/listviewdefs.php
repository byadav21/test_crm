<?php
$module_name = 'te_student_payment';
$listViewDefs [$module_name] = 
array (
  'TE_STUDENT_TE_STUDENT_PAYMENT_1_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_TE_STUDENT_TE_STUDENT_PAYMENT_1_FROM_TE_STUDENT_TITLE',
    'id' => 'TE_STUDENT_TE_STUDENT_PAYMENT_1TE_STUDENT_IDA',
    'width' => '10%',
    'default' => true,
  ),
  'BATCH_ID' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_BATCH_ID',
    'id' => 'TE_STUDENT_BATCH_ID_C',
    'link' => true,
    'width' => '10%',
    'default' => true,
  ),
  'AMOUNT' => 
  array (
    'type' => 'decimal',
    'label' => 'LBL_AMOUNT',
    'width' => '10%',
    'default' => true,
  ),
  'DATE_OF_PAYMENT' => 
  array (
    'type' => 'date',
    'label' => 'LBL_DATE_OF_PAYMENT',
    'width' => '10%',
    'default' => true,
  ),
  'PAYMENT_TYPE' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_PAYMENT_TYPE',
    'width' => '10%',
    'default' => true,
  ),
  'PAYMENT_SOURCE' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_PAYMENT_SOURCE',
    'width' => '10%',
    'default' => true,
  ),
  'CREATED_BY_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_CREATED',
    'id' => 'CREATED_BY',
    'width' => '10%',
    'default' => true,
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
