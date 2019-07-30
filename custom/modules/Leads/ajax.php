<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
ini_set('display_errors', '1');

error_reporting(E_ALL);
global $app_list_strings, $current_user, $sugar_config, $db;


if (isset($_POST['action']) && $_POST['action'] == 'seachLeadByMobileFollowup')
{
    global $db;
    $option = '';
    //RecordID: RecordID, RowID:RowID

    $Email  = $_POST['Email'];
    $Mobile = $_POST['Mobile'];
    
    $sqlConditions = '';
    if(isset($Mobile) && $Mobile!=''){
        
        $sqlConditions .= " AND leads.phone_mobile Like '%$Mobile%' ";
    }
    
    if(isset($Email) && $Email!=''){
        
        $sqlConditions .= " AND lc.email_add_c  like '%$Email%' ";
    }

    if ($Email != '' || $Mobile != '')
    {
        $updateSql = "select
                            leads.id,
                            leads.date_entered,
                            leads.assigned_user_id,
                            users.user_name,
                            leads.first_name,
                            leads.last_name,
                            leads.phone_mobile,
                            lc.email_add_c,
                            bb.batch_code,
                            bb.name,
                            leads.status,
                            leads.status_description
                        from leads 
                        inner join leads_cstm lc on leads.id=lc.id_c 
                        inner join te_ba_batch bb on lc.te_ba_batch_id_c=bb.id
                        LEFT  JOIN users ON leads.assigned_user_id =users.id
                        where
                        leads.deleted =0 
                        AND bb.deleted=0
                        $sqlConditions
                        AND leads.status='Converted'
                        ";
        $usObj     = $db->query($updateSql);

        $vendor_Options = array();
        $table          = '';
        $table          .= '<table>';
        $table          .= '<tr>
                <th>Name</th>
                <th>Sub Status</th>
                <th>Counsellor</th>               
                <th>Batch</th>               
                <th>Phone</th>  
                <th>Call</th>       
                </tr>';
        while ($row            = $db->fetchByAssoc($usObj))
        {
            //print_r($row);
            $leadID             = $row['id'];
            $userName           = $row['first_name'] . ' ' . $row['last_name'];
            $status_description = $row['status_description'];
            $agentName          = $row['user_name'];
            $batch_code         = $row['batch_code'];
            $phone              = $row['batch_code'];
            $phone_mobile       = $row['phone_mobile'];
            $table              .= "<tr><td>$userName</td><td>$status_description</td><td>$agentName</td><td>$batch_code</td><td>$phone_mobile</td>";
            $table              .= '<td><img src="custom/themes/default/images/phone.png" href="" onclick="clickToCall('.$phone_mobile.', \''.$leadID.'\')" alt="" height="20" width="20"><td>';
            $table              .= "</tr>";
        }

        $table .= '</table>';
        echo $table;
    }
    die;
}
?>
