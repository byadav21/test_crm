<?php

//Date: Created on : 27th SEP 2018

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');


//error_reporting(-1);
//ini_set('display_errors', 'On');

class LeadsViewutmleadassignmentrule extends SugarView
{

    var $report_to_id;
    var $counsellors_arr;

    public function __construct()
    {
        parent::SugarView();
    }

   
    function getVendors()
    {
        global $db;
        $vendorSql      = "SELECT id,name FROM te_vendor WHERE deleted=0 order by name";
        $vendor_Obj     = $db->query($vendorSql);
        $vendor_Options = array();
        while ($row            = $db->fetchByAssoc($vendor_Obj))
        {
            $vendor_Options[$row['id']] = $row['name'];
        }
        return $vendor_Options;
    }

    function getBatch()
    {
        global $db;
        $batchSql     = "SELECT id,batch_code FROM te_ba_batch WHERE batch_status='enrollment_in_progress' AND deleted=0 order by batch_code";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        while ($row          = $db->fetchByAssoc($batchObj))
        {
            $batchOptions[$row['id']] = $row['batch_code'];
        }
        return $batchOptions;
    }

    public function display()
    {

        global $sugar_config, $app_list_strings, $current_user, $db;


        $where      = "";
        $wherecl    = "";
        $campaignID = array();
        $leadID     = array();
     


        $error = array();
        
        $BatchListData = $this->getBatch();
        $VendorListData = $this->getVendors();
        
        
       $submit_button=''; $submit_export=''; $vendor=array(); $batch_code=array(); $campaign_id=''; $lead_id='';
        
        $submit_button     = isset($_POST['button'])? $_POST['button'] : '';
        $submit_export     = isset($_POST['export'])? $_POST['export'] : '';

        $left = '';
        
        



        
        //print_r($source_vendor); die;
        
        if (isset($submit_button))
        {

            $error        = array();
            $userArr      = array();
            $batchCodeArr = array();
            $monthArr     = array();
            $years        = '';
            $target_gsv   = '';
            $target_unit  = '';
            
            $source_vendor = isset($_POST['vendor']) ? $_POST['vendor'] : array();
            $batch_code    = isset($_POST['batch_code']) ? $_POST['batch_code'] : array();
            $campaign_id   = isset($_POST['campaign_id']) ? $_POST['campaign_id'] : '';
            $lead_id       = isset($_POST['lead_id']) ? $_POST['lead_id'] : '';

            


            if (!empty($source_vendor) && !empty($batch_code) && $campaign_id!='' && $lead_id!='')
            {
                //echo 'ss'; die;
                //print_r($batch_code); die;

                foreach ($source_vendor as $key => $val)
                {
                    //$insertSql = "INSERT INTO agent_productivity_report SET user_id='" . $value . "', user_name='',reporting_to='',status=1,created_date='" . date('Y-m-d H:i:s') . "' ";
                    //$GLOBALS['db']->Query($insertSql);

                    if (!empty($batch_code))
                    {

                        foreach ($batch_code as $key => $value_id)
                        {
                             $insertSql = "INSERT INTO source_lead_assignment_rule SET "
                                    . "source_id='" . $val . "', "
                                    . "source_name='" . $VendorListData[$val] . "',"
                                    . "batch_id='" . $value_id . "', "
                                    . "batch_code='" . $BatchListData[$value_id]. "', "
                                    . "campaign_id='$campaign_id',"
                                    . "lead_id='$lead_id',"
                                    . "created_by='$current_user->id',"
                                    . "status='1',"
                                    . "reg_date='" . date('Y-m-d H:i:s') . "'"; 
                            $GLOBALS['db']->Query($insertSql);
                        }
                    }
                  
                }
            }else
            {
                //echo 'Please input all fields.';
            }
        }

        $leadSql = "SELECT *
                     FROM source_lead_assignment_rule
                     where status=1 and deleted=0 order by reg_date desc";

        $leadObj = $db->query($leadSql) or die(mysqli_error());


        while ($row = $db->fetchByAssoc($leadObj))
        {

            $leadList[] = $row;
        }

        //echo '<pre>';
        //print_r($leadList);
        #PS @Pawan
        $total     = count($leadList); #total records
        $start     = 0;
        $per_page  = 60;
        $page      = 1;
        $pagenext  = 1;
        $last_page = ceil($total / $per_page);

        if (isset($_REQUEST['page']) && $_REQUEST['page'] > 0)
        {
            $start    = $per_page * ($_REQUEST['page'] - 1);
            $page     = ($_REQUEST['page'] - 1);
            $pagenext = ($_REQUEST['page'] + 1);
        }
        else
        {

            $pagenext++;
        }
        if (($start + $per_page) < $total)
        {
            $right = 1;
        }
        else
        {
            $right = 0;
        }
        if (isset($_REQUEST['page']) && $_REQUEST['page'] == 1)
        {
            $left = 0;
        }
        elseif (isset($_REQUEST['page']))
        {

            $left = 1;
        }

        $leadList = array_slice($leadList, $start, $per_page);
        if ($total > $per_page)
        {
            $current = "(" . ($start + 1) . "-" . ($start + $per_page) . " of " . $total . ")";
        }
        else
        {
            $current = "(" . ($start + 1) . "-" . count($leadList) . " of " . $total . ")";
        }
        #pE

        $sugarSmarty = new Sugar_Smarty();

        $sugarSmarty->assign("error", $error);
        $sugarSmarty->assign("leadList", $leadList);
        $sugarSmarty->assign("StatusList", $StatusList);
        $sugarSmarty->assign("leadList", $leadList);
        $sugarSmarty->assign("BatchListData", $BatchListData);
        $sugarSmarty->assign("VendorListData", $VendorListData);
        $sugarSmarty->assign("current_records", $current);
        $sugarSmarty->assign("page", $page);
        $sugarSmarty->assign("pagenext", $pagenext);
        $sugarSmarty->assign("right", $right);
        $sugarSmarty->assign("left", $left);
        $sugarSmarty->assign("last_page", $last_page);

        $sugarSmarty->display('custom/modules/Leads/tpls/utmleadassignmentrule.tpl');
    }

}
?>

