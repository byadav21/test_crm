<?php
// created: 2016-11-30 12:13:45
$dictionary["te_drip_campaign_te_drip_campaign_list"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'te_drip_campaign_te_drip_campaign_list' => 
    array (
      'lhs_module' => 'te_drip_campaign',
      'lhs_table' => 'te_drip_campaign',
      'lhs_key' => 'id',
      'rhs_module' => 'te_drip_campaign_list',
      'rhs_table' => 'te_drip_campaign_list',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'te_drip_campaign_te_drip_campaign_list_c',
      'join_key_lhs' => 'te_drip_campaign_te_drip_campaign_listte_drip_campaign_ida',
      'join_key_rhs' => 'te_drip_campaign_te_drip_campaign_listte_drip_campaign_list_idb',
    ),
  ),
  'table' => 'te_drip_campaign_te_drip_campaign_list_c',
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
      'name' => 'te_drip_campaign_te_drip_campaign_listte_drip_campaign_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'te_drip_campaign_te_drip_campaign_listte_drip_campaign_list_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'te_drip_campaign_te_drip_campaign_listspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'te_drip_campaign_te_drip_campaign_list_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'te_drip_campaign_te_drip_campaign_listte_drip_campaign_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'te_drip_campaign_te_drip_campaign_list_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'te_drip_campaign_te_drip_campaign_listte_drip_campaign_list_idb',
      ),
    ),
  ),
);