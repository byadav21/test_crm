<?php
$module_name = 'te_ExpensePO';
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
            'name' => 'refrenceid',
            'label' => 'LBL_REFRENCEID',
          ),
          1 => 
          array (
            'name' => 'amount',
            'label' => 'LBL_AMOUNT',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'dated',
            'label' => 'LBL_DATED',
          ),
          1 => 
          array (
            'name' => 'status',
            'studio' => 'visible',
            'label' => 'LBL_STATUS',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'porequired',
            'studio' => 'visible',
            'label' => 'LBL_POREQUIRED',
          ),
          1 => 
          array (
            'name' => 'documents',
            'studio' => 'visible',
            'label' => 'LBL_DOCUMENTS',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'vendor_c',
            'studio' => 'visible',
            'label' => 'LBL_VENDOR',
          ),
          1 => 
          array (
            'name' => 'cost_center',
            'label' => 'Cost Center',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'gl_code_c',
            'label' => 'LBL_GL_CODE',
          ),
          1 => '',
        ),
      ),
    ),
  ),
);
?>
