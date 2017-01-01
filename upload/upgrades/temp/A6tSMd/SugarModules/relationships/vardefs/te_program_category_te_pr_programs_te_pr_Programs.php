<?php
// created: 2016-09-30 00:03:54
$dictionary["te_pr_Programs"]["fields"]["te_program_category_te_pr_programs"] = array (
  'name' => 'te_program_category_te_pr_programs',
  'type' => 'link',
  'relationship' => 'te_program_category_te_pr_programs',
  'source' => 'non-db',
  'module' => 'te_Program_category',
  'bean_name' => false,
  'vname' => 'LBL_TE_PROGRAM_CATEGORY_TE_PR_PROGRAMS_FROM_TE_PROGRAM_CATEGORY_TITLE',
  'id_name' => 'te_program_category_te_pr_programste_program_category_ida',
);
$dictionary["te_pr_Programs"]["fields"]["te_program_category_te_pr_programs_name"] = array (
  'name' => 'te_program_category_te_pr_programs_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_TE_PROGRAM_CATEGORY_TE_PR_PROGRAMS_FROM_TE_PROGRAM_CATEGORY_TITLE',
  'save' => true,
  'id_name' => 'te_program_category_te_pr_programste_program_category_ida',
  'link' => 'te_program_category_te_pr_programs',
  'table' => 'te_program_category',
  'module' => 'te_Program_category',
  'rname' => 'name',
);
$dictionary["te_pr_Programs"]["fields"]["te_program_category_te_pr_programste_program_category_ida"] = array (
  'name' => 'te_program_category_te_pr_programste_program_category_ida',
  'type' => 'link',
  'relationship' => 'te_program_category_te_pr_programs',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_TE_PROGRAM_CATEGORY_TE_PR_PROGRAMS_FROM_TE_PR_PROGRAMS_TITLE',
);
