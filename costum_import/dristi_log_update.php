<?php

include 'db.php';

function getLog($lead_id){
 $SQLSELECT  = "SELECT dl.lead_id, dl.`dispositionName` ,dl.dated,dl.`entryPoint` ,dl.`callType` FROM `dristi_log` dl
            WHERE dl.lead_id='".$lead_id."' AND dl.`entryPoint`='dispose amyo' AND dl.`customer_id`!=''
            ORDER BY dl.lead_id,dl.dated  DESC
            LIMIT 1";
}

$SQLSELECT  = "SELECT l.id FROM `leads` l limit 10";
$result_set = mysqli_query($conn, $SQLSELECT) or die('error:'. mysqli_error($conn));


  while ($emapData = mysqli_fetch_assoc($result_set))
        {   
            echo $emapData['id'].'<br>';
            //print_r($emapData); die;
      
            $Leadssql    = "update  leads set vendor='".$emapData[4]."',utm='".$emapData[5]."',utm_campaign='".$emapData[6]."' where id ='".$emapData[0]."'";
	   
            //$result = mysqli_query($conn, $Leadssql);
            
         
        }
   

//close of connection
mysqli_close($conn);

?>		 