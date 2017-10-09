<?php
$searchdefs ['Leads'] = 
array (
  'layout' => 
  array (
    'basic_search' => 
    array (
      'search_name' => 
      array (
        'name' => 'search_name',
        'label' => 'LBL_NAME',
        'type' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'batch' => 
      array (
        'label' => 'LBL_BATCH',
        'type' => 'enum',
        'width' => '10%',
        'default' => true,
        'name' => 'batch',
      ),
      'email' => 
      array (
        'name' => 'email',
        'label' => 'LBL_EMAIL',
        'type' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'Counsellors' => 
      array (
        'label' => 'Counsellors',
        'type' => 'enum',
        'width' => '10%',
        'default' => true,
        'name' => 'Counsellors',
      ),
      'phone_mobile' => 
      array (
        'type' => 'phone',
        'label' => 'LBL_MOBILE_PHONE',
        'width' => '10%',
        'default' => true,
        'name' => 'phone_mobile',
      ),
    ),
    'advanced_search' => 
    array (
      'email' => 
      array (
        'name' => 'email',
        'label' => 'LBL_EMAIL',
        'type' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'phone_mobile' => 
      array (
        'type' => 'phone',
        'label' => 'LBL_MOBILE_PHONE',
        'width' => '10%',
        'default' => true,
        'name' => 'phone_mobile',
      ),
      'counsellors' => 
      array (
        'label' => 'Counsellors',
        'type' => 'enum',
        'width' => '10%',
        'default' => true,
        'name' => 'Counsellors',
      ),
      'batch' => 
      array (
        'label' => 'LBL_BATCH',
        'type' => 'enum',
        'width' => '10%',
        'default' => true,
        'name' => 'batch',
      ),
      'status_description' => 
      array (
        'type' => 'enum',
        'default' => true,
        'label' => 'LBL_STATUS_DESCRIPTION',
        'width' => '10%',
        'name' => 'status_description',
      ),
      'status' => 
      array (
        'name' => 'status',
        'default' => true,
        'width' => '10%',
      ),
      'lead_source' => 
      array (
        'name' => 'lead_source',
        'default' => true,
        'width' => '10%',
      ),
      'date_entered' => 
      array (
        'type' => 'datetime',
        'label' => 'LBL_DATE_ENTERED',
        'width' => '10%',
        'default' => true,
        'name' => 'date_entered',
      ),
      'vendor_list' => 
      array (
        'label' => 'LBL_VENDOR',
        'type' => 'enum',
        'studio' => 'visible',
        'width' => '10%',
        'default' => true,
        'name' => 'vendor_list',
      ),
    ),
  ),
  'templateMeta' => 
  array (
    'maxColumns' => '3',
    'maxColumnsBasic' => '4',
    'widths' => 
    array (
      'label' => '10',
      'field' => '30',
    ),
  ),
);
?>
