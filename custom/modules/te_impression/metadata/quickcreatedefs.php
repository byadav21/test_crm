<?php
$module_name = 'te_impression';
$viewdefs [$module_name] = 
array (
  'QuickCreate' => 
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
            'name' => 'impression_date',
            'label' => 'LBL_IMPRESSION_DATE',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'actual_type',
            'studio' => 'visible',
            'label' => 'Type',
          ),
          1 => '',
        ),
      ),
    ),
  ),
);
?>
