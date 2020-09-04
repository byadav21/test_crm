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
                                                 window.location = \"targetupload.php\"
                                         </script>";
     }


    if ($_FILES["file"]["size"] > 0)
    {
        $count = 0;

        $file     = fopen($filename, "r");
        while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
        {   
    if ($count == 0) {
        $count++;
        continue;
    }    

if($emapData[0]=='' || $emapData[1]==''|| $emapData[2]==''||$emapData[12]=='') continue;
               
  $sql = 'insert into agent_productivity_report (user_id,month,year,batch_code,target_gsv,target_unit,target_pitched,target_prospects,conversion_rate,connected_calls,talk_time,quality_score,working_days) values ( "'.$emapData['0'].'", "'.$emapData['1'].'", "'.$emapData['2'].'", "'.$emapData['3'].'", "'.$emapData['4'].'", "'.$emapData['5'].'", "'.$emapData['6'].'", "'.$emapData['7'].'", "'.$emapData['8'].'", "'.$emapData['9'].'", "'.$emapData['10'].'", "'.$emapData['11'].'", "'.$emapData['12'].'")';
//print_r($sql); die();
 $result = mysqli_query($conn, $sql);
            
            if (!$result)
            {
                 echo "<script type=\"text/javascript\">
							alert(\"Error:Please check the update query.\");
						//	window.location = \"targetupload.php\"
						</script>";
            }
            $count++;
    

if($emapData[0]=='') continue;
         echo $SQLSELECT = "SELECT * FROM agent_productivity_report WHERE `user_id`='".$emapData[0]."' ";
                $result_set =  mysqli_query($conn,$SQLSELECT);
                $contRow = mysqli_num_rows($result_set);
           if($contRow>0) {                   
    $agentupdate    ='update  agent_productivity_report set `user_id`="'.$emapData[0].'",
    `month`="'.$emapData[1].'",
    `year`="'.$emapData[2].'",
    `batch_code`="'.$emapData[3].'",
    `target_gsv`="'.$emapData[4].'",
    `target_unit`="'.$emapData[5].'",
    `target_pitched`="'.$emapData[6].'",
    `target_prospects`="'.$emapData[7].'",
    `conversion_rate`="'.$emapData[8].'",
    `connected_calls`="'.$emapData[9].'",
    `talk_time`="'.$emapData[10].'",
    `quality_score`="'.$emapData[11].'",
    `working_days`="'.$emapData[12].'" where `user_id` ="'.$emapData[0].'"';


            $result = mysqli_query($conn, $agentupdate);
           }
           if (!$result)
            {
             echo "<script type=\"text/javascript\">
                           alert(\"Error:Please check the update query.\");
                           window.location = \"targetupload.php\"
                 </script>";
            }
}



        fclose($file);
        
        echo "<script type=\"text/javascript\">
						alert(\"CSV File has been successfully Imported.\");
						window.location = \"../index.php?module=AOR_Reports&action=productivityform\"
					</script>";
        //close of connection
        mysqli_close($conn);
    }
}
?>		 
