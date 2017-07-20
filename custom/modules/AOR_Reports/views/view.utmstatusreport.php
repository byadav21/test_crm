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
			$filename = $file . "_" . date("Y-m-d");
			$_SESSION['us_from_date'] = $_REQUEST['from_date'];
			$_SESSION['us_to_date'] = $_REQUEST['to_date'];
			$_SESSION['us_batch'] = $_REQUEST['batch'];
			if($_SESSION['us_from_date']!=""&&$_SESSION['us_to_date']){
				$from_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['us_from_date'])));
				$to_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['us_to_date'])));
				$where.=" AND DATE(l.date_entered)>='".$from_date."' AND DATE(l.date_entered)<='".$to_date."'";
				$whereInvalidUtm.=" AND DATE(l.date_entered)>='".$from_date."' AND DATE(l.date_entered)<='".$to_date."'";
			}elseif($_SESSION['us_from_date']!=""&&$_SESSION['us_to_date']==""){
				$from_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['us_from_date'])));
				$where.=" AND DATE(l.date_entered)>='".$from_date."' ";
				$whereInvalidUtm.=" AND DATE(l.date_entered)>='".$from_date."' ";
			}elseif($_SESSION['us_from_date']==""&&$_SESSION['us_to_date']!=""){
				$to_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['us_to_date'])));
				$where.=" AND DATE(l.date_entered)<='".$to_date."' ";
				$whereInvalidUtm.=" AND DATE(l.date_entered)<='".$to_date."' ";
			}
			if(!empty($_SESSION['us_batch'])){
				$where.=" AND lc.te_ba_batch_id_c IN('".implode("','",$_SESSION['us_batch'])."') ";
				$whereInvalidUtm.=" AND lc.te_ba_batch_id_c IN('".implode("','",$_SESSION['us_batch'])."') ";
				$whereBatch ="AND b.id IN('".implode("','",$_SESSION['us_batch'])."')";
			}

			$councelorList=array();
			$utmArr = [];
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

			$campaignSql="SELECT DISTINCT if(utm_campaign is null or utm_campaign = '', 'NA', utm_campaign)utm_campaign,utm  from leads";

			$campaignObj =$db->query($campaignSql);
			$campaignArr = [];
			while($campaign =$db->fetchByAssoc($campaignObj)){
				$campaignArr[]=$campaign;
			}

			$councelorList=array();
			$utmArr = [];

			if($vendors){
				/*foreach($vendors as $vendorval){
					foreach($campaignArr as $val){
						if($val['utm']==$vendorval['utm_name']){
							$councelorList[$vendorval['id'].'TE__TE'.$val['utm_campaign']]['name']=$vendorval['name'];
							$councelorList[$vendorval['id'].'TE__TE'.$val['utm_campaign']]['batch']=$vendorval['batch'];
							$councelorList[$vendorval['id'].'TE__TE'.$val['utm_campaign']]['contract_type']=$vendorval['contract_type'];
							$utmArr[]=$vendorval['id'];
						}

					}
					//$utmArr[]=$vendorval['id'];

				}*/
				/*if($utmArr){
					$where.=" AND u.id IN('".implode("','",$utmArr)."') ";
				}*/
				$leadSql="SELECT u.contract_type, l.vendor,u.name AS utm,u.id AS utmid,if(l.utm_campaign is null or l.utm_campaign = '', 'NA', l.utm_campaign)utm_campaign,l.utm,b.id,b.name,COUNT(DISTINCT l.id)total,l.status_description from te_ba_batch AS b LEFT JOIN leads_cstm AS lc ON lc.te_ba_batch_id_c=b.id LEFT JOIN leads AS l ON l.id=lc.id_c LEFT JOIN `te_utm` AS u on l.utm=u.name  WHERE b.deleted=0  AND l.status_description!=''  $where AND l.deleted=0 GROUP BY b.id,l.status_description,l.utm,utm_campaign,u.contract_type,l.vendor,u.id  ORDER BY b.name ASC";
				$leadObj =$db->query($leadSql);
				while($row =$db->fetchByAssoc($leadObj)){
					$row['status_description'] = str_replace(array(' ','-'),'_',$row['status_description']);
					if($row['utmid']=='' || $row['utmid']==NULL){
					$idn = 'NA_VENDOR#'.$row['name'].'#NA'; 
					
					$councelorList[$idn.'TE__TENA']['name']='NA_VENDOR';
					$councelorList[$idn.'TE__TENA']['batch']=$row['name'];
					$councelorList[$idn.'TE__TENA']['contract_type']='NA';
					if(!array_key_exists($idn.'TE__TENA',$councelorList)) {
					  $councelorList[$idn.'TE__TE'.'NA'][$row['status_description']]=$row['total'];
				    } else {
					  $councelorList[$idn.'TE__TE'.'NA'][$row['status_description']]=$councelorList[$idn.'TE__TE'.'NA'][$row['status_description']] + $row['total'];	 
					}
				} else {
					$idn = $row['vendor'].'#'.$row['name'].'#'.$row['contract_type']; 
					$councelorList[$idn.'TE__TE'.$row['utm_campaign']]['name']=$row['vendor'];
					$councelorList[$idn.'TE__TE'.$row['utm_campaign']]['batch']=$row['name'];
					$councelorList[$idn.'TE__TE'.$row['utm_campaign']]['contract_type']=$row['contract_type'];
					
					if(!array_key_exists($idn.'TE__TE'.$row['utm_campaign'],$councelorList)) {
					  $councelorList[$idn.'TE__TE'.$row['utm_campaign']][$row['status_description']]=$row['total'];
				    } else {
					  $councelorList[$idn.'TE__TE'.$row['utm_campaign']][$row['status_description']]=$councelorList[$idn.'TE__TE'.$row['utm_campaign']][$row['status_description']] + $row['total'];	 
					} 
				}

				}
			}
			/*$invlidUtmSql = "select count(l.id)total,lc.te_ba_batch_id_c,l.status_description,(select name from te_ba_batch where id=lc.te_ba_batch_id_c)batch from leads AS l inner join leads_cstm as lc on l.id=lc.id_c  where l.utm='NA'  AND l.deleted=0 AND lc.te_ba_batch_id_c!='' $whereInvalidUtm group by lc.te_ba_batch_id_c,l.status_description,utm_campaign";
			$invlidUtmObj =$db->query($invlidUtmSql);
			while($row =$db->fetchByAssoc($invlidUtmObj)){
				$councelorList[$row['batch'].'TE__TENA']['name']='NA_VENDOR';
				$councelorList[$row['batch'].'TE__TENA']['batch']=$row['batch'];
				$councelorList[$row['batch'].'TE__TENA']['contract_type']='NA';
				$row['status_description'] = str_replace(array(' ','-'),'_',$row['status_description']);
				$councelorList[$row['batch'].'TE__TENA'][$row['status_description']]=$row['total'];
			}*/
			//echo "<pre>";print_r($councelorList);exit();
			foreach($councelorList as $key=>$councelor){
				$campaing = explode('TE__TE',$key);
				if(!isset($councelor['Duplicate'])){
					$councelor['Duplicate']=0;
				}
				if(!isset($councelor['Dead_Number'])){
					$councelor['Dead_Number']=0;
				}
				if(!isset($councelor['Dropout'])){
					$councelor['Dropout']=0;
				}
				if(!isset($councelor['Fallout'])){
					$councelor['Fallout']=0;
				}
				if(!isset($councelor['No_Answer'])){
					$councelor['No_Answer']=0;
				}
				if(!isset($councelor['Not_Eligible'])){
					$councelor['Not_Eligible']=0;
				}
				if(!isset($councelor['Not_Enquired'])){
					$councelor['Not_Enquired']=0;
				}
				if(!isset($councelor['Rejected'])){
					$councelor['Rejected']=0;
				}
				if(!isset($councelor['Retired'])){
					$councelor['Retired']=0;
				}
				if(!isset($councelor['Ringing_Multiple_Times'])){
					$councelor['Ringing_Multiple_Times']=0;
				}
				if(!isset($councelor['Wrong_Number'])){
					$councelor['Wrong_Number']=0;
				}
				if(!isset($councelor['Call_Back'])){
					$councelor['Call_Back']=0;
				}
				if(!isset($councelor['Converted'])){
					$councelor['Converted']=0;
				}
				if(!isset($councelor['Follow_Up'])){
					$councelor['Follow_Up']=0;
				}
				if(!isset($councelor['New_Lead'])){
					$councelor['New_Lead']=0;
				}
				if(!isset($councelor['Prospect'])){
					$councelor['Prospect']=0;
				}
				if(!isset($councelor['Re_Enquired'])){
					$councelor['Re_Enquired']=0;
				}
				if($councelor['name'] && $councelor['batch'] && $councelor['contract_type'] && $campaing[1]){
					$data.= "\"" . $councelor['name'] . "\",\"" . $councelor['batch']. "\",\"" . $councelor['contract_type']. "\",\"" . $campaing[1]. "\",\"" . $councelor['Duplicate'] . "\",\"" . $councelor['Dead_Number'] . "\",\"" . $councelor['Dropout'] . "\",\"" . $councelor['Fallout'] . "\",\"" . $councelor['No_Answer'] . "\",\"" . $councelor['Not_Eligible'] . "\",\"" . $councelor['Not_Enquired'] . "\",\"" . $councelor['Rejected'] . "\",\"" . $councelor['Retired'] . "\",\"" . $councelor['Ringing_Multiple_Times'] . "\",\"" . $councelor['Wrong_Number'] . "\",\"" . $councelor['Call_Back'] . "\",\"" . $councelor['Converted'] . "\",\"" . $councelor['Follow_Up'] . "\",\"" . $councelor['New_Lead'] . "\",\"" . $councelor['Prospect'] . "\",\"" . $councelor['Re_Enquired'] . "\"\n";
				}

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
			$whereInvalidUtm.=" AND DATE(l.date_entered)>='".$from_date."' AND DATE(l.date_entered)<='".$to_date."'";
		}elseif($_SESSION['us_from_date']!=""&&$_SESSION['us_to_date']==""){
			$from_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['us_from_date'])));
			$where.=" AND DATE(l.date_entered)>='".$from_date."' ";
			$whereInvalidUtm.=" AND DATE(l.date_entered)>='".$from_date."' ";
		}elseif($_SESSION['us_from_date']==""&&$_SESSION['us_to_date']!=""){
			$to_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['us_to_date'])));
			$where.=" AND DATE(l.date_entered)<='".$to_date."' ";
			$whereInvalidUtm.=" AND DATE(l.date_entered)<='".$to_date."' ";
		}
		if(!empty($_SESSION['us_batch'])){
			$where.=" AND lc.te_ba_batch_id_c IN('".implode("','",$_SESSION['us_batch'])."') ";
			$whereInvalidUtm.=" AND lc.te_ba_batch_id_c IN('".implode("','",$_SESSION['us_batch'])."') ";
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

				$campaignSql="SELECT DISTINCT if(utm_campaign is null or utm_campaign = '', 'NA', utm_campaign)utm_campaign,utm  from leads";

				$campaignObj =$db->query($campaignSql);
				$campaignArr = [];
				while($campaign =$db->fetchByAssoc($campaignObj)){
					$campaignArr[]=$campaign;
				}
		$councelorList=array();
		$utmArr = [];
		if($vendors){

			/*foreach($vendors as $vendorval){
				foreach($campaignArr as $val){
					if($val['utm']==$vendorval['utm_name']){
						$councelorList[$vendorval['id'].'TE__TE'.$val['utm_campaign']]['name']=$vendorval['name'];
						$councelorList[$vendorval['id'].'TE__TE'.$val['utm_campaign']]['batch']=$vendorval['batch'];
						$councelorList[$vendorval['id'].'TE__TE'.$val['utm_campaign']]['contract_type']=$vendorval['contract_type'];
						$utmArr[]=$vendorval['id'];
					}


				}

			}*/
			/*if($utmArr){
				$where.=" AND u.id IN('".implode("','",$utmArr)."') ";
			}*/

			$leadSql="SELECT u.contract_type, l.vendor,u.id AS utmid,if(l.utm_campaign is null or l.utm_campaign = '', 'NA', l.utm_campaign)utm_campaign,l.utm,b.id,b.name,COUNT(DISTINCT l.id)total,l.status_description from te_ba_batch AS b LEFT JOIN leads_cstm AS lc ON lc.te_ba_batch_id_c=b.id LEFT JOIN leads AS l ON l.id=lc.id_c LEFT JOIN `te_utm` AS u on l.utm=u.name  WHERE b.deleted=0  AND l.status_description!=''  $where AND l.deleted=0 GROUP BY b.id,l.status_description,l.utm,utm_campaign,u.contract_type,l.vendor,u.id  ORDER BY b.name ASC";
			$leadObj = $db->query($leadSql);
			while($row =$db->fetchByAssoc($leadObj)){
				$row['status_description'] = str_replace(array(' ','-'),'_',$row['status_description']);
				if($row['utmid']=='' || $row['utmid']==NULL){
					$idn = 'NA_VENDOR#'.$row['name'].'#NA'; 
					
					$councelorList[$idn.'TE__TENA']['name']='NA_VENDOR';
					$councelorList[$idn.'TE__TENA']['batch']=$row['name'];
					$councelorList[$idn.'TE__TENA']['contract_type']='NA';
					if(!array_key_exists($idn.'TE__TENA',$councelorList)) {
					  $councelorList[$idn.'TE__TE'.'NA'][$row['status_description']]=$row['total'];
				    } else {
					  $councelorList[$idn.'TE__TE'.'NA'][$row['status_description']]=$councelorList[$idn.'TE__TE'.'NA'][$row['status_description']] + $row['total'];	 
					}
				} else {
					$idn = $row['vendor'].'#'.$row['name'].'#'.$row['contract_type']; 
					$councelorList[$idn.'TE__TE'.$row['utm_campaign']]['name']=$row['vendor'];
					$councelorList[$idn.'TE__TE'.$row['utm_campaign']]['batch']=$row['name'];
					$councelorList[$idn.'TE__TE'.$row['utm_campaign']]['contract_type']=$row['contract_type'];
					
					if(!array_key_exists($idn.'TE__TE'.$row['utm_campaign'],$councelorList)) {
					  $councelorList[$idn.'TE__TE'.$row['utm_campaign']][$row['status_description']]=$row['total'];
				    } else {
					  $councelorList[$idn.'TE__TE'.$row['utm_campaign']][$row['status_description']]=$councelorList[$idn.'TE__TE'.$row['utm_campaign']][$row['status_description']] + $row['total'];	 
					} 
				}

			}
		} 
		/*$invlidUtmSql = "select count(l.id)total,lc.te_ba_batch_id_c,l.status_description,(select name from te_ba_batch where id=lc.te_ba_batch_id_c)batch from leads AS l inner join leads_cstm as lc on l.id=lc.id_c  where l.utm='NA'  AND l.deleted=0 AND lc.te_ba_batch_id_c!='' $whereInvalidUtm group by lc.te_ba_batch_id_c,l.status_description,utm_campaign";
		$invlidUtmObj =$db->query($invlidUtmSql);
		while($row =$db->fetchByAssoc($invlidUtmObj)){
			$councelorList[$row['batch'].'TE__TENA']['name']='NA_VENDOR';
			$councelorList[$row['batch'].'TE__TENA']['batch']=$row['batch'];
			$councelorList[$row['batch'].'TE__TENA']['contract_type']='NA';
			$row['status_description'] = str_replace(array(' ','-'),'_',$row['status_description']);
			$councelorList[$row['batch'].'TE__TENA'][$row['status_description']]=$row['total'];
		}*/
		//echo "<pre>";print_r($councelorList);exit();
		//echo "<pre>";print_r($councelorList);exit();
		foreach ($councelorList as $key => $value) {
			if(!isset($value['name']) && !isset($value['batch']) && !isset($value['contract_type'])){
				unset($councelorList[$key]);
			}
		}

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
