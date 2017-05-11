<?php
$listViewDefs ['Leads'] = 
array (
  'NAME' => 
  array (
    'width' => '10%',
    'label' => 'LBL_LIST_NAME',
    'link' => true,
    'orderBy' => 'name',
    'default' => true,
    'related_fields' => 
    array (
      0 => 'first_name',
      1 => 'last_name',
      2 => 'salutation',
    ),
  ),
  'EMAIL1' => 
  array (
    'width' => '16%',
    'label' => 'LBL_LIST_EMAIL_ADDRESS',
    'sortable' => false,
    'customCode' => '{$EMAIL1_LINK}{$EMAIL1}</a>',
    'default' => true,
  ),
  'PHONE_MOBILE' => 
  array (
    'width' => '10%',
    'label' => 'LBL_MOBILE_PHONE',
    'default' => true,
  ),
  'PROGRAM' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_PROGRAM',
    'width' => '10%',
    'sortable' => false,
  ),
  'INSTITUTE' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_INSTITUTE',
    'width' => '10%',
    'sortable' => false,
  ),
  'STATUS' => 
  array (
    'width' => '7%',
    'label' => 'LBL_LIST_STATUS',
    'default' => true,
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => '5%',
    'label' => 'LBL_LIST_ASSIGNED_USER',
    'module' => 'Users',
    'id' => 'ASSIGNED_USER_ID',
    'default' => true,
  ),
  'REPORT_TO_NAME' => 
  array (
    'type' => 'relate',
    'label' => 'LBL_REPORTS_TO',
    'id' => 'REPORTS_TO_ID',
    'link' => true,
    'width' => '10%',
    'default' => true,
    'sortable' => false,
  ),
  'DATE_ENTERED' => 
  array (
    'width' => '10%',
    'label' => 'LBL_DATE_ENTERED',
    'default' => true,
  ),
  'TEMP_LEAD_DATE_C' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_TEMP_LEAD_DATE',
    'width' => '10%',
  ),
  'DATE_OF_CALLBACK' => 
  array (
    'type' => 'datetimecombo',
    'label' => 'LBL_DATEOFCALLBACK',
    'width' => '10%',
    'default' => true,
  ),
  'DATE_OF_PROSPECT' => 
  array (
    'type' => 'datetimecombo',
    'label' => 'LBL_DATEOFPROSPECT',
    'width' => '10%',
    'default' => true,
  ),
  'DATE_OF_FOLLOWUP' => 
  array (
    'type' => 'datetimecombo',
    'label' => 'LBL_DATEOFFOLLOWUP',
    'width' => '10%',
    'default' => true,
  ),
  'STATUS_DESCRIPTION' => 
  array (
    'type' => 'enum',
    'default' => true,
    'label' => 'LBL_STATUS_DESCRIPTION',
    'width' => '10%',
  ),
  'DATE_MODIFIED' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_MODIFIED',
    'width' => '10%',
    'default' => true,
  ),
  'TITLE' => 
  array (
    'width' => '10%',
    'label' => 'LBL_TITLE',
    'default' => false,
  ),
  'REFERED_BY' => 
  array (
    'width' => '10%',
    'label' => 'LBL_REFERED_BY',
    'default' => false,
  ),
  'ACCOUNT_NAME' => 
  array (
    'width' => '15%',
    'label' => 'LBL_LIST_ACCOUNT_NAME',
    'default' => false,
    'related_fields' => 
    array (
      0 => 'account_id',
    ),
  ),
  'DEPARTMENT' => 
  array (
    'width' => '10%',
    'label' => 'LBL_DEPARTMENT',
    'default' => false,
  ),
  'PHONE_WORK' => 
  array (
    'width' => '15%',
    'label' => 'LBL_LIST_PHONE',
    'default' => false,
  ),
  'DO_NOT_CALL' => 
  array (
    'width' => '10%',
    'label' => 'LBL_DO_NOT_CALL',
    'default' => false,
  ),
  'PHONE_HOME' => 
  array (
    'width' => '10%',
    'label' => 'LBL_HOME_PHONE',
    'default' => false,
  ),
  'PHONE_OTHER' => 
  array (
    'width' => '10%',
    'label' => 'LBL_OTHER_PHONE',
    'default' => false,
  ),
  'PHONE_FAX' => 
  array (
    'width' => '10%',
    'label' => 'LBL_FAX_PHONE',
    'default' => false,
  ),
  'PRIMARY_ADDRESS_COUNTRY' => 
  array (
    'width' => '10%',
    'label' => 'LBL_PRIMARY_ADDRESS_COUNTRY',
    'default' => false,
  ),
  'PRIMARY_ADDRESS_STREET' => 
  array (
    'width' => '10%',
    'label' => 'LBL_PRIMARY_ADDRESS_STREET',
    'default' => false,
  ),
  'PRIMARY_ADDRESS_CITY' => 
  array (
    'width' => '10%',
    'label' => 'LBL_PRIMARY_ADDRESS_CITY',
    'default' => false,
  ),
  'PRIMARY_ADDRESS_STATE' => 
  array (
    'width' => '10%',
    'label' => 'LBL_PRIMARY_ADDRESS_STATE',
    'default' => false,
  ),
  'PRIMARY_ADDRESS_POSTALCODE' => 
  array (
    'width' => '10%',
    'label' => 'LBL_PRIMARY_ADDRESS_POSTALCODE',
    'default' => false,
  ),
  'ALT_ADDRESS_COUNTRY' => 
  array (
    'width' => '10%',
    'label' => 'LBL_ALT_ADDRESS_COUNTRY',
    'default' => false,
  ),
  'ALT_ADDRESS_STREET' => 
  array (
    'width' => '10%',
    'label' => 'LBL_ALT_ADDRESS_STREET',
    'default' => false,
  ),
  'ALT_ADDRESS_CITY' => 
  array (
    'width' => '10%',
    'label' => 'LBL_ALT_ADDRESS_CITY',
    'default' => false,
  ),
  'ALT_ADDRESS_STATE' => 
  array (
    'width' => '10%',
    'label' => 'LBL_ALT_ADDRESS_STATE',
    'default' => false,
  ),
  'ALT_ADDRESS_POSTALCODE' => 
  array (
    'width' => '10%',
    'label' => 'LBL_ALT_ADDRESS_POSTALCODE',
    'default' => false,
  ),
  'CREATED_BY' => 
  array (
    'width' => '10%',
    'label' => 'LBL_CREATED',
    'default' => false,
  ),
  'MODIFIED_BY_NAME' => 
  array (
    'width' => '5%',
    'label' => 'LBL_MODIFIED',
    'default' => false,
  ),
  'LEAD_SOURCE' => 
  array (
    'width' => '10%',
    'label' => 'LBL_LEAD_SOURCE',
    'default' => false,
  ),
);
?>
