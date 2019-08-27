<?php
$module_name = 'te_student_payment_plan';
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
            'name' => 'student',
            'studio' => 'visible',
            'label' => 'LBL_STUDENT',
          ),
          1 => 
          array (
            'name' => 'te_student_batch_te_student_payment_plan_1_name',
          ),
        ),
        1 => 
        array (
          0 => 'name',
          1 => 
          array (
            'name' => 'paid',
            'studio' => 'visible',
            'label' => 'LBL_PAID',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'due_date',
            'label' => 'LBL_DUE_DATE',
          ),
          1 => 'description',
        ),
      ),
    ),
  ),
);
?>
