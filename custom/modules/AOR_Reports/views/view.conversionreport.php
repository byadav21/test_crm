<?php
if (!defined('sugarEntry') || !sugarEntry)
	die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');
class AOR_ReportsViewConversionreport extends SugarView {

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
	function getBatch(){
		global $db;
		$batchSql="SELECT id,name from te_ba_batch WHERE deleted=0 AND batch_status='enrollment_in_progress'";
		$batchObj =$db->query($batchSql);
		$batchOptions=array();
		while($row =$db->fetchByAssoc($batchObj)){
			$batchOptions[]=$row;
		}
		return $batchOptions;
	}
	function getCouncelor($user_id){
		global $db;
		$userSql="SELECT CONCAT(first_name,' ',last_name) as name FROM users WHERE deleted=0 AND id='".$user_id."'";
		$userObj =$db->query($userSql);
		$user =$db->fetchByAssoc($userObj);
		return $user['name'];
	}
	function getConvertedLead($user_id,$batch_id){
		global $db;
		$leadSql="SELECT count(l.id) as total FROM leads AS l INNER JOIN leads_cstm AS lc ON l.id=lc.id_c WHERE l.deleted=0 AND l.status='Converted' AND l.assigned_user_id='".$user_id."' AND lc.te_ba_batch_id_c='".$batch_id."'";
		$leadObj =$db->query($leadSql);
		$lead =$db->fetchByAssoc($leadObj);
		return $lead['total'];
	}

	public function display() {
		global $sugar_config,$app_list_strings,$current_user,$db;
        $leadsData=array();
		$user_id=$current_user->id;
		$this->report_to_id[]=$user_id;
		$users = $this->reportingUser($user_id);
		#Get batch drop down option
		$batchList=$this->getBatch();

		$uid=$this->report_to_id;# list of user ids

		# Query for batch drop down options
		$where="";
		$selected_status="";
		if(isset($_POST['button']) && $_POST['button']=="Search") {
			if($_POST['status']!=""){
				$selected_status=$_POST['status'];
			}
			if(!empty($_POST['batch'])){
				$where.=" AND lc.te_ba_batch_id_c IN('".implode("','",$_POST['batch'])."') ";
			}
		}elseif(isset($_POST['export']) && $_POST['export']=="Export"){

			$file = "conversion_report";
			$where='';
			$filename = $file . "_" . date ( "Y-m-d");

			if(!empty($_POST['batch'])){
				$where.=" AND lc.te_ba_batch_id_c IN('".implode("','",$_POST['batch'])."') ";
			}
			$leadSql="SELECT count(l.assigned_user_id) as total,l.assigned_user_id,lc.te_ba_batch_id_c as batch,bpr.te_pr_programs_te_ba_batch_1te_pr_programs_ida as program,p.name as program_name FROM leads l INNER JOIN leads_cstm lc ON l.id=lc.id_c INNER JOIN te_pr_programs_te_ba_batch_1_c bpr ON lc.te_ba_batch_id_c=bpr.te_pr_programs_te_ba_batch_1te_ba_batch_idb INNER JOIN te_pr_programs p ON bpr.te_pr_programs_te_ba_batch_1te_pr_programs_ida=p.id where l.deleted=0 AND l.assigned_user_id IN('".implode("','",$uid)."') ".$where." GROUP BY l.assigned_user_id,program";

			$leadObj =$db->query($leadSql);
			$councelorList=array();
			$programList=array();
			while($row =$db->fetchByAssoc($leadObj)){
				$programList[$row['program']]=$row['program_name'];
				//$councelorList[$row['assigned_user_id']][$row['program']]=$row['total'];
				$councelorList[$row['assigned_user_id']][$row['program']]=$this->getConvertedLead($row['assigned_user_id'],$row['batch']);
				$councelorList[$row['assigned_user_id']]['name']=$this->getCouncelor($row['assigned_user_id']);
			}
			foreach($councelorList as $key=>$councelor){
				foreach($programList as $key1=>$value){
					if(!isset($councelor[$key1]))
						$councelorList[$key][$key1]=0;
				}
			}
			# Create heading
			$data="Counsellors";
			foreach($programList as $key=>$program){
				$data.=",".$program;
			}
			$data.="\n";
			//$data.= "\"" . $councelor['name'] . "\",\"" . $councelor['warm'] . "\",\"" . $councelor['gsv']."\",\"". "\"\n";
			foreach($councelorList as $key=>$councelor){
				$data.= "\"" . $councelor['name'];
				foreach($programList as $key1=>$value){
					$data.= "\",\"" . $councelor[$key1];
				}
				$data.= "\"\n";
			}

			ob_end_clean();
			header("Content-type: application/csv");
			header ('Content-disposition: attachment;filename=" '. $filename . '.csv";' );
			echo $data; exit;
		}
		#$leadSql="SELECT count(assigned_user_id) as warm,assigned_user_id FROM leads  where status='Alive' AND assigned_user_id IN('".implode("','",$uid)."') ".$where." GROUP BY assigned_user_id";

		$leadSql="SELECT count(l.assigned_user_id) as total,l.assigned_user_id,lc.te_ba_batch_id_c as batch,bpr.te_pr_programs_te_ba_batch_1te_pr_programs_ida as program,p.name as program_name FROM leads l INNER JOIN leads_cstm lc ON l.id=lc.id_c INNER JOIN te_pr_programs_te_ba_batch_1_c bpr ON lc.te_ba_batch_id_c=bpr.te_pr_programs_te_ba_batch_1te_ba_batch_idb INNER JOIN te_pr_programs p ON bpr.te_pr_programs_te_ba_batch_1te_pr_programs_ida=p.id where l.deleted=0 AND l.assigned_user_id IN('".implode("','",$uid)."') ".$where." GROUP BY l.assigned_user_id,program";

		$leadObj =$db->query($leadSql);
		$councelorList=array();
		$programList=array();
		while($row =$db->fetchByAssoc($leadObj)){
			$programList[$row['program']]=$row['program_name'];
			//$councelorList[$row['assigned_user_id']][$row['program']]=$row['total'];
			$councelorList[$row['assigned_user_id']][$row['program']]=$this->getConvertedLead($row['assigned_user_id'],$row['batch']);
			$councelorList[$row['assigned_user_id']]['name']=$this->getCouncelor($row['assigned_user_id']);
		}
		foreach($councelorList as $key=>$councelor){
			foreach($programList as $key1=>$value){
				if(!isset($councelor[$key1]))
					$councelorList[$key][$key1]=0;
			}
		}
	#PS @Manish	
			$total=count($councelorList); #total records					
			$start=0;		
			$per_page=10;		
			$page=1;
			$pagenext=1;		
			$last_page=ceil($total/$per_page);		
					
			if(isset($_REQUEST['page'])&&$_REQUEST['page']>0){		
				$start=$per_page*($_REQUEST['page']-1);		
				$page=($_REQUEST['page']-1);
				$pagenext = ($_REQUEST['page']+1);
							
			}else{		
				
				$pagenext++;		
			}				
			if(($start+$per_page)<$total){					
				$right=1;		
			}else{		
				$right=0;		
			}		
			if(isset($_REQUEST['page'])&&$_REQUEST['page']==1){		
				$left=0;					
			}elseif(isset($_REQUEST['page'])){		
						
				$left=1;		
			}
						
			$councelorList=array_slice($councelorList,$start,$per_page);		
			if($total>$per_page){		
				$current="(".($start+1)."-".($start+$per_page)." of ".$total.")";	
					
			}else{		
				$current="(".($start+1)."-".count($councelorList)." of ".$total.")";
				
			
			}		
		#pE
		$sugarSmarty = new Sugar_Smarty();
		$sugarSmarty->assign("councelorList",$councelorList);
		$sugarSmarty->assign("programList",$programList);
		$sugarSmarty->assign("batchList",$batchList);
		$sugarSmarty->assign("selected_batch",$_REQUEST['batch']);
		$sugarSmarty->assign("selected_status",$selected_status);
		$sugarSmarty->assign("current_records",$current);		
		$sugarSmarty->assign("page",$page);	
		$sugarSmarty->assign("pagenext",$pagenext);		
		$sugarSmarty->assign("right",$right);		
		$sugarSmarty->assign("left",$left);		
		$sugarSmarty->assign("last_page",$last_page);
		$sugarSmarty->display('custom/modules/AOR_Reports/tpls/conversionreport.tpl');
	}
}
?>
