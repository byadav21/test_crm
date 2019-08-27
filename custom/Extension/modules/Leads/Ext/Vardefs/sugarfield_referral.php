<?php
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
 ?>
