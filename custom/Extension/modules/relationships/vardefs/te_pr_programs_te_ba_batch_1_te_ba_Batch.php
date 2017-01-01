<?php
// created: 2016-09-05 07:25:52
$dictionary["te_ba_Batch"]["fields"]["te_pr_programs_te_ba_batch_1"] = array (
  'name' => 'te_pr_programs_te_ba_batch_1',
  'type' => 'link',
  'relationship' => 'te_pr_programs_te_ba_batch_1',
  'source' => 'non-db',
  'module' => 'te_pr_Programs',
  'bean_name' => 'te_pr_Programs',
  'vname' => 'LBL_TE_PR_PROGRAMS_TE_BA_BATCH_1_FROM_TE_PR_PROGRAMS_TITLE',
  'id_name' => 'te_pr_programs_te_ba_batch_1te_pr_programs_ida',
);
$dictionary["te_ba_Batch"]["fields"]["te_pr_programs_te_ba_batch_1_name"] = array (
  'name' => 'te_pr_programs_te_ba_batch_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_TE_PR_PROGRAMS_TE_BA_BATCH_1_FROM_TE_PR_PROGRAMS_TITLE',
  'save' => true,
  'id_name' => 'te_pr_programs_te_ba_batch_1te_pr_programs_ida',
  'link' => 'te_pr_programs_te_ba_batch_1',
  'table' => 'te_pr_programs',
  'module' => 'te_pr_Programs',
  'rname' => 'name',
);
$dictionary["te_ba_Batch"]["fields"]["te_pr_programs_te_ba_batch_1te_pr_programs_ida"] = array (
  'name' => 'te_pr_programs_te_ba_batch_1te_pr_programs_ida',
  'type' => 'link',
  'relationship' => 'te_pr_programs_te_ba_batch_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_TE_PR_PROGRAMS_TE_BA_BATCH_1_FROM_TE_BA_BATCH_TITLE',
);
