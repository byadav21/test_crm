<?php
$module_name = 'te_Program_category';
$listViewDefs [$module_name] = 
array (
  'NAME' => 
  array (
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'PROGRAMS' => 
  array (
    'type' => 'textfield',
    'studio' => 'visible',
    'label' => 'Programs',
    'width' => '10%',
    'default' => true,
  ),
  'ISTITUTES_LIST' => 
  array (
    'type' => 'varchar',
    'studio' => 'visible',
    'label' => 'Institutes',
    'width' => '10%',
    'default' => true,
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => '9%',
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'module' => 'Employees',
    'id' => 'ASSIGNED_USER_ID',
    'default' => false,
  ),
);
?>
