<?php
// created: 2018-05-19 11:38:47
$subpanel_layout['list_fields'] = array (
  'status' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'vname' => 'LBL_STATUS',
    'width' => '10%',
    'default' => true,
  ),
  'status_detail' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'vname' => 'LBL_STATUS_DETAIL',
    'width' => '10%',
    'default' => true,
  ),
  'description' => 
  array (
    'type' => 'text',
    'vname' => 'Note',
    'sortable' => false,
    'width' => '30%',
    'default' => true,
  ),
  'date_of_callback' => 
  array (
    'type' => 'date',
    'vname' => 'LBL_DATE',
    'width' => '10%',
    'default' => true,
  ),
  'date_entered' => 
  array (
    'type' => 'datetime',
    'vname' => 'LBL_DATE_ENTERED',
    'width' => '10%',
    'orderBy' => 'date_entered',
    'default' => true,
  ),
  'created_by_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'vname' => 'LBL_CREATED',
    'id' => 'CREATED_BY',
    'width' => '10%',
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'Users',
    'target_record_key' => 'created_by',
  ),
);