<?php
$module_name = 'AOS_Contracts';
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
      'includes' => 
      array (
        0 => 
        array (
          'file' => 'custom/modules/AOS_Contracts/contract.js',
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
          0 => 
          array (
            'name' => 'te_vendor_aos_contracts_1_name',
          ),
          1 => 
          array (
            'name' => 'performance_metrics',
            'studio' => 'visible',
            'label' => 'Performance Metrics',
          ),
        ),
        1 => 
        array (
          0 => 'name',
          1 => 
          array (
            'name' => 'contract_type',
            'studio' => 'visible',
            'label' => 'LBL_CONTRACT_TYPE',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'total_contract_value',
            'label' => 'LBL_TOTAL_CONTRACT_VALUE',
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
            'name' => 'rate_c',
            'label' => 'LBL_RATE',
          ),
          1 => 
          array (
            'name' => 'end_date',
            'label' => 'LBL_END_DATE',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'target_c',
            'label' => 'LBL_TARGET',
          ),
          1 => 
          array (
            'name' => 'renewal_reminder_date',
            'label' => 'LBL_EXPIRY_DATE',
            'type' => 'date',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'volume_c',
            'label' => 'LBL_VOLUME',
          ),
          1 => 
          array (
            'name' => 'status',
            'studio' => 'visible',
            'label' => 'LBL_STATUS',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'description',
            'displayParams' => 
            array (
              'cols' => 32,
              'rows' => 3,
            ),
          ),
          1 => 
          array (
            'name' => 'po_number',
            'label' => 'LBL_PO_NUMBER',
          ),
        ),
      ),
    ),
  ),
);
?>
