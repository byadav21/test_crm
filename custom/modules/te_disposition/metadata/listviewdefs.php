<?php
$module_name = 'te_disposition';
$listViewDefs [$module_name] = 
array (
  'NAME' => 
  array (
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'STATUS_DETAIL' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_STATUS_DETAIL',
    'width' => '10%',
    'default' => true,
  ),
  'DATE_OF_CALLBACK' => 
  array (
    'type' => 'datetimecombo',
    'label' => 'LBL_DATE',
    'width' => '10%',
    'default' => true,
  ),
  'TE_DISPOSITION_LEADS_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_TE_DISPOSITION_LEADS_FROM_LEADS_TITLE',
    'id' => 'TE_DISPOSITION_LEADSLEADS_IDA',
    'width' => '10%',
    'default' => true,
  ),
  'LEAD_MOBILE' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_LEAD_MOBILE',
    'width' => '10%',
    'default' => true,
  ),
  'LEAD_EMAIL' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_LEAD_EMAIL',
    'width' => '10%',
    'default' => true,
  ),
  'PROGRAM_NAME' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_PROGRAM',
    'width' => '10%',
    'default' => true,
  ),
  'BATCH_NAME' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_BATCH',
    'width' => '10%',
    'default' => true,
  ),
  'SHOW_BUTTON' => 
  array (
  'type' => 'varchar',
    'width' => '9%',
    'label' => 'LBL_UPDATE_DISPOSITION',
      'default' => true,
  ),
);
?>
