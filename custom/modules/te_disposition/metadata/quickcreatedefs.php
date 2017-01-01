<?php
$module_name = 'te_disposition';
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
      'includes' => 
      array (
        0 => 
        array (
          'file' => 'custom/modules/te_disposition/custom.js',
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
            'name' => 'status',
            'studio' => 'visible',
            'label' => 'LBL_STATUS',
          ),
          1 => 
          array (
            'name' => 'status_detail',
            'studio' => 'visible',
            'label' => 'LBL_STATUS_DETAIL',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'description',
            'comment' => 'Full text of the note',
            'label' => 'LBL_NOTE',
            'displayParams' => 
            array (
              'rows' => 3,
              'cols' => 29,
            ),
          ),
          1 => '',
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'date_of_callback',
            'studio' => 'visible',
            'label' => 'LBL_DATEOFCALLBACK',
          ),
          1 => 
          array (
            'name' => 'date_of_followup',
            'label' => 'LBL_DATEOFFOLLOWUP',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'date_of_prospect',
            'label' => 'LBL_DATEOFPROSPECT',
          ),
        ),
        4 => 
        array (
          0 => '',
          1 => '',
        ),
        5 => 
        array (
          0 => '',
        ),
      ),
    ),
  ),
);
?>
