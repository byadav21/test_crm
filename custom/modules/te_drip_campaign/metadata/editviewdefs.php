<?php
$module_name = 'te_drip_campaign';
$viewdefs [$module_name] = 
array (
  'EditView' => 
  array (
    'templateMeta' => 
    array (
      'maxColumns' => '2',
      'form' => 
      array (
        'footerTpl' => 'custom/modules/te_drip_campaign/tpls/EditViewFooter.tpl',
      ),
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
      'syncDetailEditViews' => true,
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
          ),
		 1 => 
          array (
            'name' => 'batch',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'total_mailers',
          ),
          1 => '',
        ), 
      ),
    ),
  ),
);
?>
