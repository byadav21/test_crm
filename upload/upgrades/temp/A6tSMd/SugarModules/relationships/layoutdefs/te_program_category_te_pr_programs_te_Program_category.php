<?php
 // created: 2016-09-30 00:03:54
$layout_defs["te_Program_category"]["subpanel_setup"]['te_program_category_te_pr_programs'] = array (
  'order' => 100,
  'module' => 'te_pr_Programs',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_TE_PROGRAM_CATEGORY_TE_PR_PROGRAMS_FROM_TE_PR_PROGRAMS_TITLE',
  'get_subpanel_data' => 'te_program_category_te_pr_programs',
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
