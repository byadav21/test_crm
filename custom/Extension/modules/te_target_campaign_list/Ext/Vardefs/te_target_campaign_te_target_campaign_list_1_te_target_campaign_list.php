<?php
// created: 2016-12-23 06:33:03
$dictionary["te_target_campaign_list"]["fields"]["te_target_campaign_te_target_campaign_list_1"] = array (
  'name' => 'te_target_campaign_te_target_campaign_list_1',
  'type' => 'link',
  'relationship' => 'te_target_campaign_te_target_campaign_list_1',
  'source' => 'non-db',
  'module' => 'te_target_campaign',
  'bean_name' => 'te_target_campaign',
  'vname' => 'LBL_TE_TARGET_CAMPAIGN_TE_TARGET_CAMPAIGN_LIST_1_FROM_TE_TARGET_CAMPAIGN_TITLE',
  'id_name' => 'te_target_b188ampaign_ida',
);
$dictionary["te_target_campaign_list"]["fields"]["te_target_campaign_te_target_campaign_list_1_name"] = array (
  'name' => 'te_target_campaign_te_target_campaign_list_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_TE_TARGET_CAMPAIGN_TE_TARGET_CAMPAIGN_LIST_1_FROM_TE_TARGET_CAMPAIGN_TITLE',
  'save' => true,
  'id_name' => 'te_target_b188ampaign_ida',
  'link' => 'te_target_campaign_te_target_campaign_list_1',
  'table' => 'te_target_campaign',
  'module' => 'te_target_campaign',
  'rname' => 'name',
);
$dictionary["te_target_campaign_list"]["fields"]["te_target_b188ampaign_ida"] = array (
  'name' => 'te_target_b188ampaign_ida',
  'type' => 'link',
  'relationship' => 'te_target_campaign_te_target_campaign_list_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_TE_TARGET_CAMPAIGN_TE_TARGET_CAMPAIGN_LIST_1_FROM_TE_TARGET_CAMPAIGN_LIST_TITLE',
);
