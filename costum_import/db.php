<?php
$conn=mysqli_connect("crm-db-server.cdftgd7ki47z.ap-south-1.rds.amazonaws.com","root","talentarina","crm") or die("Could not connect");
mysqli_select_db($conn,"crm") or die("could not connect database");
?>
