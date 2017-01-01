<?php
$module_name = 'te_actual_campaign';
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
            'name' => 'plan_date',
            'label' => 'LBL_PLAN_DATE',
          ),
          1 => 
          array (
            'name' => 'te_utm_te_actual_campaign_1_name',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'volume',
            'label' => 'LBL_VOLUME',
          ),
          1 => 
          array (
            'name' => 'type',
            'studio' => 'visible',
            'label' => 'LBL_TYPE',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'rate',
            'label' => 'LBL_RATE',
          ),
          1 => 
          array (
            'name' => 'total_cost',
            'label' => 'LBL_TOTAL_COST',
          ),
        ),

      ),
    ),
  ),
);
?>
