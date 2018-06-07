<?php
// Date: 17 Apr 2018

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');

//error_reporting(-1);
//ini_set('display_errors', 'On');

class AOR_ReportsViewLeadperformancereports extends SugarView
{

    public function __construct()
    {
        parent::SugarView();
    }

    function checkManager()
    {
        global $db, $current_user;
        $userSql = "SELECT u.id
                        FROM users AS u
                    INNER JOIN acl_roles_users AS aru ON aru.user_id=u.id
                    INNER JOIN acl_roles ON aru.role_id=acl_roles.id
                    INNER JOIN users AS ru ON ru.id=u.reports_to_id
                    WHERE aru.`role_id` IN ('7e225ca3-69fa-a75d-f3f2-581d88cafd9a')
                      AND u.deleted=0
                      AND u.id='" . $current_user->id . "'
                      AND aru.deleted=0
                      AND acl_roles.deleted=0 ";

        $userObj = $db->query($userSql);
        return $db->getRowCount($userObj);
    }

    function getManagers($role = '')
    {
        global $db, $current_user;

        $is_manger = $this->checkManager();
        $conditons = '';
        if ($is_manger == 1)
        {
            $conditons = 'AND u.id="' . $current_user->id . '"';
        }

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
                         WHERE aru.`role_id` IN ('7e225ca3-69fa-a75d-f3f2-581d88cafd9a')
                           AND u.deleted=0 $conditons
                           AND aru.deleted=0 
                           AND acl_roles.deleted=0 
                           AND u.deleted=0  
                           AND u.employee_status='Active'";
        $userObj  = $db->query($userSql);
        $usersArr = [];
        while ($user     = $db->fetchByAssoc($userObj))
        {

            $usersArr[$user['id']]['id']             = $user['id'];
            $usersArr[$user['id']]['name']           = $user['first_name'] . ' ' . $user['last_name'];
            $usersArr[$user['id']]['reporting_id']   = $user['reporting_id'];
            $usersArr[$user['id']]['reporting_name'] = $user['reporting_firstname'] . ' ' . $user['reporting_lastname'];
        }
        return $usersArr;
    }

    function getCouncelor($selectedMangers = array())
    {
        global $db,$current_user;


        //print_r($selectedMangers);
        $is_manger = $this->checkManager();
        $conditons = '';

        if ($is_manger == 1)
        {
            $conditons = 'AND ru.id="' . $current_user->id . '"';
        }
        else if (!empty($selectedMangers))
        {


            $conditons = "AND ru.id in ('" . implode("','", $selectedMangers) . "')";
        }

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
                           AND u.deleted=0 $conditons
                           AND aru.deleted=0 
                           AND acl_roles.deleted=0 
                           AND u.deleted=0 
                           AND u.employee_status='Active'";
        $userObj  = $db->query($userSql);
        $usersArr = [];
        while ($user     = $db->fetchByAssoc($userObj))
        {

            $usersArr[$user['id']]['id']             = $user['id'];
            $usersArr[$user['id']]['name']           = $user['first_name'] . ' ' . $user['last_name'];
            $usersArr[$user['id']]['reporting_id']   = $user['reporting_id'];
            $usersArr[$user['id']]['reporting_name'] = $user['reporting_firstname'] . ' ' . $user['reporting_lastname'];
        }
        return $usersArr;
    }
    

    function getbatchforlead($batch_arr = NULL)
    {
        $where = '';
        if ($batch_arr)
        {
            $where = " AND id IN('" . implode("','", $batch_arr) . "')";
        }
        global $db;
        $batchSql     = "SELECT id,name from te_ba_batch WHERE deleted=0 AND batch_status<>'Closed' $where";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        while ($row          = $db->fetchByAssoc($batchObj))
        {
            $batchOptions[] = $row;
        }
        return $batchOptions;
    }

   function getBatch()
    {
        global $db;
        $batchSql     = "SELECT id,name,batch_code FROM te_ba_batch WHERE batch_status='enrollment_in_progress' AND deleted=0";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        while ($row          = $db->fetchByAssoc($batchObj))
        {
            $batchOptions[] = $row;
        }
        return $batchOptions;
    }

    
    function getAmeyoconnected($wherecl)
    {
        global $db;
        $leadList = array();
        $leadSql  = "SELECT COUNT(l.dispositionName) AS lead_count, 
                                                 l.dispositionName,
                                        te_ba_batch.id AS batch_id,
                         te_ba_batch.batch_code
                         FROM leads l
                         LEFT JOIN leads_cstm AS lc ON l.id=lc.id_c
                         LEFT JOIN te_ba_batch ON lc.te_ba_batch_id_c = te_ba_batch.id
                         WHERE l.deleted=0 $wherecl 
                             and l.dispositionName in ('BUSY','NO_ANSWER')
                             and l.lead_source_types!='OO'
                         GROUP BY te_ba_batch.id,l.dispositionName";

        $leadObj = $db->query($leadSql);



        while ($row = $db->fetchByAssoc($leadObj))
        {
            $leadList[$row['batch_id']][$row['dispositionName']] = $row['lead_count'];
        }

        return $leadList;
    }
   

    public function display()
    {
        global $sugar_config, $app_list_strings, $current_user, $db;
        $leadsData = array();
        $is_manger = $this->checkManager();
        #Get lead status drop down option
        $leadStatusList = $GLOBALS['app_list_strings']['lead_status_dom'];
        #Get batch drop down option
      
        # Query for batch drop down options
        $where          = "";
        $from_date      = "";
        $to_date        = "";
        if (isset($_POST['button']) || isset($_POST['export']))
        {
           
            $_SESSION['cccon_from_date']  = $_REQUEST['from_date'];
            $_SESSION['cccon_to_date']    = $_REQUEST['to_date'];
            $_SESSION['cccon_batch']      = (isset($_REQUEST['batch']))? $_REQUEST['batch']:'';
            $_SESSION['cccon_program']    = $_REQUEST['program'];
            $_SESSION['cccon_batch_code'] = $_REQUEST['batch_code'];
            $_SESSION['cccon_vendors']    = $_REQUEST['vendors'];
            $_SESSION['cccon_medium_val'] = $_REQUEST['medium_val'];
            $_SESSION['cccon_status']     = $_REQUEST['status'];
            $_SESSION['cccon_managers']   = $_REQUEST['managers'];
            $_SESSION['cccon_councellors'] = $_REQUEST['councellors'];
        }

          if ($_SESSION['cccon_from_date'] != "" && $_SESSION['cccon_to_date'] != "")
        {
            $selected_from_date = $_SESSION['cccon_from_date'];
            $selected_to_date   = $_SESSION['cccon_to_date'];
            $from_date          = date('Y-m-d', strtotime(str_replace('/', '-', $_SESSION['cccon_from_date'])));
            $to_date            = date('Y-m-d', strtotime(str_replace('/', '-', $_SESSION['cccon_to_date'])));
            $wherecl            .= " AND DATE(l.date_entered)>='" . $from_date . "' AND DATE(l.date_entered)<='" . $to_date . "'";
        }
        elseif ($_SESSION['cccon_from_date'] != "" && $_SESSION['cccon_to_date'] == "")
        {
            $selected_from_date = $_SESSION['cccon_from_date'];
            $from_date          = date('Y-m-d', strtotime(str_replace('/', '-', $_SESSION['cccon_from_date'])));
            $wherecl            .= " AND DATE(l.date_entered)>='" . $from_date . "' ";
        }
        elseif ($_SESSION['cccon_from_date'] == "" && $_SESSION['cccon_to_date'] != "")
        {
            $selected_to_date = $_SESSION['cccon_to_date'];
            $to_date          = date('Y-m-d', strtotime(str_replace('/', '-', $_SESSION['cccon_to_date'])));
            $wherecl          .= " AND DATE(l.date_entered)<='" . $to_date . "' ";
        }
        if (!empty($_SESSION['cccon_status']))
        {
            $selected_status = $_SESSION['cccon_status'];
        }
        $findBatch = array();
        if (!empty($_SESSION['cccon_batch']))
        {
            $selected_batch = $_SESSION['cccon_batch'];
            //$batches        = $this->getBatch($_SESSION['cccon_batch']);
        }
        if (!empty($_SESSION['cccon_program']))
        {
            $selected_program = $_SESSION['cccon_program'];
        }
        if (!empty($_SESSION['cccon_batch_code']))
        {
            $selected_batch_code = $_SESSION['cccon_batch_code'];
            //$batches        = $this->getBatch($_SESSION['cccon_batch']);
        }
        if (!empty($_SESSION['cccon_councellors']))
        {
            $selected_councellors = $_SESSION['cccon_councellors'];
            
           
        }
        if (!empty($_SESSION['cccon_managers']))
        {
            $selected_managers = $_SESSION['cccon_managers'];
        }
        
        
        if ($is_manger == 1)
        {
            $selected_managers = array($current_user->id);
        }

        $programList = array();
        $StatusList  = array();

        if (!empty($selected_program))
        {

            $wherecl .= " AND  p.id IN ('" . implode("','", $selected_program) . "')";
        }
        if (!empty($selected_batch))
        {

            $wherecl .= " AND  b.id IN ('" . implode("','", $selected_batch) . "')";
        }
        if (!empty($selected_batch_code))
        {

            $wherecl .= " AND  b.id IN ('" . implode("','", $selected_batch_code) . "')";
        }
        if (!empty($selected_councellors))
        {
            $wherecl .= " AND  l.assigned_user_id IN ('" . implode("','", $selected_councellors) . "')";
        }
        if (!empty($selected_status) && in_array('Active', $selected_status))
        {
            $wherecl .= " AND  b.batch_status='enrollment_in_progress'";
        }
        if (!empty($selected_status) && in_array('Inactive', $selected_status))
        {
            $wherecl .= " AND  b.batch_status!='enrollment_in_progress'";
        }
        

        
       
        $councelorList = array();

        $getAmeyoCount = $this->getAmeyoconnected($wherecl);
        $BatchListData     = $this->getBatch();
        
      
        
        $error = array();
        $managerSList    = $this->getManagers();
        $councellors = $this->getCouncelor($_SESSION['cccon_managers']);
        
        //echo '<pre>';print_r($CouncellorsList); 
         $leadSql = "SELECT b.id,
                        b.batch_code name,
                        count(l.id) AS total,
                        l.status_description
                 FROM leads AS l
                 LEFT JOIN leads_cstm AS lc ON l.id=lc.id_c
                 LEFT JOIN te_ba_batch b ON lc.te_ba_batch_id_c = b.id
                 WHERE l.deleted=0 AND l.lead_source_types!='OO'
                   AND b.deleted=0 $wherecl
                 GROUP BY b.id,
                          l.status_description";
        //echo '<pre>'.$leadSql;
        $leadObj = $db->query($leadSql);
        while ($row     = $db->fetchByAssoc($leadObj))
        {
            $row['status_description']          = str_replace(array(' ', '-'), '_', $row['status_description']);
            $councelorList[$row['id']]['BUSY']  = (isset($getAmeyoCount[$row['id']]['BUSY'])) ? $getAmeyoCount[$row['id']]['BUSY'] : 0;
            $councelorList[$row['id']]['NO_ANSWER']  = (isset($getAmeyoCount[$row['id']]['NO_ANSWER'])) ? $getAmeyoCount[$row['id']]['NO_ANSWER'] : 0;
            $councelorList[$row['id']]['name']                     = $row['name'];
            $councelorList[$row['id']][$row['status_description']] = $row['total'];
        }



        foreach ($councelorList as $key => $councelor)
        {
            
            if (!isset($councelor['Converted']))
                $councelorList[$key]['Converted']              = 0;
            if (!isset($councelor['Not_Eligible']))
                $councelorList[$key]['Not_Eligible']           = 0;
            if (!isset($councelor['Not_Enquired']))
                $councelorList[$key]['Not_Enquired']           = 0;
            if (!isset($councelor['Ringing_Multiple_Times']))
                $councelorList[$key]['Ringing_Multiple_Times'] = 0;
            if (!isset($councelor['NO_ANSWER']))
                $councelorList[$key]['NO_ANSWER']              = 0;
            if(!isset($councelor['Wrong_Number']))
		$councelorList[$key]['Wrong_Number']=0;
         

        }
        
         if (isset($_POST['export']) && $_POST['export'] == "Export")
        {
            $data                     = "Vendor,Duplicate,Dead-Number,Fallout,Not-Eligible,Not-Enquired,Rejected,Retired,Ringing-Multiple-Times,Wrong-Number,Call-Back,Converted,Follow-Up,New-Lead,Prospect,Re-Enquired,No-Answer,Dropout,Grand-Total\n";
            $file                     = "leads_performance_report";
            $from_date                = "";
            $to_date                  = "";
            $filename                 = $file . "_" . date("Y-m-d");
            $_SESSION['lp_from_date'] = $_REQUEST['from_date'];
            $_SESSION['lp_to_date']   = $_REQUEST['to_date'];
            $_SESSION['lp_batch']     = $_REQUEST['batch'];
            if ($_SESSION['lp_from_date'] != "" && $_SESSION['lp_to_date'])
            {
                $from_date = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['from_date'])));
                $to_date   = date('Y-m-d', strtotime(str_replace('/', '-', $_SESSION['lp_to_date'])));
                $where     .= " AND DATE(l.date_entered)>='" . $from_date . "' AND DATE(l.date_entered)<='" . $to_date . "'";
            }
            elseif ($_SESSION['lp_from_date'] != "" && $_SESSION['lp_to_date'] == "")
            {
                $from_date = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['from_date'])));
                $where     .= " AND DATE(l.date_entered)='" . $from_date . "' ";
            }
            elseif ($_SESSION['lp_from_date'] == "" && $_SESSION['lp_to_date'] != "")
            {
                $to_date = date('Y-m-d', strtotime(str_replace('/', '-', $_SESSION['lp_to_date'])));
                $where   .= " AND DATE(l.date_entered)='" . $to_date . "' ";
            }
            if (!empty($_SESSION['lp_batch']))
            {
                $where .= " AND lc.te_ba_batch_id_c IN('" . implode("','", $_SESSION['lp_batch']) . "') ";
            }

            $councelorList = array();
  
            $leadSql = "SELECT v.id,
                                            b.batch_code name,
                                            count(l.id) AS total,
                                            l.status_description
                                     FROM leads AS l
                                     LEFT JOIN leads_cstm AS lc ON l.id=lc.id_c
                                     LEFT JOIN te_ba_batch b ON lc.te_ba_batch_id_c = b.id
                                     WHERE l.deleted=0
                                       AND b.deleted=0 $where
                                     GROUP BY b.id,
                                              l.status_description";
            $leadObj = $db->query($leadSql);
            while ($row     = $db->fetchByAssoc($leadObj))
            {
                $row['status_description']                             = str_replace(array(' ', '-'), '_', $row['status_description']);
                $councelorList[$row['id']]['name']                     = $row['name'];
                $councelorList[$row['id']][$row['status_description']] = $row['total'];
            }


            foreach ($councelorList as $key => $councelor)
            {
                if (!isset($councelor['Call_Back']))
                    $councelorList[$key]['Call_Back']              = 0;
                if (!isset($councelor['Converted']))
                    $councelorList[$key]['Converted']              = 0;
                if (!isset($councelor['Dead_Number']))
                    $councelorList[$key]['Dead_Number']            = 0;
                if (!isset($councelor['Duplicate']))
                    $councelorList[$key]['Duplicate']              = 0;
                if (!isset($councelor['Fallout']))
                    $councelorList[$key]['Fallout']                = 0;
                if (!isset($councelor['Follow_Up']))
                    $councelorList[$key]['Follow_Up']              = 0;
                if (!isset($councelor['New_Lead']))
                    $councelorList[$key]['New_Lead']               = 0;
                if (!isset($councelor['Not_Eligible']))
                    $councelorList[$key]['Not_Eligible']           = 0;
                if (!isset($councelor['Not_Enquired']))
                    $councelorList[$key]['Not_Enquired']           = 0;
                if (!isset($councelor['Prospect']))
                    $councelorList[$key]['Prospect']               = 0;
                if (!isset($councelor['Re_Enquired']))
                    $councelorList[$key]['Re_Enquired']            = 0;
                if (!isset($councelor['Rejected']))
                    $councelorList[$key]['Rejected']               = 0;
                if (!isset($councelor['Retired']))
                    $councelorList[$key]['Retired']                = 0;
                if (!isset($councelor['Ringing_Multiple_Times']))
                    $councelorList[$key]['Ringing_Multiple_Times'] = 0;
                if (!isset($councelor['Wrong_Number']))
                    $councelorList[$key]['Wrong_Number']           = 0;
                //add New Status
                if (!isset($councelor['No_Answer']))
                    $councelorList[$key]['No_Answer']              = 0;
                if (!isset($councelor['Dropout']))
                    $councelorList[$key]['Dropout']                = 0;

                if (!isset($councelor['Invalid_Total']))
                {
                    $councelorList[$key]['Invalid_Total'] = $councelorList[$key]['Wrong_Number'] + $councelorList[$key]['Dead_Number'] + $councelorList[$key]['Duplicate'] + $councelorList[$key]['Ringing_Multiple_Times'] + $councelorList[$key]['Not_Enquired'] + $councelorList[$key]['Not_Eligible'] + $councelorList[$key]['Rejected'] + $councelorList[$key]['Re_Enquired'] + $councelorList[$key]['No_Answer'];
                }
                if (!isset($councelor['Valid_Total']))
                {
                    $councelorList[$key]['Valid_Total'] = $councelorList[$key]['Call_Back'] + $councelorList[$key]['Follow_Up'] /*  New Code */ + $councelorList[$key]['New_Lead'] + $councelorList[$key]['Converted'] + $councelorList[$key]['Prospect'] + $councelorList[$key]['Dropout'] /*  New Code */ + $councelorList[$key]['Retired'] + $councelorList[$key]['Fallout'];
                }
                if (!isset($councelor['Grand_Total']))
                {
                    $councelorList[$key]['Grand_Total'] = $councelorList[$key]['Valid_Total'] + $councelorList[$key]['Invalid_Total'];
                }
            }


            foreach ($councelorList as $key => $councelor)
            {
                $data .= "\"" . $councelor['name'] . "\",\"" . $councelor['Duplicate'] . "\",\"" . $councelor['Dead_Number'] . "\",\"" . $councelor['Fallout'] . "\",\"" . $councelor['Not_Eligible'] . "\",\"" . $councelor['Not_Enquired'] . "\",\"" . $councelor['Rejected'] . "\",\"" . $councelor['Retired'] . "\",\"" . $councelor['Ringing_Multiple_Times'] . "\",\"" . $councelor['Wrong_Number'] . "\",\"" . $councelor['Call_Back'] . "\",\"" . $councelor['Converted'] . "\",\"" . $councelor['Follow_Up'] . "\",\"" . $councelor['New_Lead'] . "\",\"" . $councelor['Prospect'] . "\",\"" . $councelor['Re_Enquired'] . "\",\"" . $councelor['No_Answer'] . "\",\"" . $councelor['Dropout'] . "\",\"" . $councelor['Grand_Total'] . "\"\n";
            }
            ob_end_clean();
            header("Content-type: application/csv");
            header('Content-disposition: attachment;filename=" ' . $filename . '.csv";');
            echo $data;
            exit;
        }
        

        //echo '<pre>';print_r($councelorList); die;


        $total     = count($councelorList); #total records
        $start     = 0;
        $per_page  = 50;
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
            //$page++;
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
            $page = ($_REQUEST['page'] - 1);
            $left = 1;
        }

        $councelorList = array_slice($councelorList, $start, $per_page);
        if ($total > $per_page)
        {
            $current = "(" . ($start + 1) . "-" . ($start + $per_page) . " of " . $total . ")";
        }
        else
        {
            $current = "(" . ($start + 1) . "-" . count($councelorList) . " of " . $total . ")";
        }

        if (isset($_SESSION['lp_from_date']) && !empty($_SESSION['lp_from_date']))
        {
            $from_date = date('d-m-Y', strtotime($_SESSION['lp_from_date']));
        }
        if (isset($_SESSION['lp_to_date']) && !empty($_SESSION['lp_to_date']))
        {
            $to_date = date('d-m-Y', strtotime($_SESSION['lp_to_date']));
        }
        if (isset($_SESSION['lp_batch']) && !empty($_SESSION['lp_batch']))
        {
            $selected_batch = $_SESSION['lp_batch'];
        }
        $sugarSmarty = new Sugar_Smarty();

        $sugarSmarty->assign("leadStatusList", $leadStatusList);
        $sugarSmarty->assign("BatchListData", $BatchListData);
        $sugarSmarty->assign("selected_from_date", $from_date);
        $sugarSmarty->assign("selected_to_date", $to_date);
        $sugarSmarty->assign("selected_batch", $selected_batch);
        
        $sugarSmarty->assign("selected_batch_code", $selected_batch_code);

        $sugarSmarty->assign("councellors", $councellors);
        $sugarSmarty->assign("councelorList", $councelorList);
        $sugarSmarty->assign("managerSList", $managerSList);
        $sugarSmarty->assign("selected_status", $selected_status);

        $sugarSmarty->assign("selected_managers", $selected_managers);
        $sugarSmarty->assign("selected_councellors", $selected_councellors);
        

        $sugarSmarty->assign("current_records", $current);
        $sugarSmarty->assign("page", $page);
        $sugarSmarty->assign("pagenext", $pagenext);
        $sugarSmarty->assign("right", $right);
        $sugarSmarty->assign("left", $left);
        $sugarSmarty->assign("last_page", $last_page);
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/leadperformancereports.tpl');
    }

}

?>
