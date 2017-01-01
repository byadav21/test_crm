<?php
// created: 2016-11-24 20:39:12
$subpanel_layout['list_fields'] = array (
  'year' => 
  array (
    'type' => 'varchar',
    'vname' => 'LBL_YEAR',
    'width' => '10%',
    'default' => true,
  ),
  'week' => 
  array (
    'type' => 'varchar',
    'vname' => 'LBL_WEEK',
    'width' => '10%',
    'default' => true,
  ),
  'te_utm_te_budgeted_campaign_1_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'vname' => 'LBL_TE_UTM_TE_BUDGETED_CAMPAIGN_1_FROM_TE_UTM_TITLE',
    'id' => 'TE_UTM_TE_BUDGETED_CAMPAIGN_1TE_UTM_IDA',
    'width' => '10%',
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'te_utm',
    'target_record_key' => 'te_utm_te_budgeted_campaign_1te_utm_ida',
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
  'cost' => 
  array (
    'type' => 'int',
    'vname' => 'LBL_COST',
    'width' => '10%',
    'default' => true,
  ),
  'conversion' => 
  array (
    'type' => 'int',
    'vname' => 'LBL_CONVERSION',
    'width' => '10%',
    'default' => true,
  ),
  'conversion_rate' => 
  array (
    'type' => 'varchar',
    'vname' => 'LBL_CONVERSION_RATE',
    'width' => '10%',
    'default' => true,
  ),
  'clp' => 
  array (
    'type' => 'varchar',
    'vname' => 'LBL_CLP',
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
    'module' => 'te_budgeted_campaign',
    'width' => '4%',
    'default' => true,
  ),
);