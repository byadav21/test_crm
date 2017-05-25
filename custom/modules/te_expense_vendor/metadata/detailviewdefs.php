<?php
$module_name = 'te_expense_vendor';
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
            'name' => 'servicetaxdoc_c',
            'studio' => 'visible',
            'label' => 'LBL_SERVICETAXDOC',
          ),
          1 => 
          array (
            'name' => 'pancard_document_c',
            'studio' => 'visible',
            'label' => 'LBL_PANCARD_DOCUMENT',
          ),
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'cancledcheckdoc_c',
            'studio' => 'visible',
            'label' => 'LBL_CANCLEDCHECKDOC',
          ),
          1 => 
          array (
            'name' => 'gstn_c',
            'studio' => 'visible',
            'label' => 'LBL_GSTN',
          ),
        ),
        10 => 
        array (
          0 => 
          array (
            'name' => 'registrationdoc_c',
            'studio' => 'visible',
            'label' => 'LBL_REGISTRATIONDOC',
          ),
        ),
      ),
    ),
  ),
);
?>
