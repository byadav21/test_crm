<?php
$module_name = 'te_budgeted_campaign';
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
            'name' => 'campaign_date',
            'label' => 'LBL_CAMPAIGN_DATE',
          ),
          1 => 
          array (
            'name' => 'te_utm_te_budgeted_campaign_1_name',
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
            'name' => 'cost',
            'label' => 'LBL_COST',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'conversion',
            'label' => 'LBL_CONVERSION',
          ),
          1 => 
          array (
            'name' => 'leads',
            'label' => 'LBL_LEADS',
          ),
        ),
        3 => 
        array (
          0 => '',
          1 => '',
        ),
        4 => 
        array (
          0 => '',
        ),
      ),
    ),
  ),
);
?>
