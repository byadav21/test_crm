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



 ?>
