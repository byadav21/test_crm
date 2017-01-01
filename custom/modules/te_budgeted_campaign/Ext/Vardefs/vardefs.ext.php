<?php 
 //WARNING: The contents of this file are auto-generated


// created: 2016-11-24 12:25:31
$dictionary["te_budgeted_campaign"]["fields"]["te_utm_te_budgeted_campaign_1"] = array (
  'name' => 'te_utm_te_budgeted_campaign_1',
  'type' => 'link',
  'required' => true,
  'relationship' => 'te_utm_te_budgeted_campaign_1',
  'source' => 'non-db',
  'module' => 'te_utm',
  'bean_name' => 'te_utm',
  'vname' => 'LBL_TE_UTM_TE_BUDGETED_CAMPAIGN_1_FROM_TE_UTM_TITLE',
  'id_name' => 'te_utm_te_budgeted_campaign_1te_utm_ida',
);
$dictionary["te_budgeted_campaign"]["fields"]["te_utm_te_budgeted_campaign_1_name"] = array (
  'name' => 'te_utm_te_budgeted_campaign_1_name',
  'type' => 'relate',
  'required' => true,
  'source' => 'non-db',
  'vname' => 'LBL_TE_UTM_TE_BUDGETED_CAMPAIGN_1_FROM_TE_UTM_TITLE',
  'save' => true,
  'id_name' => 'te_utm_te_budgeted_campaign_1te_utm_ida',
  'link' => 'te_utm_te_budgeted_campaign_1',
  'table' => 'te_utm',
  'module' => 'te_utm',
  'rname' => 'name',
);
$dictionary["te_budgeted_campaign"]["fields"]["te_utm_te_budgeted_campaign_1te_utm_ida"] = array (
  'name' => 'te_utm_te_budgeted_campaign_1te_utm_ida',
  'type' => 'link',
  'relationship' => 'te_utm_te_budgeted_campaign_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_TE_UTM_TE_BUDGETED_CAMPAIGN_1_FROM_TE_BUDGETED_CAMPAIGN_TITLE',
);


$dictionary["te_budgeted_campaign"]["fields"]["campaign_date"] = array (
	'required' => false,
	'name' => 'campaign_date',
	'vname' => 'LBL_CAMPAIGN_DATE',
	'type' => 'date',
	'required' => true,
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
	'size' => '20',
	'enable_range_search' => false,
  
);

?>