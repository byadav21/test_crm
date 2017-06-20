<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');

class AOR_ReportsViewBatchwisereferals extends SugarView
{

    public function __construct()
    {
        parent::SugarView();
    }

    function getBatch()
    {
        global $db;
        $batchSql     = "SELECT id,name from te_ba_batch WHERE deleted=0 AND batch_status<>'Closed'";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        while ($row          = $db->fetchByAssoc($batchObj))
        {
            $batchOptions[] = $row;
        }
        return $batchOptions;
    }

    function getConverted($users)
    {

        global $sugar_config, $app_list_strings, $current_user, $db;


        $leadQuery = '';
        $users     .= substr($users, 0, strlen($users) - 1);
        $sql       = "SELECT COUNT(leads.id) AS CONV, leads_cstm.te_ba_batch_id_c  batch_id ";
        $sql       .= "FROM leads ";
        $sql       .= "INNER JOIN leads_cstm ON leads_cstm.id_c=leads.id ";
        $sql       .= "AND leads.deleted=0 ";
        if (!is_admin($current_user) && $users)
            $sql       .= " and assigned_user_id in ($users)";
        $sql       .= "AND leads.status='Converted' ";

        $sql                 .= "GROUP BY leads_cstm.te_ba_batch_id_c";
        $leadsDataConverteds = $db->query($sql);
        $leadData            = array();

        while ($row = $db->fetchByAssoc($leadsDataConverteds))
        {
            $leadData[$row['batch_id']] = $row['CONV'];
        }


        return $leadData;
    }

    function getReferalls($users, $converted = '')
    {

        global $sugar_config, $app_list_strings, $current_user, $db;

        $leadQuery = '';
        $flag      = '';
        if ($converted == 'True')
        {
            $flag = " AND leads.status='Converted' ";
        }
        $users .= substr($users, 0, strlen($users) - 1);

        $sql       = "SELECT COUNT(leads.id) AS CONV, leads_cstm.te_ba_batch_id_c as batch_id ";
        $sql       .= "FROM leads ";
        $sql       .= "INNER JOIN leads_cstm ON leads_cstm.id_c=leads.id ";
        $sql       .= "AND leads.deleted=0 ";
        $sql       .= "AND leads.parent_type='Leads' ";
        $sql       .= $flag;
        if (!is_admin($current_user) && $users)
            $leadQuery .= " and assigned_user_id in ($users)";
        $sql       .= "AND (leads.parent_id IS NOT NULL OR leads.parent_id!='' ) ";
        $sql       .= "GROUP BY leads_cstm.te_ba_batch_id_c";


        $referalQuery = $db->query($sql);

        while ($row = $db->fetchByAssoc($referalQuery))
        {
            $leadData[$row['batch_id']] = $row['CONV'];
        }
        //print_r($leadData);

        return $leadData;
    }

    function getGSV($user_id)
    {
        global $sugar_config, $app_list_strings, $current_user, $db;
        $batchSql = " SELECT id,fees_inr FROM `te_ba_batch`  WHERE deleted=0 AND batch_status<>'Closed' ";
        $batchObj = $db->query($batchSql);

        $batchData = array();

        while ($row = $db->fetchByAssoc($batchObj))
        {
            $batchData[$row['id']] = $row['fees_inr'];
        }


        return $batchData;
    }

    #############################################################

    public function display()
    {

        global $sugar_config, $app_list_strings, $current_user, $db;
        $leadsData = array();
        $user_id   = $current_user->id;

        $this->report_to_id[] = $user_id;

        $batchList = $this->getBatch();
        $uid       = $this->report_to_id;

        $users = '';
        foreach ($uid as $Usr)
        {
            $users = "'$Usr',";
        }
        $leadQuery = '';
        $users     .= substr($users, 0, strlen($users) - 1);

        $ConvertedArr = $this->getConverted($users);
        $ReferalsArr  = $this->getReferalls($users);
        $RcArr        = $this->getReferalls($users, 'True');
        $gsvArr       = $this->getGSV($users);


        $_SESSION['us_batch'] = $_REQUEST['batch'];
        $where                = '';
        if (!empty($_SESSION['us_batch']))
        {

            $where .= "AND te_ba_batch.id IN('" . implode("','", $_SESSION['us_batch']) . "') ";
        }
        $sql       = "SELECT te_ba_batch.id,te_ba_batch.name,count(leads.id) AS TotalLead ,fees_inr ";
        $sql       .= "FROM leads ";
        $sql       .= "INNER JOIN leads_cstm ON leads_cstm.id_c=leads.id ";
        $sql       .= "AND leads_cstm.te_ba_batch_id_c!='' ";
        $sql       .= "AND leads.deleted=0 ";
        if (!is_admin($current_user) && $users)
            $leadQuery .= " and assigned_user_id in ($users)";
        $sql       .= "INNER JOIN te_ba_batch ON leads_cstm.te_ba_batch_id_c=te_ba_batch.id $where ";
        $sql       .= "GROUP BY te_ba_batch.id,te_ba_batch.name,fees_inr ";
        $sql       .= "HAVING totalLead >0 ";

        $leadObj       = $db->query($sql);
        $councelorList = array();

        $i   = 0;
        while ($row = $db->fetchByAssoc($leadObj))
        {
            $rPercentage = (($RcArr[$row['id']] * 100) / $row['TotalLead']);

            $councelorList[$row['id']]['id']           = $row['id'];
            $councelorList[$row['id']]['name']         = $row['name'];
            $councelorList[$row['id']]['TotalLead']    = $row['TotalLead'];
            $councelorList[$row['id']]['converted']    = isset($ConvertedArr[$row['id']]) ? $ConvertedArr[$row['id']] : 0;
            $councelorList[$row['id']]['referalls']    = isset($ReferalsArr[$row['id']]) ? $ReferalsArr[$row['id']] : 0;
            $councelorList[$row['id']]['rc']           = isset($RcArr[$row['id']]) ? $RcArr[$row['id']] : 0;
            $councelorList[$row['id']]['rpercentage']  = number_format($rPercentage, 1);
            $councelorList[$row['id']]['Referals_GSV'] = number_format($gsvArr[$row['id']] * $RcArr[$row['id']], 2);
            $councelorList[$row['id']]['fees_inr']     = number_format($gsvArr[$row['id']] * $row['TotalLead'], 2);
           
           
           
            
            

            $i++;
        }

        //echo '<pre>'; print_r($councelorList); die;

        if (isset($_POST['export']) && $_POST['export'] == "Export")
        {
            $data     = "Batch, Total Lead, Converted, Referals,Referals Converted,Rererals Percentage,Referals GSV, GSV By\n";
            $file     = "batch_wise_referals_report";
            $filename = $file . "_" . date("Y-m-d");
            foreach ($councelorList as $key => $councelor)
            {
               
                $data .= "\"" . $councelor['name'] . "\",\"" . $councelor['TotalLead'] . "\",\"" . $councelor['converted'] . "\",\"" . $councelor['referalls'] . "\",\"" .$councelor['rc'] . "\",\"" .$councelor['rpercentage'] . "\",\"" .$councelor['Referals_GSV'] . "\",\"" . $councelor['fees_inr'] . "\"\n";
            }
            ob_end_clean();
            header("Content-type: application/csv");
            header('Content-disposition: attachment;filename=" ' . $filename . '.csv";');
            echo $data;
            exit;
        }


        $sugarSmarty = new Sugar_Smarty();
        $sugarSmarty->assign("batchList", $batchList);
        $sugarSmarty->assign("councelorList", $councelorList);
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/batchwisereferals.tpl');
        ?>
        
        <script>
        
                $('#BatchWiseTableId').DataTable();
//                $('#BatchWiseTableId').dataTable({
//                    "aoColumnDefs": [{'bSortable': false, 'aTargets': [1]}],
//                    "order": [[0, "desc"]],
//                    'iDisplayLength': 10,
//                    language: {
//                        search: "_INPUT_",
//                        searchPlaceholder: "Search Here..."
//                    }
//                });
               
     
        </script>
        <link type="text/css" href="custom/modules/AOR_Reports/include/css/jquery_dataTable.css" rel="stylesheet" />
        <?php
    }

}

?>
