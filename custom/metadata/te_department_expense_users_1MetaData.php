<?php
// created: 2017-04-17 12:00:56
$dictionary["te_department_expense_users_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'te_department_expense_users_1' => 
    array (
      'lhs_module' => 'te_Department_Expense',
      'lhs_table' => 'te_department_expense',
      'lhs_key' => 'id',
      'rhs_module' => 'Users',
      'rhs_table' => 'users',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'te_department_expense_users_1_c',
      'join_key_lhs' => 'te_department_expense_users_1te_department_expense_ida',
      'join_key_rhs' => 'te_department_expense_users_1users_idb',
    ),
  ),
  'table' => 'te_department_expense_users_1_c',
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
      'name' => 'te_department_expense_users_1te_department_expense_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'te_department_expense_users_1users_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'te_department_expense_users_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'te_department_expense_users_1_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'te_department_expense_users_1te_department_expense_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'te_department_expense_users_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'te_department_expense_users_1users_idb',
      ),
    ),
  ),
);