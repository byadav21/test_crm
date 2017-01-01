<?php
// created: 2016-11-24 20:23:16
$subpanel_layout['list_fields'] = array (
  'plan_date' => 
  array (
    'type' => 'date',
    'vname' => 'LBL_PLAN_DATE',
    'width' => '10%',
    'default' => true,
  ),
  'te_utm_te_actual_campaign_1_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'vname' => 'LBL_TE_UTM_TE_ACTUAL_CAMPAIGN_1_FROM_TE_UTM_TITLE',
    'id' => 'TE_UTM_TE_ACTUAL_CAMPAIGN_1TE_UTM_IDA',
    'width' => '10%',
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'te_utm',
    'target_record_key' => 'te_utm_te_actual_campaign_1te_utm_ida',
  ),
  'type' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'vname' => 'LBL_TYPE',
    'width' => '10%',
    'default' => true,
  ),
  'volume' => 
  array (
    'type' => 'int',
    'vname' => 'LBL_VOLUME',
    'width' => '10%',
    'default' => true,
  ),
  'leads' => 
  array (
    'type' => 'int',
    'vname' => 'LBL_LEADS',
    'width' => '10%',
    'default' => true,
  ),
  'rate' => 
  array (
    'type' => 'int',
    'vname' => 'LBL_RATE',
    'width' => '10%',
    'default' => true,
  ),
  'total_cost' => 
  array (
    'type' => 'int',
    'vname' => 'LBL_TOTAL_COST',
    'width' => '10%',
    'default' => true,
  ),
  'cpl' => 
  array (
    'type' => 'varchar',
    'vname' => 'LBL_CPL',
    'width' => '10%',
    'default' => true,
  ),
  'cpa' => 
  array (
    'type' => 'varchar',
    'vname' => 'LBL_CPA',
    'width' => '10%',
    'default' => true,
  ),
  'edit_button' => 
  array (
    'vname' => 'LBL_EDIT_BUTTON',
    'widget_class' => 'SubPanelEditButton',
    'module' => 'te_actual_campaign',
    'width' => '4%',
    'default' => true,
  ),
);