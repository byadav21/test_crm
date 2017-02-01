<?php
$viewdefs ['Users'] = 
array (
  'EditView' => 
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
        'headerTpl' => 'custom/modules/Users/tpls/EditViewHeader.tpl',
        'footerTpl' => 'custom/modules/Users/tpls/EditViewFooter.tpl',
      ),
	  'includes' => 
      array (
        0 => 
        array (
          'file' => 'custom/modules/Users/user.js',
        ),
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
          0 => 
          array (
            'name' => 'user_name',
            'label' => 'Email',
            'displayParams' => 
            array (
              'required' => true,
              'size' => 30,
            ),
          ),
          1 => '',
        ),
        1 => 
        array (
          0 => 'first_name',
          1 => 'last_name',
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'status',
            'customCode' => '{if $IS_ADMIN}@@FIELD@@{else}{$STATUS_READONLY}{/if}',
            'displayParams' => 
            array (
              'required' => true,
            ),
          ),
          1 => 
          array (
            'name' => 'UserType',
            'customCode' => '{if $IS_ADMIN}{$USER_TYPE_DROPDOWN}{else}{$USER_TYPE_READONLY}{/if}',
          ),
        ),
        3 => 
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
        4 => 
        array (
          0 => 
          array (
            'name' => 'full_name',
            'studio' => 
            array (
              'formula' => false,
            ),
            'label' => 'LBL_NAME',
          ),
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
          0 => 
          array (
            'name' => 'employee_status',
            'customCode' => '{if $IS_ADMIN}@@FIELD@@{else}{$EMPLOYEE_STATUS_READONLY}{/if}',
          ),
          1 => 
          array (
            'name' => 'department',
            'customCode' => '{if $IS_ADMIN}@@FIELD@@{else}{$DEPT_READONLY}{/if}',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'reports_to_name',
            'customCode' => '{if $IS_ADMIN}@@FIELD@@{else}{$REPORTS_TO_READONLY}{/if}',
          ),
          1 => 'designation',
        ),
      ),
    ),
  ),
);
?>
