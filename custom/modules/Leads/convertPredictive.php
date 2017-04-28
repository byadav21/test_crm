<?php

require_once('custom/modules/te_Api/te_Api.php');
$api = new te_Api_override();
global $db;


$sql = " SELECT  l.id,
                l.first_name,
                l.last_name,
                l.phone_mobile,
                l.phone_home,
                l.phone_work,
                l.phone_other,
                e.email_address,
                CONCAT (dristi_campagain_id,dristi_api_id) AS drtord,
                dristi_campagain_id,
                dristi_api_id
            FROM leads l
            LEFT JOIN email_addr_bean_rel el ON l.id = el.bean_id
            AND el.bean_module='Leads'
            AND el.deleted=0
            LEFT JOIN email_addresses e ON el.email_address_id = e.id
            AND e.deleted=0
            WHERE l.deleted =0
            AND l.duplicate_check=1
            AND l.status IN ('Alive','Warm') 
            AND  l.date_modified BETWEEN '" . date('Y-m-d', strtotime("-15 days")) . "' AND  '" . date('Y-m-d') . "'";

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
        echo 'Invalid Session';
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
            $pushed                  = true;
            $responses               = $api->uploadContacts($request, $currentCamp, $currentApi);
            if (isset($responses->beanResponse) && count($responses->beanResponse) > 0)
            {
                foreach ($responses->beanResponse as $key => $res)
                {
                    if ($res->inserted == 1 && $res->resultTypeString == 'ADDED')
                    {
                        $update = "UPDATE leads set assigned_user_id = NULL, dristi_customer_id='" . $res->customerId . "', neoxstatus =1 WHERE id = '" . $allInserted[$key]['id'] . "'";
                        $db->query($update);
                    }
                }
            }
            $allInserted = [];
        }
        if ($last == '')
            $last = $row['drtord'];

        $allInserted[]                    = $row;
        if ($row['first_name'] || $row['last_name'])
            $customerRecords['name']          = $row['first_name'] . " " . $row['last_name'];
        if ($row['first_name'])
            $customerRecords['first_name']    = $row['first_name'];
        if ($row['last_name'])
            $customerRecords['last_name']     = $row['last_name'];
        if ($row['email_address'])
            $customerRecords['email']         = $row['email_address'];
        if ($row['phone_mobile'])
            $customerRecords['phone1']        = $row['phone_mobile'];
        if ($row['phone_home'])
            $customerRecords['phone2']        = $row['phone_home'];
        if ($row['phone_work'])
            $customerRecords['phone3']        = $row['phone_work'];
        if ($row['phone_other'])
            $customerRecords['phone4']        = $row['phone_other'];
        if ($row['id'])
            $customerRecords['lead_refrence'] = $row['id'];
        $data['customerRecords'][]        = $customerRecords;
        $currentCamp                      = $row['dristi_campagain_id'];
        $currentApi                       = $row['dristi_api_id'];
        $pushed                           = false;
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
                if (isset($res->inserted) && $res->inserted == 1)
                {
                    $update = "UPDATE leads set dristi_customer_id='" . $res->customerId . "', neoxstatus =1 WHERE id = '" . $allInserted[$key]['id'] . "'";
                    $db->query($update);
                }
            }
        }
    }
}
$db->query("update cron_job set lead_id='0' where session_id='cron_job'");
exit();


/*
$server_ip = $GLOBALS['sugar_config']['neox']['server_ip'];
$neoxKey   		= $GLOBALS['sugar_config']['neox']['secret_key'];


//~ $URL = "http://$server_ip:9090/admin/ec_pass_list_data.php?secret_key=".$neoxKey;
 
$URL  = "http://$server_ip:9090/admin/ec_pass_list_data.php?secret_key=".$neoxKey."&duplicate_check_list=AVOID_DUPLICATE";
*/ 
/*$sql = "SELECT l.*,lc.*,e.email_address,te_ba_batch.name as batch_name,te_pr_programs.name as program_name FROM leads l LEFT JOIN leads_cstm lc on l.id=lc.id_c LEFT JOIN email_addr_bean_rel el ON l.id = el.bean_id LEFT JOIN email_addresses e ON el.email_address_id = e.id LEFT JOIN te_ba_batch ON lc.te_ba_batch_id_c=te_ba_batch.id LEFT JOIN te_pr_programs_te_ba_batch_1_c ON te_ba_batch.id=te_pr_programs_te_ba_batch_1_c.te_pr_programs_te_ba_batch_1te_ba_batch_idb LEFT JOIN te_pr_programs ON te_pr_programs_te_ba_batch_1_c.te_pr_programs_te_ba_batch_1te_pr_programs_ida=te_pr_programs.id WHERE l.deleted =0 AND l.duplicate_check=1 AND el.deleted=0 AND e.deleted=0 AND l.status_description= 'New Lead' AND el.bean_module='Leads' AND l.neoxstatus='0' AND (l.assigned_user_id= 'NULL' OR l.assigned_user_id ='' OR l.assigned_user_id IS NULL) LIMIT 50";

$result = $db->query($sql);
$filename="pushLeadNeox";
$csv_filename = $filename."_".date("Y-m-d_H-i",time()).".csv";

if($db->getRowCount($result)>0){
	$push_data = array();
	$lead_ids = array();
	$fileContent="List ID,Phone_Number,Phone_Code,Country_Code,Alternate_Number_1,Alternate_Number_2,First_Name,Last_Name,Address,Area,City,Region,Email_Address,Reference_Id,Comment,Contact_Person,Last_Date,Batch,Programe,Education,Experience,Entry_Date\n";
	$fd = fopen ("upload/push_lead_neox/".$csv_filename, "w");
	while($row = $db->fetchByAssoc($result)){

		$data = array();
		$data['list_id'] 			= $GLOBALS['sugar_config']['neox']['list_id_predictive'];
		$data['Phone_Number'] 		= $row['phone_mobile'];
		$data['batch_name'] 			= $row['batch_name'];
		$data['Phone_Code'] 		= '91';
		$data['programe_name'] 			= $row['program_name'];
		$data['Country_Code'] 		= 'IND';
		$data['education'] 			= $row['education_c'];
		$data['Alternate_Number_1'] = $row['phone_other'];
		$data['work_experience'] 			= $row['work_experience_c'];
		$data['Alternate_Number_2'] = "";
		$data['First_Name'] 		= $row['first_name'];
		$data['Last_Name'] 			= "";
		if(isset($row['last_name']) && $row['last_name']!=NULL){
			$data['Last_Name'] 			= $row['last_name'];
		}
		
		$data['Address'] 			= $row['primary_address_state'];
		$data['Area'] 				= $row['functional_area_c'];
		$data['City'] 				= $row['primary_address_city'];
		$data['Region'] 			= "";
		
		$data['Email_Address'] 			= "";
		if(isset($row['last_name']) && $row['last_name']!=NULL){
			$data['Email_Address'] 		= $row['email_address'];
		}
		$data['Reference_Id'] 		= $row['id'];
		$data['Comment'] 			= $row['comment'];
		$data['Contact_Person'] 	= $row['first_name'];
		$data['Entry_Date'] 		= date('Y-m-d',strtotime($row['date_entered']));
		$data['Last_Date'] 			= "";
		
		$fileContent.= "".$data['list_id'].",".$data['Phone_Number'].",".$data['Phone_Code'].",".$data['Country_Code'].", ".$data['Alternate_Number_1'].",".$data['Alternate_Number_2'].",".$data['First_Name'].",".$data['Last_Name'].",".$data['Address'].",".$data['Area'].",".$data['City'].",".$data['Region'].",".$data['Email_Address'].",".$data['Reference_Id'].",".$data['Comment'].",".$data['Contact_Person'].",".$data['Last_Date'].",".$data['batch_name'].",".$data['programe_name'].",".$data['education_c'].",".$data['work_experience_c'].",".$data['Entry_Date']."\n";
		$push_data[]=array($URL,"data=".json_encode($data));
		$lead_ids[]= $row['id'];
	}
	$fileContent=str_replace("\n\n","\n",$fileContent);

    fputs($fd, $fileContent);
    fclose($fd);
	$r = multiRequest($push_data);

	
	foreach($r as $k => $v){
		$d = explode(":",$v);
		if(trim($d[0])=='200'){
			$update = "UPDATE leads set neoxstatus =1 WHERE id = '".$lead_ids[$k]."'";

			$db->query($update);

		}
	}
	return true;
}
else{
	echo "No Leads to Push";
	return true;
}


function multiRequest($data, $options = array()) {
	 
	$result=array();
 foreach ($data as $id => $d) {

$URL = $d[0];
$data = $d[1];

$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,"$URL");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$buffer = curl_exec($ch);
$result[$id]=$buffer;

//echo "Result = $buffer\n";
sleep(1);
}
//print_r($result);exit();
return $result;
}
 
 */
