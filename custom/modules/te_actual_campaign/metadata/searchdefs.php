<?php
$module_name = 'te_actual_campaign';
$searchdefs [$module_name] = 
array (
  'layout' => 
  array (
    'basic_search' => 
    array (
      'batch' => 
      array (
        'type' => 'relate',
        'studio' => 'visible',
        'label' => 'LBL_BATCH',
        'width' => '10%',
        'default' => true,
        'id' => 'TE_BA_BATCH_ID_C',
        'link' => true,
        'name' => 'batch',
      ),
      'te_utm_te_actual_campaign_1_name' => 
      array (
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_TE_UTM_TE_ACTUAL_CAMPAIGN_1_FROM_TE_UTM_TITLE',
        'id' => 'TE_UTM_TE_ACTUAL_CAMPAIGN_1TE_UTM_IDA',
        'width' => '10%',
        'default' => true,
        'name' => 'te_utm_te_actual_campaign_1_name',
      ),
      'leads' => 
      array (
        'type' => 'int',
        'label' => 'LBL_LEADS',
        'width' => '10%',
        'default' => true,
        'name' => 'leads',
      ),
      'created_by' => 
      array (
        'type' => 'assigned_user_name',
        'label' => 'LBL_CREATED',
        'width' => '10%',
        'default' => true,
        'name' => 'created_by',
      ),
    ),
    'advanced_search' => 
    array (
      0 => 'name',
      1 => 
      array (
        'name' => 'assigned_user_id',
        'label' => 'LBL_ASSIGNED_TO',
        'type' => 'enum',
        'function' => 
        array (
          'name' => 'get_user_array',
          'params' => 
          array (
            0 => false,
          ),
        ),
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
