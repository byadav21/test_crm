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
                     WHERE `bb`.`deleted` = 0 AND `bb`.`date_entered` > '2019-02-26' "
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

    function main()
    {

        global $sap_conn;

       
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
?>		 
