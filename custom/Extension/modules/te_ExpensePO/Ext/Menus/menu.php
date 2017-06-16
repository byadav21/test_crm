<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); 
global $mod_strings, $app_strings, $sugar_config;

// This will add the new option
//if(ACLController::checkAccess('te_ExpensePO', 'import', true))$module_menu[]=Array("index.php?module=te_ExpensePO&action=lead_transfer", "Bulk Leads Transfer", "");
$module_menu[]=Array("index.php?module=te_ExpensePO&action=EditView&return_module=te_ExpensePO&return_action=DetailView&type=PO", "Create Expense without PO", "");
$module_menu[]=Array("index.php?module=te_ExpensePO&action=EditView&return_module=te_ExpensePO&return_action=DetailView&type=PR", "Create Purchase Requisition", "");
$module_menu[]=Array("index.php?module=te_ExpensePO&action=index", "View Expense Vouchers", "");
?>
