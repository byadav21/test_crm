<?php
// created: 2016-09-05 07:18:48
$dictionary["te_ba_Batch"]["fields"]["te_in_institutes_te_ba_batch_1"] = array (
  'name' => 'te_in_institutes_te_ba_batch_1',
  'type' => 'link',
  'relationship' => 'te_in_institutes_te_ba_batch_1',
  'source' => 'non-db',
  'module' => 'te_in_institutes',
  'bean_name' => 'te_in_institutes',
  'vname' => 'LBL_TE_IN_INSTITUTES_TE_BA_BATCH_1_FROM_TE_IN_INSTITUTES_TITLE',
  'id_name' => 'te_in_institutes_te_ba_batch_1te_in_institutes_ida',
);
$dictionary["te_ba_Batch"]["fields"]["te_in_institutes_te_ba_batch_1_name"] = array (
  'name' => 'te_in_institutes_te_ba_batch_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_TE_IN_INSTITUTES_TE_BA_BATCH_1_FROM_TE_IN_INSTITUTES_TITLE',
  'save' => true,
  'id_name' => 'te_in_institutes_te_ba_batch_1te_in_institutes_ida',
  'link' => 'te_in_institutes_te_ba_batch_1',
  'table' => 'te_in_institutes',
  'module' => 'te_in_institutes',
  'rname' => 'name',
);
$dictionary["te_ba_Batch"]["fields"]["te_in_institutes_te_ba_batch_1te_in_institutes_ida"] = array (
  'name' => 'te_in_institutes_te_ba_batch_1te_in_institutes_ida',
  'type' => 'link',
  'relationship' => 'te_in_institutes_te_ba_batch_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_TE_IN_INSTITUTES_TE_BA_BATCH_1_FROM_TE_BA_BATCH_TITLE',
);
