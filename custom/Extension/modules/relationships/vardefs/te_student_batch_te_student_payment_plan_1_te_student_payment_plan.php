<?php
// created: 2016-12-27 19:40:57
$dictionary["te_student_payment_plan"]["fields"]["te_student_batch_te_student_payment_plan_1"] = array (
  'name' => 'te_student_batch_te_student_payment_plan_1',
  'type' => 'link',
  'relationship' => 'te_student_batch_te_student_payment_plan_1',
  'source' => 'non-db',
  'module' => 'te_student_batch',
  'bean_name' => 'te_student_batch',
  'vname' => 'LBL_TE_STUDENT_BATCH_TE_STUDENT_PAYMENT_PLAN_1_FROM_TE_STUDENT_BATCH_TITLE',
  'id_name' => 'te_student_batch_te_student_payment_plan_1te_student_batch_ida',
);
$dictionary["te_student_payment_plan"]["fields"]["te_student_batch_te_student_payment_plan_1_name"] = array (
  'name' => 'te_student_batch_te_student_payment_plan_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_TE_STUDENT_BATCH_TE_STUDENT_PAYMENT_PLAN_1_FROM_TE_STUDENT_BATCH_TITLE',
  'save' => true,
  'id_name' => 'te_student_batch_te_student_payment_plan_1te_student_batch_ida',
  'link' => 'te_student_batch_te_student_payment_plan_1',
  'table' => 'te_student_batch',
  'module' => 'te_student_batch',
  'rname' => 'name',
);
$dictionary["te_student_payment_plan"]["fields"]["te_student_batch_te_student_payment_plan_1te_student_batch_ida"] = array (
  'name' => 'te_student_batch_te_student_payment_plan_1te_student_batch_ida',
  'type' => 'link',
  'relationship' => 'te_student_batch_te_student_payment_plan_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_TE_STUDENT_BATCH_TE_STUDENT_PAYMENT_PLAN_1_FROM_TE_STUDENT_PAYMENT_PLAN_TITLE',
);
