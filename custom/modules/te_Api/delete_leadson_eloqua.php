<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('custom/modules/Leads/eloqua/lib/eloquaRequest.php');

error_reporting(-1);
ini_set('display_errors', 'On');

class eloqua_contact
{

    function createLog($action, $filename, $field = '', $dataArray = array())
    {
        $file = fopen(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) . "upload/apilog/$filename", "a");
        fwrite($file, date('Y-m-d H:i:s') . "\n");
        fwrite($file, $action . "\n");
        fwrite($file, $field . "\n");
        fwrite($file, print_r($dataArray, TRUE) . "\n");
        fclose($file);
    }

    function delete_leads_eloqua()
    {
        global $db;

        //echo "<pre>"; print_r($bean);

        echo $leadObj =  "SELECT lc.eloqua_contact_id,
       		lc.eloqua_customobject_id,
	       lc.eloqua_contact_status,
	       lc.eloqua_customobject_status,
	       l.id lead_id
	FROM leads_cstm lc
	INNER JOIN leads l ON lc.id_c=l.id
	WHERE l.deleted=0
	  AND (lc.eloqua_contact_id!=''
	       OR lc.eloqua_customobject_id!='')
	  AND (lc.eloqua_contact_status=0 or lc.eloqua_customobject_status=0)
	  #AND lc.email_add_c LIKE 'test%' 
	  #AND DATE(l.date_entered) >=  '2019-04-1
	  AND DATE(l.date_entered) <=  '2017-12-31'
	limit 500000"; 

        $result = $db->query($leadObj);

        //$contact_client = new EloquaRequest('https://secure.p07.eloqua.com/API/REST/1.0');
        $custome_client = new EloquaRequest('https://secure.p07.eloqua.com/API/REST/2.0');
	$response='';
        if ($db->getRowCount($result) > 0)
        {
            $lead_detail = array();
            while ($row         = $db->fetchByAssoc($result))
            {

                $contact_id      = $row['eloqua_contact_id']; 
                $customobject_id = $row['eloqua_customobject_id'];
                $lead_id         = $row['lead_id'];

                /*if ($contact_id != '')
                {	
		     echo 'contact_id='.$contact_id.'<br>';
                     $response = $contact_client->delete('/data/contact/'.$contact_id, '');
		     echo '$response='.$response.'<br>'; 

                    if ($response==200)
                    {
			$db->query("update leads_cstm set eloqua_contact_status=1 where eloqua_contact_id='$contact_id'");
                        $this->createLog('{In $contact_id}', 'delete_eloqua_log_' . date('Y-m-d') . '.txt', $contact_id, $response);
                    }
                }*/

                if ($customobject_id != '')
                {	
		    echo 'customobject_id='.$customobject_id.'<br>';
                    $response = $custome_client->delete('/data/customObject/7/instance/' . $customobject_id, '');
		    echo '$response='.$response.'<br>';
                    if ($response==200)
                    {	
			$db->query("update leads_cstm set eloqua_customobject_status=1 where eloqua_customobject_id='$customobject_id'");
                        $this->createLog('{In $customobject_id}', 'delete_eloqua_log_' . date('Y-m-d') . '.txt', $customobject_id, $response);
                    }
                }
            }
        }
    }

}
$mainObj = new eloqua_contact();
$mainObj->delete_leads_eloqua();
