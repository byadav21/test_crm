<?php
if(!defined('sugarEntry')) {
	define('sugarEntry', true);
}
ini_set("memory_limit","512M");
global $db;

$leadSql="SELECT id,utm FROM leads WHERE deleted=0 AND fee_inr is NULL AND utm <>'NA' LIMIT 0,50";
$leadObj = $db->query($leadSql);
while($row=$db->fetchByAssoc($leadObj)){
	$utmSql="SELECT b.fees_inr,b.fees_in_usd,b.minimum_attendance_criteria as minimum_attendance,v.name as vendor,u.te_ba_batch_id_c FROM te_utm u INNER JOIN te_ba_batch b ON u.te_ba_batch_id_c=b.id INNER JOIN te_vendor_te_utm_1_c uvr ON u.id=uvr.te_vendor_te_utm_1te_utm_idb INNER JOIN te_vendor v ON uvr.te_vendor_te_utm_1te_vendor_ida=v.id WHERE u.name='".$row['utm']."' AND u.deleted=0";
	$utmObj = $db->Query($utmSql);
	$utm = $db->fetchByAssoc($utmObj);
	$updateLeadSql="UPDATE leads, leads_cstm SET leads.fee_inr='".strstr($utm['fees_inr'],'.',true)."',leads.fee_usd='".strstr($utm['fees_in_usd'],'.',true)."',leads.minimum_attendance='".strstr($utm['minimum_attendance'],'.',true)."',leads.vendor='".$utm['vendor']."',leads_cstm.te_ba_batch_id_c='".$utm['te_ba_batch_id_c']."' WHERE leads.id = leads_cstm.id_c AND leads.id='".$row['id']."'";	
	$db->query($updateLeadSql);	
}
?>
