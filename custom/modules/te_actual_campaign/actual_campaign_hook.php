<?php

///include a javascript file

class AutoCalculate
{

    public function calculateCPA(&$bean, $event, $arguments)
    {
        //echo "<pre>";print_r($bean);exit();
        global  $db;
        if (isset($_REQUEST['import_module']) && $_REQUEST['module'] == "Import")
        {
          $utmSql                = "SELECT id,te_ba_batch_id_c FROM te_utm WHERE name='" . $bean->te_utm_te_actual_campaign_1_name . "' AND deleted=0";
          $utmObj                = $bean->db->Query($utmSql);
          $utm                   = $db->fetchByAssoc($utmObj);

          $vendorSql             = "SELECT v.id,v.name FROM `te_vendor_te_utm_1_c` AS uv INNER JOIN te_vendor AS v ON v.id=uv.te_vendor_te_utm_1te_vendor_ida WHERE uv.te_vendor_te_utm_1te_utm_idb='".$utm['id']."'";
          $vendorObj                = $bean->db->Query($vendorSql);
          $vendor                   = $db->fetchByAssoc($vendorObj);
                #count total leads
                if(isset($bean->plan_date) && !empty($bean->plan_date)){
                  $where = " AND DATE(date_entered)='".$bean->plan_date."' ";
                }
                $leadSql               = "SELECT COUNT(*) as total FROM leads WHERE utm='" . $bean->te_utm_te_actual_campaign_1_name . "' AND deleted=0 and status!='Duplicate' $where";
                $leadObj               = $bean->db->Query($leadSql);
                $lead                  = $db->fetchByAssoc($leadObj);
                $total_leads           = $lead['total'];
                if ($total_leads > 0)
                     $cpl                   = floatval($bean->total_cost) / $total_leads;
                else
                    $cpl                   = 0;



                $db->query("update te_actual_campaign set te_ba_batch_id_c='". $utm['te_ba_batch_id_c'] . "' ,name ='".$vendor['name']."', vendor_id='". $vendor['id'] . "' , cpl='".  $cpl ."' where id='" . $bean->id . "'");

        }
        else
        {
          $utmSql = "SELECT id,te_ba_batch_id_c FROM te_utm WHERE id='" . $_REQUEST['te_utm_te_actual_campaign_1te_utm_ida'] . "' AND deleted=0";
          $utmObj = $bean->db->Query($utmSql);
          $utm    = $db->fetchByAssoc($utmObj);

          $vendorSql                = "SELECT v.id,v.name FROM `te_vendor_te_utm_1_c` AS uv INNER JOIN te_vendor AS v ON v.id=uv.te_vendor_te_utm_1te_vendor_ida WHERE uv.te_vendor_te_utm_1te_utm_idb='".$utm['id']."'";
          $vendorObj                = $bean->db->Query($vendorSql);
          $vendor                   = $db->fetchByAssoc($vendorObj);

            $db->Query("delete from te_utm_te_actual_campaign_1_c where te_utm_te_actual_campaign_1te_actual_campaign_idb='".$bean->id."'");
			$insertQuery = "INSERT into te_utm_te_actual_campaign_1_c (id,date_modified,te_utm_te_actual_campaign_1te_utm_ida, 	te_utm_te_actual_campaign_1te_actual_campaign_idb) VALUES ('".create_guid()."','".date('Y-m-d H:i:s')."','".$_REQUEST['te_utm_te_actual_campaign_1te_utm_ida']."','".$bean->id."')";
			$db->Query($insertQuery);


      if(isset($bean->plan_date) && !empty($bean->plan_date)){
        $where = " AND DATE(date_entered)='".$bean->plan_date."' ";
      }
            $leadSql               = "SELECT COUNT(*) as total FROM leads WHERE utm='" . $bean->te_utm_te_actual_campaign_1_name . "' AND deleted=0 and status!='Duplicate' $where";
            $leadObj     = $bean->db->Query($leadSql);
            $lead        = $db->fetchByAssoc($leadObj);
            $total_leads = $lead['total'];

            if ($total_leads > 0)
                $bean->cpl              = floatval($bean->total_cost / $total_leads);
            else
                $bean->cpl              = 0;

              $sql="update te_actual_campaign set te_ba_batch_id_c='". $utm['te_ba_batch_id_c'] . "', name ='".$vendor['name']."', vendor_id='". $vendor['id'] . "' , cpl='". $bean->cpl  ."' where id='" . $bean->id . "'"  ;
              $db->query($sql);
        }

    }

}
