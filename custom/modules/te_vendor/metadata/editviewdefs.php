<?php
$module_name = 'te_vendor';
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
          0 => 
          array (
            'name' => 'name',
            'label' => 'LBL_NAME',
          ),
          1 => 
          array (
            'name' => 'contact_name',
            'label' => 'LBL_CONTACT_NAME',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'email',
            'label' => 'LBL_EMAIL',
          ),
          1 => 
          array (
            'name' => 'phone',
            'label' => 'LBL_PHONE',
          ),
        ),
        2 => 
        array (
          0 => array (
            'name' => 'description',
            'displayParams' => 
            array (
              'cols' => 32,
              'rows' => 3,
            ),
          ),
          1 => 
          array (
            'name' => 'vendor_status',
            'studio' => 'visible',
            'label' => 'LBL_VENDOR_STATUS',
          ),
        ),
      ),
    ),
  ),
);
?>
