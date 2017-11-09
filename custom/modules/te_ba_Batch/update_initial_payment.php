	<?php
	if (!defined('sugarEntry') || !sugarEntry)
		die('Not A Valid Entry Point');

	class UpdateInitialPyment {
		function updatePayment(&$bean, $event, $arguments) {
			$bean->no_of_installments=isset($_REQUEST['installment'])? $_REQUEST['installment']: '';
			$bean->initial_payment_inr= isset($_REQUEST['initial_payment_inr'])? $_REQUEST['initial_payment_inr']: '';
			$bean->initial_payment_usd= isset($_REQUEST['initial_payment_usd'])? $_REQUEST['initial_payment_usd']: '';
			$bean->initial_payment_date=$GLOBALS['timedate']->to_db_date((isset($_REQUEST['initial_payment_date'])? $_REQUEST['initial_payment_date']: ''),false);

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
			/* # Web Api For Web site */

		/*	# -> While add New Batch */
			$batch_start_date = date('d/m/Y',strtotime($bean->batch_start_date));
			$registration_closing_date = date('d/m/Y',strtotime($bean->registration_closing_date));
			$feearray=array();
				for($x=1;$x<=$bean->no_of_installments;$x++){
				$inr_index="payment_inr_".$x;
				$usd_index="payment_usd_".$x;
				$due_date_index="due_date_".$x;
						$fee1=$_REQUEST[$inr_index].",".$_REQUEST[$usd_index].",".date('d/m/Y',strtotime($_REQUEST[$due_date_index]));
						$feearray[]=$fee1;
						}

						$fee_detail = implode("|",$feearray);

					if($bean->is_sent_web=="0"){

					/*$feeinr=$bean->initial_payment_inr.",".$bean->initial_payment_usd.",".$bean->initial_payment_date."|";
					//feeusd=$bean->initial_payment_usd.",".$bean->initial_payment_usd.",".$bean->initial_payment_date; */

					$user = 'talentedgeadmin';
					$password = 'Inkoniq@2016';
					  #$url='http://talentedgewpe.wpengine.com/tecourse-api/';
					$url = 'http://talentedge.staging.wpengine.com/tecourse-api/';
					$headers = array(
						'Authorization: Basic '. base64_encode("$user:$password")
					);
					$post = [
						'action'=> 'add',
						'batch_crmid'   =>$bean->id,
						'pname' =>$bean->name,
						'course_type'=>'1',
						'batchID'=>$bean->batch_code,
						'pexcerpt'=>'1',
						'inst_crm_id'=>$bean->te_in_institutes_te_ba_batch_1te_in_institutes_ida,
						'programme_crmid'=>$bean->te_pr_programs_te_ba_batch_1te_pr_programs_ida,
						'batch_start_date'=>$batch_start_date,
						'duration'=>$bean->duration,
						'fees_inr'=>$bean->fees_inr,
						'fees_usd'=>$bean->fees_in_usd,
						'discount_inr'=>$bean->discount_in_inr,
						'discount_usd'=>$bean->discount_in_usd,
						'batch_status'=>$bean->batch_status,
						'last_date_to_register'=>$registration_closing_date,
						'installment_detail'=>$fee_detail,
					];

					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL,$url);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
					$result = curl_exec($ch);
					$res = json_decode($result);
					$bean->is_sent_web="1";
					if(isset($res[0]->status) && $res[0]->status=='1'){
						$bean->is_sent_web="1";
						$bean->web_batch_id=$res[0]->course_id;
						#echo "hello insert";
					}

					curl_close($ch);

		}

		else{
			/* Web api while update batch Record */ 

			$user = 'talentedgeadmin';
					$password = 'Inkoniq@2016';
					$url = 'http://talentedge.staging.wpengine.com/tecourse-api/';
					$headers = array(
						'Authorization: Basic '. base64_encode("$user:$password")
					);
					$post = [
						'action'=> 'update',
						'batch_crmid'   =>$bean->id,
						'pname' =>$bean->name,
						'course_type'=>'1',
						'batchID'=>$bean->batch_code,
						'pexcerpt'=>'1',
						'inst_crm_id'=>$bean->te_in_institutes_te_ba_batch_1te_in_institutes_ida,
						'programme_crmid'=>$bean->te_pr_programs_te_ba_batch_1te_pr_programs_ida,
						'batch_start_date'=>$batch_start_date,
						'duration'=>$bean->duration,
						'fees_inr'=>$bean->fees_inr,
						'fees_usd'=>$bean->fees_in_usd,
						'discount_inr'=>$bean->discount_in_inr,
						'discount_usd'=>$bean->discount_in_usd,
						'batch_status'=>$bean->batch_status,
						'last_date_to_register'=>$registration_closing_date,
						'installment_detail'=>$fee_detail,
					];

					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL,$url);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
					$result = curl_exec($ch);
					$res = json_decode($result);
					if(isset($res[0]->status) && $res[0]->status=='1'){
						$bean->is_sent_web="1";
						$bean->web_batch_id=$res[0]->course_id;
						//echo $res[0]->course_id;
						#echo "hello update";

					}

					curl_close($ch);

			}


		   # End

		}
	}
