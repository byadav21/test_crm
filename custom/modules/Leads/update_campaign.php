<?php
ini_set('max_execution_time', 3600);
set_time_limit(3600);
require_once('custom/modules/te_Api/te_Api.php');
$api=new te_Api_override();
global $db;


	

$sqll="SELECT count(l.id) as ctr  from leads l WHERE l.deleted =0 and l.neoxstatus='0'";
$res=$db->query($sqll);	
$countLead=$db->fetchByAssoc($res);
 


if($countLead['ctr']>0){
    
    //echo 'ddxxdd'; die;
	$sql="SELECT DISTINCT te_utm_te_actual_campaign_1te_utm_ida AS utm,
                te_utm.name
            FROM te_utm_te_actual_campaign_1_c
            INNER JOIN te_utm ON 
                te_utm.id=te_utm_te_actual_campaign_1_c.te_utm_te_actual_campaign_1te_utm_ida
            WHERE te_utm_te_actual_campaign_1_c.deleted=0
              AND te_utm.deleted=0";
  
	$result=$db->query($sql);
	while($row =  $db->fetchByAssoc($result)){

	            $leadSql     = "SELECT COUNT(id) AS total
                                FROM leads
                                WHERE utm='" . $row['name'] . "'
                                  AND deleted=0
                                  AND status!='Duplicate'";
				$leadObj     = $db->Query($leadSql);
				$lead        = $db->fetchByAssoc($leadObj);
				$total_leads = $lead['total'];	
		 
				if($total_leads > 0){					
				  $db->query("UPDATE te_actual_campaign t
                                                INNER JOIN te_utm_te_actual_campaign_1_c r ON 
                                                t.id=r.te_utm_te_actual_campaign_1te_actual_campaign_idb
                                                SET cpl=total_cost/$total_leads
                                                WHERE r.te_utm_te_actual_campaign_1te_utm_ida='". $row['utm'] ."'");
				}else{
					$db->query("UPDATE te_actual_campaign t
                                                        INNER JOIN te_utm_te_actual_campaign_1_c r ON 
                                                    t.id=r.te_utm_te_actual_campaign_1te_actual_campaign_idb
                                                    SET cpl=0
                                                    WHERE 
                                                    r.te_utm_te_actual_campaign_1te_utm_ida='". $row['utm'] ."'");
				}				
		
	}
}	

 
$db->query("update cron_job set lead_id='0' where session_id='cron_job'");
exit();

