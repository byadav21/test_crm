<?php
$module_name = 'te_ExpensePR';
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
            'name' => 'status',
            'label' => 'Reference ID',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'reason_rejection',
            'label' => 'Reason Rejection',
          ),
          1 => 
          array (
            'name' => 'dated',
            'label' => 'Date',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'amount',
            'label' => 'Amount',
          ),
          1 => 
          array (
            'name' => 'refrenceid',
            'label' => 'Reference ID',
          ),
        ),
      ),
    ),
  ),
);
?>
