<?php
ini_set("display_errors",0);
/*
			Getting the leave template
*/


		class customfunctionforcrm
		{
			var $report_to_id;
			var $report_to_id1;
			var $report_to_id_transfer;


			function statusWiseCounts(){

				//~ require_once('custom/modules/Leads/customfunctionforcrm.php');
				date_default_timezone_set("Asia/Kolkata");
				global $current_user;
				$currentUserId = $current_user->id;
				$reportingUserIds = array();
				//~ $reportUserObj1 = new customfunctionforcrm();
				$this->reportingUser($currentUserId);
				$this->report_to_id[$currentUserId] = $current_user->name;
				$reportingUserIds = $this->report_to_id;

				$user_ids = implode("', '", array_keys($reportingUserIds));

				$statusWiseCount = '';
//New Leads
				$sqlCount = "SELECT status_description,count(id) as count FROM leads WHERE deleted =0 AND status_description LIKE 'New Lead'  AND leads.assigned_user_id IN ('".$user_ids."')";

				$statusWiseCount .= ' <style>.tile_count .tile_stats_count {width: 12%!important;}@media (max-width: 1024px) and (min-width: 979px) .col-sm-3.tile_stats_count { max-width: 242px !important; }</style>';

				$resCount = $GLOBALS['db']->query($sqlCount);
				$rowCount= $GLOBALS['db']->fetchByAssoc($resCount);
				if($rowCount['count'] > 0){

					 $statusWiseCount .= '<div class="col-xs-6 col-sm-3 tile_stats_count">
						<div class="count">'.$rowCount['count'].'</div>
						<span class="count_top">  <a   href="index.php?module=Leads&searchFormTab=basic_search&query=true&status_description_basic='.$rowCount['status_description'].'">'.$rowCount['status_description'].'</a></span>

					</div>	';

				}
				else{


					$statusWiseCount .= '<div class="col-xs-6 col-sm-3 tile_stats_count">
						<div class="count">0</div>
						<span class="count_top"> New Leads</span>

					</div>	';

				}

//Duplicate
				$sqlDup = "SELECT status_description,count(id) as count FROM leads WHERE deleted =0 AND status_description LIKE 'Duplicate'  AND leads.assigned_user_id IN ('".$user_ids."')";
				$resDup = $GLOBALS['db']->query($sqlDup);
				$rowDup= $GLOBALS['db']->fetchByAssoc($resDup);
				if($rowDup['count'] > 0){


					 $statusWiseCount .= '<div class="col-xs-6 col-sm-2 tile_stats_count">
					 <div class="count">'.$rowDup['count'].'</div>
						<span class="count_top"> <a  href="index.php?module=Leads&searchFormTab=basic_search&query=true&status_description_basic='.$rowDup['status_description'].'">'.$rowDup['status_description'].'</a>s</span>

					</div>	';

				}
				else{
					$stat = 'Duplicate';

					 $statusWiseCount .= '<div class="col-xs-6 col-sm-2 tile_stats_count">
						<div class="count">0</div>
						<span class="count_top"> Duplicate</span>

					</div>	';
				}




// Prospect Today
		//~ echo date('Y-m-d');
            $sqlPros = "SELECT count(id) as count FROM leads  WHERE deleted =0 AND status_description LIKE 'Prospect' AND DATE(date_of_prospect) = '".date('Y-m-d')."' AND leads.assigned_user_id IN ('".$user_ids."')";

            //~ echo $sqlPros;
            $resPros = $GLOBALS['db']->query($sqlPros);
            $rowPros= $GLOBALS['db']->fetchByAssoc($resPros);
			if($rowPros['count'] > 0){
				 ;

					$statusWiseCount .= '<div class="col-xs-6 col-sm-2 tile_stats_count">
					      <div class="count">'.$rowPros['count'].'</div>
						<span class="count_top"> <a  href="index.php?module=Leads&searchFormTab=basic_search&query=true&pros_today=1&status_description_basic=Prospect">Prospect Today</a></span>

					</div>	';

				}
				else{
					$stat = 'Duplicate';


					 $statusWiseCount .= '<div class="col-xs-6 col-sm-2 tile_stats_count">
					        <div class="count">0</div>
						<span class="count_top"> Prospect Today</span>

					</div>	';
				}




// Followup Today

            $sqlFoll = "SELECT count(id) as count FROM leads  WHERE deleted =0 AND status_description LIKE 'Follow Up' AND DATE(date_of_followup) = '".date('Y-m-d')."' AND leads.assigned_user_id IN ('".$user_ids."')";
            $resFoll = $GLOBALS['db']->query($sqlFoll);
            $rowFoll= $GLOBALS['db']->fetchByAssoc($resFoll);
			if($rowFoll['count'] > 0){


					  $statusWiseCount .= '<div class="col-xs-6 col-sm-2 tile_stats_count">
						<div class="count">'.$rowFoll['count'].'</div>
						<span class="count_top"> <a  href="index.php?module=Leads&searchFormTab=basic_search&query=true&follow_today=1&status_description_basic=Follow Up">Followup Today</a></span>

					</div>	';


				}
				else{
					$stat = 'Duplicate';

					 $statusWiseCount .= '<div class="col-xs-6 col-sm-2 tile_stats_count">
					    <div class="count">0</div>
						<span class="count_top"> Followup Today</span>

					</div>	';
				}

//Over Due Prospect

            $sqlPros = "SELECT count(id) as count FROM leads  WHERE deleted =0 AND status_description LIKE 'Prospect' AND DATE(date_of_prospect) < '".date('Y-m-d')."' AND leads.assigned_user_id IN ('".$user_ids."')";
            //~ echo $sqlPros;
            $resPros = $GLOBALS['db']->query($sqlPros);
            $rowPros= $GLOBALS['db']->fetchByAssoc($resPros);
			if($rowPros['count'] > 0){


					 $statusWiseCount .= '<div class="col-xs-6 col-sm-3 tile_stats_count">
							<div class="count">'.$rowPros['count'].'</div>
						<span class="count_top"> <a  href="index.php?module=Leads&searchFormTab=basic_search&query=true&over_due_pros=pros&status_description_basic=Prospect">Over Due Prospect</a></span>

					</div>	';

				}
				else{
					$stat = 'Duplicate';

					 $statusWiseCount .= '<div class="col-xs-6 col-sm-3 tile_stats_count">
					 <div class="count">0</div>
						<span class="count_top"> Over Due Prospect</span>

					</div>	';
				}


//Overdue followups

            $sqlFoll = "SELECT count(id) as count FROM leads  WHERE deleted =0 AND status_description LIKE 'Follow Up' AND DATE(date_of_followup) < '".date('Y-m-d')."' AND leads.assigned_user_id IN ('".$user_ids."')";
            //~ echo $sqlFoll;
            $resFoll = $GLOBALS['db']->query($sqlFoll);
            $rowFoll= $GLOBALS['db']->fetchByAssoc($resFoll);
			if($rowFoll['count'] > 0){

					   $statusWiseCount .= '<div class="col-xs-6 col-sm-3 tile_stats_count">
					   <div class="count">'.$rowFoll['count'].'</div>
						<span class="count_top"> <a  href="index.php?module=Leads&searchFormTab=basic_search&query=true&due_followup=follow&status_description_basic=Follow Up">Overdue followups</a></span>

					</div>	';

				}
				else{
					$stat = 'Duplicate';

					  $statusWiseCount .= '<div class="col-xs-6 col-sm-3 tile_stats_count">
					  <div class="count">0</div>
						<span class="count_top"> Overdue followups</span>

					</div>	';
				}


//CallBack Today
		   /*$sqlFoll = "SELECT count(id) as count FROM leads  WHERE deleted =0 AND status_description LIKE 'Call Back' AND DATE(date_of_callback) = '".date('Y-m-d')."' AND leads.assigned_user_id IN ('".$user_ids."')";
            $resFoll = $GLOBALS['db']->query($sqlFoll);
            $rowFoll= $GLOBALS['db']->fetchByAssoc($resFoll);
			if($rowFoll['count'] > 0){


					   $statusWiseCount .= '<div class="col-xs-6 col-sm-2 tile_stats_count">
					   <div class="count">'.$rowFoll['count'].'</div>
						<span class="count_top"> <a  href="index.php?module=Leads&searchFormTab=basic_search&query=true&call_today=1&status_description_basic=Call Back">CallBack Today</a></span>

					</div>	';

				}
				else{
					$stat = 'Duplicate';

					  $statusWiseCount .= '<div class="col-xs-6 col-sm-2 tile_stats_count">
					  <div class="count">0</div>
						<span class="count_top"> CallBack Today</span>

					</div>	';
				}*/


// Overdue CallBack


            /*$sqlFoll = "SELECT count(id) as count FROM leads  WHERE deleted =0 AND status_description LIKE 'Call Back' AND DATE(date_of_callback) < '".date('Y-m-d')."' AND leads.assigned_user_id IN ('".$user_ids."')";
            //~ echo $sqlFoll;
            $resFoll = $GLOBALS['db']->query($sqlFoll);
            $rowFoll= $GLOBALS['db']->fetchByAssoc($resFoll);
			if($rowFoll['count'] > 0){



					  $statusWiseCount .= '<div class="col-xs-6 col-sm-2 tile_stats_count">
					  <div class="count">'.$rowFoll['count'].'</div>
						<span class="count_top"> <a  href="index.php?module=Leads&searchFormTab=basic_search&query=true&call_back_due=due&status_description_basic=Call Back">Overdue CallBack</a></span>

					</div>	';

				}
				else{
					$stat = 'Duplicate';
					  $statusWiseCount .= '<div class="col-xs-6 col-sm-2 tile_stats_count">
					  <div class="count">0</div>
						<span class="count_top"> Overdue CallBack</span>

					</div>	';
				}*/


// Payment Not Realized
			//~ $payNR = "SELECT DISTINCT leads_te_payment_details_1leads_ida FROM leads_te_payment_details_1_c WHERE deleted = 0";
            $sqlPay = "SELECT count(id) as not_realized FROM leads  WHERE deleted =0 AND payment_realized_check = 0 AND leads.assigned_user_id  IN ('".$user_ids."') AND leads.id IN (SELECT DISTINCT leads_te_payment_details_1leads_ida FROM leads_te_payment_details_1_c WHERE deleted = 0)";
            $resPay = $GLOBALS['db']->query($sqlPay);
            $rowPay= $GLOBALS['db']->fetchByAssoc($resPay);
			if($rowPay['not_realized'] > 0){
		  $statusWiseCount .= '<div class="col-xs-4 col-sm-2 tile_stats_count">
					  <div class="count">'.$rowPay['not_realized'].'</div>
						<span class="count_top"> <a  href="index.php?module=Leads&searchFormTab=basic_search&query=true&payment_realized_check_basic=0">Payment Not Realized</a></span>

					</div>	';

				}
				else{
					$stat = 'Duplicate';


					   $statusWiseCount .= '<div class="col-xs-6 col-sm-2 tile_stats_count">
					   <div class="count">0</div>
						<span class="count_top"> Payment Not Realized</span>

					</div>	';
				}


# 1st Instalment Not Paid
			 //  $sqlPay = "SELECT count(id) as not_realized FROM leads  WHERE deleted =0 AND payment_realized_check = 0 AND leads.assigned_user_id  IN ('".$user_ids."') AND leads.id IN (SELECT DISTINCT leads_te_payment_details_1leads_ida FROM leads_te_payment_details_1_c WHERE deleted = 0)";
			$sqlPay="SELECT count(sb.id)total  FROM `te_student_batch` AS sb INNER JOIN leads AS l ON l.id=sb.leads_id INNER JOIN te_student_batch_te_student_payment_plan_1_c AS sppr ON sppr.te_student_batch_te_student_payment_plan_1te_student_batch_ida=sb.id INNER JOIN te_student_payment_plan AS spp ON spp.id=sppr.te_student9d1ant_plan_idb WHERE spp.name='1st Installment' AND sb.deleted=0 AND sb.status='Active' AND spp.deleted=0 AND l.assigned_user_id IN ('".$user_ids."') AND spp.due_date<=CURRENT_DATE AND (spp.balance_inr!=0 AND spp.balance_usd!=0)";
            $resPay = $GLOBALS['db']->query($sqlPay);
            $rowPay= $GLOBALS['db']->fetchByAssoc($resPay);
			if($rowPay['total'] > 0){
			//$users_lead = "'".implode("','", $leadList)."'";

				$statusWiseCount .= '<div class="col-xs-6 col-sm-3 tile_stats_count">
					   <div class="count">'. $rowPay['total'] .'</div>
						<span class="count_top"> <a  href="index.php?module=Leads&action=index&&searchFormTab=basic_search&query=true&lead_id=id_instalment"> Installment Not Paid</a></span>

					</div>';

				}
				else{
					$stat = 'Duplicate';

					$statusWiseCount .= '<div class="col-xs-6 col-sm-3 tile_stats_count">
					   <div class="count">0</div>
						<span class="count_top"> Installment Not Paid</span>

					</div>';

				}

				return 	$statusWiseCount;
			}


		/*
			recursively fetching all reporting user to the login user
			@@param : $currentUserId <=> the user id of current login user
		*/
		function reportingUser($currentUserId){

			$userObj = new User();
			$userObj->disable_row_level_security = true;
			$userList = $userObj->get_full_list("", "users.reports_to_id='".$currentUserId."'");

			if(!empty($userList)){

				foreach($userList as $record){

					if(!empty($record->reports_to_id)){

						$this->report_to_id[$record->id] = $record->name."(".$record->id.")";
						$this->report_to_id_transfer[$record->id] = $record->name;
						$this->reportingUser($record->id);
					}
				}
			}
		}






	}//Class End
