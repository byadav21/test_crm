<?php
if (!defined('sugarEntry') || !sugarEntry)
	die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php'); 
class AOR_ReportsViewDailyuploadreport extends SugarView {
	
	public function __construct() {
		parent::SugarView();
	}
 
 
	
	function getReportData($searchData){
		global $db;
		
		$sql="select te_vendor.name,  count(leads.id) as total , COUNT(CASE WHEN upload_status = '1' THEN 1 END) as alive, COUNT(CASE WHEN upload_status = '-1' THEN 1 END) as duplicat,count(case when dristi_customer_id is not null Then 1 End) as uploaded, count(case when dristi_request is not null Then 1 End) as called from leads inner join te_utm on te_utm.name=leads.utm inner join te_vendor_te_utm_1_c on te_utm.id=te_vendor_te_utm_1te_utm_idb inner join te_vendor on te_vendor.id=te_vendor_te_utm_1_c.te_vendor_te_utm_1te_vendor_ida ";		
		 
		if(isset($searchData['search_date'])&&$searchData['search_date']!=""){
			$searchData['search_date']=date('Y-m-d',strtotime($searchData['search_date'])); 
			$sql.=" where date(leads.date_entered)='". $searchData['search_date'] ."'";
		}
		
		$sql .="group by te_vendor.name ";		
		$vendorObj =$db->query($sql);
		$vendorOptions=array();
		while($row =$db->fetchByAssoc($vendorObj)){ 
			$vendorOptions[]=$row;
		}
		return $vendorOptions;
	}
 
 
 
	public function display() {
		global $db;
		 
		$reportDataList=array();
		$vendorOptionList=array();
		$search_date="";
		$searchData=array('search_date'=>'');
		$index=0;
	
		if(isset($_POST['button']) && $_POST['button']=="Search") {
			
			if($_POST['search_date']!=""){
				$searchData['search_date']=$_POST['search_date'];
				$search_date=$_POST['search_date'];
			}
		 
			$vendorListData=$this->getReportData($searchData);
			foreach($vendorListData as $vendors){			 
				$reportDataList[$index]['name']=$vendors['name'];				 
				$reportDataList[$index]['total']=$vendors['total'];
				$reportDataList[$index]['alive']=$vendors['alive'];
				$reportDataList[$index]['duplicate']=($vendors['duplicat']);							
				$reportDataList[$index]['uploaded']=($vendors['uploaded']);							
				$reportDataList[$index]['called']=($vendors['called']);							
				$index++;
			}
		}elseif(isset($_POST['export']) && $_POST['export']=="Export"){
			$data="Vendor,Total Leads,Alive,Duplicate\n";
			$file = "daily_report";
			$filename = $file . "_" . date ( "Y-m-d");
			
			if($_POST['search_date']!=""){
				$searchData['search_date']=$_POST['search_date'];
				$search_date=$_POST['search_date'];
			}
			$vendorListData=$this->getReportData($searchData);
			foreach($vendorListData as $vendors){
								
				$data.= "\"" . $vendors['name'] . "\",\"" . $vendors['total'] . "\",\"" . $vendors['alive']."\",\"" . $vendors['duplicat']. "\"\n";			
			}
			ob_end_clean();
			header("Content-type: application/csv");
			header ('Content-disposition: attachment;filename=" '. $filename . '.csv";' );
			echo $data;exit;
			
		
		}else{			
			$vendorListData=$this->getReportData($searchData);
			foreach($vendorListData as $vendors){
				$reportDataList[$index]['name']=$vendors['name'];				 
				$reportDataList[$index]['total']=$vendors['total'];
				$reportDataList[$index]['alive']=$vendors['alive'];
				$reportDataList[$index]['duplicate']=($vendors['duplicat']);	
				$reportDataList[$index]['uploaded']=($vendors['uploaded']);							
				$reportDataList[$index]['called']=($vendors['called']);							
				$index++;
			}
		}		
        #Custom Pagination
		$total=count($reportDataList); #total records			
		$start=0;
		$per_page=10;
		$page=1;
		$last_page=ceil($total/$per_page);
		
		if(isset($_REQUEST['page'])&&$_REQUEST['page']>0){
			$start=$per_page*($_REQUEST['page']-1);
			$page=($_REQUEST['page']+1);
		}else{
			$page++;
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
		$reportDataList=array_slice($reportDataList,$start,$per_page);
		if($total>$per_page){
			$current="(".($start+1)."-".($start+$per_page)." of ".$total.")";
		}else{
			$current="(".($start+1)."-".count($reportDataList)." of ".$total.")";
		}
		# Pagination end
		
		$sugarSmarty = new Sugar_Smarty();
		
		$sugarSmarty->assign("reportDataList",$reportDataList);		
		$sugarSmarty->assign("selected_date",$search_date);
		$sugarSmarty->assign("current_records",$current);
		$sugarSmarty->assign("page",$page);
		$sugarSmarty->assign("right",$right);
		$sugarSmarty->assign("left",$left);
		$sugarSmarty->assign("last_page",$last_page);
		$sugarSmarty->display('custom/modules/AOR_Reports/tpls/uploadreport.tpl');
	}
}
?>
