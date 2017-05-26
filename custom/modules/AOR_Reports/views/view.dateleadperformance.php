<?php
if (!defined('sugarEntry') || !sugarEntry)
	die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');
class AOR_ReportsViewDateleadperformance extends SugarView {

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
	function getUTM($vendor_id){
		global $db;
		$utmSql="SELECT utm.name FROM `te_vendor_te_utm_1_c` as vur INNER JOIN te_utm AS utm ON utm.id=vur.te_vendor_te_utm_1te_utm_idb WHERE utm.deleted=0 AND vur.te_vendor_te_utm_1te_vendor_ida='".$vendor_id."'";
		$utmObj =$db->query($utmSql);
		$utmArr = [];
		while($utm =$db->fetchByAssoc($utmObj)){
			$utmArr[] = $utm['name'];
		}
		return implode("','",$utmArr);
	}

	function getBatch(){
		global $db;
		$batchSql="SELECT name,id from te_ba_batch WHERE deleted=0 AND batch_status<>'Closed' AND name!='' GROUP BY name";
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
		if(isset($_REQUEST['button']) && $_REQUEST['button']=="Search") {
			$_SESSION['till_from_date'] = $_REQUEST['from_date'];
			$_SESSION['till_to_date'] = $_REQUEST['to_date'];
			$_SESSION['till_batch'] = $_REQUEST['batch'];
		}elseif(isset($_REQUEST['export']) && $_REQUEST['export']=="Export"){
			$_SESSION['till_from_date'] = $_REQUEST['from_date'];
			$_SESSION['till_to_date'] = $_REQUEST['to_date'];
			$_SESSION['till_batch'] = $_REQUEST['from_batch'];
			$datacsv="Batch_Name,Media,Duplicate,Dead-Number,Fallout,Not-Eligible,Not-Enquired,Rejected,Retired,Ringing-Multiple-Times,Wrong-Number,Call-Back,Converted,Follow-Up,New-Lead,Prospect,Re-Enquired,Grand-Total\n";
			$file = "Till_Date_Lead_Performance";
			$where='';
			$from_date="";
			$to_date="";
			$filename = $file . "_" . date ( "Y-m-d");
			if($_SESSION['till_from_date']!=""&&$_SESSION['till_from_date']){
				$from_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['till_from_date'])));
				$to_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['till_to_date'])));
				$where.=" AND DATE(l.date_entered)>='".$from_date."' AND DATE(l.date_entered)<='".$to_date."'";
			}elseif($_SESSION['till_from_date']!=""&&$_SESSION['till_to_date']==""){
				$from_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['till_from_date'])));
				$where.=" AND DATE(date_entered)='".$from_date."' ";
			}elseif($_SESSION['till_from_date']==""&&$_SESSION['till_to_date']!=""){
				$to_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['till_to_date'])));
				$where.=" AND DATE(date_entered)='".$to_date."' ";
			}

			if(!empty($_SESSION['till_batch'])){
				$wherebatch=" AND id IN('".implode("','",$_SESSION['till_batch'])."') ";
			}

			$councelorList=array();

			$vendorSql="SELECT name,id FROM `te_vendor` WHERE deleted=0 group by name order by name asc";
			$vendorObj =$db->query($vendorSql);
			$vendorArr = [];
			while($vendor =$db->fetchByAssoc($vendorObj)){
				$vendorArr[]=$vendor;
			}

			$vendors = $vendorArr;

			$batchSql="SELECT name,id from te_ba_batch WHERE deleted=0 AND batch_status<>'Closed' AND name!='' $wherebatch GROUP BY name";
			$batchObj =$db->query($batchSql);
			$batchOptions=array();
			while($row =$db->fetchByAssoc($batchObj)){
				$batchOptions[]=$row;
			}

			$batches = $batchOptions;

			$batchVendorArr = array();
			if($batches && $vendors){
				foreach($batches as $batchval){
					foreach ($vendors as $vendorsVal) {
						$batchVendorArr[]=array('batch_id'=>$batchval['id'],'batch_name'=>$batchval['name'],'vendor_id'=>$vendorsVal['id'],'vendor_name'=>$vendorsVal['name']);
					}
				}

			}

			if($batchVendorArr){
				foreach ($batchVendorArr as $value) {
					$where=" AND  l.vendor='".$value['vendor_name']."' AND lc.te_ba_batch_id_c='".$value['batch_id']."' ";
					$leadSql="SELECT count(l.id) as total,l.status_description FROM leads l INNER JOIN leads_cstm lc ON l.id=lc.id_c where l.deleted=0 $where GROUP BY l.status_description";
					$leadObj =$db->query($leadSql);

					$data = array();
					while($row =$db->fetchByAssoc($leadObj)){
						$row['status_description'] = str_replace(array(' ','-'),'_',$row['status_description']);
						$data[$row['status_description']]=$row['total'];
					}
					$res = $this->find_status($data);
					$councelorList[$value['batch_name']][]=array('name'=>$value['vendor_name']
					,'Call_Back'=>$res['Call_Back']
					,'Converted'=>$res['Converted']
					,'Dead_Number'=>$res['Dead_Number']
					,'Fallout'=>$res['Fallout']
					,'Follow_Up'=>$res['Follow_Up']
					,'New_Lead'=>$res['New_Lead']
					,'Not_Eligible'=>$res['Not_Eligible']
					,'Not_Enquired'=>$res['Not_Enquired']
					,'Prospect'=>$res['Prospect']
					,'Re_Enquired'=>$res['Re_Enquired']
					,'Rejected'=>$res['Rejected']
					,'Retired'=>$res['Retired']
					,'Ringing_Multiple_Times'=>$res['Ringing_Multiple_Times']
					,'Duplicate'=>$res['Duplicate']
					,'Wrong_Number'=>$res['Wrong_Number']
					,'Grand_Total'=>$res['Grand_Total']

				);
				}

			}

			foreach($councelorList as $key1=>$councelorVal){
				foreach ($councelorVal as $councelorkey => $councelor) {
					$datacsv.= "\"" . $key1 . "\",\"" . $councelor['name'] . "\",\"" . $councelor['Duplicate'] . "\",\"" . $councelor['Dead_Number']."\",\"" . $councelor['Fallout']."\",\"" . $councelor['Not_Eligible']. "\",\"" . $councelor['Not_Enquired'] . "\",\"" . $councelor['Rejected'] . "\",\"" . $councelor['Retired'] . "\",\"" . $councelor['Ringing_Multiple_Times'] . "\",\"" . $councelor['Wrong_Number'] . "\",\"" . $councelor['Call_Back'] . "\",\"" . $councelor['Converted'] . "\",\"" . $councelor['Follow_Up'] . "\",\"" . $councelor['New_Lead'] . "\",\"" . $councelor['Prospect'] . "\",\"" . $councelor['Re_Enquired'] . "\",\"" . $councelor['Grand_Total'] . "\"\n";
				}

			}

			ob_end_clean();
			header("Content-type: application/csv");
			header ('Content-disposition: attachment;filename=" '. $filename . '.csv";' );
			echo $datacsv; exit;
		}

		if($_SESSION['till_from_date']!=""&&$_SESSION['till_from_date']){
			$from_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['till_from_date'])));
			$to_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['till_to_date'])));
			$where.=" AND DATE(l.date_entered)>='".$from_date."' AND DATE(l.date_entered)<='".$to_date."'";
		}elseif($_SESSION['till_from_date']!=""&&$_SESSION['till_to_date']==""){
			$from_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['till_from_date'])));
			$where.=" AND DATE(date_entered)='".$from_date."' ";
		}elseif($_SESSION['till_from_date']==""&&$_SESSION['till_to_date']!=""){
			$to_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['till_to_date'])));
			$where.=" AND DATE(date_entered)='".$to_date."' ";
		}

		if(!empty($_SESSION['till_batch'])){
			$wherebatch=" AND id IN('".implode("','",$_SESSION['till_batch'])."') ";
		}
		$councelorList=array();

		$vendorSql="SELECT name,id FROM `te_vendor` WHERE deleted=0 group by name order by name asc";
		$vendorObj =$db->query($vendorSql);
		$vendorArr = [];
		while($vendor =$db->fetchByAssoc($vendorObj)){
			$vendorArr[]=$vendor;
		}

		$vendors = $vendorArr;

		$batchSql="SELECT name,id from te_ba_batch WHERE deleted=0 AND batch_status<>'Closed' AND name!='' $wherebatch GROUP BY name";
		$batchObj =$db->query($batchSql);
		$batchOptions=array();
		while($row =$db->fetchByAssoc($batchObj)){
			$batchOptions[]=$row;
		}

		$batches = $batchOptions;

		$batchVendorArr = array();
		if($batches && $vendors){
			foreach($batches as $batchval){
				foreach ($vendors as $vendorsVal) {
					$batchVendorArr[]=array('batch_id'=>$batchval['id'],'batch_name'=>$batchval['name'],'vendor_id'=>$vendorsVal['id'],'vendor_name'=>$vendorsVal['name']);
				}
			}

		}

		$total=count($batchVendorArr); #total records
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

		$batchVendorArr=array_slice($batchVendorArr,$start,$per_page);
		if($total>$per_page){
			$current="(".($start+1)."-".($start+$per_page)." of ".$total.")";

		}else{
			$current="(".($start+1)."-".count($batchVendorArr)." of ".$total.")";

		}


		if($batchVendorArr){
			foreach ($batchVendorArr as $value) {
				$where=" AND  l.vendor='".$value['vendor_name']."' AND lc.te_ba_batch_id_c='".$value['batch_id']."' ";
				$leadSql="SELECT count(l.id) as total,l.status_description FROM leads l INNER JOIN leads_cstm lc ON l.id=lc.id_c where l.deleted=0 $where GROUP BY l.status_description";
				$leadObj =$db->query($leadSql);

				$data = array();
				while($row =$db->fetchByAssoc($leadObj)){
					$row['status_description'] = str_replace(array(' ','-'),'_',$row['status_description']);
					$data[$row['status_description']]=$row['total'];
				}
				$res = $this->find_status($data);
				$councelorList[$value['batch_name']][]=array('name'=>$value['vendor_name']
				,'Call_Back'=>$res['Call_Back']
				,'Converted'=>$res['Converted']
				,'Dead_Number'=>$res['Dead_Number']
				,'Fallout'=>$res['Fallout']
				,'Follow_Up'=>$res['Follow_Up']
				,'New_Lead'=>$res['New_Lead']
				,'Not_Eligible'=>$res['Not_Eligible']
				,'Not_Enquired'=>$res['Not_Enquired']
				,'Prospect'=>$res['Prospect']
				,'Re_Enquired'=>$res['Re_Enquired']
				,'Rejected'=>$res['Rejected']
				,'Retired'=>$res['Retired']
				,'Ringing_Multiple_Times'=>$res['Ringing_Multiple_Times']
				,'Duplicate'=>$res['Duplicate']
				,'Wrong_Number'=>$res['Wrong_Number']
				,'Grand_Total'=>$res['Grand_Total']

			);
			}
		}
		if(isset($_SESSION['till_from_date']) && !empty($_SESSION['till_from_date'])){
			$from_date = date('d/m/Y',strtotime($_SESSION['till_from_date']));
		}
		if(isset($_SESSION['till_to_date']) && !empty($_SESSION['till_to_date'])){
			$to_date = date('d/m/Y',strtotime($_SESSION['till_to_date']));
		}
		if(isset($_SESSION['till_batch']) && !empty($_SESSION['till_batch'])){
			$selected_batch = $_SESSION['till_batch'];
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
		$sugarSmarty->display('custom/modules/AOR_Reports/tpls/dateleadperformance.tpl');
	}

	function find_status($councelorList){
		if(!array_key_exists ('Call_Back',$councelorList))
			$councelorList['Call_Back']=0;
		if(!array_key_exists ('Converted',$councelorList))
			$councelorList['Converted']=0;
		if(!array_key_exists ('Dead_Number',$councelorList))
			$councelorList['Dead_Number']=0;
		if(!array_key_exists ('Duplicate',$councelorList))
			$councelorList['Duplicate']=0;
		if(!array_key_exists ('Fallout',$councelorList))
			$councelorList['Fallout']=0;
		if(!array_key_exists ('Follow_Up',$councelorList))
			$councelorList['Follow_Up']=0;
		if(!array_key_exists ('New_Lead',$councelorList))
			$councelorList['New_Lead']=0;
		if(!array_key_exists ('Not_Eligible',$councelorList))
			$councelorList['Not_Eligible']=0;
		if(!array_key_exists ('Not_Enquired',$councelorList))
			$councelorList['Not_Enquired']=0;
		if(!array_key_exists ('Prospect',$councelorList))
			$councelorList['Prospect']=0;
		if(!array_key_exists ('Re_Enquired',$councelorList))
			$councelorList['Re_Enquired']=0;
		if(!array_key_exists ('Rejected',$councelorList))
			$councelorList['Rejected']=0;

		if(!array_key_exists ('Retired',$councelorList))
			$councelorList['Retired']=0;
		if(!array_key_exists ('Ringing_Multiple_Times',$councelorList))
			$councelorList['Ringing_Multiple_Times']=0;
		if(!array_key_exists ('Re_Enquired',$councelorList))
			$councelorList['Re_Enquired']=0;
		if(!array_key_exists ('Wrong_Number',$councelorList))
			$councelorList['Wrong_Number']=0;

		if(!array_key_exists ('Grand_Total',$councelorList)){
				$councelorList['Grand_Total']=$councelorList['Call_Back']
				+$councelorList['Converted']
				+$councelorList['Dead_Number']
				+$councelorList['Duplicate']
				+$councelorList['Fallout']
				+$councelorList['Follow_Up']
				+$councelorList['New_Lead']
				+$councelorList['Not_Eligible']
				+$councelorList['Not_Enquired']
				+$councelorList['Rejected']
				+$councelorList['Retired']
				+$councelorList['Ringing_Multiple_Times']
				+$councelorList['Re_Enquired']
				+$councelorList['Wrong_Number'];

				 }

		return $councelorList;
	}
}
?>
