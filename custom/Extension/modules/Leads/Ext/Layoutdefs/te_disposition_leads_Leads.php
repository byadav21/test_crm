<?php
 // created: 2016-11-07 22:45:28
$layout_defs["Leads"]["subpanel_setup"]['te_disposition_leads'] = array (
  //'order' => 100,
  'order' => 1,
  'module' => 'te_disposition',
  'subpanel_name' => 'default',
  'sort_order' => 'desc',
  'sort_by' => 'date_entered',
  'title_key' => 'LBL_TE_DISPOSITION_LEADS_FROM_TE_DISPOSITION_TITLE',
  'get_subpanel_data' => 'te_disposition_leads',
  'top_buttons' => 
  array (
   /* 0 => 
    array (
      'widget_class' => 'SubPanelTopButtonQuickCreate',
    ),
	/*
    1 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'mode' => 'MultiSelect',
    ),
	*/
  ),
);
