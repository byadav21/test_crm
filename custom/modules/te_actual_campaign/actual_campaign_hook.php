<?php

///include a javascript file

class AutoCalculate
{

    public function calculateCPA(&$bean, $event, $arguments)
    {
        global  $db;
        if (isset($_REQUEST['import_module']) && $_REQUEST['module'] == "Import")
        {
                #count total leads
                
                $leadSql               = "SELECT COUNT(*) as total FROM leads WHERE utm='" . $bean->te_utm_te_actual_campaign_1_name . "' AND deleted=0 and status!='Duplicate'";
                $leadObj               = $bean->db->Query($leadSql);
                $lead                  = $db->fetchByAssoc($leadObj);
                $total_leads           = $lead['total'];  
                if ($total_leads > 0)
                     $cpl                   = floatval($bean->total_cost) / $total_leads;
                else
                    $cpl                   = 0; 
                    
                   
 
                $db->query("update te_actual_campaign set te_ba_batch_id_c='". $bean->te_utm_te_actual_campaign_1te_utm_ida . "' , cpl='".  $cpl ."' where id='" . $bean->id . "'");
            
        }
        else
        {
         
			//print_r($_REQUEST);die;
            #count total leads
            $db->Query("delete from te_utm_te_actual_campaign_1_c where te_utm_te_actual_campaign_1te_actual_campaign_idb='".$bean->id."'");
			$insertQuery = "INSERT into te_utm_te_actual_campaign_1_c (id,date_modified,te_utm_te_actual_campaign_1te_utm_ida, 	te_utm_te_actual_campaign_1te_actual_campaign_idb) VALUES ('".create_guid()."','".date('Y-m-d H:i:s')."','".$_REQUEST['te_utm_te_actual_campaign_1te_utm_ida']."','".$bean->id."')";
			$db->Query($insertQuery);
            

            $leadSql     = "SELECT COUNT(*) as total FROM leads WHERE utm='" . $_REQUEST['te_utm_te_actual_campaign_1_name'] . "' AND deleted=0 and status!='Duplicate'";
            $leadObj     = $bean->db->Query($leadSql);
            $lead        = $db->fetchByAssoc($leadObj);
            $total_leads = $lead['total'];
 
            if ($total_leads > 0)
                $bean->cpl              = ($bean->total_cost / $total_leads);
            else
                $bean->cpl              = 0;
                
              $sql="update te_actual_campaign set te_ba_batch_id_c='". $_REQUEST['te_utm_te_actual_campaign_1te_utm_ida'] . "' , cpl='". $bean->cpl  ."' where id='" . $bean->id . "'"  ; 
              $db->query($sql);   
        }
        
    }

}
