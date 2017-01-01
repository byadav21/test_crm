<?php
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');

class website_detailview {
    function display_weburldetail(&$bean, $event, $arguments) {
    global $db;
  
       //Website URLs For UTM_system 
       $row1 =$db->query("SELECT * from te_utm_system WHERE deleted=0 AND id='".$bean->id."'");                         
	   $res =$db->fetchByAssoc($row1);
	   //$bean->=website_url_c=$res['naukri.com'];
	   $bean->website_url="http://www.talentedge.in/?utm_source=".$res['utm_source']."&utm_medium=".$res['utm_medium']."&utm_campaign=".$res['utm_campaign']."&utm_term=".$res['utm_term']."";
      
     
     

     
     
     
		}
 }
