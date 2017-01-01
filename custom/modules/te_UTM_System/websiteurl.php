
<?php
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');

class website_listview {
    function display_weburl(&$bean, $event, $arguments) {
    global $db;
    
       // make websiteur for UTM LIST View @manish

       $row =$db->query("SELECT * from te_utm_system WHERE deleted=0 AND id='".$bean->id."'");                     
	   $res =$db->fetchByAssoc($row);
	   //$bean->=website_url_c=$res['naukri.com'];
	   $bean->website_url="http://www.talentedge.in/?utm_source=".$res['utm_source']."&utm_medium=".$res['utm_medium']."&utm_campaign=".$res['utm_campaign']."&utm_term=".$res['utm_term']."";
      
     
		}
 }
