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
        $batchSql     = "SELECT b.name,b.id FROM te_ba_batch AS b GROUP BY b.id";
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

        $sql       = "SELECT COUNT(leads.id) AS CONV, leads_cstm.te_ba_batch_id_c,fees_inr as batch_id ";
        $sql       .= "FROM leads ";
        $sql       .= "INNER JOIN leads_cstm ON leads_cstm.id_c=leads.id ";
        $sql       .= "AND leads.deleted=0 ";
        $sql       .= "AND leads.parent_type='Leads' ";
        $sql       .= $flag;
        if (!is_admin($current_user) && $users)
            $leadQuery .= " and assigned_user_id in ($users)";
        $sql       .= "AND (leads.parent_id IS NOT NULL OR leads.parent_id!='' ) ";
       echo $sql       .= "GROUP BY leads_cstm.te_ba_batch_id_c";


        $referalQuery = $db->query($sql);

        while ($row = $db->fetchByAssoc($referalQuery))
        {
            $leadData[$row['batch_id']] = $row['CONV'];
        }
        //print_r($leadData);

        return $leadData;
    }

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
        $RcArr  = $this->getReferalls($users,'True');

        //echo '<pre>'; print_r($RcArr); die;
        

        $leadQuery = "select te_ba_batch.id,te_ba_batch.name,count(leads.id) as TotalLead ,fees_inr  from leads inner join leads_cstm on leads_cstm.id_c=leads.id and leads_cstm.te_ba_batch_id_c!='' and leads.deleted=0   ";
        if (!is_admin($current_user) && $users)
            $leadQuery .= " and assigned_user_id in ($users)";
        $leadQuery .= " inner join te_ba_batch on leads_cstm.te_ba_batch_id_c=te_ba_batch.id
		group by te_ba_batch.id,te_ba_batch.name,fees_inr having totalLead >0 order by totalLead desc ";

        $leadObj = $db->query($leadQuery);



        $councelorList = array();

        $i   = 0;
        while ($row = $db->fetchByAssoc($leadObj))
        {
            $rPercentage= (($ReferalsArr[$row['id']]*100)/$row['TotalLead']);
            
            $councelorList[$row['id']]['id']        = $row['id'];
            $councelorList[$row['id']]['name']      = $row['name'];
            $councelorList[$row['id']]['TotalLead'] = $row['TotalLead'];
            $councelorList[$row['id']]['fees_inr']  = $row['fees_inr'];
            $councelorList[$row['id']]['converted'] = isset($ConvertedArr[$row['id']]) ? $ConvertedArr[$row['id']] : 0;
            $councelorList[$row['id']]['referalls'] = isset($ReferalsArr[$row['id']]) ? $ReferalsArr[$row['id']] : 0;
            $councelorList[$row['id']]['rc'] = isset($RcArr[$row['id']]) ? $RcArr[$row['id']] : 0;
            $councelorList[$row['id']]['rpercentage'] = number_format($rPercentage,1) ;

            $i++;
        }

        //echo '<pre>'; print_r($councelorList); die;

        if (isset($_POST['export']) && $_POST['export'] == "Export")
        {
            $data     = "Batch, Total Lead, Converted, Referals, GSV By\n";
            $file     = "refferal_report";
            $filename = $file . "_" . date("Y-m-d");
            foreach ($councelorList as $key => $councelor)
            {
                if ($councelor['refby'] == 'Users')
                {
                    $ref_person = $councelor['refru'];
                }
                else
                {
                    $ref_person = $councelor['refrl'];
                }
                $data .= "\"" . $councelor['name'] . "\",\"" . $councelor['TotalLead'] . "\",\"" . $councelor['converted'] . "\",\"" . $councelor['referalls'] . "\",\"" . $councelor['fees_inr'] . "\"\n";
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
    }

}

?>
