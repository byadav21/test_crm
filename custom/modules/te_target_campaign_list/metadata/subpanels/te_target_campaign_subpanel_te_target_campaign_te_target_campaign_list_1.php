<?php
// created: 2016-12-23 11:32:58
$subpanel_layout['list_fields'] = array (
  'name' => 
  array (
    'vname' => 'LBL_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => '20%',
    'default' => true,
  ),
  'email' => 
  array (
    'type' => 'varchar',
    'vname' => 'LBL_EMAIL',
    'width' => '10%',
    'default' => true,
  ),
  'status' => 
  array (
    'type' => 'varchar',
    'vname' => 'LBL_STATUS',
    'width' => '10%',
    'default' => true,
  ),
  'sent_date' => 
  array (
    'type' => 'datetimecombo',
    'vname' => 'LBL_SENT_DATE',
    'width' => '10%',
    'default' => true,
  ),
  'remove_button' => 
  array (
    'vname' => 'LBL_REMOVE',
    'widget_class' => 'SubPanelRemoveButton',
    'module' => 'te_target_campaign_list',
    'width' => '5%',
    'default' => true,
  ),
  'edit_button' => 
  array (
    'vname' => 'LBL_EDIT_BUTTON',
    'widget_class' => 'SubPanelEditButton',
    'module' => 'te_target_campaign_list',
    'width' => '4%',
    'default' => true,
  ),
);