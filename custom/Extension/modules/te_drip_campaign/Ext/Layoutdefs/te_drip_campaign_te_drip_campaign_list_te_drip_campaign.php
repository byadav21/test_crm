<?php
 // created: 2016-11-30 12:13:45
$layout_defs["te_drip_campaign"]["subpanel_setup"]['te_drip_campaign_te_drip_campaign_list'] = array (
  'order' => 100,
  'module' => 'te_drip_campaign_list',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_TE_DRIP_CAMPAIGN_TE_DRIP_CAMPAIGN_LIST_FROM_TE_DRIP_CAMPAIGN_LIST_TITLE',
  'get_subpanel_data' => 'te_drip_campaign_te_drip_campaign_list',
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopButtonQuickCreate',
    ),
    1 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'mode' => 'MultiSelect',
    ),
  ),
);
