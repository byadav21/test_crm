<?php
$dictionary['te_pr_Programs']['fields']['web_id'] =array (
		'name' => 'web_id',
		'vname' => 'Web id',
		'type' => 'varchar',
		'required' => false,
		'comments' => 'web id',
		'help' => '',
		'importable' => 'false',
		'duplicate_merge' => 'disabled',
		'duplicate_merge_dom_value' => '0',
		'audited' => false,
		'reportable' => false,
		'len' => '50',
		'size' => '50',
	);

$dictionary['te_pr_Programs']['fields']['SAP_Status'] =array (
               'name' => 'SAP_Status',
               'vname' => 'SAP Status',
               'type' => 'int',
               'required' => false,
               'comments' => 'to check whether Programs is downloaded to SAP',
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
