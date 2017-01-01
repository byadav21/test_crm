<?php
$module_name = 'te_utm';
$viewdefs [$module_name] = 
array (
  'QuickCreate' => 
  array (
    'templateMeta' => 
    array (
      'maxColumns' => '2',
      'widths' => 
      array (
        0 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
        1 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
      ),
      'useTabs' => false,
      'tabDefs' => 
      array (
        'DEFAULT' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
    ),
    'panels' => 
    array (
      'default' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'name',
			'studio' => 'visible',
            'label' => 'LBL_UTM_NAME',
          ),
          1 => array (
            'name' => 'batch',
            'studio' => 'visible',
            'label' => 'LBL_BATCH',
          ),
        ),
		1 => 
        array (
          0 => 
          array (
            'name' => 'utm_campaign',
			'studio' => 'visible',
            'label' => 'LBL_UTM_CAMPAIGN',
          ),
          1 => array (
             'name' => 'utm_status',
            'studio' => 'visible',
            'label' => 'LBL_UTM_STATUS',
          ),
        ),
		2 => 
        array (
          0 => 
          array (
            'name' => 'contract',
            'studio' => 'visible',
            'label' => 'LBL_CONTRACT',
          ),
          1 => array (
             'name' => 'description',
            'label' => 'Notes',
			'displayParams' => 
            array (
              'cols' => 32,
              'rows' => 3,
            ),
          ),
        ),
		
      ),
    ),
  ),
);
?>
