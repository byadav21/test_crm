<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
class UpdatePaymentName{
	
	function UpdatePaymentFunc($bean, $event, $argument){
				
		if(!empty($bean->name)){
			$sa = "UPDATE te_payment_details SET name='".$bean->reference_number."' WHERE id='".$bean->id."'";
				//~ echo $s;
				$GLOBALS['db']->query($sa);
			//~ $bean->name = $bean->reference_number;
		}
		$leadSql = "SELECT leads_te_payment_details_1leads_ida as lid FROM leads_te_payment_details_1_c WHERE leads_te_payment_details_1te_payment_details_idb = '".$bean->id."' AND deleted = 0";
		$relLead= $GLOBALS['db']->query($leadSql);
		
		if($GLOBALS['db']->getRowCount($relLead) > 0){
			$leadRow = $GLOBALS['db']->fetchByAssoc($relLead);
			$sqlRel = "SELECT p.id FROM te_payment_details p INNER JOIN leads_te_payment_details_1_c lp ON p.id=lp.leads_te_payment_details_1te_payment_details_idb WHERE lp.leads_te_payment_details_1leads_ida='".$leadRow['lid']."' AND p.payment_realized= 0 ";
			//~ echo $sqlRel."<br>";
			$rel= $GLOBALS['db']->query($sqlRel);
			if($GLOBALS['db']->getRowCount($rel) > 0){
				$s = "UPDATE leads SET payment_realized_check=0 WHERE id='".$leadRow['lid']."'";
				//~ echo $s;
				$GLOBALS['db']->query($s);
			}
			else{
				$s = "UPDATE leads SET payment_realized_check=1 WHERE id='".$leadRow['lid']."'";
				//~ echo $s;
				$GLOBALS['db']->query($s);
			}
		}
	}
}
