<?php
# For Staging CRM
$conn=mysqli_connect("crm-stage-env.cdftgd7ki47z.ap-south-1.rds.amazonaws.com","webuser","we8Us3r@543","crm_stage") or die("Could not connect");
mysqli_select_db($conn,"crm_stage") or die("could not connect database");

# For Live CRM
/*$conn=mysqli_connect("crm-db-server-v2.cdftgd7ki47z.ap-south-1.rds.amazonaws.com","webuser","Us3r#&8)","crm_stage") or die("Could not connect");
mysqli_select_db($conn,"crm_stage") or die("could not connect database");*/
?>
