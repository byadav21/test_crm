<?php

include 'db.php';
if (isset($_POST["Import"]))
{


    $mimeType      = '';
    $extentionType = '';
    $filename      = $_FILES["file"]["tmp_name"];
    $finfo         = finfo_open(FILEINFO_MIME_TYPE); // return mime type text/plain 
    $mimeType      = finfo_file($finfo, $filename) . "\n";

    $filenameEx = $_FILES["file"]["name"];
    $allowed    = array('csv');
    $ext        = pathinfo($filenameEx, PATHINFO_EXTENSION);

    if (!in_array($ext, $allowed))
    {
        $extentionType = 'error';
    }

    if ($extentionType == 'error' && $mimeType != 'text/plain')
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
            //utm_source_c
            $vendor   = $emapData[2];
            //utm_contract_c
            $contract = $emapData[3];
            //utm_term_c
            $batch    = $emapData[1];

            $SQLSELECT  = "select id from te_ba_batch  where batch_code='" . $batch . "' and deleted=0";
            $result_set = mysqli_query($conn, $SQLSELECT);
            $contRow    = mysqli_num_rows($result_set);
            $batchData = mysqli_fetch_assoc($result_set);
           
            
            if ($contRow > 0)
            {
                
                
               
                $SQLSELECT  = "select id from te_vendor  where name='" . $vendor . "' and deleted=0";
                $result_set = mysqli_query($conn, $SQLSELECT);
                $Vendorcont = mysqli_num_rows($result_set);
                $VendorData = mysqli_fetch_assoc($result_set);
               
                if ($Vendorcont > 0)
                {

                    $utmSQl     = "SELECT te_utm.id,
                                            te_utm.name
                                            FROM te_utm
                                            INNER JOIN te_vendor_te_utm_1_c v ON v.te_vendor_te_utm_1te_utm_idb=te_utm.id
                                            AND te_vendor_te_utm_1te_vendor_ida='{$VendorData['id']}'
                                            WHERE te_ba_batch_id_c='{$batchData['id']}'
                                              AND contract_type='{$contract}'
                                              AND te_utm.deleted=0
                                              AND v.deleted=0 
                                              AND te_utm.utm_status='Live'";
                    $result_set = mysqli_query($conn, $utmSQl);
                    $Utmcont    = mysqli_num_rows($result_set);
                   
                    if ($Utmcont > 0)
                    {
                        $utmData = mysqli_fetch_assoc($result_set);
                        $utmName = $utmData['name'];

                        $LeadsCstmsql = "UPDATE leads_cstm
                                        SET te_ba_batch_id_c='" . $batchData['id'] . "'
                                        WHERE id_c ='" . $emapData[0] . "'";
                        
                        $Leadssql     = "UPDATE leads
                                        SET vendor      ='" . $vendor . "',
                                            utm         ='" . $utmName . "',
                                        WHERE id        ='" . $emapData[0] . "'";
                        mysqli_query($conn, $Leadssql);
                        $result       = mysqli_query($conn, $LeadsCstmsql);
                    }
                }
            }
            if (!$result)
            {
                echo "<script type=\"text/javascript\">
							alert(\"Error:Please check the update query.\");
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