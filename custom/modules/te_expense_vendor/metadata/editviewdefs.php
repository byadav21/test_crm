<?php
$module_name = 'te_expense_vendor';
$viewdefs [$module_name] = 
array (
  'EditView' => 
  array (
    'templateMeta' => 
    array (
      'maxColumns' => '2',
      'enctype' => 'multipart/form-data',
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
      'syncDetailEditViews' => false,
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
            'name' => 'email_address',
            'label' => 'Email',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'mobile',
            'label' => 'LBL_MOBILE',
          ),
          1 => 
          array (
            'name' => 'address',
            'label' => 'LBL_ADDRESS',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'address_city',
            'label' => 'LBL_ADDRESS_CITY',
          ),
          1 => 
          array (
            'name' => 'address_state',
            'label' => 'LBL_ADDRESS_STATE',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'address_postalcode',
            'label' => 'LBL_ADDRESS_POSTALCODE',
          ),
          1 => 
          array (
            'name' => 'address_country',
            'label' => 'LBL_ADDRESS_COUNTRY',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'bank_name',
            'label' => 'bank_name',
          ),
          1 => 
          array (
            'name' => 'account_no',
            'label' => 'account_no',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'ifsc',
            'label' => 'ifsc',
          ),
          1 => 
          array (
            'name' => 'contact_person',
            'label' => 'contact_person',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'department_c',
            'studio' => 'visible',
            'label' => 'LBL_DEPARTMENT',
          ),
          1 => 
          array (
            'name' => 'legal_entity_status_c',
            'studio' => 'visible',
            'label' => 'LBL_LEGAL_ENTITY_STATUS',
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'service_tax_no',
            'label' => 'LBL_SERVICE_TAX_NO',
          ),
          1 => 
          array (
            'name' => 'pan',
            'label' => 'LBL_PAN',
          ),
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'gst',
            'label' => 'GST No',
          ),
        ),
        9 => 
        array (
          0 => '',
        ),
      ),
    ),
  ),
);
?>
