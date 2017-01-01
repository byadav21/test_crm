<?php
// created: 2016-11-09 01:39:32
$subpanel_layout['list_fields'] = array (
  'document_name' => 
  array (
    'type' => 'varchar',
    'vname' => 'LBL_NAME',
    'width' => '10%',
    'default' => true,
  ),
  'filename' => 
  array (
    'width' => '20%',
    'sortable' => false,
    'vname' => 'LBL_LIST_FILENAME',
    'default' => true,
  ),
  'active_date' => 
  array (
    'name' => 'active_date',
    'vname' => 'LBL_LIST_ACTIVE_DATE',
    'width' => '10%',
    'default' => true,
  ),
  'edit_button' => 
  array (
    'vname' => 'LBL_EDIT_BUTTON',
    'widget_class' => 'SubPanelEditButton',
    'module' => 'Documents',
    'width' => '5%',
    'default' => true,
  ),
  'remove_button' => 
  array (
    'vname' => 'LBL_REMOVE',
    'widget_class' => 'SubPanelRemoveButton',
    'module' => 'Documents',
    'width' => '5%',
    'default' => true,
  ),
  'document_revision_id' => 
  array (
    'name' => 'document_revision_id',
    'usage' => 'query_only',
  ),
);