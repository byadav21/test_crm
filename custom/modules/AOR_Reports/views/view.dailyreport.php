<?php
if (!defined('sugarEntry') || !sugarEntry)
	die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');
require_once('custom/modules/AOR_Reports/pagination.php');
class AOR_ReportsViewDailyreport extends SugarView {

    private $objPagination;
	public function __construct() {
		parent::SugarView();
        $this->objPagination = new pagination(10, 'page');
	}
	
	function getBatch()
    	{
		global $db;
		$batchSql     = "SELECT b.id,b.name,b.batch_code,b.d_campaign_id,b.d_lead_id,b.batch_status,b.fees_inr,p.name AS program_name FROM te_ba_batch AS b INNER JOIN te_pr_programs_te_ba_batch_1_c AS pbr ON pbr.te_pr_programs_te_ba_batch_1te_ba_batch_idb=b.id INNER JOIN te_pr_programs AS p ON p.id=pbr.te_pr_programs_te_ba_batch_1te_pr_programs_ida WHERE  b.deleted=0 ORDER BY b.name";
		$batchObj     = $db->query($batchSql);
		$batchOptions = array();
		while ($row   = $db->fetchByAssoc($batchObj))
		{
		    $batchOptions[$row['id']] = $row;
		}
		return $batchOptions;
    	}
	
	public function display() {
		global $sugar_config, $app_list_strings, $current_user, $db;
		$batchList = $this->getBatch();
        $_export = isset($_POST['export']) && $_POST['export'] == "Export";
		//echo "<pre>";print_r($batchList);echo "</pre>";
		//echo "<pre>";print_r($app_list_strings['lead_status_custom_dom']);exit();
		$listCouncelorArr = [];
		if (isset($_REQUEST['button']) || isset($_REQUEST['export']))
		{
		    $_SESSION['dr_from_date']   = ($_REQUEST['from_date']) ? date("Y-m-d",strtotime($_REQUEST['from_date'])) : '';
		    $_SESSION['dr_to_date']     = ($_REQUEST['to_date']) ? date("Y-m-d",strtotime($_REQUEST['to_date'])) : '';
		    $_SESSION['dr_batch']       = $_REQUEST['course'];
		    $_SESSION['dr_status']      = $_REQUEST['status'];
		}
		if(!isset($_SESSION['dr_from_date']) || empty($_SESSION['dr_from_date'])){
			$_SESSION['dr_from_date'] = date('Y-m-d');
		}
		if(!isset($_SESSION['dr_to_date']) || empty($_SESSION['dr_to_date'])){
			$_SESSION['dr_to_date'] = date('Y-m-d');
		}
		
		$wheredr = "";
		if (!empty($_SESSION['dr_from_date']))
		{
		    $selected_from_date = date("d-m-Y",strtotime($_SESSION['dr_from_date']));
		    $wheredr .= " AND DATE(date_entered)>='" . $_SESSION['dr_from_date'] . "'";
		}
		if (!empty($_SESSION['dr_to_date']))
		{
		   $selected_to_date = date("d-m-Y",strtotime($_SESSION['dr_to_date']));
		   $wheredr .= " AND DATE(date_entered)<='" . $_SESSION['dr_to_date'] . "'";
		}
		if (!empty($_SESSION['dr_batch']))
		{
		    $selected_course = $_SESSION['dr_batch'];
		    $wheredr .= " AND batch_id IN ('" . implode("','", $selected_course) . "')";
		}
		if (!empty($_SESSION['dr_status']))
		{
		    $selected_status = $_SESSION['dr_status'];
		}

		/*Check Date Range*/
		$filter_date_diff = $this->dateDiff($_SESSION['dr_from_date'],$_SESSION['dr_to_date']);
		if($filter_date_diff > 30){
			SugarApplication::appendErrorMessage('Action Prohibited: Please select a max of 30 days date range.');
			//set params
			$params = array(
			    'module'=> 'AOR_Reports', //the module you want to redirect to
			    'action'=>'dailyreport', //the view within that module
			);
			//redirect    
			//SugarApplication::redirect('index.php?' . http_build_query($params));

		}/*Date Range is <=30Days*/
		else{
			SugarApplication::appendErrorMessage('');

            $leadSql = "SELECT l.status,lc.te_ba_batch_id_c,l.vendor FROM leads AS l INNER JOIN leads_cstm AS lc on l.id=lc.id_c WHERE l.deleted=0 $wheredr";
            $leadObj = null;
            $leadObj = $db->query($leadSql);

            $dataArr = array();
            while ($row = $db->fetchByAssoc($leadObj)){
                $batchID = ($row['te_ba_batch_id_c'] != '') ? $row['te_ba_batch_id_c'] : "NA";
                $vendorName = $row['vendor'];
                $k = $batchID.'_'.$vendorName;
                if(!isset($dataArr[$k])) {
                    $batch = isset($batchList[$batchID])?$batchList[$batchID]:array();
                    $dataArr[$k]['vendor']          = $vendorName;
                    $dataArr[$k]['batch']           = ($batch['name']) ? $batch['name'] : "NA";
                    $dataArr[$k]['batch_code']      = ($batch['batch_code']) ? $batch['batch_code'] : "NA";
                    $dataArr[$k]['program_name']    = ($batch['program_name']) ? $batch['program_name'] : "NA";
                    $dataArr[$k]['fees_inr']        = ($batch['fees_inr']) ? $batch['fees_inr'] : 0;
                }
                $dataArr[$k]['status'][$row['status']][]=1;
            }

            $rowCount = count($dataArr);
            if($rowCount <= 0){
                $error['error'] = "No Data Found.";
            }
            $this->objPagination->set_total($rowCount);
            $councelorList = array();
            if(!empty($dataArr)){
                $dataArr = array_slice($dataArr, $this->objPagination->get_start(), $this->objPagination->get_page_length());
                foreach($dataArr as $key=>$val){
                    $councelorList[$key]=$val;
                    $total = [];
                    $converted = 0;
                    $fee = $val['fees_inr'];
                    foreach($val['status'] as $statuskey=>$statusval){
                        if($statuskey=='Converted'){$converted = count($val['status']['Converted']);}
                        $total[]=count($statusval);
                    }
                    $councelorList[$key]['total']=array_sum($total);
                    $councelorList[$key]['converted']=$converted;
                    $councelorList[$key]['gsv']=0;
                    if($fee>0 && $converted>0){
                        $gsv = $fee*$converted;
                        $councelorList[$key]['gsv']=round($gsv,2);
                    }
                    unset($councelorList[$key]['status']);
                }
                unset($dataArr);
            }

			if($_export && empty($error)){
				$this->__export_data($councelorList);
			}

			#Pagination
            $page      = $this->objPagination->get_page();
            $last_page = $this->objPagination->get_last_page();
            $pagenext = $page + 1;
            $pageprevious = $page - 1;

            $right = $page < $last_page;
            $left = $page > 1;

            if(empty($error)) {
                $this->objPagination->set_found_rows(count($councelorList));
            }
            $current = $this->objPagination->getHeading();
        }

		
		#pE

		$sugarSmarty = new Sugar_Smarty();
		$sugarSmarty->assign("batchList",$batchList);

		$sugarSmarty->assign("reportDataList",$councelorList);

		$sugarSmarty->assign("selected_batch",$selected_course);
		$sugarSmarty->assign("selected_status",$selected_status);
		$sugarSmarty->assign("selected_from_date",$selected_from_date);
		$sugarSmarty->assign("selected_to_date",$selected_to_date);

		$sugarSmarty->assign("current_records",$current);
		$sugarSmarty->assign("page",$page);
		$sugarSmarty->assign("pagenext", $pagenext);
		$sugarSmarty->assign("pageprevious", $pageprevious);
		$sugarSmarty->assign("right",$right);
//		$sugarSmarty->assign("leftpage",$leftpage);
		$sugarSmarty->assign("left",$left);
		$sugarSmarty->assign("table_width",7*200);

		$sugarSmarty->assign("last_page",$last_page);
		$sugarSmarty->display('custom/modules/AOR_Reports/tpls/dailyreport.tpl');
	}


	function __formate_data($dataArr,$batchArr){
		$formate__res_arr = [];

		return $formate__res_arr;
	}

	function __export_data($row_data=array()){
		    $data     = "Source, Program Name, Batch Name, Batch Code,No. of Leads Generated,No. of Conversions, GSV\n";
		    $file     = "daily_report";
		    $filename = $file . "_" . date("Y-m-d");
		    foreach ($row_data as $key => $councelor)
		    {
		       
		        $data .= "\"" . $councelor['vendor'] . "\",\"" . $councelor['program_name'] . "\",\"" . $councelor['batch'] . "\",\"" . $councelor['batch_code'] . "\",\"" .$councelor['total'] . "\",\"" .$councelor['converted'] . "\",\"" . $councelor['gsv'] . "\"\n";
		    }
		    ob_end_clean();
		    header("Content-type: application/csv");
		    header('Content-disposition: attachment;filename=" ' . $filename . '.csv";');
		    echo $data;
		    exit;
	}
	function dateDiff ($d1, $d2) {
		// Return the number of days between the two dates:
	  	return round(abs(strtotime($d1)-strtotime($d2))/86400);
	}
}
?>