<?php
$dictionary['te_payment_details']['fields']['invoice_number'] =array (
		'name' => 'invoice_number',
		'vname' => 'Invoice Number',
		'type' => 'varchar',
		'required' => false,
		'massupdate' => 0,
		'comments' => 'Keep your Invoice number',
		'help' => '',
		'default'=>'',
		'importable' => 'false',
		'duplicate_merge' => 'disabled',
		'duplicate_merge_dom_value' => '0',
		'audited' => false,
		'reportable' => false,
		'studio' => 'visible',
		'len' => '150',
		'size' => '50',
	);
$dictionary['te_payment_details']['fields']['invoice_url'] =array (
		'name' => 'invoice_url',
		'vname' => 'Invoice URL',
		'type' => 'text',
		'required' => false,
		'comments' => 'Keep your invoiceurl',
		'help' => '',
		'importable' => 'false',
		'duplicate_merge' => 'disabled',
		'duplicate_merge_dom_value' => '0',
		'audited' => false,
		'reportable' => false,
		'studio' => 'visible',
		'size' => '50',
	);


// added new fields for capturing urls and all  Date: 22 Nov 2017 by Pawan

$dictionary['te_payment_details']['fields']['tax_type'] =array (
		'name' => 'tax_type',
		'vname' => 'Tax Type',
		'type' => 'varchar',
		'required' => false,
		'comments' => 'IGST, SGST or CGST',
		'help' => '',
		'importable' => 'false',
		'duplicate_merge' => 'disabled',
		'duplicate_merge_dom_value' => '0',
		'audited' => false,
		'reportable' => false,
		'studio' => 'visible',
		'len' => '100',
		'size' => '50',
	);

$dictionary['te_payment_details']['fields']['tax'] =array (
		'name' => 'tax',
		'vname' => 'Tax',
		'type' => 'varchar',
		'required' => false,
		'comments' => 'Tax percentage',
		'help' => '',
		'importable' => 'false',
		'duplicate_merge' => 'disabled',
		'duplicate_merge_dom_value' => '0',
		'audited' => false,
		'reportable' => false,
		'studio' => 'visible',
		'len' => '100',
		'size' => '50',
	);


$dictionary['te_payment_details']['fields']['payment_type'] =array (
		'name' => 'payment_type',
		'vname' => 'Payment Type',
		'type' => 'varchar',
		'required' => false,
		'comments' => 'payment_type as Installment or Full',
		'help' => '',
		'importable' => 'false',
		'duplicate_merge' => 'disabled',
		'duplicate_merge_dom_value' => '0',
		'audited' => false,
		'reportable' => false,
		'studio' => 'visible',
		'len' => '100',
		'size' => '50',
	);


$dictionary['te_payment_details']['fields']['receipt_url'] =array (
		'name' => 'receipt_url',
		'vname' => 'Receipt Url',
		'type' => 'text',
		'required' => false,
		'comments' => 'Receipt Url',
		'help' => '',
		'importable' => 'false',
		'duplicate_merge' => 'disabled',
		'duplicate_merge_dom_value' => '0',
		'audited' => false,
		'reportable' => false,
		'studio' => 'visible',
		'len' => '255',
		'size' => '50',
	);

?>
