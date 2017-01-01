<?php

// custom/modules/Leads/LeadsJjwg_MapsLogicHook.php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class UpdateInstallments {

    function updatePayments(&$bean, $event, $arguments) {
		$res1=$GLOBALS['db']->query("DELETE FROM te_installments");
		$res2=$GLOBALS['db']->query("DELETE FROM te_ba_batch_te_installments_1_c WHERE te_ba_batch_te_installments_1te_ba_batch_ida='".$bean->id."'");
		
		for($x=1;$x<=$bean->no_of_installments;$x++){
			$inr_index="payment_inr_".$x;
			$usd_index="payment_usd_".$x;
			$due_date_index="due_date_".$x;
			$installmentsObj = new te_installments();
			$installmentsObj->payment_inr		=	$_REQUEST[$inr_index];	
			$installmentsObj->payment_usd		=	$_REQUEST[$usd_index];
			$installmentsObj->due_date			=	$GLOBALS['timedate']->to_db_date($_REQUEST[$due_date_index],false);
			$installmentsObj->te_ba_batch_te_installments_1te_ba_batch_ida	=	$bean->id;
			$installmentsObj->save();
			unset($installmentsObj);
		}		
    }
}
