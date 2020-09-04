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
                                                 window.location = \"actualupload.php\"
                                         </script>";
     }


    if ($_FILES["file"]["size"] > 0)
    {
        $count = 0;

        $file     = fopen($filename, "r");
        while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
        {   

    if ($count== 0) {
        $cdate=$emapData[2];
    $count++;
    continue;
}

if ($count<=4) {
   $count++;
continue;
}

$SQLSELECT = "SELECT * FROM users WHERE `user_name`='".$emapData[7]."' ";
                $result_set =  mysqli_query($conn,$SQLSELECT);
                $contRow = mysqli_fetch_array($result_set);
               $name=$contRow['user_name'];

 $sql = 'insert into te_amyeo_calls_history (calling_date,id,manager,tl_am,counsellor,total_calls_dialed,inbound_time,outbound_time,autodial_time,total_call_time,average_talk_time,name) values ("'.$cdate.'","'.mt_rand().'",
 "'.$emapData['0'].'", "'.$emapData['1'].'", "'.$emapData['7'].'", "'.$emapData['8'].'", "'.$emapData['49'].'", "'.$emapData['50'].'", "'.$emapData['51'].'", "'.$emapData['52'].'","'.$emapData['36'].'","'.$contRow['user_name'].'")';
//exit();
//print_r($sql); die();
 $result = mysqli_query($conn, $sql);
if (!$result)
        {
            echo "<script type=\"text/javascript\">
                         alert(\"Error:Please check the update query.\");
                        window.location = \"actualupload.php\"
                       </script>";
          }
  $count++;
  
}
  fclose($file);
        
    echo "<script type=\"text/javascript\">
					alert(\"CSV File has been successfully Imported.\");
					window.location = \"../index.php?module=AOR_Reports&action=prospectdashboard2\"
					</script>";
 //close of connection
        mysqli_close($conn);
    }
}
?>		 
