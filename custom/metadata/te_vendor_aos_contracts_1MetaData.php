<?php
// created: 2016-10-29 01:20:18
$dictionary["te_vendor_aos_contracts_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'te_vendor_aos_contracts_1' => 
    array (
      'lhs_module' => 'te_vendor',
      'lhs_table' => 'te_vendor',
      'lhs_key' => 'id',
      'rhs_module' => 'AOS_Contracts',
      'rhs_table' => 'aos_contracts',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'te_vendor_aos_contracts_1_c',
      'join_key_lhs' => 'te_vendor_aos_contracts_1te_vendor_ida',
      'join_key_rhs' => 'te_vendor_aos_contracts_1aos_contracts_idb',
    ),
  ),
  'table' => 'te_vendor_aos_contracts_1_c',
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
      'name' => 'te_vendor_aos_contracts_1te_vendor_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'te_vendor_aos_contracts_1aos_contracts_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'te_vendor_aos_contracts_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'te_vendor_aos_contracts_1_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'te_vendor_aos_contracts_1te_vendor_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'te_vendor_aos_contracts_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'te_vendor_aos_contracts_1aos_contracts_idb',
      ),
    ),
  ),
);