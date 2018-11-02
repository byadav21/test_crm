<?php
//return "test";exit;
//exit;
//print_r($_REQUEST);exit;
if(!defined('sugarEntry'))define('sugarEntry', true);
require_once('include/entryPoint.php'); 
global $db;
$modifieddate=$_POST['modifieddate'];
//$modifieddate=$date;
$query="SELECT b.id Batch_id,b.name batch,b.batch_code,b.batch_size, b.fees_inr as fee_inr,u.name AS utm,v.name AS Utm_source,
u.`contract_type` AS Utm_medium,b.name AS Utm_term,u.`utm_status` AS utm_status,
c.name AS contract,bcc.id Budget_id,bcc.leads as budget_leads, bcc.volume Budget_volume,bcc.cost Budget_amount,
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
WHERE u.deleted=0 AND tac_ac.date_entered > '$modifieddate'";//exit;
$result = $db->query($query);
$data= array();
while (($row = $db->fetchByAssoc($result)) != null) {
	$data[]=$row;
}	
echo json_encode($data);exit;