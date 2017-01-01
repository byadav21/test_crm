<?php
// created: 2016-09-09 05:07:19
$dictionary["te_vendor_te_utm_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'te_vendor_te_utm_1' => 
    array (
      'lhs_module' => 'te_vendor',
      'lhs_table' => 'te_vendor',
      'lhs_key' => 'id',
      'rhs_module' => 'te_utm',
      'rhs_table' => 'te_utm',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'te_vendor_te_utm_1_c',
      'join_key_lhs' => 'te_vendor_te_utm_1te_vendor_ida',
      'join_key_rhs' => 'te_vendor_te_utm_1te_utm_idb',
    ),
  ),
  'table' => 'te_vendor_te_utm_1_c',
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
      'name' => 'te_vendor_te_utm_1te_vendor_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'te_vendor_te_utm_1te_utm_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'te_vendor_te_utm_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'te_vendor_te_utm_1_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'te_vendor_te_utm_1te_vendor_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'te_vendor_te_utm_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'te_vendor_te_utm_1te_utm_idb',
      ),
    ),
  ),
);