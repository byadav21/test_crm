<?php
$module_name = 'te_student_payment';
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
            'name' => 'te_student_te_student_payment_1_name',
          ),
          1 => 
          array (
            'name' => 'batch_id',
            'studio' => 'visible',
            'label' => 'LBL_BATCH_ID',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'payment_type',
            'studio' => 'visible',
            'label' => 'LBL_PAYMENT_TYPE',
          ),
          1 => 
          array (
            'name' => 'payment_source',
            'studio' => 'visible',
            'label' => 'LBL_PAYMENT_SOURCE',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'amount',
            'label' => 'LBL_AMOUNT',
          ),
          1 => 
          array (
            'name' => 'date_of_payment',
            'label' => 'LBL_DATE_OF_PAYMENT',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'reference_number',
            'label' => 'LBL_REFERENCE_NUMBER',
          ),
          1 => 
          array (
            'name' => 'payment_realized',
            'label' => 'LBL_PAYMENT_REALIZED',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'transaction_id',
            'label' => 'LBL_TRANSACTION_ID',
          ),
          1 => 'description',
        ),
      ),
    ),
  ),
);
?>
