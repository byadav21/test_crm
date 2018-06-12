<?php
if(!defined('sugarEntry'))define('sugarEntry', true);
require_once('include/entryPoint.php');
//require_once('modules/Campaigns/utils.php');
echo $query = "SELECT leads.id AS Lead_id,leads.date_entered,leads.date_modified,
				leads.modified_user_id,leads.assigned_user_id,ru.reports_to_id,
				leads.deleted,leads.converted,leads.converted_date,leads.lead_source_types,
				leads.lead_source,leads.vendor,leads.lead_source_description,leads.status,
				leads.status_description,leads.campaign_id,leads.gender,
				(CASE WHEN leads_cstm.`attempts_c` IN ('','null') OR leads_cstm.`attempts_c` IS NULL THEN 0 ELSE leads_cstm.`attempts_c` END) attempts_c,
				(CASE WHEN leads.Amount IN ('','null') OR leads.Amount IS NULL THEN 0 ELSE leads.Amount END) Amount,
				leads.utm,leads.fee_usd,leads.fee_inr,leads.converted_date,leads.utm_campaign,
				leads.neoxstatus,i.name Institute_name,i.id Institute_id,p.name Program_name,
				p.id Program_id,te_ba_batch.name AS batch_name,te_ba_batch.batch_code,te_ba_batch.batch_status,
				(CASE WHEN te_ba_batch.batch_size IN ('','null') OR te_ba_batch.batch_size IS NULL THEN 0 ELSE te_ba_batch.batch_size END) batch_size,
				leads.assigned_date,leads.channel,leads.`dispositionName`,te_ba_batch.no_of_installments Instalment_no
			FROM leads 
			INNER JOIN leads_cstm ON leads.id= leads_cstm.id_c AND leads.deleted=0
			INNER JOIN te_ba_batch ON leads_cstm.te_ba_batch_id_c= te_ba_batch.id AND te_ba_batch.deleted=0
			INNER JOIN te_in_institutes_te_ba_batch_1_c AS ib ON leads_cstm.te_ba_batch_id_c=ib.te_in_institutes_te_ba_batch_1te_ba_batch_idb AND ib.deleted=0
			INNER JOIN te_in_institutes as i on ib.te_in_institutes_te_ba_batch_1te_in_institutes_ida=i.id AND i.deleted=0
			INNER JOIN te_pr_programs_te_ba_batch_1_c AS pb ON pb.te_pr_programs_te_ba_batch_1te_ba_batch_idb=leads_cstm.te_ba_batch_id_c AND pb.deleted=0
			INNER JOIN te_pr_programs AS p ON p.id=pb.te_pr_programs_te_ba_batch_1te_pr_programs_ida AND p.deleted=0
			LEFT JOIN users AS ru ON ru.id=leads.assigned_user_id 
			order by leads.id limit 10";exit;
$res = $db->query($query);
$row = $db->fetchByAssoc($res);
echo "<pre>";print_r($row);echo "</pre>";
 ?>