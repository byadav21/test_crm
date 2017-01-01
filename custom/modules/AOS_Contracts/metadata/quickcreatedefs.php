<?php
$module_name = 'AOS_Contracts';
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
      'syncDetailEditViews' => false,
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
            'name' => 'status',
            'studio' => 'visible',
            'label' => 'LBL_STATUS',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'total_contract_value',
            'label' => 'LBL_TOTAL_CONTRACT_VALUE',
          ),
          1 => 
          array (
            'name' => 'renewal_reminder_date',
            'label' => 'LBL_EXPIRY_DATE',
            'type' => 'date',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'rate_c',
            'label' => 'LBL_RATE',
          ),
          1 => 
          array (
            'name' => 'start_date',
            'label' => 'LBL_START_DATE',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'target_c',
            'label' => 'LBL_TARGET',
          ),
          1 => 
          array (
            'name' => 'end_date',
            'label' => 'LBL_END_DATE',
          ),
        ),
        4 => 
        array (
          array (
            'name' => 'contract_type',
            'studio' => 'visible',
            'label' => 'LBL_CONTRACT_TYPE',
          ),
          1 => 'description',
        ),
        
      ),
    ),
  ),
);
?>
