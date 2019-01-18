    <?php

    ini_set('max_execution_time', 3600);
    set_time_limit(3600);
    require_once('custom/modules/te_Api/te_Api.php');
    $api = new te_Api_override();
    global $db;
    
    
    function createLog($action, $filename, $field = '', $dataArray = array())
    {
        $file = fopen(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) . "upload/apilog/$filename", "a");
        fwrite($file, date('Y-m-d H:i:s') . "\n");
        fwrite($file, $action . "\n");
        fwrite($file, $field . "\n");
        fwrite($file, print_r($dataArray, TRUE) . "\n");
        fclose($file);
    }


    $sql    = "select lead_id from cron_job where session_id='cron_job'";
    $result = $db->query($sql);
    if ($db->getRowCount($result) > 0)
    {
        $res = $db->fetchByAssoc($result);
        if ($res['lead_id'] == 1)
            exit();
    }




    $sqll      = "SELECT count(l.id) as ctr  from leads l WHERE l.deleted =0 and l.neoxstatus='0'";
    $res       = $db->query($sqll);
    $countLead = $db->fetchByAssoc($res);

    $db->query("update cron_job set lead_id='1' where session_id='cron_job'");
    
    $sql = "SELECT l.id,
            l.first_name,
            l.last_name,
            l.phone_mobile,
            l.phone_home,
            l.phone_work,
            l.phone_other,
            e.email_address,
            concat (dristi_campagain_id, dristi_api_id) AS drtord,
            dristi_campagain_id,
            dristi_api_id
     FROM leads l
     LEFT JOIN email_addr_bean_rel el ON l.id = el.bean_id
     AND el.bean_module='Leads'
     AND el.deleted=0
     LEFT JOIN email_addresses e ON el.email_address_id = e.id
     AND e.deleted=0
     WHERE l.deleted =0
       AND l.status_description= 'New Lead'
       AND l.neoxstatus='0'
       AND dristi_campagain_id !=''
       AND dristi_api_id !=''
       AND (l.assigned_user_id= 'NULL'
            OR l.assigned_user_id =''
            OR l.assigned_user_id IS NULL)
     ORDER BY concat (dristi_campagain_id, dristi_api_id)
     LIMIT 1000";

    $allInserted = [];
    $result      = $db->query($sql);
    $last        = '';
    $ctr         = 0;
    $currentCamp = '';
    $currentApi  = '';
    $allInserted = [];
    $pushed      = false;

    if ($db->getRowCount($result) > 0)
    {

        $data               = [];
        $session            = $api->doLogin();
        $data['sessionId']  = $session;
        $data['properties'] = array('update.customer' => true, 'migrate.customer' => true);
        if (!$session)
        {
            //echo 'Invalid Session';
            echo json_encode(array('status'=>'error','current_queue'=>'Invalid Session, Login failed!')); 
            exit();
        }


        $customerRs              = [];
        $data['customerRecords'] = [];
        while ($row                     = $db->fetchByAssoc($result))
        {

            if ($last != '' && $row['drtord'] != $last)
            {
                $last                    = $row['drtord'];
                $request                 = $data;
                $data['customerRecords'] = [];
                $pushed                  = true; // print_r($request);
                //echo count($request['customerRecords']);
                $responses               = $api->uploadContacts($request, $currentCamp, $currentApi);
                if (isset($responses->beanResponse) && count($responses->beanResponse) > 0)
                {
                    foreach ($responses->beanResponse as $key => $res)
                    {
                        if (isset($res->inserted) && ($res->inserted == 1 or $res->inserted == 'true'))
                        {
                            try
                            {
                                $update = "UPDATE leads
                                                        SET dristi_customer_id='" . $res->customerId . "',
                                                            neoxstatus =1
                                           WHERE id = '" . $allInserted[$key]['id'] . "'";
                                
                                $db->query($update);
                                $sql    = "INSERT INTO dristi_upload_logs
                                                        SET lead_id='" . $allInserted[$key]['id'] . "',
                                                        dated='" . date('Y-m-d H:i:s') . "',
                                                        customer_id='" . $res->customerId . "',
                                                        resultTypeString='" . $res->resultTypeString . "',text='" . json_encode($res) . "'";
                                $db->query($sql);
                                
                                //createLog('{createLog 1.}', 'pushLead_xx_'.date('Y-m-d').'.txt', $sql, json_encode($res));
                                
                            } catch (Exception $e)
                            {
                                //crete log	
                            }
                        }
                        else
                        {
                            try
                            {
                                $sql = "INSERT INTO dristi_upload_logs
SET                                                 lead_id='" . $allInserted[$key]['id'] . "',
                                                    dated='" . date('Y-m-d H:i:s') . "',
                                                    customer_id='" . $res->customerId . "',
                                                    resultTypeString='" . $res->resultTypeString . "',text='" . json_encode($res) . "'";
                                $db->query($sql);
                                
                                //createLog('{createLog 2.}', 'pushLead_xx_'.date('Y-m-d').'.txt', $sql, json_encode($res));
                                
                            } catch (Exception $e)
                            {
                                //crete log	
                            }
                        }
                    }
                }
                else
                {
                    try
                    {
                        $sql = "INSERT INTO dristi_upload_logs
                                                SET 
                                                lead_id='" . $allInserted[0]['id'] . "',
                                                dated='" . date('Y-m-d H:i:s') . "',
                                                customer_id='error',
                                                resultTypeString='error',text='" . json_encode($responses) . "'";
                        $db->query($sql);
                        
                        //createLog('{createLog 3.}', 'pushLead_xx_'.date('Y-m-d').'.txt', $sql, json_encode($res));
                        
                    } catch (Exception $e)
                    {
                        //crete log	
                    }
                }
                $allInserted = [];
            }
            if ($last == '')
                $last = $row['drtord'];

            $allInserted[]                     = $row;
            if ($row['first_name'] || $row['last_name'])
                $customerRecords['name']           = $row['first_name'] . " " . $row['last_name'];
            if ($row['first_name'])
                $customerRecords['first_name']     = $row['first_name'];
            if ($row['last_name'])
                $customerRecords['last_name']      = $row['last_name'];
            if ($row['email_address'])
                $customerRecords['email']          = $row['email_address'];
            if ($row['phone_mobile'])
                $customerRecords['phone1']         = $row['phone_mobile'];
            if ($row['phone_home'])
                $customerRecords['phone2']         = $row['phone_home'];
            if ($row['phone_work'])
                $customerRecords['phone3']         = $row['phone_work'];
            if ($row['phone_other'])
                $customerRecords['phone4']         = $row['phone_other'];
            if ($row['id'])
                $customerRecords['lead_reference'] = $row['id'];
            $data['customerRecords'][]         = $customerRecords;
            $currentCamp                       = $row['dristi_campagain_id'];
            $currentApi                        = $row['dristi_api_id'];
            $pushed                            = false;
        }

        if (!$pushed)
        {

            $request                 = $data;
            $data['customerRecords'] = [];
            $pushed                  = true;
            
            $responses               = $api->uploadContacts($request, $currentCamp, $currentApi);
            if (isset($responses->beanResponse) && count($responses->beanResponse) > 0)
            {
                foreach ($responses->beanResponse as $key => $res)
                {
                    if (isset($res->inserted) && ($res->inserted == 1 or $res->inserted == 'true'))
                    {
                        try
                        {
                            $update = "UPDATE leads
                                        SET dristi_customer_id='" . $res->customerId . "',
                                            neoxstatus =1
                                       WHERE id = '" . $allInserted[$key]['id'] . "'";
                            $db->query($update);
                            $sql    = "INSERT INTO dristi_upload_logs
                                                        SET   
                                                        lead_id='" . $allInserted[$key]['id'] . "',
                                                        dated='" . date('Y-m-d H:i:s') . "',
                                                        customer_id='" . $res->customerId . "',
                                                        resultTypeString='" . $res->resultTypeString . "',text='" . json_encode($res) . "'";
                            $db->query($sql);
                            
                            //createLog('{createLog 4.}', 'pushLead_xx_'.date('Y-m-d').'.txt', $sql, json_encode($res));
                            
                        } catch (Exception $e)
                        {
                            //crete log	
                        }
                    }
                    else
                    {
                        try
                        {
                            $sql = "INSERT INTO dristi_upload_logs 
                                                SET
                                                lead_id='" . $allInserted[$key]['id'] . "',
                                                dated='" . date('Y-m-d H:i:s') . "',
                                                customer_id='" . $res->customerId . "',
                                                resultTypeString='" . $res->resultTypeString . "',text='" . json_encode($res) . "'";
                            $db->query($sql);
                            
                             //createLog('{createLog 5.}', 'pushLead_xx_'.date('Y-m-d').'.txt', $sql, json_encode($res));
                             
                        } catch (Exception $e)
                        {

                        }
                    }
                }
            }
            else
            {
                try
                {
                    $sql = "INSERT INTO dristi_upload_logs
                                        SET 
                                        lead_id='" . $allInserted[0]['id'] . "',
                                        dated='" . date('Y-m-d H:i:s') . "',
                                        customer_id='error',
                                        resultTypeString='error',text='" . json_encode($responses) . "'";
                    $db->query($sql);
                    
                     //createLog('{createLog 6.}', 'pushLead_xx_'.date('Y-m-d').'.txt', $sql, json_encode($res));
                     
                } catch (Exception $e)
                {

                }
            }
        }
    }


    
    $db->query("update cron_job set lead_id='0' where session_id='cron_job'");
    echo json_encode(array('status'=>'success','current_queue'=>$db->getRowCount($result))); 
    exit();
