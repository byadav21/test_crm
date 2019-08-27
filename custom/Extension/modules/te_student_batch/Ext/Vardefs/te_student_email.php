<?php
$dictionary['te_student_batch']['fields']['email'] = array(
	'required' => false,
	'name' => 'email',
	'vname' => 'Email',
	'type' => 'varchar',
	'audited' => false,
	'massupdate' => false,
	'source' => 'non-db',
	'studio' => 'visible',
);
$dictionary['te_student_batch']['fields']['is_new'] = array(
	'required' => false,
	'name' => 'is_new',
	'vname' => 'is_new',
	'default'=>'1',
	'type' => 'int',
	'audited' => false,
	'massupdate' => false,
	'source' => 'non-db',
	'studio' => 'visible',
);
$dictionary['te_student_batch']['fields']['is_new_dropout'] = array(
	'required' => false,
	'name' => 'is_new_dropout',
	'vname' => 'is_new_dropout',
	'type' => 'varchar',
	'default'=>'0',
	'audited' => false,
	'massupdate' => false,
	'source' => 'non-db',
	'studio' => 'visible',
);

