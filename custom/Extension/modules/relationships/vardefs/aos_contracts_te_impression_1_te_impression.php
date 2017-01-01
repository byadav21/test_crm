<?php
// created: 2016-10-22 13:16:05
$dictionary["te_impression"]["fields"]["aos_contracts_te_impression_1"] = array (
  'name' => 'aos_contracts_te_impression_1',
  'type' => 'link',
  'relationship' => 'aos_contracts_te_impression_1',
  'source' => 'non-db',
  'module' => 'AOS_Contracts',
  'bean_name' => 'AOS_Contracts',
  'vname' => 'LBL_AOS_CONTRACTS_TE_IMPRESSION_1_FROM_AOS_CONTRACTS_TITLE',
  'id_name' => 'aos_contracts_te_impression_1aos_contracts_ida',
);
$dictionary["te_impression"]["fields"]["aos_contracts_te_impression_1_name"] = array (
  'name' => 'aos_contracts_te_impression_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_AOS_CONTRACTS_TE_IMPRESSION_1_FROM_AOS_CONTRACTS_TITLE',
  'save' => true,
  'id_name' => 'aos_contracts_te_impression_1aos_contracts_ida',
  'link' => 'aos_contracts_te_impression_1',
  'table' => 'aos_contracts',
  'module' => 'AOS_Contracts',
  'rname' => 'name',
);
$dictionary["te_impression"]["fields"]["aos_contracts_te_impression_1aos_contracts_ida"] = array (
  'name' => 'aos_contracts_te_impression_1aos_contracts_ida',
  'type' => 'link',
  'relationship' => 'aos_contracts_te_impression_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_AOS_CONTRACTS_TE_IMPRESSION_1_FROM_TE_IMPRESSION_TITLE',
);
