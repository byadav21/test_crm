<?php

include 'db.php';

$SQLSELECT = "SELECT lid FROM testlead limit 100,11000";
$result_set =  mysqli_query($conn,$SQLSELECT);
 
while($row = mysqli_fetch_array($result_set)){
	
	echo $sql="select dispositionName from dristi_log where lead_id='" . $row['lid'] . "' and entryPoint='dispose amyo' order by dated desc"; 
	$result_setd =  mysqli_query($conn,$sql);
	if($result_setd){
		$dis= mysqli_fetch_array($result_setd);
		if($dis){
		  echo $sqlu="update testlead set disposition='". $dis['dispositionName'] ."' where lid='". $row['lid'] ."'";	
		  mysqli_query($conn,$sqlu);
		}
	}
}
