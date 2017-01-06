<?php
// created: 2017-01-05 04:56:24
$dictionary["te_student_payment"]["fields"]["te_student_te_student_payment_1"] = array (
  'name' => 'te_student_te_student_payment_1',
  'type' => 'link',
  'relationship' => 'te_student_te_student_payment_1',
  'source' => 'non-db',
  'module' => 'te_student',
  'bean_name' => 'te_student',
  'vname' => 'LBL_TE_STUDENT_TE_STUDENT_PAYMENT_1_FROM_TE_STUDENT_TITLE',
  'id_name' => 'te_student_te_student_payment_1te_student_ida',
);
$dictionary["te_student_payment"]["fields"]["te_student_te_student_payment_1_name"] = array (
  'name' => 'te_student_te_student_payment_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_TE_STUDENT_TE_STUDENT_PAYMENT_1_FROM_TE_STUDENT_TITLE',
  'save' => true,
  'id_name' => 'te_student_te_student_payment_1te_student_ida',
  'link' => 'te_student_te_student_payment_1',
  'table' => 'te_student',
  'module' => 'te_student',
  'rname' => 'name',
);
$dictionary["te_student_payment"]["fields"]["te_student_te_student_payment_1te_student_ida"] = array (
  'name' => 'te_student_te_student_payment_1te_student_ida',
  'type' => 'link',
  'relationship' => 'te_student_te_student_payment_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_TE_STUDENT_TE_STUDENT_PAYMENT_1_FROM_TE_STUDENT_PAYMENT_TITLE',
);
