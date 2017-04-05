<?php
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
$dictionary["Lead"]["fields"]["dristi_campagain_id"] = array (
  'name' => 'dristi_campagain_id',
  'type' => 'varchar',
  
);

$dictionary["Lead"]["fields"]["dristi_API_id"] = array (
  'name' => 'dristi_API_id',
  'type' => 'text',
  
);

$dictionary["Lead"]["fields"]["call_object_id"] = array (
  'name' => 'call_object_id',
  'type' => 'text',
  
);
