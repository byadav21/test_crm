<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');
class PaymentCurrency{
	function showCurrency($bean, $event, $argument){
		if($bean->currency=="USD"){
			$bean->balance_inr=$bean->balance_usd;
			$query = "SELECT balance_usd,discount,paid_amount_usd,due_amount_usd FROM te_student_payment_plan WHERE id = '".$bean->id."'";
			$queryObj= $GLOBALS['db']->query($query);
			$result= $GLOBALS['db']->fetchByAssoc($queryObj);
			$bean->balance_inr=	$result['balance_usd'];
			$bean->fees=$result['due_amount_usd']+$result['discount'];
			$bean->total_amount=$result['due_amount_usd']+$result['discount'];
			$bean->paid_amount_inr=$result['paid_amount_usd'];
			$bean->tax="0";
		}

	}
}
