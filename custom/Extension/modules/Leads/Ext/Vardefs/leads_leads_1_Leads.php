<?php

// created: 2016-09-19 13:25:40
$dictionary["Lead"]["fields"]["leads_leads_1"]          = array(
    'name'         => 'leads_leads_1',
    'type'         => 'link',
    'relationship' => 'leads_leads_1',
    'source'       => 'non-db',
    'module'       => 'Leads',
    'bean_name'    => 'Lead',
    'vname'        => 'LBL_LEADS_LEADS_1_FROM_LEADS_L_TITLE',
    'id_name'      => 'leads_leads_1leads_ida',
);
$dictionary["Lead"]["fields"]["leads_leads_1_name"]     = array(
    'name'             => 'leads_leads_1_name',
    'type'             => 'relate',
    'source'           => 'non-db',
    'vname'            => 'LBL_LEADS_LEADS_1_FROM_LEADS_L_TITLE',
    'save'             => true,
    'id_name'          => 'leads_leads_1leads_ida',
    'link'             => 'leads_leads_1',
    'table'            => 'leads',
    'module'           => 'Leads',
    'rname'            => 'name',
    'db_concat_fields' =>
    array(
        0 => 'first_name',
        1 => 'last_name',
    ),
);
$dictionary["Lead"]["fields"]["leads_leads_1leads_ida"] = array(
    'name'         => 'leads_leads_1leads_ida',
    'type'         => 'link',
    'relationship' => 'leads_leads_1',
    'source'       => 'non-db',
    'reportable'   => false,
    'side'         => 'right',
    'vname'        => 'LBL_LEADS_LEADS_1_FROM_LEADS_R_TITLE',
);
$dictionary["Lead"]["fields"]["dristi_customer_id"]     = array(
    'name' => 'dristi_customer_id',
    'type' => 'varchar',
);

$dictionary["Lead"]["fields"]["dristi_request"]      = array(
    'name' => 'dristi_request',
    'type' => 'text',
);
$dictionary["Lead"]["fields"]["dristi_campagain_id"] = array(
    'name' => 'dristi_campagain_id',
    'type' => 'varchar',
);

$dictionary["Lead"]["fields"]["dristi_API_id"] = array(
    'name' => 'dristi_API_id',
    'type' => 'text',
);

$dictionary["Lead"]["fields"]["call_object_id"] = array(
    'name' => 'call_object_id',
    'type' => 'text',
);


$dictionary["Lead"]["fields"]["disposition_reason"] = array(
    'name'            => 'disposition_reason',
    //'label' => 'LBL_SOURCE_TYPE',
    'vname'           => 'Disposition Reason',
    'type'            => 'enum',
    'help'            => '',
    'comment'         => 'source_type',
    //'ext1' => 'lead_source_custom_dom_type', //maps to options - specify list name
    'mass_update'     => false,
    'required'        => false,
    'reportable'      => true,
    'audited'         => true,
    'importable'      => 'true',
    'duplicate_merge' => false,
    'len'             => 100,
    'size'            => '20',
    'options'         => 'leads_disposition_reason_list',
    'studio'          => 'visible',
);
$dictionary['Lead']['fields']['landing_url']        = array(
    'name'                      => 'landing_url',
    'label'                     => 'Landing URL',
    'type'                      => 'text',
    'required'                  => false,
    'massupdate'                => 0,
    'comments'                  => '',
    'help'                      => '',
    'default'                   => 'NA',
    'importable'                => 'true',
    'duplicate_merge'           => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited'                   => false,
    'reportable'                => true,
    'source'                    => 'custom_fields',
);

$dictionary["Lead"]["fields"]["country_code"] = array(
            'name'            => 'country_code',
            'vname'           => 'LBL_COUNTRY_CODE',
            'type'            => 'varchar',
            'len'             => '100',
            'size'            => '20',
            //'module' => 'Leads',
            'required'        => false,
            'reportable'      => true,
            'audited'         => false,
            'importable'      => 'true',
            'duplicate_merge' => false,
            'source'          => 'custom_fields',
);

$dictionary["Lead"]["fields"]["test_status"] = array(
            'name'            => 'test_status',
            'vname'           => 'Test Status',
            'type'            => 'varchar',
            'len'             => '50',
            'size'            => '20',
            //'module' => 'Leads',
            'default'         => 'NA',
            'required'        => false,
            'reportable'      => true,
            'audited'         => false,
            'importable'      => 'true',
            'duplicate_merge' => false,
            'source'          => 'custom_fields',
);

$dictionary["Lead"]["fields"]["site_lead_id"] = array(
            'name'            => 'site_lead_id',
            'vname'           => 'Site Lead ID',
            'type'            => 'varchar',
            'len'             => '100',
            'size'            => '20',
            //'module' => 'Leads',
            'required'        => false,
            'reportable'      => true,
            'audited'         => false,
            'importable'      => 'true',
            'duplicate_merge' => false,
            'source'          => 'custom_fields',
);
