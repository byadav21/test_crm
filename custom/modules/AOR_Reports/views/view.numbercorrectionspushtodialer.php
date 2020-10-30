<?php
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');
//error_reporting(E_ALL);

class AOR_ReportsViewnumbercorrectionspushtodialer extends SugarView
{
    public function __construct()
    {
        parent::SugarView();
    }

    public function display()
    {
        global $db, $current_user;
        $sugarSmarty = new Sugar_Smarty();
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
                $sugarSmarty->display('custom/modules/AOR_Reports/tpls/numbercorrectionspushtodialer.tpl');
                return true;
            } else if ($_FILES["file"]["size"] > 0)
            {
                $count = 0;
                $count_blank = 0;
                $flag = true;
                $file     = fopen($filename, "r");
                while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
                {
                    if($flag) { 
                        if($emapData[0] != "ID" && $emapData[1] != "Campagain ID" && $emapData[2] != "API_id LeadID" && $emapData[3] != "Correct Number"){
                            echo "<script type=\"text/javascript\">
                                alert(\"Invalid Column:Please Upload CSV File.\");
                                </script>";
                            // print_r($emapData);
                            $sugarSmarty->display('custom/modules/AOR_Reports/tpls/numbercorrectionspushtodialer.tpl');
                            return true; 
                        }
                        $flag = false; continue; 
                    }

                    // echo "<pre>"; print_r($emapData);
                    
                    //Check Validation All 
                    if($emapData[0] !='' && $emapData[1] !='' && $emapData[2] !='' && $emapData[3] !='') 
                    {
                        //update leads set phone_mobile, dristi_campagain_id, dristi_API_id

                        $agentupdate    ='update  leads set 
                                            `dristi_campagain_id`   = "'.$emapData[1].'",
                                            `dristi_API_id`         = "'.$emapData[2].'",
                                            `phone_mobile`          = "'.$emapData[3].'",
                                            `date_modified`         = "'.date("Y-m-d H:i:s").'" 
                                            where `id`              = "'.$emapData[0].'" ';
                        
                        $result = $db->query($agentupdate);
                        $count++;
                    } else {
                        echo "<script type=\"text/javascript\">
                                    alert(\"Please check:-Require all feilds data.\");
                                </script>";
                        $count_blank++;
                    }
                }

                if($result)
                {
                    echo "<script type=\"text/javascript\">
                            alert(\"CSV File has been successfully Imported.\");
                            alert(\"Total Number of count Rows Data:-". $count." Total Number of Blank count Rows Data:-". $count_blank."\");
                        </script>";
                }
            }

            fclose($file);
        }
        
        $sugarSmarty = new Sugar_Smarty();
        $sugarSmarty->assign("examList",$examList);
        $sugarSmarty->assign("docsnum",$docsnum);
        $sugarSmarty->assign("documentifo",$documentifo);
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/numbercorrectionspushtodialer.tpl');
    }
}

?>