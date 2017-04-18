<?php
// created: 2017-04-17 12:00:56
$dictionary["User"]["fields"]["te_department_expense_users_1"] = array (
  'name' => 'te_department_expense_users_1',
  'type' => 'link',
  'relationship' => 'te_department_expense_users_1',
  'source' => 'non-db',
  'module' => 'te_Department_Expense',
  'bean_name' => 'te_Department_Expense',
  'vname' => 'LBL_TE_DEPARTMENT_EXPENSE_USERS_1_FROM_TE_DEPARTMENT_EXPENSE_TITLE',
  'id_name' => 'te_department_expense_users_1te_department_expense_ida',
);
$dictionary["User"]["fields"]["te_department_expense_users_1_name"] = array (
  'name' => 'te_department_expense_users_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_TE_DEPARTMENT_EXPENSE_USERS_1_FROM_TE_DEPARTMENT_EXPENSE_TITLE',
  'save' => true,
  'id_name' => 'te_department_expense_users_1te_department_expense_ida',
  'link' => 'te_department_expense_users_1',
  'table' => 'te_department_expense',
  'module' => 'te_Department_Expense',
  'rname' => 'name',
);
$dictionary["User"]["fields"]["te_department_expense_users_1te_department_expense_ida"] = array (
  'name' => 'te_department_expense_users_1te_department_expense_ida',
  'type' => 'link',
  'relationship' => 'te_department_expense_users_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_TE_DEPARTMENT_EXPENSE_USERS_1_FROM_USERS_TITLE',
);
