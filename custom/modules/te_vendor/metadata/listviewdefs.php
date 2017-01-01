<?php
$module_name = 'te_vendor';
$listViewDefs [$module_name] = 
array (
  'NAME' => 
  array (
    'width' => '20%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'CONTACT_NAME' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_CONTACT_NAME',
    'width' => '20%',
    'default' => true,
  ),
  'EMAIL' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_EMAIL',
    'width' => '20%',
    'default' => true,
  ),
  'PHONE' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_PHONE',
    'width' => '10%',
    'default' => true,
  ),
  'DATE_ENTERED' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_ENTERED',
    'width' => '15%',
    'default' => true,
  ),
);
?>
