<?php
$sap_conn=mysqli_connect("crm-db-server.cdftgd7ki47z.ap-south-1.rds.amazonaws.com","sapcrm","sap,*12#","sap_crm") or die("Could not connect");
mysqli_select_db($sap_conn,"sap_crm") or die("could not connect database");
?>
