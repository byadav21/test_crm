<?php
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');

//error_reporting(E_ALL);
	
//echo"Gya pani me";

class AOR_ReportsViewactualupload extends SugarView
{

    public function __construct()
    {
        parent::SugarView();
    }

    public function display()
    {
global $db;
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
                                                         window.location = \"index.php?module=AOR_Reports&action=actualupload\"
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
//print_r($emapData) die();
                   // if($emapData[0]=='' || $emapData[1]==''|| $emapData[2]==''||$emapData[12]=='') continue;
$SQLSELECT = "SELECT * FROM users WHERE `user_name`='".$emapData[7]."' ";
               $result_set =  $db->query($SQLSELECT);
                        $contRow = $db->fetchByAssoc($result_set);
               $name=$contRow['user_name'];
                       
                  $sql = 'insert into te_amyeo_calls_history (calling_date,id,manager,tl_am,counsellor,total_calls_dialed,inbound_time,outbound_time,autodial_time,total_call_time,average_talk_time,name) values ("'.$cdate.'","'.mt_rand().'",
 "'.$emapData['0'].'", "'.$emapData['1'].'", "'.$emapData['7'].'", "'.$emapData['8'].'", "'.$emapData['49'].'", "'.$emapData['50'].'", "'.$emapData['51'].'", "'.$emapData['52'].'","'.$emapData['36'].'","'.$contRow['user_name'].'")';
                 
                    $result = $db->query($sql);
                    //print_r($db); die();
                    if (!$result)
                    {
                         echo "<script type=\"text/javascript\">
                                    alert(\"Error:Please check the Insert query.\");
                                //  window.location = \"index.php?module=AOR_Reports&action=actualupload\"
                                </script>";
                    }
                    $count++;
            

                    /*if($emapData[0]=='') continue;
                    $SQLSELECT = "SELECT * FROM agent_productivity_report WHERE `user_id`='".$emapData[0]."' ";
                        $result_set =  $db->query($SQLSELECT);
                        $contRow = $db->fetchByAssoc($result_set);
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


                            $result = $db->query($agentupdate);
                   }
                   if (!$result)
                    {
                     echo "<script type=\"text/javascript\">
                                   alert(\"Error:Please check the update query.\");
                                   window.location = \"index.php?module=AOR_Reports&action=actualupload\"
                         </script>";
                    }*/
                }
            }



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
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/actualupload.tpl');  

    }

}

?>