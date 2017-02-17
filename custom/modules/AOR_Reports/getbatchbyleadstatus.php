<?php
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');
global $app_list_strings,$current_user,$sugar_config,$db;

if(isset($_REQUEST['status']) && $_REQUEST['status']!=""){
	$status=$_REQUEST['status'];
	$where="";
	if($status=="Live"){
		$where.=" AND batch_status='enrollment_in_progress'";
	}else{
		$where.=" AND batch_status NOT IN ('enrollment_in_progress','planned')";
	}
	$batchSql="SELECT distinct(id),name FROM te_ba_batch WHERE deleted=0 ".$where;
	$batchObj =$db->query($batchSql);
	$batchOptions=array('status'=>'error','res'=>'');
	while($row =$db->fetchByAssoc($batchObj)){ 
		$batchOptions['res'][]=$row;
	}	
	if(!empty($batchOptions['res'])){
		$batchOptions['status']='ok';
	}
	echo json_encode($batchOptions);
}
?>
