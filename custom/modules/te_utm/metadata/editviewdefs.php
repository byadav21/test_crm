<?php
$module_name = 'te_utm';
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
          'file' => 'custom/modules/te_utm/utm.js',
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
            'name' => 'name',
            'label' => 'LBL_UTM_NAME',
          ),
          1 => 
          array (
            'name' => 'te_vendor_te_utm_1_name',
            'label' => 'LBL_UTM_SOURCE',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'contract',
            'studio' => 'visible',
            'label' => 'UTM Contract',
          ),
          1 => 
          array (
            'name' => 'utm_status',
            'studio' => 'visible',
            'label' => 'LBL_UTM_STATUS',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'batch',
            'studio' => 'visible',
            'label' => 'LBL_BATCH',
          ),
          1 => '',
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'description',
            'label' => 'Notes',
            'displayParams' => 
            array (
              'cols' => 32,
              'rows' => 3,
            ),
          ),
          1 => array (
            'name' => 'contract_type',
            'studio' => 'visible',
            'label' => 'UTM Medium',
          ),
        ),
      ),
    ),
  ),
);
?>
