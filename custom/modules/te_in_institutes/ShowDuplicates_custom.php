<?php
global $db;
if(isset($_REQUEST['name']));
{
	$VAL=$_REQUEST['name'];
	
}
	
echo "<script type='text/javascript'>alert('Record Duplicate ! $VAL')</script>";
echo " The Institute record name you are about to create might be a duplicate of an Institute record that already exists.

 click Back to Button to return to the creating New unique Institute.";
?>
</br>
<button onclick="window.location.href='index.php?module=te_in_institutes&action=EditView'">Back to create </button>



