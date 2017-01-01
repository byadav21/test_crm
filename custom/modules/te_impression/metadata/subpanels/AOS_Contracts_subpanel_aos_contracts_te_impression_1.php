<?php
// created: 2016-11-08 05:52:22
$subpanel_layout['list_fields'] = array (
  'name' => 
  array (
    'vname' => 'LBL_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => '10%',
    'default' => true,
  ),
  'impression_date' => 
  array (
    'type' => 'date',
    'vname' => 'LBL_IMPRESSION_DATE',
    'width' => '10%',
    'default' => true,
  ),
  'actual_type' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'vname' => 'Type',
    'width' => '10%',
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