<?php 
 //WARNING: The contents of this file are auto-generated


// created: 2016-12-27 19:40:57
$dictionary["te_student_batch"]["fields"]["te_student_batch_te_student_payment_plan_1"] = array (
  'name' => 'te_student_batch_te_student_payment_plan_1',
  'type' => 'link',
  'relationship' => 'te_student_batch_te_student_payment_plan_1',
  'source' => 'non-db',
  'module' => 'te_student_payment_plan',
  'bean_name' => 'te_student_payment_plan',
  'side' => 'right',
  'vname' => 'LBL_TE_STUDENT_BATCH_TE_STUDENT_PAYMENT_PLAN_1_FROM_TE_STUDENT_PAYMENT_PLAN_TITLE',
);


// created: 2016-12-26 17:03:11
$dictionary["te_student_batch"]["fields"]["te_student_te_student_batch_1"] = array (
  'name' => 'te_student_te_student_batch_1',
  'type' => 'link',
  'relationship' => 'te_student_te_student_batch_1',
  'source' => 'non-db',
  'module' => 'te_student',
  'bean_name' => 'te_student',
  'vname' => 'LBL_TE_STUDENT_TE_STUDENT_BATCH_1_FROM_TE_STUDENT_TITLE',
  'id_name' => 'te_student_te_student_batch_1te_student_ida',
);
$dictionary["te_student_batch"]["fields"]["te_student_te_student_batch_1_name"] = array (
  'name' => 'te_student_te_student_batch_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_TE_STUDENT_TE_STUDENT_BATCH_1_FROM_TE_STUDENT_TITLE',
  'save' => true,
  'id_name' => 'te_student_te_student_batch_1te_student_ida',
  'link' => 'te_student_te_student_batch_1',
  'table' => 'te_student',
  'module' => 'te_student',
  'rname' => 'name',
);
$dictionary["te_student_batch"]["fields"]["te_student_te_student_batch_1te_student_ida"] = array (
  'name' => 'te_student_te_student_batch_1te_student_ida',
  'type' => 'link',
  'relationship' => 'te_student_te_student_batch_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_TE_STUDENT_TE_STUDENT_BATCH_1_FROM_TE_STUDENT_BATCH_TITLE',
);

  
$dictionary["te_student_batch"]["fields"]["kit_status"] = array (
	  'required' => false,
      'name' => 'kit_status',
      'vname' => 'Kit Status',
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
      'options' => 'study_kit_status_list',
      'studio' => 'visible',
      'dependency' => false,
    );
   
   $dictionary["te_student_batch"]["fields"]["address_confirmed"] = array (
      'required' => false,
      'name' => 'address_confirmed',
      'vname' => 'Address Confiremed',
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
      'options' => 'checkbox_dom',
      'studio' => 'visible',
      'dependency' => false,
    );
     $dictionary["te_student_batch"]["fields"]["study_kit_address"] = array ( 
      'required' => false,
      'name' => 'study_kit_address',
      'vname' => 'Study Kit Address',
      'type' => 'varchar',
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
      'studio' => 'visible',
      'len' => '255',
      'size' => '20',
    );
     $dictionary["te_student_batch"]["fields"]["study_kit_address_country"] = array ( 
      'required' => false,
      'name' => 'study_kit_address_country',
      'vname' => 'Study Kit Address Country',
      'type' => 'varchar',
      'massupdate' => 0,
      'no_default' => false,
      'comments' => '',
      'help' => '',
      'importable' => 'true',
      'duplicate_merge' => 'disabled',
      'duplicate_merge_dom_value' => 0,
      'audited' => false,
      'inline_edit' => true,
      'reportable' => true,
      'unified_search' => false,
      'merge_filter' => 'disabled',
      'studio' => 'visible',
      'len' => 100,
      'size' => '20',
    );
     $dictionary["te_student_batch"]["fields"]["study_kit_address_state"] = array ( 
      'required' => false,
      'name' => 'study_kit_address_state',
      'vname' => 'Study Kit Address State',
      'type' => 'varchar',
      'massupdate' => 0,
      'no_default' => false,
      'comments' => '',
      'help' => '',
      'importable' => 'true',
      'duplicate_merge' => 'disabled',
      'duplicate_merge_dom_value' => 0,
      'audited' => false,
      'inline_edit' => true,
      'reportable' => true,
      'unified_search' => false,
      'merge_filter' => 'disabled',
      'studio' => 'visible',
      'len' => 100,
      'size' => '20',
    );
    $dictionary["te_student_batch"]["fields"]["study_kit_address_postalcode"] = array ( 
      'required' => false,
      'name' => 'study_kit_address_postalcode',
      'vname' => 'Study Kit Address Postalcode',
      'type' => 'varchar',
      'massupdate' => 0,
      'no_default' => false,
      'comments' => '',
      'help' => '',
      'importable' => 'true',
      'duplicate_merge' => 'disabled',
      'duplicate_merge_dom_value' => 0,
      'audited' => false,
      'inline_edit' => true,
      'reportable' => true,
      'unified_search' => false,
      'merge_filter' => 'disabled',
      'studio' => 'visible',
      'len' => 20,
      'size' => '20',
    );
     $dictionary["te_student_batch"]["fields"]["study_kit_address_city"] = array ( 
      'required' => false,
      'name' => 'study_kit_address_city',
      'vname' => 'Study Kit Address City',
      'type' => 'varchar',
      'massupdate' => 0,
      'no_default' => false,
      'comments' => '',
      'help' => '',
      'importable' => 'true',
      'duplicate_merge' => 'disabled',
      'duplicate_merge_dom_value' => 0,
      'audited' => false,
      'inline_edit' => true,
      'reportable' => true,
      'unified_search' => false,
      'merge_filter' => 'disabled',
      'studio' => 'visible',
      'len' => 100,
      'size' => '20',
    );


$dictionary["te_student_batch"]["fields"]["student_kitsent"] = array(
  'required' => false,
	'name' => 'student_kitsent',
	'vname' => 'Student Kit Sent',
	'type' => 'varchar',
	'audited' => false,
	'massupdate' => false,
	'source' => 'non-db',
	'studio' => 'visible',
);




$dictionary['te_student_batch']['fields']['mobile'] = array(
	'required' => false,
	'name' => 'mobile',
	'vname' => 'Phone',
	'type' => 'varchar',
	'audited' => false,
	'massupdate' => false,
	'source' => 'non-db',
	'studio' => 'visible',
);

$dictionary['te_student_batch']['fields']['is_new_approved'] = array(
	'required' => false,
	'name' => 'is_new_approved',
	'vname' => 'is_new_approved',
	'type' => 'int',
	'audited' => false,
	'massupdate' => false,	 
	'studio' => 'visible',
);









$dictionary['te_student_batch']['fields']['feepaid'] = array(
	'required' => false,
	'name' => 'feepaid',
	'vname' => 'Fee-Paid',
	'type' => 'varchar',
	'audited' => false,
	'massupdate' => false,
	'source' => 'non-db',
	'studio' => 'visible',
);



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



$dictionary['te_student_batch']['fields']['total_payment'] = array(
	'required' => false,
	'name' => 'total_payment',
	'vname' => 'Total Payment',
	'type' => 'varchar',
	'default'=>'0',
	'audited' => false,
	'massupdate' => false,
	'studio' => 'visible',
	'len' => '255',
	'size' => '20',
	'dbType' => 'varchar',
);


?>