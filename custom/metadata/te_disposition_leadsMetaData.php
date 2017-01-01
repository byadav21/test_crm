<?php
// created: 2016-11-07 22:45:22
$dictionary["te_disposition_leads"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'te_disposition_leads' => 
    array (
      'lhs_module' => 'Leads',
      'lhs_table' => 'leads',
      'lhs_key' => 'id',
      'rhs_module' => 'te_disposition',
      'rhs_table' => 'te_disposition',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'te_disposition_leads_c',
      'join_key_lhs' => 'te_disposition_leadsleads_ida',
      'join_key_rhs' => 'te_disposition_leadste_disposition_idb',
    ),
  ),
  'table' => 'te_disposition_leads_c',
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
      'name' => 'te_disposition_leadsleads_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'te_disposition_leadste_disposition_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'te_disposition_leadsspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'te_disposition_leads_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'te_disposition_leadsleads_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'te_disposition_leads_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'te_disposition_leadste_disposition_idb',
      ),
    ),
  ),
);