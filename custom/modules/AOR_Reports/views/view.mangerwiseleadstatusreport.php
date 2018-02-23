<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');
class AOR_ReportsViewMangerwiseleadstatusreport extends SugarView
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
        $batchSql     = "SELECT id,name,batch_code FROM te_ba_batch WHERE deleted=0";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        while ($row          = $db->fetchByAssoc($batchObj))
        {
            $batchOptions[$row['id']] = array('name'=>$row['name'],'batch_code'=>$row['batch_code']);
        }
		$batchOptions['na'] = 'NA';
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
		#echo "<pre>";print_r($usersdd);exit();
        if (!isset($_SESSION['cccon_from_date']))
        {
            $_SESSION['cccon_from_date'] = date('Y-m-d', strtotime('-1 days'));
        }
        if (!isset($_SESSION['cccon_to_date']))
        {
            $_SESSION['cccon_to_date'] = date('Y-m-d', strtotime('-1 days'));
        }
		/*if(!isset($_SESSION['cccon_counselor'])){
			$_SESSION['cccon_counselor'] = array_keys($usersdd);
		}*/
        if (isset($_POST['button']) || isset($_POST['export']))
        {
            $_SESSION['cccon_from_date']  = $_REQUEST['from_date'];
            $_SESSION['cccon_to_date']    = $_REQUEST['to_date'];
            //$_SESSION['cccon_vendor']      = $_REQUEST['vendor'];
            //$_SESSION['cccon_counselor'] = $_REQUEST['counselor'];
            
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
        if (!empty($_SESSION['cccon_vendor']))
        {
            $selected_vendor = $_SESSION['cccon_vendor'];
        }
        if (!empty($_SESSION['cccon_batch_code']))
        {
            $selected_batch_code = $_SESSION['cccon_batch_code'];
        }
		/*if (!empty($_SESSION['cccon_counselor']))
        {
            $selected_counselor = $_SESSION['cccon_counselor'];
        }*/
		

        $programList = array();
        $StatusList  = array();
        if (!empty($selected_vendor))
        {
			$vendorArr = [];
			foreach($selected_vendor as $val){
				$vendorArr[]=strtolower($val);
			}
            $wherecl .= " AND  l.vendor IN ('" . implode("','", $selected_vendor) . "')";
        }
        
		/*if (!empty($selected_counselor))
        {

            $wherecl .= " AND  l.assigned_user_id IN ('" . implode("','", $selected_counselor) . "')";
        }*/
		
		$statusArr['alive'] = 'Alive';
		$statusArr['dead'] = 'Dead';
		$statusArr['converted'] = 'Converted';
		$statusArr['warm'] = 'Warm';
		$statusArr['recycle'] = 'Recycle';
		$statusArr['dropout'] = 'Dropout';
		$statusArr['duplicate'] = 'Duplicate';
		

        if (isset($_POST['export']) && $_POST['export'] == "Export")
        {



            $file     = "Manager_wise_lead_statusReport";
            $where    = '';
            $filename = $file . "_" . $from_date . "_" . $to_date;

            $leadSql = "SELECT COUNT(l.id) AS lead_count, l.status,LOWER(l.vendor)vendor,l.assigned_user_id FROM leads l WHERE l.deleted=0  $wherecl GROUP BY l.status,l.vendor,l.assigned_user_id";


			$leadSql = "SELECT count(l.id)total,lc.te_ba_batch_id_c,l.dristi_campagain_id,l.status,SUM(CASE WHEN l.`assigned_user_id` IN ('','NULL') OR l.`assigned_user_id` IS NULL THEN 1 ELSE 0 END)unassigned FROM `leads` AS l inner join leads_cstm AS lc on l.id=lc.id_c WHERE l.deleted=0 $wherecl GROUP BY lc.te_ba_batch_id_c,l.`dristi_campagain_id`,l.status";

			//echo $leadSql;exit();
			$leadObj = $db->query($leadSql);
			
			$programList = array();
			while ($row = $db->fetchByAssoc($leadObj))
			{
				$batch_id = !empty($row['te_ba_batch_id_c']) ? $row['te_ba_batch_id_c'] : 'NA';
				$manager_id = !empty($row['dristi_campagain_id']) ? $row['dristi_campagain_id'] : 'NA';
				//echo $batch_id;exit();
				$programList[$batch_id .'_ManagerID_'.$manager_id]['name']   = $BatchListData[$batch_id]['name'];
				$programList[$batch_id .'_ManagerID_'.$manager_id]['batch_code']   = $BatchListData[$batch_id]['batch_code'];
				$programList[$batch_id .'_ManagerID_'.$manager_id]['manager_id']   = $manager_id;
				$programList[$batch_id .'_ManagerID_'.$manager_id]['unassigned'][]   = $row['unassigned'];
				$programList[$batch_id .'_ManagerID_'.$manager_id][strtolower($row['status'])][]   = $row['total'];
				
			}
			//echo "<pre>".count($programList);print_r($programList);exit();
			foreach($programList as $key=>$val){
				$total=0;
				foreach ($statusArr as $key1=>$value){
					$countedLead = (!empty($programList[$key][$key1])? array_sum($programList[$key][$key1]) : 0);
					$programList[$key][$key1] = $countedLead;
					$total      += $countedLead;
				}
				$programList[$key]['unassigned']   = array_sum($programList[$key]['unassigned']);
				$programList[$key]['total']   = $total;
			}

            # Create heading
            $data = "Manager ID";
		    $data .= ",Batch Name";
		    $data .= ",Batch Code";
            $data .= ",Total Lead";
			$data .= ",Leads Assigned";
			$data .= ",Leads Un-assigned";
			$data .= ",".implode(',',$statusArr);
            $data .= "\n";



            //echo "<pre>";print_r($programList);exit();
            foreach ($programList as $key => $councelor)
            {
				$assigned = $councelor['total']-$councelor['unassigned'];
                $data .= "\"" . $councelor['manager_id'];
                $data .= "\",\"" . $councelor['name'];
                $data .= "\",\"" . $councelor['batch_code'];
                $data .= "\",\"" . $councelor['total'];
                $data .= "\",\"" . $assigned;
                $data .= "\",\"" . $councelor['unassigned'];
                foreach($statusArr as $key1=>$val){
                    $data      .= "\",\"" . $programList[$key][$key1];
				}
                $data .= "\"\n";
            }

            ob_end_clean();
            header("Content-type: application/csv");
            header('Content-disposition: attachment;filename=" ' . $filename . '.csv";');
            echo $data;
            exit;
        } // End Of Export Func








        $leadSql = "SELECT count(l.id)total,lc.te_ba_batch_id_c,l.dristi_campagain_id,l.status,SUM(CASE WHEN l.`assigned_user_id` IN ('','NULL') OR l.`assigned_user_id` IS NULL THEN 1 ELSE 0 END)unassigned FROM `leads` AS l inner join leads_cstm AS lc on l.id=lc.id_c WHERE l.deleted=0 $wherecl GROUP BY lc.te_ba_batch_id_c,l.`dristi_campagain_id`,l.status";

		//echo $leadSql;exit();
        $leadObj = $db->query($leadSql);
		
		$programList = array();
        while ($row = $db->fetchByAssoc($leadObj))
        {
			$batch_id = !empty($row['te_ba_batch_id_c']) ? $row['te_ba_batch_id_c'] : 'NA';
			$manager_id = !empty($row['dristi_campagain_id']) ? $row['dristi_campagain_id'] : 'NA';
			//echo $batch_id;exit();
            $programList[$batch_id .'_ManagerID_'.$manager_id]['name']   = $BatchListData[$batch_id]['name'];
            $programList[$batch_id .'_ManagerID_'.$manager_id]['batch_code']   = $BatchListData[$batch_id]['batch_code'];
			$programList[$batch_id .'_ManagerID_'.$manager_id]['manager_id']   = $manager_id;
            $programList[$batch_id .'_ManagerID_'.$manager_id]['unassigned'][]   = $row['unassigned'];
			$programList[$batch_id .'_ManagerID_'.$manager_id][strtolower($row['status'])][]   = $row['total'];
			
        }
		//echo "<pre>".count($programList);print_r($programList);exit();
		foreach($programList as $key=>$val){
			$total=0;
			foreach ($statusArr as $key1=>$value){
				$countedLead = (!empty($programList[$key][$key1])? array_sum($programList[$key][$key1]) : 0);
				$programList[$key][$key1] = $countedLead;
				$total      += $countedLead;
			}
			$programList[$key]['unassigned']   = array_sum($programList[$key]['unassigned']);
			$programList[$key]['total']   = $total;
		}
		//echo "<pre>".count($programList);print_r($programList);exit();

        
	
        //echo '<pre>';print_r($programList); die;
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
        $sugarSmarty->assign("StausListData", $statusArr);
        $sugarSmarty->assign("CounselorList", $usersdd);
        $sugarSmarty->assign("selected_vendor", $selected_vendor);
        $sugarSmarty->assign("selected_from_date", $selected_from_date);
        $sugarSmarty->assign("selected_to_date", $selected_to_date);
        $sugarSmarty->assign("selected_counselor", $selected_counselor);

        $sugarSmarty->assign("current_records", $current);
        $sugarSmarty->assign("page", $page);
        $sugarSmarty->assign("pagenext", $pagenext);
        $sugarSmarty->assign("right", $right);
        $sugarSmarty->assign("left", $left);
        $sugarSmarty->assign("last_page", $last_page);
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/mangerwiseleadstatusreport.tpl');
    }

}

?>
