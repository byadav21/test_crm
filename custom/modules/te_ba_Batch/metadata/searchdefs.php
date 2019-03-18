<?php
$module_name = 'te_ba_Batch';
$searchdefs [$module_name] = 
array (
  'layout' => 
  array (
    'basic_search' => 
    array (
      'name' => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'batch_code' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_BATCH_CODE',
        'width' => '10%',
        'default' => true,
        'name' => 'batch_code',
      ),
      'current_user_only' => 
      array (
        'name' => 'current_user_only',
        'label' => 'LBL_CURRENT_USER_FILTER',
        'type' => 'bool',
        'default' => true,
        'width' => '10%',
      ),
    ),
    'advanced_search' => 
    array (
      'name' => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'te_in_institutes_te_ba_batch_1_name' => 
      array (
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_TE_IN_INSTITUTES_TE_BA_BATCH_1_FROM_TE_IN_INSTITUTES_TITLE',
        'id' => 'TE_IN_INSTITUTES_TE_BA_BATCH_1TE_IN_INSTITUTES_IDA',
        'width' => '10%',
        'default' => true,
        'name' => 'te_in_institutes_te_ba_batch_1_name',
      ),
    ),
  ),
  'templateMeta' => 
  array (
    'maxColumns' => '3',
    'maxColumnsBasic' => '4',
    'widths' => 
    array (
      'label' => '10',
      'field' => '30',
    ),
  ),
);
?>
