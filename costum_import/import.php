<?php

include 'db.php';
if (isset($_POST["Import"]))
{


    echo $filename = $_FILES["file"]["tmp_name"];


    if ($_FILES["file"]["size"] > 0)
    {

        $file     = fopen($filename, "r");
        while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
        {   
            echo $SQLSELECT = "SELECT * FROM te_utm WHERE `id`='".$emapData[1]."' ";
				$result_set =  mysqli_query($conn,$SQLSELECT);
				$contRow = mysqli_num_rows($result_set);
            if($contRow>0) {                   
            //It wiil insert a row to our subject table from our csv file`
            echo $sql    = "update  te_utm set te_ba_batch_id_c='".$emapData[4]."' where id ='".$emapData[1]."'";
	            	
            //we are using mysql_query function. it returns a resource on true else False on error
            $result = mysqli_query($conn, $sql);
            }
            if (!$result)
            {
                echo "<script type=\"text/javascript\">
							alert(\"Invalid File:Please Upload CSV File.\");
							window.location = \"index.php\"
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