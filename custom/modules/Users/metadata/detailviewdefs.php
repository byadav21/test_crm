<?php
$viewdefs ['Users'] = 
array (
  'DetailView' => 
  array (
    'templateMeta' => 
    array (
      'maxColumns' => '2',
      'widths' => 
      array (
        0 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
        1 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
      ),
      'form' => 
      array (
        'headerTpl' => 'custom/modules/Users/tpls/DetailViewHeader.tpl',
        'footerTpl' => 'custom/modules/Users/tpls/DetailViewFooter.tpl',
      ),
      'useTabs' => false,
      'tabDefs' => 
      array (
        'LBL_USER_INFORMATION' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_EMPLOYEE_INFORMATION' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
      'syncDetailEditViews' => true,
    ),
    'panels' => 
    array (
      'LBL_USER_INFORMATION' => 
      array (
        0 => 
        array (
          0 => '',
          1 => '',
        ),
        1 => 
        array (
          0 => 'user_name',
          1 => 
          array (
            'name' => 'te_department_expense_users_1_name',
            'label' => 'LBL_TE_DEPARTMENT_EXPENSE_USERS_1_FROM_TE_DEPARTMENT_EXPENSE_TITLE',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'first_name',
            'label' => 'LBL_FIRST_NAME',
          ),
          1 => 
          array (
            'name' => 'last_name',
            'label' => 'LBL_LAST_NAME',
          ),
        ),
        3 => 
        array (
          0 => 'status',
          1 => 
          array (
            'name' => 'UserType',
            'customCode' => '{$USER_TYPE_READONLY}',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'neox_user',
            'label' => 'LBL_NEOXUSER',
          ),
          1 => 
          array (
            'name' => 'neox_password',
            'label' => 'LBL_NEOXPASS',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'neox_extension',
            'label' => 'LBL_NEOXEXTENSION',
          ),
          1 => 'phone_mobile',
        ),
        6 => 
        array (
          0 => 'full_name',
          1 => 
          array (
            'name' => 'user_access_type',
            'label' => 'LBL_USERTYPE',
          ),
        ),
      ),
      'LBL_EMPLOYEE_INFORMATION' => 
      array (
        0 => 
        array (
          0 => 'employee_status',
          1 => 'department',
        ),
        1 => 
        array (
          0 => 'reports_to_name',
          1 => 'designation',
        ),
      ),
    ),
  ),
);
?>
