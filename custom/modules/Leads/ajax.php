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
    if (isset($Mobile) && $Mobile != '')
    {

        $sqlConditions .= " AND leads.phone_mobile Like '%$Mobile%' ";
    }

    if (isset($Email) && $Email != '')
    {

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
                        AND leads.status='Converted' limit 100
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
            $table              .= '<td><img src="custom/themes/default/images/phone.png" href="" onclick="clickToCall(' . $phone_mobile . ', \'' . $leadID . '\')" alt="" height="20" width="20"><td>';
            $table              .= "</tr>";
        }

        if ($db->getRowCount($usObj) == 0)
        {
            $table .= "<tr><td  align='center' style='border:1px solid red' colspan='6'>No Data Found!</td></td>";
        }

        $table .= '</table>';
        echo $table;
    }
    die;
}


if (isset($_POST['action']) && $_POST['action'] == 'seachLeadByDefaultSearch')
{
    global $db;
    $option = '';
    //RecordID: RecordID, RowID:RowID

    $Email  = $_POST['email_id'];
    $Mobile = $_POST['mobile_number'];
    $Fname  = $_POST['first_name'];
    $Lname  = $_POST['last_name'];
    $lead_id= "";
    //print_r($_REQUEST); die;
    $where    = "";
            $whereNew = '';
            // condition add krna h
//      name and email and mobile koi

            if (!empty($Fname))
            {
                if ($where != '')
                {
                    $where .= " OR (tbl1.first_name like '%" . $Fname . "')";
                }
                else
                {
                    $where .= "  (tbl1.first_name like '%" . $Fname . "')";
                }
            }

            if (!empty($lead_id))
            {
                if ($where != '')
                {
                    $where .= " OR (tbl1.id = '" . $lead_id . "')";
                }
                else
                {
                    $where .= "  (tbl1.id = '" . $lead_id . "')";
                }
            }

            if (!empty($Lname))
            {
                if ($where != '')
                {
                    $where .= " OR (tbl1.last_name like '" . $Lname . "%')";
                }
                else
                {
                    $where .= "  (tbl1.last_name like '%" . $Lname . "%')";
                }
            }
            if (!empty($Email))
            {
                if ($where != '')
                {
                    $where .= "  OR (tbl4.email_add_c like '" . $Email . "')";
                }
                else
                {
                    $where .= "  (tbl4.email_add_c like '" . $Email . "')";
                }
            }

            if (!empty($Mobile))
            {
                if ($where != '')
                {
                    $where .= "  OR (tbl1.phone_mobile like '" . $Mobile . "')";
                }
                else
                {
                    $where .= "  (tbl1.phone_mobile like '" . $Mobile . "')";
                }
            }
            if (strpos($where, 'tbl1.deleted') == false && $where != '')
            {
                $where .= " AND (tbl1.deleted=0) ";
            }
            if (!empty($where) && !empty($whereSRM))
            {
                $whereNew = " AND (tbl1.status = 'Converted')";
            }


            $fetch = "SELECT tbl1.id,
                    tbl1.salutation,
                    tbl1.phone_mobile,
                    tbl4.email_add_c AS email_address,
                    #tbl4.email_address,
                    tbl1.assigned_user_id,
                    tbl1.first_name,
                    tbl1.last_name,
                    tbl1.status,
                    tbl1.status_description,
                    tbl1.date_entered,
                    tbl1.lead_source,
                    tbl2.user_name,
                    tbl2.phone_mobile,
                    bb.batch_code,
                    bb.name batch_name
                    
             FROM leads AS tbl1
             LEFT JOIN leads_cstm AS tbl4 ON tbl1.id= tbl4.id_c
             LEFT JOIN users AS tbl2 ON tbl1.assigned_user_id = tbl2.id
             LEFT join te_ba_batch bb on tbl4.te_ba_batch_id_c=bb.id and bb.deleted=0
             WHERE  " . $where . " $whereNew
             LIMIT 0, 100";
            $usObj     = $db->query($fetch);
            //echo $fetch;die();
            
        $vendor_Options = array();
        $table          = '';
        $table          .= '<table>';
        $table          .= '<tr>
                <th>Name</th>
                <th>Status</th>
                <th>Sub Status</th>
                <th>Counsellor</th>               
                <th>Batch</th>               
                 <th>Batch Name</th>      
                </tr>';
        while ($row            = $db->fetchByAssoc($usObj))
        {
            //print_r($row);
            $leadID             = $row['id'];
            $userName           = $row['first_name'] . ' ' . $row['last_name'];
            $status             = $row['status'];
            $status_description = $row['status_description'];
            $agentName          = $row['user_name'];
            $batch_code         = $row['batch_code'];
            $batch_name              = $row['batch_name'];
            $phone_mobile       = $row['phone_mobile'];
            $table              .= "<tr><td>$userName</td><td>$status</td><td>$status_description</td><td>$agentName</td><td>$batch_code</td><td>$batch_name</td>";
            //$table              .= '<td><img src="custom/themes/default/images/phone.png" href="" onclick="clickToCall(' . $phone_mobile . ', \'' . $leadID . '\')" alt="" height="20" width="20"><td>';
            $table              .= "</tr>";
        }

        if ($db->getRowCount($usObj) == 0)
        {
            $table .= "<tr><td  align='center' style='border:1px solid red' colspan='6'>No Data Found!</td></td>";
        }

        $table .= '</table>';
        echo $table;
    }
  

?>
