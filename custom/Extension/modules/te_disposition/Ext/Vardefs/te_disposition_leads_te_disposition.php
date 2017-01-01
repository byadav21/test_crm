<?php
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
