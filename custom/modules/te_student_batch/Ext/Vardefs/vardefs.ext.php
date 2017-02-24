<?php 
 //WARNING: The contents of this file are auto-generated


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




$dictionary['te_student_batch']['fields']['leads_id'] =array (
	'name' => 'leads_id',
	'label' => 'LBL_LEADS_ID',
	'type' => 'varchar',
	'help' => '',
	'comment' => '',
	'default_value' => '',
	'len' => '50',
    'size' => '20',
	'required' => false, 
	'reportable' => true, 
	'audited' => false, 
	'importable' => 'true', 
	'duplicate_merge' => false, 
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


?>