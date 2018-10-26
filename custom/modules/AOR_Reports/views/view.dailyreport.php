<?php
    if (!defined('sugarEntry') || !sugarEntry)
        die('Not A Valid Entry Point');
    require_once('custom/include/Email/sendmail.php');
    class AOR_ReportsViewDailyreport extends SugarView {

        public function __construct() {
            parent::SugarView();
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
                $wheredr .= " AND DATE(l.date_entered)>='" . $_SESSION['dr_from_date'] . "'";
            }
            if (!empty($_SESSION['dr_to_date']))
            {
                $selected_to_date = date("d-m-Y",strtotime($_SESSION['dr_to_date']));
                $wheredr .= " AND DATE(l.date_entered)<='" . $_SESSION['dr_to_date'] . "'";
            }
            if (!empty($_SESSION['dr_batch']))
            {
                $selected_course = $_SESSION['dr_batch'];
                $wheredr .= " AND lc.te_ba_batch_id_c IN ('" . implode("','", $selected_course) . "')";
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
                $leadObj = $db->query($leadSql);
                while ($row = $db->fetchByAssoc($leadObj)){
                    $dataArr[] = $row;
                }
                $councelorList = $this->__formate_data($dataArr,$batchList);
                if(isset($_REQUEST['export'])){
                    $this->__export_data($councelorList);
                }
                #Pagination
                $total=count($councelorList); #total records
                $start=0;
                $per_page=10;
                $page=1;
                $pagenext=1;
                $last_page=ceil($total/$per_page);

                if(isset($_REQUEST['page']) && $_REQUEST['page']>0){
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
            $sugarSmarty->assign("right",$right);
            $sugarSmarty->assign("leftpage",$leftpage);
            $sugarSmarty->assign("left",$left);
            $sugarSmarty->assign("last_page",$last_page);
            $sugarSmarty->display('custom/modules/AOR_Reports/tpls/dailyreport.tpl');
        }
        function __formate_data($dataArr,$batchArr){
            $formate_arr = [];
            $formate__res_arr = [];
            foreach($dataArr as $val){
                $batchID = ($val['te_ba_batch_id_c']) ? $val['te_ba_batch_id_c'] : "NA";
                $vendorName = $val['vendor'];
                $formate_arr[$batchID.'_'.$vendorName]['vendor']=$vendorName;
                $formate_arr[$batchID.'_'.$vendorName]['batch']=($batchArr[$val['te_ba_batch_id_c']]['name']) ? $batchArr[$val['te_ba_batch_id_c']]['name'] : "NA";
                $formate_arr[$batchID.'_'.$vendorName]['batch_code']=($batchArr[$val['te_ba_batch_id_c']]['batch_code']) ? $batchArr[$val['te_ba_batch_id_c']]['batch_code'] : "NA";
                $formate_arr[$batchID.'_'.$vendorName]['program_name']=($batchArr[$val['te_ba_batch_id_c']]['program_name']) ? $batchArr[$val['te_ba_batch_id_c']]['program_name'] : "NA";
                $formate_arr[$batchID.'_'.$vendorName]['fees_inr']=($batchArr[$val['te_ba_batch_id_c']]['fees_inr']) ? $batchArr[$val['te_ba_batch_id_c']]['fees_inr'] : 0;
                $formate_arr[$batchID.'_'.$vendorName]['status'][$val['status']][]=1;
            }
            if($formate_arr){
                foreach($formate_arr as $key=>$val){
                    $formate__res_arr[$key]=$val;
                    $total = [];
                    $converted = 0;
                    $fee = $val['fees_inr'];
                    foreach($val['status'] as $statuskey=>$statusval){
                        if($statuskey=='Converted'){$converted = count($val['status']['Converted']);}
                        $total[]=count($statusval);
                    }
                    $formate__res_arr[$key]['total']=array_sum($total);
                    $formate__res_arr[$key]['converted']=$converted;
                    $formate__res_arr[$key]['gsv']=0;
                    if($fee>0 && $converted>0){
                        $gsv = $fee*$converted;
                        $formate__res_arr[$key]['gsv']=round($gsv,2);
                    }
                    unset($formate__res_arr[$key]['status']);
                }
            }
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