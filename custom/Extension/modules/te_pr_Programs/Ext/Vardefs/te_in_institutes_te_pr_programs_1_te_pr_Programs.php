<?php
// created: 2016-09-05 07:08:40
$dictionary["te_pr_Programs"]["fields"]["te_in_institutes_te_pr_programs_1"] = array (
  'name' => 'te_in_institutes_te_pr_programs_1',
  'type' => 'link',
  'required'=>true,
  'relationship' => 'te_in_institutes_te_pr_programs_1',
  'source' => 'non-db',
  'module' => 'te_in_institutes',
  'bean_name' => 'te_in_institutes',
  'vname' => 'LBL_TE_IN_INSTITUTES_TE_PR_PROGRAMS_1_FROM_TE_IN_INSTITUTES_TITLE',
  'id_name' => 'te_in_institutes_te_pr_programs_1te_in_institutes_ida',
);
$dictionary["te_pr_Programs"]["fields"]["te_in_institutes_te_pr_programs_1_name"] = array (
  'name' => 'te_in_institutes_te_pr_programs_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'required'=>true,
  'vname' => 'LBL_TE_IN_INSTITUTES_TE_PR_PROGRAMS_1_FROM_TE_IN_INSTITUTES_TITLE',
  'save' => true,
  'id_name' => 'te_in_institutes_te_pr_programs_1te_in_institutes_ida',
  'link' => 'te_in_institutes_te_pr_programs_1',
  'table' => 'te_in_institutes',
  'module' => 'te_in_institutes',
  'rname' => 'name',
);
$dictionary["te_pr_Programs"]["fields"]["te_in_institutes_te_pr_programs_1te_in_institutes_ida"] = array (
  'name' => 'te_in_institutes_te_pr_programs_1te_in_institutes_ida',
  'type' => 'link',
  'relationship' => 'te_in_institutes_te_pr_programs_1',
  'source' => 'non-db',
  'required'=>true,
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_TE_IN_INSTITUTES_TE_PR_PROGRAMS_1_FROM_TE_PR_PROGRAMS_TITLE',
);
