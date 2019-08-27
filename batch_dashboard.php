<?php
if(!defined('sugarEntry'))define('sugarEntry', true);
require_once('include/entryPoint.php');
 
$query="SELECT b.id Batch_id,b.name batch,b.batch_code,u.name AS utm,v.name AS Utm_source,
u.`contract_type` AS Utm_medium,b.name AS Utm_term,u.`utm_status` AS utm_status,
c.name AS contract,bcc.id Budget_id,bcc.volume Budget_volume,bcc.cost Budget_amount,
tac_ac.id Actual_Budget_id,tac_ac.volume Actual_volume,tac_ac.total_cost Actual_amount,bcc.date_entered budget_date_entered, bcc.date_modified budget_date_modified, tac_ac.date_entered actual_budget_date_entered, tac_ac.date_modified actual_budget_date_modified
FROM `te_utm` AS u
INNER JOIN te_ba_batch AS b ON b.id=u.`te_ba_batch_id_c` and b.deleted=0
INNER JOIN te_vendor_te_utm_1_c AS uvr ON uvr.te_vendor_te_utm_1te_utm_idb=u.id and uvr.deleted=0
INNER JOIN te_vendor AS v ON v.id=uvr.te_vendor_te_utm_1te_vendor_ida and v.deleted=0
INNER JOIN aos_contracts AS c ON c.id=u.aos_contracts_id_c and c.deleted=0
INNER JOIN te_utm_te_budgeted_campaign_1_c tbc on u.id=tbc.te_utm_te_budgeted_campaign_1te_utm_ida and tbc.deleted=0
INNER JOIN te_budgeted_campaign bcc on tbc.te_utm_te_budgeted_campaign_1te_budgeted_campaign_idb=bcc.id and bcc.deleted=0
INNER JOIN te_utm_te_actual_campaign_1_c tac on u.id=tac.te_utm_te_actual_campaign_1te_utm_ida and tac.deleted=0
INNER JOIN te_actual_campaign tac_ac on tac.te_utm_te_actual_campaign_1te_actual_campaign_idb=tac_ac.id and tac_ac.deleted=0
WHERE u.deleted=0";
$result = $db->query($query);
while (($row = $db->fetchByAssoc($result)) != null) {
	//echo "<pre>";print_r($row);echo "</pre>";
	/*$query = "SELECT *  FROM dashboard_batch WHERE lead_id='".$row['lead_id']."' ";
	$resultselect = $db->query($query, false);
	//echo $resultselect->num_rows;
	//echo "<pre>";print_r($resultselect);echo "</pre>";exit;
	if($resultselect->num_rows==0){

	}*/
	$insertquery="INSERT INTO `dashboard_actual_budget` ( `batch_id`, `batch`, `batch_code`, `utm`, `utm_source`, `utm_medium`, `utm_term`, `utm_status`, `contract`, `budget_id`, `budget_volume`, `budget_amount`, `actual_Budget_id`, `actual_volume`, `actual_amount`, `budget_entry_date`, `budget_modified_date`, `actual_budget_entry_date`, `actual_budget_modified_date`) VALUES ('".$row['Batch_id']."', '".$row['batch']."', '".$row['batch_code']."', '".$row['utm']."', '".$row['Utm_source']."', '".$row['Utm_medium']."', '".$row['Utm_term']."', '".$row['utm_status']."', '".$row['contract']."', '".$row['Budget_id']."', '".$row['Budget_volume']."','".$row['Budget_amount']."', '".$row['Actual_Budget_id']."', '".$row['Actual_volume']."', '".$row['Actual_amount']."', '".$row['budget_date_entered']."', '".$row['budget_date_modified']."', '".$row['actual_budget_date_entered']."', '".$row['actual_budget_date_modified']."')";
	$insert = $db->query($insertquery);
}	