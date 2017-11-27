<?php

    if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

    class update_lead_status
    {
        function after_save_updateleads($bean, $event, $arguments)
        {
            global $current_user,$db;
            if($bean->status=='Dropout'){

			 

              $user_id=$current_user->id;
              $dispo_id=$this->__create_guid();
              $current_date=date('Y-m-d H:i:s');
              $leadid = $bean->leads_id;
              $te_disposition_leads_c=$this->__create_guid();

              $tebatchSql="UPDATE te_student_batch set is_new=0,is_new_dropout=1 WHERE id='". $bean->id."'";
              $tebatchSqlObj =$db->query($tebatchSql);
              
              $leadSql="UPDATE leads set status='Dropout',status_description='Dropout' WHERE id='".$leadid."'";
              $leadObj =$db->query($leadSql);

              $leadDispoSql="INSERT INTO `te_disposition`(`id`, `name`, `date_entered`, `date_modified`, `modified_user_id`, `created_by`, `assigned_user_id`, `status`, `status_detail`) VALUES ('".$dispo_id."','Dropout','".$current_date."','".$current_date."','".$user_id."','".$user_id."','".$user_id."','Dropout','Dropout')";
              $leadDispoObj =$db->query($leadDispoSql);

              $leadDispoRelSql="INSERT INTO `te_disposition_leads_c`(`id`, `date_modified`, `te_disposition_leadsleads_ida`, `te_disposition_leadste_disposition_idb`) VALUES ('".$te_disposition_leads_c."','".$current_date."','".$leadid."','".$dispo_id."')";
              $leadDispoRelObj =$db->query($leadDispoRelSql);

              
            }
            /* new Status Change according to 27nov17 */
             if($bean->status=='Active'){
				  $user_id=$current_user->id;
				  $current_date=date('Y-m-d H:i:s');
				  $leadid = $bean->leads_id; 
				  $discription=$bean->status_discription;
				  $notes=$bean->description;
				 
			      $dispo_id=$this->__create_guid();
                  $te_disposition_leads_c=$this->__create_guid();
				 
				  $leadSqlE="UPDATE leads set status_description='".$discription."' WHERE id='".$leadid."'";
				  $leadObj =$db->query($leadSqlE);
				  
				    $leadDispoSql="INSERT INTO `te_disposition`(`id`, `name`, `date_entered`, `date_modified`, `modified_user_id`, `created_by`, `assigned_user_id`, `status`, `status_detail`,`description`) VALUES ('".$dispo_id."','Converted','".$current_date."','".$current_date."','".$user_id."','".$user_id."','".$user_id."','Converted','".$discription."','".$notes."')";
					$leadDispoObj =$db->query($leadDispoSql);

					$leadDispoRelSql="INSERT INTO `te_disposition_leads_c`(`id`, `date_modified`, `te_disposition_leadsleads_ida`, `te_disposition_leadste_disposition_idb`) VALUES ('".$te_disposition_leads_c."','".$current_date."','".$leadid."','".$dispo_id."')";
					$leadDispoRelObj =$db->query($leadDispoRelSql);
				   
			 }
            
            
            
        }
        function __create_guid() {
        $microTime = microtime();
        list($a_dec, $a_sec) = explode(" ", $microTime);

        $dec_hex = dechex($a_dec * 1000000);
        $sec_hex = dechex($a_sec);

        $this->__ensure_length($dec_hex, 5);
        $this->__ensure_length($sec_hex, 6);

        $guid = "";
        $guid .= $dec_hex;
        $guid .= $this->__create_guid_section(3);
        $guid .= '-';
        $guid .= $this->__create_guid_section(4);
        $guid .= '-';
        $guid .= $this->__create_guid_section(4);
        $guid .= '-';
        $guid .= $this->__create_guid_section(4);
        $guid .= '-';
        $guid .= $sec_hex;
        $guid .= $this->__create_guid_section(6);

        return $guid;
    }

    function __create_guid_section($characters) {
        $return = "";
        for ($i = 0; $i < $characters; $i++) {
            $return .= dechex(mt_rand(0, 15));
        }
        return $return;
    }

      function __ensure_length(&$string, $length) {
          $strlen = strlen($string);
          if ($strlen < $length) {
              $string = str_pad($string, $length, "0");
          } else if ($strlen > $length) {
              $string = substr($string, 0, $length);
          }
      }
    }

?>
