<?php
$module_name = 'te_pr_Programs';
$viewdefs [$module_name] = 
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
      'useTabs' => false,
      'tabDefs' => 
      array (
        'DEFAULT' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
    ),
    'panels' => 
    array (
      'default' => 
      array (
        0 => 
        array (
          0 => 'name',
          1 => 
          array (
            'name' => 'te_in_institutes_te_pr_programs_1_name',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'director_name_c',
            'label' => 'LBL_DIRECTOR_NAME',
          ),
          1 => 
          array (
            'name' => 'email_address_c',
            'label' => 'LBL_EMAIL_ADDRESS',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'contact_number_c',
            'label' => 'LBL_CONTACT_NUMBER',
          ),
          1 => 
          array (
            'name' => 'mobile_number_c',
            'label' => 'LBL_MOBILE_NUMBER',
          ),
        ),
        3 => 
        array (
          0 => 'description',
          1 => '',
        ),
      ),
    ),
  ),
);
?>
