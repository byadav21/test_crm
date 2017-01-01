<?php
$module_name = 'te_budgeted_campaign';
$viewdefs [$module_name] = 
array (
  'DetailView' => 
  array (
    'templateMeta' => 
    array (
      'form' => 
      array (
        'buttons' => 
        array (
          0 => 'EDIT',
          1 => 'DUPLICATE',
          2 => 'DELETE',
          3 => 'FIND_DUPLICATES',
        ),
      ),
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
            'name' => 'year',
            'label' => 'LBL_YEAR',
          ),
          1 => 
          array (
            'name' => 'week',
            'label' => 'LBL_WEEK',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'te_utm_te_budgeted_campaign_1_name',
          ),
          1 => 
          array (
            'name' => 'volume',
            'label' => 'LBL_VOLUME',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'cost',
            'label' => 'LBL_COST',
          ),
          1 => 
          array (
            'name' => 'conversion',
            'label' => 'LBL_CONVERSION',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
             'name' => 'conversion_rate',
            'label' => 'LBL_CONVERSION_RATE',
          ),
          1 =>  array (
            'name' => 'leads',
            'label' => 'LBL_LEADS',
          ),
        ),
		4 => 
        array (
          0 => 
          array (
              'name' => 'clp',
            'label' => 'LBL_CLP',
          ),
          1 =>  array (
            'name' => 'cpa',
            'label' => 'LBL_CPA',
          ),
        ),
      ),
    ),
  ),
);
?>
