<?php 
 //WARNING: The contents of this file are auto-generated


// created: 2016-11-07 22:45:22
$dictionary["te_disposition"]["fields"]["te_disposition_leads"] = array (
  'name' => 'te_disposition_leads',
  'type' => 'link',
  'relationship' => 'te_disposition_leads',
  'source' => 'non-db',
  'module' => 'Leads',
  'bean_name' => 'Lead',
  'vname' => 'LBL_TE_DISPOSITION_LEADS_FROM_LEADS_TITLE',
  'id_name' => 'te_disposition_leadsleads_ida',
);
$dictionary["te_disposition"]["fields"]["te_disposition_leads_name"] = array (
  'name' => 'te_disposition_leads_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_TE_DISPOSITION_LEADS_FROM_LEADS_TITLE',
  'save' => true,
  'id_name' => 'te_disposition_leadsleads_ida',
  'link' => 'te_disposition_leads',
  'table' => 'leads',
  'module' => 'Leads',
  'rname' => 'name',
  'db_concat_fields' => 
  array (
    0 => 'first_name',
    1 => 'last_name',
  ),
);
$dictionary["te_disposition"]["fields"]["te_disposition_leadsleads_ida"] = array (
  'name' => 'te_disposition_leadsleads_ida',
  'type' => 'link',
  'relationship' => 'te_disposition_leads',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_TE_DISPOSITION_LEADS_FROM_TE_DISPOSITION_TITLE',
);


// created: 2016-09-19 13:25:40
$dictionary["te_disposition"]["fields"]["lead_mobile"] = array (
  'name' => 'lead_mobile',
  'type' => 'varchar',
  'source' => 'non-db',
  'module' => 'te_disposition',
  'bean_name' => 'te_disposition',
  'vname' => 'LBL_LEAD_MOBILE',
  
);

$dictionary["te_disposition"]["fields"]["lead_email"] = array (
  'name' => 'lead_email',
  'type' => 'varchar',
  'source' => 'non-db',
  'module' => 'te_disposition',
  'bean_name' => 'te_disposition',
  'vname' => 'LBL_LEAD_EMAIL',
  
);

$dictionary["te_disposition"]["fields"]["show_button"] = array (
  'name' => 'show_button',
  'type' => 'varchar',
  'source' => 'non-db',
  'module' => 'te_disposition',
  'bean_name' => 'te_disposition',
  'vname' => 'LBL_UPDATE_DISPOSITION',
  
);

$dictionary["te_disposition"]["fields"]["batch_name"] = array (
  'name' => 'batch_name',
  'type' => 'varchar',
  'source' => 'non-db',
  'module' => 'te_disposition',
  'bean_name' => 'te_disposition',
  'vname' => 'LBL_BATCH',
  
);

$dictionary["te_disposition"]["fields"]["program_name"] = array (
  'name' => 'program_name',
  'type' => 'varchar',
  'source' => 'non-db',
  'module' => 'te_disposition',
  'bean_name' => 'te_disposition',
  'vname' => 'LBL_PROGRAM',
  
);


 // created: 2016-09-15 13:52:52
$dictionary['te_disposition']['fields']['date_of_callback']['name']='date_of_callback';
$dictionary['te_disposition']['fields']['date_of_callback']['vname']='LBL_DATEOFCALLBACK';
$dictionary['te_disposition']['fields']['date_of_callback']['type']='datetimecombo';
$dictionary['te_disposition']['fields']['date_of_callback']['dbType']='datetime';
$dictionary['te_disposition']['fields']['date_of_callback']['enable_range_search']=true;
$dictionary['te_disposition']['fields']['date_of_callback']['options']='date_range_search_dom';



$dictionary['te_disposition']['fields']['date_of_followup']['name']='date_of_followup';
$dictionary['te_disposition']['fields']['date_of_followup']['vname']='LBL_DATEOFFOLLOWUP';
$dictionary['te_disposition']['fields']['date_of_followup']['type']='datetimecombo';
$dictionary['te_disposition']['fields']['date_of_followup']['dbType']='datetime';
$dictionary['te_disposition']['fields']['date_of_followup']['enable_range_search']=true;
$dictionary['te_disposition']['fields']['date_of_followup']['options']='date_range_search_dom';


$dictionary['te_disposition']['fields']['date_of_prospect']['name']='date_of_prospect';
$dictionary['te_disposition']['fields']['date_of_prospect']['vname']='LBL_DATEOFPROSPECT';
$dictionary['te_disposition']['fields']['date_of_prospect']['type']='datetimecombo';
$dictionary['te_disposition']['fields']['date_of_prospect']['dbType']='datetime';
$dictionary['te_disposition']['fields']['date_of_prospect']['enable_range_search']=true;
$dictionary['te_disposition']['fields']['date_of_prospect']['options']='date_range_search_dom';


$dictionary['te_disposition']['fields']['unique_call_id']['name']='unique_call_id';
$dictionary['te_disposition']['fields']['unique_call_id']['vname']='LBL_UNIQUECALLID';
$dictionary['te_disposition']['fields']['unique_call_id']['type']='varchar';
$dictionary['te_disposition']['fields']['unique_call_id']['dbType']='varchar';
$dictionary['te_disposition']['fields']['unique_call_id']['len']='100';
$dictionary['te_disposition']['fields']['unique_call_id']['audited']='false';



$dictionary['te_disposition']['fields']['status']['required']=true;
$dictionary['te_disposition']['fields']['status']['options']='lead_status_custom_dis_dom';
$dictionary['te_disposition']['fields']['status_detail']['options']='lead_status_details_custom_dis_dom';
 
 
 

?>