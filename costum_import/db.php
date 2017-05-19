<?php
$conn=mysqli_connect("crm-db-server.cdftgd7ki47z.ap-south-1.rds.amazonaws.com","root","talentarina","crm_stage") or die("Could not connect");
mysqli_select_db($conn,"crm_stage") or die("could not connect database");
?>
