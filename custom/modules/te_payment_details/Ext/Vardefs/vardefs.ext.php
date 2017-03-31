<?php 
 //WARNING: The contents of this file are auto-generated


$dictionary['te_payment_details']['fields']['currency_type'] = array (
'name' => 'currency_type',
    'vname' => 'Currency Type',
    'type' => 'enum',
    'options'=>'pyment_currency_type',
    'duplicate_merge' => 'disabled',
    'required' => false,
    'studio' => 'visible',
);


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


 // created: 2016-09-15 13:52:52


$dictionary['te_payment_details']['fields']['transaction_id']['name']='transaction_id';
$dictionary['te_payment_details']['fields']['transaction_id']['vname']='LBL_TRANSACTIONID';
$dictionary['te_payment_details']['fields']['transaction_id']['type']='varchar';
$dictionary['te_payment_details']['fields']['transaction_id']['len']='100';
$dictionary['te_payment_details']['fields']['transaction_id']['audited']='false';


$dictionary['te_payment_details']['fields']['payment_source']['name']='payment_source';
$dictionary['te_payment_details']['fields']['payment_source']['type']='enum';
$dictionary['te_payment_details']['fields']['payment_source']['vname']='LBL_PAYMENTTYPESOURCE';
$dictionary['te_payment_details']['fields']['payment_source']['len']='100';
$dictionary['te_payment_details']['fields']['payment_source']['options']='payment_type_source_dom';
$dictionary['te_payment_details']['fields']['payment_source']['audited']='false';

 
 
 

?>