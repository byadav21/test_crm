<?php
if (!defined('sugarEntry') || !sugarEntry)
	die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');
class AOR_ReportsViewConversiondatareport extends SugarView {

	public function __construct() {
		parent::SugarView();
	}

	function getVendor(){
		global $db;
		$vendorSql="SELECT name,id FROM `te_vendor` WHERE deleted=0 group by name order by name asc";
		$vendorObj =$db->query($vendorSql);
		$vendorArr = [];
		while($vendor =$db->fetchByAssoc($vendorObj)){
			$vendorArr[]=$vendor;
		}
		return $vendorArr;
	}
	function getbatchforlead($batch_arr=NULL){
		$where = '';
		if($batch_arr){
			$where =" AND id IN('".implode("','",$batch_arr)."')";
		}
		global $db;
		$batchSql="SELECT id,name FROM te_ba_batch WHERE batch_status='enrollment_in_progress' AND deleted=0 ".$where." ORDER BY name ASC";
		$batchObj =$db->query($batchSql);
		$batchOptions=array();
		while($row =$db->fetchByAssoc($batchObj)){
			$batchOptions[]=$row;
		}

		return $batchOptions;
	}

	function getBatch(){
		global $db;
		$batchSql="SELECT id,name FROM te_ba_batch WHERE batch_status='enrollment_in_progress' AND deleted=0";
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

		# Query for batch drop down options
		$where="";
		$from_date="";
		$to_date="";
		if(isset($_POST['button']) && $_POST['button']=="Search") {
			$_SESSION['lp_from_date'] = $_REQUEST['from_date'];
			$_SESSION['lp_to_date'] = $_REQUEST['to_date'];
			$_SESSION['lp_batch'] = $_REQUEST['batch'];
			if($_SESSION['lp_from_date']!=""&&$_SESSION['lp_to_date']){
				$from_date=date('Y-m-d',strtotime(str_replace('/','-',$_POST['from_date'])));
				$to_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['lp_to_date'])));
				$where.=" AND DATE(l.date_entered)>='".$from_date."' AND DATE(l.date_entered)<='".$to_date."'";
			}elseif($_SESSION['lp_from_date']!=""&&$_SESSION['lp_to_date']==""){
				$from_date=date('Y-m-d',strtotime(str_replace('/','-',$_POST['from_date'])));
				$where.=" AND DATE(l.date_entered)='".$from_date."' ";
			}elseif($_SESSION['lp_from_date']==""&&$_SESSION['lp_to_date']!=""){
				$to_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['lp_to_date'])));
				$where.=" AND DATE(l.date_entered)='".$to_date."' ";
			}
			if(!empty($_SESSION['lp_batch'])){
				$where.=" AND lc.te_ba_batch_id_c IN ('".implode("','",$_SESSION['lp_batch'])."') ";
			}


		}elseif(isset($_POST['export']) && $_POST['export']=="Export"){
			$file = "leads_conversiondata_report";
			$where='';
			$from_date="";
			$to_date="";
			$filename = $file . "_" . date ( "Y-m-d");
			$_SESSION['lp_from_date'] = $_REQUEST['from_date'];
			$_SESSION['lp_to_date'] = $_REQUEST['to_date'];
			$_SESSION['lp_batch'] = $_REQUEST['batch'];
			if($_SESSION['lp_from_date']!=""&&$_SESSION['lp_to_date']){
				$from_date=date('Y-m-d',strtotime(str_replace('/','-',$_POST['from_date'])));
				$to_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['lp_to_date'])));
				$where.=" AND DATE(l.date_entered)>='".$from_date."' AND DATE(l.date_entered)<='".$to_date."'";
			}elseif($_SESSION['lp_from_date']!=""&&$_SESSION['lp_to_date']==""){
				$from_date=date('Y-m-d',strtotime(str_replace('/','-',$_POST['from_date'])));
				$where.=" AND DATE(l.date_entered)='".$from_date."' ";
			}elseif($_SESSION['lp_from_date']==""&&$_SESSION['lp_to_date']!=""){
				$to_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['lp_to_date'])));
				$where.=" AND DATE(l.date_entered)='".$to_date."' ";
			}
			if(!empty($_SESSION['lp_batch'])){
				$where.=" AND lc.te_ba_batch_id_c IN ('".implode("','",$_SESSION['lp_batch'])."') ";
			}
			if(!empty($_SESSION['lp_batch'])){
				$batchLeadsArr = $this->getbatchforlead($_SESSION['lp_batch']);
			}
			else{
				$batchLeadsArr = $this->getbatchforlead();
			}
			$batchnameArr[]='Vendor';
			foreach ($batchLeadsArr as $key => $batchLeadsArrvalue) {
				$batchArr[]=$batchLeadsArrvalue['id'];
				$batchnameArr[]=str_replace(' ','_',$batchLeadsArrvalue['name']);
			}
			$batchnameArr[]='Grand_Total';
			$data=implode(',',$batchnameArr)."\n";

			$councelorList=array();
			$vendorArr = array();
			$vendorSql = "SELECT vendor.name,vendor.id  from te_vendor AS vendor where vendor.deleted=0";
			$vendorObj =$db->query($vendorSql);

			while($row =$db->fetchByAssoc($vendorObj)){
				$vendorArr[]=$row['name'];
			}
			/*$total=count($vendorArr); #total records
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
				$page=($_REQUEST['page']-1);
				$left=1;
			}

			$vendorArr=array_slice($vendorArr,$start,$per_page);
			if($total>$per_page){
				$current="(".($start+1)."-".($start+$per_page)." of ".$total.")";

			}else{
				$current="(".($start+1)."-".count($vendorArr)." of ".$total.")";

			}*/

			if($vendorArr && $batchArr){
				foreach ($vendorArr as $key => $vendorArrvalue) {
					foreach ($batchArr as $key => $value) {
						$councelorList[$vendorArrvalue][$value]=0;
					}
					
				}
				$leadSql = "SELECT lc.te_ba_batch_id_c AS batchid,v.id,v.name,COUNT(l.id)total from te_vendor AS v LEFT JOIN leads AS l ON l.vendor=v.name  LEFT JOIN leads_cstm AS lc ON lc.id_c=l.id WHERE l.deleted=0 AND v.deleted=0 AND l.status='Converted' $where GROUP BY v.id,lc.te_ba_batch_id_c ORDER BY v.name ASC";
				$leadObj =$db->query($leadSql);
				while($row =$db->fetchByAssoc($leadObj)){
					$councelorList[$row['name']][$row['batchid']]=$row['total'];
				}
			}


			foreach($councelorList as $key=>$councelor){
				$dataArr = array();
				$total = array();
				$dataArr[] = str_replace(' ','__',$key);
				foreach($batchArr as $value){
					$dataArr[] = $councelor[$value];
					$total[] = $councelor[$value];
				}
				$dataArr[] = array_sum($total);

				$data.=implode(',',$dataArr)."\n";
		 }
			ob_end_clean();
			header("Content-type: application/csv");
			header ('Content-disposition: attachment;filename=" '. $filename . '.csv";' );
			echo $data; exit;

		}
		$councelorList=array();
		$vendorArr = array();
		$batchArr = array();
		if(!empty($_SESSION['lp_batch'])){
			$batchLeadsArr = $this->getbatchforlead($_SESSION['lp_batch']);
		}
		else{
			$batchLeadsArr = $this->getbatchforlead();
		}

		foreach ($batchLeadsArr as $key => $batchLeadsArrvalue) {
			$batchArr[]=$batchLeadsArrvalue['id'];
		}
		$vendorSql = "SELECT vendor.name,vendor.id  from te_vendor AS vendor where vendor.deleted=0 ORDER BY vendor.name ASC";
		$vendorObj =$db->query($vendorSql);

		while($row =$db->fetchByAssoc($vendorObj)){
			$vendorArr[]=$row['name'];
		}

		if($vendorArr && $batchArr){
			foreach ($vendorArr as $key => $vendorArrvalue) {
				foreach ($batchArr as $key => $value) {
					$councelorList[$vendorArrvalue][$value]=0;
				}
				/*$leadSql = "select count(*)total,leads_cstm.te_ba_batch_id_c AS batchid from leads INNER JOIN leads_cstm ON leads.id=leads_cstm.id_c where leads.vendor='".$vendorArrvalue."' AND leads_cstm.te_ba_batch_id_c IN ('".implode("','",$batchArr)."') AND leads.status='Converted'  $where GROUP BY leads_cstm.te_ba_batch_id_c";
				$leadObj =$db->query($leadSql);
				while($row =$db->fetchByAssoc($leadObj)){
					$councelorList[$vendorArrvalue][$row['batchid']]=$row['total'];
				}*/
			}

			$leadSql = "SELECT lc.te_ba_batch_id_c AS batchid,v.id,v.name,COUNT(l.id)total from te_vendor AS v LEFT JOIN leads AS l ON l.vendor=v.name  LEFT JOIN leads_cstm AS lc ON lc.id_c=l.id WHERE l.deleted=0 AND v.deleted=0 AND l.status='Converted' $where GROUP BY v.id,lc.te_ba_batch_id_c ORDER BY v.name ASC";
			$leadObj =$db->query($leadSql);
			while($row =$db->fetchByAssoc($leadObj)){
				$councelorList[$row['name']][$row['batchid']]=$row['total'];
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
			$page=($_REQUEST['page']-1);
			$left=1;
		}

		$councelorList=array_slice($councelorList,$start,$per_page);
		if($total>$per_page){
			$current="(".($start+1)."-".($start+$per_page)." of ".$total.")";

		}else{
			$current="(".($start+1)."-".count($councelorList)." of ".$total.")";

		}

		if(isset($_SESSION['lp_from_date']) && !empty($_SESSION['lp_from_date'])){
			$from_date = date('d-m-Y',strtotime($_SESSION['lp_from_date']));
		}
		if(isset($_SESSION['lp_to_date']) && !empty($_SESSION['lp_to_date'])){
			$to_date = date('d-m-Y',strtotime($_SESSION['lp_to_date']));
		}
		if(isset($_SESSION['lp_batch']) && !empty($_SESSION['lp_batch'])){
			$selected_batch = $_SESSION['lp_batch'];
		}

		$sugarSmarty = new Sugar_Smarty();
		$sugarSmarty->assign("councelorList",$councelorList);
		$sugarSmarty->assign("batchLeadsArr",$batchLeadsArr);
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
		$sugarSmarty->display('custom/modules/AOR_Reports/tpls/conversiondatareport.tpl');
	}
}
?>
