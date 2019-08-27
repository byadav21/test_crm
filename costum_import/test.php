<?php

include 'db.php';

$SQLSELECT = "select id_c,email_addresses.email_address from leads_cstm
INNER JOIN email_addr_bean_rel ON email_addr_bean_rel.bean_id = id_c AND email_addr_bean_rel.bean_module ='Leads'  
INNER JOIN email_addresses ON email_addresses.id =  email_addr_bean_rel.email_address_id where (email_add_c is null or email_add_c='' or email_add_c=' ') ";
$result_set =  mysqli_query($conn,$SQLSELECT);
$i=0; 
while($row = mysqli_fetch_array($result_set)){
 echo $i++.'.';   
 $sqlu="update leads_cstm set email_add_c='". $row['email_address'] ."' where id_c='". $row['id_c'] ."'";
         mysqli_query($conn,$sqlu);

/*
	echo $sql="select dispositionName from dristi_log where lead_id='" . $row['lid'] . "' and entryPoint='dispose amyo' order by dated desc"; 
	$result_setd =  mysqli_query($conn,$sql);
	if($result_setd){
		$dis= mysqli_fetch_array($result_setd);
		if($dis){
		  echo $sqlu="update testlead set disposition='". $dis['dispositionName'] ."' where lid='". $row['lid'] ."'";	
		  mysqli_query($conn,$sqlu);
		}
	}*/
}
