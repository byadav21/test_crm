<?php
if (!defined('sugarEntry') || !sugarEntry)
	die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');
class AOR_ReportsViewReferalleads extends SugarView {


	public function __construct() {
		parent::SugarView();
	}
	function reportingUser($currentUserId){
		$userObj = new User();
		$userObj->disable_row_level_security = true;
		$userList = $userObj->get_full_list("", "users.reports_to_id='".$currentUserId."'");
		if(!empty($userList)){
			foreach($userList as $record){
				if(!empty($record->reports_to_id) && !empty($record->id)){
					$this->report_to_id[] = $record->id;
					$this->reportingUser($record->id);
				}
			}
		}
	}
	function getCouncelor($user_id){
		global $db;
		$userSql="SELECT CONCAT(first_name,' ',last_name) as name FROM users WHERE deleted=0 AND id='".$user_id."'";
		$userObj =$db->query($userSql);
		$user =$db->fetchByAssoc($userObj);
		return $user['name'];
	}

	function getBatch(){
		global $db;
		$batchSql="SELECT b.name,b.id FROM te_ba_batch AS b INNER JOIN te_student_batch AS sb WHERE b.id=sb.te_ba_batch_id_c GROUP BY b.id";
		$batchObj =$db->query($batchSql);
		$batchOptions=array();
		while($row =$db->fetchByAssoc($batchObj)){
			$batchOptions[]=$row;
		}
		return $batchOptions;
	}



	public function display() {
		global $sugar_config,$app_list_strings,$current_user,$db;
    $leadsData=array();
	  $user_id=$current_user->id;
		$this->report_to_id[]=$user_id;
		$users = $this->reportingUser($user_id);
		#Get batch drop down option
		$batchList=$this->getBatch();
		$srmrow =$db->query("SELECT user_id FROM `acl_roles_users` WHERE `role_id` IN('86800aa5-c8c2-5868-a690-58a88d188265') AND deleted=0");
		$srmArr=[];
		while($srmres =$db->fetchByAssoc($srmrow)){
		  $srmArr[]=$srmres['user_id'];
		}

		$uid=$this->report_to_id;# list of user ids
		$user_ids = "'" . implode("','", $uid) . "'";
		# Query for batch drop down options
		$where="";
		$selected_batch="";
			if(!empty($_POST['batch'])){
				$selected_batch=$_POST['batch'];
				$where.=" AND b.id IN('".implode("','",$_POST['batch'])."') ";
			}
			if(!empty($user_ids) && ($current_user->is_admin==0 && !in_array($current_user->id,$srmArr))){
				$where.=" AND (l.`parent_id` IN($user_ids) OR l.created_by IN($user_ids))";
			}

		# Query Fill $$ Manish Kumar
		$leadSql="select concat(u.first_name,' ',u.last_name) as name,b.name as batch,l.phone_mobile,l.parent_type AS refby,concat(u.first_name,' ',u.last_name) createdby,concat(ru.first_name,' ',ru.last_name)refru,concat(rl.first_name)refrl 
			from leads l inner join leads_cstm lc on l.id=lc.id_c  
			inner join te_ba_batch b on b.id=te_ba_batch_id_c
			LEFT JOIN users AS u ON u.id=l.`created_by` 
			LEFT JOIN users as ru ON ru.id=l.parent_id 
			LEFT JOIN leads AS rl ON rl.id=l.parent_id WHERE l.lead_source='Referrals' ".$where."";
		$leadObj =$db->query($leadSql);
		$councelorList=array();
		while($row =$db->fetchByAssoc($leadObj)){
			$councelorList[]=$row;

		}
		if(isset($_POST['export']) && $_POST['export']=="Export"){
			$data="Nane,Batch,Phone,Referral Person,Create By\n";
			$file = "refferal_report";
			$filename = $file . "_" . date ( "Y-m-d");
			foreach($councelorList as $key=>$councelor){
				if($councelor['refby']=='Users'){
					$ref_person=$councelor['refru'];
				}

				else{
					$ref_person=$councelor['refrl'];
				}
				$data.= "\"" . $councelor['name'] . "\",\"" . $councelor['batch'] . "\",\"". $councelor['phone_mobile']. "\",\"". $ref_person. "\",\"". $councelor['createdby']. "\"\n";
			}
			ob_end_clean();
			header("Content-type: application/csv");
			header ('Content-disposition: attachment;filename=" '. $filename . '.csv";' );
			echo $data; exit;
		}
		$sugarSmarty = new Sugar_Smarty();
		$sugarSmarty->assign("councelorList",$councelorList);
		$sugarSmarty->assign("batchList",$batchList);
		$sugarSmarty->assign("selected_batch",$selected_batch);
		$sugarSmarty->display('custom/modules/AOR_Reports/tpls/referallead.tpl');
	}
}
?>
