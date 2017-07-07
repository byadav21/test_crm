<?php
$module_name = 'te_target_campaign';
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
          'file' => 'custom/modules/te_target_campaign/target_campaign.js',
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
      'syncDetailEditViews' => true,
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
            'name' => 'program',
            'label' => 'LBL_PROGRAM',
            'comment' => '',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'batch',
            'label' => 'LBL_BATCH',
            'comment' => '',
          ),
          1 => 
          array (
            'name' => 'vendor',
            'label' => 'LBL_VENDOR',
            'comment' => '',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'Status',
            'studio' => 'visible',
            'label' => 'LBL_STATUS',
          ),
          1 => 
          array (
            'name' => 'template',
            'label' => 'LBL_TEMPLATE',
            'comment' => '',
          ),
        ),
        3 => 
        array (
          0 => 'description',
        ),
      ),
    ),
  ),
);
?>
