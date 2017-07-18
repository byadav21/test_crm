<?php
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
$dictionary["Lead"]["fields"]["country_log"] = 
            array(
                'name' => 'country_log',
                'vname' => 'LBL_COUNTRY_LOG',
                'type' => 'enum',
                'len' => '100',
                'options' => 'country_log',
                'audited' => true,
                'comment' => 'Status of the country',
                'merge_filter' => 'enabled',
            );


$dictionary["Lead"]["fields"]["dispositionName"] = 
            array(
                'name' => 'dispositionName',
                'vname' => 'LBL_DISPOSITION_NAME',
                 'type' => 'varchar',
                'len' => '255',
		'size' => '20',
                'module' => 'Leads',
                'required' => false,
                'reportable' => true,
                'audited' => false,
                'importable' => 'true',
                'duplicate_merge' => false,
            );

$dictionary["Lead"]["fields"]["callType"] = 
            array(
                'name' => 'callType',
                'label' => 'Call Type',
                'vname' => 'LBL_CALL_TYPE',
                'type' => 'varchar',
                'module' => 'Leads',
                'len' => '255',
		'size' => '20',
                'required' => false,
                'reportable' => true,
                'audited' => false,
                'importable' => 'true',
                'duplicate_merge' => false,
            );


