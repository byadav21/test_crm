<?php

include 'db.php';
$leadtobedelete=[];
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
                                                 window.location = \"leads_update.php\"
                                         </script>";
     }

    if ($_FILES["file"]["size"] > 0)
    {

        $file     = fopen($filename, "r");
        $dristi_campagain_id='';
        while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
        {   
            echo $SQLSELECT = "SELECT * FROM leads WHERE `id`='".$emapData[0]."' ";
				$result_set =  mysqli_query($conn,$SQLSELECT);
				$contRow = mysqli_num_rows($result_set);
            if($contRow>0) {  
				    $row= mysqli_fetch_assoc($result_set);                 
					//It wiil insert a row to our subject table from our csv file`
					//echo $sql    = "update  leads set assigned_user_id='".$emapData[1]."' where id ='".$emapData[0]."'";
					//we are using mysql_query function. it returns a resource on true else False on error
					//$result = mysqli_query($conn, $sql);
				$customerRecords=[];	
				if($row['first_name'] || $row['last_name']) $customerRecords['name']= $row['first_name']." ". $row['last_name'];
				if($row['first_name'] )  $customerRecords['first_name'] = $row['first_name'];
				if($row['last_name'] )  $customerRecords['last_name'] = $row['last_name'];
		 
				if($row['phone_mobile'] )  $customerRecords['phone1'] = $row['phone_mobile'];
				if($row['phone_home'] )  $customerRecords['phone2'] = $row['phone_home'];
				if($row['phone_work'] )  $customerRecords['phone3'] = $row['phone_work'];
				if($row['phone_other'] )  $customerRecords['phone4'] = $row['phone_other'] ;	 
				if($row['id'] )  $customerRecords['lead_reference'] = $row['id'];
				$leadtobedelete['customerRecords'][]=$customerRecords;
                                $dristi_campagain_id=$emapData[1];
            
            }
//            if (!$result)
//            {
//                echo "<script type=\"text/javascript\">
//							alert(\"Error:Please check the update query.\");
//							window.location = \"leads_update.php\"
//						</script>";
//            }
        }
        fclose($file);
        //echo $dristi_campagain_id; die;
        $server = 'http://180.151.225.244:8888/ameyowebaccess/command/?command=force-login&data=';
	
		$data=[];
		$data['userId']= "pankaj.jha@talentedge.in";
		$data['password']= '123456';
		$data['terminal']= $_SERVER['REMOTE_ADDR'];
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $server. urlencode(json_encode($data)));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 100);						
		echo $session= curl_exec($ch); 

		$jsonEncodedData = json_decode($session);
		$session=$jsonEncodedData->sessionId;
                
                $campID=18;
                $apiID=42;
               
                if($dristi_campagain_id==18){
                                                          
                        $campID=18;
                        $apiID=46;
                }
                else if($dristi_campagain_id==16){

                        $campID=16;
                        $apiID=47;
                }
                else if($dristi_campagain_id==17){

                        $campID=17;
                        $apiID=48;
                }
                
		$leadtobedelete['sessionId']=$session;
		$leadtobedelete['properties']=array('update.customer'=>true,'migrate.customer'=>true);
		
		$leadtobedelete['status']='NOT_TRIED';
                $leadtobedelete['campaignId']=$campID;
		$leadtobedelete['leadId']=$apiID;

		$ch = curl_init(); 
                curl_setopt($ch, CURLOPT_URL, 'http://180.151.225.244:8888/ameyowebaccess/command?command=uploadContacts');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_TIMEOUT, 100);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, "data=".urlencode(json_encode($request)));					
                echo $response = curl_exec($ch);
        
        
        //throws a message if data successfully imported to mysql database from excel file
       /* echo "<script type=\"text/javascript\">
						alert(\"CSV File has been successfully Imported.\");
						window.location = \"leads_update.php\"
					</script>";
*/


        //close of connection
        mysqli_close($conn);
    }
}





?>		 
