<?php 
 //WARNING: The contents of this file are auto-generated


 // created: 2016-10-10 01:04:13
$dictionary['te_utm']['fields']['name']['inline_edit']=true;
$dictionary['te_utm']['fields']['name']['duplicate_merge']='disabled';
$dictionary['te_utm']['fields']['name']['duplicate_merge_dom_value']='0';
$dictionary['te_utm']['fields']['name']['merge_filter']='disabled';
$dictionary['te_utm']['fields']['name']['unified_search']=false;

 

 // created: 2016-10-10 01:09:34
$dictionary['te_utm']['fields']['utm_medium_c']['inline_edit']='1';
$dictionary['te_utm']['fields']['utm_medium_c']['labelValue']='UTM Medium';

 


$dictionary['te_utm']['fields']['utm_url'] =
	array (
		'name' => 'utm_url',
		'vname' => 'LBL_UTM_URL',
		'type' => 'varchar',
		'source'=>'non-db',
	);




 // created: 2016-10-10 01:12:30
$dictionary['te_utm']['fields']['utm_campaign_c']['inline_edit']='1';
$dictionary['te_utm']['fields']['utm_campaign_c']['labelValue']='UTM Campaign	';

 

 // created: 2016-10-10 01:14:12
$dictionary['te_utm']['fields']['utm_term_c']['inline_edit']='1';
$dictionary['te_utm']['fields']['utm_term_c']['labelValue']='UTM Term';

 

// created: 2016-11-24 12:25:58
$dictionary["te_utm"]["fields"]["te_utm_te_actual_campaign_1"] = array (
  'name' => 'te_utm_te_actual_campaign_1',
  'type' => 'link',
  'relationship' => 'te_utm_te_actual_campaign_1',
  'source' => 'non-db',
  'module' => 'te_actual_campaign',
  'bean_name' => 'te_actual_campaign',
  'side' => 'right',
  'vname' => 'LBL_TE_UTM_TE_ACTUAL_CAMPAIGN_1_FROM_TE_ACTUAL_CAMPAIGN_TITLE',
);


 // created: 2016-10-10 01:06:21
$dictionary['te_utm']['fields']['utm_source_c']['inline_edit']='1';
$dictionary['te_utm']['fields']['utm_source_c']['labelValue']='UTM Source';

 

// created: 2016-11-24 12:25:31
$dictionary["te_utm"]["fields"]["te_utm_te_budgeted_campaign_1"] = array (
  'name' => 'te_utm_te_budgeted_campaign_1',
  'type' => 'link',
  'relationship' => 'te_utm_te_budgeted_campaign_1',
  'source' => 'non-db',
  'module' => 'te_budgeted_campaign',
  'bean_name' => 'te_budgeted_campaign',
  'side' => 'right',
  'vname' => 'LBL_TE_UTM_TE_BUDGETED_CAMPAIGN_1_FROM_TE_BUDGETED_CAMPAIGN_TITLE',
);


// created: 2016-09-09 05:07:20
$dictionary["te_utm"]["fields"]["te_vendor_te_utm_1"] = array (
  'name' => 'te_vendor_te_utm_1',
   'required' => true,
  'type' => 'link',
  'relationship' => 'te_vendor_te_utm_1',
  'source' => 'non-db',
  'module' => 'te_vendor',
  'bean_name' => 'te_vendor',
  'vname' => 'LBL_TE_VENDOR_TE_UTM_1_FROM_TE_VENDOR_TITLE',
  'id_name' => 'te_vendor_te_utm_1te_vendor_ida',
);
$dictionary["te_utm"]["fields"]["te_vendor_te_utm_1_name"] = array (
  'name' => 'te_vendor_te_utm_1_name',
   'required' => true,
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_TE_VENDOR_TE_UTM_1_FROM_TE_VENDOR_TITLE',
  'save' => true,
  'id_name' => 'te_vendor_te_utm_1te_vendor_ida',
  'link' => 'te_vendor_te_utm_1',
  'table' => 'te_vendor',
  'module' => 'te_vendor',
  'rname' => 'name',
);
$dictionary["te_utm"]["fields"]["te_vendor_te_utm_1te_vendor_ida"] = array (
  'name' => 'te_vendor_te_utm_1te_vendor_ida',
  'type' => 'link',
  'relationship' => 'te_vendor_te_utm_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_TE_VENDOR_TE_UTM_1_FROM_TE_UTM_TITLE',
);

?>