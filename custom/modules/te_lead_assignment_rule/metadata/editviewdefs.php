<?php
$module_name = 'te_lead_assignment_rule';
$viewdefs [$module_name] = 
array (
  'EditView' => 
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
	  'includes' => 
      array (
        0 => 
        array (
          'file' => 'custom/modules/te_lead_assignment_rule/rules.js',
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
          0 => 'name',
          1 => 
          array (
            'name' => 'rule_status',
            'studio' => 'visible',
            'label' => 'LBL_RULE_STATUS',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'lead_source',			
			'type' => 'multienum',
            'studio' => 'visible',
            'label' => 'LBL_LEAD_SOURCE',
			'displayParams' => array ( 'size' => 3,),
          ),
		   1 => 
          array (
            'name' => 'assign_rule',
            'studio' => 'visible',
            'label' => 'LBL_ASSIGN_RULE',
          ), 
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'batch',
            'studio' => 'visible',
            'label' => 'LBL_BATCH',
          ),
		  1 => 
          array (
            'name' => 'agent',
            'studio' => 'visible',
            'label' => 'LBL_AGENT',
          ),
          
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'method',
            'studio' => 'visible',
            'label' => 'LBL_METHOD',
          ),
		  1 => 
          array (
            'name' => 'security_group',
            'studio' => 'visible',
            'label' => 'LBL_SECURITY_GROUP',
          ),
        ),
		4 => 
        array (
          0 => '',
          1 => '',
        ),
      ),
    ),
  ),
);
?>
