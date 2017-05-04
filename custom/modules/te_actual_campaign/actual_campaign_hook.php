<?php

//include a javascript file

class AutoCalculate
{

    public function calculateCPA(&$bean, $event, $arguments)
    {
        global $db;
        if (isset($_REQUEST['import_module']) && $_REQUEST['module'] == "Import")
        {

            if (isset($_REQUEST['UTM']) && $_REQUEST['UTM'] != "")
            {
                $actualCampaignSql     = "SELECT count(*) as total FROM te_actual_campaign WHERE plan_date='" . $bean->plan_date . "' AND name='" . $bean->name . "' AND deleted=0";
                $actualCampaignObj     = $bean->db->Query($actualCampaignSql);
                $actualCampaign        = $db->fetchByAssoc($actualCampaignObj);
                #get utm id
                $utmSql                = "SELECT id,te_ba_batch_id_c FROM te_utm WHERE name='" . $_REQUEST['UTM'] . "' AND deleted=0";
                $utmObj                = $bean->db->Query($utmSql);
                $utm                   = $db->fetchByAssoc($utmObj);
                #count total leads
                $leadSql               = "SELECT COUNT(*) as total FROM leads WHERE utm='" . $_REQUEST['UTM'] . "' AND deleted=0 AND date_entered LIKE '" . $bean->plan_date . "%'";
                $leadObj               = $bean->db->Query($leadSql);
                $lead                  = $db->fetchByAssoc($leadObj);
                $total_leads           = $lead['total'];
                #count total converted leads
                $convertedLeadSql      = "SELECT COUNT(*) as total FROM leads WHERE utm='" . $_REQUEST['UTM'] . "' AND deleted=0 AND status='Converted' AND date_entered LIKE '" . $bean->plan_date . "%'";
                $convertedLeadObj      = $bean->db->Query($convertedLeadSql);
                $convertedLead         = $db->fetchByAssoc($convertedLeadObj);
                $total_converted_leads = $convertedLead['total'];
                if ($total_leads > 0)
                    $cpl                   = ($_REQUEST['total_cost'] / $total_leads);
                else
                    $cpl                   = 0;
                if ($total_converted_leads > 0)
                    $cpa                   = ($_REQUEST['total_cost'] / $total_converted_leads);
                else
                    $cpa                   = 0;

                if ($actualCampaign['total'] > 0)
                {
                    $actualSql     = "UPDATE te_actual_campaign SET plan_date='" . $bean->plan_date . "',name='" . $bean->name . "',volume='" . $bean->volume . "',total_cost='" . $bean->total_cost . "',rate='" . $bean->rate . "',type='" . $bean->type . "',leads='" . $total_leads . "',te_ba_batch_id_c='" . $utm['te_ba_batch_id_c'] . "',cpl='" . $cpl . "',cpa='" . $cpa . "'  WHERE plan_date='" . $bean->plan_date . "' AND name='" . $bean->name . "' AND deleted=0";
                    $bean->db->Query($actualSql);
                    $bean->deleted = 1;
                }
                else
                {
                    $bean->te_ba_batch_id_c                      = $utm['te_ba_batch_id_c'];
                    $bean->leads                                 = $total_leads;
                    $bean->cpl                                   = $cpl;
                    $bean->cpa                                   = $cpa;
                    $bean->te_utm_te_actual_campaign_1te_utm_ida = $utm['id'];
                }
            }
            else
            {
                $bean->deleted = 0;
            }
        }
        else
        {
            #get utm id
            $utmSql = "SELECT id,te_ba_batch_id_c FROM te_utm WHERE name='" . $bean->te_utm_te_actual_campaign_1_name . "' AND deleted=0";
            $utmObj = $bean->db->Query($utmSql);
            $utm    = $db->fetchByAssoc($utmObj);
            #count total leads

            $leadSql     = "SELECT COUNT(*) as total FROM leads WHERE utm='" . $bean->te_utm_te_actual_campaign_1_name . "' AND deleted=0 AND date_entered LIKE '" . $bean->plan_date . "%'";
            $leadObj     = $bean->db->Query($leadSql);
            $lead        = $db->fetchByAssoc($leadObj);
            $total_leads = $lead['total'];

            $bean->te_ba_batch_id_c = $utm['te_ba_batch_id_c'];
            if ($total_leads > 0)
                $bean->cpl              = ($bean->total_cost / $total_leads);
            else
                $bean->cpl              = 0;
        }
    }

}
