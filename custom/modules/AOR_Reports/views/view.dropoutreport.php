<?php
if (!defined('sugarEntry') || !sugarEntry)
	die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php'); 
class AOR_ReportsViewDropoutreport extends SugarView {
	
	
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
	//	$user_id=$current_user->id;
		//$this->report_to_id[]=$user_id;
		//$users = $this->reportingUser($user_id);
		#Get lead status drop down option
		//$leadStatusList=$GLOBALS['app_list_strings']['lead_status_dom'];
		#Get batch drop down option
		$batchList=$this->getBatch();
		#print_r($users);
		#print_r($this->report_to_id);die;
		//$uid=$this->report_to_id;# list of user ids

		# Query for batch drop down options
		$where="";
		
			if(!empty($_POST['batch'])){	
				$where.=" AND b.id IN('".implode("','",$_POST['batch'])."') ";
			}
			
				
		
		$leadSql="SELECT b.name AS batch,s.name AS student,s.email AS email,s.mobile AS mobile,leads.primary_address_city,leads.primary_address_state,leads_cstm.education_c,leads_cstm.work_experience_c FROM te_student AS s INNER JOIN te_student_te_student_batch_1_c AS ssb ON s.id=ssb.te_student_te_student_batch_1te_student_ida INNER JOIN te_student_batch AS sb ON sb.id=ssb.te_student_te_student_batch_1te_student_batch_idb INNER JOIN te_ba_batch as b ON b.id=sb.te_ba_batch_id_c LEFT JOIN leads ON leads.id=sb.leads_id LEFT JOIN leads_cstm ON leads_cstm.id_c=leads.id WHERE s.deleted=0 AND sb.deleted=0 AND sb.status='Dropout' ".$where."";
		
		$leadObj =$db->query($leadSql);
		$councelorList=array();
		while($row =$db->fetchByAssoc($leadObj)){
			$councelorList[]=$row;
							
		}		
		$sugarSmarty = new Sugar_Smarty();
		$sugarSmarty->assign("councelorList",$councelorList);
		$sugarSmarty->assign("batchList",$batchList);
	
		$sugarSmarty->display('custom/modules/AOR_Reports/tpls/dropoutreport.tpl');
	}
}
?>
