<?php
// created: 2018-08-16 10:56:52
$dictionary["User"]["fields"]["te_ba_batch_users_1"] = array (
  'name' => 'te_ba_batch_users_1',
  'type' => 'link',
  'relationship' => 'te_ba_batch_users_1',
  'source' => 'non-db',
  'module' => 'te_ba_Batch',
  'bean_name' => 'te_ba_Batch',
  'vname' => 'LBL_TE_BA_BATCH_USERS_1_FROM_TE_BA_BATCH_TITLE',
  'id_name' => 'te_ba_batch_users_1te_ba_batch_ida',
);
$dictionary["User"]["fields"]["te_ba_batch_users_1_name"] = array (
  'name' => 'te_ba_batch_users_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_TE_BA_BATCH_USERS_1_FROM_TE_BA_BATCH_TITLE',
  'save' => true,
  'id_name' => 'te_ba_batch_users_1te_ba_batch_ida',
  'link' => 'te_ba_batch_users_1',
  'table' => 'te_ba_batch',
  'module' => 'te_ba_Batch',
  'rname' => 'name',
);
$dictionary["User"]["fields"]["te_ba_batch_users_1te_ba_batch_ida"] = array (
  'name' => 'te_ba_batch_users_1te_ba_batch_ida',
  'type' => 'link',
  'relationship' => 'te_ba_batch_users_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_TE_BA_BATCH_USERS_1_FROM_USERS_TITLE',
);
