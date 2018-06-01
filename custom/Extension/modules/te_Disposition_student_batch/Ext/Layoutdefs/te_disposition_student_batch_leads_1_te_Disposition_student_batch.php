<?php
 // created: 2018-05-30 21:49:09
$layout_defs["te_Disposition_student_batch"]["subpanel_setup"]['te_disposition_student_batch_leads_1'] = array (
  'order' => 100,
  'module' => 'Leads',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_TE_DISPOSITION_STUDENT_BATCH_LEADS_1_FROM_LEADS_TITLE',
  'get_subpanel_data' => 'te_disposition_student_batch_leads_1',
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
