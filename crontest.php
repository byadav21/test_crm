<?php
$myfile = fopen("newfile.txt", "a") or die("Unable to open file!");
$txt = date('Y-m-d H:i:s');
fwrite($myfile, "\n". $txt);
fclose($myfile);
?>
