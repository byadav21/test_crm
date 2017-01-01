<?php
global $db;
if(isset($_REQUEST['name']));
{
	$VAL=$_REQUEST['name'];
	
}
	
echo "<script type='text/javascript'>alert('Record Duplicate ! $VAL')</script>";
echo "The institute record name already mapped With Program to create might be a duplicate of an institute record that already exists.
      click Back to Button to return to the Select New institute With This Program.";
?>
</br>
<button onclick="window.location.href='index.php?module=te_pr_Programs&action=EditView'">Back to create </button>



