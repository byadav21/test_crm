<?php
$module_name = 'te_utm';
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
      'current_user_only' => 
      array (
        'name' => 'current_user_only',
        'label' => 'LBL_CURRENT_USER_FILTER',
        'type' => 'bool',
        'default' => true,
        'width' => '10%',
      ),
      'utm_status' => 
      array (
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_UTM_STATUS',
        'width' => '10%',
        'default' => true,
        'name' => 'utm_status',
      ),
      'contract_type' => 
      array (
        'type' => 'enum',
        'label' => 'UTM Medium',
        'width' => '10%',
        'default' => true,
        'name' => 'contract_type',
      ),
      'te_vendor_te_utm_1_name' => 
      array (
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_TE_VENDOR_TE_UTM_1_FROM_TE_VENDOR_TITLE',
        'id' => 'TE_VENDOR_TE_UTM_1TE_VENDOR_IDA',
        'width' => '10%',
        'default' => true,
        'name' => 'te_vendor_te_utm_1_name',
      ),
      'batch' => 
      array (
        'type' => 'relate',
        'studio' => 'visible',
        'label' => 'LBL_BATCH',
        'id' => 'TE_BA_BATCH_ID_C',
        'link' => true,
        'width' => '10%',
        'default' => true,
        'name' => 'batch',
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
