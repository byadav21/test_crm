<?php
ini_set("display_errors",0);
/*
			Getting the leave template
*/


		class customfunctionforcrm
		{
			var $report_to_id;
			var $report_to_id1;
			
			
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
				
				$statusWiseCount = '<h2>Status Wise Count</h2><table style="width:100%"><tr><td>&nbsp;</td><td>&nbsp;</td></tr>';
//New Leads		
				$sqlCount = "SELECT status_description,count(*) as count FROM leads WHERE deleted =0 AND status_description LIKE 'New Lead'  AND leads.assigned_user_id IN ('".$user_ids."')"; 
				
				$resCount = $GLOBALS['db']->query($sqlCount);
				$rowCount= $GLOBALS['db']->fetchByAssoc($resCount);						
				if($rowCount['count'] > 0){
					$statusWiseCount .= '
					<table width="50%" border="1" bordercolor="#fff" cellpadding="0" style="float:left;  cellpadding="5" cellspacing="5">
				  <tr> <th align="center" style="padding:5px; color:#fff; font-size:18px;">'.$rowCount['count'].'</th></tr>
				 <tr> <td align="center"style="padding:5px;"><a  style="color:#fff;" href="index.php?module=Leads&searchFormTab=basic_search&query=true&status_description_basic='.$rowCount['status_description'].'">'.$rowCount['status_description'].'</a></td></tr>
					 </table>';
					
				}
				else{
					$statusWiseCount .= '
					<table width="50%" border="1" bordercolor="#fff" cellpadding="0" style="float:left;  cellpadding="5" cellspacing="5">
				  <tr> <th align="center" style="padding:5px; color:#fff; font-size:18px;">0</th></tr>
				 <tr> <td align="center"style="padding:5px;"><a style="color:#fff;" >New Lead</a></td></tr>
					 </table>';
				}

//Duplicate		
				$sqlDup = "SELECT status_description,count(*) as count FROM leads WHERE deleted =0 AND status_description LIKE 'Duplicate'  AND is_seen=0 AND leads.assigned_user_id IN ('".$user_ids."')"; 
				$resDup = $GLOBALS['db']->query($sqlDup);
				$rowDup= $GLOBALS['db']->fetchByAssoc($resDup);			
				if($rowDup['count'] > 0){
					$statusWiseCount .= '
					<table width="50%" border="1" bordercolor="#fff" cellpadding="0" style="float:left;  cellpadding="5" cellspacing="5">
				  <tr> <th align="center" style="padding:5px; color:#fff; font-size:18px;">'.$rowDup['count'].'</th></tr>
				 <tr> <td align="center"style="padding:5px;"><a style="color:#fff;" href="index.php?module=Leads&searchFormTab=basic_search&query=true&status_description_basic='.$rowDup['status_description'].'">'.$rowDup['status_description'].'</a></td></tr>
					 </table>';
					
				}
				else{
					$stat = 'Duplicate';
					$statusWiseCount .= '
					<table width="50%" border="1" bordercolor="#fff" cellpadding="0" style="float:left;  cellpadding="5" cellspacing="5">
				  <tr> <th align="center" style="padding:5px; color:#fff; font-size:18px;">0</th></tr>
				 <tr> <td align="center"style="padding:5px;"><a style="color:#fff;" >Duplicate</a></td></tr>
					 </table>';
				}




// Prospect Today
		//~ echo date('Y-m-d');
            $sqlPros = "SELECT count(*) as count FROM leads  WHERE deleted =0 AND status_description LIKE 'Prospect' AND DATE(date_of_prospect) = '".date('Y-m-d')."' AND leads.assigned_user_id IN ('".$user_ids."')"; 
            
            //~ echo $sqlPros;
            $resPros = $GLOBALS['db']->query($sqlPros);
            $rowPros= $GLOBALS['db']->fetchByAssoc($resPros);
			if($rowPros['count'] > 0){
				$statusWiseCount .= '<table width="50%" border="1" bordercolor="#fff" cellpadding="0" style="float:left;  cellpadding="5" cellspacing="5">
				  <tr> <th align="center" style="padding:5px; color:#fff; font-size:18px;">'.$rowPros['count'].'</th></tr>
				 <tr> <td align="center"style="padding:5px;"><a style="color:#fff;" href="index.php?module=Leads&searchFormTab=basic_search&query=true&pros_today=1&status_description_basic=Prospect">Prospect Today</a></td></tr>
					 </table>';
					
				}
				else{
					$stat = 'Duplicate';
					$statusWiseCount .= '<table width="50%" border="1" bordercolor="#fff" cellpadding="0" style="float:left;  cellpadding="5" cellspacing="5">
				  <tr> <th align="center" style="padding:5px; color:#fff; font-size:18px;">0</th></tr>
				 <tr> <td align="center"style="padding:5px;"><a style="color:#fff;" >Prospect Today</a></td></tr>
					 </table>';
				}




// Followup Today

            $sqlFoll = "SELECT count(*) as count FROM leads  WHERE deleted =0 AND status_description LIKE 'Follow Up' AND DATE(date_of_followup) = '".date('Y-m-d')."' AND leads.assigned_user_id IN ('".$user_ids."')"; 
            $resFoll = $GLOBALS['db']->query($sqlFoll);
            $rowFoll= $GLOBALS['db']->fetchByAssoc($resFoll);
			if($rowFoll['count'] > 0){
				$statusWiseCount .= '<table width="50%" border="1" bordercolor="#fff" cellpadding="0" style="float:left;  cellpadding="5" cellspacing="5">
				  <tr> <th align="center" style="padding:5px; color:#fff; font-size:18px;">'.$rowFoll['count'].'</th></tr>
				 <tr> <td align="center"style="padding:5px;"><a style="color:#fff;" href="index.php?module=Leads&searchFormTab=basic_search&query=true&follow_today=1&status_description_basic=Follow Up">Followup Today</a></td></tr>
					 </table>';
					
				}
				else{
					$stat = 'Duplicate';
					$statusWiseCount .= '<table width="50%" border="1" bordercolor="#fff" cellpadding="0" style="float:left;  cellpadding="5" cellspacing="5">
				  <tr> <th align="center" style="padding:5px; color:#fff; font-size:18px;">0</th></tr>
				 <tr> <td align="center"style="padding:5px;"><a style="color:#fff;" >Followup Today</a></td></tr>
					 </table>';
				}

//Over Due Prospect

            $sqlPros = "SELECT count(*) as count FROM leads  WHERE deleted =0 AND status_description LIKE 'Prospect' AND DATE(date_of_prospect) < '".date('Y-m-d')."' AND leads.assigned_user_id IN ('".$user_ids."')"; 
            //~ echo $sqlPros;
            $resPros = $GLOBALS['db']->query($sqlPros);
            $rowPros= $GLOBALS['db']->fetchByAssoc($resPros);
			if($rowPros['count'] > 0){
				$statusWiseCount .= '<table width="50%" border="1" bordercolor="#fff" cellpadding="0" style="float:left;  cellpadding="5" cellspacing="5">
				  <tr> <th align="center" style="padding:5px; color:#fff; font-size:18px;">'.$rowPros['count'].'</th></tr>
				 <tr> <td align="center"style="padding:5px;"><a style="color:#fff;" href="index.php?module=Leads&searchFormTab=basic_search&query=true&over_due_pros=pros&status_description_basic=Prospect">Over Due Prospect</a></td></tr>
					 </table>';
					
				}
				else{
					$stat = 'Duplicate';
					$statusWiseCount .= '<table width="50%" border="1" bordercolor="#fff" cellpadding="0" style="float:left;  cellpadding="5" cellspacing="5">
				  <tr> <th align="center" style="padding:5px; color:#fff; font-size:18px;">0</th></tr>
				 <tr> <td align="center"style="padding:5px;"><a style="color:#fff;" >Over Due Prospect</a></td></tr>
					 </table>';
				}


//Overdue followups

            $sqlFoll = "SELECT count(*) as count FROM leads  WHERE deleted =0 AND status_description LIKE 'Follow Up' AND DATE(date_of_followup) < '".date('Y-m-d')."' AND leads.assigned_user_id IN ('".$user_ids."')"; 
            //~ echo $sqlFoll;
            $resFoll = $GLOBALS['db']->query($sqlFoll);
            $rowFoll= $GLOBALS['db']->fetchByAssoc($resFoll);
			if($rowFoll['count'] > 0){
				$statusWiseCount .= '<table width="50%" border="1" bordercolor="#fff" cellpadding="0" style="float:left;  cellpadding="5" cellspacing="5">
				  <tr> <th align="center" style="padding:5px; color:#fff; font-size:18px;">'.$rowFoll['count'].'</th></tr>
				 <tr> <td align="center"style="padding:5px;"><a style="color:#fff;" href="index.php?module=Leads&searchFormTab=basic_search&query=true&due_followup=follow&status_description_basic=Follow Up">Overdue followups</a></td></tr>
					 </table>';
					
				}
				else{
					$stat = 'Duplicate';
					$statusWiseCount .= '<table width="50%" border="1" bordercolor="#fff" cellpadding="0" style="float:left;  cellpadding="5" cellspacing="5">
				  <tr> <th align="center" style="padding:5px; color:#fff; font-size:18px;">0</th></tr>
				 <tr> <td align="center"style="padding:5px;"><a style="color:#fff;" >Overdue followups</a></td></tr>
					 </table>';
				}


//CallBack Today
		   $sqlFoll = "SELECT count(*) as count FROM leads  WHERE deleted =0 AND status_description LIKE 'Call Back' AND DATE(date_of_callback) = '".date('Y-m-d')."' AND leads.assigned_user_id IN ('".$user_ids."')"; 
            $resFoll = $GLOBALS['db']->query($sqlFoll);
            $rowFoll= $GLOBALS['db']->fetchByAssoc($resFoll);
			if($rowFoll['count'] > 0){
				$statusWiseCount .= '<table width="50%" border="1" bordercolor="#fff" cellpadding="0" style="float:left;  cellpadding="5" cellspacing="5">
				  <tr> <th align="center" style="padding:5px; color:#fff; font-size:18px;">'.$rowFoll['count'].'</th></tr>
				 <tr> <td align="center"style="padding:5px;"><a style="color:#fff;" href="index.php?module=Leads&searchFormTab=basic_search&query=true&call_today=1&status_description_basic=Call Back">CallBack Today</a></td></tr>
					 </table>';
					
				}
				else{
					$stat = 'Duplicate';
					$statusWiseCount .= '<table width="50%" border="1" bordercolor="#fff" cellpadding="0" style="float:left;  cellpadding="5" cellspacing="5">
				  <tr> <th align="center" style="padding:5px; color:#fff; font-size:18px;">0</th></tr>
				 <tr> <td align="center"style="padding:5px;"><a style="color:#fff;" >CallBack Today</a></td></tr>
					 </table>';
				}


// Overdue CallBack


            $sqlFoll = "SELECT count(*) as count FROM leads  WHERE deleted =0 AND status_description LIKE 'Call Back' AND DATE(date_of_callback) < '".date('Y-m-d')."' AND leads.assigned_user_id IN ('".$user_ids."')"; 
            //~ echo $sqlFoll;
            $resFoll = $GLOBALS['db']->query($sqlFoll);
            $rowFoll= $GLOBALS['db']->fetchByAssoc($resFoll);
			if($rowFoll['count'] > 0){
				$statusWiseCount .= '<table width="50%" border="1" bordercolor="#fff" cellpadding="0" style="float:left;  cellpadding="5" cellspacing="5">
				  <tr> <th align="center" style="padding:5px; color:#fff; font-size:18px;">'.$rowFoll['count'].'</th></tr>
				 <tr> <td align="center"style="padding:5px;"><a style="color:#fff;" href="index.php?module=Leads&searchFormTab=basic_search&query=true&call_back_due=due&status_description_basic=Call Back">Overdue CallBack</a></td></tr>
					 </table>';
					
				}
				else{
					$stat = 'Duplicate';
					$statusWiseCount .= '<table width="50%" border="1" bordercolor="#fff" cellpadding="0" style="float:left;  cellpadding="5" cellspacing="5">
				  <tr> <th align="center" style="padding:5px; color:#fff; font-size:18px;">0</th></tr>
				 <tr> <td align="center"style="padding:5px;"><a style="color:#fff;" >Overdue CallBack</a></td></tr>
					 </table>';
				}


// Payment Not Realized
			//~ $payNR = "SELECT DISTINCT leads_te_payment_details_1leads_ida FROM leads_te_payment_details_1_c WHERE deleted = 0";
            $sqlPay = "SELECT count(id) as not_realized FROM leads  WHERE deleted =0 AND payment_realized_check = 0 AND leads.assigned_user_id  IN ('".$user_ids."') AND leads.id IN (SELECT DISTINCT leads_te_payment_details_1leads_ida FROM leads_te_payment_details_1_c WHERE deleted = 0)";
            $resPay = $GLOBALS['db']->query($sqlPay);
            $rowPay= $GLOBALS['db']->fetchByAssoc($resPay);
			if($rowPay['not_realized'] > 0){
				$statusWiseCount .= '<table width="50%" border="1" bordercolor="#fff" cellpadding="0" style="float:left;  cellpadding="5" cellspacing="5">
				  <tr> <th align="center" style="padding:5px; color:#fff; font-size:18px;">'.$rowPay['not_realized'].'</th></tr>
				 <tr> <td align="center"style="padding:5px;"><a style="color:#fff;" href="index.php?module=Leads&searchFormTab=basic_search&query=true&payment_realized_check_basic=0">Payment Not Realized</a></td></tr>
					 </table>';
					
				}
				else{
					$stat = 'Duplicate';
					$statusWiseCount .= '<table width="50%" border="1" bordercolor="#fff" cellpadding="0" style="float:left;  cellpadding="5" cellspacing="5">
				  <tr> <th align="center" style="padding:5px; color:#fff; font-size:18px;">0</th></tr>
				 <tr> <td align="center"style="padding:5px;"><a style="color:#fff;" >Payment Not Realized</a></td></tr>
					 </table>';
				}




				
				$statusWiseCount .= '<tr><td>&nbsp;</td><td>&nbsp;</td></tr></table>';	
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
						$this->reportingUser($record->id);
					}
				}
			}
		}
		
		
		
		
		
		
	}//Class End 
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
