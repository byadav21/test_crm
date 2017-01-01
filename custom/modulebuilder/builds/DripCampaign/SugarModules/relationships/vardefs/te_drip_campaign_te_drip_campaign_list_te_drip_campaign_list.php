<?php
// created: 2016-11-30 12:13:45
$dictionary["te_drip_campaign_list"]["fields"]["te_drip_campaign_te_drip_campaign_list"] = array (
  'name' => 'te_drip_campaign_te_drip_campaign_list',
  'type' => 'link',
  'relationship' => 'te_drip_campaign_te_drip_campaign_list',
  'source' => 'non-db',
  'module' => 'te_drip_campaign',
  'bean_name' => 'te_drip_campaign',
  'vname' => 'LBL_TE_DRIP_CAMPAIGN_TE_DRIP_CAMPAIGN_LIST_FROM_TE_DRIP_CAMPAIGN_TITLE',
  'id_name' => 'te_drip_campaign_te_drip_campaign_listte_drip_campaign_ida',
);
$dictionary["te_drip_campaign_list"]["fields"]["te_drip_campaign_te_drip_campaign_list_name"] = array (
  'name' => 'te_drip_campaign_te_drip_campaign_list_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_TE_DRIP_CAMPAIGN_TE_DRIP_CAMPAIGN_LIST_FROM_TE_DRIP_CAMPAIGN_TITLE',
  'save' => true,
  'id_name' => 'te_drip_campaign_te_drip_campaign_listte_drip_campaign_ida',
  'link' => 'te_drip_campaign_te_drip_campaign_list',
  'table' => 'te_drip_campaign',
  'module' => 'te_drip_campaign',
  'rname' => 'name',
);
$dictionary["te_drip_campaign_list"]["fields"]["te_drip_campaign_te_drip_campaign_listte_drip_campaign_ida"] = array (
  'name' => 'te_drip_campaign_te_drip_campaign_listte_drip_campaign_ida',
  'type' => 'link',
  'relationship' => 'te_drip_campaign_te_drip_campaign_list',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_TE_DRIP_CAMPAIGN_TE_DRIP_CAMPAIGN_LIST_FROM_TE_DRIP_CAMPAIGN_LIST_TITLE',
);
