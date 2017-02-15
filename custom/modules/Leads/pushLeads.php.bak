<?php
echo "<pre>";
$server_ip = $GLOBALS['sugar_config']['neox']['server_ip'];
$neoxKey   		= $GLOBALS['sugar_config']['neox']['secret_key'];
global $db;

//~ $URL = "http://$server_ip:9090/admin/ec_pass_list_data.php?secret_key=".$neoxKey;
 
$URL  = "http://$server_ip:9090/admin/ec_pass_list_data.php?secret_key=".$neoxKey."&duplicate_check_list=AVOID_DUPLICATE&data=";
$sql = "SELECT l.*,lc.*,e.email_address FROM leads l LEFT JOIN leads_cstm lc on l.id=lc.id_c LEFT JOIN email_addr_bean_rel el ON l.id = el.bean_id LEFT JOIN email_addresses e ON el.email_address_id = e.id WHERE l.deleted =0 AND el.deleted=0 AND e.deleted=0 AND l.status_description= 'New Lead' AND el.bean_module='Leads' AND l.neoxstatus='0' AND (assigned_user_id= 'NULL' OR assigned_user_id ='' OR assigned_user_id IS NULL) LIMIT 100"; 
$result = $db->query($sql);

if($db->getRowCount($result)>0){
	$push_data = array();
	$lead_ids = array();
	while($row = $db->fetchByAssoc($result)){
		//~ print_r($row);
		$data = array();
		$data['list_id'] 			= $GLOBALS['sugar_config']['neox']['list_id_predictive'];
		$data['Phone_Number'] 		= $row['phone_mobile'];
		$data['Phone_Code'] 		= '91';
		$data['Country_Code'] 		= 'IND';
		$data['Alternate_Number_1'] = $row['phone_other'];
		$data['Alternate_Number_2'] = '';
		$data['First_Name'] 		= $row['first_name'];
		$data['Last_Name'] 			= $row['last_name'];
		$data['Address'] 			= $row['primary_address_state'];
		$data['Area'] 				= $row['functional_area_c'];
		$data['City'] 				= $row['primary_address_city'];
		$data['Region'] 			= '';
		$data['Email_Address'] 		= '';
		$data['Reference_Id'] 		= $row['id'];
		$data['Comment'] 			= $row['comment'];
		$data['Contact_Person'] 	= $row['first_name'];
		$data['Last_Date'] 			= '';
		$data['Entry_Date'] 		= date('Y-m-d',strtotime($row['date_entered']));
		$push_data[]=$URL.json_encode($data);
		$lead_ids[]= $row['id'];
	}
	$r = multiRequest($push_data);


	echo '<pre>';
	print_r($r);
	
	foreach($r as $k => $v){
		$d = explode(":",$v);
		if(trim($d[0])=='200'){
			$update = "UPDATE leads set neoxstatus =1 WHERE id = '".$lead_ids[$k]."'";
			//~ echo $update;
			$db->query($update);
		 //~ echo $d[0];	
		}
	}
	return true;
}
else{
	echo "No Leads to Push";
	return true;
}


function multiRequest($data, $options = array()) {
 
  // array of curl handles
  $curly = array();
  // data to be returned
  $result = array();
 
  // multi handle
  $mh = curl_multi_init();
 
  // loop through $data and create curl handles
  // then add them to the multi-handle
  foreach ($data as $id => $d) {
 
    $curly[$id] = curl_init();
 
    $url = (is_array($d) && !empty($d['url'])) ? $d['url'] : $d;
    curl_setopt($curly[$id], CURLOPT_URL,            $url);
    curl_setopt($curly[$id], CURLOPT_HEADER,         0);
    curl_setopt($curly[$id], CURLOPT_RETURNTRANSFER, 1);
 
    // post?
    if (is_array($d)) {
      if (!empty($d['post'])) {
        curl_setopt($curly[$id], CURLOPT_POST,       1);
        curl_setopt($curly[$id], CURLOPT_POSTFIELDS, $d['post']);
      }
    }
 
    // extra options?
    if (!empty($options)) {
      curl_setopt_array($curly[$id], $options);
    }
 
    curl_multi_add_handle($mh, $curly[$id]);
  }
 
  // execute the handles
  $running = null;
  do {
    curl_multi_exec($mh, $running);
  } while($running > 0);
 
 
  // get content and remove handles
  foreach($curly as $id => $c) {
    $result[$id] = curl_multi_getcontent($c);
    curl_multi_remove_handle($mh, $c);
  }
 
  // all done
  curl_multi_close($mh);
 
  return $result;
}
 
 

?>
