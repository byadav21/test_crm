<?php
require('custom/modules/Leads/fppdf/generateInvoiceFunction.php');
 //~ ini_set("display_errors",1);
if(isset($_REQUEST['LeadID']) && !empty($_REQUEST['LeadID'])){
	$lead_id = trim($_REQUEST['LeadID']);
	$params = array();
	$bean = BeanFactory::newBean('Leads');
	//~ $lead = new Lead();
	$bean->retrieve($lead_id);
	$to = $bean->first_name." ".$bean->last_name;
	$mobile = $bean->phone_mobile;
	$invoiceNumber = $bean->invoice_number;
	if($invoiceNumber==0){
		$inv = "SELECT max(invoice_number) as invoice_number from leads";
		$re = $GLOBALS['db']->query($inv);
		$xx = $GLOBALS['db']->fetchByAssoc($re);
		$invoiceNumber = $xx['invoice_number']+1;
		$re = $GLOBALS['db']->query("UPDATE leads SET invoice_number = {$invoiceNumber} WHERE id = '".$bean->id."'" ); 
	}
	$sqlB = "SELECT fees_inr FROM te_ba_batch  WHERE id = '".$bean->te_ba_batch_id_c."'";
	$reB = $GLOBALS['db']->query($sqlB);
	$xxB = $GLOBALS['db']->fetchByAssoc($reB);
	$cost = $xxB['fees_inr'];
	$total = $cost;
	$subtotal = $cost;
	$tax = ($subtotal * $GLOBALS['sugar_config']['tax']['service'])/100;
	$gross = $total + $tax;

	$sql_pro = "SELECT te_pr_programs_te_ba_batch_1te_pr_programs_ida,name FROM te_pr_programs p INNER JOIN te_pr_programs_te_ba_batch_1_c  pb ON p.id = pb.te_pr_programs_te_ba_batch_1te_pr_programs_ida WHERE te_pr_programs_te_ba_batch_1te_ba_batch_idb = '".$bean->te_ba_batch_id_c."' AND pb.deleted = 0 AND p.deleted=0";
	$res_pro = $GLOBALS['db']->query($sql_pro);
	$pro = $GLOBALS['db']->fetchByAssoc($res_pro);
	$program_name = $pro['name'];

	$payment_source = $bean->payment_source;

	$params['invoice_to']=$to;
	$params['mobile']=$bean->phone_mobile;
	$params['invoiceNumber']=$invoiceNumber;
	$params['cost']=$cost;
	$params['total']=$cost;
	$params['subtotal']=$cost;
	$params['tax']=$tax;
	$params['gross']=$gross;
	$params['program_name']=$program_name;
	$params['payment_source']=$payment_source;
	//~ 
	//~ echo "<pre>";
	//~ print_r($params);
	generatePdf($params);
	
}
else{
		die("Error");
}
