<?php
$module_name = 'te_UTM_System';
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
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'utm_source',
            'label' => 'LBL_UTM_SOURCE',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'utm_medium',
            'label' => 'LBL_UTM_MEDIUM',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'utm_campaign',
            'label' => 'LBL_UTM_CAMPAIGN',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'utm_term',
            'label' => 'LBL_UTM_TERM',
          ),
        ),
        5 => 
        array (
          0 => 'description',
        ),
      ),
    ),
  ),
);
?>
