<?php
 // created: 2016-09-19 13:25:40
$layout_defs["Leads"]["subpanel_setup"]['leads_leads_1leads_ida'] = array (
  'order' => 100,
  'module' => 'Leads',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_LEADS_LEADS_1_FROM_LEADS_R_TITLE',
  'get_subpanel_data' => 'leads_leads_1leads_ida',
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
