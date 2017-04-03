<?php 
 //WARNING: The contents of this file are auto-generated


$dictionary['Lead']['fields']['min_attendance_c']['validation'] = array(
    'type' => 'range',
    'min' => '0',
    'max' => '100',
);



 // created: 2016-10-18 02:06:29
$dictionary['Lead']['fields']['first_name']['required']=true;
$dictionary['Lead']['fields']['first_name']['inline_edit']=true;
$dictionary['Lead']['fields']['first_name']['comments']='First name of the contact';
$dictionary['Lead']['fields']['first_name']['merge_filter']='disabled';

 

$dictionary['Lead']['fields']['mailer_day'] =array (
	'required' => false,
    'name' => 'mailer_day',
    'vname' => 'LBL_MAILER_DAY',
    'type' => 'int',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => '11',
    'size' => '20',
    'enable_range_search' => false,
    'disable_num_format' => '',
    'min' => false,
    'max' => false,
);
 

 // created: 2016-09-13 03:07:50
$dictionary['Lead']['fields']['previous_courses_from_te_c']['inline_edit']='1';
$dictionary['Lead']['fields']['previous_courses_from_te_c']['labelValue']='Previous Courses From TE';

 

 // created: 2016-09-15 13:52:20
$dictionary['Lead']['fields']['status_description']['inline_edit']=true;
$dictionary['Lead']['fields']['status_description']['comments']='Description of the status of the lead';
$dictionary['Lead']['fields']['status_description']['type']='enum';
$dictionary['Lead']['fields']['status_description']['len']='100';
$dictionary['Lead']['fields']['status_description']['options']='lead_status_details_custom_dom';
$dictionary['Lead']['fields']['status_description']['audited']='true';
$dictionary['Lead']['fields']['status_description']['default']='New Lead';


$dictionary['Lead']['fields']['status']['options']='lead_status_custom_dom';
$dictionary['Lead']['fields']['status']['default']='Alive';

$dictionary['Lead']['fields']['lead_source']['options']='lead_source_custom_dom';

$dictionary['Lead']['fields']['gender']['name']='gender';
$dictionary['Lead']['fields']['gender']['comments']='Gender of the status of the lead';
$dictionary['Lead']['fields']['gender']['type']='enum';
$dictionary['Lead']['fields']['gender']['vname']='Gender';
$dictionary['Lead']['fields']['gender']['len']='100';
$dictionary['Lead']['fields']['gender']['options']='gender_dom';
$dictionary['Lead']['fields']['gender']['audited']='false';


 
 
 


// created: 2016-09-19 13:25:40
$dictionary["Lead"]["fields"]["program"] = array (
  'name' => 'program',
  'type' => 'varchar',
  'source' => 'non-db',
  'module' => 'Leads',
  'bean_name' => 'Lead',
  'vname' => 'LBL_PROGRAM',
  
);

$dictionary["Lead"]["fields"]["institute"] = array (
  'name' => 'institute',
  'type' => 'varchar',
  'source' => 'non-db',
  'module' => 'Leads',
  'bean_name' => 'Lead',
  'vname' => 'LBL_INSTITUTE',
  
);


 // created: 2016-08-29 08:18:17
$dictionary['Lead']['fields']['jjwg_maps_address_c']['inline_edit']=1;

 

// created: 2016-09-19 13:25:40
$dictionary["Lead"]["fields"]["leads_leads_1"] = array (
  'name' => 'leads_leads_1',
  'type' => 'link',
  'relationship' => 'leads_leads_1',
  'source' => 'non-db',
  'module' => 'Leads',
  'bean_name' => 'Lead',
  'vname' => 'LBL_LEADS_LEADS_1_FROM_LEADS_L_TITLE',
  'id_name' => 'leads_leads_1leads_ida',
);
$dictionary["Lead"]["fields"]["leads_leads_1_name"] = array (
  'name' => 'leads_leads_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_LEADS_LEADS_1_FROM_LEADS_L_TITLE',
  'save' => true,
  'id_name' => 'leads_leads_1leads_ida',
  'link' => 'leads_leads_1',
  'table' => 'leads',
  'module' => 'Leads',
  'rname' => 'name',
  'db_concat_fields' => 
  array (
    0 => 'first_name',
    1 => 'last_name',
  ),
);
$dictionary["Lead"]["fields"]["leads_leads_1leads_ida"] = array (
  'name' => 'leads_leads_1leads_ida',
  'type' => 'link',
  'relationship' => 'leads_leads_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_LEADS_LEADS_1_FROM_LEADS_R_TITLE',
);
$dictionary["Lead"]["fields"]["dristi_customer_id"] = array (
  'name' => 'dristi_customer_id',
  'type' => 'varchar',
  
);

$dictionary["Lead"]["fields"]["dristi_request"] = array (
  'name' => 'dristi_request',
  'type' => 'text',
  
);


 // created: 2016-09-15 13:52:52
$dictionary['Lead']['fields']['lead_source_description']['inline_edit']=true;
$dictionary['Lead']['fields']['lead_source_description']['comments']='Description of the lead source';
$dictionary['Lead']['fields']['lead_source_description']['merge_filter']='disabled';
$dictionary['Lead']['fields']['lead_source_description']['rows']='2';
$dictionary['Lead']['fields']['lead_source_description']['cols']='20';

 

$dictionary['Lead']['fields']['batch'] =array (
	'name' => 'batch',
	'label' => 'LBL_BATCH',
	'type' => 'enum',
	'module' => 'Leads',
	'help' => '',
	'comment' => '',
	'function' => 'getBatchList',
	'default_value' => '',
	'mass_update' => false, 
	'required' => true, 
	'reportable' => true, 
	'audited' => false,
	'importable' => 'true',
	'duplicate_merge' => false,
);


 // created: 2016-11-07 06:58:15
$dictionary['Lead']['fields']['note']['name']='note';
$dictionary['Lead']['fields']['note']['vname']='Note';
$dictionary['Lead']['fields']['note']['type']='text';
$dictionary['Lead']['fields']['note']['merge_filter']='disabled';
$dictionary['Lead']['fields']['note']['rows']='5';
$dictionary['Lead']['fields']['note']['cols']='29';
$dictionary['Lead']['fields']['note']['inline_edit']=true;

 


$dictionary['Lead']['fields']['utm'] =array (
		'name' => 'utm',
		'vname' => 'LBL_UTM',
		'type' => 'varchar',
		'required' => false,
		'massupdate' => 0,
		'comments' => '',
		'help' => '',
		'default'=>'NA',
		'importable' => 'true',
		'duplicate_merge' => 'disabled',
		'duplicate_merge_dom_value' => '0',
		'audited' => false,
		'reportable' => true,
		'len' => '50',
		'size' => '50',
	);




 // created: 2016-11-07 06:58:15
$dictionary['Lead']['fields']['is_new_dropout']['name']='is_new_dropout';
$dictionary['Lead']['fields']['is_new_dropout']['vname']='is_new_dropout';
$dictionary['Lead']['fields']['is_new_dropout']['type']='int';


 


 // created: 2016-09-13 02:59:34
$dictionary['Lead']['fields']['functional_area_c']['inline_edit']='1';
$dictionary['Lead']['fields']['functional_area_c']['labelValue']='Functional Area';

 

$dictionary['Lead']['fields']['neoxstatus'] = array (
      'name' => 'neoxstatus',
      'vname' => 'NEOXSTATUS',
      'type' => 'varchar',
      'comment' => 'Status of Lead to push into neox',
      'inline_edit' => false,
      'required' => false,
      'studio' => 'visible',
      'default'=>'0',
    );




 // created: 2016-10-29 14:14:16
$dictionary['Lead']['fields']['last_name']['required']=false;
$dictionary['Lead']['fields']['last_name']['inline_edit']=true;
$dictionary['Lead']['fields']['last_name']['importable']=false;
$dictionary['Lead']['fields']['last_name']['comments']='Last name of the contact';
$dictionary['Lead']['fields']['last_name']['merge_filter']='disabled';

$dictionary['Lead']['fields']['first_name']['importable']='required';

 


$dictionary['Lead']['fields']['date_of_payment']['massupdate']=false;
$dictionary['Lead']['fields']['do_not_call']['massupdate']=false;

$dictionary['Lead']['fields']['converted']['massupdate']=false;

$dictionary['Lead']['fields']['gender']['massupdate']=false;
$dictionary['Lead']['fields']['optout_primary']['massupdate']=false;

$dictionary['Lead']['fields']['payment_realized_check']['massupdate']=false;
$dictionary['Lead']['fields']['payment_type']['massupdate']=false;

//$dictionary['Lead']['fields']['program']['massupdate']=true;
$dictionary['Lead']['fields']['payment_source']['massupdate']=false;
$dictionary['Lead']['fields']['payment_realized']['massupdate']=false;


// new added // css 173line css hide date field

$dictionary['Lead']['fields']['date_of_callback']['massupdate']=false;
$dictionary['Lead']['fields']['date_of_prospect']['massupdate']=false;
$dictionary['Lead']['fields']['date_of_followup']['massupdate']=false;
$dictionary['Lead']['fields']['status']['massupdate']=false;
$dictionary['Lead']['fields']['converted_date']['massupdate']=false;
$dictionary['Lead']['fields']['assigned_flag']['massupdate']=false;

$dictionary['Lead']['fields']['status_description']['massupdate']=false;
$dictionary['Lead']['fields']['assigned_flag']['converted_datejscal_field']=false;

//New Added 31 Mrch
$dictionary['Lead']['fields']['batch']['massupdate']=false;

$dictionary['Lead']['fields']['status_description']['massupdate']=false;
$dictionary['Lead']['fields']['date_of_referral']['massupdate']=false;


 // created: 2016-11-07 04:56:35
$dictionary['Lead']['fields']['email1']['required']=true;
$dictionary['Lead']['fields']['email1']['inline_edit']=true;
$dictionary['Lead']['fields']['email1']['merge_filter']='disabled';

 

 // created: 2016-09-15 13:40:55
$dictionary['Lead']['fields']['te_ba_batch_id_c']['inline_edit']=1;

 

$dictionary['Lead']['fields']['utm_campaign'] =array (
	'name' => 'utm_campaign',
	'vname' => 'UTM Campaign',
	'type' => 'varchar',
	'len' => '50',
    'size' => '20',
    'studio' => 'visible',
	'required' => false, 
	'reportable' => true, 
	'audited' => false, 
	'importable' => true, 
	'duplicate_merge' => false, 
);
 


$dictionary['Lead']['fields']['parrent_leads'] =array (
	'name' => 'parrent_leads',
	'vname' => 'Parrent Lead',
	'type' => 'varchar',
	'len' => '50',
    'size' => '20',
    'studio' => 'visible',
	'required' => false, 
	'reportable' => true, 
	'audited' => false, 
	'importable' => true, 
	'duplicate_merge' => false,
	'inline_edit' => false, 
);
 


 // created: 2016-09-15 13:52:52
$dictionary['Lead']['fields']['date_of_payment']['name']='date_of_payment';
$dictionary['Lead']['fields']['date_of_payment']['vname']='LBL_DATEOFPAYMENT';
$dictionary['Lead']['fields']['date_of_payment']['type']='date';
$dictionary['Lead']['fields']['date_of_payment']['enable_range_search']=true;
$dictionary['Lead']['fields']['date_of_payment']['options']='date_range_search_dom';

$dictionary['Lead']['fields']['amount']['name']='amount';
$dictionary['Lead']['fields']['amount']['vname']='LBL_AMOUNT';
$dictionary['Lead']['fields']['amount']['type']='decimal';
$dictionary['Lead']['fields']['amount']['enable_range_search']=false;
$dictionary['Lead']['fields']['amount']['size']='20';
$dictionary['Lead']['fields']['amount']['len']='18';
$dictionary['Lead']['fields']['amount']['precision']='2';


$dictionary['Lead']['fields']['reference_number']['name']='reference_number';
$dictionary['Lead']['fields']['reference_number']['vname']='LBL_REFERENCENUMBER';
$dictionary['Lead']['fields']['reference_number']['type']='varchar';
$dictionary['Lead']['fields']['reference_number']['len']='100';
$dictionary['Lead']['fields']['reference_number']['audited']='false';



$dictionary['Lead']['fields']['transaction_id']['name']='transaction_id';
$dictionary['Lead']['fields']['transaction_id']['vname']='LBL_TRANSACTIONID';
$dictionary['Lead']['fields']['transaction_id']['type']='varchar';
$dictionary['Lead']['fields']['transaction_id']['len']='100';
$dictionary['Lead']['fields']['transaction_id']['audited']='false';



$dictionary['Lead']['fields']['payment_type']['name']='payment_type';
$dictionary['Lead']['fields']['payment_type']['type']='enum';
$dictionary['Lead']['fields']['payment_type']['vname']='LBL_PAYMENTTYPE';
$dictionary['Lead']['fields']['payment_type']['len']='100';
$dictionary['Lead']['fields']['payment_type']['options']='payment_type_dom';
$dictionary['Lead']['fields']['payment_type']['audited']='false';


$dictionary['Lead']['fields']['payment_source']['name']='payment_source';
$dictionary['Lead']['fields']['payment_source']['type']='enum';
$dictionary['Lead']['fields']['payment_source']['vname']='LBL_PAYMENTTYPESOURCE';
$dictionary['Lead']['fields']['payment_source']['len']='100';
$dictionary['Lead']['fields']['payment_source']['options']='payment_type_source_dom';
$dictionary['Lead']['fields']['payment_source']['audited']='false';



$dictionary['Lead']['fields']['payment_realized']['name']='payment_realized';
$dictionary['Lead']['fields']['payment_realized']['type']='bool';
$dictionary['Lead']['fields']['payment_realized']['vname']='LBL_PAYMENTREREALIZED';
$dictionary['Lead']['fields']['payment_realized']['len']='2';
$dictionary['Lead']['fields']['payment_realized']['audited']='false';


$dictionary['Lead']['fields']['payment_realized_check']['name']='payment_realized_check';
$dictionary['Lead']['fields']['payment_realized_check']['type']='bool';
$dictionary['Lead']['fields']['payment_realized_check']['vname']='LBL_PAYMENTREREALIZED_CHECK';
$dictionary['Lead']['fields']['payment_realized_check']['len']='2';
$dictionary['Lead']['fields']['payment_realized_check']['audited']='false';


$dictionary['Lead']['fields']['phone_mobile']['inline_edit']='false';
$dictionary['Lead']['fields']['phone_other']['inline_edit']='false';


$dictionary['Lead']['fields']['date_of_callback']['name']='date_of_callback';
$dictionary['Lead']['fields']['date_of_callback']['vname']='LBL_DATEOFCALLBACK';
$dictionary['Lead']['fields']['date_of_callback']['type']='datetimecombo';
$dictionary['Lead']['fields']['date_of_callback']['dbType']='datetime';
$dictionary['Lead']['fields']['date_of_callback']['enable_range_search']=true;
$dictionary['Lead']['fields']['date_of_callback']['options']='date_range_search_dom';


$dictionary['Lead']['fields']['date_of_followup']['name']='date_of_followup';
$dictionary['Lead']['fields']['date_of_followup']['vname']='LBL_DATEOFFOLLOWUP';
$dictionary['Lead']['fields']['date_of_followup']['type']='datetimecombo';
$dictionary['Lead']['fields']['date_of_followup']['dbType']='datetime';
$dictionary['Lead']['fields']['date_of_followup']['enable_range_search']=true;
$dictionary['Lead']['fields']['date_of_followup']['options']='date_range_search_dom';


$dictionary['Lead']['fields']['date_of_prospect']['name']='date_of_prospect';
$dictionary['Lead']['fields']['date_of_prospect']['vname']='LBL_DATEOFPROSPECT';
$dictionary['Lead']['fields']['date_of_prospect']['type']='datetimecombo';
$dictionary['Lead']['fields']['date_of_prospect']['dbType']='datetime';
$dictionary['Lead']['fields']['date_of_prospect']['enable_range_search']=true;
$dictionary['Lead']['fields']['date_of_prospect']['options']='date_range_search_dom';



$dictionary['Lead']['fields']['assigned_flag']['name']='assigned_flag';
$dictionary['Lead']['fields']['assigned_flag']['type']='bool';
$dictionary['Lead']['fields']['assigned_flag']['vname']='LBL_ASSIGNED_FLAG';
$dictionary['Lead']['fields']['assigned_flag']['len']='2';
$dictionary['Lead']['fields']['assigned_flag']['audited']='false';


 
 
 


// created: 2016-11-07 22:45:22
$dictionary["Lead"]["fields"]["te_disposition_leads"] = array (
  'name' => 'te_disposition_leads',
  'type' => 'link',
  'relationship' => 'te_disposition_leads',
  'source' => 'non-db',
  'module' => 'te_disposition',
  'bean_name' => false,
  'side' => 'right',
  'vname' => 'LBL_TE_DISPOSITION_LEADS_FROM_TE_DISPOSITION_TITLE',
);


$dictionary['Lead']['fields']['date_of_referral']['name']='date_of_referral';
$dictionary['Lead']['fields']['date_of_referral']['vname']='LBL_DATEOFREFERRAL';
$dictionary['Lead']['fields']['date_of_referral']['type']='date';
$dictionary['Lead']['fields']['date_of_referral']['enable_range_search']=true;
$dictionary['Lead']['fields']['date_of_referral']['options']='date_range_search_dom';

$dictionary['Lead']['fields']['is_new_dropout'] = array(
	'required' => false,
	'name' => 'is_new_dropout',
	'vname' => 'is_new_dropout',
	'type' => 'varchar',
	'default'=>'0',
	'audited' => false,
	'massupdate' => false,
	'source' => 'non-db',
	'studio' => 'visible',
);

$dictionary['Lead']['fields']['is_new_referalls'] = array(
	'required' => false,
	'name' => 'is_new_referalls',
	'vname' => 'is_new_referalls',
	'type' => 'varchar',
	'default'=>'0',
	'audited' => false,
	'massupdate' => false,
	'source' => 'non-db',
	'studio' => 'visible',
);


$dictionary['Lead']['fields']['parent_name'] = 
    array (
      'inline_edit' => '0',
      'labelValue' => 'Referral',
      'required' => false,
      'source' => 'non-db',
      'name' => 'parent_name',
      'vname' => 'LBL_FLEX_RELATE',
      'type' => 'parent',
      'massupdate' => '0',
      'default' => NULL,
      'no_default' => false,
      'comments' => '',
      'help' => '',
      'importable' => 'true',
      'duplicate_merge' => 'disabled',
      'duplicate_merge_dom_value' => '0',
      'audited' => false,
      'reportable' => true,
      'unified_search' => false,
      'merge_filter' => 'disabled',
      'len' => 25,
      'size' => '20',
      'options' => 'parent_type_display_custom',
      'studio' => 'visible',
      'type_name' => 'parent_type',
      'id_name' => 'parent_id',
      'parent_type' => 'record_type_display',
      //~ 'id' => 'Leadsparent_name',
      //~ 'custom_module' => 'Leads',
    );
$dictionary['Lead']['fields']['parent_type'] =
    array (
      'inline_edit' => 0,
      'required' => false,
      //~ 'source' => 'custom_fields',
      'name' => 'parent_type',
      'vname' => 'LBL_PARENT_TYPE',
      'type' => 'parent_type',
      'massupdate' => '0',
      'default' => NULL,
      'no_default' => false,
      'comments' => '',
      'help' => '',
      'importable' => 'true',
      'duplicate_merge' => 'disabled',
      'duplicate_merge_dom_value' => '0',
      'audited' => false,
      'reportable' => true,
      'unified_search' => false,
      'merge_filter' => 'disabled',
      'len' => '255',
      'size' => '20',
      'dbType' => 'varchar',
      'studio' => 'hidden',
      //~ 'id' => 'Leadsparent_type',
      //~ 'custom_module' => 'Leads',
    );
    
    $dictionary['Lead']['fields']['parent_id'] =
    array (
      'inline_edit' => 1,
      'required' => false,
      //~ 'source' => 'custom_fields',
      'name' => 'parent_id',
      'vname' => 'LBL_PARENT_ID',
      'type' => 'id',
      'massupdate' => '0',
      'default' => NULL,
      'no_default' => false,
      'comments' => '',
      'help' => '',
      'importable' => 'true',
      'duplicate_merge' => 'disabled',
      'duplicate_merge_dom_value' => '0',
      'audited' => false,
      'reportable' => true,
      'unified_search' => false,
      'merge_filter' => 'disabled',
      'len' => '36',
      'size' => '20',
      //~ 'id' => 'Leadsparent_id',
      //~ 'custom_module' => 'Leads',
    );
 


 // created: 2016-09-15 13:35:37
$dictionary['Lead']['fields']['age_c']['inline_edit']='1';
$dictionary['Lead']['fields']['age_c']['labelValue']='Age';

 

$dictionary['Lead']['fields']['vendor'] =array (
	'name' => 'vendor',
	'label' => 'LBL_VENDOR',
	'type' => 'varchar',
	'module' => 'Leads',
	'help' => '',
	'comment' => '',
	'default_value' => '',
	'len' => '50',
    'size' => '20',
	'required' => false, 
	'reportable' => true, 
	'audited' => false, 
	'importable' => 'true', 
	'duplicate_merge' => false, 
);
 

 // created: 2016-09-15 13:34:46
$dictionary['Lead']['fields']['city_c']['inline_edit']='1';
$dictionary['Lead']['fields']['city_c']['labelValue']='City';

 

// created: 2016-11-03 00:13:18
$dictionary["Lead"]["fields"]["leads_te_payment_details_1"] = array (
  'name' => 'leads_te_payment_details_1',
  'type' => 'link',
  'relationship' => 'leads_te_payment_details_1',
  'source' => 'non-db',
  'module' => 'te_payment_details',
  'bean_name' => 'te_payment_details',
  'side' => 'right',
  'vname' => 'LBL_LEADS_TE_PAYMENT_DETAILS_1_FROM_TE_PAYMENT_DETAILS_TITLE',
);


 // created: 2016-09-13 03:00:35
$dictionary['Lead']['fields']['education_c']['inline_edit']='1';
$dictionary['Lead']['fields']['education_c']['labelValue']='Education';

 

 // created: 2016-08-29 08:18:17
$dictionary['Lead']['fields']['jjwg_maps_geocode_status_c']['inline_edit']=1;

 

$dictionary['Lead']['fields']['fee_usd'] =array (
	'required' => true,
    'name' => 'fee_usd',
    'vname' => 'LBL_FEE_USD',
    'type' => 'int',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => false,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => '11',
    'size' => '20',
    'enable_range_search' => false,
    'disable_num_format' => '',
    'min' => false,
    'max' => false,
);
 

 // created: 2016-08-29 08:18:17
$dictionary['Lead']['fields']['jjwg_maps_lng_c']['inline_edit']=1;

 

 // created: 2016-09-13 03:06:28
$dictionary['Lead']['fields']['work_experience_c']['inline_edit']='1';
$dictionary['Lead']['fields']['work_experience_c']['labelValue']='Work Experience';

 


$dictionary['Lead']['fields']['invoice_number'] =array (
		'name' => 'invoice_number',
		'vname' => 'LBL_INVOICE_NUMBER',
		'type' => 'int',
		'required' => false,
		'massupdate' => 0,
		'comments' => '',
		'help' => '',
		'default'=> 0,
		'importable' => 'false',
		'duplicate_merge' => 'disabled',
		'duplicate_merge_dom_value' => '0',
		'audited' => false,
		'reportable' => false,
		'len' => '50',
		'size' => '50',
	);




 // created: 2016-09-15 13:40:55
$dictionary['Lead']['fields']['batch_c']['inline_edit']='1';
$dictionary['Lead']['fields']['batch_c']['labelValue']='Batch';

 

$dictionary['Lead']['fields']['primary_address_country']['required'] = false;



 // created: 2016-09-15 13:40:04
$dictionary['Lead']['fields']['min_attendance_c']['inline_edit']='1';
$dictionary['Lead']['fields']['min_attendance_c']['labelValue']='Min. Attendance';

 

 // created: 2016-09-13 02:59:07
$dictionary['Lead']['fields']['company_c']['inline_edit']='1';
$dictionary['Lead']['fields']['company_c']['labelValue']='Company';

 

$dictionary['Lead']['fields']['converted_date'] =array (
	'name' => 'converted_date',
	'label' => 'LBL_CONVERTED_DATE',
	'type' => 'date',
	'module' => 'Leads',
	'default_value' => '',
	'help' => '',
	'comment' => '',
	'mass_update' => false, 
	'required' => false, 
	'reportable' => true, 
	'audited' => false, 
	'duplicate_merge' => false, 
	'importable' => 'true', 
);
 

$dictionary['Lead']['fields']['minimum_attendance'] =array (
	'required' => false,
    'name' => 'minimum_attendance',
    'vname' => 'LBL_MINIMUM_ATTENDANCE',
    'type' => 'int',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => false,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => '11',
    'size' => '20',
    'enable_range_search' => false,
    'disable_num_format' => '',
    'min' => false,
    'max' => false,
);
 

$dictionary['Lead']['fields']['comment'] = array (
      'name' => 'comment',
      'vname' => 'COMMENT',
      'type' => 'text',
      'comment' => 'Full text of the note',
      'rows' => 6,
      'cols' => '103',
      'inline_edit' => true,
      'comments' => 'Full text of the note',
      'merge_filter' => 'disabled',
      'required' => false,
      'studio' => 'visible',
    );




 // created: 2016-08-29 08:18:17
$dictionary['Lead']['fields']['jjwg_maps_lat_c']['inline_edit']=1;

 

$dictionary['Lead']['fields']['fee_inr'] =array (
	'required' => false,
    'name' => 'fee_inr',
    'vname' => 'LBL_FEE_INR',
    'type' => 'int',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => false,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => '11',
    'size' => '20',
    'enable_range_search' => false,
    'disable_num_format' => '',
    'min' => false,
    'max' => false,
);
 
?>