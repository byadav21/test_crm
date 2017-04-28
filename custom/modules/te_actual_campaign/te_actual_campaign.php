<?php

/* * *******************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 * ****************************************************************************** */

/**
 * THIS CLASS IS FOR DEVELOPERS TO MAKE CUSTOMIZATIONS IN
 */
//require_once('modules/te_budgeted_campaign/te_budgeted.php');

class te_actual_campaign_override extends te_actual_campaign
{
    public $dbinstance;
    
    function __construct()
    {
        parent::__construct();
        $this->dbinstance = DBManagerFactory::getInstance();
    }
    
 


 
    function getBatchList($isadmin = '0', $batches = '', $userID = '', $start = 0, $noofRow = 18)
    {

        $sql = " SELECT  
                    bb.name ,sum(volume) as volume,sum(rate) as rate, sum(total_cost) as total_cost 
                FROM te_actual_campaign tac 
                INNER JOIN te_utm_te_actual_campaign_1_c uac ON tac.id=uac.te_utm_te_actual_campaign_1te_actual_campaign_idb
                INNER JOIN te_utm ON uac.te_utm_te_actual_campaign_1te_utm_ida=te_utm. id
                INNER JOIN `te_ba_batch` bb ON te_utm.te_ba_batch_id_c=bb.id  WHERE bb.deleted=0 AND te_utm.deleted=0 AND tac.deleted=0 GROUP BY bb.id ";

        $itemDetal = $this->dbinstance->query($sql);
        $rowData   = [];
        $current   = '';
        while ($row       = $this->dbinstance->fetchByAssoc($itemDetal))
        {

            $addrows   = $row;

            $addrows['name']   = strtoupper($row['name']);
            $rowData[] = $addrows;
        }
        return $rowData;
    }

    public $report_to_id;

    function reportingUser($currentUserId)
    {

        $userObj                             = new User();
        $userObj->disable_row_level_security = true;
        $userList                            = $userObj->get_full_list("", "users.reports_to_id='" . $currentUserId . "'");

        if (!empty($userList))
        {

            foreach ($userList as $record)
            {

                if (!empty($record->reports_to_id))
                {

                    $this->report_to_id[$record->id] = $record->name . "(" . $record->id . ")";
                    $this->reportingUser($record->id);
                }
            }
        }
    }

}

?>
