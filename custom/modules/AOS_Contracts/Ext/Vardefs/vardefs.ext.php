<?php 
 //WARNING: The contents of this file are auto-generated


 // created: 2016-09-18 22:23:31
$dictionary['AOS_Contracts']['fields']['target_c']['inline_edit']='1';
$dictionary['AOS_Contracts']['fields']['target_c']['labelValue']='Target';

 

$dictionary['AOS_Contracts']['fields']["po_number"]=array(
	'name' => 'po_number',
	'vname' => 'LBL_PO_NUMBER',
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
	'len' => '40',
	'size' => '20',
);

 

$dictionary['AOS_Contracts']['fields']['renewal_reminder_date']['type']='date';
$dictionary['AOS_Contracts']['fields']['renewal_reminder_date']['display_default']='+1 year';
$dictionary['AOS_Contracts']['fields']['renewal_reminder_date']['labelValue']='Expiry Date (Optional):';



// created: 2016-10-29 01:20:19
$dictionary["AOS_Contracts"]["fields"]["te_vendor_aos_contracts_1"] = array (
  'name' => 'te_vendor_aos_contracts_1',
  'type' => 'link',
  'required'=>true,
  'relationship' => 'te_vendor_aos_contracts_1',
  'source' => 'non-db',
  'module' => 'te_vendor',
  'bean_name' => 'te_vendor',
  'vname' => 'LBL_TE_VENDOR_AOS_CONTRACTS_1_FROM_TE_VENDOR_TITLE',
  'id_name' => 'te_vendor_aos_contracts_1te_vendor_ida',
);
$dictionary["AOS_Contracts"]["fields"]["te_vendor_aos_contracts_1_name"] = array (
  'name' => 'te_vendor_aos_contracts_1_name',
  'type' => 'relate',
  'required'=>true,
  'source' => 'non-db',
  'vname' => 'LBL_TE_VENDOR_AOS_CONTRACTS_1_FROM_TE_VENDOR_TITLE',
  'save' => true,
  'id_name' => 'te_vendor_aos_contracts_1te_vendor_ida',
  'link' => 'te_vendor_aos_contracts_1',
  'table' => 'te_vendor',
  'module' => 'te_vendor',
  'rname' => 'name',
);
$dictionary["AOS_Contracts"]["fields"]["te_vendor_aos_contracts_1te_vendor_ida"] = array (
  'name' => 'te_vendor_aos_contracts_1te_vendor_ida',
  'type' => 'link',
  'required'=>true,
  'relationship' => 'te_vendor_aos_contracts_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_TE_VENDOR_AOS_CONTRACTS_1_FROM_AOS_CONTRACTS_TITLE',
);


// created: 2016-10-22 13:16:05
$dictionary["AOS_Contracts"]["fields"]["aos_contracts_te_impression_1"] = array (
  'name' => 'aos_contracts_te_impression_1',
  'type' => 'link',
  'relationship' => 'aos_contracts_te_impression_1',
  'source' => 'non-db',
  'module' => 'te_impression',
  'bean_name' => 'te_impression',
  'side' => 'right',
  'vname' => 'LBL_AOS_CONTRACTS_TE_IMPRESSION_1_FROM_TE_IMPRESSION_TITLE',
);


 // created: 2016-11-07 02:40:27
$dictionary['AOS_Contracts']['fields']['description']['inline_edit']=true;
$dictionary['AOS_Contracts']['fields']['description']['comments']='Full text of the note';
$dictionary['AOS_Contracts']['fields']['description']['merge_filter']='disabled';
$dictionary['AOS_Contracts']['fields']['description']['cols']='84';

 

 // created: 2016-09-18 22:22:36
$dictionary['AOS_Contracts']['fields']['rate_c']['inline_edit']='1';
$dictionary['AOS_Contracts']['fields']['rate_c']['labelValue']='Rate';

 

 // created: 2016-11-07 03:06:58
$dictionary['AOS_Contracts']['fields']['volume_c']['inline_edit']='1';
$dictionary['AOS_Contracts']['fields']['volume_c']['labelValue']='Volume';

 

 // created: 2016-09-18 22:23:31
$dictionary['AOS_Contracts']['fields']["te_vendor_id_c"]=array(
	'required' => false,
	'name' => 'te_vendor_id_c',
	'vname' => 'LBL_VENDOR_TE_VENDOR_ID',
	'type' => 'id',
	'massupdate' => 0,
	'no_default' => false,
	'comments' => '',
	'help' => '',
	'importable' => 'true',
	'duplicate_merge' => 'disabled',
	'duplicate_merge_dom_value' => 0,
	'audited' => false,
	'inline_edit' => true,
	'reportable' => false,
	'unified_search' => false,
	'merge_filter' => 'disabled',
	'len' => 36,
	'size' => '20',
);
$dictionary['AOS_Contracts']['fields']["vendor"]=array(
	'required' => false,
	'source' => 'non-db',
	'name' => 'vendor',
	'vname' => 'LBL_VENDOR',
	'type' => 'relate',
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
	'len' => '255',
	'size' => '20',
	'id_name' => 'te_vendor_id_c',
	'ext2' => 'te_vendor',
	'module' => 'te_vendor',
	'rname' => 'name',
	'quicksearch' => 'enabled',
	'studio' => 'visible',
);


 // created: 2016-09-18 23:05:10
$dictionary['AOS_Contracts']['fields']['expiry_valume_c']['inline_edit']='1';
$dictionary['AOS_Contracts']['fields']['expiry_valume_c']['labelValue']='Expiry Valume';

 

$dictionary['AOS_Contracts']['fields']['performance_metrics'] = array (
	'name' => 'performance_metrics',
    'vname' => 'Performance Metrics',
    'type' => 'enum',
    'options'=>'performance_metrics',
    'duplicate_merge' => 'disabled',
    'required' => false,
    'studio' => 'visible',
);





 // created: 2016-11-08 01:01:54
$dictionary['AOS_Contracts']['fields']['contract_type']['default']='';
$dictionary['AOS_Contracts']['fields']['contract_type']['inline_edit']=true;
$dictionary['AOS_Contracts']['fields']['contract_type']['merge_filter']='disabled';

 
?>