<?php
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');

//error_reporting(E_ALL);
	
//echo"Gya pani me";

class AOR_ReportsViewtargetupload extends SugarView
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
                                                         window.location = \"index.php?module=AOR_Reports&action=targetupload\"
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
                    if($emapData[0]=='' || $emapData[1]==''|| $emapData[2]==''||$emapData[12]==''){
                        continue;
                    }
                    //For Update
                    $userselect = "SELECT * FROM users WHERE `user_name`='".$emapData[0]."' ";
                    $result_set =  $db->query($userselect);
                    $contRowuser = $db->fetchByAssoc($result_set);
                    if($contRowuser['id']==''){//user not exists
                        continue;
                    }
                    $batchselect = "SELECT * FROM te_ba_batch WHERE `batch_code`='".$emapData[3]."' ";
                    $result_set_batch =  $db->query($batchselect);
                    $contRowbatch= $db->fetchByAssoc($result_set_batch);
                    $SQLSELECT = "SELECT * FROM agent_productivity_report WHERE `user_id`='".$contRowuser['id']."' and month='".$emapData[1]."' and year='".$emapData[2]."'";
                        $result_set =  $db->query($SQLSELECT);
                        $contRow = $db->fetchByAssoc($result_set);
                    if($contRow>0) {                   
                        $agentupdate    ='update  agent_productivity_report set `user_id`="'.$contRowuser['id'].'",
                        `reporting_to`="'.$contRowuser['reports_to_id'].'",
                        `month`="'.$emapData[1].'",
                        `year`="'.$emapData[2].'",
                        `batch_code`="'.$emapData[3].'",
                        `batch_id`="'.$contRowbatch['id'].'",
                        `target_gsv`="'.$emapData[4].'",
                        `target_unit`="'.$emapData[5].'",
                        `target_pitched`="'.$emapData[6].'",
                        `target_prospects`="'.$emapData[7].'",
                        `conversion_rate`="'.$emapData[8].'",
                        `connected_calls`="'.$emapData[9].'",
                        `talk_time`="'.$emapData[10].'",
                        `quality_score`="'.$emapData[11].'",
                        `modified_date`="'.date("Y-m-d H:i:s").'",
                        `working_days`="'.$emapData[12].'" where `user_id` ="'.$contRowuser['id'].'" and month="'.$emapData[1].'" and year="'.$emapData[2].'"';
                        $result = $db->query($agentupdate);
                    }else{                       
                        $username=$contRowuser['first_name']." ".$contRowuser['last_name'];
                        $sql = 'insert into agent_productivity_report (user_name,user_id,reporting_to,month,year,batch_code,target_gsv,target_unit,target_pitched,target_prospects,conversion_rate,connected_calls,talk_time,quality_score,working_days,status) values ( "'.$username.'","'.$contRowuser['id'].'","'.$contRowuser['reports_to_id'].'" ,"'.$emapData['1'].'", "'.$emapData['2'].'", "'.$emapData['3'].'", "'.$emapData['4'].'", "'.$emapData['5'].'", "'.$emapData['6'].'", "'.$emapData['7'].'", "'.$emapData['8'].'", "'.$emapData['9'].'", "'.$emapData['10'].'", "'.$emapData['11'].'", "'.$emapData['12'].'","1")';

                        $result = $db->query($sql);
                        if (!$result){
                            echo "<script type=\"text/javascript\">
                            alert(\"Error:Please check the Insert query.\");
                            //  window.location = \"index.php?module=AOR_Reports&action=targetupload\"
                            </script>";
                        }                        
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
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/targetupload.tpl');  

    }

}

?>