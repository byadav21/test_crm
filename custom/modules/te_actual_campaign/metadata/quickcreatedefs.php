<?php
$module_name = 'te_actual_campaign';
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
          0 => 
          array (
            'name' => 'plan_date',
            'label' => 'LBL_PLAN_DATE',
          ),
          1 => 
          array (
            'name' => 'volume',
            'label' => 'LBL_VOLUME',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'leads',
            'label' => 'LBL_LEADS',
          ),
          1 => 
          array (
            'name' => 'rate',
            'label' => 'LBL_RATE',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'type',
            'studio' => 'visible',
            'label' => 'LBL_TYPE',
          ),
          1 => 
          array (
            'name' => 'total_cost',
            'label' => 'LBL_TOTAL_COST',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'cpl',
            'label' => 'LBL_CPL',
          ),
          1 => 
          array (
            'name' => 'cpa',
            'label' => 'LBL_CPA',
          ),
        ),
      ),
    ),
  ),
);
?>
