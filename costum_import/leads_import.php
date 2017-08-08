<?php

include 'db.php';
if (isset($_POST["Import"]))
{


     $mimeType='';
    $extentionType='';
    $filename = $_FILES["file"]["tmp_name"];
    $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type text/plain 
    $mimeType= finfo_file($finfo, $filename) . "\n"; 
   
    $filenameEx = $_FILES["file"]["name"];
    $allowed =  array('csv');
    $ext = pathinfo($filenameEx, PATHINFO_EXTENSION);
   
    if(!in_array($ext,$allowed) ) {
        $extentionType= 'error';
    }
    
     if ($extentionType=='error' && $mimeType!='text/plain')
     {
         echo "<script type=\"text/javascript\">
                                                 alert(\"Invalid File:Please Upload CSV File.\");
                                                 window.location = \"index.php\"
                                         </script>";
     }


    if ($_FILES["file"]["size"] > 0)
    {

        $file     = fopen($filename, "r");
        while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
        {   
           if($emapData[3]=='Converted') continue;
            echo $SQLSELECT = "SELECT * FROM leads WHERE `id`='".$emapData[0]."' ";
				$result_set =  mysqli_query($conn,$SQLSELECT);
				$contRow = mysqli_num_rows($result_set);
            if($contRow>0) {                   
            //It wiil insert a row to our subject table from our csv file`
            $LeadsCstmsql    = "update  leads_cstm set te_ba_batch_id_c='".$emapData[2]."'  where id_c ='".$emapData[0]."'";
            //$Leadssql    = "update  leads set vendor='".$emapData[4]."',utm='".$emapData[5]."',utm_campaign='".$emapData[6]."' where id ='".$emapData[0]."'";
	    //mysqli_query($conn, $LeadsCstmsql);        	
            //we are using mysql_query function. it returns a resource on true else False on error
            $result = mysqli_query($conn, $LeadsCstmsql);
            }
            if (!$result)
            {
                 echo "<script type=\"text/javascript\">
							alert(\"Error:Please check the update query.\");
							window.location = \"leads_update.php\"
						</script>";
            }
        }
        fclose($file);
        //throws a message if data successfully imported to mysql database from excel file
        echo "<script type=\"text/javascript\">
						alert(\"CSV File has been successfully Imported.\");
						window.location = \"index.php\"
					</script>";



        //close of connection
        mysqli_close($conn);
    }
}
?>		 
