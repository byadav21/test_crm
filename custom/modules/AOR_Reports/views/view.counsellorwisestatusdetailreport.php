<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');
class AOR_ReportsViewCounsellorwisestatusdetailreport extends SugarView
{

    var $report_to_id;
    var $counsellors_arr;

    public function __construct()
    {
        parent::SugarView();
    }
	function reportingUser($currentUserId){
		$userObj = new User();
		$userObj->disable_row_level_security = true;
		$userList = $userObj->get_full_list("", "users.reports_to_id='".$currentUserId."'");
		if(!empty($userList)){
			foreach($userList as $record){
				if(!empty($record->reports_to_id) && !empty($record->id)){
					$this->report_to_id[] = $record->id;
					$this->reportingUser($record->id);
				}
			}
		}
	}
	function getCouncelor($user_id){
		global $db;
		$userSql="SELECT CONCAT(first_name,' ',last_name) as name FROM users WHERE deleted=0 AND id='".$user_id."'";
		$userObj =$db->query($userSql);
		$user =$db->fetchByAssoc($userObj);
		return $user['name'];
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
	
	function getCouncelorForAdmin($user_id=NULL){
		global $db;
		$userSql="select u.first_name,u.last_name,u.id,ru.first_name AS reporting_firstname,ru.last_name AS reporting_lastname,ru.id AS reporting_id FROM users AS u INNER JOIN acl_roles_users AS aru ON aru.user_id=u.id LEFT JOIN users AS ru ON ru.id=u.reports_to_id WHERE aru.`role_id` IN ('7e225ca3-69fa-a75d-f3f2-581d88cafd9a',  '270ce9dd-7f7d-a7bf-f758-582aeb4f2a45',  'cc7133be-0db9-d50a-2684-582c0078e74e') AND u.deleted=0 AND aru.deleted=0";
		$userObj =$db->query($userSql);
		$usersArr = [];
		while($user =$db->fetchByAssoc($userObj)){
			$usersArr[$user['id']]=array(
			'id'=>$user['id'],
			'name'=>$user['first_name'].' '.$user['last_name'],
			'reporting_id'=>$user['reporting_id'],
			'reporting_name'=>$user['reporting_firstname'].' '.$user['reporting_lastname']
			);
		}
		return $usersArr;
	}
	
	function getCouncelorForUsers($user_ids=array()){
		global $db;
		$userSql="select u.first_name,u.last_name,u.id,ru.first_name AS reporting_firstname,ru.last_name AS reporting_lastname,ru.id AS reporting_id FROM users AS u LEFT JOIN users AS ru ON ru.id=u.reports_to_id WHERE u.id IN ('".implode("','",$user_ids)."') AND u.deleted=0";
		$userObj =$db->query($userSql);
		$usersArr = [];
		while($user =$db->fetchByAssoc($userObj)){
			$usersArr[$user['id']]=array(
			'id'=>$user['id'],
			'name'=>$user['first_name'].' '.$user['last_name'],
			'reporting_id'=>$user['reporting_id'],
			'reporting_name'=>$user['reporting_firstname'].' '.$user['reporting_lastname']
			);
		}
		return $usersArr;
	}
    public function display()
    {
        global $sugar_config, $app_list_strings, $current_user, $db;
		$current_user_id = $current_user->id;
		$current_user_is_admin = $current_user->is_admin;
        $where         = "";
        $wherecl       = "";
		$BatchListData = $this->getBatch();
		$usersdd = "";
		if($current_user_is_admin==1){
			$usersdd = $this->getCouncelorForAdmin();
		}
		else{
			$this->report_to_id[]=$current_user_id;
			$reportingusersids = $this->reportingUser($current_user_id);
			
			$uid=$this->report_to_id;
			
			$usersdd = $this->getCouncelorForUsers($uid);
		}
        if (!isset($_SESSION['cccon_from_date']))
        {
            $_SESSION['cccon_from_date'] = date('Y-m-d', strtotime('-1 days'));
        }
        if (!isset($_SESSION['cccon_to_date']))
        {
            $_SESSION['cccon_to_date'] = date('Y-m-d', strtotime('-1 days'));
        }
		if(!isset($_SESSION['cccon_counselor'])){
			$_SESSION['cccon_counselor'] = array_keys($usersdd);
		}
        if (isset($_POST['button']) || isset($_POST['export']))
        {
            $_SESSION['cccon_from_date']  = $_REQUEST['from_date'];
            $_SESSION['cccon_to_date']    = $_REQUEST['to_date'];
            $_SESSION['cccon_batch']      = $_REQUEST['batch'];
            $_SESSION['cccon_batch_code'] = $_REQUEST['batch_code'];
            $_SESSION['cccon_counselor'] = $_REQUEST['counselor'];
            
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
        
        $findBatch = array();
        if (!empty($_SESSION['cccon_batch']))
        {
            $selected_batch = $_SESSION['cccon_batch'];
        }
        if (!empty($_SESSION['cccon_batch_code']))
        {
            $selected_batch_code = $_SESSION['cccon_batch_code'];
        }
		if (!empty($_SESSION['cccon_counselor']))
        {
            $selected_counselor = $_SESSION['cccon_counselor'];
        }
		

        $programList = array();
        $StatusList  = array();

        if (!empty($selected_batch))
        {

            $wherecl .= " AND  te_ba_batch.id IN ('" . implode("','", $selected_batch) . "')";
        }
        if (!empty($selected_batch_code))
        {

            $wherecl .= " AND  te_ba_batch.id IN ('" . implode("','", $selected_batch_code) . "')";
        }
		if (!empty($selected_counselor))
        {

            $wherecl .= " AND  l.assigned_user_id IN ('" . implode("','", $selected_counselor) . "')";
        }
		
		$statusArr = ['alive','dead','converted','warm','recycle','dropout'];
		$StatusList['new_lead']     = 'New Lead';
		$StatusList['follow_up']     = 'Follow-Up';
		$StatusList['call_back']     = 'Call-back';
		$StatusList['dead_number']     = 'Dead Number';
		$StatusList['fallout']     = 'Fallout';
		$StatusList['not_eligible']     = 'Not Eligible';
		$StatusList['not_enquired']     = 'Not Enquired';
		$StatusList['retired']     = 'Retired';
		$StatusList['ringing_multiple_times']     = 'Ringing Multiple Times';
		$StatusList['wrong_number']     = 'Wrong Number';
		$StatusList['converted']     = 'Converted';
		$StatusList['prospect']     = 'Prospect';
		$StatusList['re_enquired']     = 'Re-Enquired';
		$StatusList['recycle']     = 'Recycle';
		$StatusList['dropout']     = 'Dropout';
		$StatusList['duplicate']     = 'Duplicate';
		$StatusList['na']     = 'NA';

        if (isset($_POST['export']) && $_POST['export'] == "Export")
        {



            $file     = "CounselorWiseStatusdetail_report";
            $where    = '';
            $filename = $file . "_" . $from_date . "_" . $to_date;

            $leadSql = "SELECT COUNT(l.id) AS lead_count,
                    COALESCE(te_ba_batch.id,'NA') AS batch_id,
                    COALESCE(te_ba_batch.name,'NA') AS batch_name,
                    COALESCE(te_ba_batch.batch_code,'NA')AS batch_code,
                    l.status_description,
                    l.assigned_user_id
                FROM leads l
                INNER JOIN leads_cstm AS lc ON l.id=lc.id_c
                LEFT JOIN te_ba_batch ON lc.te_ba_batch_id_c = te_ba_batch.id
                 WHERE l.deleted=0
                   $wherecl
              GROUP BY l.status_description,l.assigned_user_id,te_ba_batch.batch_code order by  te_ba_batch.batch_code ";
            //echo $leadSql;exit();


            $leadObj = $db->query($leadSql);


            while ($row = $db->fetchByAssoc($leadObj))
			{
			   
				$programList[$row['assigned_user_id'] .'_BATCH_'.$row['batch_id']]['batch_id']   = $row['batch_id'];
				$programList[$row['assigned_user_id'] .'_BATCH_'.$row['batch_id']]['batch_name']   = $row['batch_name'];
				$programList[$row['assigned_user_id'] .'_BATCH_'.$row['batch_id']]['batch_code']   = $row['batch_code'];
				$programList[$row['assigned_user_id'] .'_BATCH_'.$row['batch_id']]['assigned_user']   = !empty($row['assigned_user_id']) ? $usersdd[$row['assigned_user_id']]['name'] : 'NA';
				$programList[$row['assigned_user_id'] .'_BATCH_'.$row['batch_id']]['reporting_user']   = !empty($row['assigned_user_id']) ? $usersdd[$row['assigned_user_id']]['reporting_name'] : 'NA';
				$programList[$row['assigned_user_id'] .'_BATCH_'.$row['batch_id']][strtolower(str_replace(array(' ','-'),'_',$row['status_description']))]   = $row['lead_count'];
				
			}
			foreach($programList as $key=>$val){
				$total=0;
				foreach ($StatusList as $key1=>$value){
					$countedLead = (isset($programList[$key][$key1]) && !empty($programList[$key][$key1])? $programList[$key][$key1] : 0);
					$total      += $countedLead;
				}
				$programList[$key]['total']   = $total;
			}

            # Create heading
            $data = "Counsellor Name";
		    $data .= "Reporting Manager";
		    $data .= "Batch Name";
            $data .= ",Batch Code";
            $data .= ",Total";
            foreach ($StatusList as $statusVal)
            {
                $data .= "," . $statusVal;
            }
            $data .= "\n";



            //echo "<pre>";print_r($programList);exit();
            foreach ($programList as $key => $councelor)
            {
                $data .= "\"" . $councelor['assigned_user'];
                $data .= "\"" . $councelor['reporting_user'];
                $data .= "\"" . $councelor['batch_name'];
                $data .= "\",\"" . $councelor['batch_code'];
                $data .= "\",\"" . $councelor['total'];
				
				foreach($StatusList as $key1=>$val){
					$countedLead = (!empty($programList[$key][$key1])? $programList[$key][$key1] : 0);
                    $data      .= "\",\"" . $countedLead;
				}
                $data .= "\"\n";
            }

            ob_end_clean();
            header("Content-type: application/csv");
            header('Content-disposition: attachment;filename=" ' . $filename . '.csv";');
            echo $data;
            exit;
        } // End Of Export Func








        $leadSql = "SELECT COUNT(l.id) AS lead_count,
                    COALESCE(te_ba_batch.id,'NA') AS batch_id,
                    COALESCE(te_ba_batch.name,'NA') AS batch_name,
                    COALESCE(te_ba_batch.batch_code,'NA')AS batch_code,
                    l.status_description,
                    l.assigned_user_id
                FROM leads l
                INNER JOIN leads_cstm AS lc ON l.id=lc.id_c
                LEFT JOIN te_ba_batch ON lc.te_ba_batch_id_c = te_ba_batch.id
                 WHERE l.deleted=0
                   $wherecl
              GROUP BY l.status_description,l.assigned_user_id,te_ba_batch.batch_code order by  te_ba_batch.batch_code ";
        //echo $leadSql;exit();


        $leadObj = $db->query($leadSql);		
        while ($row = $db->fetchByAssoc($leadObj))
        {
           
            $programList[$row['assigned_user_id'] .'_BATCH_'.$row['batch_id']]['batch_id']   = $row['batch_id'];
            $programList[$row['assigned_user_id'] .'_BATCH_'.$row['batch_id']]['batch_name']   = $row['batch_name'];
            $programList[$row['assigned_user_id'] .'_BATCH_'.$row['batch_id']]['batch_code']   = $row['batch_code'];
            $programList[$row['assigned_user_id'] .'_BATCH_'.$row['batch_id']]['assigned_user']   = !empty($row['assigned_user_id']) ? $usersdd[$row['assigned_user_id']]['name'] : 'NA';
            $programList[$row['assigned_user_id'] .'_BATCH_'.$row['batch_id']]['reporting_user']   = !empty($row['assigned_user_id']) ? $usersdd[$row['assigned_user_id']]['reporting_name'] : 'NA';
			$programList[$row['assigned_user_id'] .'_BATCH_'.$row['batch_id']][strtolower(str_replace(array(' ','-'),'_',$row['status_description']))]   = $row['lead_count'];
			
        }
		
		foreach($programList as $key=>$val){
			$total=0;
			foreach ($StatusList as $key1=>$value){
				$countedLead = (isset($programList[$key][$key1]) && !empty($programList[$key][$key1])? $programList[$key][$key1] : 0);
				$total      += $countedLead;
			}
			$programList[$key]['total']   = $total;
		}

        
        $total     = count($programList); #total records
        $start     = 0;
        $per_page  = 60;
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

            $left = 1;
        }

        $programList = array_slice($programList, $start, $per_page);
        if ($total > $per_page)
        {
            $current = "(" . ($start + 1) . "-" . ($start + $per_page) . " of " . $total . ")";
        }
        else
        {
            $current = "(" . ($start + 1) . "-" . count($programList) . " of " . $total . ")";
        }
        #pE
        $sugarSmarty = new Sugar_Smarty();

        $sugarSmarty->assign("programList", $programList);
        $sugarSmarty->assign("BatchListData", $BatchListData);
        $sugarSmarty->assign("CounselorList", $usersdd);
        $sugarSmarty->assign("selected_batch", $selected_batch);
        $sugarSmarty->assign("selected_from_date", $selected_from_date);
        $sugarSmarty->assign("selected_to_date", $selected_to_date);
        $sugarSmarty->assign("selected_counselor", $selected_counselor);

        $sugarSmarty->assign("current_records", $current);
        $sugarSmarty->assign("page", $page);
        $sugarSmarty->assign("pagenext", $pagenext);
        $sugarSmarty->assign("right", $right);
        $sugarSmarty->assign("left", $left);
        $sugarSmarty->assign("last_page", $last_page);
		$sugarSmarty->assign("statusArr", $statusArr);
		$sugarSmarty->assign("StatusList", $StatusList);
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/counsellorwisestatusdetailreport.tpl');
    }

}

?>
