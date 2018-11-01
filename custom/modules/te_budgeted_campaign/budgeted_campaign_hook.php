<?php
ini_set("display_errors",0);
class MapUtm
{
	public function updateRelation(&$bean, $event, $arguments){
		global $db;
		#Record is being created while import
		if(isset($_REQUEST['import_module'])&&$_REQUEST['module']=="Import"){
			$utmSql="SELECT id FROM te_utm WHERE name='".$bean->name."' AND deleted=0";
			$utmObj = $db->Query($utmSql);
			$utm = $db->fetchByAssoc($utmObj);	
			
		}		
	}
	public function assignUtm(&$bean, $event, $arguments)
	    {
			global $db;
			$bean->clp=($bean->leads>0)?round($bean->cost/$bean->leads,2):0;
			$bean->cpa=($bean->conversion>0)?round($bean->cost/$bean->conversion,2):0;		 
			$bean->conversion_rate=($bean->leads>0)?round(($bean->conversion*100)/$bean->leads,2) . '%':0 . '%';
			
			#Record is being created while import
			if(isset($_REQUEST['import_module'])&&$_REQUEST['module']=="Import"){
				
				$utmSql="SELECT te_ba_batch_id_c FROM te_utm WHERE id='".$bean->te_utm_te_budgeted_campaign_1te_utm_ida."' AND deleted=0";
				$utmObj = $bean->db->Query($utmSql);
				$utm = $db->fetchByAssoc($utmObj);
				$date=explode("-",$bean->campaign_date);
				$y=$date[0];
				$m=$date[1];
				$d=$date[2];
				$week=(Integer)date("W", mktime(0,0,0,$m,$d,$y));			
				$bean->week=$week;
				$bean->year=$y;
				$bean->te_ba_batch_id_c=$utm['te_ba_batch_id_c'];
						
			}else{
				# If record is being created from module
				$utmSql="SELECT id,te_ba_batch_id_c FROM te_utm WHERE id='".$bean->te_utm_te_budgeted_campaign_1te_utm_ida."' AND deleted=0";
				$utmObj = $bean->db->Query($utmSql);
				$utm = $db->fetchByAssoc($utmObj);
				$bean->te_ba_batch_id_c=$utm['te_ba_batch_id_c'];
				$date=explode("-",$_REQUEST['campaign_date']);		 
				$m=$date[2];
				$d=$date[1];
				$y=$date[0];
				$week=(Integer)date("W", mktime(0,0,0,$m,$d,$y));
				$bean->week=$week;
				$bean->year=$y;
				$db->Query("delete from te_utm_te_budgeted_campaign_1_c where te_utm_te_budgeted_campaign_1te_budgeted_campaign_idb='".$bean->id."'");
				$insertQuery = "INSERT into te_utm_te_budgeted_campaign_1_c (id,date_modified,te_utm_te_budgeted_campaign_1te_utm_ida, 	te_utm_te_budgeted_campaign_1te_budgeted_campaign_idb) VALUES ('".create_guid()."','".date('Y-m-d H:i:s')."','".$utm['id']."','".$bean->id."')";
				$db->Query($insertQuery);
				
			}
			
		}	
}
