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
        


        $query   = "SELECT  replace(`te_in_institutes`.`id`, '-', '') AS `U_BPID`,
                            replace(`te_in_institutes`.`name`, '&', ' ') AS `CardName`,
                            replace(`te_in_institutes`.`description`, '&', ' ') AS `CardFName`
                     FROM   `te_in_institutes`
                     WHERE  `te_in_institutes`.`deleted` = 0 
                     AND    `te_in_institutes`.`date_entered` > '2018-04-01'";
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
                   AND `te_student`.`date_entered` > '2018-04-01'";

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
        
        
    
        
        $query   = "SELECT replace(`pr`.`id`, '-', '') AS `U_CourseID`,
                            replace(`pr`.`name`, '&', ' ') AS `ItemName`,
                            replace(`pr`.`description`, '&', ' ') AS `FrgnName`,
                            `inst`.`name` AS `U_Institute`,
                            `pr`.`SAP_Status` AS `SAP_Status`
                      FROM  `te_pr_programs` `pr`
                            JOIN `te_in_institutes_te_pr_programs_1_c` `inst_rel` on `pr`.`id` = `inst_rel`.`te_in_institutes_te_pr_programs_1te_pr_programs_idb`
                            JOIN `te_in_institutes` `inst` on `inst_rel`.`te_in_institutes_te_pr_programs_1te_in_institutes_ida` = `inst`.`id`
                     WHERE  pr.deleted=0";
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
        
        
  
        $query   = "SELECT 
                                replace(`te_vendor`.`id`, '-', '') AS `U_BPID`,
                                `te_vendor`.`name` AS `CardName`,
                                `te_vendor`.`description` AS `CardFName`,
                                `te_vendor`.`phone` AS `Phone1`,
                                `te_vendor`.`email` AS `E_Mail`,
                                `te_vendor`.`SAP_Status` AS `SAP_Status`
                            FROM `te_vendor`
                            WHERE  `te_vendor`.`name` <> ''
                                   AND `te_vendor`.`date_entered` > '2018-04-01'";
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
                        AND `pd`.`date_of_payment` > '2018-03-31'
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
       
       

        $query   = "SELECT 		
                            replace(`pd`.`id`, '-', '') AS `U_OrigEntry`,
                            (CASE
                             WHEN (`leads`.`primary_address_state` = 'BR') THEN 'BH'
                             ELSE `leads`.`primary_address_state`
                            END) AS `BpStateCod`,
                            `pd`.`SAP_Status` AS `SAP_Status`
                            
                            FROM `te_student` AS  `s`

                            JOIN `te_student_te_student_batch_1_c` `stsb` on `s`.`id` = `stsb`.`te_student_te_student_batch_1te_student_ida`
                            JOIN `te_student_batch` `sb` on `stsb`.`te_student_te_student_batch_1te_student_batch_idb` = `sb`.`id`
                            JOIN `te_student_payment` `sp` on `stsb`.`te_student_te_student_batch_1te_student_batch_idb` = `sp`.`te_student_batch_id_c`
                            JOIN `te_payment_details` `pd` on `sp`.`id` = `pd`.`student_payment_id`
                            JOIN `leads` on `sb`.`leads_id` = `leads`.`id`
                    WHERE `s`.`deleted` = 0
                        AND `leads`.`primary_address_state` <> ''
                        AND `leads`.`primary_address_state` <> 0 ";
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
WHERE   `sb`.`deleted` = 0
       AND `pd`.`deleted` = 0
       AND `pd`.`date_of_payment` > '2018-03-31'
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
                        AND `pd`.`date_of_payment` > '2018-03-31'";
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
        
      
        $query   = "SELECT replace(`pd`.`id`, '-', '') AS `U_OrigEntry`,
                            `pd`.`SAP_DocEntry` AS `DocEntry`,
                             0 AS `InvoiceId`,
                            `pd`.`amount` AS `SumApplied`,
                            `pd`.`Pay_Status` AS `Pay_Status`
                     FROM (((((`te_student` `s`
                               JOIN `te_student_te_student_batch_1_c` `stsb` on((`s`.`id` = `stsb`.`te_student_te_student_batch_1te_student_ida`)))
                              JOIN `te_student_batch` `sb` on((`stsb`.`te_student_te_student_batch_1te_student_batch_idb` = `sb`.`id`)))
                             JOIN `te_student_payment` `sp` on((`stsb`.`te_student_te_student_batch_1te_student_batch_idb` = `sp`.`te_student_batch_id_c`)))
                            JOIN `te_payment_details` `pd` on((`sp`.`id` = `pd`.`student_payment_id`)))
                           JOIN `leads` on((`sb`.`leads_id` = `leads`.`id`)))
                     WHERE pd.deleted=0 AND `pd`.`date_of_payment` > '2018-04-31'";
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
       
        $query   = "SELECT replace(`bb`.`id`, '-', '') AS `U_OrigCode`,
                            replace(`bb`.`batch_code`, '-', '_') AS `PrjCode`,
                            replace(`bb`.`batch_code`, '-', '_') AS `PrjName`,
                            'N' AS `Locked`,
                            'Y' AS `Active`,
                            `bb`.`SAP_Status` AS `SAP_Status`
                     FROM `te_ba_batch` `bb`
                     WHERE (`bb`.`deleted` = 0)";
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


        #1. /////////// Customer Table Syncing //////////////////
        
               
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
        
        $CustomersArr     = $this->Customers();
        $StudCustomersArr = $this->StudCustomers();
        $ItemsArr         = $this->Items();
        $SupplierArr      = $this->Supplier();
        $Stud_OINVArr     = $this->Stud_OINV();
        $Stud_INV1Arr     = $this->Stud_INV1();
        $Stud_INV12Arr    = $this->Stud_INV12();
        $WEB_ORCTArr      = $this->WEB_ORCT();
        $WEB_RCT1Arr      = $this->WEB_RCT1();
        $WEB_RCT2Arr      = $this->WEB_RCT2();
        $WEB_OPRJArr      = $this->WEB_OPRJ();

        //echo 'xx==='.$SyncSapTimestamp;
        //echo "<pre>";
        //print_r($WEB_OPRJArr);
        //die;
        
        #1. /////////// Customers Table Syncing //////////////////
        echo '<hr>Customers Table Syncing ';

        foreach ($CustomersArr as $key => $data)
        {
            echo  $sql = "INSERT INTO Customers 
                                  SET 
                        U_BPID='" . $data['U_BPID'] . "',
                        CardName='" . $data['CardName'] . "',
                        CardFName='" . $data['CardFName'] . "'";
            mysqli_query($sap_conn,$sql);
        }



        #2. /////////// StudCustomers Table Syncing //////////////////
        echo '<hr>StudCustomers Table Syncing ';
         
         
        foreach ($StudCustomersArr as $key => $data)
        {
            echo $sql = "INSERT INTO StudCustomers 
                                SET 
                        U_BPId='" . $data['U_BPId'] . "',
                        CardName='" . $data['CardName'] . "',
                        CardFName='" . $data['CardFName'] . "',
                        E_Mail='" . $data['E_Mail'] . "',
                        Phone1='" . $data['Phone1'] . "',
                        Cellular='" . $data['Cellular'] . "',
                        State1='" . $data['State1'] . "',
                        State2='" . $data['State2'] . "',
                        Country='" . $data['Country'] . "',
                        MailCountr='" . $data['MailCountr'] . "'";
           mysqli_query($sap_conn,$sql);
        }

        #3. /////////// Items Table Syncing //////////////////
        echo '<hr>Items Table Syncing ';
        
        
        foreach ($ItemsArr as $key => $data)
        {
           echo $sql = "INSERT INTO Items 
                                SET 
                        U_CourseID='" . $data['U_CourseID'] . "',
                        ItemName='" . $data['ItemName'] . "',
                        FrgnName='" . $data['FrgnName'] . "',
                        U_Institute='" . $data['U_Institute'] . "'";

            mysqli_query($sap_conn,$sql);
        }

        #4. /////////// Supplier Table Syncing //////////////////
        echo '<hr>Supplier Table Syncing ';
         
         
        foreach ($SupplierArr as $key => $data)
        {
            echo $sql = "INSERT INTO Supplier 
                                SET 
                        U_BPID='" . $data['U_BPID'] . "',
                        CardName='" . $data['CardName'] . "',
                        CardFName='" . $data['CardFName'] . "',
                        Phone1='" . $data['Phone1'] . "',
                        E_Mail='" . $data['E_Mail'] . "'";

            mysqli_query($sap_conn,$sql);
        }

        #5. /////////// Stud_OINV Table Syncing //////////////////
        echo '<hr>Stud_OINV Table Syncing ';
        
        foreach ($Stud_OINVArr as $key => $data)
        {
           echo $sql = "INSERT INTO Stud_OINV 
                                SET 
                        U_OrigEntry='" . $data['U_OrigEntry'] . "',
                        U_OrigNum='" . $data['U_OrigNum'] . "',
                        U_ARInvNo='" . $data['U_ARInvNo'] . "',
                        SlpCode='" . $data['SlpCode'] . "',
                        DocDate='" . $data['DocDate'] . "',
                        TaxDate='" . $data['TaxDate'] . "',
                        DocDueDate='" . $data['DocDueDate'] . "',
                        CardCode='" . $data['CardCode'] . "',
                        Address='" . $data['Address'] . "',
                        NumAtCard='" . $data['NumAtCard'] . "',
                        U_Batch='" . $data['U_Batch'] . "'";

            mysqli_query($sap_conn,$sql);
        }

        #6. /////////// Stud_INV1 Table Syncing //////////////////
        echo '<hr>Stud_INV1 Table Syncing ';
        
        foreach ($Stud_INV1Arr as $key => $data)
        {
            echo $sql = "INSERT INTO Stud_INV1 
                                SET 
                        U_OrigEntry='" . $data['U_OrigEntry'] . "',
                        U_OrigLine='" . $data['U_OrigLine'] . "',
                        ItemCode='" . $data['ItemCode'] . "',
                        Quantity='" . $data['Quantity'] . "',
                        PriceBefDi='" . $data['PriceBefDi'] . "',
                        TaxCode='" . $data['TaxCode'] . "',
                        OcrCode='" . $data['OcrCode'] . "',
                        OcrCode2='" . $data['OcrCode2'] . "',
                        OcrCode3='" . $data['OcrCode3'] . "',
                        OcrCode4='" . $data['OcrCode4'] . "',
                        OcrCode5='" . $data['OcrCode5'] . "',
                        Project='" . $data['Project'] . "'";

            mysqli_query($sap_conn,$sql);
        }

        #7. /////////// Stud_INV12 Table Syncing //////////////////
        echo '<hr>Stud_INV12 Table Syncing ';
        
        foreach ($Stud_INV12Arr as $key => $data)
        {
            echo $sql = "INSERT INTO Stud_INV12 
                                SET 
                        U_OrigEntry='" . $data['U_OrigEntry'] . "',
                        BpStateCod='" . $data['BpStateCod'] . "'<br>";

            mysqli_query($sap_conn,$sql);
        }

        #8. /////////// WEB_ORCT Table Syncing //////////////////
        echo '<hr>WEB_ORCT Table Syncing ';
        
        foreach ($WEB_ORCTArr as $key => $data)
        {
            echo $sql = "INSERT INTO WEB_ORCT 
                                SET 
                        U_OrigEntry= '" . $data['U_OrigEntry'] . "',
                        DocDate='" . $data['DocDate'] . "',
                        DocDueDate='" . $data['DocDueDate'] . "',
                        TaxDate='" . $data['TaxDate'] . "',
                        CardCode='" . $data['CardCode'] . "',
                        Address='" . $data['Address'] . "',
                        Pay_Status='" . $data['Pay_Status'] . "',
                        U_PaymnetID='" . $data['U_PaymnetID'] . "',
                        U_PaymentGateway='" . $data['U_PaymentGateway'] . "',
                        CheckAcct='" . $data['CheckAcct'] . "',
                        CashAcct='" . $data['CashAcct'] . "',
                        TrsfrSum='" . $data['TrsfrSum'] . "',
                        TrsfrAcct='" . $data['TrsfrAcct'] . "',
                        CheckSum='" . $data['CheckSum'] . "',
                        CashSum='" . $data['CashSum'] . "'"; 

            mysqli_query($sap_conn,$sql); 
        }

        #9. /////////// WEB_RCT1 Table Syncing //////////////////
        echo '<hr>WEB_RCT1 Table Syncing ';
        
        foreach ($WEB_RCT1Arr as $key => $data)
        {
           echo $sql = "INSERT INTO WEB_RCT1 
                                SET 
                        U_OrigEntry='" . $data['U_OrigEntry'] . "',
                        DueDate='" . $data['DueDate'] . "',
                        CheckSum='" . $data['CheckSum'] . "'";

            mysqli_query($sap_conn,$sql);
        }

        #10. /////////// WEB_RCT2 Table Syncing //////////////////
        echo '<hr>WEB_RCT2 Table Syncing ';
        

        foreach ($WEB_RCT2Arr as $key => $data)
        {
           echo $sql = "INSERT INTO WEB_RCT2 
                                SET 
                        U_OrigEntry='" . $data['U_OrigEntry'] . "',
                        DocEntry='" . $data['DocEntry'] . "',
                        SumApplied='" . $data['SumApplied'] . "'";

            mysqli_query($sap_conn,$sql); 
        }

        #11. /////////// WEB_OPRJ Table Syncing //////////////////
        echo '<hr>WEB_OPRJ Table Syncing ';
        
        
        foreach ($WEB_OPRJArr as $key => $data)
        {
           echo $sql = "INSERT INTO WEB_OPRJ 
                                SET 
                        U_OrigCode='" . $data['U_OrigCode'] . "',
                        PrjCode='" . $data['PrjCode'] . "',
                        PrjName='" . $data['PrjName'] . "',
                        Locked='" . $data['Locked'] . "',
                        Active='" . $data['Active'] . "'";

            mysqli_query($sap_conn,$sql);
        }
    }

// END of Main
}

$mainObj = new syncsaptables();
$mainObj->main();

$sql = "INSERT INTO SYNC_SAP_TIMESTAMP  SET reg_date='".date("Y-m-d h:i:s")."'";
mysqli_query($conn,$sql);

mysqli_close($conn);
?>		 
