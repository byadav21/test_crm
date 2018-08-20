<?php
 // created: 2018-08-16 10:56:52
$layout_defs["te_ba_Batch"]["subpanel_setup"]['te_ba_batch_users_1'] = array (
  'order' => 100,
  'module' => 'Users',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_TE_BA_BATCH_USERS_1_FROM_USERS_TITLE',
  'get_subpanel_data' => 'te_ba_batch_users_1',
  'top_buttons' => 
  array (
  /*	
    0 =>
    array (
      'widget_class' => 'SubPanelTopButtonQuickCreate',
    ),
*/
    1 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'mode' => 'MultiSelect',
    ),
  ),
);
