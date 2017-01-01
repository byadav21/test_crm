<?php
$popupMeta = array (
    'moduleMain' => 'te_pr_Programs',
    'varName' => 'te_pr_Programs',
    'orderBy' => 'te_pr_programs.name',
    'whereClauses' => array (
  'name' => 'te_pr_programs.name',
),
    'searchInputs' => array (
  0 => 'te_pr_programs_number',
  1 => 'name',
  2 => 'priority',
  3 => 'status',
),
    'listviewdefs' => array (
  'DATE_ENTERED' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_ENTERED',
    'width' => '10%',
    'default' => true,
    'name' => 'date_entered',
  ),
  'NAME' => 
  array (
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
    'name' => 'name',
  ),
  'TE_IN_INSTITUTES_TE_PR_PROGRAMS_1_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_TE_IN_INSTITUTES_TE_PR_PROGRAMS_1_FROM_TE_IN_INSTITUTES_TITLE',
    'id' => 'TE_IN_INSTITUTES_TE_PR_PROGRAMS_1TE_IN_INSTITUTES_IDA',
    'width' => '10%',
    'default' => true,
    'name' => 'te_in_institutes_te_pr_programs_1_name',
  ),
  'ENROLLMENT_IN_PROGRESS_C' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_ENROLLMENT_IN_PROGRESS',
    'width' => '10%',
    'name' => 'enrollment_in_progress_c',
  ),
  'CLOSED_BATCH_C' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_CLOSED_BATCH',
    'width' => '10%',
    'name' => 'closed_batch_c',
  ),
  'CLASSES_IN_PROGRESS_C' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_CLASSES_IN_PROGRESS',
    'width' => '10%',
    'name' => 'classes_in_progress_c',
  ),
  'TOTAL_P_C' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_TOTAL_P',
    'width' => '10%',
    'name' => 'total_p_c',
  ),
),
);
