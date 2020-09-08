<?php
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');
//error_reporting(E_ALL);

class AOR_ReportsViewactualupload extends SugarView
{
    public function __construct()
    {
        parent::SugarView();
    }

    public function display()
    {
        global $db, $current_user;
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
                    </script>";
            }

            if ($_FILES["file"]["size"] > 0)
            {
                $count = 0;

                $file     = fopen($filename, "r");
                while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
                {   

                    if ($count== 0 && $emapData[2] !='') {
                        $cdate=$emapData[2];
                        $count++;
                        continue;
                    }

                    if ($count<=4) {
                        $count++;
                        continue;
                    }
                    
                    //Check Validation Date & Email 
                    if($emapData[2]=='' || $emapData[7]=='') 
                    continue;

                    //Check user name exist or not
                    $userselect = "SELECT id, user_name FROM users WHERE `user_name`='".$emapData[7]."' ";
                    $result_set =  $db->query($userselect);
                    $contRowUser    = $db->fetchByAssoc($result_set);

                    if($contRowUser['id']=='' && $contRowUser['user_name']==''  ){//user not exists
                        continue;
                    }

                    $SQLSELECT = "SELECT * FROM te_amyeo_calls_history WHERE `name`='".$emapData[7]."' AND `calling_date`= '".$cdate."' ";
                    $result_set =   $db->query($SQLSELECT);
                    $contRow    =   $db->fetchByAssoc($result_set);
                    
                    if($contRow>0) {
                        $agentupdate    ='update  te_amyeo_calls_history set 
                                            `calling_date`      = "'.$cdate.'",
                                            `manager`           = "'.$emapData[0].'",
                                            `tl_am`             = "'.$emapData[1].'",
                                            `modified_user_id`  = "'.$current_user->id.'",
                                            `counsellor_id`     = "'.$contRowUser['id'].'",
                                            `counsellor`        = "'.$emapData[7].'",
                                            `total_calls_dialed`= "'.$emapData[9].'",
                                            `inbound_time`      = "'.$emapData[49].'",
                                            `outbound_time`     = "'.$emapData[50].'",
                                            `autodial_time`     = "'.$emapData[51].'",
                                            `total_call_time`   = "'.$emapData[52].'",
                                            `average_talk_time` = "'.$emapData[36].'",
                                            `name`              = "'.$emapData[7].'"
                                            where `name` ="'.$emapData[7].'" and calling_date="'.$cdate.'" ';
                        
                        $result = $db->query($agentupdate);
                        if(!$result)
                        {
                            echo "<script type=\"text/javascript\">
                                    alert(\"Error:Please check the Update query.\");
                                </script>";
                        }

                    }else {
                        
                        $sql = 'insert into te_amyeo_calls_history (calling_date,id,manager,tl_am,modified_user_id,created_by,counsellor_id,counsellor,total_calls_dialed,inbound_time,outbound_time,autodial_time,total_call_time,average_talk_time,name, date_entered) values ("'.$cdate.'","'.create_guid().'",
                    "'.$emapData['0'].'", "'.$emapData['1'].'", "'.$current_user->id.'", "'.$current_user->id.'", "'.$contRowUser['id'].'", "'.$emapData['7'].'", "'.$emapData['9'].'", "'.$emapData['49'].'", "'.$emapData['50'].'", "'.$emapData['51'].'", "'.$emapData['52'].'","'.$emapData['36'].'","'.$emapData[7].'", "'.date("Y-m-d H:i:s").'")';
                                    
                        $result = $db->query($sql);
                        if(!$result)
                        {
                            echo "<script type=\"text/javascript\">
                                    alert(\"Error:Please check the Insert query.\");
                                </script>";
                        }
                    }
                    $count++;
                    
                   /* if($result)
                    {
                        echo "<script type=\"text/javascript\">
                                alert(\"CSV File has been successfully Imported.\");
                            </script>";
                    }*/
                  
                }

            }

            fclose($file);
        }
        
        $sugarSmarty = new Sugar_Smarty();
        $sugarSmarty->assign("examList",$examList);
        $sugarSmarty->assign("docsnum",$docsnum);
        $sugarSmarty->assign("documentifo",$documentifo);
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/actualupload.tpl');
    }
}

?>