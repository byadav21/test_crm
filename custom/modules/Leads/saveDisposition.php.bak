<?php

//~ print_r($_REQUEST);
if(isset($_REQUEST['disposition_id']) && !empty($_REQUEST['disposition_id'])){
	$disposition = new te_disposition();
	$disposition->disable_row_level_security=true;
	$disposition->retrieve($_REQUEST['disposition_id']);
	$disposition->status 	   = $_REQUEST['status'];
	$disposition->status_detail  = $_REQUEST['status_detail'];

	$disposition->description			 = $_REQUEST['description'];

	$disposition->date_of_callback			 = $_REQUEST['callback'];
	$disposition->date_of_followup			 = $_REQUEST['followup'];
	$disposition->date_of_prospect			 = $_REQUEST['prospect'];
	$disposition->name 		   	 = $_REQUEST['status'];
	//~ $disposition->unique_call_id 		   	 = $_REQUEST['call_id'];
	//~ $disposition->te_disposition_leadsleads_ida 		   	 = $_REQUEST['lead_id'];
	$disposition->save();
	echo "1";
}
else{
	echo "Disposition Id and Status should not empty";	
}
?>
