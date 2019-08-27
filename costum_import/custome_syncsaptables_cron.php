<?php

error_reporting(-1);
ini_set('display_errors', 'On');

#For Institutes :  Customers 
#For Students :  StudCustomers 
#For Courses/Programs :  Items 
#For Vendors :   Supplier 
#Invoices Header : Stud_OINV 
#Invoices Rows : Stud_INV1 
#Invoices Ship To State : Stud_INV12 
#Payments Header : WEB_ORCT 
#Payment Details like Check Amount / Due Date : WEB_RCT1 
#Payment Against Invoice : WEB_RCT2 
#Projects : WEB_OPRJ

include 'db.php';
include 'sap_db.php';

class syncsaptables
{

    function createLog($action, $filename, $field = '', $dataArray = array())
    {
        $file = fopen(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) . "upload/apilog/$filename", "a");
        fwrite($file, date('Y-m-d H:i:s') . "\n");
        fwrite($file, $action . "\n");
        fwrite($file, $field . "\n");
        fwrite($file, print_r($dataArray, TRUE) . "\n");
        fclose($file);
    }

    function SyncSapTimestamp()
    {
        global $conn, $sap_conn;
        $query   = "SELECT reg_date FROM   `SYNC_SAP_TIMESTAMP` order by reg_date desc limit 1";
        $leadObj = mysqli_query($sap_conn, $query);
        $row     = mysqli_fetch_assoc($leadObj);

        return $row['reg_date'];
    }

    function WEB_RCT1()
    {

        global $conn;
        $leadsCstmData = array();


        $query   = "SELECT 
                        replace(`pd`.`id`, '-', '') AS `U_OrigEntry`,
                        `pd`.`date_of_payment` AS `DueDate`,
                        round((`pd`.`amount` * 0.01),2) AS `CheckSum`,
                        `pd`.`Pay_Status` AS `Pay_Status`
                 FROM (((((`te_student` `s`
                       JOIN `te_student_te_student_batch_1_c` `stsb` on((`s`.`id` = `stsb`.`te_student_te_student_batch_1te_student_ida`)))
                       JOIN `te_student_batch` `sb` on((`stsb`.`te_student_te_student_batch_1te_student_batch_idb` = `sb`.`id`)))
                       JOIN `te_student_payment` `sp` on((`stsb`.`te_student_te_student_batch_1te_student_batch_idb` = `sp`.`te_student_batch_id_c`)))
                       JOIN `te_payment_details` `pd` on((`sp`.`id` = `pd`.`student_payment_id`)))
                       JOIN leads_te_payment_details_1_c AS lp ON lp.leads_te_payment_details_1te_payment_details_idb=pd.id
                       JOIN `leads` on((`sb`.`leads_id` = `leads`.`id`)))
                 WHERE  pd.deleted=0 AND lp.deleted=0  AND `pd`.`date_of_payment` > '2018-03-31'";
        $leadObj = mysqli_query($conn, $query);
        if ($leadObj)
        {

            while ($row = mysqli_fetch_assoc($leadObj))
            {
                $leadsCstmData[] = $row;
            }
        }

        return $leadsCstmData;
    }

    function WEB_RCT2()
    {

        global $conn;
        $leadsCstmData = array();


        $query   = "SELECT replace(`pd`.`id`, '-', '') AS `U_OrigEntry`,
                            `pd`.`SAP_DocEntry` AS `DocEntry`,
                             0 AS `InvoiceId`,
                            `pd`.`amount` AS `SumApplied`,
                            `pd`.`Pay_Status` AS `Pay_Status`,
                             `s`.`SAP_CardCode` AS `CardCode`,
                            `pd`.`invoice_number` AS `U_OrigNum`
                     FROM (((((`te_student` `s`
                               JOIN `te_student_te_student_batch_1_c` `stsb` on((`s`.`id` = `stsb`.`te_student_te_student_batch_1te_student_ida`)))
                              JOIN `te_student_batch` `sb` on((`stsb`.`te_student_te_student_batch_1te_student_batch_idb` = `sb`.`id`)))
                             JOIN `te_student_payment` `sp` on((`stsb`.`te_student_te_student_batch_1te_student_batch_idb` = `sp`.`te_student_batch_id_c`)))
                            JOIN `te_payment_details` `pd` on((`sp`.`id` = `pd`.`student_payment_id`)))
                            JOIN leads_te_payment_details_1_c AS lp ON lp.leads_te_payment_details_1te_payment_details_idb=pd.id
                           JOIN `leads` on((`sb`.`leads_id` = `leads`.`id`)))
                     WHERE pd.deleted=0 AND lp.deleted=0 AND `pd`.`date_of_payment` > '2018-04-31'";
        $leadObj = mysqli_query($conn, $query);
        if ($leadObj)
        {

            while ($row = mysqli_fetch_assoc($leadObj))
            {
                $leadsCstmData[] = $row;
            }
        }

        return $leadsCstmData;
    }

    function main()
    {

        global $sap_conn;

        $WEB_RCT1Arr = array();
        $WEB_RCT2Arr = array();

        #9. /////////// WEB_RCT1 Table Syncing //////////////////
        $WEB_RCT1Arr = $this->WEB_RCT1();

        echo '<hr>WEB_RCT1 Table Syncing ';

        $custSQL = "INSERT INTO `WEB_RCT1` (`U_OrigEntry`, `DueDate`,`CheckSum`,`Pay_Status`) VALUES ";
        $i       = 1;
        foreach ($WEB_RCT1Arr as $key => $data)
        {
            $custSQL .= "('" . $data['U_OrigEntry'] . "','" . $data['DueDate'] . "','" . $data['CheckSum'] . "','" . $data['Pay_Status'] . "'),";

            $i++;
        }
        $exeSql = rtrim($custSQL, ',');
        if ($i > 1)
        {
            mysqli_query($sap_conn, $exeSql) or die(mysqli_error($sap_conn));
        }
        unset($WEB_RCT1Arr);




        #10. /////////// WEB_RCT2 Table Syncing //////////////////

        $WEB_RCT2Arr = $this->WEB_RCT2();

        echo '<hr>WEB_RCT2 Table Syncing ';

        $custSQL = "INSERT INTO `WEB_RCT2` (`U_OrigEntry`, `DocEntry`,`SumApplied`,`Pay_Status`,`CardCode`,`U_OrigNum`) VALUES ";
        $i       = 1;
        foreach ($WEB_RCT2Arr as $key => $data)
        {
            $custSQL .= "('" . $data['U_OrigEntry'] . "','" . $data['DocEntry'] . "','" . $data['SumApplied'] . "','" . $data['Pay_Status'] . "','" . $data['CardCode'] . "','" . $data['U_OrigNum'] . "'),";
            $i++;
        }
        $exeSql = rtrim($custSQL, ',');
        if ($i > 1)
        {
            mysqli_query($sap_conn, $exeSql) or die(mysqli_error($sap_conn));
        }
        unset($WEB_RCT2Arr);
    }

// END of Main
}

$mainObj = new syncsaptables();
$mainObj->main();
?>		 
