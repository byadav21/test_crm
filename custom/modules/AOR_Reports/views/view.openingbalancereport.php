<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');

class AOR_ReportsViewopeningbalancereport extends SugarView
{

    var $report_to_id;
    var $counsellors_arr;

    public function __construct()
    {
        parent::SugarView();
    }

    function getBatch()
    {
        global $db;
        //batch_status='enrollment_in_progress' AND   {commented for getting old one alos}
        $batchSql     = "SELECT id,name,batch_code FROM te_ba_batch WHERE  deleted=0 order by batch_code   ";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        while ($row          = $db->fetchByAssoc($batchObj))
        {
            $batchOptions[] = $row;
        }
        return $batchOptions;
    }

    function getDueDate()
    {

        global $db;

        $batchSql     = "SELECT 
            bb.id batch_id, bb.batch_code, inst.due_date,inst.payment_inr
        FROM te_ba_batch bb
            INNER JOIN  `te_ba_batch_te_installments_1_c` binst_rel ON bb.id = binst_rel.te_ba_batch_te_installments_1te_ba_batch_ida
            INNER JOIN te_installments inst ON binst_rel.te_ba_batch_te_installments_1te_installments_idb = inst.id
        WHERE bb.deleted =0
        AND binst_rel.deleted =0
        AND inst.deleted =0
        ORDER BY bb.id, inst.due_date";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        while ($row          = $db->fetchByAssoc($batchObj))
        {
            $batchOptions[$row['batch_id']][] = $row['due_date'];//array('due_date' => $row['due_date'], 'payment_inr' => $row['payment_inr']);
        }
        return $batchOptions;
    }

    function getInstitute()
    {

        global $db;

        $batchSql     = "SELECT 
            bb.id batch_id, bb.batch_code, i.name
        FROM te_ba_batch bb
            INNER JOIN te_in_institutes_te_ba_batch_1_c AS ib ON bb.id=ib.te_in_institutes_te_ba_batch_1te_ba_batch_idb AND ib.deleted=0
            INNER JOIN te_in_institutes as i on ib.te_in_institutes_te_ba_batch_1te_in_institutes_ida=i.id AND i.deleted=0
        WHERE bb.deleted =0";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        while ($row          = $db->fetchByAssoc($batchObj))
        {
            $batchOptions[$row['batch_id']] = $row['name'];
        }
        return $batchOptions;
    }

    public function display()
    {
        global $sugar_config, $app_list_strings, $current_user, $db;
        $current_user_id       = $current_user->id;
        $current_user_is_admin = $current_user->is_admin;
        $where                 = "";
        $wherecl               = "";
        $BatchListData         = $this->getBatch();
        $getDueDateData        = $this->getDueDate();
        $getInstituteData      = $this->getInstitute();
        $usersdd               = "";
	$from_date = (isset($_POST['from_date']) && !empty($_POST['from_date']))? $_POST['from_date'] : "2018-04-01";
	$to_date = (isset($_POST['to_date']) && !empty($_POST['to_date']))? $_POST['to_date'] : date('Y-m-d');

        if ($from_date)
        {
            $_SESSION['ob_from_date'] = $from_date;
	    $selected_from_date = $from_date; 
	    $wherecl .= " AND  DATE(p.date_of_payment ) >='".$from_date."' ";
        }
	if ($to_date)
        {
            $_SESSION['ob_to_date'] = $to_date;
	    $selected_to_date = $to_date; 
	    $wherecl .= " AND  DATE(p.date_of_payment ) <='".$to_date."' ";
        }


        $findBatch = array();

        $paymentList = array();
        $StatusList  = array();

		$leadSql = "SELECT l.id,lc.email_add_c,l.first_name,l.last_name,l.phone_mobile,l.converted_date,l.vendor,lc.te_ba_batch_id_c,b.name AS batch,b.batch_code,b.fees_inr,p.id AS payment_id,p.`payment_source`,p.`date_of_payment` , p.`amount` , p.`invoice_number` , p.`invoice_order_number` , p.`tax_type` , p.`tax` , p.`country` , DATE_FORMAT( p.date_of_payment,'%b')Month , 
		CASE WHEN MONTH( l.`converted_date` ) >=4
		THEN  'New'
		ELSE  'Spillover'
		END AS category
		FROM  `te_payment_details` AS p
		INNER JOIN leads_te_payment_details_1_c AS lpr
		ON lpr.leads_te_payment_details_1te_payment_details_idb = p.id
		INNER JOIN leads AS l ON l.id=lpr.leads_te_payment_details_1leads_ida
		INNER JOIN leads_cstm AS lc ON l.id=lc.id_c
		INNER JOIN te_ba_batch AS b ON b.id=lc.te_ba_batch_id_c
		WHERE p.deleted =0 AND lpr.deleted=0 AND l.deleted=0
		$wherecl ORDER BY p.date_of_payment ASC";

		$leadObj = $db->query($leadSql);
		while ($row = $db->fetchByAssoc($leadObj))
            	{
			//echo "<pre>";
			//print_r($row);
			$paymentList[$row['id']][$row['payment_id']]['institute']        = $getInstituteData[$row['te_ba_batch_id_c']];
			$paymentList[$row['id']][$row['payment_id']]['te_ba_batch_id_c']        = $row['te_ba_batch_id_c'];
			$paymentList[$row['id']][$row['payment_id']]['batch_code']        = $row['batch_code'];
			$paymentList[$row['id']][$row['payment_id']]['course']        = $row['batch'];
			$paymentList[$row['id']][$row['payment_id']]['month']        = $row['Month'];
			$paymentList[$row['id']][$row['payment_id']]['category']        = $row['category'];
			$paymentList[$row['id']][$row['payment_id']]['country']        = $row['country'];
			$paymentList[$row['id']][$row['payment_id']]['fees_inr']        = $row['fees_inr'];
			$paymentList[$row['id']][$row['payment_id']]['total_amt']        = $row['fees_inr'] + ($row['fees_inr'] * 0.18);
			$paymentList[$row['id']][$row['payment_id']]['gst']        = $row['fees_inr'] * 0.18;
			$paymentList[$row['id']][$row['payment_id']]['date_of_payment']        = ($row['date_of_payment']) ? $row['date_of_payment'] : '';
			$paymentList[$row['id']][$row['payment_id']]['amount']        = $row['amount'];
			$paymentList[$row['id']][$row['payment_id']]['invoice_number']        = $row['invoice_number'];
			$paymentList[$row['id']][$row['payment_id']]['invoice_order_number']        = $row['invoice_order_number'];
			$paymentList[$row['id']][$row['payment_id']]['payment_source']        = $row['payment_source'];
			$paymentList[$row['id']][$row['payment_id']]['vendor']        = $row['vendor'];
			$paymentList[$row['id']][$row['payment_id']]['id']        = $row['id'];
			$paymentList[$row['id']][$row['payment_id']]['email_add_c']        = $row['email_add_c'];
			$paymentList[$row['id']][$row['payment_id']]['phone_mobile']        = $row['phone_mobile'];
			$paymentList[$row['id']][$row['payment_id']]['full_name']        = $row['first_name'].' '.$row['last_name'];
			$paymentList[$row['id']][$row['payment_id']]['converted_date']        = ($row['converted_date']) ? $row['converted_date'] : '';
		}
		$paymentListRes = [];
		$firstKey = '';
		$si_no = 1;
		if($paymentList){
			foreach($paymentList as $lead => $value){
				$i = 0 ;
				$k = 1 ;
				$count =  count($value);
				$outBal = [];
				foreach($value as $key => $val){
					$due_date = $getDueDateData[$val['te_ba_batch_id_c']][$i];
					$outBal[]   = $val['amount'];

					$paymentListRes[$key]['si_no']        = $si_no;
					$paymentListRes[$key]['institute']        = $getInstituteData[$val['te_ba_batch_id_c']];
					$paymentListRes[$key]['te_ba_batch_id_c']        = $val['te_ba_batch_id_c'];
					$paymentListRes[$key]['batch_code']        = $val['batch_code'];
					$paymentListRes[$key]['course']        = $val['course'];
					$paymentListRes[$key]['month']        = $val['month'];
					$paymentListRes[$key]['category']        = $val['category'];
					$paymentListRes[$key]['country']        = $val['country'];
					$paymentListRes[$key]['installment_type']        = 'Installment '.$k;
					$paymentListRes[$key]['due_date']        = $due_date;
					
					$paymentListRes[$key]['date_of_payment']        = $val['date_of_payment'];
					$paymentListRes[$key]['amount']        = $val['amount'];
					$paymentListRes[$key]['invoice_number']        = $val['invoice_number'];
					$paymentListRes[$key]['invoice_order_number']        = $val['invoice_order_number'];
					$paymentListRes[$key]['payment_source']        = $val['payment_source'];
					$paymentListRes[$key]['vendor']        = $val['vendor'];
					$paymentListRes[$key]['id']        = $val['id'];
					$paymentListRes[$key]['email_add_c']        = $val['email_add_c'];
					$paymentListRes[$key]['phone_mobile']        = $val['phone_mobile'];
					$paymentListRes[$key]['full_name']        = $val['full_name'];
					$paymentListRes[$key]['converted_date']        = $val['converted_date'];
					if($i==0){
						$firstKey = $key;
						$paymentListRes[$key]['fees_inr']        = $val['fees_inr'];
						$paymentListRes[$key]['total_amt']        = $val['total_amt'];
						$paymentListRes[$key]['gst']        = $val['fees_inr'] * 0.18;
					}
					else{
						$paymentListRes[$key]['fees_inr']        = '';
						$paymentListRes[$key]['total_amt']        = '';
						$paymentListRes[$key]['gst']        = '';
					}
					
				$i++;
				$k++;
				$si_no++;
				}$paymentListRes[$firstKey]['ob']=$paymentListRes[$firstKey]['total_amt'] - array_sum($outBal);
			}
		}

	//echo "<pre>";print_r($paymentListRes);exit();
	
            if (isset($_POST['export']) && $_POST['export'] == "Export")
		{

		    $file        = "gsv_ob_report";
		    $where       = '';
		    $filename    = $file . "_" . $from_date . "_" . $to_date;
		
		    # Create heading
		    $data = "SI No.";
		    $data .= ",Category";
		    $data .= ",Batch Code";


		    $data .= ",Course Name";
		    $data .= ",Lead Source Name";
		    $data .= ",Institute Name";
		    $data .= ",Registration Date";


		    $data .= ",Student Name";
		    
		    $data .= ",Lead ID";
		    $data .= ",Email";
		    $data .= ",Phone";


		    $data .= ",Installment Type";
		    $data .= ",Invoice No";
		    $data .= ",Course Fee";
		    $data .= ",GST";


		    $data .= ",Total Amt";
		    $data .= ",Outstanding Balance";
		    $data .= ",Order No";
		    $data .= ",Order Amt";
		    $data .= ",Payment Source";
		    $data .= ",Month";
		    
		    $data .= ",Date of Payment";
		    $data .= ",Due date";
		    $data .= "\n";




		    foreach ($paymentListRes as $key => $datax)
		    {
			
		        $data .= "\"" . $datax['si_no'];


		        $data .= "\",\"" . $datax['category'];
		        $data .= "\",\"" . $datax['batch_code'];
		        $data .= "\",\"" . $datax['course'];
		        $data .= "\",\"" . $datax['vendor'];

		        $data .= "\",\"" . $datax['institute'];
		        
		        $data .= "\",\"" . $datax['converted_date'];
		        $data .= "\",\"" . $datax['full_name'];
		        $data .= "\",\"" . $datax['id'];
		        

		        $data .= "\",\"" . $datax['email_add_c'];
		        $data .= "\",\"" . $datax['phone_mobile'];
		        $data .= "\",\"" . $datax['installment_type'];
		        $data .= "\",\"" . $datax['invoice_number'];
			$data .= "\",\"" . $datax['fees_inr'];
			$data .= "\",\"" . $datax['gst'];
			$data .= "\",\"" . $datax['total_amt'];
			$data .= "\",\"" . $datax['ob'];
			$data .= "\",\"" . $datax['invoice_order_number'];
			$data .= "\",\"" . $datax['amount'];
			$data .= "\",\"" . $datax['payment_source'];
			$data .= "\",\"" . $datax['month'];
			$data .= "\",\"" . $datax['date_of_payment'];
			$data .= "\",\"" . $datax['due_date'];

		        $data .= "\"\n";
		    }

		    ob_end_clean();
		    header("Content-type: application/csv");
		    header('Content-disposition: attachment;filename=" ' . $filename . '.csv";');
		    echo $data;
		    exit;
		}

        

        $total     = count($paymentListRes); #total records
        $start     = 0;
        $per_page  = 60;
        $page      = 1;
        $pagenext  = 1;
        $last_page = ceil($total / $per_page);

        if (isset($_REQUEST['page']) && $_REQUEST['page'] > 0)
        {
            $start    = $per_page * ($_REQUEST['page'] - 1);
            $page     = ($_REQUEST['page'] - 1);
            $pagenext = ($_REQUEST['page'] + 1);
        }
        else
        {

            $pagenext++;
        }
        if (($start + $per_page) < $total)
        {
            $right = 1;
        }
        else
        {
            $right = 0;
        }
        if (isset($_REQUEST['page']) && $_REQUEST['page'] == 1)
        {
            $left = 0;
        }
        elseif (isset($_REQUEST['page']))
        {

            $left = 1;
        }

        $paymentListRes = array_slice($paymentListRes, $start, $per_page);
        if ($total > $per_page)
        {
            $current = "(" . ($start + 1) . "-" . ($start + $per_page) . " of " . $total . ")";
        }
        else
        {
            $current = "(" . ($start + 1) . "-" . count($paymentListRes) . " of " . $total . ")";
        }
        #pE

        $sugarSmarty = new Sugar_Smarty();


        $sugarSmarty->assign("paymentList", $paymentListRes);
        $sugarSmarty->assign("selected_from_date", $selected_from_date);
        $sugarSmarty->assign("selected_to_date", $selected_to_date);

        $sugarSmarty->assign("current_records", $current);
        $sugarSmarty->assign("page", $page);
        $sugarSmarty->assign("pagenext", $pagenext);
        $sugarSmarty->assign("right", $right);
        $sugarSmarty->assign("left", $left);
        $sugarSmarty->assign("last_page", $last_page);
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/openingbalancereport.tpl');
    }

}

?>
