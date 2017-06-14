<?php
$popupMeta = array (
    'moduleMain' => 'te_expense_vendor',
    'varName' => 'te_expense_vendor',
    'orderBy' => 'te_expense_vendor.name',
    'whereClauses' => array (
  'name' => 'te_expense_vendor.name',
  'status' => 'te_expense_vendor.status',
  'assigned_user_id' => 'te_expense_vendor.assigned_user_id',
),
    'searchInputs' => array (
  1 => 'name',
  3 => 'status',
  4 => 'assigned_user_id',
),
    'searchdefs' => array (
  'name' => 
  array (
    'name' => 'name',
    'width' => '10%',
  ),
  'status' => 
  array (
    'label' => 'status',
    'type' => 'int',
    'width' => '10%',
    'name' => 'status',
  ),
  'assigned_user_id' => 
  array (
    'name' => 'assigned_user_id',
    'label' => 'LBL_ASSIGNED_TO',
    'type' => 'enum',
    'function' => 
    array (
      'name' => 'get_user_array',
      'params' => 
      array (
        0 => false,
      ),
    ),
    'width' => '10%',
  ),
),
);
