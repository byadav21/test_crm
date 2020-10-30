<?php
error_reporting(-1);
ini_set('display_errors', 'On');

#Invoices Header : Stud_OINV Update State  

include 'db.php';
include 'sap_db.php';

class sync_update_tables
{
    function Stud_OINV()
    {
        global $conn;
        $leadsCstmData    = array();
        if(!empty($_REQUEST['startdate']) && !empty($_REQUEST['enddate'])){
			$startDate 	= date("Y-m-d", strtotime($_REQUEST['startdate']));
			$endDate 	= date("Y-m-d", strtotime($_REQUEST['enddate']));	
			echo "StartDate:- ".$startDate." && EndDate:- ".$endDate."<br/>";
		}
        //die('imhere');
       $query   = "SELECT `pd`.`state` AS `State`, `pd`.`invoice_order_number` AS `NumAtCard`
                      FROM `te_payment_details` `pd` 
                      WHERE `pd`.`deleted` = 0
                        AND `pd`.`date_entered` > '$startDate' AND `pd`.`date_entered` <= '$endDate' 
                      ORDER BY `pd`.`date_entered`";
        $leadObj = mysqli_query($conn, $query);
        if ($leadObj)
        {
			$i= 1;
            while ($row = mysqli_fetch_assoc($leadObj))
            {
				//echo "<pre>==NumAtCard=="; print_r($row['NumAtCard']."==Address==".$row['Address']."==State==".$row['State']."====".$i);
                $leadsCstmData[] = $row;
                $i++;
            }
        }
        
        return $leadsCstmData;
    }

    function main()
    {

        global $sap_conn;

        $Stud_OINVArr_new     = array();

        #1. /////////// Stud_OINV Update State Table Syncing //////////////////
        
        $Stud_OINVArr_new = $this->Stud_OINV();
        echo '<hr>Stud_OINV Table Syncing <br />';
		
        // Only State Feild Updates
        $j = 1;
        foreach ($Stud_OINVArr_new as $key => $set_data)
        {
			
			$select_query = "SELECT State, NumAtCard from  `Stud_OINV` where NumAtCard = '".$set_data['NumAtCard']."' ";
			$get_data 	= mysqli_query($sap_conn, $select_query) or die(mysqli_error($sap_conn));
			if($get_data){
				$row_count 	= mysqli_fetch_assoc($get_data);
				
				//if(empty($row_count['State']) || ($row_count['State'] == NULL) ){
					echo "Number of Count:- ".$j." && NumAtCard ID:- ".$set_data['NumAtCard']." && State:- ".$set_data['State']."<br/>";
					$check_state = $set_data['State'];

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
					$update_query = "UPDATE `Stud_OINV` SET `State` = '".$state."' where NumAtCard = '".$set_data['NumAtCard']."'  ";
					$update_state = mysqli_query($sap_conn, $update_query) or die(mysqli_error($sap_conn));
					$j++;
				//}
			}
			
		}
		
        unset($Stud_OINVArr_new);
    }

// END of Main
}

$mainObj = new sync_update_tables();
$mainObj->main();

?>		 
