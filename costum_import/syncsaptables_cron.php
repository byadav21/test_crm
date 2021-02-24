<?php
error_reporting(E_ALL);
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
include('../custom/include/Email/sendmail.php');
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
        global $conn,$sap_conn;
        $query   = "SELECT reg_date FROM   `SYNC_SAP_TIMESTAMP` order by reg_date desc limit 1";
        $leadObj = mysqli_query($sap_conn, $query);
        $row     = mysqli_fetch_assoc($leadObj);
        //$row['reg_date'] = date("Y-m-d H:i:s",strtotime($row['reg_date']." -330 minutes"));

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
                     AND    `te_in_institutes`.`date_entered` > '" . $SyncSapTimestamp . "'
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
                   AND `te_student`.`date_entered` > '$SyncSapTimestamp' AND `te_student`.`date_entered` <= '$currentTime'";

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
                     AND `pr`.`date_entered` > '$SyncSapTimestamp' AND `pr`.`date_entered` <= '$currentTime'";
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
                       AND `te_vendor`.`date_entered` > '$SyncSapTimestamp' AND `te_vendor`.`date_entered` <= '$currentTime'";
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
                             `pd`.`id` AS `Check_Id`,
                             `pd`.`invoice_number` AS `U_OrigNum`,
                             `pd`.`invoice_number` AS `U_ARInvNo`,
                             `te_vendor`.`SlpCode` AS `SlpCode`,
                             `pd`.`date_of_payment` AS `DocDate`,
                             `pd`.`date_of_payment` AS `TaxDate`,
                             `pd`.`date_of_payment` AS `DocDueDate`,
                              replace(`s`.`id`, '-', '') AS `U_BPId`,
                             `s`.`SAP_CardCode` AS `CardCode`,
                             concat_ws(' ',`leads`.`primary_address_street`, `leads`.`primary_address_city`,`leads`.`primary_address_state`,`leads`.`primary_address_postalcode`) AS `Address`,
                             `pd`.`state` AS `State`,
                             `pd`.`invoice_order_number` AS `NumAtCard`,
                             `sb`.`batch_code` AS `U_Batch`,
                             `pd`.`SAP_Status` AS `SAP_Status`,
                             `pd`.`currency_type` AS `currency_type`
                      FROM `te_student` `s`
                      JOIN `te_student_te_student_batch_1_c` `stsb` ON `s`.`id` = `stsb`.`te_student_te_student_batch_1te_student_ida`
                      JOIN `te_student_batch` `sb` ON `stsb`.`te_student_te_student_batch_1te_student_batch_idb` = `sb`.`id`
                      JOIN `te_student_payment` `sp` ON `stsb`.`te_student_te_student_batch_1te_student_batch_idb` = `sp`.`te_student_batch_id_c`
                      JOIN `te_payment_details` `pd` ON `sp`.`id` = `pd`.`student_payment_id`
                      JOIN leads_te_payment_details_1_c AS lp ON lp.leads_te_payment_details_1te_payment_details_idb=pd.id
                      JOIN `leads` ON `sb`.`leads_id` = `leads`.`id`
                      LEFT JOIN `te_vendor` ON lower(`leads`.`vendor`) = lower(`te_vendor`.`name`)
                      WHERE `sb`.`deleted` = 0
                        AND `pd`.`deleted` = 0
                        AND lp.deleted=0 
                        AND `pd`.`date_entered` > '$SyncSapTimestamp' AND `pd`.`date_entered` <= '$currentTime'
                      GROUP BY `sb`.`leads_id`
                      ORDER BY `pd`.`date_entered`";
        $leadObj = mysqli_query($conn, $query);
        //AND `pd`.`date_entered` > '$SyncSapTimestamp' AND `pd`.`date_entered` <= '$currentTime' 
        // AND `pd`.`date_entered` > '2019-07-25' AND `pd`.`date_entered` <= '2019-07-26' 
        if ($leadObj)
        {

            while ($row = mysqli_fetch_assoc($leadObj))
            {
                $leadsCstmData[] = $row;
            }
        }
        // echo "<pre>"; print_r($leadsCstmData);
        return $leadsCstmData;
    }

    function Stud_INV1()
    {

        global $conn;
        $leadsCstmData    = array();
        $SyncSapTimestamp = $this->SyncSapTimestamp();
        $currentTime      = date('Y-m-d H:i:s');
        
        $query   = "SELECT replace(`pd`.`id`, '-', '') AS `U_OrigEntry`,
                                    `pd`.`id` AS `Check_Id`,
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
                                        WHEN (`l`.`lead_source_types` = 'null') THEN 'Digital'
                                        WHEN (`l`.`lead_source_types` IS NULL) THEN 'Digital'
                                        WHEN (`l`.`lead_source_types` ='') THEN 'Digital'
                                        WHEN (`l`.`lead_source_types` ='CC') THEN 'Digital'
                                        ELSE 'Channel'
                                   END) AS `OcrCode5`,
                                    `sb`.`batch_code` AS `Project`,
                                    replace(`p`.`id`, '-', '') AS `U_CourseID`,
                                    `pd`.`SAP_Status` AS `SAP_Status`
                             FROM `te_student_payment` `sp`
                                          JOIN `te_student_batch_te_student_payment_plan_1_c` `sp_rel` on `sp`.`te_student_batch_id_c` = `sp_rel`.`te_student_batch_te_student_payment_plan_1te_student_batch_ida`
                                         JOIN `te_student_payment_plan` `spp` on `sp_rel`.`te_student9d1ant_plan_idb` = `spp`.`id`
                                        JOIN `te_student_batch` `sb` on `sp`.`te_student_batch_id_c` = `sb`.`id`
                                       JOIN `te_ba_batch` on `sb`.`te_ba_batch_id_c` = `te_ba_batch`.`id`
                                      JOIN `te_pr_programs` `p` on `sb`.`te_pr_programs_id_c` = `p`.`id`
                                     JOIN `te_payment_details` `pd` on `sp`.`id` = `pd`.`student_payment_id`
                                     JOIN leads_te_payment_details_1_c AS lp ON lp.leads_te_payment_details_1te_payment_details_idb=pd.id
                                    JOIN `leads` `l` on `sb`.`leads_id` = `l`.`id`
                                   LEFT JOIN `te_in_institutes` `inst` on `sb`.`te_in_institutes_id_c` = `inst`.`id`
                             WHERE `inst`.`short_name` <> ''
                                    AND `p`.`short_name` <> ''
                                    AND `te_ba_batch`.`BusinessSegment` <> ''
                                    #AND `l`.`lead_source_types` <> '' 
                                    AND  pd.deleted=0
                                    AND lp.deleted=0 
                                    AND pd.date_entered > '$SyncSapTimestamp' AND `pd`.`date_entered` <= '$currentTime'
                             GROUP BY `sp`.`id`";
                            //  AND pd.date_entered > '$SyncSapTimestamp' AND pd.date_entered <= '$currentTime'
                            // AND `pd`.`date_entered` > '2019-07-25' AND `pd`.`date_entered` <= '2019-08-30' 
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
                            JOIN leads_te_payment_details_1_c AS lp ON lp.leads_te_payment_details_1te_payment_details_idb=pd.id
                           JOIN `leads` on `sb`.`leads_id` = `leads`.`id`
                     WHERE `s`.`deleted` = 0
                            AND `leads`.`primary_address_state` <> ''
                            AND  pd.deleted=0
                            AND lp.deleted=0 
                            AND `leads`.`primary_address_state` <> 0 
                            AND `pd`.`date_entered` > '$SyncSapTimestamp' AND `pd`.`date_entered` <= '$currentTime' 
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
                        concat_ws(' ',`leads`.`primary_address_street`, `leads`.`primary_address_city`,`leads`.`primary_address_state`,`leads`.`primary_address_postalcode`) AS `Address`,
                        `pd`.`Pay_Status` AS `Pay_Status`,
                        `pd`.`transaction_id` AS `U_PaymnetID`,
                        `pd`.`payment_response`,
                        `pd`.`amount`,
                        `pd`.`transaction_id` AS `U_TransactionID`,
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
                        AND `pd`.`date_entered` > '$SyncSapTimestamp' AND `pd`.`date_entered` <= '$currentTime' 
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
                       JOIN leads_te_payment_details_1_c AS lp ON lp.leads_te_payment_details_1te_payment_details_idb=pd.id
                       JOIN `leads` on((`sb`.`leads_id` = `leads`.`id`)))
                 WHERE pd.deleted=0   AND lp.deleted=0  AND `pd`.`date_entered` > '$SyncSapTimestamp' AND `pd`.`date_entered` <= '$currentTime'";
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
                            `pd`.`Pay_Status` AS `Pay_Status`,
                            `s`.`SAP_CardCode` AS `CardCode`,
                            `pd`.`invoice_number` AS `U_OrigNum`
                     FROM `te_student` `s`
                               JOIN `te_student_te_student_batch_1_c` `stsb` on `s`.`id` = `stsb`.`te_student_te_student_batch_1te_student_ida`
                              JOIN `te_student_batch` `sb` on `stsb`.`te_student_te_student_batch_1te_student_batch_idb` = `sb`.`id`
                             JOIN `te_student_payment` `sp` on `stsb`.`te_student_te_student_batch_1te_student_batch_idb` = `sp`.`te_student_batch_id_c`
                            JOIN `te_payment_details` `pd` on `sp`.`id` = `pd`.`student_payment_id`
                            JOIN leads_te_payment_details_1_c AS lp ON lp.leads_te_payment_details_1te_payment_details_idb=pd.id
                           JOIN `leads` on `sb`.`leads_id` = `leads`.`id`
                     WHERE pd.deleted=0  AND lp.deleted=0  AND `pd`.`date_entered` > '$SyncSapTimestamp' AND `pd`.`date_entered` <= '$currentTime'";
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
                     WHERE `bb`.`deleted` = 0 AND `bb`.`date_entered` > '$SyncSapTimestamp' "
                . "AND `bb`.`date_entered` <= '$currentTime'";
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

    // Update API SET State, Tax, Invoice payment_response 
    function update_state_tax_invoice_payment()
    {
        global $db, $sugar_config;
        $currentDate 	= date("Y-m-d");
        
        $startDate = date_create($currentDate);
        $endDate = date_create($currentDate);
        
        date_sub($endDate,date_interval_create_from_date_string("2 days"));
        
        $endDate   = date_format($endDate, "Y-m-d");
        $startDate   = date_format($startDate, "Y-m-d");
        
        $user = 'talentedgeadmin';
        $password = 'Inkoniq@2016';
        $url = $sugar_config['website_URL']."/crmordersync.php?startdate='".$startDate."'&enddate='".$endDate."'";
        $headers = array(
                'Authorization: Basic '. base64_encode("$user:$password")
        );
        $post = [
                'startdate' => $startDate,
                'enddate' 	=> $endDate
        ];
            
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);

        //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $result = curl_exec($ch);
        $result = stripslashes(html_entity_decode($result));
        $res = json_decode(trim($result),TRUE);
        if (is_array($res) || is_object($res))
        {
            foreach ($res as $value){
                if( !empty($value['taxtype']) && !empty($value['state']) && !empty($value['payment_id']) ){
                    $query = "UPDATE te_payment_details SET `currency_type` ='".$value['currency']."', `tax_type` ='".$value['taxtype']."', `state` ='".$value['state']."', `invoice_number` ='".$value['invoice_number']."', `payment_response_new` ='".$value['payment_response']."', `transaction_id` = '".$value['payment_referencenum']."' where `invoice_order_number`='".$value['payment_id']."' ";
                    $qry1= $db->query($query);
                }
            }
        }	
    }
    

 function main()
    {

        global $sap_conn, $conn;

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
        $update_state_tax_invoice_paymentArr = array();

        $SyncSapTimestamp = $this->SyncSapTimestamp();
        
        #0. /////////// $updat_state_payment_responseArr //////////
        echo '<hr>Update State Tax Invoide te_payment_details Table Syncing ';
        $update_state_tax_invoice_paymentArr = $this->update_state_tax_invoice_payment();
        unset($update_state_tax_invoice_paymentArr);
        
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

        //echo "<br /><hr>============== Testing Imhere Start ====================";
        // echo "<pre>"; print_r($Stud_OINVArr); echo "</pre>";
        
        echo '<hr>Stud_OINV Table Syncing ';
        $checkID = array();
        // echo "<pre>"; print_r($Stud_OINVArr);
        $custSQL = "INSERT INTO `Stud_OINV` (`U_OrigEntry`, `U_OrigNum`,`U_ARInvNo`,`SlpCode`,`DocDate`,`TaxDate`,`DocDueDate`,`U_BPId`,`CardCode`,`Address`,`State`,`NumAtCard`,`U_Batch`,`currency_type`) VALUES ";
        $numAtCard_Check_Id = array();
        $i = 1;
        foreach ($Stud_OINVArr as $key => $data)
        {

            $Address = mysqli_real_escape_string($sap_conn, $data['Address']);
            $Address = ($Address=='0')? '': $Address;

            $check_state = $data['State'];

					switch ($check_state) {
						case "BR":
							$state = "BH";
							break;
						case "CT":
							$state = "CG";
							break;
						case "DN":
							$state = "DH";
							break;
						case "KA":
							$state = "KT";
							break;
						case "ML":
							$state = "ME";
							break;
						case "TG":
							$state = "TS";
							break;
						case "UK":
							$state = "UT";
							break;
						
						default:
							$state = $check_state;
					}
            
            if(empty($data['NumAtCard']) || $data['NumAtCard'] == NULL || $data['NumAtCard'] == 'NULL'){
                
                //Send Mail IF NumAtCard data is Blank
                $numAtCard_Check_Id[]     = $data['Check_Id'];
               // echo "numAtCard_Check_Id:- " .$data['Check_Id']." </br>";
            }else {
                $custSQL .= "('" . $data['U_OrigEntry'] . "',
                        '" . $data['U_OrigNum'] . "',
                        '" . $data['U_ARInvNo'] . "',
                        '" . $data['SlpCode'] . "',
                        '" . $data['DocDate'] . "',
                        '" . $data['TaxDate'] . "',
                        '" . $data['DocDueDate'] . "',
                        '" . $data['U_BPId'] . "',
                        '" . $data['CardCode'] . "',
                        '" . $Address. "',
                        '" . $state . "',
                        '" . $data['NumAtCard'] . "',
                        '" . $data['U_Batch'] . "',
                        '" . $data['currency_type'] . "'),";
            }

            $i++;
        }
        
        $exeSql = rtrim($custSQL, ','); 
        // echo "<pre>"; print_r(str_replace("-",'', $checkID));
        if ($i > 1)
        {
            mysqli_query($sap_conn, $exeSql) or die(mysqli_error($sap_conn));
            
        }

        //echo "============== Testing Imhere END ==================== ".$exeSql." /////////////////////// </br />";
        // echo "imhere"; 
        // die('brijesh');
        if(!empty($numAtCard_Check_Id)){
            $body   = '<table>';
            foreach ($numAtCard_Check_Id AS $value){
                $body .='
                <tr height="20">
                    <td align="left" valign="top">te_payment_details ID:- ' . $value . '</td></br/>
                </tr>';
            }
            
            $body .='</table>';
                
            $subject    = "Sap Not Insert for this tables te_payment_details Leads";
            $mail       = new NetCoreEmail();
            $email      = 'brijesh.kumar@talentedge.com';
            $mail->sendEmail($email, $subject, $body);

        }
            unset($Stud_OINVArr);




        #6. /////////// Stud_INV1 Table Syncing //////////////////
        
        $Stud_INV1Arr = $this->Stud_INV1();
        echo '<br /><hr> Stud_INV1 Table Syncing ';
        // echo "<pre>"; print_r(str_replace("-",'', $checkID));
        //echo "<pre>"; print_r($Stud_INV1Arr);
        $get_checkID = array();
        $custSQL = "INSERT INTO `Stud_INV1` (`U_OrigEntry`, `U_OrigLine`,`ItemCode`,`Quantity`,`PriceBefDi`,`TaxCode`,`OcrCode`,`OcrCode2`,`OcrCode3`,`OcrCode4`,`OcrCode5`,`Project`,`U_CourseID`) VALUES ";

        $i = 1;
        foreach ($Stud_INV1Arr as $key => $data)
        {
          // echo "<pre> "; print_r($data);

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
                '" . $Project . "',
                '" . $data['U_CourseID'] . "'),";

            $get_checkID[]    = $data['Check_Id'];
        
            $i++;
        }

        $exeSql = rtrim($custSQL, ',');
       // echo "<pre>"; print_r($get_checkID);
        $sap_status_not_updated_Stud_OINV = array();
        $sap_status_not_updated_Stud_INV1 = array();
        if ($i > 1)
        {
            mysqli_query($sap_conn, $exeSql) or die(mysqli_error($sap_conn));
            foreach($get_checkID AS $value)
            {
                // echo "<pre>"; print_r($value);
                //Remove UnderScore in checkID
                $valueRemoveID = str_replace("-",'', $value);

                // echo "<pre>"; print_r($valueRemoveID);
                // die('imhere');

                // Check & Update for Stud_INV1
                $query_Stud_OINV = "select U_OrigEntry from `Stud_OINV` where `U_OrigEntry` = '".$valueRemoveID."' ";
                $queryStud_OINV = mysqli_query($sap_conn, $query_Stud_OINV) or die(mysqli_error($sap_conn));
                $query_count_Stud_OINV = mysqli_num_rows($queryStud_OINV);
                //Count Number of rows data & remove all data accepted 1 rows
                $delete_count_Stud_OINV = $query_count_Stud_OINV - 1 ;
                // print_r(" delete_count_Stud_OINV:- ".$delete_count_Stud_OINV);
                      
                // if($query_count_Stud_OINV >= 1){
                //     $delete_query_Stud_OINV = "DELETE from `Stud_OINV` where `U_OrigEntry` = '".$valueRemoveID."' LIMIT $delete_count_Stud_OINV ";
                //     mysqli_query($sap_conn, $delete_query_Stud_OINV) or die(mysqli_error($sap_conn));
                // }
                
                if ($queryStud_OINV)
                {
                    while($row = mysqli_fetch_assoc($queryStud_OINV)){
                        if($row['U_OrigEntry'] == $valueRemoveID){
                            $SAP_Status_CRM = 1;
                        }else {
                            $SAP_Status_CRM = 2;
                            $sap_status_not_updated_Stud_OINV[] = $value." Stud_OINV SAP_Status_CRM:- ".$SAP_Status_CRM;
                        }
                    }
                }else {
                    $SAP_Status_CRM = 0;
                    $sap_status_not_updated_Stud_OINV[] = $value." Stud_OINV SAP_Status_CRM:- ".$SAP_Status_CRM;
                }
                //echo " sap_status_not_updated_Stud_OINV :- ".$SAP_Status_CRM. " =====<br/>";

                //Send Mail which data not updated
                // if($SAP_Status_CRM = 2 || $SAP_Status_CRM = 0){
                //     $body   = '<table>
                //                         <tr height="20">
                //                             <td align="left" valign="top">' . $value . '</td>
                //                         </tr>
                //                     </table>';
                        
                //     $subject    = "Sap Not Update for this tables:-Stud_OINV:-'". $SAP_Status_CRM . "'  Lead ID:- ".$value;
                //     $mail       = new NetCoreEmail();
                //     $email      = 'brijesh.kumar@talentedge.com';
                    
                //     $mail->sendEmail($email, $subject, $body);
                // }
                // echo " SAP_Status_CRM OINV :- ".$SAP_Status_CRM;
                $updateCRM = "UPDATE te_payment_details SET SAP_Status = '".$SAP_Status_CRM."' WHERE id =  '".$value."' ";
                $query = mysqli_query($conn, $updateCRM) or die(mysqli_error($conn));
                // print_r($row);

                // Check & Update for Stud_INV1
                $query_Stud_INV1 = "select U_OrigEntry from `Stud_INV1` where `U_OrigEntry` = '".$valueRemoveID."' ";
                $queryStud_INV1 = mysqli_query($sap_conn, $query_Stud_INV1) or die(mysqli_error($sap_conn));
                $query_count_Stud_INV1 = mysqli_num_rows($queryStud_INV1);
                //Count Number of rows data & remove all data accepted 1 rows
                $delete_count_Stud_INV1 = $query_count_Stud_INV1 - 1 ;
                // print_r(" delete_count_Stud_INV1:- ".$delete_count_Stud_INV1);

                // $querySAP = "select U_OrigEntry,NumAtCard from `Stud_OINV` where `U_OrigEntry` = 'cfa01028a4fef9e576bd5d395d034c69' ";

                // if($query_count_Stud_INV1 >= 1){
                //     $delete_query_Stud_INV1 = "DELETE from `Stud_INV1` where `U_OrigEntry` = '".$valueRemoveID."' LIMIT $delete_count_Stud_INV1 ";
                //     mysqli_query($sap_conn, $delete_query_Stud_INV1) or die(mysqli_error($sap_conn));
                // }
                
                if ($queryStud_INV1)
                {
                    while($row = mysqli_fetch_assoc($queryStud_INV1)){
                        if($row['U_OrigEntry'] == $valueRemoveID){
                            $SAP_Status_CRM = 1;
                        }else {
                            $SAP_Status_CRM = 3;
                            $sap_status_not_updated_Stud_INV1[] = $value." Stud_INV1 SAP_Status_CRM:- ".$SAP_Status_CRM;
                        }
                    }
                }else {
                    $SAP_Status_CRM = 0;
                    $sap_status_not_updated_Stud_INV1[] = $value." Stud_INV1 SAP_Status_CRM:- ".$SAP_Status_CRM;
                }
                //echo " sap_status_not_updated_Stud_INV1 :- ".$SAP_Status_CRM. " =====<br/>";
                $updateCRM = "UPDATE te_payment_details SET SAP_Status = '".$SAP_Status_CRM."' WHERE id =  '".$value."' ";
                $query = mysqli_query($conn, $updateCRM) or die(mysqli_error($conn));
                // print_r($row);

                
            }
        }

        //Send Mail which data not updated
        if(!empty($sap_status_not_updated_Stud_OINV)){

            $body   = '<table>';
            foreach ($sap_status_not_updated_Stud_OINV AS $value){
                $body .='
                <tr height="20">
                    <td align="left" valign="top">Stud_OINV ID:- ' . $value . '</td></br/>
                </tr>';
            }
            
            $body .='</table>';
                
            $subject    = "Sap Not Update for this tables:-Stud_OINV, Leads ID";
            $mail       = new NetCoreEmail();
            $email      = 'brijesh.kumar@talentedge.com';
            
            $mail->sendEmail($email, $subject, $body);
        }

        if(!empty($sap_status_not_updated_Stud_INV1)){

            $body   = '<table>';
            foreach ($sap_status_not_updated_Stud_INV1 AS $data_id){
                $body .='
                <tr height="20">
                    <td align="left" valign="top">Stud_INV1 ID:- ' . $data_id . '</td></br/>
                </tr>';
            }
            
            $body .='</table>';
                
            $subject    = "Sap Not Update for this tables:-Stud_INV1, Leads ID";
            $mail       = new NetCoreEmail();
            $email      = 'brijesh.kumar@talentedge.com';
            
            $mail->sendEmail($email, $subject, $body);
        }

        // echo "imhere"; die('brijesh');

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

        $custSQL = "INSERT INTO `WEB_ORCT` (`U_OrigEntry`, `DocDate`,`DocDueDate`,`TaxDate`,`CardCode`,`Address`,`Pay_Status`,`U_PaymnetID`,`U_PaymentGateway`,`CheckAcct`,`CashAcct`,`TrsfrSum`,`TrsfrAcct`,`CheckSum`,`CashSum`,`U_OrigNum`) VALUES ";
        $i       = 1;
        foreach ($WEB_ORCTArr as $key => $data)
        {
            if($data['payment_response']){
                $pres=$data['payment_response'];
                if($data['U_PaymentGateway']=='PayU'){
                    if($pres=='UPI'){
                        $data['CheckSum']   =20;                        
                    }else if($pres=='DC'){
                        $data['CheckSum']   =$data['amount']*(1.05/100);                        
                    }else if($pres=='CC' || $pres=='NB'){
                        $data['CheckSum']   =$data['amount']*(1.27/100);                        
                    }else if($pres=='EMI'){
                        $data['CheckSum']   =$data['amount']*(2.25/100);   
                    }
                    $data['CashSum']    =$data['CheckSum']*0.18;
                    $data['TrsfrSum']   =$data['amount']-($data['CheckSum']+$data['CashSum']);
                }else if($data['U_PaymentGateway']=='paytm'){
                    if($pres=='UPI'){
                        $data['CheckSum']   =0;                        
                    }else if($pres=='PPI'){
                        $data['CheckSum']   =$data['amount']*(1.60/100);                        
                    }else if($pres=='NB'){
                        $data['CheckSum']   =17;                        
                    }else if($pres=='CC' && $pres=='AMEX'){
                        $data['CheckSum']   =$data['amount']*(2.70/100);                        
                    }else if($pres=='CC' && $pres!='AMEX'){
                        $data['CheckSum']   =$data['amount']*(1.20/100);   
                    }else if($pres=='DC' && $data['amount']>2000){
                        $data['CheckSum']   =$data['amount']*(0.01);   
                    }else if($pres=='DC' && $data['amount']<2000){
                        $data['CheckSum']   =$data['amount']*(0.0075);   
                    }
                    $data['CashSum']    =$data['CheckSum']*0.18;
                    $data['TrsfrSum']   =$data['amount']-($data['CheckSum']+$data['CashSum']);
                }else{
                    $data['CheckSum']=0;
                    $data['CashSum'] =0;
                    $data['TrsfrSum']= $data['amount'];
                }

            }
            //echo "<pre>";print_r($data);exit;
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

        $custSQL = "INSERT INTO `WEB_RCT2` (`U_OrigEntry`, `DocEntry`,`SumApplied`,`CardCode`,`U_OrigNum`) VALUES ";
        $i       = 1;
        foreach ($WEB_RCT2Arr as $key => $data)
        {
            $custSQL .= "('" . $data['U_OrigEntry'] . "','" . $data['DocEntry'] . "','" . $data['SumApplied'] . "','" . $data['CardCode'] . "','" . $data['U_OrigNum'] . "'),";
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

$query   = "SELECT date_entered FROM `te_payment_details` ORDER BY `te_payment_details`.`date_entered` DESC limit 1";
$leadObj = mysqli_query($conn, $query);
$row     = mysqli_fetch_assoc($leadObj);
$sql = "INSERT INTO SYNC_SAP_TIMESTAMP  SET reg_date='" . $row['date_entered'] . "'";

//$sql = "INSERT INTO SYNC_SAP_TIMESTAMP  SET reg_date='" . date("Y-m-d H:i:s") . "'";
mysqli_query($sap_conn, $sql);

mysqli_close($conn);
?>		 
