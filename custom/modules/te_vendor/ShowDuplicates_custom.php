<?php
global $db;
if(isset($_REQUEST['name']));
{
	$VAL=$_REQUEST['name'];
	
}
	
echo "<script type='text/javascript'>alert('Record Duplicate ! $VAL')</script>";
echo "The Vendor record name you are about to create might be a duplicate of an Vendor record that already exists.

 click Back to Button to return to the  creating New Vendor.";
?>
</br>
<button onclick="window.location.href='index.php?module=te_vendor&action=EditView'">Back to create </button>






