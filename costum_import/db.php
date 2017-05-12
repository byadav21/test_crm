<?php
$conn=mysqli_connect("localhost","root","","test") or die("Could not connect");
mysqli_select_db($conn,"crm") or die("could not connect database");
?>