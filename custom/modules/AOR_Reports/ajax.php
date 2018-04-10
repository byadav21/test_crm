<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
ini_set('display_errors', '1');

error_reporting(E_ALL);
global $app_list_strings, $current_user, $sugar_config, $db;


if (isset($_POST['action']) && $_POST['action'] == 'batch_code')
{
    $where  = '';
    $option = '';
    $param  = $_POST['param'];
    if ($param && in_array('Active', $param))
    {

        $where = " and batch_status in ('enrollment_in_progress')";
    }
    else if ($param && in_array('All', $param))
    {

        $where = " ";
    }
    else if (empty($param))
    {

        $where = " ";
    }
    else
    {
        $where = " and batch_status in ('closed','completed','enrollment_closed','classes_in_progress','planned')";
    }
    $query_utm = "SELECT `id`, `name`, `batch_code` FROM `te_ba_batch` WHERE `deleted`=0 $where";
    $batch     = $db->query($query_utm);



    while ($data = $db->fetchByAssoc($batch))
    {
        $option .= '<option value="' . $data['id'] . '">' . $data['batch_code'] . '</option>';
    }

    //print_r($_POST['param']);
    echo $option;
    die;
}

if (isset($_POST['action']) && $_POST['action'] == 'councellors')
{
    global $db;
    $option = '';
    $param  = $_POST['param'];

    if (!empty($param))
    {
        $userSql  = "SELECT u.first_name,
                                u.last_name,
                                u.id,
                                ru.first_name AS reporting_firstname,
                                ru.last_name AS reporting_lastname,
                                ru.id AS reporting_id
                         FROM users AS u
                         INNER JOIN acl_roles_users AS aru ON aru.user_id=u.id
 			 INNER join acl_roles on aru.role_id=acl_roles.id
                         INNER JOIN users AS ru ON ru.id=u.reports_to_id
                         WHERE aru.`role_id` IN ('270ce9dd-7f7d-a7bf-f758-582aeb4f2a45')
                           AND u.deleted=0
                           AND aru.deleted=0 and acl_roles.deleted=0 and ru.id in ('" . implode("','", $param) . "')";  
        $userObj  = $db->query($userSql);
        $usersArr = [];
        while ($user     = $db->fetchByAssoc($userObj))
        {
            $option .= '<option value="' . $user['id'] . '">' . $user['first_name'] . ' ' . $user['last_name'] . '</option>';
        }
    }

    echo $option;
    die;
}
?>
