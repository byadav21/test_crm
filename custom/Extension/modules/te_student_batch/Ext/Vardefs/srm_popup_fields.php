<?php
$dictionary['te_student_batch']['fields']['bt_srm_attachment'] =array(
                'name' => 'bt_srm_attachment',
                'vname' => 'bt_srm_attachment',
                 'type' => 'varchar',
                'len' => '255',
		'size' => '20',
                'comments' => 'SRM attachment will be sent in email for approval',
                'module' => 'te_student_batch',
                'required' => false,
                'reportable' => true,
                'audited' => false,
                'importable' => 'true',
                'duplicate_merge' => false,
            );


/*$dictionary['te_student_batch']['fields']['bt_fee_waiver'] =array(
                'name' => 'bt_fee_waiver',
                'vname' => 'bt_fee_waiver',
                 'type' => 'varchar',
                'len' => '20',
                'default'=> '0',
		'size' => '20',
                'comments' => '',
                'module' => '1. waiver, 2. to_be_deducted, 3. to be paid',
                'required' => false,
                'reportable' => true,
                'audited' => false,
                'importable' => 'true',
                'duplicate_merge' => false,
            );*/


$dictionary['te_student_batch']['fields']['bt_srm_comments'] =array (
		'name' => 'bt_srm_comments',
		'label' => 'bt_srm_comments',
		'type' => 'text',
		'required' => false,
		'massupdate' => 0,
		'comments' => 'SRM comments will be sent in email for approval',
		'help' => '',
		'default'=>'',
		'importable' => 'true',
		'duplicate_merge' => 'disabled',
		'duplicate_merge_dom_value' => '0',
		'audited' => false,
		'reportable' => true
	
	);

$dictionary['te_student_batch']['fields']['bt_approver_comments'] =array (
		'name' => 'bt_approver_comments',
		'label' => 'bt_approver_comments',
		'type' => 'text',
		'required' => false,
		'massupdate' => 0,
		'comments' => 'SRM approver comments will be shown to SRM',
		'help' => '',
		'default'=>'',
		'importable' => 'true',
		'duplicate_merge' => 'disabled',
		'duplicate_merge_dom_value' => '0',
		'audited' => false,
		'reportable' => true
	
	);


$dictionary['te_student_batch']['fields']['bt_pre_dropped'] =array (
		'name' => 'bt_pre_dropped',
		'vname' => 'BT Pre Dropped',
		'type' => 'int',
		'required' => false,
		'comments' => 'bt_pre_dropped',
		'help' => '',
		'default'=> 0,
		'importable' => 'false',
		'duplicate_merge' => 'disabled',
		'duplicate_merge_dom_value' => '0',
		'audited' => false,
		'reportable' => false,
		'len' => '10',
		'size' => '10',
	);

