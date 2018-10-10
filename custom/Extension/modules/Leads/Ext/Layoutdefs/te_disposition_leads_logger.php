<?php
 // created: 2018-05-31 22:45:28
$layout_defs["Leads"]["subpanel_setup"]['te_dispositionlogger_leads'] = array (
  //'order' => 100,
  'order' => 1,
  'module' => 'te_disposition',
  'subpanel_name' => 'default',
  'sort_order' => 'Asc',
  'sort_by' => 'date_entered',
  'title_key' => 'Call log',
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
