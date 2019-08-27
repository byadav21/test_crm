<?php
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

$dictionary['te_budgeted_campaign']['fields']['leads']['type']='decimal';
$dictionary['te_budgeted_campaign']['fields']['leads']['len']='9';
$dictionary['te_budgeted_campaign']['fields']['leads']['precision']='2';

$dictionary['te_budgeted_campaign']['fields']['conversion']['type']='decimal';
$dictionary['te_budgeted_campaign']['fields']['conversion']['len']='9';
$dictionary['te_budgeted_campaign']['fields']['conversion']['precision']='2';

$dictionary['te_budgeted_campaign']['fields']['volume']['type']='decimal';
$dictionary['te_budgeted_campaign']['fields']['volume']['len']='9';
$dictionary['te_budgeted_campaign']['fields']['volume']['precision']='2';

$dictionary['te_budgeted_campaign']['fields']['cost']['type']='decimal';
$dictionary['te_budgeted_campaign']['fields']['cost']['len']='9';
$dictionary['te_budgeted_campaign']['fields']['cost']['precision']='2';


$dictionary['te_budgeted_campaign']['fields']['conversion_rate']['required']=false;
$dictionary['te_budgeted_campaign']['fields']['clp']['required']=false;
$dictionary['te_budgeted_campaign']['fields']['cpa']['required']=false;
