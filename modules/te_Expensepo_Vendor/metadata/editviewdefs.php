<?php
$module_name = 'te_Expensepo_Vendor';
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
      'useTabs' => true,
      'tabDefs' => 
      array (
        'DEFAULT' => 
        array (
          'newTab' => true,
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
            'name' => 'email_id',
            'label' => 'LBL_EMAIL_ID',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'phone_no',
            'label' => 'LBL_PHONE_NO',
          ),
          1 => 
          array (
            'name' => 'mobile',
            'label' => 'LBL_MOBILE',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'address',
            'studio' => 'visible',
            'label' => 'LBL_ADDRESS',
          ),
          1 => 
          array (
            'name' => 'city',
            'label' => 'LBL_CITY',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'state',
            'label' => 'LBL_STATE',
          ),
          1 => 
          array (
            'name' => 'country',
            'label' => 'LBL_COUNTRY',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'service_tax_no',
            'label' => 'LBL_SERVICE_TAX_NO',
          ),
          1 => 
          array (
            'name' => 'pan_no',
            'label' => 'LBL_PAN_NO',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'documents',
            'studio' => 'visible',
            'label' => 'LBL_DOCUMENTS',
          ),
          1 => 
          array (
            'name' => 'dated',
            'label' => 'LBL_DATED',
          ),
        ),
      ),
    ),
  ),
);
?>
