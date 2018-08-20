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
        global $conn;
        $query   = "SELECT reg_date FROM   `SYNC_SAP_TIMESTAMP` order by reg_date desc limit 1";
        $leadObj = mysqli_query($conn, $query);
        $row     = mysqli_fetch_assoc($leadObj);

        return $row['reg_date'];
    }

    function Customers()
    {

        global $conn;
        $leadsCstmData    = array();
        $SyncSapTimestamp = $this->SyncSapTimestamp();



        $query   = "SELECT  replace(`te_in_institutes`.`id`, '-', '') AS `U_BPID`,
                            replace(`te_in_institutes`.`name`, '&', ' ') AS `CardName`,
                            replace(`te_in_institutes`.`description`, '&', ' ') AS `CardFName`
                     FROM   `te_in_institutes`
                     WHERE  `te_in_institutes`.`deleted` = 0 
                     AND    `te_in_institutes`.`date_entered` >= '" . $SyncSapTimestamp . "'
                     AND    `te_in_institutes`.`date_entered` <= '" . date('Y-m-d H:i:s') . "'";
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

    function StudCustomers()
    {

        global $conn;
        $leadsCstmData    = array();
        $SyncSapTimestamp = $this->SyncSapTimestamp();
        $currentTime      = date('Y-m-d H:i:s');


         $query = "SELECT
                        replace(`te_student`.`id`, '-', '') AS `U_BPId`,
                        replace(`te_student`.`name`, '&', ' ') AS `CardName`,
                        replace(`te_student`.`description`, '&', ' ') AS `CardFName`,
                        `te_student`.`email` AS `E_Mail`,
                        `te_student`.`phone_other` AS `Phone1`,
                        `te_student`.`mobile` AS `Cellular`,
                        (CASE
                             WHEN (replace(`leads`.`primary_address_state`, 'Other', '') = 'Maharashtra') THEN 'MH'
                             WHEN (replace(`leads`.`primary_address_state`, 'Other', '') = 'Telangana') THEN 'TS'
                             WHEN (replace(`leads`.`primary_address_state`, 'Other', '') = 'Gujarat') THEN 'GJ'
                         END) AS `State1`,
                        (CASE
                             WHEN (replace(`leads`.`primary_address_state`, 'Other', '') = 'Maharashtra') THEN 'MH'
                             WHEN (replace(`leads`.`primary_address_state`, 'Other', '') = 'Telangana') THEN 'TS'
                             WHEN (replace(`leads`.`primary_address_state`, 'Other', '') = 'Gujarat') THEN 'GJ'
                         END) AS `State2`,
                        replace(replace(`leads`.`primary_address_country`, 'India', 'IN'), 'Other', '') AS `Country`,
                        replace(replace(`leads`.`primary_address_country`, 'India', 'IN'), 'Other', '') AS `MailCountr`, 
                        `te_student`.`SAP_Status` AS `SAP_Status`
                        
                 FROM `te_student`
                 JOIN `te_student_te_student_batch_1_c` `stsb` on `te_student`.`id` = `stsb`.`te_student_te_student_batch_1te_student_ida`
                 JOIN `te_student_batch` `sb` on `stsb`.`te_student_te_student_batch_1te_student_batch_idb` = `sb`.`id`
                 JOIN `leads` on `sb`.`leads_id` = `leads`.`id`
                 WHERE `leads`.`deleted` = 0
                   AND `te_student`.`date_entered` >= '$SyncSapTimestamp' AND `te_student`.`date_entered` <= '$currentTime'";

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

    function Items()
    {

        global $conn;
        $leadsCstmData    = array();
        $SyncSapTimestamp = $this->SyncSapTimestamp();
        $currentTime      = date('Y-m-d H:i:s');

        $query   = "SELECT replace(`pr`.`id`, '-', '') AS `U_CourseID`,
                            replace(`pr`.`name`, '&', ' ') AS `ItemName`,
                            replace(`pr`.`description`, '&', ' ') AS `FrgnName`,
                            `inst`.`name` AS `U_Institute`,
                            `pr`.`SAP_Status` AS `SAP_Status`
                      FROM  `te_pr_programs` `pr`
                            JOIN `te_in_institutes_te_pr_programs_1_c` `inst_rel` on `pr`.`id` = `inst_rel`.`te_in_institutes_te_pr_programs_1te_pr_programs_idb`
                            JOIN `te_in_institutes` `inst` on `inst_rel`.`te_in_institutes_te_pr_programs_1te_in_institutes_ida` = `inst`.`id`
                     WHERE  pr.deleted=0 
                     AND `pr`.`date_entered` >= '$SyncSapTimestamp' AND `pr`.`date_entered` <= '$currentTime'";
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

    function Supplier()
    {

        global $conn;
        $leadsCstmData    = array();
        $SyncSapTimestamp = $this->SyncSapTimestamp();
        $currentTime      = date('Y-m-d H:i:s');



        $query   = "SELECT 
                    replace(`te_vendor`.`id`, '-', '') AS `U_BPID`,
                    `te_vendor`.`name` AS `CardName`,
                    `te_vendor`.`description` AS `CardFName`,
                    `te_vendor`.`phone` AS `Phone1`,
                    `te_vendor`.`email` AS `E_Mail`,
                    `te_vendor`.`SAP_Status` AS `SAP_Status`
                FROM `te_vendor`
                WHERE  `te_vendor`.`name` <> ''
                       AND `te_vendor`.`date_entered` >= '$SyncSapTimestamp' AND `te_vendor`.`date_entered` >= '$currentTime'";
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

    function Stud_OINV()
    {

        global $conn;
        $leadsCstmData    = array();
        $SyncSapTimestamp = $this->SyncSapTimestamp();
        $currentTime      = date('Y-m-d H:i:s');
       

        $query   = "SELECT          
                             replace(`pd`.`id`, '-', '') AS `U_OrigEntry`,
                             `pd`.`invoice_number` AS `U_OrigNum`,
                             `pd`.`invoice_number` AS `U_ARInvNo`,
                             `te_vendor`.`SlpCode` AS `SlpCode`,
                             `pd`.`date_of_payment` AS `DocDate`,
                             `pd`.`date_of_payment` AS `TaxDate`,
                             `pd`.`date_of_payment` AS `DocDueDate`,
                             `s`.`SAP_CardCode` AS `CardCode`,
                             concat(`leads`.`primary_address_street`, '', `leads`.`primary_address_city`, '', `leads`.`primary_address_state`, '', `leads`.`primary_address_postalcode`) AS `Address`,
                             `pd`.`invoice_order_number` AS `NumAtCard`,
                             `sb`.`batch_code` AS `U_Batch`,
                             `pd`.`SAP_Status` AS `SAP_Status`
                      FROM `te_student` `s`
                      JOIN `te_student_te_student_batch_1_c` `stsb` ON `s`.`id` = `stsb`.`te_student_te_student_batch_1te_student_ida`
                      JOIN `te_student_batch` `sb` ON `stsb`.`te_student_te_student_batch_1te_student_batch_idb` = `sb`.`id`
                      JOIN `te_student_payment` `sp` ON `stsb`.`te_student_te_student_batch_1te_student_batch_idb` = `sp`.`te_student_batch_id_c`
                      JOIN `te_payment_details` `pd` ON `sp`.`id` = `pd`.`student_payment_id`
                      JOIN `leads` ON `sb`.`leads_id` = `leads`.`id`
                      JOIN `te_vendor` ON lower(`leads`.`vendor`) = lower(`te_vendor`.`name`)
                      WHERE `sb`.`deleted` = 0
                        AND `pd`.`deleted` = 0
                        AND `pd`.`date_of_payment` >= '$SyncSapTimestamp' AND `pd`.`date_of_payment` <= '$currentTime' 
                      GROUP BY `sb`.`leads_id`
                      ORDER BY `pd`.`date_of_payment`";
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

    function Stud_INV1()
    {

        global $conn;
        $leadsCstmData    = array();
        $SyncSapTimestamp = $this->SyncSapTimestamp();
        $currentTime      = date('Y-m-d H:i:s');
        
        

        $query   = "SELECT replace(`pd`.`id`, '-', '') AS `U_OrigEntry`,
                                    '1' AS `U_OrigLine`,
                                    `p`.`SAP_ItemCode` AS `ItemCode`,
                                    1 AS `Quantity`,
                                    cast(`te_ba_batch`.`fees_inr` AS decimal(18, 2)) AS `PriceBefDi`,
                                    (CASE
                                         WHEN (`pd`.`state` = 'HR') THEN 'SGST'
                                         ELSE 'IGST'
                                     END) AS `TaxCode`,
                                    'EE' AS `OcrCode`,
                                    `inst`.`short_name` AS `OcrCode2`,
                                    `p`.`short_name` AS `OcrCode3`,
                                    `te_ba_batch`.`BusinessSegment` AS `OcrCode4`,
                                    (CASE
                                         WHEN (`l`.`lead_source_types` IN ('NULL',
                                                                           'CC')) THEN 'Digital'
                                         ELSE 'Channel'
                                     END) AS `OcrCode5`,
                                    `sb`.`batch_code` AS `Project`,
                                    `pd`.`SAP_Status` AS `SAP_Status`
                             FROM `te_student_payment` `sp`
                                          JOIN `te_student_batch_te_student_payment_plan_1_c` `sp_rel` on `sp`.`te_student_batch_id_c` = `sp_rel`.`te_student_batch_te_student_payment_plan_1te_student_batch_ida`
                                         JOIN `te_student_payment_plan` `spp` on `sp_rel`.`te_student9d1ant_plan_idb` = `spp`.`id`
                                        JOIN `te_student_batch` `sb` on `sp`.`te_student_batch_id_c` = `sb`.`id`
                                       JOIN `te_ba_batch` on `sb`.`te_ba_batch_id_c` = `te_ba_batch`.`id`
                                      JOIN `te_pr_programs` `p` on `sb`.`te_pr_programs_id_c` = `p`.`id`
                                     JOIN `te_payment_details` `pd` on `sp`.`id` = `pd`.`student_payment_id`
                                    JOIN `leads` `l` on `sb`.`leads_id` = `l`.`id`
                                   LEFT JOIN `te_in_institutes` `inst` on `sb`.`te_in_institutes_id_c` = `inst`.`id`
                             WHERE `inst`.`short_name` <> ''
                                    AND `p`.`short_name` <> ''
                                    AND `te_ba_batch`.`BusinessSegment` <> ''
                                    AND `l`.`lead_source_types` <> ''
                                    AND sp.date_entered >= '$SyncSapTimestamp' AND sp.date_entered <= '$currentTime'
                             GROUP BY `sp`.`id`";
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

    function Stud_INV12()
    {

        global $conn;
        $leadsCstmData    = array();
        $SyncSapTimestamp = $this->SyncSapTimestamp();
        $currentTime      = date('Y-m-d H:i:s');

         $query   = "SELECT replace(`pd`.`id`, '-', '') AS `U_OrigEntry`,
                            (CASE
                                 WHEN (`leads`.`primary_address_state` = 'BR') THEN 'BH'
                                 ELSE `leads`.`primary_address_state`
                             END) AS `BpStateCod`,
                            `pd`.`SAP_Status` AS `SAP_Status`
                     FROM  `te_student` `s`
                               JOIN `te_student_te_student_batch_1_c` `stsb` on `s`.`id` = `stsb`.`te_student_te_student_batch_1te_student_ida`
                              JOIN `te_student_batch` `sb` on `stsb`.`te_student_te_student_batch_1te_student_batch_idb` = `sb`.`id`
                             JOIN `te_student_payment` `sp` on `stsb`.`te_student_te_student_batch_1te_student_batch_idb` = `sp`.`te_student_batch_id_c`
                            JOIN `te_payment_details` `pd` on `sp`.`id` = `pd`.`student_payment_id`
                           JOIN `leads` on `sb`.`leads_id` = `leads`.`id`
                     WHERE `s`.`deleted` = 0
                            AND `leads`.`primary_address_state` <> ''
                            AND `leads`.`primary_address_state` <> 0 
                            AND `pd`.`date_of_payment` >= '$SyncSapTimestamp' AND `pd`.`date_of_payment` <= '$currentTime' 
                            ";
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
                        concat(`leads`.`primary_address_street`, '', `leads`.`primary_address_city`, '', `leads`.`primary_address_state`, '', `leads`.`primary_address_postalcode`) AS `Address`,
                        `pd`.`Pay_Status` AS `Pay_Status`,
                        `pd`.`transaction_id` AS `U_PaymnetID`,
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
                       JOIN `leads` on((`sb`.`leads_id` = `leads`.`id`)))
                 WHERE   `sb`.`deleted` = ''
                        AND `pd`.`deleted` = ''
                        AND `pd`.`date_of_payment` >= '$SyncSapTimestamp' AND `pd`.`date_of_payment` <= '$currentTime' 
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

    function WEB_RCT1()
    {

        global $conn;
        $leadsCstmData    = array();
        $SyncSapTimestamp = $this->SyncSapTimestamp();
        $currentTime      = date('Y-m-d H:i:s');
        

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
                       JOIN `leads` on((`sb`.`leads_id` = `leads`.`id`)))
                 WHERE `pd`.`Pay_Status` = 0
                        AND `pd`.`SAP_DocEntry` <> ''
                        AND `pd`.`date_of_payment` >= '$SyncSapTimestamp' AND `pd`.`date_of_payment` <= '$currentTime'";
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
        $leadsCstmData    = array();
        $SyncSapTimestamp = $this->SyncSapTimestamp();
        $currentTime      = date('Y-m-d H:i:s');

        $query   = "SELECT replace(`pd`.`id`, '-', '') AS `U_OrigEntry`,
                            `pd`.`SAP_DocEntry` AS `DocEntry`,
                             0 AS `InvoiceId`,
                            `pd`.`amount` AS `SumApplied`,
                            `pd`.`Pay_Status` AS `Pay_Status`
                     FROM `te_student` `s`
                               JOIN `te_student_te_student_batch_1_c` `stsb` on `s`.`id` = `stsb`.`te_student_te_student_batch_1te_student_ida`
                              JOIN `te_student_batch` `sb` on `stsb`.`te_student_te_student_batch_1te_student_batch_idb` = `sb`.`id`
                             JOIN `te_student_payment` `sp` on `stsb`.`te_student_te_student_batch_1te_student_batch_idb` = `sp`.`te_student_batch_id_c`
                            JOIN `te_payment_details` `pd` on `sp`.`id` = `pd`.`student_payment_id`
                           JOIN `leads` on `sb`.`leads_id` = `leads`.`id`
                     WHERE `pd`.`Pay_Status` = 0
                            AND `pd`.`SAP_DocEntry` <> ''
                            AND `pd`.`date_of_payment` >= '$SyncSapTimestamp' AND `pd`.`date_of_payment` <= '$currentTime'";
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

    function WEB_OPRJ()
    {

        global $conn;
        $leadsCstmData    = array();
        $SyncSapTimestamp = $this->SyncSapTimestamp();
        $currentTime      = date('Y-m-d H:i:s');
        
        
        $query   = "SELECT replace(`bb`.`id`, '-', '') AS `U_OrigCode`,
                            replace(`bb`.`batch_code`, '-', '_') AS `PrjCode`,
                            replace(`bb`.`batch_code`, '-', '_') AS `PrjName`,
                            'N' AS `Locked`,
                            'Y' AS `Active`,
                            `bb`.`SAP_Status` AS `SAP_Status`
                     FROM `te_ba_batch` `bb`
                     WHERE `bb`.`deleted` = 0 AND `bb`.`date_of_payment` >= '$SyncSapTimestamp' "
                . "AND `bb`.`date_of_payment` <= '$currentTime'";
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





        $CustomersArr     = array();
        $StudCustomersArr = array();
        $ItemsArr         = array();
        $SupplierArr      = array();
        $Stud_OINVArr     = array();
        $Stud_INV1Arr     = array();
        $Stud_INV12Arr    = array();
        $WEB_ORCTArr      = array();
        $WEB_RCT1Arr      = array();
        $WEB_RCT2Arr      = array();
        $WEB_OPRJArr      = array();


        $SyncSapTimestamp = $this->SyncSapTimestamp();


        #1. /////////// Customers Table Syncing //////////////////

        $CustomersArr = $this->Customers();
        echo '<hr>Customers Table Syncing ';

        $custSQL = "INSERT INTO `Customers` (`U_BPID`, `CardName`, `CardFName`) VALUES ";
        
        $i=1;
        foreach ($CustomersArr as $key => $data)
        {
            $custSQL .= "('" . $data['U_BPID'] . "','" . $data['CardName'] . "','" . $data['CardFName'] . "'),";
        $i++;
        }
        $exeSql = rtrim($custSQL, ',');
        if ($i > 1)
        {
            mysqli_query($sap_conn, $exeSql) or die(mysqli_error($sap_conn));
        }
        unset($CustomersArr);



        #2. /////////// StudCustomers Table Syncing //////////////////

        $StudCustomersArr = $this->StudCustomers();
        echo '<hr>StudCustomers Table Syncing ';

        $custSQL2 = "INSERT INTO `StudCustomers` (`U_BPId`, `CardName`, `CardFName`,`E_Mail`,`Phone1`,`Cellular`,`State1`,`State2`,`Country`,`MailCountr`) VALUES ";
        $i        = 1;
        foreach ($StudCustomersArr as $key => $data)
        {
            $firstname = mysqli_real_escape_string($sap_conn, $data['CardName']);
            $lastname  = mysqli_real_escape_string($sap_conn, $data['CardFName']);

            $custSQL2 .= "('" . $data['U_BPId'] . "',
                '" . $firstname . "',
	        '" . $lastname . "',
		'" . $data['E_Mail'] . "',
		'" . $data['Phone1'] . "',
		'" . $data['Cellular'] . "',
		'" . $data['State1'] . "',
		'" . $data['State2'] . "',
		'" . $data['Country'] . "',
		'" . $data['MailCountr'] . "'),";
            $i++;
        }
        $exeSql2 = rtrim($custSQL2, ',');
        if ($i > 1)
        {
            mysqli_query($sap_conn, $exeSql2) or die(mysqli_error($sap_conn));
        }
        unset($StudCustomersArr);


        
        
        #3. /////////// Items Table Syncing //////////////////
        
        $ItemsArr = $this->Items();
        echo '<hr>Items Table Syncing ';

        $custSQL2 = "INSERT INTO `Items` (`U_CourseID`, `ItemName`, `FrgnName`,`U_Institute`) VALUES ";
        $i        = 1;
        foreach ($ItemsArr as $key => $data)
        {


            $ItemName    = mysqli_real_escape_string($sap_conn, $data['ItemName']);
            $FrgnName    = mysqli_real_escape_string($sap_conn, $data['FrgnName']);
            $U_Institute = mysqli_real_escape_string($sap_conn, $data['U_Institute']);

            $custSQL2 .= "('" . $data['U_CourseID'] . "',
                '" . $ItemName . "',
	        '" . $FrgnName . "',
		'" . $U_Institute . "'),";
            $i++;
        }
        $exeSql2 = rtrim($custSQL2, ',');
        if ($i > 1)
        {
            mysqli_query($sap_conn, $exeSql2) or die(mysqli_error($sap_conn));
        }
        unset($StudCustomersArr);


        
        #4. /////////// Supplier Table Syncing //////////////////
        
        $SupplierArr = $this->Supplier();
        echo '<hr>Supplier Table Syncing ';

        $custSQL = "INSERT INTO `Supplier` (`U_BPID`, `CardName`, `CardFName`,`Phone1`,`E_Mail`) VALUES ";
        $i       = 1;
        foreach ($SupplierArr as $key => $data)
        {
            $CardName  = mysqli_real_escape_string($sap_conn, $data['CardName']);
            $CardFName = mysqli_real_escape_string($sap_conn, $data['CardFName']);
            $Phone1    = mysqli_real_escape_string($sap_conn, $data['Phone1']);
            $E_Mail    = mysqli_real_escape_string($sap_conn, $data['E_Mail']);

            $custSQL .= "('" . $data['U_BPID'] . "',
                '" . $CardName . "',
	        '" . $CardFName . "',
                '" . $Phone1 . "',
		'" . $E_Mail . "'),";
            $i++;
        }
        $exeSql = rtrim($custSQL, ',');
        if ($i > 1)
        {
            mysqli_query($sap_conn, $exeSql) or die(mysqli_error($sap_conn));
        }
        unset($SupplierArr);



        #5. /////////// Stud_OINV Table Syncing //////////////////
        
        $Stud_OINVArr = $this->Stud_OINV();
        echo '<hr>Stud_OINV Table Syncing ';

        $custSQL = "INSERT INTO `Stud_OINV` (`U_OrigEntry`, `U_OrigNum`,`U_ARInvNo`,`SlpCode`,`DocDate`,`TaxDate`,`DocDueDate`,`CardCode`,`Address`,`NumAtCard`,`U_Batch`) VALUES ";

        $i = 1;
        foreach ($Stud_OINVArr as $key => $data)
        {

            $Address = mysqli_real_escape_string($sap_conn, $data['Address']);


            $custSQL .= "('" . $data['U_OrigEntry'] . "',
                '" . $data['U_OrigNum'] . "',
	        '" . $data['U_ARInvNo'] . "',
		'" . $data['SlpCode'] . "',
		'" . $data['DocDate'] . "',
		'" . $data['TaxDate'] . "',
		'" . $data['DocDueDate'] . "',
		'" . $data['CardCode'] . "',
		'" . $Address . "',
		'" . $data['NumAtCard'] . "','" . $data['U_Batch'] . "'),";

            $i++;
        }
        $exeSql = rtrim($custSQL, ',');
        if ($i > 1)
        {
            mysqli_query($sap_conn, $exeSql) or die(mysqli_error($sap_conn));
        }
        unset($Stud_OINVArr);




        #6. /////////// Stud_INV1 Table Syncing //////////////////
        
        $Stud_INV1Arr = $this->Stud_INV1();
        echo '<hr>Stud_INV1 Table Syncing ';

        $custSQL = "INSERT INTO `Stud_INV1` (`U_OrigEntry`, `U_OrigLine`,`ItemCode`,`Quantity`,`PriceBefDi`,`TaxCode`,`OcrCode`,`OcrCode2`,`OcrCode3`,`OcrCode4`,`OcrCode5`,`Project`) VALUES ";

        $i = 1;
        foreach ($Stud_INV1Arr as $key => $data)
        {

            $Project = mysqli_real_escape_string($sap_conn, $data['Project']);


            $custSQL .= "('" . $data['U_OrigEntry'] . "',
                '" . $data['U_OrigLine'] . "',
	        '" . $data['ItemCode'] . "',
		'" . $data['Quantity'] . "',
		'" . $data['PriceBefDi'] . "',
		'" . $data['TaxCode'] . "',
		'" . $data['OcrCode'] . "',
		'" . $data['OcrCode2'] . "',
                '" . $data['OcrCode3'] . "',
                '" . $data['OcrCode4'] . "',
                '" . $data['OcrCode5'] . "',
		'" . $Project . "'),";

            $i++;
        }

        $exeSql = rtrim($custSQL, ',');
        if ($i > 1)
        {
            mysqli_query($sap_conn, $exeSql) or die(mysqli_error($sap_conn));
        }
        unset($Stud_INV1Arr);


        
        #7. /////////// Stud_INV12 Table Syncing //////////////////
        
        $Stud_INV12Arr = $this->Stud_INV12();
        echo '<hr>Stud_INV12 Table Syncing ';

        $custSQL = "INSERT INTO `Stud_INV12` (`U_OrigEntry`, `BpStateCod`) VALUES ";

        $i = 1;
        foreach ($Stud_INV12Arr as $key => $data)
        {
            $custSQL .= "('" . $data['U_OrigEntry'] . "','" . $data['BpStateCod'] . "'),";
            $i++;
        }

        $exeSql = rtrim($custSQL, ',');
        if ($i > 1)
        {
            mysqli_query($sap_conn, $exeSql) or die(mysqli_error($sap_conn));
        }
        unset($Stud_INV12Arr);

        
        
        
        #8. /////////// WEB_ORCT Table Syncing //////////////////
        
        $WEB_ORCTArr = $this->WEB_ORCT();
        echo '<hr>WEB_ORCT Table Syncing ';

        $custSQL = "INSERT INTO `WEB_ORCT` (`U_OrigEntry`, `DocDate`,`DocDueDate`,`TaxDate`,`CardCode`,`Address`,`Pay_Status`,`U_PaymnetID`,`U_PaymentGateway`,`CheckAcct`,`CashAcct`,`TrsfrSum`,`TrsfrAcct`,`CheckSum`,`CashSum`) VALUES ";
        $i       = 1;
        foreach ($WEB_ORCTArr as $key => $data)
        {

            $Address = mysqli_real_escape_string($sap_conn, $data['Address']);

            $custSQL .= "('" . $data['U_OrigEntry'] . "',
                '" . $data['DocDate'] . "',
	        '" . $data['DocDueDate'] . "',
		'" . $data['TaxDate'] . "',
		'" . $data['CardCode'] . "',
		'" . $Address . "',
		'" . $data['Pay_Status'] . "',
                '" . $data['U_PaymnetID'] . "',
                '" . $data['U_PaymentGateway'] . "',
                '" . $data['CheckAcct'] . "',
                '" . $data['CashAcct'] . "',
                '" . $data['TrsfrSum'] . "',
                '" . $data['TrsfrAcct'] . "',
                '" . $data['CheckSum'] . "',
                '" . $data['CashSum'] . "'),";


            $i++;
        }
        $exeSql = rtrim($custSQL, ',');
        if ($i > 1)
        {
            mysqli_query($sap_conn, $exeSql) or die(mysqli_error($sap_conn));
        }
        unset($WEB_ORCTArr);





        #9. /////////// WEB_RCT1 Table Syncing //////////////////
        $WEB_RCT1Arr = $this->WEB_RCT1();

        echo '<hr>WEB_RCT1 Table Syncing ';

        $custSQL = "INSERT INTO `WEB_RCT1` (`U_OrigEntry`, `DueDate`,`CheckSum`) VALUES ";
        $i       = 1;
        foreach ($WEB_RCT1Arr as $key => $data)
        {
            $custSQL .= "('" . $data['U_OrigEntry'] . "','" . $data['DueDate'] . "','" . $data['CheckSum'] . "'),";

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

        $custSQL = "INSERT INTO `WEB_RCT2` (`U_OrigEntry`, `DocEntry`,`SumApplied`) VALUES ";
        $i       = 1;
        foreach ($WEB_RCT2Arr as $key => $data)
        {
            $custSQL .= "('" . $data['U_OrigEntry'] . "','" . $data['DocEntry'] . "','" . $data['SumApplied'] . "'),";
            $i++;
        }
        $exeSql = rtrim($custSQL, ',');
        if ($i > 1)
        {
            mysqli_query($sap_conn, $exeSql) or die(mysqli_error($sap_conn));
        }
        unset($WEB_RCT2Arr);
        
        
        

        #11. /////////// WEB_OPRJ Table Syncing //////////////////
        
        
        $WEB_OPRJArr = $this->WEB_OPRJ();
        echo '<hr>WEB_OPRJ Table Syncing ';

        $custSQL = "INSERT INTO `WEB_OPRJ` (`U_OrigCode`, `PrjCode`,`PrjName`,`Locked`,`Active`) VALUES ";
        $i       = 1;
        foreach ($WEB_OPRJArr as $key => $data)
        {
            $PrjCode = mysqli_real_escape_string($sap_conn, $data['PrjCode']);
            $PrjName = mysqli_real_escape_string($sap_conn, $data['PrjName']);

            $custSQL .= "('" . $data['U_OrigCode'] . "',
                        '" . $PrjCode . "',
                        '" . $PrjName . "',
                        '" . $data['Locked'] . "',
                        '" . $data['Active'] . "'),";


            $i++;
        }
        $exeSql = rtrim($custSQL, ',');
        if ($i > 1)
        {
            mysqli_query($sap_conn, $exeSql) or die(mysqli_error($sap_conn));
        }
        unset($WEB_OPRJArr);
    }

// END of Main
}

$mainObj = new syncsaptables();
$mainObj->main();

$sql = "INSERT INTO SYNC_SAP_TIMESTAMP  SET reg_date='" . date("Y-m-d h:i:s") . "'";
mysqli_query($sap_conn, $sql);

mysqli_close($conn);
?>		 
