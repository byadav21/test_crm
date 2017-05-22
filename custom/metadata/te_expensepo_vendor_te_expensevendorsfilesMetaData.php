<?php
// created: 2017-05-18 13:09:48
$dictionary["te_expensepo_vendor_te_expensevendorsfiles"] = array (
  'true_relationship_type' => 'many-to-many',
  'relationships' => 
  array (
    'te_expensepo_vendor_te_expensevendorsfiles' => 
    array (
      'lhs_module' => 'te_Expensepo_Vendor',
      'lhs_table' => 'te_expensepo_vendor',
      'lhs_key' => 'id',
      'rhs_module' => 'te_expenseVendorsFiles',
      'rhs_table' => 'te_expensevendorsfiles',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'te_expensepo_vendor_te_expensevendorsfiles_c',
      'join_key_lhs' => 'te_expense2ebe_vendor_ida',
      'join_key_rhs' => 'te_expense9a8brsfiles_idb',
    ),
  ),
  'table' => 'te_expensepo_vendor_te_expensevendorsfiles_c',
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
      'name' => 'te_expense2ebe_vendor_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'te_expense9a8brsfiles_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'te_expensepo_vendor_te_expensevendorsfilesspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'te_expensepo_vendor_te_expensevendorsfiles_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'te_expense2ebe_vendor_ida',
        1 => 'te_expense9a8brsfiles_idb',
      ),
    ),
  ),
);