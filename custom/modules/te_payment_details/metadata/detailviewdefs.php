<?php
$module_name = 'te_payment_details';
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
          0 => 
          array (
            'name' => 'payment_type',
            'studio' => 'visible',
            'label' => 'LBL_PAYMENT_TYPE',
          ),
          1 => 
          array (
            'name' => 'leads_te_payment_details_1_name',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'date_of_payment',
            'label' => 'LBL_DATE_OF_PAYMENT',
          ),
          1 => 
          array (
            'name' => 'reference_number',
            'label' => 'LBL_REFERENCE_NUMBER',
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
            'name' => 'payment_source',
            'label' => 'LBL_PAYMENTTYPESOURCE',
          ),
        ),
        3 => 
        array (
          0 => 'description',
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
            'name' => 'invoice_order_number',
            'studio' => 'visible',
            'label' => 'Invoice Order Number',
          ),
          1 => '',
        ),
        5 => 
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
