<?php
require_once('custom/include/Email/sendmail_cron.php');
require_once('include/entryPoint.php');
require_once('custom/include/Email/sendmail_cron.php');

error_reporting(E_ALL);
ini_set('display_errors', 'On');
ini_set('memory_limit', '1024M');

    if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

    class update_lead_status
    {
        function after_save_updateleads($bean, $event, $arguments)
        {
            global $current_user,$db,$sugar_config;
            if($bean->status=='Dropout'){

	     $mail            = new FalconideEmail();	 
                
              $user_id=$current_user->id;
              $dispo_id=$this->__create_guid();
              $current_date=date('Y-m-d H:i:s');
              $leadid = $bean->leads_id;
              $te_disposition_leads_c=$this->__create_guid();
              
              
            $dropouttype       = $bean->dropout_type;
            $qualifyforrefund  = $bean->qualify_for_refund;
            $refundrequestdate = $bean->refund_request_date;
            $refundamount      = $bean->refund_amount;

            $insname          = $bean->institute;
            $programname      = $bean->program;
            $batchname        = $bean->batch;
            $batch_code       = $bean->batch_code;
            $bt_srm_comments = $bean->description;
            //$urlx             = $bean->institute;
            $sbid             = $bean->id;
            $student_id       = $bean->te_student_te_student_batch_1te_student_ida;
           
            $xsx= array($sbid,$insname,$programname,$batchname,$batch_code,$bt_srm_comments,$student_id);
             //print_r($xsx);
              
                $studentSql      = "SELECT * FROM te_student WHERE id='" . $student_id . "' AND deleted=0";
                $studentObj      = $GLOBALS['db']->query($studentSql);
                $studentDetails  = $GLOBALS['db']->fetchByAssoc($studentObj);
                $student_country = $studentDetails['country'];
                $studentemail    = $studentDetails['email'];
                $studentmobile   = $studentDetails['mobile'];
                $studentname     = $studentDetails['name'];


              $tebatchSql="UPDATE te_student_batch set is_new=0,is_new_dropout=1 WHERE id='". $bean->id."'";
              $tebatchSqlObj =$db->query($tebatchSql);
              
              $leadSql="UPDATE leads set status='Dropout',status_description='Dropout' WHERE id='".$leadid."'";
              $leadObj =$db->query($leadSql);

              $leadDispoSql="INSERT INTO `te_disposition`(`id`, `name`, `date_entered`, `date_modified`, `modified_user_id`, `created_by`, `assigned_user_id`, `status`, `status_detail`) VALUES ('".$dispo_id."','Dropout','".$current_date."','".$current_date."','".$user_id."','".$user_id."','".$user_id."','Dropout','Dropout')";
              $leadDispoObj =$db->query($leadDispoSql);

              $leadDispoRelSql="INSERT INTO `te_disposition_leads_c`(`id`, `date_modified`, `te_disposition_leadsleads_ida`, `te_disposition_leadste_disposition_idb`) VALUES ('".$te_disposition_leads_c."','".$current_date."','".$leadid."','".$dispo_id."')";
              $leadDispoRelObj =$db->query($leadDispoRelSql);
              
              $btApprover = $sugar_config['bt_approver_test'];
              $uploadedFile='';

              //echo '<pre>'; print_r($bean); die();

                //print_r($btApprover); die;
                if($qualifyforrefund=='Yes' &&  $refundamount!='')
                {
                foreach ($btApprover as $val)
                {
                    $urlx = $GLOBALS['sugar_config']['site_url'];
                    $email_summary = '

                   <table cellpadding="0" cellspacing="0" style="width: 600px; border:1px solid #999; padding: 10px;" align="center">

                        <tr>
                            <td style="font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#333; text-align: center; font-weight: bold;">SRM Dropout Request Details</td>
                        </tr>
                        <tr>
                            <td><hr/></td>
                        </tr>
                        <tr>
                            <td height="15"></td>
                        </tr>
                        <tr>
                                <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333; text-align: left; font-weight: bold;">Hi,</td>
                        </tr>

                        <tr>
                            <td height="15"></td>
                        </tr>
                        <tr>
                            <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333; text-align: left; font-weight: bold;">Below is the information of Batch Transfer Request</td>
                        </tr>
                        <tr>
                                <td height="15"></td>
                        </tr>
                        <tr>
                            <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333; text-align: left; font-weight: bold;">
                               <table cellpadding="0" cellspacing="0" style="width: 600px; border:1px solid #999; padding: 10px; border-collapse: collapse;" align="center">
                                <tr>
                                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif; width: 28%;  padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: bold;">Name :</td>
                                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif; width: 72%;  padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: normal;">'.$studentname.'</td>
                                </tr>
                                <tr>
                                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif; padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: bold;">Email :</td>
                                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif; padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: normal;"><a href="#">'.$studentemail.'</a></td>
                                </tr>
                                <tr>
                                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif; padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: bold;">Mobile :</td>
                                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif; padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: normal;">'. $studentmobile.'</td>
                                </tr>
                                <tr>
                                <td></td> <td></td>
                                </tr>
                                <tr>
                                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif; padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: bold;">Dropout Type:</td>
                                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif; padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: normal;">'.$dropouttype .'</td>
                                </tr>
                                <tr>
                                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif; padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: bold;">Qualify For Refund:</strong></td>
                                    <td style="font-family:Arial, Helvetica, sans-serif; padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: normal;">'.$qualifyforrefund.'</td>
                                </tr>
                                <tr>
                                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif; padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: bold;">Refund Request Date:</td>
                                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif; padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: normal;">'.$refundrequestdate.'</td>
                                </tr>
                                <tr>
                                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif; padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: bold;">Refund Amount: </td>
                                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif; padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: normal;">'.$refundamount . '</td>
                                </tr>
                                <tr>
                                <td></td> <td></td>
                                </tr>
                                
                                <tr>
                                    <td style="padding: 10px; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333; text-align: left; font-weight: normal;"><strong style="margin-right: 10px;">SRM Comments : </strong></td>
                                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif; padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: normal;">'.substr($bt_srm_comments, 0, 100).'...(<a href='.$urlx.'/srmdropstatus.php?student_batch='.$sbid.'&appusr=' . md5($val) . '>Click the approval URl for more details</a>)</td>
                                </tr>
                               </table> 
                            </td>
                        </tr>
                        <tr>
                            <td height="15"></td>
                        </tr>
                        <tr>
                            <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333; text-align: left; font-weight: bold;">Click the Below links to approve the request</td>
                        </tr>
                        <tr>
                            <td height="15"></td>
                        </tr>
                        <tr>
                            <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333; text-align: left; font-weight: bold;"><strong>Approval URL:</strong>&nbsp;<a href="'.$urlx.'/srmrequeststatus.php?student_batch='.$sbid.'&&appusr=' . md5($val) . '" style="font-weight: normal;">redge.talentedge.in</a></td>
                        </tr>
                        <tr>
                            <td height="15"></td>
                        </tr>

                        <tr>
                            <td height="15"></td>
                        </tr>
                        <tr>
                            <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333; text-align: left; font-weight: bold;">Regards</td>
                        </tr>
                         <tr>
                            <td height="8"></td>
                        </tr>
                        <tr>
                            <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333; text-align: left;">SRM Team</td>
                        </tr>
                     </table>';



                    $emailData = $mail->toBtApprover('SRM Dropout Request', $uploadedFile, date('Y-m-d'), $email_summary, array($val));
                    $nnn       = $mail->btApprovalEmail($emailData);
                }
                }
            }
            /* new Status Change according to 27nov17 @Manish */
            if($bean->status=='Active'){
				$dispo_status = 'Converted';
				$discription= isset($bean->status_discription)? $bean->status_discription : '';
			}
			else{
				$dispo_status = $bean->status;
				$discription=$bean->status;
			}
             //if($bean->status=='Active'){
				  $user_id=$current_user->id;
				  $current_date=date('Y-m-d H:i:s');
				  $leadid = $bean->leads_id; 
				  $discription= isset($bean->status_discription)? $bean->status_discription : '';
				  $notes=$bean->description;
				 
			      $dispo_id=$this->__create_guid();
                  $te_disposition_leads_c=$this->__create_guid();
				 
				  $leadSqlE="UPDATE leads set status_description='".$discription."' WHERE id='".$leadid."'";
				  $leadObj =$db->query($leadSqlE);
				  
					$leadDispoSql="INSERT INTO `te_disposition`(`id`, `name`, `date_entered`, `date_modified`, `modified_user_id`, `created_by`, `assigned_user_id`, `status`, `status_detail`,`description`) VALUES ('".$dispo_id."','".$dispo_status."','".$current_date."','".$current_date."','".$user_id."','".$user_id."','".$user_id."','".$dispo_status."','".$discription."','".$notes."')";
					$leadDispoObj =$db->query($leadDispoSql);

					$leadDispoRelSql="INSERT INTO `te_disposition_leads_c`(`id`, `date_modified`, `te_disposition_leadsleads_ida`, `te_disposition_leadste_disposition_idb`) VALUES ('".$te_disposition_leads_c."','".$current_date."','".$leadid."','".$dispo_id."')";
					$leadDispoRelObj =$db->query($leadDispoRelSql);
						 	
					$dispositionCall = new te_Disposition_student_batch();
					$dispositionCall->status        = $bean->status;
					$dispositionCall->dispostion_status = $discription;
					$dispositionCall->date_time   = isset($bean->date_time)? $bean->date_time : '';
					$dispositionCall->name        = $bean->status;
					$dispositionCall->description        = $bean->description;
					$dispositionCall->te_disposi5321t_batch_ida = $bean->id;
					$dispositionCall->save();   
				 
				 
				 //}
			 
			
            
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
