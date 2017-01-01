<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class UpdateInitialPyment {
    function updatePayment(&$bean, $event, $arguments) {		
		$bean->no_of_installments=$_REQUEST['installment'];
		$bean->initial_payment_inr=$_REQUEST['initial_payment_inr'];
		$bean->initial_payment_usd=$_REQUEST['initial_payment_usd'];
		$bean->initial_payment_date=$GLOBALS['timedate']->to_db_date($_REQUEST['initial_payment_date'],false);
	}
}
