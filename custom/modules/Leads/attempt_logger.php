<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
ini_set('display_errors', '1');

error_reporting(E_ALL);
global $app_list_strings, $current_user, $sugar_config, $db;


if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'getLogger')
{
    $lead_id = $_REQUEST['lead_id'];
    $query_logger = "SELECT * FROM `attempt_log` WHERE `lead_id`='$lead_id' order by reg_date";
    $res     = $db->query($query_logger);
    

    
    ?>

<table cellpadding="0" cellspacing="0" width="100%" border="0" class="list view subpanel-table">
<tbody>


<tr height="20">
<th scope="col" width="20%"><span sugar="slot14" style="white-space:normal;">User</span></th>
<th scope="col" width="10%"><span sugar="slot16" style="white-space:normal;">System Disposition</a></span></th>
<th scope="col" width="10%"><span sugar="slot17" style="white-space:normal;">CallType</span></th>
<th scope="col" width="10%"><span sugar="slot18" style="white-space:normal;">Attempts</span></th>
<th scope="col" width="10%"><span sugar="slot18" style="white-space:normal;">Disposition Code</span></th>
<th scope="col" width="10%"><span sugar="slot18" style="white-space:normal;">Date</span></th>
</tr>

<?php 
while ($data = $db->fetchByAssoc($res))
    { ?>
        <tr height="20" class="oddListRowS1">
        <td scope="row" valign="top" class=""><span sugar="slot10b"><?=$data['user'];?></span></td>
        <td scope="row" valign="top" class=""><span sugar="slot10b"><?=$data['dispositionName'];?></span></td>
        <td scope="row" valign="top" class=""><span sugar="slot10b"><?=$data['callType'];?></span></td>
        <td scope="row" valign="top" class=""><span sugar="slot10b"><?=$data['attempts_c'];?></span></td>
        <td scope="row" valign="top" class=""><span sugar="slot10b"><?=$data['dispositionCode'];?></span></td>
        <td scope="row" valign="top" class=""><span sugar="slot10b"><?=$data['reg_date'];?></span></td>
        </tr>
 <?php }
if ($db->getRowCount($res) == 0){ 
    echo '<tr height="20" class="oddListRowS1"><td colspan="10" align="center"><em>No Data</em></td></tr>';
}?> 

        
</tbody>
</table>
<?php
}

?>
