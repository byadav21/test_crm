<?php
// created: 2016-12-23 06:33:02
$dictionary["te_target_campaign_te_target_campaign_list_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'te_target_campaign_te_target_campaign_list_1' => 
    array (
      'lhs_module' => 'te_target_campaign',
      'lhs_table' => 'te_target_campaign',
      'lhs_key' => 'id',
      'rhs_module' => 'te_target_campaign_list',
      'rhs_table' => 'te_target_campaign_list',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'te_target_campaign_te_target_campaign_list_1_c',
      'join_key_lhs' => 'te_target_b188ampaign_ida',
      'join_key_rhs' => 'te_target_ee97gn_list_idb',
    ),
  ),
  'table' => 'te_target_campaign_te_target_campaign_list_1_c',
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
      'name' => 'te_target_b188ampaign_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'te_target_ee97gn_list_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'te_target_campaign_te_target_campaign_list_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'te_target_campaign_te_target_campaign_list_1_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'te_target_b188ampaign_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'te_target_campaign_te_target_campaign_list_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'te_target_ee97gn_list_idb',
      ),
    ),
  ),
);