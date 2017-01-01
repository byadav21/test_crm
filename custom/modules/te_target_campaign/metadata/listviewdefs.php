<?php
$module_name = 'te_target_campaign';
$listViewDefs [$module_name] = 
array (
  'NAME' => 
  array (
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'PROGRAM' => 
  array (
    'label' => 'LBL_PROGRAM',
    'type' => 'enum',
    'width' => '10%',
    'default' => true,
  ),
  'BATCH' => 
  array (
    'label' => 'LBL_BATCH',
    'type' => 'enum',
    'width' => '10%',
    'default' => true,
  ),
  'VENDOR' => 
  array (
    'label' => 'LBL_VENDOR',
    'type' => 'enum',
    'width' => '10%',
    'default' => true,
  ),
  'send_email' => 
  array (
    'label' => 'LBL_SEND_EMAIL',
	'type' => 'varchar',
    'width' => '10%',
    'default' => true,
  ),
);
?>
