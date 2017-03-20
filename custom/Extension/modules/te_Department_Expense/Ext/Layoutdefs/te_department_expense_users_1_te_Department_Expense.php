<?php
 // created: 2017-03-20 18:06:08
$layout_defs["te_Department_Expense"]["subpanel_setup"]['te_department_expense_users_1'] = array (
  'order' => 100,
  'module' => 'Users',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_TE_DEPARTMENT_EXPENSE_USERS_1_FROM_USERS_TITLE',
  'get_subpanel_data' => 'te_department_expense_users_1',
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopButtonQuickCreate',
    ),
    1 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'mode' => 'MultiSelect',
    ),
  ),
);
