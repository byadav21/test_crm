<?php
$module_name = 'te_Expensepo_Vendor';
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
          0 => 'name',
          1 => 
          array (
            'name' => 'mobile',
            'label' => 'LBL_MOBILE',
          ),
        ),
        1 => 
        array (
          0 => 'date_entered',
          1 => 'date_modified',
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'email_id',
            'label' => 'LBL_EMAIL_ID',
          ),
          1 => 
          array (
            'name' => 'phone_no',
            'label' => 'LBL_PHONE_NO',
          ),
        ),
        3 => 
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
        4 => 
        array (
          0 => 
          array (
            'name' => 'country',
            'label' => 'LBL_COUNTRY',
          ),
          1 => 
          array (
            'name' => 'documents',
            'studio' => 'visible',
            'label' => 'LBL_DOCUMENTS',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'service_tax_no',
            'label' => 'LBL_SERVICE_TAX_NO',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'state',
            'label' => 'LBL_STATE',
          ),
          1 => 
          array (
            'name' => 'dated',
            'label' => 'LBL_DATED',
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'pan_no',
            'label' => 'LBL_PAN_NO',
          ),
          1 => 'description',
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'filename',
            'label' => 'LBL_FILENAME',
          ),
          1 => 
          array (
            'name' => 'pancard_filename',
            'label' => 'LBL_PANCARD_FILENAME',
          ),
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'servicetax_file_mime_type',
            'label' => 'LBL_SERVICETAX_FILE_MIME_TYPE',
          ),
          1 => 
          array (
            'name' => 'pancard_file_mime_type',
            'label' => 'LBL_PANCARD_FILE_MIME_TYPE',
          ),
        ),
        10 => 
        array (
          0 => 
          array (
            'name' => 'servicetax_filename',
            'label' => 'LBL_SERVICETAX_FILENAME',
          ),
          1 => 
          array (
            'name' => 'created_by_name',
            'label' => 'LBL_CREATED',
          ),
        ),
      ),
    ),
  ),
);
?>
