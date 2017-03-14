<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

ini_set('memory_limit','1024M');
require_once('include/entryPoint.php');
	require_once('custom/modules/Leads/customfunctionforcrm.php');
global $db,$current_user,$app_list_strings;
$currentUserId = $current_user->id;
$srExecutiveRole = '30957fe0-3494-e372-656d-58a9a6296516';
//~ echo "<pre>";
//~ print_r($_REQUEST);
//~ echo "</pre>";
$reportingUserIds = array();
$reportUserObj = new customfunctionforcrm();
$reportUserObj->reportingUser($currentUserId);
$reportUserObj->report_to_id[$currentUserId] = $current_user->name;
$reportingUserIds = $reportUserObj->report_to_id;


// Program List
	$sqlProg = "SELECT id,name FROM  te_pr_programs WHERE deleted = 0  ORDER BY name ASC";
	$resultP = $db->query($sqlProg);
	$selectedProgram = '';
	$program = array();
	while($rowp = $db->fetchByAssoc($resultP)){
		$program[$rowp['id']] = $rowp['name'];
	}

// Batch List
	$sqlBatch = "SELECT b.id,CONCAT(p.name,' - ',b.name) AS name FROM  te_ba_batch AS b INNER JOIN te_pr_programs_te_ba_batch_1_c AS pb ON pb.te_pr_programs_te_ba_batch_1te_ba_batch_idb=b.id INNER JOIN te_pr_programs AS p on p.id=pb.te_pr_programs_te_ba_batch_1te_pr_programs_ida WHERE b.deleted=0  AND p.deleted=0 ORDER BY name ASC";
	$resultB = $db->query($sqlBatch);
	$selectedBatch = '';
	$batch = array();
	while($rowb = $db->fetchByAssoc($resultB)){
		$batch[$rowb['id']] = $rowb['name'];
	}


// Status List
	$statusList = $app_list_strings['lead_status_custom_dom'];
	$selectedStatus = '';


// SRM List
	$sqlSRM = "SELECT u.id, CONCAT(ifnull(u.first_name,''),' ',ifnull(u.last_name,''))  as name FROM  acl_roles_users au
	INNER JOIN users u ON au.user_id = u.id  WHERE au.deleted = 0 AND au.role_id='".$srExecutiveRole."'
	  ORDER BY u.first_name ASC";
	$resultSRM = $db->query($sqlSRM);
	$selectedSRM = '';
	$srm = array();
	while($rowsrm = $db->fetchByAssoc($resultSRM)){
		$srm[$rowsrm['id']] = $rowsrm['name'];
	}
//~ print_r($srm);




$SQL = "SELECT distinct(l.id) as lid,  CONCAT(ifnull(l.first_name,''),' ',ifnull(l.last_name,''))  as name, l.phone_mobile,e.email_address,l.status,CONCAT(ifnull(u.first_name,''),' ',ifnull(u.last_name,'')) as counselor,b.id batch_id, b.name as batch_name, p.name as prog_name,i.name as insti_name,l.parent_type,l.parent_id, CONCAT(ifnull(lr.first_name,''),' ',ifnull(lr.last_name,''))  as rname, CONCAT(ifnull(ur.first_name,''),' ',ifnull(ur.last_name,'')) as rcounselor,  CONCAT(ifnull(usb.first_name,''),' ',ifnull(usb.last_name,''))  as srm,l.date_of_referral FROM leads l
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
		LEFT JOIN te_student_batch sb ON sb.leads_id = l.id
		LEFT JOIN users usb ON sb.assigned_user_id = usb.id
		";

$where = '';

//$where .= " WHERE l.deleted =0 AND l.lead_source='Referrals' AND pb.deleted =0 AND ib.deleted=0 AND i.deleted = 0 AND b.deleted =0 AND p.deleted =0 ";
$where .= " WHERE l.deleted =0 AND l.lead_source='Referrals'";
$where  .= " AND l.parent_type IS NOT NULL AND (l.parent_id IN ('";
$where  .= implode("', '", array_keys($reportingUserIds));
$where  .= "') OR (l.created_by IN ('";
$where  .= implode("', '", array_keys($reportingUserIds));
$where  .= "')))";


//Search The Referrals
if(isset($_REQUEST['searchreferral']) && $_REQUEST['searchreferral'] =='Search'){
		if(isset($_REQUEST['program']) && !empty($_REQUEST['program'])){
			$where  .= " AND p.id='".trim($_REQUEST['program'])."'";
			$selectedProgram = $_REQUEST['program'];
		}
		if(isset($_REQUEST['batch']) && !empty($_REQUEST['batch'])){
			$where  .= " AND b.id='".trim($_REQUEST['batch'])."'";
			$selectedBatch = $_REQUEST['batch'];
		}
		if(isset($_REQUEST['status']) && !empty($_REQUEST['status'])){
			$where  .= " AND l.status='".trim($_REQUEST['status'])."'";
			$selectedStatus = $_REQUEST['status'];
		}
		if(isset($_REQUEST['srm']) && !empty($_REQUEST['srm'])){
			$where  .= " AND usb.id='".trim($_REQUEST['srm'])."'";
			$selectedSRM = $_REQUEST['srm'];
		}
}

$sql = $SQL.$where;
$sql = $sql." ORDER BY l.date_of_referral DESC";
 //echo $sql;exit();
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
$sugarSmarty->assign("selectedProgram",$selectedProgram);
$sugarSmarty->assign("program",$program);
$sugarSmarty->assign("batch",$batch);
$sugarSmarty->assign("selectedBatch",$selectedBatch);
$sugarSmarty->assign("statusList",$statusList);
$sugarSmarty->assign("selectedStatus",$selectedStatus);
$sugarSmarty->assign("srm",$srm);
$sugarSmarty->assign("selectedSRM",$selectedSRM);

$sugarSmarty->assign("referrals",$referrals);
$sugarSmarty->display('custom/modules/te_student_batch/tpls/viewmyrefferal.tpl');

?>
