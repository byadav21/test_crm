<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
ini_set('memory_limit', '1024M');
require_once('include/entryPoint.php');
global $db;
$data         = json_decode(file_get_contents('php://input'), true);
$error_fields = [];
$discount     = ' 0';



if (empty($data))
{
    $error_fields['error:'] = ['empty data'];
}


if ($error_fields)
{
    $response_result = array('status' => '400', 'result' => $error_fields);
    echo json_encode($response_result);
    exit();
}
else
{


    foreach ($data as $key => $val)
    {


        $crm_orderid = $val['crm_orderid'];

        if (!$crm_orderid)
        {
            continue;
        }

        /* check valid crm_payment_id in case of update */
        if ($crm_orderid != '')
        {
            $getAllPayments = getAllPaymentsid($crm_orderid);

            if (!empty($getAllPayments))
            {

                foreach ($getAllPayments as $paymentId)
                {
                    $paymentId = $paymentId['paymentId'];
                    $query     = "UPDATE te_payment_details SET invoice_number='" . $val['invno'] . "' WHERE id='" . $paymentId . "'";
                    $GLOBALS['db']->query($query);

                    //$fp = fopen('invoiceNo2_API_log_.txt', 'a');
                    //fwrite($fp, $query);
                    //fclose($fp);
                }
            }
        }
    }
}

function getAllPaymentsid($crm_orderid)
{
    $queryPid = "SELECT 
            pd_rel.leads_te_payment_details_1leads_ida AS lead_id
            FROM `te_payment_details` pd
            INNER JOIN leads_te_payment_details_1_c pd_rel ON 
            pd.id = pd_rel.leads_te_payment_details_1te_payment_details_idb
            WHERE pd.id = '$crm_orderid' limit 1";

    $payment_Obj = $GLOBALS['db']->query($queryPid);
    $row         = $GLOBALS['db']->fetchByAssoc($payment_Obj);

    if (!empty($row))
    {
        $leadId   = $row['lead_id'];
        $queryPid = "SELECT leads_te_payment_details_1te_payment_details_idb as paymentId 
                    FROM  `leads_te_payment_details_1_c` 
                    WHERE  `leads_te_payment_details_1leads_ida` =  '$leadId'";

        $payment_Obj = $GLOBALS['db']->query($queryPid);

        $paymentArra = array();
        while ($row         = $GLOBALS['db']->fetchByAssoc($payment_Obj))
        {
            $paymentArra[] = $row;
        }

        //$fp = fopen('invoiceNo3_API_log_.txt', 'a');
        //fwrite($fp, print_r($paymentArra, TRUE));
        //fclose($fp);
        return $paymentArra;
    }
}
