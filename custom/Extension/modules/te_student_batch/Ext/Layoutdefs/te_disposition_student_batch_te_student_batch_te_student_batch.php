<?php
 // created: 2017-11-28 11:50:50
$layout_defs["te_student_batch"]["subpanel_setup"]['te_disposition_student_batch_te_student_batch'] = array (
  'order' => 100,
  'module' => 'te_Disposition_student_batch',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_TE_DISPOSITION_STUDENT_BATCH_TE_STUDENT_BATCH_FROM_TE_DISPOSITION_STUDENT_BATCH_TITLE',
  'get_subpanel_data' => 'te_disposition_student_batch_te_student_batch',
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
