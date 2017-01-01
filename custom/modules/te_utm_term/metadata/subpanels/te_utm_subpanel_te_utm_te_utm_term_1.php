<?php
// created: 2016-09-12 13:45:02
$subpanel_layout['list_fields'] = array (
  'name' => 
  array (
    'vname' => 'LBL_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => '20%',
    'default' => true,
  ),
  'institutes_c' => 
  array (
    'type' => 'relate',
    'default' => true,
    'studio' => 'visible',
    'vname' => 'LBL_INSTITUTES',
    'id' => 'TE_IN_INSTITUTES_ID_C',
    'link' => true,
    'width' => '20%',
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'te_in_institutes',
    'target_record_key' => 'te_in_institutes_id_c',
  ),
  'programs_c' => 
  array (
    'type' => 'relate',
    'default' => true,
    'studio' => 'visible',
    'vname' => 'LBL_PROGRAMS',
    'id' => 'TE_PR_PROGRAMS_ID_C',
    'link' => true,
    'width' => '20%',
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'te_pr_Programs',
    'target_record_key' => 'te_pr_programs_id_c',
  ),
  'date_modified' => 
  array (
    'vname' => 'LBL_DATE_MODIFIED',
    'width' => '45%',
    'default' => true,
  ),
  'edit_button' => 
  array (
    'vname' => 'LBL_EDIT_BUTTON',
    'widget_class' => 'SubPanelEditButton',
    'module' => 'te_utm_term',
    'width' => '4%',
    'default' => true,
  ),
  'remove_button' => 
  array (
    'vname' => 'LBL_REMOVE',
    'widget_class' => 'SubPanelRemoveButton',
    'module' => 'te_utm_term',
    'width' => '5%',
    'default' => true,
  ),
);