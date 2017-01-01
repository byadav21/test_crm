<?php
// created: 2016-09-09 05:07:20
$dictionary["te_utm"]["fields"]["te_vendor_te_utm_1"] = array (
  'name' => 'te_vendor_te_utm_1',
  'type' => 'link',
  'relationship' => 'te_vendor_te_utm_1',
  'source' => 'non-db',
  'module' => 'te_vendor',
  'bean_name' => 'te_vendor',
  'vname' => 'LBL_TE_VENDOR_TE_UTM_1_FROM_TE_VENDOR_TITLE',
  'id_name' => 'te_vendor_te_utm_1te_vendor_ida',
);
$dictionary["te_utm"]["fields"]["te_vendor_te_utm_1_name"] = array (
  'name' => 'te_vendor_te_utm_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_TE_VENDOR_TE_UTM_1_FROM_TE_VENDOR_TITLE',
  'save' => true,
  'id_name' => 'te_vendor_te_utm_1te_vendor_ida',
  'link' => 'te_vendor_te_utm_1',
  'table' => 'te_vendor',
  'module' => 'te_vendor',
  'rname' => 'name',
);
$dictionary["te_utm"]["fields"]["te_vendor_te_utm_1te_vendor_ida"] = array (
  'name' => 'te_vendor_te_utm_1te_vendor_ida',
  'type' => 'link',
  'relationship' => 'te_vendor_te_utm_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_TE_VENDOR_TE_UTM_1_FROM_TE_UTM_TITLE',
);
