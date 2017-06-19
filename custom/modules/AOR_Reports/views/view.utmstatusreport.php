<?php
if (!defined('sugarEntry') || !sugarEntry)
	die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');
class AOR_ReportsViewUtmstatusreport extends SugarView {

	public function __construct() {
		parent::SugarView();
	}

	function getUTM(){
		global $db;
		$vendorSql="SELECT name,id FROM `te_utm` WHERE utm_status IN ('Live') AND deleted=0 order by date_modified desc";
		$vendorObj =$db->query($vendorSql);
		$vendorArr = [];
		while($vendor =$db->fetchByAssoc($vendorObj)){
			$vendorArr[]=$vendor;
		}
		return $vendorArr;
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

		#Get lead status drop down option
		$leadStatusList=$GLOBALS['app_list_strings']['lead_status_dom'];
		#Get batch drop down option
		$batchList=$this->getBatch();

		$where="";
		$from_date="";
		$to_date="";
		$whereBatch="";
		if(isset($_POST['button']) && $_POST['button']=="Search") {
			$_SESSION['us_from_date'] = $_REQUEST['from_date'];
			$_SESSION['us_to_date'] = $_REQUEST['to_date'];
			$_SESSION['us_batch'] = $_REQUEST['batch'];
		}elseif(isset($_POST['export']) && $_POST['export']=="Export"){
			$data="Source,Term,Medium,Campaign,Duplicate,Dead_Number,Dropout,Fallout,No_Answer,Not_Eligible,Not_Enquired,Rejected,Retired,Ringing_Multiple_Times,Wrong_Number,Call_Back,Converted,Follow_Up,New_Lead,Prospect,Re_Enquired\n";
			$file = "utm_status_report";
			$where='';
			$from_date="";
			$to_date="";
			$filename = $file . "_" . date ( "Y-m-d");
			$_SESSION['us_from_date'] = $_REQUEST['from_date'];
			$_SESSION['us_to_date'] = $_REQUEST['to_date'];
			$_SESSION['us_batch'] = $_REQUEST['batch'];
			if($_SESSION['us_from_date']!=""&&$_SESSION['us_to_date']){
				$from_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['us_from_date'])));
				$to_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['us_to_date'])));
				$where.=" AND DATE(l.date_entered)>='".$from_date."' AND DATE(l.date_entered)<='".$to_date."'";
			}elseif($_SESSION['us_from_date']!=""&&$_SESSION['us_to_date']==""){
				$from_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['us_from_date'])));
				$where.=" AND DATE(l.date_entered)='".$from_date."' ";
			}elseif($_SESSION['us_from_date']==""&&$_SESSION['us_to_date']!=""){
				$to_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['us_to_date'])));
				$where.=" AND DATE(l.date_entered)='".$to_date."' ";
			}

			if(!empty($_SESSION['us_batch'])){
				$where.=" AND lc.te_ba_batch_id_c IN('".implode("','",$_SESSION['us_batch'])."') ";
				$whereBatch ="AND b.id IN('".implode("','",$_SESSION['us_batch'])."')";
			}

			$councelorList=array();
			$utmArr = [];
			$vendorSql="SELECT u.id ,v.name,b.name as batch,contract_type from te_utm as u
						inner join te_ba_batch as b on b.id=u.te_ba_batch_id_c
						inner join te_vendor_te_utm_1_c on te_vendor_te_utm_1_c.te_vendor_te_utm_1te_utm_idb=u.id
						inner join te_vendor as v on v.id=te_vendor_te_utm_1_c.te_vendor_te_utm_1te_vendor_ida
						WHERE u.utm_status ='Live' AND u.deleted=0 AND b.deleted=0 AND v.deleted=0 $whereBatch
						order by u.date_modified desc";
			$vendorObj =$db->query($vendorSql);
			$vendorArr = [];
			while($vendor =$db->fetchByAssoc($vendorObj)){
				$vendorArr[]=$vendor;
			}
			$vendors = $vendorArr;

			$campaignSql="SELECT DISTINCT IFNULL(utm_campaign,'NA')utm_campaign  from leads";

			$campaignObj =$db->query($campaignSql);
			$campaignArr = [];
			while($campaign =$db->fetchByAssoc($campaignObj)){
				$campaignArr[]=$campaign['utm_campaign'];
			}

			if($vendors){
				foreach($vendors as $vendorval){
					foreach($campaignArr as $val){
						$councelorList[$vendorval['id'].'TE__TE'.$val]['name']=$vendorval['name'];
						$councelorList[$vendorval['id'].'TE__TE'.$val]['batch']=$vendorval['batch'];
						$councelorList[$vendorval['id'].'TE__TE'.$val]['contract_type']=$vendorval['contract_type'];
						$councelorList[$vendorval['id'].'TE__TE'.$val]['Call_Back']=0;
						$councelorList[$vendorval['id'].'TE__TE'.$val]['Converted']=0;
						$councelorList[$vendorval['id'].'TE__TE'.$val]['Dropout']=0;
						$councelorList[$vendorval['id'].'TE__TE'.$val]['Dead_Number']=0;
						$councelorList[$vendorval['id'].'TE__TE'.$val]['Fallout']=0;
						$councelorList[$vendorval['id'].'TE__TE'.$val]['Follow_Up']=0;
						$councelorList[$vendorval['id'].'TE__TE'.$val]['New_Lead']=0;
						$councelorList[$vendorval['id'].'TE__TE'.$val]['No_Answer']=0;
						$councelorList[$vendorval['id'].'TE__TE'.$val]['Not_Eligible']=0;
						$councelorList[$vendorval['id'].'TE__TE'.$val]['Not_Enquired']=0;
						$councelorList[$vendorval['id'].'TE__TE'.$val]['Prospect']=0;
						$councelorList[$vendorval['id'].'TE__TE'.$val]['Wrong_Number']=0;
						$councelorList[$vendorval['id'].'TE__TE'.$val]['Re_Enquired']=0;
						$councelorList[$vendorval['id'].'TE__TE'.$val]['Rejected']=0;
						$councelorList[$vendorval['id'].'TE__TE'.$val]['Retired']=0;
						$councelorList[$vendorval['id'].'TE__TE'.$val]['Ringing_Multiple_Times']=0;
						$councelorList[$vendorval['id'].'TE__TE'.$val]['Duplicate']=0;
					}
					$utmArr[]=$vendorval['id'];

				}
				if($utmArr){
					$where.=" AND u.id IN('".implode("','",$utmArr)."') ";
				}
				$leadSql="SELECT u.name,u.id,l.status_description,count(l.id)total,IFNULL(l.utm_campaign,'NA')utm_campaign FROM `te_utm` AS u INNER JOIN leads AS l ON l.utm=u.name  INNER JOIN leads_cstm AS lc ON lc.id_c=l.id WHERE u.deleted=0 AND u.utm_status='Live' AND l.deleted=0  $where GROUP BY u.id,l.status_description,l.utm_campaign";
				$leadObj =$db->query($leadSql);
				while($row =$db->fetchByAssoc($leadObj)){
					$row['status_description'] = str_replace(array(' ','-'),'_',$row['status_description']);
					$councelorList[$row['id'].'TE__TE'.$row['utm_campaign']][$row['status_description']]=$row['total'];
				}
			}
			foreach($councelorList as $key=>$councelor){
				$campaing = explode('TE__TE',$key);
				$data.= "\"" . $councelor['name'] . "\",\"" . $councelor['batch']. "\",\"" . $councelor['contract_type']. "\",\"" . $campaing[1]. "\",\"" . $councelor['Duplicate'] . "\",\"" . $councelor['Dead_Number'] . "\",\"" . $councelor['Dropout'] . "\",\"" . $councelor['Fallout'] . "\",\"" . $councelor['No_Answer'] . "\",\"" . $councelor['Not_Eligible'] . "\",\"" . $councelor['Not_Enquired'] . "\",\"" . $councelor['Rejected'] . "\",\"" . $councelor['Retired'] . "\",\"" . $councelor['Ringing_Multiple_Times'] . "\",\"" . $councelor['Wrong_Number'] . "\",\"" . $councelor['Call_Back'] . "\",\"" . $councelor['Converted'] . "\",\"" . $councelor['Follow_Up'] . "\",\"" . $councelor['New_Lead'] . "\",\"" . $councelor['Prospect'] . "\",\"" . $councelor['Re_Enquired'] . "\"\n";
			}
			ob_end_clean();
			header("Content-type: application/csv");
			header ('Content-disposition: attachment;filename=" '. $filename . '.csv";' );
			echo $data; exit;
		}


		if($_SESSION['us_from_date']!=""&&$_SESSION['us_to_date']){
			$from_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['us_from_date'])));
			$to_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['us_to_date'])));
			$where.=" AND DATE(l.date_entered)>='".$from_date."' AND DATE(l.date_entered)<='".$to_date."'";
		}elseif($_SESSION['us_from_date']!=""&&$_SESSION['us_to_date']==""){
			$from_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['us_from_date'])));
			$where.=" AND DATE(l.date_entered)>='".$from_date."' ";
		}elseif($_SESSION['us_from_date']==""&&$_SESSION['us_to_date']!=""){
			$to_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['us_to_date'])));
			$where.=" AND DATE(l.date_entered)<='".$to_date."' ";
		}
		if(!empty($_SESSION['us_batch'])){
			$where.=" AND lc.te_ba_batch_id_c IN('".implode("','",$_SESSION['us_batch'])."') ";
			$whereBatch ="AND b.id IN('".implode("','",$_SESSION['us_batch'])."')";
		}
		$vendorSql="SELECT u.id ,u.name AS utm_name,v.name,b.name as batch,contract_type from te_utm as u
						inner join te_ba_batch as b on b.id=u.te_ba_batch_id_c
						inner join te_vendor_te_utm_1_c on te_vendor_te_utm_1_c.te_vendor_te_utm_1te_utm_idb=u.id
						inner join te_vendor as v on v.id=te_vendor_te_utm_1_c.te_vendor_te_utm_1te_vendor_ida
						WHERE u.utm_status ='Live' AND u.deleted=0 AND b.deleted=0 AND v.deleted=0 $whereBatch
						order by u.date_modified desc";

				$vendorObj =$db->query($vendorSql);
				$vendorArr = [];
				while($vendor =$db->fetchByAssoc($vendorObj)){
					$vendorArr[]=$vendor;
				}
				$vendors = $vendorArr;

				$campaignSql="SELECT DISTINCT IFNULL(utm_campaign,'NA')utm_campaign  from leads";

				$campaignObj =$db->query($campaignSql);
				$campaignArr = [];
				while($campaign =$db->fetchByAssoc($campaignObj)){
					$campaignArr[]=$campaign['utm_campaign'];
				}
		$councelorList=array();
		$InitialcouncelorList=array();
		$utmArr = [];
		if($vendors){
			$keys=array(
				"Call_Back",
				"Converted",
				"Dropout",
				"Dead_Number",
				"Fallout",
				"Follow_Up",
				"New_Lead",
				"No_Answer",
				"Not_Eligible",
				"Not_Enquired",
				"Prospect",
				"Wrong_Number",
				"Re_Enquired",
				"Rejected",
				"Retired",
				"Ringing_Multiple_Times",
				"Duplicate"
			);
			$a1=array_fill_keys($keys,0);
			foreach($vendors as $vendorval){
				foreach($campaignArr as $val){
					$InitialcouncelorList[$vendorval['id'].'TE__TE'.$val]['name']=$vendorval['name'];
					$InitialcouncelorList[$vendorval['id'].'TE__TE'.$val]['batch']=$vendorval['batch'];
					$InitialcouncelorList[$vendorval['id'].'TE__TE'.$val]['contract_type']=$vendorval['contract_type'];
					/*$councelorList[$vendorval['id'].'TE__TE'.$val]['Call_Back']=0;
					$councelorList[$vendorval['id'].'TE__TE'.$val]['Converted']=0;
					$councelorList[$vendorval['id'].'TE__TE'.$val]['Dropout']=0;
					$councelorList[$vendorval['id'].'TE__TE'.$val]['Dead_Number']=0;
					$councelorList[$vendorval['id'].'TE__TE'.$val]['Fallout']=0;
					$councelorList[$vendorval['id'].'TE__TE'.$val]['Follow_Up']=0;
					$councelorList[$vendorval['id'].'TE__TE'.$val]['New_Lead']=0;
					$councelorList[$vendorval['id'].'TE__TE'.$val]['No_Answer']=0;
					$councelorList[$vendorval['id'].'TE__TE'.$val]['Not_Eligible']=0;
					$councelorList[$vendorval['id'].'TE__TE'.$val]['Not_Enquired']=0;
					$councelorList[$vendorval['id'].'TE__TE'.$val]['Prospect']=0;
					$councelorList[$vendorval['id'].'TE__TE'.$val]['Wrong_Number']=0;
					$councelorList[$vendorval['id'].'TE__TE'.$val]['Re_Enquired']=0;
					$councelorList[$vendorval['id'].'TE__TE'.$val]['Rejected']=0;
					$councelorList[$vendorval['id'].'TE__TE'.$val]['Retired']=0;
					$councelorList[$vendorval['id'].'TE__TE'.$val]['Ringing_Multiple_Times']=0;
					$councelorList[$vendorval['id'].'TE__TE'.$val]['Duplicate']=0;*/
				}
				$utmArr[]=$vendorval['id'];
			}
			foreach($InitialcouncelorList as $key=>$val){
				 $test = array_merge($val,$a1);
				 $councelorList[$key]=$test;
			}
			//echo "<pre>";print_r($councelorList);exit();
			if($utmArr){
				$where.=" AND u.id IN('".implode("','",$utmArr)."') ";
			}
			$leadSql="SELECT u.name,u.id,l.status_description,count(l.id)total,IFNULL(l.utm_campaign,'NA')utm_campaign FROM `te_utm` AS u INNER JOIN leads AS l ON l.utm=u.name  INNER JOIN leads_cstm AS lc ON lc.id_c=l.id WHERE u.deleted=0 AND u.utm_status='Live' AND l.deleted=0  $where GROUP BY u.id,l.status_description,l.utm_campaign";
			$leadObj =$db->query($leadSql);
			while($row =$db->fetchByAssoc($leadObj)){
				$row['status_description'] = str_replace(array(' ','-'),'_',$row['status_description']);
				$councelorList[$row['id'].'TE__TE'.$row['utm_campaign']][$row['status_description']]=$row['total'];
			}

		}
		//echo count($councelorList)."<pre>";print_r($councelorList);exit();
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
			$page=($_REQUEST['page']-1);
			$left=1;
		}

		$councelorList=array_slice($councelorList,$start,$per_page);
		if($total>$per_page){
			$current="(".($start+1)."-".($start+$per_page)." of ".$total.")";

		}else{
			$current="(".($start+1)."-".count($councelorList)." of ".$total.")";

		}

		if(isset($_SESSION['us_from_date']) && !empty($_SESSION['us_from_date'])){
			$from_date = date('d-m-Y',strtotime($_SESSION['us_from_date']));
		}
		if(isset($_SESSION['us_to_date']) && !empty($_SESSION['us_to_date'])){
			$to_date = date('d-m-Y',strtotime($_SESSION['us_to_date']));
		}
		if(isset($_SESSION['us_batch']) && !empty($_SESSION['us_batch'])){
			$selected_batch = $_SESSION['us_batch'];
		}

		$sugarSmarty = new Sugar_Smarty();
		$sugarSmarty->assign("councelorList",$councelorList);
		$sugarSmarty->assign("leadStatusList",$leadStatusList);
		$sugarSmarty->assign("batchList",$batchList);
		$sugarSmarty->assign("selected_from_date",$from_date);
		$sugarSmarty->assign("selected_to_date",$to_date);
		$sugarSmarty->assign("selected_batch",$selected_batch);

		$sugarSmarty->assign("current_records",$current);
		$sugarSmarty->assign("page",$page);
		$sugarSmarty->assign("pagenext",$pagenext);
		$sugarSmarty->assign("right",$right);
		$sugarSmarty->assign("left",$left);
		$sugarSmarty->assign("last_page",$last_page);
		$sugarSmarty->display('custom/modules/AOR_Reports/tpls/utmstatusreport.tpl');
	}
}
?>
