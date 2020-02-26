<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

error_reporting(-1);
ini_set('display_errors', 'On');

class checkRenquired
{

    function check_reenquired_leads(&$bean, $event, $argument)
    {
        global $db;
        $beanId             = $bean->id;
        $phone              = $bean->phone_mobile;
        $email              = $bean->email_add_c;
        $batchid            = $bean->te_ba_batch_id_c;
        $status             = $bean->status;
        $status_description = $bean->status_description;
        $disposition_reason = $bean->disposition_reason;
        $log_d_reason      = "";
        $reLeadArr         = array();
        
        if(!in_array($status, array('Dead','Converted'))){
            //echo 'sss';die;
            return;
        }

        if (($phone != '' || $email != '') && $batchid != '')
        {
            
            // (converted) Rule 1: “Dead>Re-Enquired>Enrolled candidate
            // (dead) Rule 2: “Dead>Re-Enquired>Duplicate lead”
            if($status=='Converted'){
                    $log_d_reason   =   'Enrolled candidate';
                }
            if($status=='Dead'){
                $log_d_reason   =   'Duplicate lead';
            }
            
            $sql=   "SELECT  leads.id AS id
                    FROM leads
                    INNER JOIN leads_cstm ON leads.id = leads_cstm.id_c 
                   WHERE leads.deleted = 0
                     AND leads_cstm.te_ba_batch_id_c = '$batchid'
                     AND status_description='Re-Enquired'
                     AND ( leads.phone_mobile = '$phone' or email_add_c = '$email')
                     AND leads.deleted=0" ; 
            //die($log_d_reason);
            $re = $GLOBALS['db']->query($sql);
            if ($GLOBALS['db']->getRowCount($re) > 0)
            {   
                
                 while ($row = $db->fetchByAssoc($re))
                    {
                        $reLeadAr[] = $row['id'];
                    }
                    
                $string    = implode("','", $reLeadAr);

                $assignSQL = "update leads set disposition_reason='$log_d_reason',date_modified='" . date('Y-m-d H:i:s') . "' where id in ('$string');"; 

                //echo '<pre>'; print_r($assignSQL);die;
                if (!empty($string) && !empty($log_d_reason))
                {
                    $query = $db->query($assignSQL);
                    
                    $this->createLog('{while Re-Enquired leads found:}', 're_enquired_level_three_' . date('Y-m-d') . '_log.txt',"(".$phone.'_'.$email.'_'.$batchid.")",$reLeadAr);
                }
                    
            
                
            }
        
        }
    }

    function createLog($action, $filename, $field = '', $dataArray = array())
    {
        $file = fopen(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) . "upload/apilog/$filename", "a");
        fwrite($file, date('Y-m-d H:i:s') . "\n");
        fwrite($file, $action . "\n");
        fwrite($file, $field . "\n");
        fwrite($file, print_r($dataArray, TRUE) . "\n");
        fclose($file);
    }

}
