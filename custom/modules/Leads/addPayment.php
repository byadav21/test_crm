<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');
require_once('custom/modules/te_Api/te_Api.php');

class addPaymentClass
{

    function addPaymentFunc($bean, $event, $argument)
    {
        
        $primary_address_country = strtolower($bean->primary_address_country);
        $paidAmount              = 0;
        $student_id              = "";
        $student_name            = "";
        $student_email           = "";
        $student_batch_id        = "";
        $lead_payment_details_id = "";
        if ($bean->country_log == 'India')
        {
            $student_country = strtolower($bean->country_log);
        }
        else if ($bean->country_log == 'Other')
        {
            $student_country = strtolower($bean->primary_address_country);
        }
        
       
        
        

        if (!empty($bean->payment_type) || !empty($bean->date_of_payment) || !empty($bean->reference_number))
        {
           

            $payment                                      = new te_payment_details();
            $payment->payment_type                        = $bean->payment_type;
            $payment->invoice_number                      = $bean->invoice_number;
            $payment->invoice_order_number                = $bean->invoice_order_number;
            $payment->invoice_url                         = $bean->invoice_url;

            $payment->payment_source                      = $bean->payment_source;
            $payment->transaction_id                      = $bean->transaction_id;
            $payment->date_of_payment                     = $bean->date_of_payment;
            $payment->reference_number                    = $bean->reference_number;
            $payment->amount                              = $bean->amount;
            $payment->name                                = $bean->amount;
            $payment->payment_realized                    = $bean->payment_realized;
            $payment->leads_te_payment_details_1leads_ida = $bean->id;
            $payment->country                             = $student_country;
            $payment->state                               = $bean->primary_address_state;
            $payment->save();
            $lead_payment_details_id                      = $payment->id;
            $paidAmount                                   = $bean->amount;
            $GLOBALS['db']->query("UPDATE leads SET invoice_number='',invoice_order_number='',invoice_url='',payment_type='',transaction_id='',payment_source='',date_of_payment='',reference_number='',amount='',payment_realized=''");

            $sqlRel = "SELECT p.id FROM te_payment_details p INNER JOIN leads_te_payment_details_1_c lp ON p.id=lp.leads_te_payment_details_1te_payment_details_idb WHERE lp.leads_te_payment_details_1leads_ida='" . $bean->id . "' AND p.payment_realized= 0 ";
            $rel    = $GLOBALS['db']->query($sqlRel);
            if ($GLOBALS['db']->getRowCount($rel) > 0)
            {
                $s = "UPDATE leads SET payment_realized_check=0 WHERE id='" . $bean->id . "'";
                $GLOBALS['db']->query($s);
            }
            else
            {
                $s = "UPDATE leads SET payment_realized_check=1 WHERE id='" . $bean->id . "'";
                $GLOBALS['db']->query($s);
            }
            
            /*update last state ID in */
            
            $sqlpaymentState = "SELECT 
                    s.name,
                    sp.te_student_batch_id_c AS batch_id ,
                    sprel.`te_student_te_student_payment_1te_student_ida` AS student_id,
                    pd.date_of_payment,
                    pd.amount,
                    pd.country,
                    pd.state
                    FROM `te_student_payment` sp
                    INNER JOIN `te_payment_details` pd ON pd.student_payment_id=sp.id
                    INNER JOIN `te_student_batch` sb ON sb.id=sp.te_student_batch_id_c 
                    INNER JOIN `te_student_te_student_payment_1_c` sprel ON sprel.`te_student_te_student_payment_1te_student_payment_idb`=sp.id
                    INNER JOIN te_student s ON sprel.`te_student_te_student_payment_1te_student_ida`=s.id
                    WHERE s.email='".$bean->email1."'
                    ORDER BY  pd.`date_entered` DESC limit 1"; 
            $stateData    = $GLOBALS['db']->query($sqlpaymentState);
            if ($GLOBALS['db']->getRowCount($stateData) > 0)
            {
                $statedata    = $GLOBALS['db']->fetchByAssoc($stateData);
                $s = "UPDATE te_payment_details SET state='".$statedata['state']."' WHERE id='" . $lead_payment_details_id . "'"; 
                $GLOBALS['db']->query($s);
            }
            /*End of update last state name in payment*/
            
        }

        if (!isset($_REQUEST['import_module']) && $_REQUEST['module'] != "Import")
        {


            #update fee & attendance when record is being created manually
            $batchSql = "SELECT fees_inr,fees_in_usd,minimum_attendance_criteria as minimum_attendance FROM te_ba_batch
			WHERE id='" . $bean->te_ba_batch_id_c . "' AND deleted=0";
            $batchObj = $bean->db->Query($batchSql);
            $batch    = $GLOBALS['db']->fetchByAssoc($batchObj);
            if (isset($batch['fees_inr']) && !empty($batch['fees_inr']))
            {
                $bean->fee_inr = strstr($batch['fees_inr'], '.', true);
            }
            if (isset($batch['fees_in_usd']) && !empty($batch['fees_in_usd']))
            {
                $bean->fee_usd = strstr($batch['fees_in_usd'], '.', true);
            }
            if (isset($batch['minimum_attendance_criteria']) && !empty($batch['minimum_attendance_criteria']))
            {
                $bean->minimum_attendance = strstr($batch['minimum_attendance_criteria'], '.', true);
            }
            if ($bean->status == 'Converted')
            {

                //$bean->converted_date=date("Y-m-d H:i:s");
                #create student
                $duplicateStudentSql = "SELECT id,name,email,country FROM te_student WHERE deleted=0 AND email='" . $bean->email1 . "'";
                $duplicateStudentObj = $GLOBALS['db']->query($duplicateStudentSql);
                #check duplicate student
                if ($GLOBALS['db']->getRowCount($duplicateStudentObj) > 0)
                {
                    $duplicateStudent = $GLOBALS['db']->fetchByAssoc($duplicateStudentObj);
                    $student_id       = $duplicateStudent['id'];
                    $student_name     = $duplicateStudent['name'];
                    $student_email    = $duplicateStudent['email'];
                    $student_country  = $duplicateStudent['country'];

                    //$duplicateBatchSql = "SELECT id FROM te_student_batch WHERE deleted=0 AND te_ba_batch_id_c='".$bean->te_ba_batch_id_c."'";
                    $duplicateBatchSql = "SELECT sb.id as student_batch_id FROM te_student_te_student_batch_1_c sbr INNER JOIN te_student_batch sb ON sbr.te_student_te_student_batch_1te_student_batch_idb=sb.id  WHERE sb.deleted=0 AND sbr.te_student_te_student_batch_1te_student_ida='" . $student_id . "' AND sb.te_ba_batch_id_c='" . $bean->te_ba_batch_id_c . "'";
                    //echo $duplicateBatchSql;die;
                    $duplicateBatchObj = $GLOBALS['db']->query($duplicateBatchSql);
                    if ($GLOBALS['db']->getRowCount($duplicateBatchObj) == 0)
                    { #If no duplicate batch
                        #create batch of student
                        $vendorSql                                                    = "SELECT id FROM te_vendor WHERE deleted=0 AND name='" . $bean->vendor . "'";
                        $vendorObj                                                    = $GLOBALS['db']->query($vendorSql);
                        $vendor                                                       = $GLOBALS['db']->fetchByAssoc($vendorObj);
                        #get Institute, Program and batch details
                        $batchSql                                                     = "SELECT b.id as batch_id,b.name as batch_name,b.batch_code,b.fees_inr,b.fees_in_usd,b.initial_payment_inr,b.initial_payment_usd,b.initial_payment_date,p.id as program_id,i.id as institute_id,b.total_sessions_planned,b.batch_start_date FROM te_ba_batch b INNER JOIN te_pr_programs_te_ba_batch_1_c pbr ON pbr.te_pr_programs_te_ba_batch_1te_ba_batch_idb=b.id INNER JOIN te_pr_programs p ON pbr.te_pr_programs_te_ba_batch_1te_pr_programs_ida=p.id INNER JOIN te_in_institutes_te_ba_batch_1_c bir ON b.id=bir.te_in_institutes_te_ba_batch_1te_ba_batch_idb INNER JOIN te_in_institutes i ON bir.te_in_institutes_te_ba_batch_1te_in_institutes_ida=i.id WHERE b.deleted=0 AND b.id='" . $bean->te_ba_batch_id_c . "'";
                        $batchObj                                                     = $GLOBALS['db']->query($batchSql);
                        $batchDetails                                                 = $GLOBALS['db']->fetchByAssoc($batchObj);
                        $studentBatchObj                                              = new te_student_batch();
                        $studentBatchObj->name                                        = $batchDetails['batch_name'];
                        $studentBatchObj->batch_code                                  = $batchDetails['batch_code'];
                        $studentBatchObj->batch_start_date                            = $batchDetails['batch_start_date'];
                        $studentBatchObj->fee_inr                                     = $batchDetails['fees_inr'];
                        $studentBatchObj->fee_usd                                     = $batchDetails['fees_in_usd'];
                        $studentBatchObj->initial_payment_inr                         = $batchDetails['initial_payment_inr'];
                        $studentBatchObj->initial_payment_usd                         = $batchDetails['initial_payment_usd'];
                        $studentBatchObj->initial_payment_date                        = $batchDetails['initial_payment_date'];
                        $studentBatchObj->te_ba_batch_id_c                            = $batchDetails['batch_id'];
                        $studentBatchObj->te_pr_programs_id_c                         = $batchDetails['program_id'];
                        $studentBatchObj->te_in_institutes_id_c                       = $batchDetails['institute_id'];
                        $studentBatchObj->te_vendor_id_c                              = $vendor['id'];
                        $studentBatchObj->status                                      = "Active";
                        $studentBatchObj->assigned_user_id                            = $this->getSrmUser($batchDetails['batch_id']);
                        $studentBatchObj->total_session_required                      = $batchDetails['total_sessions_planned'];
                        $studentBatchObj->study_kit_address_state                     = $bean->primary_address_state;
                        $studentBatchObj->study_kit_address_city                      = $bean->primary_address_city;
                        $studentBatchObj->study_kit_address_country                   = $student_country;
                        $studentBatchObj->te_student_te_student_batch_1te_student_ida = $duplicateStudent['id'];
                        $studentBatchObj->leads_id                                    = $bean->id;
                        $studentBatchObj->save();
                        #get new student batch id
                        $student_batch_id                                             = $studentBatchObj->id;
                    }
                    else
                    {
                        #get existing student batch id
                        $existingStudentBatch = $GLOBALS['db']->fetchByAssoc($duplicateBatchObj);
                        //$student_batch_id=$existingStudentBatch['id'];
                        $student_batch_id     = $existingStudentBatch['student_batch_id']; //Fixed by Anup
                    }
                }
                else
                {
                    $duplicateStudent            = $GLOBALS['db']->fetchByAssoc($duplicateStudentObj);
                    $studentObj                  = new te_student();
                    $studentObj->name            = $bean->first_name . " " . $bean->last_name;
                    $studentObj->email           = $bean->email1;
                    $studentObj->mobile          = $bean->phone_mobile;
                    $studentObj->status          = 'Active';
                    $studentObj->lead_id_c       = $bean->id;
                    $studentObj->dob             = $bean->birthdate;
                    $studentObj->gender          = $bean->gender;
                    $studentObj->company         = $bean->company_c;
                    $studentObj->state           = $bean->primary_address_state;
                    $studentObj->city            = $bean->primary_address_city;
                    $studentObj->country         = $student_country;
                    $studentObj->education       = $bean->education_c;
                    $studentObj->work_experience = $bean->work_experience_c;
                    $studentObj->functional_area = $bean->functional_area_c;
                    $studentObj->phone_other     = $bean->phone_other;
                    $studentObj->save();
                    $student_id                  = $studentObj->id;
                    $student_name                = $studentObj->name;
                    $student_email               = $studentObj->email;
                    $student_country             = $studentObj->country;

                    #create batch of student
                    $vendorSql                                                    = "SELECT id FROM te_vendor WHERE deleted=0 AND name='" . $bean->vendor . "'";
                    $vendorObj                                                    = $GLOBALS['db']->query($vendorSql);
                    $vendor                                                       = $GLOBALS['db']->fetchByAssoc($vendorObj);
                    #get Institute, Program and batch details
                    $batchSql                                                     = "SELECT b.id as batch_id,b.name as batch_name,b.batch_code,b.fees_inr,b.fees_in_usd,b.initial_payment_inr,b.initial_payment_usd,b.initial_payment_date,p.id as program_id,i.id as institute_id,b.total_sessions_planned,b.batch_start_date FROM te_ba_batch b INNER JOIN te_pr_programs_te_ba_batch_1_c pbr ON pbr.te_pr_programs_te_ba_batch_1te_ba_batch_idb=b.id INNER JOIN te_pr_programs p ON pbr.te_pr_programs_te_ba_batch_1te_pr_programs_ida=p.id INNER JOIN te_in_institutes_te_ba_batch_1_c bir ON b.id=bir.te_in_institutes_te_ba_batch_1te_ba_batch_idb INNER JOIN te_in_institutes i ON bir.te_in_institutes_te_ba_batch_1te_in_institutes_ida=i.id WHERE b.deleted=0 AND b.id='" . $bean->te_ba_batch_id_c . "'";
                    $batchObj                                                     = $GLOBALS['db']->query($batchSql);
                    $batchDetails                                                 = $GLOBALS['db']->fetchByAssoc($batchObj);
                    $studentBatchObj                                              = new te_student_batch();
                    $studentBatchObj->name                                        = $batchDetails['batch_name'];
                    $studentBatchObj->batch_code                                  = $batchDetails['batch_code'];
                    $studentBatchObj->batch_start_date                            = $batchDetails['batch_start_date'];
                    $studentBatchObj->fee_inr                                     = $batchDetails['fees_inr'];
                    $studentBatchObj->fee_usd                                     = $batchDetails['fees_in_usd'];
                    $studentBatchObj->initial_payment_inr                         = $batchDetails['initial_payment_inr'];
                    $studentBatchObj->initial_payment_usd                         = $batchDetails['initial_payment_usd'];
                    $studentBatchObj->initial_payment_date                        = $batchDetails['initial_payment_date'];
                    $studentBatchObj->te_ba_batch_id_c                            = $batchDetails['batch_id'];
                    $studentBatchObj->te_pr_programs_id_c                         = $batchDetails['program_id'];
                    $studentBatchObj->te_in_institutes_id_c                       = $batchDetails['institute_id'];
                    $studentBatchObj->te_vendor_id_c                              = $vendor['id'];
                    $studentBatchObj->status                                      = "Active";
                    $studentBatchObj->assigned_user_id                            = $this->getSrmUser($batchDetails['batch_id']);
                    $studentBatchObj->total_session_required                      = $batchDetails['total_sessions_planned'];
                    $studentBatchObj->study_kit_address_state                     = $bean->primary_address_state;
                    $studentBatchObj->study_kit_address_city                      = $bean->primary_address_city;
                    $studentBatchObj->study_kit_address_country                   = $student_country;
                    $studentBatchObj->te_student_te_student_batch_1te_student_ida = $student_id;
                    $studentBatchObj->leads_id                                    = $bean->id;
                    $studentBatchObj->save();
                    #get new student batch id
                    $student_batch_id                                             = $studentBatchObj->id;
                }
                $GLOBALS['db']->query("update te_student set state='" . $bean->primary_address_state . "' where email='{$bean->email1}'");
                $GLOBALS['db']->query("update leads set converted_date='" . date('Y-m-d H:i:s') . "' where id='{$bean->id}'");
            }

            if ($bean->status == 'Dropout')
            {

                $GLOBALS['db']->query("update leads set is_new_dropout=1 where id='{$bean->id}'");
            }
			/*Re-Enquired Logic Added*/
			if ($bean->status == 'Dead')
            {
				$findReenquriedSql = "SELECT GROUP_CONCAT(leads_leads_1leads_ida)lead_id FROM leads_leads_1_c WHERE leads_leads_1leads_idb='" . $bean->id . "' AND deleted=0";
				$findReenquriedObj = $bean->db->Query($findReenquriedSql);
				$findReenquriedRes    = $GLOBALS['db']->fetchByAssoc($findReenquriedObj);
				if(isset($findReenquriedRes['lead_id']) && !empty($findReenquriedRes['lead_id'])){
					$leads_id_arr=explode(',',$findReenquriedRes['lead_id']) ;
					$res_id_arr = "'" . implode ( "', '", $leads_id_arr ) . "'";
					$GLOBALS['db']->query("update leads set status='".$bean->status."',status_description='".$bean->status_description."' where id IN($res_id_arr) AND status!='Converted' ");
				}
				
                
            }
			if(!empty($bean->assigned_user_id) && $bean->assigned_user_id!=NULL){
				$findReenquriedSql = "SELECT GROUP_CONCAT(leads_leads_1leads_ida)lead_id FROM leads_leads_1_c WHERE leads_leads_1leads_idb='" . $bean->id . "' AND deleted=0";
				$findReenquriedObj = $bean->db->Query($findReenquriedSql);
				$findReenquriedRes    = $GLOBALS['db']->fetchByAssoc($findReenquriedObj);
				if(isset($findReenquriedRes['lead_id']) && !empty($findReenquriedRes['lead_id'])){
					$leads_id_arr=explode(',',$findReenquriedRes['lead_id']) ;
					$res_id_arr = "'" . implode ( "', '", $leads_id_arr ) . "'";
					$GLOBALS['db']->query("update leads set assigned_user_id='".$bean->assigned_user_id."',assigned_date='".$bean->assigned_date."' where id IN($res_id_arr)");
				}
			}
			/*End Re-Enquired Logic Added*/
        }
        /* elseif( isset($_REQUEST['import_module']) && $_REQUEST['module']=="Import"){

          $api=new te_Api_override();
          $session=(!isset($_SESSION['AMUYSESSION']) || $_SESSION['AMUYSESSION']=='')? $api->doLogin() : 	$_SESSION['AMUYSESSION'];

          $data=[];
          $data['sessionId']=$session;
          $data['properties']=array('update.customer'=>true,'migrate.customer'=>true);
          $customerRecords=[];
          if($bean->first_name." ".$bean->last_name) $customerRecords['name']=$bean->first_name." ".$bean->last_name;
          if($bean->first_name )  $customerRecords['first_name'] = $bean->first_name;
          if($bean->last_name )  $customerRecords['last_name'] = $bean->last_name;
          if($bean->email1 )  $customerRecords['email'] = $bean->email1;
          if($bean->phone_mobile )  $customerRecords['phone1'] = $bean->phone_mobile;
          if($bean->id )  $customerRecords['lead_id'] = $bean->id;
          $data['customerRecords'][]=$customerRecords;
          $error=false;

          if($session){
          $error=(!$api->uploadContacts($data))?false:true;
          }

          if(!$error){
          $session=$api->doLogin();
          $data['sessionId']=$session;
          if(!$api->uploadContacts($data)){
          $apiSave=new te_Api_override();
          $apiSave->name=$bean->id;
          $apiSave->description=$api->importError;
          $apiSave->save();
          }
          }

          } */



        if (!empty($bean->payment_type))
        {
            #update student payment history
            $student_payment_id = create_guid();
            $insertSql          = "INSERT INTO te_student_payment SET id='" . $student_payment_id . "', name='" . $bean->reference_number . "', date_entered='" . date('Y-m-d H:i:s') . "', date_modified='" . date('Y-m-d H:i:s') . "', te_student_batch_id_c='" . $student_batch_id . "',date_of_payment='" . $bean->date_of_payment . "', amount='" . $bean->amount . "', reference_number='" . $bean->reference_number . "', payment_type='" . $bean->payment_type . "', payment_realized='" . $bean->payment_realized . "', transaction_id='" . $bean->transaction_id . "', payment_source='" . $bean->payment_source . "',lead_payment_details_id='" . $lead_payment_details_id ."', invoice_number='" . $bean->invoice_number . "', invoice_url='" . $bean->invoice_url . "', invoice_order_number='" . $bean->invoice_order_number."'";
            //echo $insertSql;exit();
            $GLOBALS['db']->Query($insertSql);

            #update student payment id in lead payment details
            $GLOBALS['db']->query("UPDATE te_payment_details SET student_payment_id='" . $student_payment_id . "' WHERE id='" . $lead_payment_details_id . "'");

            #Update relationship record
            $insertRelSql = "INSERT INTO te_student_te_student_payment_1_c SET id='" . create_guid() . "', 	date_modified='" . date('Y-m-d H:i:s') . "',deleted=0,te_student_te_student_payment_1te_student_ida='" . $student_id . "', te_student_te_student_payment_1te_student_payment_idb='" . $student_payment_id . "'";
            $GLOBALS['db']->Query($insertRelSql);
        }
        if ($paidAmount > 0 && $bean->payment_realized == 1)
        {
            $paymentDetails = array(
                'batch_id'         => $bean->te_ba_batch_id_c,
                'student_id'       => $student_id,
                'amount'           => $paidAmount,
                'student_country'  => $student_country,
                'payment_source'   => $bean->payment_source,
                'student_batch_id' => $student_batch_id
            );
            $this->updateStudentPaymentPlan($paymentDetails);
        }
        #Mail Addreferal leads not converted lead
        if ($_REQUEST['module'] == "Leads" && $bean->lead_source == "Referrals" && $bean->status != "Converted" && $bean->status_description != "Converted")
        {

            if ($bean->parent_type == 'Leads')
            {
                global $db;
                $sqllead       = "SELECT ea.email_address FROM email_addr_bean_rel eabr JOIN email_addresses ea ON (ea.id = eabr.email_address_id) WHERE eabr.deleted = 0 AND eabr.bean_module='Leads' AND eabr.bean_id='" . $bean->parent_id . "'";
                $leadObj       = $db->query($sqllead);
                $studentresult = $db->fetchByAssoc($leadObj);
                echo $studemail     = $studentresult['email_address'];
                $template      = "<p>Dear " . $bean->parent_name . ",</p>
									<p> Greetings!</p>

									<p>This is to thank you for participating in the referral programme offered by Talentedge.</p>

									<p>Thank you for referring " . $bean->first_name . ".</p>
									<p>We shall reach out to the prospective candidates, and keep you informed should any of your referred candidate chooses to join a programme offered by Talentedge.</p>
									<p>The referral programme terms and conditions are mentioned in the website: https://talentedge.in/referral.</p> <p>The referral incentive shall be issued to the referrer subject to qualifying for the criteria, and as per the terms & conditions of Talentedge. </p><p>Talentedge also reserves the right to withdraw the referral programme at any stage.</p>
									</br>
									<p>Regards,</p>
									<p>Student Relations Manager</p>
									<p>Enquiries and Customer Support, Contact No: +91-8376000600</p>";

                $mail = new NetCoreEmail();
                $mail->sendEmail($studemail, "Lead Referral", $template);
            }
            if ($bean->parent_type == 'Users') # If get user then find user email id
            {
                global $db;
                $sqllead       = "SELECT ea.email_address FROM email_addr_bean_rel eabr JOIN email_addresses ea ON (ea.id = eabr.email_address_id) WHERE eabr.deleted = 0 AND eabr.bean_module='Users' AND eabr.bean_id='" . $bean->parent_id . "'";
                $leadObj       = $db->query($sqllead);
                $studentresult = $db->fetchByAssoc($leadObj);
                $useremail     = $studentresult['email_address'];

                $template = "<p>Dear " . $bean->parent_name . ",</p>
									<p> Greetings!</p>

									<p>This is to thank you for participating in the referral programme offered by Talentedge.</p>

									<p>Thank you for referring " . $bean->parent_name . ".</p>
									<p>We shall reach out to the prospective candidates, and keep you informed should any of your referred candidate chooses to join a programme offered by Talentedge.</p>
									<p>The referral programme terms and conditions are mentioned in the website: https://talentedge.in/referral.</p> <p>The referral incentive shall be issued to the referrer subject to qualifying for the criteria, and as per the terms & conditions of Talentedge. </p><p>Talentedge also reserves the right to withdraw the referral programme at any stage.</p>
									</br>
									<p>Regards,</p>
									<p>Student Relations Manager</p>
									<p>Enquiries and Customer Support, Contact No: +91-8376000600</p>";

                $mail = new NetCoreEmail();
                $mail->sendEmail($useremail, "Lead Referral", $template);
            }
        }


        # When Converted Leads and Referal select sendt mail
        if ($_REQUEST['module'] == "Leads" && $bean->lead_source == "Referrals" && $bean->status == "Converted" && $bean->status_description == "Converted")
        {
            global $db;
            if ($bean->parent_type == 'Leads') ## When lead get email id
            {
                global $db;
                $sqllead       = "SELECT ea.email_address FROM email_addr_bean_rel eabr JOIN email_addresses ea ON (ea.id = eabr.email_address_id) WHERE eabr.deleted = 0 AND eabr.bean_module='Leads' AND eabr.bean_id='" . $bean->parent_id . "'";
                $leadObj       = $db->query($sqllead);
                $studentresult = $db->fetchByAssoc($leadObj);
                $studemail     = $studentresult['email_address'];
                #find program 
                $SQLBATCh      = "SELECT t1.te_pr_programs_te_ba_batch_1te_pr_programs_ida,pt2.name FROM `te_pr_programs_te_ba_batch_1_c` t1 INNER JOIN te_pr_programs pt2 ON t1.te_pr_programs_te_ba_batch_1te_pr_programs_ida=pt2.id where t1.te_pr_programs_te_ba_batch_1te_ba_batch_idb='" . $bean->te_ba_batch_id_c . "'";
                $BatchObj      = $db->query($SQLBATCh);
                $BAtchresult   = $db->fetchByAssoc($BatchObj);
                $BATCHprogram  = $BAtchresult['name'];

                echo $template = "<p>Dear " . $bean->parent_name . ",</p>
								<p>Greetings!</p>

								<p>This is to thank you for participating in the referral programme offered by Talentedge.</p>
								<p>We are pleased to inform you that the following candidate(s) referred by you have registered with us for a Talentedge programme: " . $BATCHprogram . "</p>
								<p>Congratulations indeed for a successful referral! Your incentive voucher shall reach you within next 30 days at your registered email id.</p>
								<p>The referral programme terms and conditions are mentioned in the website: https://talentedge.in/referral.</p> <p>The referral incentive shall be issued to the referrer subject to qualifying for the criteria, and as per the terms & conditions of Talentedge. Talentedge also reserves the right to withdraw the referral programme at any stage.</p>
								<p>Please feel free to reach out to your Student Relations Manager incase of non-receipt of the referral gift voucher/incentive, or for any other query.</p>
								<p>Regards,</p>
								<p>Student Relations Manager</p>
								<p>Enquiries and Customer Support, Contact No: +91-8376000600</p>";


                $mail = new NetCoreEmail();
                $mail->sendEmail($studemail, "Lead Referral Converted", $template);
            }
            if ($bean->parent_type == 'Users') # If get user then find user email id
            {
                global $db;
                $sqllead       = "SELECT ea.email_address FROM email_addr_bean_rel eabr JOIN email_addresses ea ON (ea.id = eabr.email_address_id) WHERE eabr.deleted = 0 AND eabr.bean_module='Users' AND eabr.bean_id='" . $bean->parent_id . "'";
                $leadObj       = $db->query($sqllead);
                $studentresult = $db->fetchByAssoc($leadObj);
                $useremail     = $studentresult['email_address'];
                #find program 
                $SQLBATCh      = "SELECT t1.te_pr_programs_te_ba_batch_1te_pr_programs_ida,pt2.name FROM `te_pr_programs_te_ba_batch_1_c` t1 INNER JOIN te_pr_programs pt2 ON t1.te_pr_programs_te_ba_batch_1te_pr_programs_ida=pt2.id where t1.te_pr_programs_te_ba_batch_1te_ba_batch_idb='" . $bean->te_ba_batch_id_c . "'";
                $BatchObj      = $db->query($SQLBATCh);
                $BAtchresult   = $db->fetchByAssoc($BatchObj);
                $BATCHprogram  = $BAtchresult['name'];

                $template = "<p>Dear " . $bean->parent_name . ",</p>
								<p>Greetings!</p>

								<p>This is to thank you for participating in the referral programme offered by Talentedge.</p>
								<p>We are pleased to inform you that the following candidate(s) referred by you have registered with us for a Talentedge programme: " . $BATCHprogram . "</p>
								<p>Congratulations indeed for a successful referral! Your incentive voucher shall reach you within next 30 days at your registered email id.</p>
								<p>The referral programme terms and conditions are mentioned in the website: https://talentedge.in/referral.</p> <p>The referral incentive shall be issued to the referrer subject to qualifying for the criteria, and as per the terms & conditions of Talentedge. Talentedge also reserves the right to withdraw the referral programme at any stage.</p>
								<p>Please feel free to reach out to your Student Relations Manager incase of non-receipt of the referral gift voucher/incentive, or for any other query.</p>
								<p>Regards,</p>
								<p>Student Relations Manager</p>
								<p>Enquiries and Customer Support, Contact No: +91-8376000600</p>";

                $mail = new NetCoreEmail();
                $mail->sendEmail($useremail, "Lead Referral Converted", $template);
            }
        }
    }

    public function getSrmUser($batch_id)
    {
        $srmSql  = "SELECT assigned_user_id FROM te_srm_auto_assignment WHERE deleted=0 AND te_ba_batch_id_c='" . $batch_id . "'";
        $srmObj  = $GLOBALS['db']->query($srmSql);
        $srmUser = $GLOBALS['db']->fetchByAssoc($srmObj);
        return $srmUser['assigned_user_id'];
    }

    function updateStudentPaymentPlan($paymentDetails)
    {
        #Service Tax deduction
        $amount           = $paymentDetails['amount'];
        $student_country  = strtolower($paymentDetails['student_country']);
        $batch_id         = $paymentDetails['batch_id'];
        $student_id       = $paymentDetails['student_id'];
        $payment_source   = $paymentDetails['payment_source'];
        $student_batch_id = $paymentDetails['student_batch_id'];

        global $sugar_config;
        #for Indian student only need to calculate service tax
        if (empty($student_country) || $student_country == "india")
        {
            //getTaxStatus($student_id);
            $service_tax =  getTaxStatus($student_id); 
            $tax         = (($amount * $service_tax) / 100);
            //$amount=($amount-$tax); //since tax is already added in fees

            $paymentPlanSql = "SELECT s.name as student_name,s.email,s.mobile,sb.name as batch_name,sp.name,sp.id,sp.te_student_id_c,sp.due_amount_inr,sp.paid_amount_inr,sp.paid,sp.due_date,sp.currency FROM te_student_batch sb INNER JOIN te_student_batch_te_student_payment_plan_1_c rel ON sb.id=rel.te_student_batch_te_student_payment_plan_1te_student_batch_ida INNER JOIN `te_student_payment_plan` sp ON sp.id=rel.te_student9d1ant_plan_idb INNER JOIN te_student s ON sp.te_student_id_c=s.id WHERE sp.deleted=0 AND sp.te_student_id_c='" . $student_id . "' AND sb.te_ba_batch_id_c='" . $batch_id . "' ORDER BY sp.due_date";

            $paymentPlanObj   = $GLOBALS['db']->Query($paymentPlanSql);
            $tempAmt          = 0;
            $initial_payment  = 0;
            $student_email    = "";
            $student_name     = "";
            $student_mobile   = "";
            $student_batch    = "";
            $payment_currency = "";
            $paid_amount      = $amount;
            while ($row              = $GLOBALS['db']->fetchByAssoc($paymentPlanObj))
            {
                $payment_currency = $row['currency'];
                if ($row['due_amount_inr'] == $row['paid_amount_inr'])
                {
                    $initial_payment = 1;
                    continue;
                }
                $student_email  = $row['email'];
                $student_name   = $row['student_name'];
                $student_mobile = $row['mobile'];
                $student_batch  = $row['batch_name'];

                $restAmt = ($row['due_amount_inr'] - $row['paid_amount_inr']);
                if ($amount >= $restAmt)
                {
                    $GLOBALS['db']->Query("UPDATE te_student_payment_plan SET paid_amount_inr=paid_amount_inr+" . $restAmt . ", paid='Yes' WHERE id='" . $row['id'] . "'");
                    $amount = $amount - $restAmt;
                }
                else
                {
                    $GLOBALS['db']->Query("UPDATE te_student_payment_plan SET paid_amount_inr=paid_amount_inr+" . $amount . " WHERE id='" . $row['id'] . "'");
                    $amount = 0;
                }
                #update balanced amount
                $GLOBALS['db']->Query("UPDATE te_student_payment_plan SET balance_inr=due_amount_inr-paid_amount_inr WHERE id='" . $row['id'] . "'");
                if ($amount == 0)
                    break;
            }
            #update payment currency as INR
            if ($payment_currency == "")
            {
                $GLOBALS['db']->query("UPDATE te_student_payment_plan, te_student_batch_te_student_payment_plan_1_c SET te_student_payment_plan.currency = 'INR' WHERE te_student_payment_plan.id = te_student_batch_te_student_payment_plan_1_c.te_student9d1ant_plan_idb AND te_student_batch_te_student_payment_plan_1_c.te_student_batch_te_student_payment_plan_1te_student_batch_ida='" . $student_batch_id . "' AND te_student_payment_plan.te_student_id_c='" . $student_id . "'");
            }
            #send welcome email on first payment
            if (!$initial_payment)
            {
                $this->sendWelcomEmail($student_email, $batch_id, $student_id, $student_name, $student_country);
            }
        }
        else
        {
            # Payment for non indian student will be on USD
            $paymentPlanSql = "SELECT s.name as student_name,s.email,s.mobile,sb.name as batch_name,sp.name,sp.id,sp.te_student_id_c,sp.due_amount_usd,sp.paid_amount_usd,sp.paid,sp.due_date,sp.currency FROM te_student_batch sb INNER JOIN te_student_batch_te_student_payment_plan_1_c rel ON sb.id=rel.te_student_batch_te_student_payment_plan_1te_student_batch_ida INNER JOIN `te_student_payment_plan` sp ON sp.id=rel.te_student9d1ant_plan_idb INNER JOIN te_student s ON sp.te_student_id_c=s.id WHERE sp.deleted=0 AND sp.te_student_id_c='" . $student_id . "' AND sb.te_ba_batch_id_c='" . $batch_id . "' ORDER BY sp.due_date";

            $paymentPlanObj   = $GLOBALS['db']->Query($paymentPlanSql);
            $tempAmt          = 0;
            $initial_payment  = 0;
            $student_email    = "";
            $student_name     = "";
            $student_mobile   = "";
            $student_batch    = "";
            $payment_currency = "";
            $paid_amount      = $amount;

            while ($row = $GLOBALS['db']->fetchByAssoc($paymentPlanObj))
            {
                $payment_currency = $row['currency'];
                if ($row['due_amount_usd'] == $row['paid_amount_usd'])
                {
                    $initial_payment = 1; #to check initial payment has been done and welcome email has sent
                    continue;
                }
                $student_email  = $row['email'];
                $student_name   = $row['student_name'];
                $student_mobile = $row['mobile'];
                $student_batch  = $row['batch_name'];

                $restAmt = ($row['due_amount_usd'] - $row['paid_amount_usd']);
                if ($amount >= $restAmt)
                {
                    $GLOBALS['db']->Query("UPDATE te_student_payment_plan SET paid_amount_usd=paid_amount_usd+" . $restAmt . ", paid='Yes' WHERE id='" . $row['id'] . "'");
                    $amount = $amount - $restAmt;
                }
                else
                {
                    $GLOBALS['db']->Query("UPDATE te_student_payment_plan SET paid_amount_usd=paid_amount_usd+" . $amount . " WHERE id='" . $row['id'] . "'");
                    $amount = 0;
                }

                #update balanced amount
                $GLOBALS['db']->Query("UPDATE te_student_payment_plan SET balance_usd=due_amount_usd-paid_amount_usd WHERE id='" . $row['id'] . "'");
                if ($amount == 0)
                    break;
            }
            #update payment currency as USD
            if ($payment_currency == "")
            {
                $GLOBALS['db']->query("UPDATE te_student_payment_plan, te_student_batch_te_student_payment_plan_1_c SET te_student_payment_plan.currency = 'USD' WHERE te_student_payment_plan.id = te_student_batch_te_student_payment_plan_1_c.te_student9d1ant_plan_idb AND te_student_batch_te_student_payment_plan_1_c.te_student_batch_te_student_payment_plan_1te_student_batch_ida='" . $student_batch_id . "' AND te_student_payment_plan.te_student_id_c='" . $student_id . "'");
            }
            #send welcome email on first payment
            if (!$initial_payment)
            {
                $this->sendWelcomEmail($student_email, $batch_id, $student_id, $student_name, $student_country);
            }
        }
    }

    function checkDuplicateFunc($bean, $event, $argument)
    {
        ini_set("display_errors", 0);
        error_reporting(0);
        global $db,$current_user;

		if((!isset($_SESSION['user_cp_vendor']) || empty($_SESSION['user_cp_vendor'])) && ($bean->utm_source_c)){
			$sql="select v.name AS vendor,uvr.te_vendor_users_1users_idb AS userid from te_vendor AS v
					inner join te_vendor_users_1_c AS uvr on uvr.te_vendor_users_1te_vendor_ida=v.id and v.name='$bean->utm_source_c' 
					where v.deleted=0 and uvr.deleted=0 limit 0,1"; 
						
			$results=$db->query($sql);
			if($db->getRowCount($results)>0){
				$vendor=$db->fetchByAssoc($results);
				$bean->assigned_user_id = $vendor['userid'];
				$_SESSION['user_cp_vendor'] = $vendor;
			}
			
		}
		
        $bean->email_add_c=$bean->email1;
        $bean->primary_vendor=$bean->vendor;
        if(isset($_SESSION['user_cp_vendor']) && !empty($_SESSION['user_cp_vendor']) && ($bean->lead_source_types !='CC'))
        {
		    $bean->lead_source='OO'.'_'.strtoupper($_SESSION['user_cp_vendor']['vendor']);;
		    $bean->lead_source_types='OO';
        
			
        }
        // Capture the date of referral creation
        if (isset($_REQUEST['parent_id']) && !empty($_REQUEST['parent_id']) && empty($_REQUEST['date_of_referral']))
        {
            $bean->date_of_referral = date('Y-m-d');
        }

        if (isset($_REQUEST['import_module']) && $_REQUEST['module'] == "Import")
        {


            $vendor    = $bean->utm_source_c;
            $contract  = $bean->utm_contract_c;
            $batch     = $bean->utm_term_c;
            $batch_id  = 0;
            $vendor_id = '';
            if ($batch)
            {
                $sql = "select id from te_ba_batch  where batch_code='" . $batch . "' and deleted=0";
                $res = $db->query($sql);
                if ($db->getRowCount($res) > 0)
                {
                    $batch_id = $db->fetchByAssoc($res); //die;
                    if ($contract && $vendor && $batch_id['id'])
                    {
                        $sql = "select id from te_vendor  where name='" . $vendor . "' and deleted=0";
                        $res = $db->query($sql);
                        if ($db->getRowCount($res) > 0)
                        {
                            $vendor_id = $db->fetchByAssoc($res);

                            if ($vendor_id['id'])
                            {

                                $sql = "select te_utm.id,te_utm.name from te_utm inner join te_vendor_te_utm_1_c v on v.te_vendor_te_utm_1te_utm_idb=te_utm.id and te_vendor_te_utm_1te_vendor_ida='{$vendor_id['id']}' where te_ba_batch_id_c='{$batch_id['id']}' and contract_type='{$contract}' and te_utm.deleted=0 and v.deleted=0";
                                $res = $db->query($sql);
                                if ($db->getRowCount($res) > 0)
                                {
                                    $utmDetails = $db->fetchByAssoc($res);
                                    $bean->utm  = $utmDetails['name'];
                                }
                            }
                        }
                    }
                }
            }

            #update fee & attendance
            /* $utmSql="SELECT  u.name as utm,u.te_ba_batch_id_c as batch, v.name as vendor from  te_utm u INNER JOIN te_vendor_te_utm_1_c uvr ON u.id=uvr.te_vendor_te_utm_1te_utm_idb INNER JOIN te_vendor v ON uvr.te_vendor_te_utm_1te_vendor_ida=v.id WHERE uvr.deleted=0 AND u.deleted=0 AND u.name='".$bean->utm."'";
              $utmObj = $bean->db->Query($utmSql);
              $utmDetails = $GLOBALS['db']->fetchByAssoc($utmObj); */
            //if(!isset($utmDetails['batch'] || !$utmDetails['batch'] ))  $utmDetails['batch']=$bean->batch; 
            #check duplicate leads
            $sql = "SELECT leads.id as id,leads.assigned_user_id,leads.status FROM leads INNER JOIN leads_cstm ON leads.id = leads_cstm.id_c ";
            /*if ($bean->email1 != "")
            {
                $sql .= " INNER JOIN email_addr_bean_rel ON email_addr_bean_rel.bean_id = leads.id AND email_addr_bean_rel.bean_module ='Leads' ";
                $sql .= " INNER JOIN email_addresses ON email_addresses.id =  email_addr_bean_rel.email_address_id ";
            }*/
            $sql .= " WHERE leads.deleted = 0 AND leads_cstm.te_ba_batch_id_c = '" . $batch_id['id'] . "' and status_description!='Duplicate' and status_description!='Re-Enquired' and  leads.deleted=0"; // AND DATE(date_entered) = '".date('Y-m-d')."'";
            if ($bean->phone_mobile && $bean->email1)
            {

                $sql .= " and ( leads.phone_mobile = '{$bean->phone_mobile}' or email_add_c = '{$bean->email1}')";
            }
            elseif (!$bean->phone_mobile && $bean->email1)
            {

                $sql .= " and email_add_c=  '{$bean->email1}'";
            }
            elseif ($bean->phone_mobile && !$bean->email1)
            {
                $sql .= " and leads.phone_mobile = '{$bean->phone_mobile}'";
            }
            $bean->upload_status   = 1;
            $bean->duplicate_check = '1';
			$sql .= " order by date_entered DESC";
            //echo $sql;die;
            try
            {
                $re = $GLOBALS['db']->query($sql);
            } catch (Exception $e)
            {
                $re = NULL;
            }

            if ($GLOBALS['db']->getRowCount($re) > 0)
            {
				/*Re-Enquired Logic Added*/
				$beanData                 = $GLOBALS['db']->fetchByAssoc($re);
				if($beanData['status']=='Dead'){
					$bean->status             = 'Alive';
					if(isset($_SESSION['user_cp_vendor']) && !empty($_SESSION['user_cp_vendor'])){
						$bean->status_description='Follow Up';
						$bean->autoassign= 'No';	
					}
					else{
						$bean->status_description = 'New Lead';
						$bean->assigned_user_id   = NULL;
						$bean->autoassign= 'Yes';					
					}
					
					$bean->duplicate_check    = '1';
					
					
				}
				else{
					$bean->status             = 'Warm';
					$bean->status_description = 'Re-Enquired';
					$bean->duplicate_check    = '1';
					
					$bean->assigned_user_id   = $beanData['assigned_user_id'];
					$bean->autoassign= 'No';
					$bean->assigned_date=($bean->temp_lead_date_c)? $bean->temp_lead_date_c : date('Y-m-d H:i:s');
					$lead_lead_id = create_guid();
					//$GLOBALS['db']->query("INSERT INTO `crm_new`.`leads_leads_1_c` (`id`, `date_modified`, `leads_leads_1leads_ida`, `leads_leads_1leads_idb`) VALUES ('".$lead_lead_id."','".(date('Y-m-d H:i:s'))."','".$bean->id."','".$beanData['id']."')");
					
				}
                /*End Re-Enquired Logic*/
               /* $bean->status             = 'Warm';
                $bean->status_description = 'Re-Enquired';
                $bean->duplicate_check    = '1';
                $bean->upload_status      = -1;
                $_SESSION['dupCheck']     = intval($_SESSION['dupCheck']) + 1;
                //$data=$GLOBALS['db']->fetchByAssoc($re);
                $bean->assigned_user_id   = $beanData->assigned_user_id;
                if($beanData->assigned_user_id) $bean->assigned_date=($bean->temp_lead_date_c)? $bean->temp_lead_date_c : date('Y-m-d H:i:s');*/
				//$bean->converted_date=date('Y-m-d');
            }
            else
            {
                if ($bean->autoassign == 'Yes')
                {
                    $bean->assigned_user_id = NULL;
                }else{
					$bean->assigned_date=($bean->temp_lead_date_c)? $bean->temp_lead_date_c : date('Y-m-d');
					 
				}
                $_SESSION['aliveCheck'] = intval($_SESSION['aliveCheck']) + 1;
            }
             if(isset($_SESSION['user_cp_vendor']) && !empty($_SESSION['user_cp_vendor']))
       		 {
		    		$bean->assigned_user_id = $current_user->id;
		    		$bean->autoassign == 'No';
        		 }
            $bean->vendor           = ($bean->utm_source_c)? $bean->utm_source_c : 'NA_VENDOR';   // $vendor_id['id'];
            if(!$bean->utm) $bean->utm='NA';
            $bean->te_ba_batch_id_c = $batch_id['id'];
            
            if($bean->status == 'Converted')  $bean->converted_date=($bean->temp_lead_date_c)? $bean->temp_lead_date_c : date('Y-m-d');
            
        }
        else
        {
            if ($bean->fetched_row['temp_lead_date_c'] == '')
            {
                $bean->temp_lead_date_c = date('Y-m-d H:i:s');
            }

            if (empty($bean->fetched_row['id']))
            {

                $sql = "SELECT leads.id  as id,leads.assigned_user_id,leads.status FROM leads INNER JOIN leads_cstm ON leads.id = leads_cstm.id_c ";
                /*if ($bean->email1 != "")
                {
                    $sql .= " INNER JOIN email_addr_bean_rel ON email_addr_bean_rel.bean_id = leads.id AND email_addr_bean_rel.bean_module ='Leads' ";
                    $sql .= " INNER JOIN email_addresses ON email_addresses.id =  email_addr_bean_rel.email_address_id ";
                }*/
                $sql .= " WHERE leads.deleted = 0 AND leads_cstm.te_ba_batch_id_c = '" . $bean->te_ba_batch_id_c . "' and status_description!='Duplicate'  and status_description!='Re-Enquired' and leads.deleted=0 "; // AND DATE(date_entered) = '".date('Y-m-d')."'";
                if ($bean->phone_mobile && $bean->email1)
                {

                    $sql .= " and ( leads.phone_mobile = '{$bean->phone_mobile}' or email_add_c = '{$bean->email1}')";
                }
                elseif (!$bean->phone_mobile && $bean->email1)
                {

                    $sql .= " and email_add_c= '{$bean->email1}'";
                }
                elseif ($bean->phone_mobile && !$bean->email1)
                {
                    $sql .= " and leads.phone_mobile = '{$bean->phone_mobile}'";
                }
				 $sql .= " order by date_entered DESC";
                $re = $GLOBALS['db']->query($sql);
                if ($GLOBALS['db']->getRowCount($re) > 0)
                {
					/*Re-Enquired Logic Added*/
					$data                     = $GLOBALS['db']->fetchByAssoc($re);
					if($data['status']=='Dead'){
						$bean->status             = 'Alive';
						if(isset($_SESSION['user_cp_vendor']) && !empty($_SESSION['user_cp_vendor'])){
							$bean->status_description='Follow Up';
							$bean->autoassign= 'No';
					   }
					   else{
						 	$bean->status_description = 'New Lead';
						 	$bean->assigned_user_id   = NULL;
						 	$bean->autoassign= 'Yes';					
					   }
						$bean->duplicate_check    = '1';
					}
					else{
						$bean->status             = 'Warm';
						$bean->status_description = 'Re-Enquired';
						$bean->duplicate_check    = '1';
						
						$bean->assigned_user_id   = $data['assigned_user_id'];
						$bean->autoassign= 'No';
						$bean->assigned_date=($bean->temp_lead_date_c)? $bean->temp_lead_date_c : date('Y-m-d H:i:s');
						$lead_lead_id = create_guid();
						$GLOBALS['db']->query("INSERT INTO `crm_new`.`leads_leads_1_c` (`id`, `date_modified`, `leads_leads_1leads_ida`, `leads_leads_1leads_idb`) VALUES ('".$lead_lead_id."','".(date('Y-m-d H:i:s'))."','".$bean->id."','".$data['id']."')");
						
					}
                    /*End Re-Enquired Logic*/
					//$bean->converted_date=date('Y-m-d');
                    
                }
                
                $bean->assigned_date=($bean->temp_lead_date_c)? $bean->temp_lead_date_c : date('Y-m-d H:i:s');
                
				if(!$bean->utm) $bean->utm='NA';
				if(!$bean->vendor) $bean->vendor='NA_VENDOR';
				//$bean->converted_date=date('Y-m-d');
            }
        }
        # 	>>>>----------------web Services ----------------------------<<<<<<
        /*if (!isset($_REQUEST['import_module']) && $_REQUEST['module'] != "Import")
        {

            $Query3     = "SELECT email_address,id FROM `email_addresses` WHERE deleted=0 AND email_address='" . $bean->email1 . "'";
            $lead3      = $GLOBALS['db']->query($Query3);
            $Emails     = $GLOBALS['db']->fetchByAssoc($lead3);
            $leadEmail  = $Emails['email_address'];
            $emailaddid = $Emails['id'];
            $webid      = '';

            /*if ($emailaddid)
            {
                $findUserWebidSql = "SELECT l.web_lead_id FROM `email_addr_bean_rel` as eabr INNER JOIN leads as l on l.id=eabr.bean_id WHERE eabr.`email_address_id`='" . $emailaddid . "' AND l.web_lead_id!='' LIMIT 0,1";
                $findUserWebidobj = $GLOBALS['db']->query($findUserWebidSql);
                $findUserWebidRes = $GLOBALS['db']->fetchByAssoc($findUserWebidobj);
                $webid            = $findUserWebidRes['web_lead_id'];
            }
            $Fields = array();

            if (!empty($bean->first_name))
            {
                $Fields[] = "first_name = '" . $bean->first_name . "'";
            }
            if (!empty($bean->last_name))
            {
                $Fields[] = "last_name = '" . $bean->last_name . "'";
            }
            if (!empty($bean->birthdate))
            {
                $Fields[] = "birthdate = '" . $bean->birthdate . "'";
            }
            if (!empty($bean->phone_mobile))
            {
                $Fields[] = "phone_mobile = '" . $bean->phone_mobile . "'";
            }
            if (!empty($bean->primary_address_country))
            {
                $Fields[] = "primary_address_country = '" . $bean->primary_address_country . "'";
            }
            if (!empty($bean->primary_address_city))
            {
                $Fields[] = "primary_address_city = '" . $bean->primary_address_city . "'";
            }
            $updateColumns = '';
            if ($Fields)
            {
                $updateColumns = implode(",", $Fields);
            }
            if ($bean->email1 == $leadEmail && $webid)
            {
                $user     = 'talentedgeadmin';
                $password = 'Inkoniq@2016';
                $url      = 'http://webstaging.talentedge.in/user-api/';
                $headers  = array(
                    'Authorization: Basic ' . base64_encode("$user:$password")
                );
                $post     = [
                    'action'      => 'update',
                    'crm_user_id' => $bean->id,
                    'email'       => $bean->email1,
                    'first_name'  => $bean->first_name,
                    'last_name'   => $bean->last_name,
                    'gender'      => $bean->gender,
                    'dob'         => $bean->birthdate,
                    'mobile'      => $bean->phone_mobile,
                    'country'     => $bean->primary_address_country,
                    'state'       => $bean->primary_address_state,
                    'city'        => $bean->primary_address_city,
                    'pincode'     => '1',
                    'address'     => '1',
                ];

                $ch     = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                $result = curl_exec($ch);
                $res    = json_decode($result);
                if (isset($res[0]->status) && $res[0]->status == '1')
                {
                    $bean->web_lead_id = $res[0]->userid;
                    #$GLOBALS['db']->Query("UPDATE leads_cstm SET web_id_c='".$res[0]->userid."' WHERE id_c='".$bean->id."'");
                }
                $bean->web_lead_id = $webid;
                $bean->is_sent_web = "1";

                //curl_close($ch);
                if ($updateColumns)
                {
                    #find ID of email address
                    $sql6   = "SELECT ebr.bean_id,ebr.email_address_id,ea.id,l.web_lead_id FROM `email_addr_bean_rel` ebr INNER JOIN email_addresses ea ON ebr.email_address_id = ea.id  INNER JOIN leads l ON ebr.bean_id=l.id WHERE ea.deleted=0 AND ebr.deleted=0 AND ebr.bean_module='Leads' AND ea.email_address ='" . $bean->email1 . "'";
                    $email6 = $GLOBALS['db']->query($sql6);

                    while ($row6 = $GLOBALS['db']->fetchByAssoc($email6))
                    {

                        # ****update When Records When Email id Same ******	
                        #echo $ts="UPDATE leads SET ".$updateColumns." WHERE id='".$row6['bean_id']."'";
                        $GLOBALS['db']->Query("UPDATE leads SET " . $updateColumns . ",web_lead_id='" . $webid . "' WHERE id='" . $row6['bean_id'] . "'");
                        #$qs="UPDATE leads SET ".$updateColumns.",web_lead_id='".$webid."' WHERE id='".$row6['bean_id']."'";
                        #$GLOBALS['db']->Query("UPDATE leads_cstm SET web_id_c='".$webid."' WHERE id_c='".$row6['bean_id']."'");					
                    }
                }
            }
            else
            {
                $user     = 'talentedgeadmin';
                $password = 'Inkoniq@2016';
                $url      = 'http://webstaging.talentedge.in/user-api/';
                $headers  = array(
                    'Authorization: Basic ' . base64_encode("$user:$password")
                );
                $post     = [
                    'action'      => 'add',
                    'crm_user_id' => $bean->id,
                    'email'       => $bean->email1,
                    'first_name'  => $bean->first_name,
                    'last_name'   => $bean->last_name,
                    'gender'      => $bean->gender,
                    'dob'         => $bean->birthdate,
                    'mobile'      => $bean->phone_mobile,
                    'country'     => $bean->primary_address_country,
                    'state'       => $bean->primary_address_state,
                    'city'        => $bean->primary_address_city,
                    'pincode'     => '1',
                    'address'     => '1',
                ];
                #print_r ($post);
                #die();
                $ch       = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                $result   = curl_exec($ch);
                $res      = json_decode($result);

                if (isset($res[0]->status) && $res[0]->status == '1')
                {
                    $bean->is_sent_web = "1";
                    $bean->web_lead_id = $res[0]->userid;
                    #$GLOBALS['db']->Query("UPDATE leads_cstm SET web_id_c='".$res[0]->userid."' WHERE id_c='".$bean->id."'");	
                    if ($updateColumns)
                    {
                        #find ID of email address
                        #echo $sql6="SELECT ebr.bean_id,ebr.email_address_id,ea.id FROM `email_addr_bean_rel` ebr INNER JOIN email_addresses ea ON ebr.email_address_id = ea.id WHERE ea.deleted=0 AND ebr.deleted=0 AND ebr.bean_module='Leads' AND ea.email_address ='".$bean->email1."'";
                        $sql6   = "SELECT ebr.bean_id,ebr.email_address_id,ea.id,l.web_lead_id FROM `email_addr_bean_rel` ebr INNER JOIN email_addresses ea ON ebr.email_address_id = ea.id  INNER JOIN  leads l ON ebr.bean_id=l.id WHERE ea.deleted=0 AND ebr.deleted=0 AND ebr.bean_module='Leads' AND ea.email_address ='" . $bean->email1 . "'";
                        $email6 = $GLOBALS['db']->query($sql6);

                        while ($row6 = $GLOBALS['db']->fetchByAssoc($email6))
                        {
                            # ****update When Records When Email id Same ******	
                            #echo $ts="UPDATE leads SET ".$updateColumns." WHERE id='".$row6['bean_id']."'";
                            $GLOBALS['db']->Query("UPDATE leads SET " . $updateColumns . ",web_lead_id='" . $webid . "' WHERE id='" . $row6['bean_id'] . "'");
                            #$GLOBALS['db']->Query("UPDATE leads_cstm SET web_id_c='".$res[0]->userid."' WHERE id_c='".$row6['bean_id']."'");					
                        }
                    }
                }

                //curl_close($ch);  						
            }
        }*/
    }

    function addDispositionFunc($bean, $event, $argument)
    {
        ini_set('display_errors', "off");
        global $db,$current_user,$sugar_config;
        $db->query("delete from  session_call where  session_id='" . session_id() . "'");
#If record is being created manually
        if (!isset($_REQUEST['import_module']) && $_REQUEST['module'] != "Import")
        {
            // echo $bean->fetched_row['status'] . '='. $bean->status;die;
            if ($bean->fetched_row['status'] = '' || ($bean->fetched_row['status'] != $bean->status) || ($bean->fetched_row['status_description'] != $bean->status_description) || ($bean->status_description == 'Call Back' && $bean->fetched_row['date_of_callback'] != $bean->date_of_callback) || ($bean->status_description == 'Follow Up' && $bean->fetched_row['date_of_followup'] != $bean->date_of_followup) || ($bean->status_description == 'Prospect' && $bean->fetched_row['date_of_prospect'] != $bean->date_of_prospect))
            {


          
                
                $disposition = new te_disposition();

                $disposition->status        = $bean->status;
                $disposition->status_detail = $bean->status_description;
                if (isset($bean->note))
                {
                    $disposition->description = $bean->note;
                }
                $disposition->date_of_callback              = $bean->date_of_callback;
                $disposition->date_of_followup              = $bean->date_of_followup;
                $disposition->date_of_prospect              = $bean->date_of_prospect;
                $disposition->name                          = $bean->dispositionName;
                $disposition->dispositionName               = $bean->dispositionName;
                $disposition->calltype                      = $bean->callType;
		//$disposition->created_by                  =  $bean->created_by;
                //$disposition->assigned_user_id            =  $bean->assigned_user_id;
                //$disposition->modified_user_id            =  $bean->modified_user_id;
                $disposition->attempt_count                 = $bean->attempts_c;
                $disposition->te_disposition_leadsleads_ida = $bean->id;
                $xx                                         = $disposition->save();
                $created_byIDX                              = '';
                $assigned_user_IDX                          = '';
                $modified_user_IDX                          = '';
                $date_of_callbackX                          = '';
                $date_of_followupX                          = '';
                $date_of_prospectX                          = '';
                if ($xx != '')
                {
                    $getusrQery        = $db->query("SELECT date_of_callback,
                                                                date_of_followup,
                                                                date_of_prospect,
                                                                created_by,
                                                                assigned_user_id,
                                                                modified_user_id
                                                         FROM `leads`
                                                         WHERE `id`='" . $bean->id . "'");
                    $recordsData       = $db->fetchByAssoc($getusrQery);
                    $created_byIDX     = $recordsData['created_by'];
                    $assigned_user_IDX = $recordsData['assigned_user_id'];
                    $modified_user_IDX = $recordsData['modified_user_id'];
                    $date_of_callbackX = $recordsData['date_of_callback'];
                    $date_of_followupX = $recordsData['date_of_followup'];
                    $date_of_prospectX = $recordsData['date_of_prospect'];
                    
                    $sql               = "UPDATE `te_disposition`
                                                SET 
                                                   `created_by`='" . $created_byIDX . "',
                                                    modified_user_id='" . $modified_user_IDX . "',
                                                    assigned_user_id='" . $assigned_user_IDX . "',
                                                    date_of_callback='" . $date_of_callbackX . "'
                                                WHERE id ='" . $xx . "'";
                    $sqlData           = $GLOBALS['db']->query($sql);
                }

                $file = fopen(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) . "upload/apilog/check_user01.txt", "a");
                fwrite($file,'---------------------------'. "\n");
                fwrite($file, date('Y-m-d H:i:s') . "\n");
                fwrite($file, 'userId='.$_REQUEST['userId'] . "\n");
                //fwrite($file, print_r($current_user, TRUE) . "\n");
                fwrite($file, 'ameyo_import_login: '.$sugar_config['ameyo_import_login'] . "\n");
                fwrite($file, '$current_user: '.$current_user->id . "\n");
                fwrite($file, 'LeadID: '.$bean->id . "\n");
                fwrite($file, 'Assigned_user_id: '.$bean->assigned_user_id . "\n");
                fwrite($file, 'CreatedBy: '.$bean->created_by . "\n");
                fwrite($file, 'modified_user_id: '.$bean->modified_user_id  . "\n");
                fwrite($file, 'disp save id: '.$xx . "\n");
                fwrite($file, 'sqlQuery: '.$sql . "\n");
                fwrite($file, 'leadID: '.$bean->id . "\n");
                fclose($file);

                $sql     = " select dristi_request from leads WHERE id ='" . $bean->id . "'";
                $sqlData = $GLOBALS['db']->query($sql);

                if ($GLOBALS['db']->getRowCount($sqlData) > 0)
                {
                    $dristiReq = $GLOBALS['db']->fetchByAssoc($sqlData);
                    //echo $_SESSION['temp_for_newUser'];die;
                    if ($dristiReq && $dristiReq['dristi_request'] || $_SESSION['temp_for_newUser'])
                    {
                        $arrReq = (array) json_decode(html_entity_decode($dristiReq['dristi_request']));
                        if (!$arrReq)
                            $arrReq = (array) json_decode(html_entity_decode($_SESSION['temp_for_newUser']));

//$_SESSION['temp_for_newUser'];

                        if ($arrReq && count($arrReq) > 2)
                        {
                            $drobj = new te_Api_override();
                            global $current_user;


                            if ($bean->status_description == 'Call Back' || $bean->status_description == 'Follow Up' || $bean->status_description == 'Prospect')
                            {

                                $date = '';
                                if ($bean->status_description == 'Call Back')
                                    $date = $bean->date_of_callback;
                                if ($bean->status_description == 'Follow Up')
                                    $date = $bean->date_of_followup;
                                if ($bean->status_description == 'Prospect')
                                    $date = $bean->date_of_prospect;

                                // echo $date;die;

                                if ($date)
                                {
                                    $drobj->sendDisposition($bean->status_description, $arrReq, $GLOBALS['timedate']->to_display_date_time($date), $bean->id);
                                }
                                else
                                {
                                    $drobj->sendDisposition($bean->status_description, $arrReq, '', $bean->id);
                                }
                            }
                            else
                            {
                                $drobj->sendDisposition($bean->status_description, $arrReq, '', $bean->id);
                            }
                        }
                    }
                }


                //~ die;
            }
            /* * ************************ Mail 1Trigers Code 14Sep18 by MKG  Mail=> Not Interested ***************** */
            $useremail = $bean->email1;
            if (($bean->lead_source_types != "OO" && $bean->lead_source_types != "CO") && $bean->status_description == "Not Interested")
            {
                $template = "<p>Hi " . $bean->first_name . " " . $bean->last_name . ",</p>
                <p>We regret not having been able to help you with your query regarding " . $bean->batch_c . ".</p>
                <p>We do hope you will consider us to be your learning partner, should you decide to boost your skill set with online executive courses.</p>
                <p>Talentedge partners with leading academic Indian & International institutes – such as IIMs, MICA, XLRI, JWMI, SPJIR etc. to bring to working professionals industry relevant executive courses online.</p>
                <p> Delivered through a technologically advanced education platform, we offer Live & Interactive digital learning across popular domains.</p>
                </br>
                <p>Give us a call at +91-8376000600 or visit www.talentedge.in  and we will be happy to assist with </p><p>more information.</p>
                <p>Regards,</p>
                <p>Team Talentedge</p>";

                $mail = new NetCoreEmail();
                $mail->sendEmail2($useremail, "Team Talentedge", $template);
            }

            /** Mail2 => Fallout: ** */
            if (($bean->lead_source_types != "OO" && $bean->lead_source_types != "CO") && $bean->status_description == "Fallout")
            {
                $template = "<p>Hi " . $bean->first_name . " " . $bean->last_name . ",</p>
                <p>We are sorry to see you go from " . $bean->batch_c . " .</p>  
                <p>However, you can be sure that we will continue to bring to you the most industry relevant courses and do our best to help you fast-track your career.</p>
                <p>We hope you will consider us to be your learning partner whenever you decide to take up online executive courses.</p>
                <p>You can always give us a call at +91-8376000600 or visit www.talentedge.in ,if you need any assistance with your career.</p>
                </br> 
                <p>Regards,</p>
                <p>Team Talentedge</p>";
                $mail     = new NetCoreEmail();
                $mail->sendEmail2($useremail, "Leaving us already?", $template);
            }
            /** Triger Mail Mail3> Next batch: ** */
            if (($bean->lead_source_types != "OO" && $bean->lead_source_types != "CO") && $bean->status_description == "Next Batch")
            {

                $template = "<p>Hi " . $bean->first_name . " " . $bean->last_name . ",</p>
                <p>We hate to see you go.</p>  
                <p>While we will have other courses in this domain to offer, we cannot promise when this batch will
return, or if it will with the same curriculum or class schedule. </p>
                <p>Don't lose this great opportunity for you to transform your career. While the seats for the " . $bean->batch_c . " are filling up fast, we have a few left, if you still want to enrol in this batch.</p> 
                <p>Give us a call at +91-8376000600 and we will be happy to assist with more information. </p>
                </br> 
                <p>Regards,</p>
                <p>Team Talentedge</p>";
                $mail     = new NetCoreEmail();
                $mail->sendEmail2($useremail, "Until next time, fare well!", $template);
            }
            /** Triger Mail Mail4> Auto-retired: ** */
            if (($bean->lead_source_types != "OO" && $bean->lead_source_types != "CO") && $bean->status_description == "Auto Retired")
            {
                $template = "<p>Hi " . $bean->first_name . " " . $bean->last_name . ",</p>
                <p>We tried reaching you a few times, regarding your query for " . $bean->batch_c . ", but could not get through. </p>
                <p>Our courses have been rated to have a 92% satisfaction score by learners, with a referability rate of 78%.</p>
                <p> Live & interactive online sessions for each course are scheduled to suit the convenience of working professionals like you.</p>
                <p >Enrol now(to be linked with course page) to get certified from leading academic institutes.</p> <p>Give us a call back at +91-8376000600 for more information. </p>
                </br>
                <p>Regards,</p>
                <p>Team Talentedge</p>";

                $mail = new NetCoreEmail();
                $mail->sendEmail2($useremail, "Knock, knock! Are you there? ", $template);
            }
            /*             * *End */
        }
    }

    function sendWelcomEmail($email, $batch_id, $student_id, $student_name, $student_country, $attachment = "")
    {
        $paymentPlanSql = "SELECT sb.name as batch_name,s.name as payment_name,s.id,s.te_student_id_c,s.due_amount_inr,s.paid_amount_inr,s.paid,s.due_date,s.balance_inr,s.due_amount_usd,s.paid_amount_usd,s.balance_usd,s.description as notes FROM te_student_batch sb INNER JOIN te_student_batch_te_student_payment_plan_1_c rel ON sb.id=rel.te_student_batch_te_student_payment_plan_1te_student_batch_ida INNER JOIN `te_student_payment_plan` s ON s.id=rel.te_student9d1ant_plan_idb WHERE s.deleted=0 AND s.te_student_id_c='" . $student_id . "' AND sb.te_ba_batch_id_c='" . $batch_id . "' ORDER BY s.due_date";
        $paymentPlanObj = $GLOBALS['db']->Query($paymentPlanSql);

        $template   = '<p>Hello ' . $student_name . '</p>
			<p>Thanks for making payment.Please have a look on your payment details:</p>
			<table cellpadding="0" cellspacing="0" width="100%" border="1">
			<tr height="20">
				<th><strong>Batch</strong></th><th><strong>Payment</strong></th><th><strong>Due Amount</strong></th>
				<th><strong>Paid Amount</strong></th><th><strong>Paid</strong></th><th><strong>Balance Amount</strong></th><th>
				<strong>Notes</strong></th><th><strong>Due Date</strong></th>
			</tr>';
        $batch_name = 0;
        if ($student_country == "" || $student_country == "India" || $student_country == "india")
        {
            while ($row = $GLOBALS['db']->fetchByAssoc($paymentPlanObj))
            {
                $batch_name = $row['batch_name'];
                $template   .= '<tr height="20">
				   <td align="left" valign="top" >' . $row['batch_name'] . '</td>
				   <td align="left" valign="top" >' . $row['payment_name'] . '</td>
				   <td align="left" valign="top">' . $row['due_amount_inr'] . '</td>
				   <td align="left" valign="top" >' . $row['paid_amount_inr'] . '</td>
				   <td align="left" valign="top">' . $row['paid'] . '</td>
				   <td align="left" valign="top" >' . $row['balance_inr'] . '</td>
				   <td align="left" valign="top">' . $row['notes'] . '</td>
				   <td align="left" valign="top">' . $row['due_date'] . '</td>
				</tr>';
            }
        }
        else
        {
            while ($row = $GLOBALS['db']->fetchByAssoc($paymentPlanObj))
            {
                $batch_name = $row['batch_name'];
                $template   .= '<tr height="20">
				   <td align="left" valign="top" >' . $row['batch_name'] . '</td>
				   <td align="left" valign="top" >' . $row['payment_name'] . '</td>
				   <td align="left" valign="top">' . $row['due_amount_usd'] . '</td>
				   <td align="left" valign="top" >' . $row['paid_amount_usd'] . '</td>
				   <td align="left" valign="top">' . $row['paid'] . '</td>
				   <td align="left" valign="top" >' . $row['balance_usd'] . '</td>
				   <td align="left" valign="top">' . $row['notes'] . '</td>
				   <td align="left" valign="top">' . $row['due_date'] . '</td>
				</tr>';
            }
        }

        $template .= "</table>";
        $subject  = "Welcome in batch - " . $batch_name;
        $mail     = new NetCoreEmail();
        $mail->sendEmail($email, $subject, $template, $attachment);
    }

    function checkAmyoFunc($bean, $event, $argument)
    {

        //throw new SugarApiException("You can't edit or add disposition while calling", null, 'Leads', 550);
    }

    function checkduplicate($bean, $event, $argument)
    {
        ini_set('display_errors', "off");
        if (isset($_REQUEST['import_module']) && $_REQUEST['module'] == "Import")
            return false;
            
        if (isset($_REQUEST['entryPoint']) && $_REQUEST['entryPoint'] == "lead-genration") return false;    
            
        global $db, $current_user;
        $sql     = "select slug from acl_roles inner join acl_roles_users on acl_roles_users.role_id=acl_roles.id and user_id='" . $current_user->id . "' and acl_roles.deleted=0 and acl_roles_users.deleted=0";
        $mis     = $db->query($sql);
        $misData = $db->fetchByAssoc($mis);
        //echo 'p';die;
        if ($misData['slug'] == 'CCM' || $misData['slug'] == 'CCTL' || $misData['slug'] == 'CCH' || $current_user->is_admin == 1)
            return false;
            
        

        if ($bean->fetched_row['id'] == '')
        {
            $sql = "SELECT leads.id  as id,leads.assigned_user_id FROM leads INNER JOIN leads_cstm ON leads.id = leads_cstm.id_c ";
           /* if ($bean->email1 != "")
            {
                $sql .= " INNER JOIN email_addr_bean_rel ON email_addr_bean_rel.bean_id = leads.id AND email_addr_bean_rel.bean_module ='Leads' ";
                $sql .= " INNER JOIN email_addresses ON email_addresses.id =  email_addr_bean_rel.email_address_id ";
            }*/
            $sql .= " WHERE leads.deleted = 0 AND leads_cstm.te_ba_batch_id_c = '" . $bean->te_ba_batch_id_c . "' and status_description!='Duplicate' and leads.deleted=0 "; // AND DATE(date_entered) = '".date('Y-m-d')."'";
            if ($bean->phone_mobile && $bean->email1)
            {

                $sql .= " and ( leads.phone_mobile = '{$bean->phone_mobile}' or email_add_c = '{$bean->email1}')";
            }
            elseif (!$bean->phone_mobile && $bean->email1)
            {

                $sql .= " and email_add_c= '{$bean->email1}'";
            }
            elseif ($bean->phone_mobile && !$bean->email1)
            {
                $sql .= " and leads.phone_mobile = '{$bean->phone_mobile}'";
            }

            $re = $GLOBALS['db']->query($sql);
            if ($GLOBALS['db']->getRowCount($re) > 0)
            {
                echo '<script> alert("You can\'t add duplicate lead");callPage(); function callPage(){  window.location.href="index.php?module=Leads&action=ListView&record=' . $bean->id . '" } </script>';
                exit();
            }
        }


        if ($bean->fetched_row['status'] == 'Duplicate')
        {
            echo '<script> alert("You can\'t edit duplicate lead");callPage(); function callPage(){  window.location.href="index.php?module=Leads&action=DetailView&record=' . $bean->id . '" } </script>';
            exit();
        }
    }

}
