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
        'label' => 'LBL_BATCH',
		'id' => 'LBL_BATCH_TE_BA_BATCH_ID',
        'width' => '10%',
        'default' => true,
        'name' => 'batch',
      ),
	  'plan_date' => 
      array (
        'type' => 'date',
        'label' => 'LBL_PLAN_DATE',
        'width' => '10%',
        'default' => true,
        'name' => 'plan_date',
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
