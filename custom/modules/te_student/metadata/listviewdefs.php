<?php
$module_name = 'te_student';
$listViewDefs [$module_name] = 
array (
  'NAME' => 
  array (
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'EMAIL' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_EMAIL',
    'width' => '10%',
    'default' => true,
  ),
  'MOBILE' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_MOBILE',
    'width' => '10%',
    'default' => true,
  ),
  'STATUS' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_STATUS',
    'width' => '10%',
    'default' => true,
  ),
  'GENDER' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_GENDER',
    'width' => '10%',
    'default' => true,
  ),
  'DOB' => 
  array (
    'type' => 'date',
    'label' => 'LBL_DOB',
    'width' => '10%',
    'default' => true,
  ),
);
?>
