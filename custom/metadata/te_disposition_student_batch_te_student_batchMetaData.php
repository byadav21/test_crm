<?php
// created: 2017-11-28 11:50:50
$dictionary["te_disposition_student_batch_te_student_batch"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'te_disposition_student_batch_te_student_batch' => 
    array (
      'lhs_module' => 'te_student_batch',
      'lhs_table' => 'te_student_batch',
      'lhs_key' => 'id',
      'rhs_module' => 'te_Disposition_student_batch',
      'rhs_table' => 'te_disposition_student_batch',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'te_disposition_student_batch_te_student_batch_c',
      'join_key_lhs' => 'te_disposi5321t_batch_ida',
      'join_key_rhs' => 'te_disposi55f9t_batch_idb',
    ),
  ),
  'table' => 'te_disposition_student_batch_te_student_batch_c',
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
      'name' => 'te_disposi5321t_batch_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'te_disposi55f9t_batch_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'te_disposition_student_batch_te_student_batchspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'te_disposition_student_batch_te_student_batch_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'te_disposi5321t_batch_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'te_disposition_student_batch_te_student_batch_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'te_disposi55f9t_batch_idb',
      ),
    ),
  ),
);