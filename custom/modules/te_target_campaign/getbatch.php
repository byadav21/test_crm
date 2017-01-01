<?php
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');
global $app_list_strings,$current_user,$sugar_config,$db;

if(isset($_REQUEST['programId']) && $_REQUEST['programId']!=""){
	$batchSql="SELECT distinct(b.id),b.name FROM te_ba_batch b INNER JOIN te_pr_programs_te_ba_batch_1_c r on b.id=r.te_pr_programs_te_ba_batch_1te_ba_batch_idb AND r.te_pr_programs_te_ba_batch_1te_pr_programs_ida='".$_REQUEST['programId']."' WHERE r.deleted=0";
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
