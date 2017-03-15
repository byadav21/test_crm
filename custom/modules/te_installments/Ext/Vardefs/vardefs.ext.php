<?php 
 //WARNING: The contents of this file are auto-generated


// created: 2016-09-14 20:35:29
$dictionary["te_installments"]["fields"]["te_ba_batch_te_installments_1"] = array (
  'name' => 'te_ba_batch_te_installments_1',
  'type' => 'link',
  'relationship' => 'te_ba_batch_te_installments_1',
  'source' => 'non-db',
  'module' => 'te_ba_Batch',
  'bean_name' => 'te_ba_Batch',
  'vname' => 'LBL_TE_BA_BATCH_TE_INSTALLMENTS_1_FROM_TE_BA_BATCH_TITLE',
  'id_name' => 'te_ba_batch_te_installments_1te_ba_batch_ida',
);
$dictionary["te_installments"]["fields"]["te_ba_batch_te_installments_1_name"] = array (
  'name' => 'te_ba_batch_te_installments_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_TE_BA_BATCH_TE_INSTALLMENTS_1_FROM_TE_BA_BATCH_TITLE',
  'save' => true,
  'id_name' => 'te_ba_batch_te_installments_1te_ba_batch_ida',
  'link' => 'te_ba_batch_te_installments_1',
  'table' => 'te_ba_batch',
  'module' => 'te_ba_Batch',
  'rname' => 'name',
);
$dictionary["te_installments"]["fields"]["te_ba_batch_te_installments_1te_ba_batch_ida"] = array (
  'name' => 'te_ba_batch_te_installments_1te_ba_batch_ida',
  'type' => 'link',
  'relationship' => 'te_ba_batch_te_installments_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_TE_BA_BATCH_TE_INSTALLMENTS_1_FROM_TE_INSTALLMENTS_TITLE',
);

?>