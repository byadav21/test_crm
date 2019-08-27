<?php
$dictionary['Lead']['fields']['parrent_leads'] =array (
	'name' => 'parrent_leads',
	'vname' => 'Parrent Lead',
	'type' => 'varchar',
	'len' => '50',
    'size' => '20',
    'studio' => 'visible',
	'required' => false, 
	'reportable' => true, 
	'audited' => false, 
	'importable' => true, 
	'duplicate_merge' => false,
	'inline_edit' => false, 
);

$dictionary['Lead']['fields']['is_predictive'] = array(
    'name'            => 'is_predictive',
    'vname'           => 'Predictive',
    'type'            => 'int',
    'len'             => '2',
    'size'            => '20',
    'default'         =>  0,
    'studio'          => 'visible',
    'required'        => false,
    'reportable'      => true,
    'audited'         => false,
    'importable'      => true,
    'duplicate_merge' => false,
    'inline_edit'     => false,
);
?>
