<?php
 // created: 2016-09-15 13:52:52
$dictionary['Lead']['fields']['date_of_payment']['name']='date_of_payment';
$dictionary['Lead']['fields']['date_of_payment']['vname']='LBL_DATEOFPAYMENT';
$dictionary['Lead']['fields']['date_of_payment']['type']='date';
$dictionary['Lead']['fields']['date_of_payment']['enable_range_search']=true;
$dictionary['Lead']['fields']['date_of_payment']['options']='date_range_search_dom';

$dictionary['Lead']['fields']['amount']['name']='amount';
$dictionary['Lead']['fields']['amount']['vname']='LBL_AMOUNT';
$dictionary['Lead']['fields']['amount']['type']='decimal';
$dictionary['Lead']['fields']['amount']['enable_range_search']=false;
$dictionary['Lead']['fields']['amount']['size']='20';
$dictionary['Lead']['fields']['amount']['len']='18';
$dictionary['Lead']['fields']['amount']['precision']='2';


$dictionary['Lead']['fields']['reference_number']['name']='reference_number';
$dictionary['Lead']['fields']['reference_number']['vname']='LBL_REFERENCENUMBER';
$dictionary['Lead']['fields']['reference_number']['type']='varchar';
$dictionary['Lead']['fields']['reference_number']['len']='100';
$dictionary['Lead']['fields']['reference_number']['audited']='false';



$dictionary['Lead']['fields']['transaction_id']['name']='transaction_id';
$dictionary['Lead']['fields']['transaction_id']['vname']='LBL_TRANSACTIONID';
$dictionary['Lead']['fields']['transaction_id']['type']='varchar';
$dictionary['Lead']['fields']['transaction_id']['len']='100';
$dictionary['Lead']['fields']['transaction_id']['audited']='false';



$dictionary['Lead']['fields']['payment_type']['name']='payment_type';
$dictionary['Lead']['fields']['payment_type']['type']='enum';
$dictionary['Lead']['fields']['payment_type']['vname']='LBL_PAYMENTTYPE';
$dictionary['Lead']['fields']['payment_type']['len']='100';
$dictionary['Lead']['fields']['payment_type']['options']='payment_type_dom';
$dictionary['Lead']['fields']['payment_type']['audited']='false';


$dictionary['Lead']['fields']['payment_source']['name']='payment_source';
$dictionary['Lead']['fields']['payment_source']['type']='enum';
$dictionary['Lead']['fields']['payment_source']['vname']='LBL_PAYMENTTYPESOURCE';
$dictionary['Lead']['fields']['payment_source']['len']='100';
$dictionary['Lead']['fields']['payment_source']['options']='payment_type_source_dom';
$dictionary['Lead']['fields']['payment_source']['audited']='false';



$dictionary['Lead']['fields']['payment_realized']['name']='payment_realized';
$dictionary['Lead']['fields']['payment_realized']['type']='enum';
$dictionary['Lead']['fields']['payment_realized']['vname']='LBL_PAYMENTREREALIZED';
$dictionary['Lead']['fields']['payment_realized']['len']='2';
$dictionary['Lead']['fields']['payment_realized']['options']='payment_relize';
$dictionary['Lead']['fields']['payment_realized']['audited']='false';


$dictionary['Lead']['fields']['payment_realized_check']['name']='payment_realized_check';
$dictionary['Lead']['fields']['payment_realized_check']['type']='bool';
$dictionary['Lead']['fields']['payment_realized_check']['vname']='LBL_PAYMENTREREALIZED_CHECK';
$dictionary['Lead']['fields']['payment_realized_check']['len']='2';
$dictionary['Lead']['fields']['payment_realized_check']['audited']='false';


$dictionary['Lead']['fields']['phone_mobile']['inline_edit']='false';
$dictionary['Lead']['fields']['phone_other']['inline_edit']='false';


$dictionary['Lead']['fields']['date_of_callback']['name']='date_of_callback';
$dictionary['Lead']['fields']['date_of_callback']['vname']='LBL_DATEOFCALLBACK';
$dictionary['Lead']['fields']['date_of_callback']['type']='datetimecombo';
$dictionary['Lead']['fields']['date_of_callback']['dbType']='datetime';
$dictionary['Lead']['fields']['date_of_callback']['enable_range_search']=true;
$dictionary['Lead']['fields']['date_of_callback']['options']='date_range_search_dom';


$dictionary['Lead']['fields']['date_of_followup']['name']='date_of_followup';
$dictionary['Lead']['fields']['date_of_followup']['vname']='LBL_DATEOFFOLLOWUP';
$dictionary['Lead']['fields']['date_of_followup']['type']='datetimecombo';
$dictionary['Lead']['fields']['date_of_followup']['dbType']='datetime';
$dictionary['Lead']['fields']['date_of_followup']['enable_range_search']=true;
$dictionary['Lead']['fields']['date_of_followup']['options']='date_range_search_dom';


$dictionary['Lead']['fields']['date_of_prospect']['name']='date_of_prospect';
$dictionary['Lead']['fields']['date_of_prospect']['vname']='LBL_DATEOFPROSPECT';
$dictionary['Lead']['fields']['date_of_prospect']['type']='datetimecombo';
$dictionary['Lead']['fields']['date_of_prospect']['dbType']='datetime';
$dictionary['Lead']['fields']['date_of_prospect']['enable_range_search']=true;
$dictionary['Lead']['fields']['date_of_prospect']['options']='date_range_search_dom';



$dictionary['Lead']['fields']['assigned_flag']['name']='assigned_flag';
$dictionary['Lead']['fields']['assigned_flag']['type']='bool';
$dictionary['Lead']['fields']['assigned_flag']['vname']='LBL_ASSIGNED_FLAG';
$dictionary['Lead']['fields']['assigned_flag']['len']='2';
$dictionary['Lead']['fields']['assigned_flag']['audited']='false';


 ?>
 
 
