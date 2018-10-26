<?php
# For 35.154.138.186
//$conn=mysqli_connect("35.154.138.186","crm","crm","crm_te") or die("Could not connect");
//mysqli_select_db($conn,"crm_te") or die("could not connect database");

# For Live CRM
$conn=mysqli_connect("crm-db-server.cdftgd7ki47z.ap-south-1.rds.amazonaws.com","webuser","Us3r#&8)","crm_stage") or die("Could not connect");
mysqli_select_db($conn,"crm_stage") or die("could not connect database");
?>
