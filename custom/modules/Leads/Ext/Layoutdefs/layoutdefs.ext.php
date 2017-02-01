<?php 
 //WARNING: The contents of this file are auto-generated



unset($layout_defs["Leads"]["subpanel_setup"]['activities']);
unset($layout_defs["Leads"]["subpanel_setup"]['history']);
unset($layout_defs["Leads"]["subpanel_setup"]['campaigns']);
unset($layout_defs["Leads"]["subpanel_setup"]['fp_events']);
unset($layout_defs["Leads"]["subpanel_setup"]['SecurityGroups']);




 // created: 2016-11-03 00:13:18
$layout_defs["Leads"]["subpanel_setup"]['leads_te_payment_details_1'] = array (
  'order' => 100,
  'module' => 'te_payment_details',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_LEADS_TE_PAYMENT_DETAILS_1_FROM_TE_PAYMENT_DETAILS_TITLE',
  'get_subpanel_data' => 'leads_te_payment_details_1',
  'top_buttons' => 
  array (
    /*0 => 
    array (
      'widget_class' => 'SubPanelTopButtonQuickCreate',
    ),
	
    1 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'mode' => 'MultiSelect',
    ),
	*/
  ),
);


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
    0 => 
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


//auto-generated file DO NOT EDIT
$layout_defs['Leads']['subpanel_setup']['te_disposition_leads']['override_subpanel_name'] = 'Lead_subpanel_te_disposition_leads';


//auto-generated file DO NOT EDIT
$layout_defs['Leads']['subpanel_setup']['securitygroups']['override_subpanel_name'] = 'Lead_subpanel_securitygroups';


//auto-generated file DO NOT EDIT
$layout_defs['Leads']['subpanel_setup']['leads_te_payment_details_1']['override_subpanel_name'] = 'Lead_subpanel_leads_te_payment_details_1';


//auto-generated file DO NOT EDIT
$layout_defs['Leads']['subpanel_setup']['leads_leads_1leads_ida']['override_subpanel_name'] = 'Lead_subpanel_leads_leads_1leads_ida';

?>