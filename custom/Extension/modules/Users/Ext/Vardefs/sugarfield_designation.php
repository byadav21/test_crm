<?php
$dictionary['User']['fields']['designation'] =array (
	'name' => 'designation',
	'vname' => 'LBL_DESIGNATION',
	'required' => true,
	'type' => 'enum',
	'importable' => 'true',
	'len' => 50,
	'size' => '20',
	'options' => 'designation_list',
);

$dictionary['User']['fields']['department'] =array (
        'name' => 'department',
        'vname' => 'LBL_DEPARTMENT',
        'required' => true,
        'type' => 'enum',
        'importable' => 'true',
        'len' => 50,
        'size' => '20',
        'options' => 'department_list',
);
?>
