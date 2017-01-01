<?php
$module_name = 'te_target_campaign_list';
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
  'STATUS' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_STATUS',
    'width' => '10%',
    'default' => true,
  ),
  'SENT_DATE' => 
  array (
    'type' => 'datetimecombo',
    'label' => 'LBL_SENT_DATE',
    'width' => '10%',
    'default' => true,
  ),
);
?>
