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

     function WEB_ORCT()
    {

        global $conn;
        $leadsCstmData    = array();
        $SyncSapTimestamp = $this->SyncSapTimestamp();
        $currentTime      = date('Y-m-d H:i:s');
       

         $query   = "SELECT replace(`pd`.`id`, '-', '') AS `U_OrigEntry`,
                        `pd`.`date_of_payment` AS `DocDate`,
                        `pd`.`date_of_payment` AS `DocDueDate`,
                        `pd`.`date_of_payment` AS `TaxDate`,
                        `s`.`SAP_CardCode` AS `CardCode`,
                        concat_ws(' ',`leads`.`primary_address_street`, `leads`.`primary_address_city`,`leads`.`primary_address_state`,`leads`.`primary_address_postalcode`) AS `Address`,
                        `pd`.`Pay_Status` AS `Pay_Status`,
                        `pd`.`transaction_id` AS `U_PaymnetID`,
                        `pd`.`invoice_number` AS `U_OrigNum`,
                        (CASE
                             WHEN (`pd`.`payment_source` IN ('PayU',
                                                             'payu_in')) THEN 'PayU'
                             ELSE `pd`.`payment_source`
                         END) AS `U_PaymentGateway`,
                        (CASE
                             WHEN (`pd`.`payment_source` IN ('PayU',
                                                             'payu_in')) THEN '_SYS00000000107'
                             WHEN (`pd`.`payment_source` = 'ATOM') THEN '_SYS00000000105'
                             WHEN (`pd`.`payment_source` = 'Paytm') THEN '_SYS00000000106'
                             ELSE `pd`.`payment_source`
                         END) AS `CheckAcct`,
                        '_SYS00000000188' AS `CashAcct`,
                        (CASE
                             WHEN (`pd`.`payment_source` IN ('PayU',
                                                             'payu_in')) THEN ' _SYS00000000293'
                             ELSE `pd`.`payment_source`
                         END) AS `TrsfrAcct`,
                        round((`pd`.`amount` * 0.9882),2) AS `TrsfrSum`,
                        round((`pd`.`amount` * 0.01),2) AS `CheckSum`,
                        round(((`pd`.`amount` * 0.01) * 0.18),2) AS `CashSum`
                 FROM (((((`te_student` `s`
                           JOIN `te_student_te_student_batch_1_c` `stsb` on((`s`.`id` = `stsb`.`te_student_te_student_batch_1te_student_ida`)))
                          JOIN `te_student_batch` `sb` on((`stsb`.`te_student_te_student_batch_1te_student_batch_idb` = `sb`.`id`)))
                         JOIN `te_student_payment` `sp` on((`stsb`.`te_student_te_student_batch_1te_student_batch_idb` = `sp`.`te_student_batch_id_c`)))
                        JOIN `te_payment_details` `pd` on((`sp`.`id` = `pd`.`student_payment_id`)))
                        JOIN leads_te_payment_details_1_c AS lp ON lp.leads_te_payment_details_1te_payment_details_idb=pd.id
                       JOIN `leads` on((`sb`.`leads_id` = `leads`.`id`)))
                 WHERE   `sb`.`deleted` = 0
                        AND `pd`.`deleted` = 0 AND pd.deleted=0 AND lp.deleted=0 
                        AND `pd`.`date_entered` > '2019-02-26 16:28:43' AND `pd`.`date_entered` <= '2019-06-29 22:16:43' 
                        AND `pd`.`amount` <> 0";
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

        $WEB_ORCTArr      = array();
        
         #8. /////////// WEB_ORCT Table Syncing //////////////////
        
        $WEB_ORCTArr = $this->WEB_ORCT();
        echo '<hr>WEB_ORCT Table Syncing ';

        $custSQL = "INSERT INTO `WEB_ORCT` (`U_OrigEntry`, `DocDate`,`DocDueDate`,`TaxDate`,`CardCode`,`Address`,`Pay_Status`,`U_PaymnetID`,`U_PaymentGateway`,`CheckAcct`,`CashAcct`,`TrsfrSum`,`TrsfrAcct`,`CheckSum`,`CashSum`,`U_OrigNum`) VALUES ";
        $i       = 1;
        foreach ($WEB_ORCTArr as $key => $data)
        {

            $Address = mysqli_real_escape_string($sap_conn, $data['Address']);
            $Address = ($Address=='0')? '': $Address;
            
            $custSQL .= "('" . $data['U_OrigEntry'] . "',
                '" . $data['DocDate'] . "',
	        '" . $data['DocDueDate'] . "',
		'" . $data['TaxDate'] . "',
		'" . $data['CardCode'] . "',
		'" . $Address. "',
		'" . $data['Pay_Status'] . "',
                '" . $data['U_PaymnetID'] . "',
                '" . $data['U_PaymentGateway'] . "',
                '" . $data['CheckAcct'] . "',
                '" . $data['CashAcct'] . "',
                '" . $data['TrsfrSum'] . "',
                '" . $data['TrsfrAcct'] . "',
                '" . $data['CheckSum'] . "',
                '" . $data['CashSum'] . "','" . $data['U_OrigNum'] . "'),";


            $i++;
        }
        $exeSql = rtrim($custSQL, ',');
        if ($i > 1)
        {
            mysqli_query($sap_conn, $exeSql) or die(mysqli_error($sap_conn));
        }
        unset($WEB_ORCTArr);



       
    }

// END of Main
}

$mainObj = new syncsaptables();
$mainObj->main();
?>		 
