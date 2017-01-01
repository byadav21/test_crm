<?php
$module_name = 'AOS_Contracts';
$searchdefs [$module_name] = 
array (
  'layout' => 
  array (
    'basic_search' => 
    array (
      0 => 'name',
      1 => 
      array (
        'name' => 'current_user_only',
        'label' => 'LBL_CURRENT_USER_FILTER',
        'type' => 'bool',
      ),
      2 => 
      array (
        'name' => 'favorites_only',
        'label' => 'LBL_FAVORITES_FILTER',
        'type' => 'bool',
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
      'contract_account' => 
      array (
        'name' => 'contract_account',
        'default' => true,
        'width' => '10%',
      ),
      'opportunity' => 
      array (
        'name' => 'opportunity',
        'default' => true,
        'width' => '10%',
      ),
      'start_date' => 
      array (
        'name' => 'start_date',
        'default' => true,
        'width' => '10%',
      ),
	  'contract_type' => 
      array (
        'name' => 'contract_type',
        'default' => true,
        'width' => '10%',
      ),
      
    /*   'total_contract_value' => 
      array (
        'name' => 'total_contract_value',
        'default' => true,
        'width' => '10%',
      ),*/
      'status' => 
      array (
        'name' => 'status',
        'default' => true,
        'width' => '10%',
      ),
      'end_date' => 
      array (
        'name' => 'end_date',
        'default' => true,
        'width' => '10%',
      ),
	  
      'assigned_user_id' => 
      array (
        'name' => 'assigned_user_id',
        'label' => 'LBL_ASSIGNED_TO_NAME',
        'type' => 'enum',
        'function' => 
        array (
          'name' => 'get_user_array',
          'params' => 
          array (
            0 => false,
          ),
        ),
        'default' => true,
        'width' => '10%',
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
