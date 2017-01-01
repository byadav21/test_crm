<?php
$module_name = 'te_disposition';
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
      'syncDetailEditViews' => true,
    ),
    'panels' => 
    array (
      'default' => 
      array (
        0 => 
        array (
          0 => 'name',
          1 => 'assigned_user_name',
        ),
        1 => 
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
        2 => 
        array (
          0 => 
          array (
            'name' => 'description',
            'label' => 'Note',
          ),
          1 => 
          array (
            'name' => 'date_of_callback',
            'label' => 'LBL_DATEOFCALLBACK',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'te_disposition_leads_name',
          ),
          1 => 
          array (
            'name' => 'date_of_followup',
            'label' => 'LBL_DATEOFFOLLOWUP',
          ),
        ),
        4 => 
        array (
          0 => '',
          1 => 
          array (
            'name' => 'date_of_prospect',
            'label' => 'LBL_DATEOFPROSPECT',
          ),
        ),
      ),
    ),
  ),
);
?>
