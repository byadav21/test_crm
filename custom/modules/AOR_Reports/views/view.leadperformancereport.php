<?php
if (!defined('sugarEntry') || !sugarEntry)
	die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');
class AOR_ReportsViewLeadperformancereport extends SugarView {

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
		$batchSql="SELECT id,name from te_ba_batch WHERE deleted=0 AND batch_status<>'Closed' $where";
		$batchObj =$db->query($batchSql);
		$batchOptions=array();
		while($row =$db->fetchByAssoc($batchObj)){
			$batchOptions[]=$row;
		}
		return $batchOptions;
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
		# Query for batch drop down options
		$where="";
		$from_date="";
		$to_date="";
		if(isset($_POST['button']) || isset($_POST['export'])){
			   $_SESSION['lp_from_date'] = $_REQUEST['from_date'];
			   $_SESSION['lp_to_date'] = $_REQUEST['to_date'];
			   $_SESSION['lp_batch'] = $_REQUEST['batch'];
	    }

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
		   $where.=" AND lc.te_ba_batch_id_c IN('".implode("','",$_SESSION['lp_batch'])."') ";
	  }
		if(isset($_POST['export']) && $_POST['export']=="Export"){
			$data="Vendor,Duplicate,Dead-Number,Fallout,Not-Eligible,Not-Enquired,Rejected,Retired,Ringing-Multiple-Times,Wrong-Number,Call-Back,Converted,Follow-Up,New-Lead,Prospect,Re-Enquired,No-Answer,Dropout,Grand-Total\n";
			$file = "leads_performance_report";
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
				$where.=" AND lc.te_ba_batch_id_c IN('".implode("','",$_SESSION['lp_batch'])."') ";
			}

			$councelorList=array();
			/*$vendorSql="SELECT vendor.name,vendor.id from te_vendor AS vendor where vendor.deleted=0";
			$vendorSql="SELECT vendor.name,vendor.id from te_vendor AS vendor INNER JOIN leads as l on LOWER(l.vendor)=(vendor.name) where vendor.deleted=0 AND l.deleted=0 GROUP BY vendor.name";
			$vendorObj =$db->query($vendorSql);
			while($rowVendor =$db->fetchByAssoc($vendorObj)){
				$councelorList[$rowVendor['id']]['name']=$rowVendor['name'];
			}*/

			//$leadSql="SELECT vendor.name,vendor.id ,count(l.id) as total,l.status_description from te_vendor AS vendor LEFT JOIN leads l ON trim(vendor.name)=trim(l.vendor) AND l.deleted=0 AND vendor.deleted=0 LEFT JOIN leads_cstm AS lc ON l.id=lc.id_c WHERE l.status_description IN(SELECT DISTINCT status_description from leads) AND vendor.name!='' $where GROUP BY vendor.name,l.status_description";
			$leadSql="SELECT v.id,v.name ,count(l.id) as total,l.status_description from  leads AS l INNER JOIN leads_cstm AS lc ON l.id=lc.id_c INNER JOIN te_vendor AS v on v.name=l.vendor WHERE l.deleted=0 AND v.deleted=0 $where GROUP BY v.id,l.status_description";
			$leadObj =$db->query($leadSql);
			while($row =$db->fetchByAssoc($leadObj)){
				$row['status_description'] = str_replace(array(' ','-'),'_',$row['status_description']);
				$councelorList[$row['id']]['name']=$row['name'];
				$councelorList[$row['id']][$row['status_description']]=$row['total'];
			}


			foreach($councelorList as $key=>$councelor){
				if(!isset($councelor['Call_Back']))
					$councelorList[$key]['Call_Back']=0;
				if(!isset($councelor['Converted']))
					$councelorList[$key]['Converted']=0;
				if(!isset($councelor['Dead_Number']))
					$councelorList[$key]['Dead_Number']=0;
				if(!isset($councelor['Duplicate']))
					$councelorList[$key]['Duplicate']=0;
				if(!isset($councelor['Fallout']))
					$councelorList[$key]['Fallout']=0;
				if(!isset($councelor['Follow_Up']))
					$councelorList[$key]['Follow_Up']=0;
				if(!isset($councelor['New_Lead']))
					$councelorList[$key]['New_Lead']=0;
				if(!isset($councelor['Not_Eligible']))
					$councelorList[$key]['Not_Eligible']=0;
				if(!isset($councelor['Not_Enquired']))
					$councelorList[$key]['Not_Enquired']=0;
				if(!isset($councelor['Prospect']))
					$councelorList[$key]['Prospect']=0;
				if(!isset($councelor['Re_Enquired']))
					$councelorList[$key]['Re_Enquired']=0;
				if(!isset($councelor['Rejected']))
					$councelorList[$key]['Rejected']=0;
				if(!isset($councelor['Retired']))
					$councelorList[$key]['Retired']=0;
				if(!isset($councelor['Ringing_Multiple_Times']))
					$councelorList[$key]['Ringing_Multiple_Times']=0;
				if(!isset($councelor['Wrong_Number']))
					$councelorList[$key]['Wrong_Number']=0;
							//add New Status
				if(!isset($councelor['No_Answer']))
					$councelorList[$key]['No_Answer']=0;
				if(!isset($councelor['Dropout']))
					$councelorList[$key]['Dropout']=0;

				if(!isset($councelor['Invalid_Total'])){
					$councelorList[$key]['Invalid_Total']=$councelorList[$key]['Wrong_Number']
					+$councelorList[$key]['Dead_Number']
					+$councelorList[$key]['Duplicate']
					+$councelorList[$key]['Ringing_Multiple_Times']
					+$councelorList[$key]['Not_Enquired']
					+$councelorList[$key]['Not_Eligible']
					+$councelorList[$key]['Rejected']
					+$councelorList[$key]['Re_Enquired']
					+$councelorList[$key]['No_Answer'];
				}
				if(!isset($councelor['Valid_Total'])){
					$councelorList[$key]['Valid_Total']=$councelorList[$key]['Call_Back']
					+$councelorList[$key]['Follow_Up'] /*  New Code */
					+$councelorList[$key]['New_Lead']
					+$councelorList[$key]['Converted']
					+$councelorList[$key]['Prospect']
					+$councelorList[$key]['Dropout'] /*  New Code */
					+$councelorList[$key]['Retired']
					+$councelorList[$key]['Fallout'];
				}
				if(!isset($councelor['Grand_Total'])){
					$councelorList[$key]['Grand_Total']=$councelorList[$key]['Valid_Total']+$councelorList[$key]['Invalid_Total'];
				}

			}


			foreach($councelorList as $key=>$councelor){
				$data.= "\"" . $councelor['name'] . "\",\"" . $councelor['Duplicate'] . "\",\"" . $councelor['Dead_Number']."\",\"" . $councelor['Fallout']."\",\"" . $councelor['Not_Eligible']. "\",\"" . $councelor['Not_Enquired'] . "\",\"" . $councelor['Rejected'] . "\",\"" . $councelor['Retired'] . "\",\"" . $councelor['Ringing_Multiple_Times'] . "\",\"" . $councelor['Wrong_Number'] . "\",\"" . $councelor['Call_Back'] . "\",\"" . $councelor['Converted'] . "\",\"" . $councelor['Follow_Up'] . "\",\"" . $councelor['New_Lead'] . "\",\"" . $councelor['Prospect'] . "\",\"" . $councelor['Re_Enquired'] . "\",\"" . $councelor['No_Answer'] . "\",\"" . $councelor['Dropout'] . "\",\"" . $councelor['Grand_Total'] . "\"\n";
			}
			ob_end_clean();
			header("Content-type: application/csv");
			header ('Content-disposition: attachment;filename=" '. $filename . '.csv";' );
			echo $data; exit;
		}
		$councelorList=array();


		/*$vendorSql="SELECT vendor.name,vendor.id from te_vendor AS vendor INNER JOIN leads as l on LOWER(l.vendor)=(vendor.name) where vendor.deleted=0 AND l.deleted=0 GROUP BY vendor.name";
		$vendorObj =$db->query($vendorSql);
		while($rowVendor =$db->fetchByAssoc($vendorObj)){
			$councelorList[$rowVendor['id']]['name']=$rowVendor['name'];
		}*/

		//$leadSql="SELECT vendor.name,vendor.id ,count(l.id) as total,l.status_description from te_vendor AS vendor LEFT JOIN leads l ON trim(vendor.name)=trim(l.vendor) AND l.deleted=0 AND vendor.deleted=0 LEFT JOIN leads_cstm AS lc ON l.id=lc.id_c WHERE l.status_description IN(SELECT DISTINCT status_description from leads) AND vendor.name!='' $where GROUP BY vendor.name,l.status_description";
		$leadSql="SELECT v.id,v.name ,count(l.id) as total,l.status_description from  leads AS l INNER JOIN leads_cstm AS lc ON l.id=lc.id_c INNER JOIN te_vendor AS v on v.name=l.vendor WHERE l.deleted=0 AND v.deleted=0 $where GROUP BY v.id,l.status_description";
		$leadObj =$db->query($leadSql);
		while($row =$db->fetchByAssoc($leadObj)){
			$row['status_description'] = str_replace(array(' ','-'),'_',$row['status_description']);
			$councelorList[$row['id']]['name']=$row['name'];
			$councelorList[$row['id']][$row['status_description']]=$row['total'];
		}



		foreach($councelorList as $key=>$councelor){
			if(!isset($councelor['Call_Back']))
				$councelorList[$key]['Call_Back']=0;
			if(!isset($councelor['Converted']))
				$councelorList[$key]['Converted']=0;
			if(!isset($councelor['Dead_Number']))
				$councelorList[$key]['Dead_Number']=0;
			if(!isset($councelor['Duplicate']))
				$councelorList[$key]['Duplicate']=0;
			if(!isset($councelor['Fallout']))
				$councelorList[$key]['Fallout']=0;
			if(!isset($councelor['Follow_Up']))
				$councelorList[$key]['Follow_Up']=0;
			if(!isset($councelor['New_Lead']))
				$councelorList[$key]['New_Lead']=0;
			if(!isset($councelor['Not_Eligible']))
				$councelorList[$key]['Not_Eligible']=0;
			if(!isset($councelor['Not_Enquired']))
				$councelorList[$key]['Not_Enquired']=0;
			if(!isset($councelor['Prospect']))
				$councelorList[$key]['Prospect']=0;
			if(!isset($councelor['Re_Enquired']))
				$councelorList[$key]['Re_Enquired']=0;
			if(!isset($councelor['Rejected']))
				$councelorList[$key]['Rejected']=0;
			if(!isset($councelor['Retired']))
				$councelorList[$key]['Retired']=0;
			if(!isset($councelor['Ringing_Multiple_Times']))
				$councelorList[$key]['Ringing_Multiple_Times']=0;
			if(!isset($councelor['Wrong_Number']))
				$councelorList[$key]['Wrong_Number']=0;
							//add New Status
			if(!isset($councelor['No_Answer']))
					$councelorList[$key]['No_Answer']=0;
			if(!isset($councelor['Dropout']))
					$councelorList[$key]['Dropout']=0;
			if(!isset($councelor['Invalid_Total'])){
					$councelorList[$key]['Invalid_Total']=$councelorList[$key]['Wrong_Number']
					+$councelorList[$key]['Dead_Number']
					+$councelorList[$key]['Duplicate']
					+$councelorList[$key]['Ringing_Multiple_Times']
					+$councelorList[$key]['Not_Enquired']
					+$councelorList[$key]['Not_Eligible']
					+$councelorList[$key]['Rejected']
					+$councelorList[$key]['Re_Enquired']
					+$councelorList[$key]['No_Answer'];
				}
				if(!isset($councelor['Valid_Total'])){
					$councelorList[$key]['Valid_Total']=$councelorList[$key]['Call_Back']
					+$councelorList[$key]['Follow_Up'] /*  New Code */
					+$councelorList[$key]['New_Lead']
					+$councelorList[$key]['Converted']
					+$councelorList[$key]['Prospect']
					+$councelorList[$key]['Dropout'] /*  New Code */
					+$councelorList[$key]['Retired']
					+$councelorList[$key]['Fallout'];
				}
			if(!isset($councelor['Grand_Total'])){
				$councelorList[$key]['Grand_Total']=$councelorList[$key]['Valid_Total']+$councelorList[$key]['Invalid_Total'];
			}

		}

		//$pagination_query = "SELECT COUNT(*)total FROM (SELECT vendor.name,vendor.id ,count(l.id) as total,l.status_description from te_vendor AS vendor LEFT JOIN leads l ON trim(vendor.name)=trim(l.vendor) AND l.deleted=0 AND vendor.deleted=0 LEFT JOIN leads_cstm AS lc ON l.id=lc.id_c WHERE vendor.name!='' $where GROUP BY vendor.name,l.status_description)as temp";

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
		$sugarSmarty->display('custom/modules/AOR_Reports/tpls/leadperformancereport.tpl');
	}
}
?>
