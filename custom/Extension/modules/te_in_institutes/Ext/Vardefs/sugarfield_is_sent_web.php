<?php
$dictionary['te_in_institutes']['fields']['is_sent_web'] =array (
		'name' => 'is_sent_web',
		'vname' => 'Is sent web',
		'type' => 'int',
		'required' => false,
		'comments' => 'web api leads update or insert',
		'help' => '',
		'default'=> 0,
		'importable' => 'false',
		'duplicate_merge' => 'disabled',
		'duplicate_merge_dom_value' => '0',
		'audited' => false,
		'reportable' => false,
		'len' => '50',
		'size' => '50',
	);

$dictionary['te_in_institutes']['fields']['SAP_Status'] =array (
               'name' => 'SAP_Status',
               'vname' => 'SAP Status',
               'type' => 'int',
               'required' => false,
               'comments' => 'to check whether institute is downloaded to SAP',
               'help' => '',
               'default'=> 0,
               'importable' => 'false',
               'duplicate_merge' => 'disabled',
               'duplicate_merge_dom_value' => '0',
               'audited' => false,
               'reportable' => false,
               'len' => '50',
               'size' => '50',
       );

?>
