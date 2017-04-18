<?php
if (!defined('sugarEntry') || !sugarEntry)
	die('Not A Valid Entry Point');
	require_once('custom/include/Email/sendmail.php');
class AOR_ReportsViewGsvreport extends SugarView {

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
		$userSql="SELECT id,CONCAT(first_name,' ',last_name) as name FROM users WHERE deleted=0 AND id='".$user_id."'";
		$userObj =$db->query($userSql);
		$user =$db->fetchByAssoc($userObj);
		return $user['name'];
	}

	function getCouncelorid($user_id){
		global $db;
		$userSql="SELECT id,CONCAT(first_name,' ',last_name) as name FROM users WHERE deleted=0 AND id='".$user_id."'";
		$userObj =$db->query($userSql);
		$user =$db->fetchByAssoc($userObj);
		$useropt[]=$user;
		return $user;
	}


	function getGSV($user_id){
		global $db;
	  $batchSql="SELECT sum(b.fees_inr) as gsv,b.id FROM leads l INNER JOIN leads_cstm lc on l.id=lc.id_c INNER JOIN te_ba_batch b ON lc.te_ba_batch_id_c=b.id where l.deleted=0 AND l.status='Converted' AND l.assigned_user_id='".$user_id."' GROUP BY b.id ";
		$batchObj =$db->query($batchSql);
		//$batch =$db->fetchByAssoc($batchObj);
		$batch_gsv='';
		while($batch =$db->fetchByAssoc($batchObj)){
			$batch_gsv[]=$batch['gsv'];
		}
		if($batch_gsv){
			return array_sum($batch_gsv);
		}
		else{
			return 0;
		}
		return $batch['gsv'];
	}
	function getBatch(){
		global $db;
		$batchSql="SELECT id,name from te_ba_batch WHERE deleted=0 AND batch_status<>'Closed'";
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
		#Get lead status drop down option
		$leadStatusList=$GLOBALS['app_list_strings']['lead_status_dom'];
		#Get batch drop down option
		$batchList=$this->getBatch();
		#print_r($users);
		#print_r($this->report_to_id);die;
		$uid=$this->report_to_id;# list of user ids

		# Query for batch drop down options
		$where="";
		$from_date="";
		$to_date="";
		$selected_counsellor="";
		if(isset($_POST['button']) && $_POST['button']=="Search") {
			if($_POST['from_date']!="" && $_POST['to_date']!=""){
				$from_date=date('Y-m-d',strtotime(str_replace('/','-',$_POST['from_date'])));
				$to_date=date('Y-m-d',strtotime(str_replace('/','-',$_POST['to_date'])));
				$where.=" AND DATE(date_modified)>='".$from_date."' AND DATE(date_modified)<='".$to_date."'";
			}elseif($_POST['from_date']!="" && $_POST['to_date']==""){
				$from_date=date('Y-m-d',strtotime(str_replace('/','-',$_POST['from_date'])));
				$where.=" AND DATE(date_modified)>='".$from_date."' ";
			}elseif($_POST['from_date']=="" && $_POST['to_date']!=""){
				$to_date=date('Y-m-d',strtotime(str_replace('/','-',$_POST['to_date'])));
				$where.=" AND DATE(date_modified)<='".$to_date."' ";
			}
			if(!empty($_POST['counsellor'])){
				 $selected_counsellor=$_POST['counsellor'];
				 $uid=$_POST['counsellor'];
			}
		}elseif(isset($_POST['export']) && $_POST['export']=="Export"){
			$data="Counsellors,Conversion,GSV\n";
			$file = "status_report";
			$where='';
			$from_date="";
			$to_date="";
			$filename = $file . "_" . date ( "Y-m-d");
			if($_POST['from_date']!=""&&$_POST['to_date']){
				$from_date=$GLOBALS['timedate']->to_db_date($_POST['from_date'],false);
				$to_date=$GLOBALS['timedate']->to_db_date($_POST['to_date'],false);
				$where.=" AND DATE(date_modified)>='".$from_date."' AND DATE(date_modified)<='".$to_date."'";
			}elseif($_POST['from_date']!=""&&$_POST['to_date']==""){
				$from_date=$GLOBALS['timedate']->to_db_date($_POST['from_date'],false);
				$where.=" AND DATE(date_modified)='".$from_date."' ";
			}elseif($_POST['from_date']==""&&$_POST['to_date']!=""){
				$to_date=$GLOBALS['timedate']->to_db_date($_POST['to_date'],false);
				$where.=" AND DATE(date_modified)='".$to_date."' ";
			}

			if(!empty($_POST['batch'])){
				$where.=" AND lc.te_ba_batch_id_c IN('".implode("','",$_POST['batch'])."') ";
			}
			$leadSql="SELECT count(l.assigned_user_id) as total,l.assigned_user_id,l.status FROM leads l INNER JOIN leads_cstm lc ON l.id=lc.id_c where l.deleted=0 AND  l.assigned_user_id IN('".implode("','",$uid)."') ".$where." GROUP BY l.assigned_user_id,l.status";

			$leadObj =$db->query($leadSql);
			$councelorList=array();
			while($row =$db->fetchByAssoc($leadObj)){
				$councelorList[$row['assigned_user_id']][$row['status']]=$row['total'];
				$councelorList[$row['assigned_user_id']]['name']=$this->getCouncelor($row['assigned_user_id']);
			}
			foreach($councelorList as $key=>$councelor){
				if(!isset($councelor['Alive']))
					$councelorList[$key]['Alive']=0;
				if(!isset($councelor['Warm']))
					$councelorList[$key]['Warm']=0;
				if(!isset($councelor['Dead']))
					$councelorList[$key]['Dead']=0;
				if(!isset($councelor['Converted']))
					$councelorList[$key]['Converted']=0;
			}


			foreach($councelorList as $key=>$councelor){
				$data.= "\"" . $councelor['name'] . "\",\"" . $councelor['Converted'] . "\",\"". $councelor['gsv']. "\"\n";
			}
			ob_end_clean();
			header("Content-type: application/csv");
			header ('Content-disposition: attachment;filename=" '. $filename . '.csv";' );
			echo $data; exit;
		}

		#$leadSql="SELECT count(l.assigned_user_id) as total,l.assigned_user_id,l.status FROM leads l INNER JOIN leads_cstm lc ON l.id=lc.id_c where l.deleted=0 ".$where." GROUP BY assigned_user_id,status";

		$leadSql="SELECT count(l.assigned_user_id) as total,l.assigned_user_id,l.status FROM leads l INNER JOIN leads_cstm lc ON l.id=lc.id_c where l.deleted=0 AND  l.assigned_user_id IN('".implode("','",$uid)."') ".$where." GROUP BY l.assigned_user_id,l.status";
		$leadObj =$db->query($leadSql);
		$councelorList=array();
		while($row =$db->fetchByAssoc($leadObj)){

			$councelorList[$row['assigned_user_id']][$row['status']]=$row['total'];
			$councelorList[$row['assigned_user_id']]['name']=$this->getCouncelor($row['assigned_user_id']);
			$councelorList[$row['assigned_user_id']]['gsv']=$this->getGSV($row['assigned_user_id']);
		}

		foreach($councelorList as $key=>$councelor){
			if(!isset($councelor['Alive']))
				$councelorList[$key]['Alive']=0;
			if(!isset($councelor['Warm']))
				$councelorList[$key]['Warm']=0;
			if(!isset($councelor['Dead']))
				$councelorList[$key]['Dead']=0;
			if(!isset($councelor['Converted']))
				$councelorList[$key]['Converted']=0;
		}

		if(!empty($from_date)){
			$from_date = date('d/m/Y',strtotime($from_date));
		}
		if(!empty($to_date)){
			$to_date = date('d/m/Y',strtotime($to_date));
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
				//$page++;
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
				//$page=($_REQUEST['page']-1);		
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
		$sugarSmarty->assign("leadStatusList",$leadStatusList);
		$sugarSmarty->assign("batchList",$batchList);
		$sugarSmarty->assign("selected_from_date",$from_date);
		$sugarSmarty->assign("selected_to_date",$to_date);
		$sugarSmarty->assign("selected_counsellor",$selected_counsellor);
		$sugarSmarty->assign("current_records",$current);		
		$sugarSmarty->assign("page",$page);	
		$sugarSmarty->assign("pagenext",$pagenext);		
		$sugarSmarty->assign("right",$right);		
		$sugarSmarty->assign("left",$left);		
		$sugarSmarty->assign("last_page",$last_page);
		$sugarSmarty->display('custom/modules/AOR_Reports/tpls/gsvreport.tpl');
	}
}
?>
