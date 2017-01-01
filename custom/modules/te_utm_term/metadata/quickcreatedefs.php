<?php
$module_name = 'te_utm_term';
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
          0 => 'name',
          1 => 
          array (
            'name' => 'te_utm_te_utm_term_1_name',
            'label' => 'LBL_TE_UTM_TE_UTM_TERM_1_FROM_TE_UTM_TITLE',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'institutes_c',
            'studio' => 'visible',
            'label' => 'LBL_INSTITUTES',
          ),
          1 => 
          array (
            'name' => 'programs_c',
            'studio' => 'visible',
            'label' => 'LBL_PROGRAMS',
          ),
        ),
        2 => 
        array (
          0 => 'assigned_user_name',
          1 => 
          array (
            'name' => 'description',
            'comment' => 'Full text of the note',
            'label' => 'LBL_DESCRIPTION',
          ),
        ),
      ),
    ),
  ),
);
?>
