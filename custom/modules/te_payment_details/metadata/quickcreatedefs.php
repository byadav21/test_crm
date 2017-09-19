<?php
$module_name = 'te_payment_details';
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
          0 => 
          array (
            'name' => 'currency_type',
            'studio' => 'visible',
            'label' => 'Currency Type',
          ),
          1 => 
          array (
            'name' => 'amount',
            'label' => 'LBL_AMOUNT',
          ),
        ),
        1 => 
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
        2 => 
        array (
          0 => 
          array (
            'name' => 'payment_source',
            'label' => 'LBL_PAYMENTTYPESOURCE',
          ),
          1 => 
          array (
            'name' => 'transaction_id',
            'label' => 'LBL_TRANSACTIONID',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'invoice_order_number',
            'studio' => 'visible',
            'label' => 'Invoice Order Number',
          ),
        ),
        4 => 
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
      ),
    ),
  ),
);
?>
