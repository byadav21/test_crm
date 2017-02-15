<?php
if(isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id'])){
	$sql = "SELECT d.*,l.id as lid, l.phone_mobile,l.first_name,l.last_name,lc.te_ba_batch_id_c as batch,b.name as bname,e.email_address FROM te_disposition d 
			INNER JOIN te_disposition_leads_c dl ON d.id = dl.te_disposition_leadste_disposition_idb 
			INNER JOIN leads l ON l.id = dl.te_disposition_leadsleads_ida 
			LEFT JOIN leads_cstm lc ON l.id=lc.id_c 
			LEFT JOIN email_addr_bean_rel el ON l.id = el.bean_id LEFT JOIN email_addresses e ON el.email_address_id = e.id
			LEFT JOIN te_ba_batch b ON lc.te_ba_batch_id_c = b.id
			WHERE d.deleted =0 AND dl.deleted =0 AND l.deleted=0 AND unique_call_id IS NOT NULL AND unique_call_id !='' AND d.status ='unsaved' AND unique_call_id NOT IN (SELECT unique_id FROM neox_call_details_update )";
	//~ echo $sql;
	$result = $GLOBALS['db']->query($sql);
	$data = "<table border='1' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>";
	$data .= "<tr><th><b>Status</b></th><th><b>Status Detail</b></th><th><b>Date</b></th><th><b>Leads</b></th>";
	$data .= "<th><b>Leads Mobile</b></th><th><b>Leads Email</b></th><th><b>Program</b></th><th><b>Batch</b></th><th><b>&nbsp;</b></th></tr>";
	if($GLOBALS['db']->getRowCount($result) >0){
		while($row = $GLOBALS['db']->fetchByAssoc($result)){
		$data .="<tr>";		
		$data .= "<td>".$row['status']."</td>";
		$data .= "<td>".$row['status_detail']."</td>";
		$sql_pro = "SELECT te_pr_programs_te_ba_batch_1te_pr_programs_ida,name FROM te_pr_programs p INNER JOIN te_pr_programs_te_ba_batch_1_c  pb ON p.id = pb.te_pr_programs_te_ba_batch_1te_pr_programs_ida WHERE te_pr_programs_te_ba_batch_1te_ba_batch_idb = '".$row['batch']."' AND pb.deleted = 0 AND p.deleted=0";
		$res_pro = $GLOBALS['db']->query($sql_pro);
		$pro = $GLOBALS['db']->fetchByAssoc($res_pro);
		$data .= "<td>".$row['date_of_callback']."</td>";
		$data .= "<td><a target='blank' href='index.php?action=DetailView&module=Leads&record={$row['lid']}'>".$row['first_name']." ".$row['last_name']."</a></td>";
		$data .= "<td>".$row['phone_mobile']."</td>";
		$data .= "<td>".$row['email_address']."</td>";
		$data .= "<td>".$pro['name']."</td>";
		$data .= "<td>".$row['bname']."</td>";
		$data .= '<td><button type="button" onclick="update_disposition_forrunning(\''.$row['id'].'\','.$row['phone_mobile'].')">Update</button></td></tr>';
		
		}
		
		$data .="</table>";
		echo $data;
	}
	else{
		echo "No Running Call";
	}
	
}
?>


