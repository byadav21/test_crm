<?php
$module_name = 'te_UTM_System';
$listViewDefs [$module_name] = 
array (
  'NAME' => 
  array (
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'UTM_SOURCE' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_UTM_SOURCE',
    'width' => '10%',
    'default' => true,
  ),
  'WEBSITE_URL' => 
  array (
    'type' => 'url',
    'label' => 'LBL_WEBSITE_URL',
    'width' => '10%',
    'default' => true,
  ),
  'DATE_ENTERED' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_ENTERED',
    'width' => '10%',
    'default' => true,
  ),
);
?>
