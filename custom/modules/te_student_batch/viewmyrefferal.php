<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

ini_set('memory_limit','1024M');
require_once('include/entryPoint.php');
	require_once('custom/modules/Leads/customfunctionforcrm.php');
global $db,$current_user;
$currentUserId = $current_user->id;
//~ echo "<pre>";
$reportingUserIds = array();
$reportUserObj = new customfunctionforcrm();
$reportUserObj->reportingUser($currentUserId);
$reportUserObj->report_to_id[$currentUserId] = $current_user->name;
$reportingUserIds = $reportUserObj->report_to_id;


$SQL = "SELECT l.id as lid,  CONCAT(ifnull(l.first_name,''),' ',ifnull(l.last_name,''))  as name, l.phone_mobile,e.email_address,l.status,CONCAT(ifnull(u.first_name,''),' ',ifnull(u.last_name,'')) as counselor,b.id batch_id, b.name as batch_name, p.name as prog_name,i.name as insti_name,l.parent_type,l.parent_id, CONCAT(ifnull(lr.first_name,''),' ',ifnull(lr.last_name,''))  as rname, CONCAT(ifnull(ur.first_name,''),' ',ifnull(ur.last_name,'')) as rcounselor FROM leads l 
		LEFT JOIN leads_cstm lc ON l.id =lc.id_c 
		LEFT JOIN email_addr_bean_rel er ON er.bean_id = l.id AND er.bean_module ='Leads' 
		INNER JOIN email_addresses e ON e.id =  er.email_address_id 
		LEFT JOIN te_utm ON l.utm = te_utm.name LEFT JOIN te_ba_batch b ON b.id = CASE WHEN l.utm =  'NA' THEN lc.te_ba_batch_id_c WHEN l.utm !=  'NA' THEN te_utm.te_ba_batch_id_c END
		LEFT JOIN te_pr_programs_te_ba_batch_1_c  pb ON b.id = pb.te_pr_programs_te_ba_batch_1te_ba_batch_idb  
		LEFT JOIN te_pr_programs p ON p.id = pb.te_pr_programs_te_ba_batch_1te_pr_programs_ida
		LEFT JOIN te_in_institutes_te_ba_batch_1_c ib ON b.id=ib.te_in_institutes_te_ba_batch_1te_ba_batch_idb
		LEFT JOIN te_in_institutes i ON i.id = ib.te_in_institutes_te_ba_batch_1te_in_institutes_ida
		LEFT JOIN users u ON u.id = l.assigned_user_id
		LEFT JOIN users ur ON l.parent_id = ur.id
		LEFT JOIN leads lr ON l.parent_id = lr.id
		";

$where = '';

$where .= " WHERE l.deleted =0 AND pb.deleted =0 AND ib.deleted=0 AND i.deleted = 0 AND b.deleted =0 AND p.deleted =0 ";
$where  .= " AND l.parent_type IS NOT NULL AND (l.parent_id IN ('";
$where  .= implode("', '", array_keys($reportingUserIds));
$where  .= "') OR (l.created_by IN ('";
$where  .= implode("', '", array_keys($reportingUserIds));
$where  .= "')))";
$sql = $SQL.$where;
//~ echo $sql;
$referrals = array();
$result = $db->query($sql);
if($db->getRowCount($result)>0){
		while($row = $db->fetchByAssoc($result)){
			$referrals[] = $row;
		}
}
					
//~ print_r($referrals);					
//~ echo "</pre>";
//~ die;
$sugarSmarty = new Sugar_Smarty();
$sugarSmarty->assign("referrals",$referrals);
$sugarSmarty->display('custom/modules/te_student_batch/tpls/viewmyrefferal.tpl');

?>
