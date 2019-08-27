<?php

$dictionary['te_student_payment']['fields']['invoice_number'] =array (
		'name' => 'invoice_number',
		'vname' => 'Invoice Number',
		'type' => 'int',
		'required' => false,
		'massupdate' => 0,
		'comments' => 'Keep your Invoice number',
		'help' => '',
		'default'=> '',
		'importable' => 'false',
		'duplicate_merge' => 'disabled',
		'duplicate_merge_dom_value' => '0',
		'audited' => false,
		'reportable' => false,
		'len' => '50',
		'size' => '50',
		'studio' => 'visible',
	);

$dictionary['te_student_payment']['fields']['invoice_url'] =array (
		'name' => 'invoice_url',
		'vname' => 'Invoice URL',
		'type' => 'varchar',
		'required' => false,
		'comments' => 'Keep your invoiceurl',
		'help' => '',
		'importable' => 'false',
		'duplicate_merge' => 'disabled',
		'duplicate_merge_dom_value' => '0',
		'audited' => false,
		'reportable' => false,
		'len' => '255',
		'size' => '50',
		'studio' => 'visible',
	);
?>
