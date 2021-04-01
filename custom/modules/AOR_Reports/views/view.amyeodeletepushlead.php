<?php
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');

//error_reporting(E_ALL);
	
//echo"Gya pani me";
require_once('custom/modules/te_Api/te_Api.php');
$api = new te_Api_override();

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
            if ($_FILES["file"]["size"] > 0){
                $count = 0;
                $file     = fopen($filename, "r");
                while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE){   
                    if ($count == 0) {
                        $count++;
                        continue;
                    }    
                    //print_r($emapData) die();
                    if($emapData[0]=='' || $emapData[1]==''){
                        continue;
                    }
                    //For Update
                    

                    $result = $api->removeContactsFromCampaign($campaignId, $customerIds);
                    
                    if (!$result){
                        echo "<script type=\"text/javascript\">
                        alert(\"Error:Please check the Insert query.\");
                        //  window.location = \"index.php?module=AOR_Reports&action=targetupload\"
                        </script>";
                    }
                       
                    $count++;
                   /*if (!$result)
                    {
                     echo "<script type=\"text/javascript\">
                                   alert(\"Error:Please check the update query.\");
                                   window.location = \"index.php?module=AOR_Reports&action=targetupload\"
                         </script>";
                    }*/
                }//while end
            }//file size check



            fclose($file);
             
           /*
            echo "<script type=\"text/javascript\">
                                alert(\"CSV File has been successfully Imported.\");
                                window.location = \"../index.php?module=AOR_Reports&action=productivityform\"
                            </script>";
            */
           
            }
        
         $sugarSmarty = new Sugar_Smarty();
        $sugarSmarty->assign("examList",$examList);
        $sugarSmarty->assign("docsnum",$docsnum);
        $sugarSmarty->assign("documentifo",$documentifo);
  
  
        // $sugarSmarty->assign("error", $error);
        // $sugarSmarty->assign("leadList", $leadList);
        // $sugarSmarty->assign("headers", $headers);
        // $sugarSmarty->assign("tablewidth", count($headers) * 130);
        // $sugarSmarty->assign("QueueCount", $QueueCount);
        // $sugarSmarty->assign("junkCount", $junkCount);

        // $sugarSmarty->assign("campaignIDs", $campaignID);
        // $sugarSmarty->assign("leadIDs", $leadID);
        // $sugarSmarty->assign("ExcelHeaders", $ExcelHeaders);
        // $sugarSmarty->assign("current_records", $current);
        // $sugarSmarty->assign("page", $page);
        // $sugarSmarty->assign("pagenext", $pagenext);
        // $sugarSmarty->assign("pageprevious", $pageprevious);
        // $sugarSmarty->assign("right", $right);
        // $sugarSmarty->assign("left", $left);
        // $sugarSmarty->assign("last_page", $last_page);
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/amyeodeletepushlead.tpl');
    }

}
?>

