<?php
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');

//error_reporting(E_ALL);
	
//echo"Gya pani me";
require_once('custom/modules/te_Api/te_Api.php');


class AOR_ReportsViewamyeodeletepushlead extends SugarView
{

    public function __construct()
    {
        parent::SugarView();
    }

    public function display()
    {
        global $db;
        if (isset($_POST["Import"])){
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
            if ($extentionType=='error' && $mimeType!='text/plain'){             
               echo "<script type=\"text/javascript\">
                            alert(\"Invalid File:Please Upload CSV File.\");
                            window.location = \"index.php?module=AOR_Reports&action=amyeodeletepushlead\"
                    </script>";
            }
            $numcols = count(file($filename));
            $maxLimitRows = 680;
            if ($numcols > $maxLimitRows){             
                echo "<script type=\"text/javascript\">
                alert(\"Invalid File:Max Limit allowed is $maxLimitRows . Current Count is:- \" + $numcols);
                            //  window.location = \"index.php?module=AOR_Reports&action=amyeodeletepushlead\"
                     </script>";
             }
            //  print_r($numcols);die('imherews');
            
            if ($_FILES["file"]["size"] > 0 && $numcols <= $maxLimitRows){
                $empData = array();
                $count = 0;
                $file     = fopen($filename, "r");
                while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE){
                    if ($count == 0) {
                        $count++;
                        continue;
                    }   
                    
                    if($emapData[0]=='' || $emapData[1]==''){
                        continue;
                    }
                    
                    $empData[$emapData[0]][] = $emapData[1];
                    
                    $count++;
                   
                }//while end

                $api = new te_Api_override();
                $sessionId = $api->doLogin();
                // echo "<pre>"; print_r($empData);die('imhere');
                foreach ($empData as $key => $value) {
                    $campaignId = $key;
                    $customerIds = $value;
                    $response = $api->removeContactsFromCampaign($sessionId,$campaignId, $customerIds);
                }
                
                if (!$response->result){
                    echo "<script type=\"text/javascript\">
                    alert(\"Error:Please Try again!.\");
                    //  window.location = \"index.php?module=AOR_Reports&action=targetupload\"
                    </script>";
                }else {
                    echo '<h1 class="response" style="text-align:center; color:green; font-size: 20px;">'.$response->result."</h1>";
                }

            }//file size check
            
            fclose($file);
          
            // echo "Imhere";
        }
            
        
        $sugarSmarty = new Sugar_Smarty();
       
        $sugarSmarty->assign("error", $error);
        $sugarSmarty->assign("response", $response);
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/amyeodeletepushlead.tpl');
    }

}
?>

