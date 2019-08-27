<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
ini_set('memory_limit', '1024M');
require_once('include/entryPoint.php');
require_once('custom/modules/Leads/eloqua/lib/eloquaRequest.php');

//error_reporting(-1);
//ini_set('display_errors', 'On');

global $db;
error_reporting(-1);
ini_set('display_errors', 'On');

class updateEloquaStatus
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

    function getLeads()
    {

        global $db;
        $leadsCstmData = array();

        $query = "SELECT              
                    l.date_entered,
		    l.id lead_id,
                    lc.eloqua_contact_id,
                    lc.eloqua_customobject_id,
                    lc.te_ba_batch_id_c,
                    lc.email_add_c,
                    bb.batch_status,
		    bb.batch_code
             FROM leads_cstm lc
             INNER JOIN leads l ON lc.id_c=l.id
             inner join te_ba_batch bb on lc.te_ba_batch_id_c=bb.id
             where 
             l.deleted=0 
             and (l.status='Converted' or l.status_description='Converted')
	     AND date(l.date_entered) >= '".date('Y-m-d',strtotime("-1 days"))."'
             AND date(l.date_entered) <='".date('Y-m-d')."'
	     #AND date(l.date_entered) >= '2017-01-01' 
	     #AND date(l.date_entered) <='2017-06-31'
	      order by l.date_entered";

	echo '<pre>'.$query; 
	//die();
                     

        $leadObj = $db->query($query);
        if ($leadObj)
        {

            while ($row = $db->fetchByAssoc($leadObj))
            {
                $leadsCstmData[] = $row;
            }
        }

        return $leadsCstmData;
    }

    public function main()
    {
        global $sugar_config, $app_list_strings, $current_user, $db;

        $leadsCstmData = array();

        $DataArr = $this->getLeads();

        echo "<pre>";
        print_r($DataArr);
        //die;


        foreach ($DataArr as $key => $data)
        {
            $d_campaign_id   = $data['lead_id'];
            $contact_id      = $data['eloqua_contact_id'];
            $customobject_id = $data['eloqua_customobject_id'];
            $batch_id_c      = $data['te_ba_batch_id_c'];
            $email_add_c     = $data['email_add_c'];
            $batch_status    = $data['batch_status'];
            if ($customobject_id != '')
            {


                $client = new EloquaRequest('https://secure.p07.eloqua.com/API/REST/2.0');

                $GetContactID = $client->get('/data/contacts?search=*' . $email_add_c);
                if (!empty($GetContactID->elements))
                {
                    $contactArr   = $GetContactID->elements;
                    $contactIDAPI = $contactArr[0]->id;
                    $contactIDAPI = ($contactIDAPI != '') ? $contactIDAPI : $contact_id;
                }

                $this->createLog('{getContactID}', 'eloquaConverted_' . date('Y-m-d') . '.txt', $contactArr[0]->id, $GetContactID->elements);


                if (!isset($_REQUEST['import_module']) && $_REQUEST['module'] != "Import")
                {
                    $contact = array(
                        'id'          => $customobject_id,
                        'contactId'   => $contactIDAPI,
                        'fieldValues' =>
                        array(
                            0 => array('type' => 'FieldValue', 'id' => 153, 'value' => 'Converted'),
                            1 => array('type' => 'FieldValue', 'id' => 154, 'value' => 'Converted'),
                            2 => array('type' => 'FieldValue', 'id' => 171, 'value' => isset($batch_status) ? $batch_status : ''),
                        ),
                    );
                    //$this->createLog($contact, '{On Request status update}');
                    //echo "<pre>inUpdate="; print_r($contact); 
                    //echo json_encode($contact); die;

                    $response = $client->put('/data/customObject/7/instance/' . $customobject_id, $contact);

                    if ($response->id != '')
                    {

                        $contactObjIDXX = $response->id;
                        $contactIDXX    = $contactIDAPI;
                        $sqlQuery       = "UPDATE leads_cstm
                                        SET eloqua_contact_id='$contactIDXX',
                                            eloqua_customobject_id='$contactObjIDXX'
                                WHERE email_add_c='" . $email_add_c . "'
                                  AND te_ba_batch_id_c='" . $batch_id_c . "'";
                        $db->query($sqlQuery);

                        $db->query("update leads_cstm  set eloqua_contact_id='$contactIDXX' where  email_add_c='" . $email_add_c . "'");


                        $this->createLog('{checking update on email and batch}', 'eloquaConverted_' . date('Y-m-d') . '.txt', $sqlQuery, array());
                    }
		    else
		    {
                        $this->createLog('{if response have no id}', 'eloquaConverted_' . date('Y-m-d') . '.txt', $email_add_c, array());
		    }
                }
            }
        }
    }

// End of main function
}

$mainObj = new updateEloquaStatus();
$mainObj->main();


