<?php
// created: 2016-11-03 00:13:18
$dictionary["te_payment_details"]["fields"]["leads_te_payment_details_1"] = array (
  'name' => 'leads_te_payment_details_1',
  'type' => 'link',
  'relationship' => 'leads_te_payment_details_1',
  'source' => 'non-db',
  'module' => 'Leads',
  'bean_name' => 'Lead',
  'vname' => 'LBL_LEADS_TE_PAYMENT_DETAILS_1_FROM_LEADS_TITLE',
  'id_name' => 'leads_te_payment_details_1leads_ida',
);
$dictionary["te_payment_details"]["fields"]["leads_te_payment_details_1_name"] = array (
  'name' => 'leads_te_payment_details_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_LEADS_TE_PAYMENT_DETAILS_1_FROM_LEADS_TITLE',
  'save' => true,
  'id_name' => 'leads_te_payment_details_1leads_ida',
  'link' => 'leads_te_payment_details_1',
  'table' => 'leads',
  'module' => 'Leads',
  'rname' => 'name',
  'db_concat_fields' => 
  array (
    0 => 'first_name',
    1 => 'last_name',
  ),
);
$dictionary["te_payment_details"]["fields"]["leads_te_payment_details_1leads_ida"] = array (
  'name' => 'leads_te_payment_details_1leads_ida',
  'type' => 'link',
  'relationship' => 'leads_te_payment_details_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_LEADS_TE_PAYMENT_DETAILS_1_FROM_TE_PAYMENT_DETAILS_TITLE',
);

$dictionary["te_payment_details"]["fields"]["country"] = array (
		'name' => 'country',
		'vname' => 'Country',
		'type' => 'varchar',
		'required' => false,
		'comments' => 'Student Country',
		'help' => '',
		'default'=> NULL,
		'importable' => 'false',
		'duplicate_merge' => 'disabled',
		'duplicate_merge_dom_value' => '0',
		'audited' => false,
		'reportable' => false,
		'len' => '100',
		'size' => '100',
	);
$dictionary["te_payment_details"]["fields"]["state"] = array (
		'name' => 'state',
		'vname' => 'state',
		'type' => 'varchar',
		'required' => false,
		'comments' => 'Student State',
		'help' => '',
		'default'=> NULL,
		'importable' => 'false',
		'duplicate_merge' => 'disabled',
		'duplicate_merge_dom_value' => '0',
		'audited' => false,
		'reportable' => false,
		'len' => '100',
		'size' => '100',
	);