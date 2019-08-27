<?php
# For Staging CRM
//$sap_conn=mysqli_connect("crm-stage-env.cdftgd7ki47z.ap-south-1.rds.amazonaws.com","webuser","we8Us3r@543","crm_stage") or die("Could not connect");
//mysqli_select_db($sap_conn,"sap_crm") or die("could not connect database");

# For Live CRM
$sap_conn=mysqli_connect("sap-crm.cdftgd7ki47z.ap-south-1.rds.amazonaws.com","webuser","w3#busEr","sap_crm") or die("Could not connect");
mysqli_select_db($sap_conn,"sap_crm") or die("could not connect database");
?>
