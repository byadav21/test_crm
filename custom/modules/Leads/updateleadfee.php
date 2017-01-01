<?php
if(!defined('sugarEntry')) {
	define('sugarEntry', true);
}
ini_set("memory_limit","512M");
global $db;

$leadSql="SELECT l.id,lc.te_ba_batch_id_c FROM leads l INNER JOIN leads_cstm lc ON l.id=lc.id_c WHERE l.deleted=0 AND l.fee_inr is NULL AND lc.te_ba_batch_id_c <>'' LIMIT 0,50";
$leadObj = $db->query($leadSql);
while($row=$db->fetchByAssoc($leadObj)){
	$batchSql="SELECT fees_inr,fees_in_usd,minimum_attendance_criteria as minimum_attendance FROM te_ba_batch
	WHERE id='".$row['te_ba_batch_id_c']."' AND deleted=0";
	$batchObj = $db->Query($batchSql);
	$batch = $db->fetchByAssoc($batchObj);
	
	$updateSql = "UPDATE leads SET fee_inr='".strstr($batch['fees_inr'],'.',true)."',fee_usd='".strstr($batch['fees_in_usd'],'.',true)."',minimum_attendance='".strstr($batch['minimum_attendance'],'.',true)."' WHERE id='".$row['id']."'";
	$db->query($updateSql);	
}
?>
