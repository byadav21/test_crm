<?php
// created: 2016-11-24 12:25:58
$dictionary["te_utm_te_actual_campaign_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'te_utm_te_actual_campaign_1' => 
    array (
      'lhs_module' => 'te_utm',
      'lhs_table' => 'te_utm',
      'lhs_key' => 'id',
      'rhs_module' => 'te_actual_campaign',
      'rhs_table' => 'te_actual_campaign',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'te_utm_te_actual_campaign_1_c',
      'join_key_lhs' => 'te_utm_te_actual_campaign_1te_utm_ida',
      'join_key_rhs' => 'te_utm_te_actual_campaign_1te_actual_campaign_idb',
    ),
  ),
  'table' => 'te_utm_te_actual_campaign_1_c',
  'fields' => 
  array (
    0 => 
    array (
      'name' => 'id',
      'type' => 'varchar',
      'len' => 36,
    ),
    1 => 
    array (
      'name' => 'date_modified',
      'type' => 'datetime',
    ),
    2 => 
    array (
      'name' => 'deleted',
      'type' => 'bool',
      'len' => '1',
      'default' => '0',
      'required' => true,
    ),
    3 => 
    array (
      'name' => 'te_utm_te_actual_campaign_1te_utm_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'te_utm_te_actual_campaign_1te_actual_campaign_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'te_utm_te_actual_campaign_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'te_utm_te_actual_campaign_1_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'te_utm_te_actual_campaign_1te_utm_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'te_utm_te_actual_campaign_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'te_utm_te_actual_campaign_1te_actual_campaign_idb',
      ),
    ),
  ),
);