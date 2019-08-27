<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class UpdateBatchCompletionDate
{

    function updateDate(&$bean, $event, $arguments)
    {

        $batch_completion_date   = '';
        $batch_completion_date_2 = '';

        if ($bean->duration != '' && $bean->batch_start_date != '')
        {
            $batch_completion_date = date('Y-m-d', strtotime("+$bean->duration months", strtotime($bean->batch_start_date)));

            if ($bean->batch_completion_date_2 == '')
            {
                $res1 = $GLOBALS['db']->query("update te_ba_batch set batch_completion_date_2 ='$batch_completion_date' WHERE id='" . $bean->id . "'");
            }
        }

        $res1 = $GLOBALS['db']->query("update te_ba_batch set batch_completion_date='$batch_completion_date' WHERE id='" . $bean->id . "'");
    }

}
