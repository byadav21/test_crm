    <?php
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');
	ini_set('display_errors','1');

	error_reporting(E_ALL);
	global $app_list_strings,$current_user,$sugar_config,$db;
// Get UTM Based on batches for dropdown 2
if(isset($_REQUEST['export']) && !empty($_REQUEST['export'])){
	$sql ="SELECT v.name AS vendor, b.batch_code, tebc.`campaign_date` , tebc.`leads` , tebc.`conversion` , tebc.`conversion_rate` , tebc.`clp` , tebc.`cpa` , tebc.`volume` , tebc.`cost` FROM  `te_budgeted_campaign` AS tebc INNER JOIN te_utm_te_budgeted_campaign_1_c AS bcr ON tebc.id = bcr.te_utm_te_budgeted_campaign_1te_budgeted_campaign_idb INNER JOIN te_vendor_te_utm_1_c AS vur ON vur.te_vendor_te_utm_1te_utm_idb = bcr.te_utm_te_budgeted_campaign_1te_utm_ida INNER JOIN te_vendor AS v ON v.id = vur.te_vendor_te_utm_1te_vendor_ida INNER JOIN te_ba_batch AS b ON b.id = tebc.te_ba_batch_id_c WHERE tebc.deleted =0 AND bcr.deleted=0"; 

	$res_obj =$db->query($sql);
	
	$data = "Vendor,batch_code,date,volume,leads,cost,conversion,cpa,cpl";
	$data .= "\n";
	$filename = "budgeted_campaign_".time();
	while($result =$db->fetchByAssoc($res_obj)){
	    	$resultArr[]=$result['vendor'];
	    	$resultArr[]=$result['batch_code'];
		$resultArr[]=$result['campaign_date'];
		$resultArr[]=$result['volume'];
		$resultArr[]=$result['leads'];
		$resultArr[]=$result['cost'];
		$resultArr[]=$result['conversion_rate'];
		$resultArr[]=$result['cpa'];
		$resultArr[]=$result['clp'];
		$data .= implode(',',$resultArr);
		$data .= "\n";
	    	$resultArr='';
	}
	ob_end_clean();
   	header("Content-type: application/csv");
	header('Content-disposition: attachment;filename=" ' . $filename . '.csv";');
	echo $data;
	exit;
}
if(isset($_REQUEST['batch_val']) && !empty($_REQUEST['batch_val'])){
	$query_utm="SELECT te_utm.id,te_utm.name,te_ba_batch.name batch_name FROM te_ba_batch INNER JOIN te_utm on te_utm.te_ba_batch_id_c=te_ba_batch.id AND te_ba_batch.id='".$_REQUEST['batch_val']."' AND te_utm.utm_status='Live'";
	$batch =$db->query($query_utm);
	$utmArr='';
	$utmArr['status']='error';
	$utmArr['res']='';
	while($utm =$db->fetchByAssoc($batch)){
		$utmArr['res'][]=array('id'=>$utm['id'],'name'=>$utm['name']);
	}

	if(!empty($utmArr['res'])){
		$utmArr['status']='ok';
	}
	echo json_encode($utmArr);
	return false;
}
if(isset($_REQUEST['vendors']) && !empty($_REQUEST['vendors'])){
 //$query_utm="SELECT c.name,c.id FROM `te_vendor_aos_contracts_1_c` vc INNER JOIN aos_contracts c ON vc.te_vendor_aos_contracts_1aos_contracts_idb=c.id WHERE vc.deleted=0 AND vc.te_vendor_aos_contracts_1te_vendor_ida='".$_REQUEST['vendors']."' AND c.deleted=0";
 $query_utm="SELECT GROUP_CONCAT(DISTINCT u.contract_type)contract_type,v.id AS vendorid,v.name AS vendor,u.id,u.name FROM `te_utm` AS u INNER JOIN te_vendor_te_utm_1_c AS uv ON uv.te_vendor_te_utm_1te_utm_idb=u.id INNER JOIN te_vendor AS v ON v.id=uv.te_vendor_te_utm_1te_vendor_ida WHERE u.deleted=0 AND v.deleted=0 AND v.vendor_status='Active' AND v.id='".$_REQUEST['vendors']."' GROUP BY v.id";
 $batch =$db->query($query_utm);
 $utmArr='';
 $utmArr['status']='error';
 $utmArr['res']='';
 while($utm =$db->fetchByAssoc($batch)){
 	$contract_type = explode(',',$utm['contract_type']);
	foreach($contract_type as $cval){
		$utmArr['res'][]=array('id'=>$utm['vendorid']."_TE_".$cval,'name'=>$utm['vendor']." - ".$cval);
	}

 }

 if(!empty($utmArr['res'])){
  $utmArr['status']='ok';
 }
 echo json_encode($utmArr);
 return false;
}

?>
