<?php
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');

//error_reporting(E_ALL);
	
//echo"Gya pani me";
require_once('custom/modules/te_Api/te_Api.php');


class AOR_ReportsViewamyeoupdatepushleadapi extends SugarView
{

    public function __construct()
    {
        parent::SugarView();
    }

    // Get phone number for lead id
    function getPhoneNumber($leadid='')
    {
        try{
            global $db;
            //Check user name exist or not
            $getData = "SELECT phone_mobile FROM leads WHERE `id`='".$leadid."' ";
            $result_set =  $db->query($getData);
            $getMobile    = $db->fetchByAssoc($result_set);
            echo "<pre>";print_r($getMobile['phone_mobile']);
            return $getMobile['phone_mobile'];
        }catch(Exception $e){
			return false;
		}
    }

    public function display()
    {
        global $db;
        // print_r($db);
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

            if ($numcols >= $maxLimitRows){             
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
                    
                    if($emapData[0]=='' || $emapData[1]=='' || $emapData[2]=='' || $emapData[3]=='' || $emapData[4]=='' || $emapData[5]==''){
                        continue;
                    }

                    // $getData = ;
                    $result_set =  $db->query("SELECT phone_mobile FROM leads WHERE `id`='".$emapData[0]."' ");
                    $getMobile    = $db->fetchByAssoc($result_set);



                    
                    $empData[$emapData[0]]['leadid']                = $emapData[0];
                    $empData[$emapData[0]]['dristi_campagain_id']   = $emapData[1];
                    $empData[$emapData[0]]['dristi_API_id']         = $emapData[2];
                    $empData[$emapData[0]]['ameyo_status']          = $emapData[3];
                    $empData[$emapData[0]]['phone_mobile']          = $getMobile['phone_mobile'];
                    $empData[$emapData[0]]['status']                = $emapData[4];
                    $empData[$emapData[0]]['status_description']    = $emapData[5];
                    $count++;

                }//while end
  //               echo "<pre>"; print_r($empData);
                // die('imheewdc');
                $api = new te_Api_override();
                $data               =   [];
                $session            =   $api->doLogin();								
               
		 foreach ($empData as $keyData => $valueData) {
                     
                    $data['campaignId']                = $valueData['dristi_campagain_id'];
                    $data['leadId']                    = $valueData['dristi_API_id'];
                    $data['sessionId']                 = $session;
                    $data['properties']                = array('update.customer'=>true,'migrate.customer'=>true);
                    //$data['status']                    = $valueData['ameyo_status'];
                    $data['customerRecords']           = [];
                    $customerRecords['phone1']         = $valueData['phone_mobile'];
                    $customerRecords['lead_reference'] = $valueData['leadid'];
                    $data['customerRecords'][]         = $customerRecords;
                    $data['status']                    = $valueData['ameyo_status'];
//                    echo "<pre>";print_r($data);
                    
                    $responses = $api->uploadContactsCampaigainID($data);//,$campID,$apiID  

// {"campaignId":"49","leadId":516,"sessionId":"d379-60536742-ses-noc@talentedge.in-sDmnGOJS-25809","properties":{"update.customer":true,"migrate.customer":true},"status":"NOT_TRIED","customerRecords":[{"phone1":"9818222840","lead_reference":"1022a9cb-5bef-6c5c-d787-601accc832d8"},{"phone1":"8929822325","lead_reference":"104aa438-8e4c-2703-6017-603354583a2a"}]}
                    if($responses){
                        $db->query("update leads set  status='". $valueData['status']  ."' , status_description='". $valueData['status_description'] ."',assigned_user_id='', assigned_date='". date('Y-m-d H:i:s') ."' where id='". $valueData['leadid'] ."'");	
                    }
                }



                
                if (!$responses){
                    echo "<script type=\"text/javascript\">
                    alert(\"Error:Please Try again!.\");
                    //  window.location = \"index.php?module=AOR_Reports&action=amyeoupdatepushleadapi\"
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
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/amyeoupdatepushleadapi.tpl');
    }

}
?>

