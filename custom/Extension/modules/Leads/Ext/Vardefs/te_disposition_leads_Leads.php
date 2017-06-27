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
