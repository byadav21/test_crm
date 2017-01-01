<?php
$module_name = 'te_lead_assignment_rule';
$listViewDefs [$module_name] = 
array (
  'NAME' => 
  array (
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'RULE_STATUS' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_RULE_STATUS',
    'width' => '10%',
    'default' => true,
  ),
  'LEAD_SOURCE' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_LEAD_SOURCE',
    'width' => '10%',
    'default' => true,
  ),
  'BATCH' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_BATCH',
    'id' => 'TE_BA_BATCH_ID_C',
    'link' => true,
    'width' => '10%',
    'default' => true,
  ),
  'AGENT' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_AGENT',
    'id' => 'USER_ID_C',
    'link' => true,
    'width' => '10%',
    'default' => true,
  ),
  'SECURITY_GROUP' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_SECURITY_GROUP',
    'id' => 'SECURITYGROUP_ID_C',
    'link' => true,
    'width' => '10%',
    'default' => true,
  ),
  'METHOD' => 
  array (
    'type' => 'radioenum',
    'studio' => 'visible',
    'label' => 'LBL_METHOD',
    'width' => '10%',
    'default' => true,
  ),
  'CATEGORY' => 
  array (
    'type' => 'dynamicenum',
    'studio' => 'visible',
    'label' => 'LBL_CATEGORY',
    'width' => '10%',
    'default' => false,
  ),
  'LEAD_STATUS' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_LEAD_STATUS',
    'width' => '10%',
    'default' => false,
  ),
);
?>
