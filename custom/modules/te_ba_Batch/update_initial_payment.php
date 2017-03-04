<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class UpdateInitialPyment {
    function updatePayment(&$bean, $event, $arguments) {		
		$bean->no_of_installments=$_REQUEST['installment'];
		$bean->initial_payment_inr=$_REQUEST['initial_payment_inr'];
		$bean->initial_payment_usd=$_REQUEST['initial_payment_usd'];
		$bean->initial_payment_date=$GLOBALS['timedate']->to_db_date($_REQUEST['initial_payment_date'],false);
		
		#If batch is being updated		
		if(isset($_REQUEST['record'])&&$_REQUEST['record']!=""){
			$studentBatchSql="UPDATE te_student_batch SET date_modified='".date('Y-m-d H:i:s')."', name='".$_REQUEST['name']."',batch_code='".$_REQUEST['batch_code']."',batch_start_date='".$GLOBALS['timedate']->to_db_date($_REQUEST['batch_start_date'],false)."',fee_inr='".$_REQUEST['fees_inr']."',fee_usd='".$_REQUEST['fees_usd']."',initial_payment_inr='".$_REQUEST['initial_payment_inr']."', initial_payment_usd='".$_REQUEST['initial_payment_usd']."',initial_payment_date='".$GLOBALS['timedate']->to_db_date($_REQUEST['initial_payment_date'],false)."',te_pr_programs_id_c='".$_REQUEST['te_pr_programs_te_ba_batch_1te_pr_programs_ida']."',te_in_institutes_id_c='".$_REQUEST['te_in_institutes_te_ba_batch_1te_in_institutes_ida']."',total_session_required='".$_REQUEST['total_sessions_planned']."' WHERE te_ba_batch_id_c='".$_REQUEST['record']."'";
			$GLOBALS['db']->query($studentBatchSql);
			
			$batchSql="SELECT sb.id as student_batch_id,spp.id as plan_id FROM `te_student_batch` sb INNER JOIN te_student_batch_te_student_payment_plan_1_c sbr ON sb.id=sbr.te_student_batch_te_student_payment_plan_1te_student_batch_ida INNER JOIN te_student_payment_plan spp ON sbr.te_student9d1ant_plan_idb=spp.id WHERE sb.deleted=0 AND sb.te_ba_batch_id_c='".$_REQUEST['record']."' AND spp.deleted=0 ORDER BY sb.id";
		
			$batchObj= $GLOBALS['db']->query($batchSql);
			$planids=array();
			while($batch = $GLOBALS['db']->fetchByAssoc($batchObj)){
				if($batch['name']=="Initial Payment"){
					$GLOBALS['db']->query("UPDATE te_student_payment_plan SET due_date='".$bean->initial_payment_date."' WHERE id='".$batch['plan_id']."' AND name='Initial Payment'");
				}else{
					$planids[]=$batch['plan_id'];
				}			
			}
			
			$installments=array('1'=>'1st','2'=>'2nd','3'=>'3rd','4'=>'4th','5'=>'5th','6'=>'6th','7'=>'7th');	
			for($x=1;$x<=$_REQUEST['installment'];$x++){
				$due_date_index="due_date_".$x;
				for($y=0;$y<count($planids);$y++){
					$GLOBALS['db']->query("UPDATE te_student_payment_plan SET due_date='".$GLOBALS['timedate']->to_db_date($_REQUEST[$due_date_index],false)."' WHERE id='".$planids[$y]."' AND name='".$installments[$x]." Installment'");
				}
				
			}		
		}
	}
}
