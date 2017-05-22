<?php
 // created: 2017-05-18 13:09:48
$layout_defs["te_Expensepo_Vendor"]["subpanel_setup"]['te_expensepo_vendor_te_expensevendorsfiles'] = array (
  'order' => 100,
  'module' => 'te_expenseVendorsFiles',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_TE_EXPENSEPO_VENDOR_TE_EXPENSEVENDORSFILES_FROM_TE_EXPENSEVENDORSFILES_TITLE',
  'get_subpanel_data' => 'te_expensepo_vendor_te_expensevendorsfiles',
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
