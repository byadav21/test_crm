<?php
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


$dictionary['te_payment_details']['fields']['payment_realized']['name']='payment_realized';
$dictionary['te_payment_details']['fields']['payment_realized']['type']='enum';
$dictionary['te_payment_details']['fields']['payment_realized']['vname']='LBL_PAYMENTTYPESOURCE';
$dictionary['te_payment_details']['fields']['payment_realized']['len']='2';
$dictionary['te_payment_details']['fields']['payment_realized']['options']='payment_relize';
$dictionary['te_payment_details']['fields']['payment_realized']['audited']='false';

 ?>
 
 
