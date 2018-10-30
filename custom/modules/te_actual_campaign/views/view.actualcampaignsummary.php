<?php

// Date: Created on : 27th FEB 2018

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
ini_set('memory_limit', '1024M');

require_once('custom/modules/AOR_Reports/leads_utility.php');
require_once('custom/modules/AOR_Reports/UserInput.php');

//error_reporting(-1);
//ini_set('display_errors', 'On');

class te_actual_campaignViewactualcampaignsummary extends SugarView
{

    var $report_to_id;
    var $counsellors_arr;

    public function __construct()
    {
        parent::SugarView();
        $this->_objInputs = new UserInput();
        //$this->_objInputs->syncSessions('leadUtilizationReport');
    }

    function getBatch()
    {
        global $db;
        $batchSql     = "SELECT id,
                                name,
                                batch_code,
                                d_campaign_id,
                                d_lead_id
                         FROM te_ba_batch
                         WHERE batch_status='enrollment_in_progress'
                           AND deleted=0
                         ORDER BY name";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        while ($row          = $db->fetchByAssoc($batchObj))
        {
            $batchOptions[] = $row;
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
        $error      = array();
        $findBatch  = array();
        $leadList   = array();
        $StatusList = array();

        $left          = 0;
        $BatchListData = $this->getBatch();







        $selected_from_date = $this->_objInputs->getVal('from_date', 'post');
        $fromDateFormatted  = ($selected_from_date != '') ? date('Y-m-d', strtotime(str_replace('/', '-', $selected_from_date))) : '';
        $selected_to_date   = $this->_objInputs->getVal('to_date', 'post');
        $toDateFormatted    = ($selected_to_date != '') ? date('Y-m-d', strtotime(str_replace('/', '-', $selected_to_date))) : '';


        if ($selected_from_date != '')
        {
            $wherecl .= " AND DATE(tac.date_entered) >= '" . $fromDateFormatted . "'";
        }


        if ($selected_to_date != '')
        {
            $wherecl .= " AND DATE(tac.date_entered) <= '" . $toDateFormatted . "' ";
        }




        $selected_batch_code = $this->_objInputs->getVal('batch_code', 'post', array());
        $selected_source     = $this->_objInputs->getVal('source', 'post', array());
        $selected_status     = $this->_objInputs->getVal('status', 'post', array());




        if (!empty($selected_batch_code))
        {
            $wherecl .= " AND  bb.id IN ('" . implode("','", $selected_batch_code) . "')";
        }






        $leadSql = "SELECT bb.batch_code,
                         bb.name,
                          v.name as vendor_name,
                         sum(tac.total_cost) AS total_cost
             FROM te_actual_campaign tac
             INNER JOIN `te_ba_batch` bb ON tac.te_ba_batch_id_c=bb.id
             left join te_vendor v on tac.vendor_id=v.id
             WHERE bb.deleted=0
               AND tac.deleted=0 $wherecl
             GROUP BY bb.id order by tac.date_entered desc";

        //echo $leadSql;
        $leadObj = $db->query($leadSql) or die(mysqli_error());

        $leadList = [];
        $current  = '';
        while ($row      = $db->fetchByAssoc($leadObj))
        {

            $addrows = $row;

            $addrows['batch_code']  = strtoupper($row['batch_code']);
            $addrows['name']        = strtoupper($row['name']);
            $addrows['vendor_name'] = ($row['vendor_name']) ? strtoupper($row['vendor_name']) : 'N/A';
            $leadList[]             = $addrows;
        }


        if (isset($_REQUEST['export']))
        {


            $data     = "Batch Code, vendor, Cost\n";
            $file     = "actual_report_campaign";
            $filename = $file . "_" . date("Y-m-d");
            foreach ($leadList as $key => $councelor)
            {

                $data .= "\"" . $councelor['batch_code'] . "\",\"" . $councelor['vendor_name'] . "\",\"" . $councelor['total_cost'] . "\"\n";
            }
            ob_end_clean();
            header("Content-type: application/csv");
            header('Content-disposition: attachment;filename=" ' . $filename . '.csv";');
            echo $data;
            exit;
        }



//        $objBenchMarking->end('overall');
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
        $sugarSmarty->assign("BatchListData", $BatchListData);
        $sugarSmarty->assign("StatusList", $StatusList);
        $sugarSmarty->assign("leadList", $leadList);
        $sugarSmarty->assign("selected_batch_code", $selected_batch_code);
        $sugarSmarty->assign("selected_from_date", $selected_from_date);
        $sugarSmarty->assign("selected_to_date", $selected_to_date);

        $sugarSmarty->assign("selected_status", $selected_status);

        $sugarSmarty->assign("current_records", $current);
        $sugarSmarty->assign("page", $page);
        $sugarSmarty->assign("pagenext", $pagenext);
        $sugarSmarty->assign("right", $right);
        $sugarSmarty->assign("left", $left);
        $sugarSmarty->assign("last_page", $last_page);
        $sugarSmarty->display('custom/modules/te_actual_campaign/tpls/actualcampaignsummary.tpl');
    }

}
?>

