<?php
// created: 2016-10-29 01:20:19
$dictionary["te_vendor"]["fields"]["te_vendor_aos_contracts_1"] = array (
  'name' => 'te_vendor_aos_contracts_1',
  'type' => 'link',
  'relationship' => 'te_vendor_aos_contracts_1',
  'source' => 'non-db',
  'module' => 'AOS_Contracts',
  'bean_name' => 'AOS_Contracts',
  'side' => 'right',
  'vname' => 'LBL_TE_VENDOR_AOS_CONTRACTS_1_FROM_AOS_CONTRACTS_TITLE',
);

$dictionary['te_vendor']['fields']['SAP_Status'] =array (
               'name' => 'SAP_Status',
               'vname' => 'SAP Status',
               'type' => 'int',
               'required' => false,
               'comments' => 'to check whether Vendor is downloaded to SAP',
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
$dictionary['te_vendor']['fields']['Contact_Status'] =array (
               'name' => 'Contact_Status',
               'vname' => 'Contact Status',
               'type' => 'int',
               'required' => false,
               'comments' => 'to check whether Vendor Contact Person is downloaded to SAP',
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

$dictionary['te_vendor']['fields']['SAP_CardCode'] =array (
               'name' => 'SAP_CardCode',
               'vname' => 'SAP CardCode',
               'type' => 'varchar',
               'required' => false,
               'comments' => 'SAP CardCode',
               'help' => '',
               'default'=> null,
               'importable' => 'false',
               'duplicate_merge' => 'disabled',
               'duplicate_merge_dom_value' => '0',
               'audited' => false,
               'reportable' => false,
               'len' => '250',
               'size' => '250',
       );