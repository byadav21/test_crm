<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class UpdatePaymentName
{

    function UpdatePaymentFunc($bean, $event, $argument)
    {

        //echo "/var/www/html/aws/custom/modules/te_payment_details/UpdatePayment.php"; die;
        $paymentSqlE = "SELECT is_sent_web FROM `te_payment_details` WHERE id='" . $bean->id . "'";
        $paymentObjE = $GLOBALS['db']->Query($paymentSqlE);
        $paymentrowE = $GLOBALS['db']->fetchByAssoc($paymentObjE);
        if (isset($paymentrowE['is_sent_web']) && $paymentrowE['is_sent_web'] == 0)
        {
            //echo "/var/www/html/aws/custom/modules/te_payment_details/UpdatePayment.php"; die;
            $sql_batch   = "SELECT `discount_in_inr`,`discount_in_usd` FROM `te_ba_batch` WHERE id ='" . $_REQUEST['te_ba_batch_id_c'] . "'";
            $batchObj    = $GLOBALS['db']->Query($sql_batch);
            $resultbatch = $GLOBALS['db']->fetchByAssoc($batchObj);

            if ($_REQUEST['country_log'] == 'India')
            {
                if (($resultbatch['discount_in_inr'] != NULL || $resultbatch['discount_in_usd'] != NULL) && ($_REQUEST['discount'] != ''))
                {
                    $discountlead = $_REQUEST['discount'];
                }
                elseif (($resultbatch['discount_in_inr'] != NULL || $resultbatch['discount_in_usd'] != NULL) && ($_REQUEST['discount'] == ''))
                {
                    $discountlead = $resultbatch['discount_in_inr'];
                }
                elseif (($resultbatch['discount_in_inr'] == NULL || $resultbatch['discount_in_usd'] == NULL) && ($_REQUEST['discount'] != ''))
                {
                    $discountlead = $_REQUEST['discount'];
                }
                else
                {

                    $discountlead = '0';
                }
            }
            elseif ($_REQUEST['country_log'] == 'Other')
            {
                //echo $resultbatch['discount_in_usd'];
                if (($resultbatch['discount_in_inr'] != NULL || $resultbatch['discount_in_usd'] != NULL) && ($_REQUEST['discount'] != ''))
                {
                    $discountlead = $_REQUEST['discount'];
                }
                elseif (($resultbatch['discount_in_inr'] != NULL || $resultbatch['discount_in_usd'] != NULL) && ($_REQUEST['discount'] == ''))
                {
                    $discountlead = $resultbatch['discount_in_usd'];
                }
                elseif (($resultbatch['discount_in_inr'] == NULL || $resultbatch['discount_in_usd'] == NULL) && ($_REQUEST['discount'] != ''))
                {
                    $discountlead = $_REQUEST['discount'];
                }
                else
                {

                    $discountlead = '0';
                }
            }
            else
            {
                $discountlead = '0';
            }
        }

        //if (isset($_REQUEST['entryPoint']) && $_REQUEST['entryPoint'] == "web_lead_payment")
        if (isset($_REQUEST['entryPoint']) && ($_REQUEST['entryPoint'] == "web_lead_payment" || $_REQUEST['entryPoint'] == "migrate_student" ||  $_REQUEST['entryPoint'] == "migrate_student_payment"))
        {
            return true;
        }

        $lead_id = "";
        if (!empty($bean->name))
        {
            $sa = "UPDATE te_payment_details SET name='" . $bean->reference_number . "' WHERE id='" . $bean->id . "'";
            $GLOBALS['db']->query($sa);
        }

        $leadSql = "SELECT leads_te_payment_details_1leads_ida as lid FROM leads_te_payment_details_1_c WHERE leads_te_payment_details_1te_payment_details_idb = '" . $bean->id . "' AND deleted = 0";
        $relLead = $GLOBALS['db']->query($leadSql);

        if ($GLOBALS['db']->getRowCount($relLead) > 0)
        {

            $leadRow = $GLOBALS['db']->fetchByAssoc($relLead);
            $lead_id = $leadRow['lid'];
            $sqlRel  = "SELECT p.id FROM te_payment_details p INNER JOIN leads_te_payment_details_1_c lp ON p.id=lp.leads_te_payment_details_1te_payment_details_idb WHERE lp.leads_te_payment_details_1leads_ida='" . $leadRow['lid'] . "' AND p.payment_realized= 0 ";
            $rel     = $GLOBALS['db']->query($sqlRel);
            if ($GLOBALS['db']->getRowCount($rel) > 0)
            {
                $s = "UPDATE leads SET payment_realized_check=0 WHERE id='" . $leadRow['lid'] . "'";
                $GLOBALS['db']->query($s);
            }
            else
            {
                $s = "UPDATE leads SET payment_realized_check=1 WHERE id='" . $leadRow['lid'] . "'";
                $GLOBALS['db']->query($s);
            }
        }

        # if payment details is being updated. Update the same payment in student payment module
        //print_r($_REQUEST);    die();
        if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" && $_REQUEST['module'] != "Leads")
        {

            $GLOBALS['db']->query("UPDATE te_student_payment SET amount='" . $bean->amount . "',invoice_number='" . $bean->invoice_number . "',invoice_url='" . $bean->invoice_url . "',invoice_order_number='" . $bean->invoice_order_number . "' WHERE lead_payment_details_id='" . $_REQUEST['record'] . "'");

            #update student payment plan
            $paymentSql = "SELECT SUM(p.amount) as amount FROM te_payment_details p INNER JOIN leads_te_payment_details_1_c lp ON p.id=lp.leads_te_payment_details_1te_payment_details_idb WHERE lp.leads_te_payment_details_1leads_ida='" . $lead_id . "' AND p.payment_realized= 1 AND p.deleted=0";
            $paymentObj = $GLOBALS['db']->query($paymentSql);
            $paymentRes = $GLOBALS['db']->fetchByAssoc($paymentObj);

            $studentDetails   = $this->getStudentId($lead_id);
            $batch_id         = $this->getBatchId($lead_id);
            $student_batch_id = $this->getStudentBatchId($studentDetails['id'], $batch_id);
            if ($bean->payment_realized == 1)
            {
                $paymentDetails = array(
                    'batch_id'         => $batch_id,
                    'student_id'       => $studentDetails['id'],
                    'amount'           => $paymentRes['amount'],
                    'student_country'  => $studentDetails['country'],
                    'payment_source'   => $bean->payment_source,
                    'student_batch_id' => $student_batch_id
                );

                $this->removePaymentPlan($studentDetails['id'], $batch_id, $studentDetails['country']);
                $this->updateStudentPaymentPlan($paymentDetails);
            }
        }
        # WEB Payment Api
        $lead_user_details = [];
        if (isset($_REQUEST['Leads0emailAddress0']) && !empty($_REQUEST['Leads0emailAddress0']))
        {
            $lead_user_details['email_address']         = $_REQUEST['Leads0emailAddress0'];
            $lead_user_details['first_name']            = $_REQUEST['first_name'];
            $lead_user_details['last_name']             = $_REQUEST['last_name'];
            $lead_user_details['phone_mobile']          = $_REQUEST['phone_mobile'];
            $lead_user_details['te_ba_batch_id_c']      = $_REQUEST['te_ba_batch_id_c'];
            $lead_user_details['id']                    = $bean->id;
            $lead_user_details['lead_id']               = $lead_id;
            $lead_user_details['amount']                = $bean->amount;
            $lead_user_details['payment_realized']      = $bean->payment_realized;
            $lead_user_details['reference_number']      = $bean->reference_number . '&nbsp;' . $bean->transaction_id;
            $lead_user_details['payment_type']          = $bean->payment_type;
            $lead_user_details['date_of_payment']       = $bean->date_of_payment;
            $lead_user_details['discount']              = $discountlead;
            $lead_user_details['primary_address_state'] =($_REQUEST['primary_address_state'] != '') ? $_REQUEST['primary_address_state'] : 'AK';
            $lead_user_details['country_log']           = ($_REQUEST['country_log'] == 'India') ? 'IN' : 'US';
        }
        else
        {
            $lead_user_details                          = $this->get_lead_details($lead_id);
            $batch_id                                   = $this->getBatchId($lead_id);
            $lead_user_details['te_ba_batch_id_c']      = $batch_id;
            $lead_user_details['lead_id']               = $lead_id;
            $lead_user_details['id']                    = $bean->id;
            $lead_user_details['lead_id']               = $lead_id;
            $lead_user_details['amount']                = $bean->amount;
            $lead_user_details['payment_realized']      = $bean->payment_realized;
            $lead_user_details['reference_number']      = $bean->reference_number . '&nbsp;' . $bean->transaction_id;
            $lead_user_details['payment_type']          = $bean->payment_type;
            $lead_user_details['date_of_payment']       = $bean->date_of_payment;
            $lead_user_details['discount']              = $discountlead;
            $lead_user_details['primary_address_state'] = ($_REQUEST['primary_address_state'] != '') ? $_REQUEST['primary_address_state'] : 'AK';
            $lead_user_details['country_log']           = ($_REQUEST['country_log'] == 'India') ? 'IN' : 'US';
        }
        if ($lead_user_details)
        {

            $paymentSql = "SELECT * FROM `te_payment_details` WHERE id='" . $bean->id . "'";
            $paymentObj = $GLOBALS['db']->Query($paymentSql);
            $paymentrow = $GLOBALS['db']->fetchByAssoc($paymentObj);
            if (isset($paymentrow['is_sent_web']) && $paymentrow['is_sent_web'] == 0)
            {
                #add api
                $this->addpayment_curl($lead_user_details);
            }
            else
            {
                #update api
                $this->updatepayment_curl($lead_user_details);
            }
        }
    }

    /* ------------------- stop syncing from crm to web for payment */
    
   function createLog($action, $filename, $field = '', $dataArray = array())
        {
            $file = fopen(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) . "upload/apilog/$filename", "a");
            fwrite($file, date('Y-m-d H:i:s') . "\n");
            fwrite($file, $action . "\n");
            fwrite($file, $field . "\n");
            fwrite($file, print_r($dataArray, TRUE) . "\n");
            fclose($file);
        }

    function addpayment_curl($lead_user_details)
    {
        global $sugar_config;
        $user     = 'talentedgeadmin';
        $password = 'Inkoniq@2016';
        //$url      = 'https://talentedge.in/order-api/';
        $url      = $sugar_config['website_URL'] . '/order-api/';
        $headers  = array(
            'Authorization: Basic ' . base64_encode("$user:$password")
        );
        $post     = [
            'action'                => 'add',
            'user_email'            => $lead_user_details['email_address'],
            'first_name'            => $lead_user_details['first_name'],
            'mobile'                => $lead_user_details['phone_mobile'],
            'lead_id'               => $lead_user_details['lead_id'],
            'batch_crmid'           => $lead_user_details['te_ba_batch_id_c'],
            'order_total'           => $lead_user_details['amount'],
            'order_currency'        => 'INR',
            'payment_method'        => $lead_user_details['payment_type'],
            'payment_date'          => $lead_user_details['date_of_payment'],
            'payment_realized'      => $lead_user_details['payment_realized'],
            'payment_referencenum'  => $lead_user_details['reference_number'],
            'crm_orderid'           => $lead_user_details['id'],
            'discount_for'          => $lead_user_details['email_address'],
            'discount'              => $lead_user_details['discount'],
            'primary_address_state' => $lead_user_details['primary_address_state'],
            'country_log'           => $lead_user_details['country_log'],
        ];
        //echo '<pre>'; print_r($post); die;
	//$this->createLog('{In Add Case}', 'send_payment_info_web_log_'.date('Y-m-d').'.txt', $url, $lead_user_details);


        $ch     = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $result = curl_exec($ch);
        $res    = json_decode($result,TRUE);
	$this->createLog('{In Add Case}', 'send_payment_info_web_log_'.date('Y-m-d').'.txt', '', $post);
        $this->createLog('{In Add api response}', 'send_payment_info_web_log_'.date('Y-m-d').'.txt', '', $result);
        if (isset($res[0]->status) && $res[0]->status == '1')
        {
            $insertRelSql = "UPDATE te_payment_details SET is_sent_web=1 Where id='" . $lead_user_details['id'] . "'";
            $GLOBALS['db']->Query($insertRelSql);
        }

        curl_close($ch);
    }

    function updatepayment_curl($lead_user_details)
    {
        global $sugar_config;
        $user     = 'talentedgeadmin';
        $password = 'Inkoniq@2016';
        $url      = $sugar_config['website_URL'] . '/order-api/';
        $headers  = array(
            'Authorization: Basic ' . base64_encode("$user:$password"),
        );
        $post     = [
            'action'               => 'update',
            'crm_orderid'          => $bean->id,
            'batch_crmid'          => $lead_user_details['te_ba_batch_id_c'],
            'order_total'          => $bean->amount,
            'order_currency'       => 'INR',
            'payment_method'       => $bean->payment_source,
            'payment_date'         => $bean->date_of_payment,
            'payment_realized'     => $bean->payment_realized,
            'payment_referencenum' => $bean->reference_number,
            'discount_for'         => $lead_user_details['email_address'],
            'discount'             => $lead_user_details['discount'],
        ];
        $ch       = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 50);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $result   = curl_exec($ch);
        $res      = json_decode($result,TRUE);
        $this->createLog('{In Update Case}', 'send_payment_info_web_log_'.date('Y-m-d').'.txt', '', $lead_user_details);
        $this->createLog('{In Update api response}', 'send_payment_info_web_log_'.date('Y-m-d').'.txt', '', $result);

        curl_close($ch);
    }

    /* */

    function get_lead_details($lead_id)
    {
    $leadSql = "SELECT  lc.email_add_c email_address,
                        l.first_name,
                        l.last_name,
                        l.phone_mobile
                 FROM `leads` l
                 INNER JOIN leads_cstm lc ON l.id= lc.id_c
                 WHERE l.id='" . $lead_id . "'";

    //$leadSql = "SELECT e.email_address,leads.first_name,leads.last_name,leads.phone_mobile FROM `email_addr_bean_rel` AS eabr INNER JOIN email_addresses as e ON e.id=eabr.`email_address_id` INNER JOIN leads ON leads.id=eabr.`bean_id` WHERE eabr.`bean_id`='" . $lead_id . "' AND eabr.`bean_module`='Leads' LIMIT 0,1";
    $leadObj = $GLOBALS['db']->Query($leadSql);
    $row     = $GLOBALS['db']->fetchByAssoc($leadObj);
    return $row;
    }

    function removePaymentPlan($student_id, $batch_id, $student_country)
    {
        if (empty($student_country) || strtolower($student_country) == "india")
        {
            $paymentPlanSql = "SELECT s.name as student_name,s.email,s.mobile,sb.name as batch_name,sp.name,sp.id,sp.te_student_id_c,sp.due_amount_inr,sp.paid_amount_inr,sp.paid,sp.due_date,sp.currency FROM te_student_batch sb INNER JOIN te_student_batch_te_student_payment_plan_1_c rel ON sb.id=rel.te_student_batch_te_student_payment_plan_1te_student_batch_ida INNER JOIN `te_student_payment_plan` sp ON sp.id=rel.te_student9d1ant_plan_idb INNER JOIN te_student s ON sp.te_student_id_c=s.id WHERE sp.deleted=0 AND sp.te_student_id_c='" . $student_id . "' AND sb.te_ba_batch_id_c='" . $batch_id . "' ORDER BY sp.due_date";
            $paymentPlanObj = $GLOBALS['db']->Query($paymentPlanSql);
            while ($row            = $GLOBALS['db']->fetchByAssoc($paymentPlanObj))
            {
                $GLOBALS['db']->Query("UPDATE te_student_payment_plan SET paid_amount_inr=0,balance_inr=total_amount,paid='No' WHERE id='" . $row['id'] . "'");
            }
        }
        else
        {
            # Payment for non indian student will be on USD
            $paymentPlanSql = "SELECT s.name as student_name,s.email,s.mobile,sb.name as batch_name,sp.name,sp.id,sp.te_student_id_c,sp.due_amount_usd,sp.paid_amount_usd,sp.paid,sp.due_date,sp.currency FROM te_student_batch sb INNER JOIN te_student_batch_te_student_payment_plan_1_c rel ON sb.id=rel.te_student_batch_te_student_payment_plan_1te_student_batch_ida INNER JOIN `te_student_payment_plan` sp ON sp.id=rel.te_student9d1ant_plan_idb INNER JOIN te_student s ON sp.te_student_id_c=s.id WHERE sp.deleted=0 AND sp.te_student_id_c='" . $student_id . "' AND sb.te_ba_batch_id_c='" . $batch_id . "' ORDER BY sp.due_date";
            $paymentPlanObj = $GLOBALS['db']->Query($paymentPlanSql);
            while ($row            = $GLOBALS['db']->fetchByAssoc($paymentPlanObj))
            {
                $GLOBALS['db']->Query("UPDATE te_student_payment_plan SET paid_amount_usd=0,balance_usd=total_amount,paid='No' WHERE id='" . $row['id'] . "'");
            }
        }
    }

    function updateStudentPaymentPlan($paymentDetails)
    {
        #Service Tax deduction
        //echo 'updateStudentPaymentPlan'; die;
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

            $service_tax = getTaxStatus($student_id);
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
        }
    }

    public function getStudentId($leadId)
    {
        $studentSql = "SELECT s.id,s.country FROM te_student AS s INNER JOIN te_student_te_student_batch_1_c AS sbr ON sbr.te_student_te_student_batch_1te_student_ida=s.id INNER JOIN te_student_batch AS sb ON sb.id=sbr.te_student_te_student_batch_1te_student_batch_idb WHERE s.deleted=0 AND sb.leads_id='" . $leadId . "'";
        $studentObj = $GLOBALS['db']->query($studentSql);
        $student    = $GLOBALS['db']->fetchByAssoc($studentObj);
        return $student;
    }

    public function getBatchId($leadId)
    {
        $studentSql = "SELECT te_ba_batch_id_c  FROM leads_cstm WHERE id_c='" . $leadId . "'";
        $studentObj = $GLOBALS['db']->query($studentSql);
        $student    = $GLOBALS['db']->fetchByAssoc($studentObj);
        return $student['te_ba_batch_id_c'];
    }

    public function getStudentBatchId($student_id, $batch_id)
    {
        $studentBatchSql = "SELECT sb.id as student_batch_id FROM te_student_te_student_batch_1_c sbr INNER JOIN te_student_batch sb ON sbr.te_student_te_student_batch_1te_student_batch_idb=sb.id  WHERE sb.deleted=0 AND sbr.te_student_te_student_batch_1te_student_ida='" . $student_id . "' AND sb.te_ba_batch_id_c='" . $batch_id . "'";
        $studentBatchObj = $GLOBALS['db']->query($studentBatchSql);
        $studentBatch    = $GLOBALS['db']->fetchByAssoc($studentBatchObj);
        return $studentBatch['student_batch_id'];
    }

}
