<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class BatchTransferRequest{
	function approveBatchTransferRequest($bean, $event, $argument){
		global $db;

		  $programmeOld="select p.te_pr_programs_te_ba_batch_1te_pr_programs_ida as id from te_ba_batch as b inner join te_pr_programs_te_ba_batch_1_c as p on p.te_pr_programs_te_ba_batch_1te_ba_batch_idb=b.id where b.id='".$bean->old_batch_records."' and b.deleted=0";
		 $programObj=$db->query($programmeOld);
		 $programObjOld=$db->fetchByAssoc($programObj);


		  $programmeNew="select p.te_pr_programs_te_ba_batch_1te_pr_programs_ida as id from te_ba_batch as b inner join te_pr_programs_te_ba_batch_1_c as p on p.te_pr_programs_te_ba_batch_1te_ba_batch_idb=b.id where b.id='".$bean->te_ba_batch_id_c."' and b.deleted=0";
		$programObj=$db->query($programmeNew);
		$programObjNew=$db->fetchByAssoc($programObj);
		$bean->country=($programObjOld['id']==$programObjNew['id']) ? 'Batch'	: 'Programme';


		$data=$db->fetchByAssoc($programObj);

		if($bean->status=="Pending"){
			 global $current_user;
			// print_r($_SESSION['ACL'][$current_user->id]['te_transfer_batch']);


			if(ACLController::checkAccess('te_transfer_batch','edit') && $current_user->designation=="BUH"){

				$batch_action_list =$GLOBALS['app_list_strings']['dropuout_status_list'];
				$action="<span id='batch_transfer_request_".$bean->id."'></span><select name='status' id='".$bean->id."' onchange='return changeTransferStatus(this.id,this.value);'><option value='' style='width:30px;'>--select--</option>";
				foreach($batch_action_list as $key=>$value){
					if($bean->status==$key)
						$action.="<option value='".$key."' selected>".$value."</option>";
					else
						$action.="<option value='".$key."'>".$value."</option>";
				}
				$action.="</select>";
				$bean->status=$action;

			}

			$programsql="SELECT b.name FROM te_ba_batch AS b INNER JOIN `te_transfer_batch` AS tb ON b.id=tb.`te_student_batch_id_c`  WHERE tb.id='".$bean->id."'";

		}
		else{
			$programsql="SELECT b.name FROM te_ba_batch AS b INNER JOIN `te_transfer_batch` AS tb ON b.id=tb.`old_batch_records`  WHERE tb.id='".$bean->id."'";
		}
		
	$programObj=$db->query($programsql);
	$data=$db->fetchByAssoc($programObj);

	$bean->old_batch=$data['name'];

	}
}
