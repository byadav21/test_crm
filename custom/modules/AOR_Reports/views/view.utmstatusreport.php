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
		if(isset($_POST['button']) && $_POST['button']=="Search") {
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
			}
		}elseif(isset($_POST['export']) && $_POST['export']=="Export"){
			$data="Source,Term,Medium,,Alive,Warm,Dead,Converted\n";
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
			}

			$councelorList=array();
			$vendorSql="SELECT u.id ,v.name,b.name as batch,contract_type from te_utm as u
						inner join te_ba_batch as b on b.id=u.te_ba_batch_id_c
						inner join te_vendor_te_utm_1_c on te_vendor_te_utm_1_c.te_vendor_te_utm_1te_utm_idb=u.id
						inner join te_vendor as v on v.id=te_vendor_te_utm_1_c.te_vendor_te_utm_1te_vendor_ida
						WHERE u.utm_status ='Live' AND u.deleted=0 AND b.deleted=0 AND v.deleted=0 
						order by u.date_modified desc";
			$vendorObj =$db->query($vendorSql);
			$vendorArr = [];
			while($vendor =$db->fetchByAssoc($vendorObj)){
				$vendorArr[]=$vendor;
			}
			$vendors = $vendorArr;
			if($vendors){
				foreach($vendors as $vendorval){
					$councelorList[$vendorval['id']]['name']=$vendorval['name'];
					$councelorList[$vendorval['id']]['Alive']=0;
					$councelorList[$vendorval['id']]['Warm']=0;
					$councelorList[$vendorval['id']]['Dead']=0;
					$councelorList[$vendorval['id']]['Converted']=0;

				}
				$leadSql="SELECT u.name,u.id,l.status,count(l.id)total FROM `te_utm` AS u INNER JOIN leads AS l ON l.utm=u.name  INNER JOIN leads_cstm AS lc ON lc.id_c=l.id WHERE u.deleted=0 AND u.utm_status='Live' AND l.deleted=0 AND l.status IN ('Alive','Warm','Dead','Converted') $where GROUP BY u.id,l.status";
				$leadObj =$db->query($leadSql);
				while($row =$db->fetchByAssoc($leadObj)){
					$councelorList[$row['id']]['name']=$row['name'];
					$councelorList[$row['id']][$row['status']]=$row['total'];
				}
			}

			foreach($councelorList as $key=>$councelor){
				$data.= "\"" . $councelor['name'] . "\",\"" . $councelor['batch']. "\",\"" . $councelor['contract_type']. "\",\"" . $councelor['Alive'] . "\",\"" . $councelor['Warm']."\",\"" . $councelor['Dead']."\",\"" . $councelor['Converted']. "\"\n";
			}
			ob_end_clean();
			header("Content-type: application/csv");
			header ('Content-disposition: attachment;filename=" '. $filename . '.csv";' );
			echo $data; exit;
		}

		$vendorSql="SELECT u.id ,v.name,b.name as batch,contract_type from te_utm as u
						inner join te_ba_batch as b on b.id=u.te_ba_batch_id_c
						inner join te_vendor_te_utm_1_c on te_vendor_te_utm_1_c.te_vendor_te_utm_1te_utm_idb=u.id
						inner join te_vendor as v on v.id=te_vendor_te_utm_1_c.te_vendor_te_utm_1te_vendor_ida
						WHERE u.utm_status ='Live' AND u.deleted=0 AND b.deleted=0 AND v.deleted=0 
						order by u.date_modified desc";
				 
				$vendorObj =$db->query($vendorSql);
				$vendorArr = [];
				while($vendor =$db->fetchByAssoc($vendorObj)){
					$vendorArr[]=$vendor;
				}
				$vendors = $vendorArr;


		$councelorList=array();
		if($vendors){
			foreach($vendors as $vendorval){
				//$leadSql="SELECT count(l.id) as total,l.status FROM leads l INNER JOIN leads_cstm lc ON l.id=lc.id_c where l.deleted=0 AND l.utm='".$vendorval['name']."' $where GROUP BY l.status";
				//$leadObj =$db->query($leadSql);

				$councelorList[$vendorval['id']]['name']=$vendorval['name'];
				$councelorList[$vendorval['id']]['batch']=$vendorval['batch'];
				$councelorList[$vendorval['id']]['contract_type']=$vendorval['contract_type'];
				$councelorList[$vendorval['id']]['Alive']=0;
				$councelorList[$vendorval['id']]['Warm']=0;
				$councelorList[$vendorval['id']]['Dead']=0;
				$councelorList[$vendorval['id']]['Converted']=0;
				/*while($row =$db->fetchByAssoc($leadObj)){
					$councelorList[$vendorval['id']][$row['status']]=$row['total'];
				}*/
			}
			$leadSql="SELECT u.name,u.id,l.status,count(l.id)total FROM `te_utm` AS u INNER JOIN leads AS l ON l.utm=u.name  INNER JOIN leads_cstm AS lc ON lc.id_c=l.id WHERE u.deleted=0 AND u.utm_status='Live' AND l.deleted=0 AND l.status IN ('Alive','Warm','Dead','Converted') $where GROUP BY u.id,l.status";
			$leadObj =$db->query($leadSql);
			while($row =$db->fetchByAssoc($leadObj)){
				$councelorList[$row['id']]['name']=$row['name'];
				$councelorList[$row['id']][$row['status']]=$row['total'];
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
