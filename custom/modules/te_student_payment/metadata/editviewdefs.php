<?php
$module_name = 'te_student_payment';
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
            'name' => 'invoice_number',
            'studio' => 'visible',
            'label' => 'Invoice Number',
          ),
          1 => 
          array (
            'name' => 'invoice_url',
            'studio' => 'visible',
            'label' => 'Invoice URL',
          ),
        ),
        4 => 
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
        5 => 
        array (
          0 => 
          array (
            'name' => 'invoice_order_number',
            'studio' => 'visible',
            'label' => 'Invoice Order Number',
          ),
        ),
        6 => 
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
