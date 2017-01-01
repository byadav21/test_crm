<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
class updateStatusClass{
	
	function updateStatusFunc($bean, $event, $argument){
		$sa = "UPDATE te_disposition SET name='".$bean->status."' WHERE id='".$bean->id."'";
		//~ die;
		$GLOBALS['db']->query($sa);
		$GLOBALS['log']->fatal('Request - '.print_r($_REQUEST,true));
		if(empty($bean->fetched_row['id']) && !empty($bean->te_disposition_leadsleads_ida)){
			//~ $sql = "UPDATE leads SET status='".$bean->status."',status_detail='".$bean->status_description."',note='".$bean->description."' WHERE id ='".$bean->te_disposition_leadsleads_ida."'";
			//~ $GLOBALS['db']->query($sql);
		}
		$ss = "SELECT te_disposition_leadsleads_ida FROM te_disposition_leads_c WHERE te_disposition_leadste_disposition_idb = '".$bean->id."' AND deleted =0";
		$rr = $GLOBALS['db']->query($ss);
		if($GLOBALS['db']->getRowCount($rr)>0){
			$ll = $GLOBALS['db']->fetchByAssoc($rr);
			$sql = "UPDATE leads SET status='".$bean->status."',status_description='".$bean->status_detail."',note='".$bean->description."',date_of_callback = '".$bean->date_of_callback."',date_of_followup='".$bean->date_of_followup."',date_of_prospect = '".$bean->date_of_prospect."' WHERE id ='".$ll['te_disposition_leadsleads_ida']."'";
			$GLOBALS['db']->query($sql);
			
		}
		
	}
	
	function showDates($bean, $event, $argument){
		
		$ss = "SELECT * FROM te_disposition WHERE id = '".$bean->id."' AND deleted =0";
		//~ echo $ss;die;
		$rr = $GLOBALS['db']->query($ss);
		$ll = $GLOBALS['db']->fetchByAssoc($rr);
		if($bean->status_detail=='Follow Up'){
			$bean->date_of_callback = $GLOBALS['timedate']->to_display_date_time($ll['date_of_followup']);
		}
		elseif($bean->status_detail=='Prospect'){
			$bean->date_of_callback = $GLOBALS['timedate']->to_display_date_time($ll['date_of_prospect']);
		}
		
		
	}
	
	
	
}


