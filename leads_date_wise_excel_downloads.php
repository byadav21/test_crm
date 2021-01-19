<?php
if(!defined('sugarEntry'))

define('sugarEntry', true);

require_once ('include/entryPoint.php');

global $db;

error_reporting(E_ALL);

    if(!empty($_REQUEST['startdate']) && !empty($_REQUEST['enddate'])){
        $startDate 	= date("Y-m-d", strtotime($_REQUEST['startdate']));
        $endDate 	= date("Y-m-d", strtotime($_REQUEST['enddate']));	
        // echo "StartDate:- ".$startDate." && EndDate:- ".$endDate."<br/>";
    }
    
    $query ="SELECT DISTINCT(lc.email_add_c) FROM leads AS l INNER JOIN leads_cstm AS lc ON l.id = lc.id_c where l.date_entered > '$startDate' AND l.date_entered <= '$endDate' AND l.status = 'Converted' ";

    $result = $db->query($query);
    // print_r($result);
    while (($row = $db->fetchByAssoc($result)) != null) {
        // echo "<pre>";print_r($row);echo "</pre>";
        $selectQuery = "SELECT l.id, md5(l.phone_mobile) AS Mobile_Encripted, md5(lc.email_add_c) AS Email_Encripted, lc.te_ba_batch_id_c, l.vendor, l.converted_date, l.status, l.status_description, l.date_entered FROM leads AS l
        INNER JOIN leads_cstm AS lc ON l.id = lc.id_c
        WHERE lc.email_add_c = '".$row['email_add_c']."'
        order by l.date_entered DESC ";

        $resultselect = $db->query($selectQuery);
        // echo $resultselect->num_rows;
        // echo "<pre>";print_r($resultselect);echo "</pre>";
        while (($getAllData = $db->fetchByAssoc($resultselect)) != null) {
            
            $programList[$row['email_add_c']][$getAllData['id']]['id']                  = $getAllData['id'];
            $programList[$row['email_add_c']][$getAllData['id']]['phone_mobile']        = $getAllData['Mobile_Encripted'];
            $programList[$row['email_add_c']][$getAllData['id']]['email_add_c']         = $getAllData['Email_Encripted'];
            $programList[$row['email_add_c']][$getAllData['id']]['te_ba_batch_id_c']    = $getAllData['te_ba_batch_id_c'];
            $programList[$row['email_add_c']][$getAllData['id']]['vendor']              = $getAllData['vendor'];
            $programList[$row['email_add_c']][$getAllData['id']]['converted_date']      = $getAllData['converted_date'];
            $programList[$row['email_add_c']][$getAllData['id']]['status']              = $getAllData['status'];
            $programList[$row['email_add_c']][$getAllData['id']]['status_description']  = $getAllData['status_description'];
            $programList[$row['email_add_c']][$getAllData['id']]['date_entered']        = $getAllData['date_entered']; 
        }
        
    }
    // echo "<pre>";print_r($programList);echo "</pre>";

    // die('imhere');
    $file     = "leads_date_wise_converted";
    $where    = '';
    $filename = $file . "_" . $startDate . "_" . $endDate;

    # Create heading
    $data  = "ID";
    $data .= ",Mobile Encripted";
    $data .= ",Email Encripted";
    $data .= ",Batch Code";
    $data .= ",Vendor";
    $data .= ",Converted Date";
    $data .= ",Status";
    $data .= ",Status Description";
    $data .= ",Date";

    $data .= "\n";

    // echo "<pre>";print_r($programList);exit();
    foreach ($programList as $key => $councelor)
    {
        foreach($councelor as $key1 => $value){
            foreach($value as $key2 =>$value2){
                $countedLead =  $value2;
                $data        .= "\",\"" . $countedLead;
            }
            $data .= "\"\n";
        }
    }
    

    ob_end_clean();
    header("Content-type: application/csv");
    header('Content-disposition: attachment;filename=" ' . $filename . '.csv";');
    echo $data;
    exit;


 ?>