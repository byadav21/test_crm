<?php
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');
global $app_list_strings,$current_user,$sugar_config,$db;

if(isset($_REQUEST['batch_val']) && !empty($_REQUEST['batch_val'])){
	$utmSql="SELECT distinct(v.id),v.name,date(te_ba_batch.date_entered) as date_entered FROM te_ba_batch INNER JOIN te_utm u on u.te_ba_batch_id_c=te_ba_batch.id INNER JOIN  te_vendor_te_utm_1_c uvr ON u.id=uvr.te_vendor_te_utm_1te_utm_idb INNER JOIN te_vendor v ON uvr.te_vendor_te_utm_1te_vendor_ida=v.id WHERE te_ba_batch.id='".$_REQUEST['batch_val']."' AND u.utm_status='Live'";
	$utmObj =$db->query($utmSql);
	$utmOptions=array('status'=>'error','res'=>'');
	while($row =$db->fetchByAssoc($utmObj)){ 
		$utmOptions['res'][]=$row;
		$utmOptions['date_entered']=$row['date_entered'];
	}	
	if(!empty($utmOptions['res'])){
		$utmOptions['status']='ok';
	}
	echo json_encode($utmOptions);
	return false;
}
   
?>
