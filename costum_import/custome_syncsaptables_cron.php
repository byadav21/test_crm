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

    function Customers()
    {

        global $conn;
        $leadsCstmData    = array();
        $SyncSapTimestamp = $this->SyncSapTimestamp();



        $query   = "SELECT  replace(`te_in_institutes`.`id`, '-', '') AS `U_BPID`,
                            replace(`te_in_institutes`.`name`, '&', ' ') AS `CardName`,
                            replace(`te_in_institutes`.`description`, '&', ' ') AS `CardFName`
                     FROM   `te_in_institutes`
                     WHERE  `te_in_institutes`.`deleted` = 0";
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






       
    }

// END of Main
}

$mainObj = new syncsaptables();
$mainObj->main();
?>		 
