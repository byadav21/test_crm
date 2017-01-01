<?php
// created: 2016-11-24 12:25:31
$dictionary["te_budgeted_campaign"]["fields"]["te_utm_te_budgeted_campaign_1"] = array (
  'name' => 'te_utm_te_budgeted_campaign_1',
  'type' => 'link',
  'relationship' => 'te_utm_te_budgeted_campaign_1',
  'source' => 'non-db',
  'module' => 'te_utm',
  'bean_name' => 'te_utm',
  'vname' => 'LBL_TE_UTM_TE_BUDGETED_CAMPAIGN_1_FROM_TE_UTM_TITLE',
  'id_name' => 'te_utm_te_budgeted_campaign_1te_utm_ida',
);
$dictionary["te_budgeted_campaign"]["fields"]["te_utm_te_budgeted_campaign_1_name"] = array (
  'name' => 'te_utm_te_budgeted_campaign_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_TE_UTM_TE_BUDGETED_CAMPAIGN_1_FROM_TE_UTM_TITLE',
  'save' => true,
  'id_name' => 'te_utm_te_budgeted_campaign_1te_utm_ida',
  'link' => 'te_utm_te_budgeted_campaign_1',
  'table' => 'te_utm',
  'module' => 'te_utm',
  'rname' => 'name',
);
$dictionary["te_budgeted_campaign"]["fields"]["te_utm_te_budgeted_campaign_1te_utm_ida"] = array (
  'name' => 'te_utm_te_budgeted_campaign_1te_utm_ida',
  'type' => 'link',
  'relationship' => 'te_utm_te_budgeted_campaign_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_TE_UTM_TE_BUDGETED_CAMPAIGN_1_FROM_TE_BUDGETED_CAMPAIGN_TITLE',
);
