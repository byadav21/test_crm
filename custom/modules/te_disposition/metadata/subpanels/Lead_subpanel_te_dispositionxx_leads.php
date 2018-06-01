<?php
// created: 2018-05-31 16:31:37
$subpanel_layout['list_fields'] = array (
  'date_entered' => 
  array (
    'type' => 'datetime',
    'vname' => 'LBL_DATE_ENTERED',
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
  'dispositionname' => 
  array (
    'type' => 'varchar',
    'vname' => 'LBL_Disposition_Name',
    'width' => '10%',
    'default' => true,
  ),
  'assigned_user_name' => 
  array (
    'link' => true,
    'type' => 'relate',
    'vname' => 'LBL_ASSIGNED_TO_NAME',
    'id' => 'ASSIGNED_USER_ID',
    'width' => '10%',
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'Users',
    'target_record_key' => 'assigned_user_id',
  ),
  'date_of_callback' => 
  array (
    'type' => 'datetimecombo',
    'vname' => 'LBL_DATEOFCALLBACK',
    'width' => '10%',
    'default' => true,
  ),
  'date_of_followup' => 
  array (
    'type' => 'datetimecombo',
    'vname' => 'LBL_DATEOFFOLLOWUP',
    'width' => '10%',
    'default' => true,
  ),
  'date_of_prospect' => 
  array (
    'type' => 'datetimecombo',
    'vname' => 'LBL_DATEOFPROSPECT',
    'width' => '10%',
    'default' => true,
  ),
  'calltype' => 
  array (
    'type' => 'varchar',
    'vname' => 'LBL_Call_Type',
    'width' => '10%',
    'default' => true,
  ),
  'attempt_count' => 
  array (
    'type' => 'varchar',
    'vname' => 'LBL_Attempt_Count',
    'width' => '10%',
    'default' => true,
  ),
);