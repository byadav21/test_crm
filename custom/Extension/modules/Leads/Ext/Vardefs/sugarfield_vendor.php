<?php
$dictionary['Lead']['fields']['vendor'] =array (
	'name' => 'vendor',
	'label' => 'LBL_VENDOR',
	'type' => 'varchar',
	'module' => 'Leads',
	'help' => '',
	'comment' => '',
	'default_value' => '',
	'len' => '50',
    'size' => '20',
	'required' => false, 
	'reportable' => true, 
	'audited' => false, 
	'importable' => 'true', 
	'duplicate_merge' => false, 
);


$dictionary['Lead']['fields']['utm_term_c'] =array (
        'name' => 'utm_term_c',
        'label' => 'UTM Terms (Batch)',
        'type' => 'varchar',
        'module' => 'Leads',
        'help' => '',
        'comment' => '',
        'default_value' => '',
        'len' => '255',
		'size' => '20',
        'required' => false,
        'reportable' => true,
        'audited' => false,
        'importable' => 'true',
        'duplicate_merge' => false,
);
$dictionary['Lead']['fields']['utm_source_c'] =array (
        'name' => 'utm_source_c',
        'label' => 'UTM Source (vendor)',
        'type' => 'varchar',
        'module' => 'Leads',
        'help' => '',
        'comment' => '',
        'default_value' => '',
        'len' => '255',
		'size' => '20',
        'required' => false,
        'reportable' => true,
        'audited' => false,
        'importable' => 'true',
        'duplicate_merge' => false,
);
$dictionary['Lead']['fields']['utm_contract_c'] =array (
        'name' => 'utm_contract_c',
        'label' => 'UTM Mediums',
        'type' => 'varchar',
        'module' => 'Leads',
        'help' => '',
        'comment' => '',
        'default_value' => '',
        'len' => '255',
		'size' => '20',
        'required' => false,
        'reportable' => true,
        'audited' => false,
        'importable' => 'true',
        'duplicate_merge' => false,
);

$dictionary['Lead']['fields']['lead_source'] =array(
        'name' => 'lead_source',  
         'vname' => 'LBL_LEAD_SOURCE',
        'type' => 'dynamicenum', 
         'dbType' => 'enum',
           'options' => 'lead_source_custom_dom',
        'parentenum' => 'lead_source_types',       
        'len' => '255',       
);

$dictionary['Lead']['fields']['lead_source_types'] =array(
	'name' => 'lead_source_types',
	'label' => 'Lead Source Type',
	'type' => 'enum',	
	'len' => '150',
        'size' => '20',
	'required' => false ,
	'options'=>'lead_source_custom_dom_type'
);


 ?>
