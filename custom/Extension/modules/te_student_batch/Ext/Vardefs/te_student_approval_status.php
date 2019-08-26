<?php
$dictionary['te_student_batch']['fields']['bt_fee_waiver'] = array(
	'required' => false,
	'name' => 'bt_fee_waiver',
	'vname' => 'bt_fee_waiver',
	'type' => 'enum',
	'massupdate' => 0,
	  'no_default' => false,
	  'comments' => '',
	  'help' => '',
	  'importable' => 'true',
	  'duplicate_merge' => 'disabled',
	  'duplicate_merge_dom_value' => '0',
	  'audited' => false,
	  'inline_edit' => true,
	  'reportable' => true,
	  'unified_search' => false,
	  'merge_filter' => 'disabled',
	  'len' => 100,
	  'size' => '20',
	  'options' => 'approval_status',
	  'studio' => 'visible',
	  'dependency' => false,
	);

$dictionary['te_student_batch']['fields']['bt_approver_comments'] = array(
	'required' => false,
	'name' => 'bt_approver_comments',
	'vname' => 'bt_approver_comments',
	'type' => 'text',
	'audited' => false,
	'massupdate' => false,	 
	'studio' => 'visible',
);
$dictionary['te_student_batch']['fields']['bt_url'] = array(
	'required' => false,
	'name' => 'bt_url',
	'vname' => 'bt_url',
	'type' => 'text',
	'audited' => false,
	'massupdate' => false,	 
	'studio' => 'visible',
);







