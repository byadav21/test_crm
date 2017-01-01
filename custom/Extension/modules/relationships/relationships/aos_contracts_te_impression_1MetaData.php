<?php
// created: 2016-10-22 13:16:03
$dictionary["aos_contracts_te_impression_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'aos_contracts_te_impression_1' => 
    array (
      'lhs_module' => 'AOS_Contracts',
      'lhs_table' => 'aos_contracts',
      'lhs_key' => 'id',
      'rhs_module' => 'te_impression',
      'rhs_table' => 'te_impression',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'aos_contracts_te_impression_1_c',
      'join_key_lhs' => 'aos_contracts_te_impression_1aos_contracts_ida',
      'join_key_rhs' => 'aos_contracts_te_impression_1te_impression_idb',
    ),
  ),
  'table' => 'aos_contracts_te_impression_1_c',
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
      'name' => 'aos_contracts_te_impression_1aos_contracts_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'aos_contracts_te_impression_1te_impression_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'aos_contracts_te_impression_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'aos_contracts_te_impression_1_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'aos_contracts_te_impression_1aos_contracts_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'aos_contracts_te_impression_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'aos_contracts_te_impression_1te_impression_idb',
      ),
    ),
  ),
);