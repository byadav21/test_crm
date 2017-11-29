<?php
// created: 2017-11-28 11:50:51
$dictionary["te_Disposition_student_batch"]["fields"]["te_disposition_student_batch_te_student_batch"] = array (
  'name' => 'te_disposition_student_batch_te_student_batch',
  'type' => 'link',
  'relationship' => 'te_disposition_student_batch_te_student_batch',
  'source' => 'non-db',
  'module' => 'te_student_batch',
  'bean_name' => 'te_student_batch',
  'vname' => 'LBL_TE_DISPOSITION_STUDENT_BATCH_TE_STUDENT_BATCH_FROM_TE_STUDENT_BATCH_TITLE',
  'id_name' => 'te_disposi5321t_batch_ida',
);
$dictionary["te_Disposition_student_batch"]["fields"]["te_disposition_student_batch_te_student_batch_name"] = array (
  'name' => 'te_disposition_student_batch_te_student_batch_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_TE_DISPOSITION_STUDENT_BATCH_TE_STUDENT_BATCH_FROM_TE_STUDENT_BATCH_TITLE',
  'save' => true,
  'id_name' => 'te_disposi5321t_batch_ida',
  'link' => 'te_disposition_student_batch_te_student_batch',
  'table' => 'te_student_batch',
  'module' => 'te_student_batch',
  'rname' => 'name',
);
$dictionary["te_Disposition_student_batch"]["fields"]["te_disposi5321t_batch_ida"] = array (
  'name' => 'te_disposi5321t_batch_ida',
  'type' => 'link',
  'relationship' => 'te_disposition_student_batch_te_student_batch',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_TE_DISPOSITION_STUDENT_BATCH_TE_STUDENT_BATCH_FROM_TE_DISPOSITION_STUDENT_BATCH_TITLE',
);
