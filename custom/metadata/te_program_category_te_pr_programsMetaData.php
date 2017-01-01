<?php
// created: 2016-10-19 03:58:18
$dictionary["te_program_category_te_pr_programs"] = array (
  'true_relationship_type' => 'many-to-many',
  'relationships' => 
  array (
    'te_program_category_te_pr_programs' => 
    array (
      'lhs_module' => 'te_Program_category',
      'lhs_table' => 'te_program_category',
      'lhs_key' => 'id',
      'rhs_module' => 'te_pr_Programs',
      'rhs_table' => 'te_pr_programs',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'te_program_category_te_pr_programs_c',
      'join_key_lhs' => 'te_program_category_te_pr_programste_program_category_ida',
      'join_key_rhs' => 'te_program_category_te_pr_programste_pr_programs_idb',
    ),
  ),
  'table' => 'te_program_category_te_pr_programs_c',
  'fields' => 
  array (
    0 => 
    array (
      'name' => 'id',
      'type' => 'varchar',
      'len' => 36,
    ),
    1 => 
    array (
      'name' => 'date_modified',
      'type' => 'datetime',
    ),
    2 => 
    array (
      'name' => 'deleted',
      'type' => 'bool',
      'len' => '1',
      'default' => '0',
      'required' => true,
    ),
    3 => 
    array (
      'name' => 'te_program_category_te_pr_programste_program_category_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'te_program_category_te_pr_programste_pr_programs_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'te_program_category_te_pr_programsspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'te_program_category_te_pr_programs_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'te_program_category_te_pr_programste_program_category_ida',
        1 => 'te_program_category_te_pr_programste_pr_programs_idb',
      ),
    ),
  ),
);