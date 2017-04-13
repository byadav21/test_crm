<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class te_student_batchViewDropoutrequest extends SugarView
{

    public function __construct()
    {
        parent::SugarView();
    }

    /**
     * @see ViewList::preDisplay()
     */
    public function preDisplay()
    {
        echo '<script type="text/javascript" src="custom/modules/te_student_batch/student_batch.js"></script>';
        parent::preDisplay();
    }

    function getInstitute($institute_id)
    {
        global $db;
        $instituteSql = "SELECT name FROM te_in_institutes WHERE id='" . $institute_id . "'";
        $instituteObj = $db->query($instituteSql);
        $institute    = $db->fetchByAssoc($instituteObj);
        return $institute['name'];
    }

    function getProgram($program_id)
    {
        global $db;
        $programSql = "SELECT name FROM te_pr_programs WHERE id='" . $program_id . "'";
        $programObj = $db->query($programSql);
        $program    = $db->fetchByAssoc($programObj);
        return $program['name'];
    }

    public function display()
    {

        $custom_query = '';
        if (isset($_GET['is_new_dropout_basic']) && $_GET['is_new_dropout_basic'] == 1)
        {
            $custom_query = " AND sb.is_new_dropout=1 AND dropout_status IN ('Approved','Rejected')";
            echo '<input type="hidden" name="is_new_dropout_basic" value="' . $_GET['is_new_dropout_basic'] . '">';
        }

        if (isset($_GET['dropout_count']) && $_GET['dropout_count'] == 1)
        {
            $custom_query .= "  AND dropout_status IN ('Approved','Rejected')";
            echo '<input type="hidden" name="dropout_count" value="' . $_GET['dropout_count'] . '">';
        }



        global $db, $current_user, $s_history;
        $resultSet    = array();
        $resultSethis = array();
        if ($current_user->designation == "BUH")
        {
            $studentBatchSql = "SELECT sb.*,s.name as student,s.id as idstudent FROM te_student s INNER JOIN te_student_te_student_batch_1_c sbr ON s.id=sbr.te_student_te_student_batch_1te_student_ida INNER JOIN te_student_batch sb ON sbr.te_student_te_student_batch_1te_student_batch_idb=sb.id WHERE sb.dropout_status='Pending'  AND sb.deleted=0 ORDER BY sb.date_entered DESC,sb.date_modified DESC";
            $s_history       = "SELECT sb.*,s.name as student,s.id as idstudent FROM te_student s INNER JOIN te_student_te_student_batch_1_c sbr ON s.id=sbr.te_student_te_student_batch_1te_student_ida INNER JOIN te_student_batch sb ON sbr.te_student_te_student_batch_1te_student_batch_idb=sb.id WHERE (sb.dropout_status='Approved' OR sb.dropout_status='Rejected')  AND sb.deleted=0 ORDER BY sb.date_entered DESC,sb.date_modified DESC";
        }
        elseif ($current_user->is_admin == 1)
        {

            $studentBatchSql = "SELECT sb.*,s.name as student,s.id as idstudent FROM te_student s INNER JOIN te_student_te_student_batch_1_c sbr ON s.id=sbr.te_student_te_student_batch_1te_student_ida INNER JOIN te_student_batch sb ON sbr.te_student_te_student_batch_1te_student_batch_idb=sb.id WHERE sb.dropout_status IN('Rejected','Approved','Pending')  AND sb.deleted=0 $custom_query ORDER BY sb.date_entered DESC,sb.date_modified DESC";
        }
        else
        {
            $user_id = $current_user->id;
            $users   = $this->reportingUser($user_id);
            $uid     = $this->report_to_id;
            if (empty($uid))
            {
                $uid[0] = $user_id;
            }
            else
            {
                array_push($uid, $user_id);
            }

            $users_str       = "'" . implode("','", $uid) . "'";
            $studentBatchSql = "SELECT sb.*,s.name as student,s.id as idstudent FROM te_student s INNER JOIN te_student_te_student_batch_1_c sbr ON s.id=sbr.te_student_te_student_batch_1te_student_ida INNER JOIN te_student_batch sb ON sbr.te_student_te_student_batch_1te_student_batch_idb=sb.id WHERE sb.dropout_status IN('Rejected','Approved','Pending') AND sb.deleted=0 AND sb.assigned_user_id IN($users_str) ORDER BY sb.date_entered DESC,sb.date_modified DESC";
        }
        $studentBatchObj = $db->query($studentBatchSql);


        $dropout_status_list = $GLOBALS['app_list_strings']['dropuout_status_list'];
        $dropout_type_list   = $GLOBALS['app_list_strings']['student_batch_dropout_list'];
        $rowcount            = 0;
        while ($row                 = $db->fetchByAssoc($studentBatchObj))
        {
            $rowcount++;
            $row['program']   = $this->getProgram($row['te_pr_programs_id_c']);
            $row['institute'] = $this->getInstitute($row['te_in_institutes_id_c']);

            $dropout_status = "<span id='dropout_request_" . $row['id'] . "'></span><select name='dropout_status' id='" . $row['id'] . "' onchange='return changeDropoutStatus(this.id,this.value," . $rowcount . ");' style='width:113PX !IMPORTANT'><option value=''></option>";
            foreach ($dropout_status_list as $key => $value)
            {
                if ($row['dropout_status'] == $key)
                    $dropout_status .= "<option value='" . $key . "' selected>" . $value . "</option>";
                else
                    $dropout_status .= "<option value='" . $key . "'>" . $value . "</option>";
            }

            $dropout_status .= "</select>";


            $dropout_type = "<select name='dropout_type' id='dropout_type_" . $rowcount . "'  style='width:90PX !IMPORTANT'>";
            foreach ($dropout_type_list as $key => $value)
            {
                if ($row['dropout_type'] == $key)
                    $dropout_type .= "<option value='" . $key . "' selected>" . $value . "</option>";
                else
                    $dropout_type .= "<option value='" . $key . "'>" . $value . "</option>";
            }
            $dropout_type .= "</select>";




            if ($current_user->designation == "BUH")
            {
                $row['dropout_type']   = $dropout_type;
                $row['dropout_status'] = $dropout_status;
            }
            else
            {
                $row['dropout_type'] = $dropout_type_list[$row['dropout_type']];
            }

            $resultSet[] = $row;
        }
        if ($s_history)
        {
            $student_history = $db->query($s_history);
            while ($rowhis          = $db->fetchByAssoc($student_history))
            {
                $rowhis['program']   = $this->getProgram($rowhis['te_pr_programs_id_c']);
                $rowhis['institute'] = $this->getInstitute($rowhis['te_in_institutes_id_c']);

                $resultSethis[] = $rowhis;
            }
        }

        //New code
        $sugarSmarty = new Sugar_Smarty();
        $sugarSmarty->assign("resultSet", $resultSet);
        $sugarSmarty->assign("resultSethis", $resultSethis);
        $sugarSmarty->assign("designation", $current_user->designation);

        $sugarSmarty->assign("current_user_id", $current_user->id);

        $sugarSmarty->display('custom/modules/te_student_batch/tpls/dropoutapprove.tpl');
    }

    function reportingUser($currentUserId)
    {
        $userObj                             = new User();
        $userObj->disable_row_level_security = true;
        $userList                            = $userObj->get_full_list("", "users.reports_to_id='" . $currentUserId . "'");
        if (!empty($userList))
        {
            foreach ($userList as $record)
            {
                if (!empty($record->reports_to_id) && !empty($record->id))
                {
                    $this->report_to_id[] = $record->id;
                    $this->reportingUser($record->id);
                }
            }
        }
    }

}

?>
