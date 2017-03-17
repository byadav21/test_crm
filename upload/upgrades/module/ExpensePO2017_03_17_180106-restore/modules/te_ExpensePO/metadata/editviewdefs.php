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
      'useTabs' => true,
      'tabDefs' => 
      array (
        'DEFAULT' => 
        array (
          'newTab' => true,
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
            'name' => 'refrenceid',
            'label' => 'LBL_REFRENCEID',
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
            'name' => 'amount',
            'label' => 'LBL_AMOUNT',
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
      ),
    ),
  ),
);
?>
