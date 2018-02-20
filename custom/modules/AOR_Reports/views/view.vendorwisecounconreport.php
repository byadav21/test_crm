<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');
class AOR_ReportsViewVendorwisecounconreport extends SugarView
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
    function getVendor()
    {
        global $db;
        $vendorSql     = "SELECT id,name FROM te_vendor WHERE deleted=0";
        $vendorObj     = $db->query($vendorSql);
        $vendorOptions = array();
        while ($row          = $db->fetchByAssoc($vendorObj))
        {
            $vendorOptions[] = $row;
        }
        return $vendorOptions;
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
		$VendorListData = $this->getVendor();
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
		if(!isset($_SESSION['cccon_counselor'])){
			$_SESSION['cccon_counselor'] = array_keys($usersdd);
		}
        if (isset($_POST['button']) || isset($_POST['export']))
        {
            $_SESSION['cccon_from_date']  = $_REQUEST['from_date'];
            $_SESSION['cccon_to_date']    = $_REQUEST['to_date'];
            $_SESSION['cccon_vendor']      = $_REQUEST['vendor'];
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
        if (!empty($_SESSION['cccon_vendor']))
        {
            $selected_vendor = $_SESSION['cccon_vendor'];
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
        if (!empty($selected_vendor))
        {
			$vendorArr = [];
			foreach($selected_vendor as $val){
				$vendorArr[]=strtolower($val);
			}
            $wherecl .= " AND  l.vendor IN ('" . implode("','", $selected_vendor) . "')";
        }
        
		if (!empty($selected_counselor))
        {

            $wherecl .= " AND  l.assigned_user_id IN ('" . implode("','", $selected_counselor) . "')";
        }
		
		$statusArr = ['alive','dead','converted','warm','recycle','dropout'];

        if (isset($_POST['export']) && $_POST['export'] == "Export")
        {



            $file     = "VendorWiseCounselorConversion_report";
            $where    = '';
            $filename = $file . "_" . $from_date . "_" . $to_date;

            $leadSql = "SELECT COUNT(l.id) AS lead_count, l.status,LOWER(l.vendor)vendor,l.assigned_user_id FROM leads l WHERE l.deleted=0  $wherecl GROUP BY l.status,l.vendor,l.assigned_user_id";


			$leadObj = $db->query($leadSql);		
			while ($row = $db->fetchByAssoc($leadObj))
			{
			   
				$programList[$row['assigned_user_id'] .'_VENDOR_'.$row['vendor']]['vendor']   = $row['vendor'];
				$programList[$row['assigned_user_id'] .'_VENDOR_'.$row['vendor']]['assigned_user']   = !empty($row['assigned_user_id']) ? $usersdd[$row['assigned_user_id']]['name'] : 'NA';
				$programList[$row['assigned_user_id'] .'_VENDOR_'.$row['vendor']][strtolower($row['status'])]   = $row['lead_count'];
				
			}
			foreach($programList as $key=>$val){
				$total=0;
				foreach ($statusArr as $value){
					$countedLead = (!empty($programList[$key][$value])? $programList[$key][$value] : 0);
					$total      += $countedLead;
				}
				$programList[$key]['total']   = $total;
			}

            # Create heading
            $data = "Counsellor Name";
		    $data .= "Vendor";
            $data .= ",Total";
			$data .= ",Converted";
            $data .= "\n";



            //echo "<pre>";print_r($programList);exit();
            foreach ($programList as $key => $councelor)
            {
                $data .= "\"" . $councelor['assigned_user'];
                $data .= "\",\"" . $councelor['vendor'];
                
                
                $data .= "\",\"" . $councelor['total'];
				$data .= "\",\"" . (!empty($councelor['converted'])? $councelor['converted'] : 0);
                $data .= "\"\n";
            }

            ob_end_clean();
            header("Content-type: application/csv");
            header('Content-disposition: attachment;filename=" ' . $filename . '.csv";');
            echo $data;
            exit;
        } // End Of Export Func








        $leadSql = "SELECT COUNT(l.id) AS lead_count, l.status,LOWER(l.vendor)vendor,l.assigned_user_id FROM leads l WHERE l.deleted=0  $wherecl GROUP BY l.status,l.vendor,l.assigned_user_id";


        $leadObj = $db->query($leadSql);		
        while ($row = $db->fetchByAssoc($leadObj))
        {
           
            $programList[$row['assigned_user_id'] .'_VENDOR_'.$row['vendor']]['vendor']   = $row['vendor'];
            $programList[$row['assigned_user_id'] .'_VENDOR_'.$row['vendor']]['assigned_user']   = !empty($row['assigned_user_id']) ? $usersdd[$row['assigned_user_id']]['name'] : 'NA';
			$programList[$row['assigned_user_id'] .'_VENDOR_'.$row['vendor']][strtolower($row['status'])]   = $row['lead_count'];
			
        }
		foreach($programList as $key=>$val){
			$total=0;
			foreach ($statusArr as $value){
				$countedLead = (!empty($programList[$key][$value])? $programList[$key][$value] : 0);
				$total      += $countedLead;
			}
			$programList[$key]['total']   = $total;
		}

        
	
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
        $sugarSmarty->assign("VendorListData", $VendorListData);
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
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/vendorwisecounconreport.tpl');
    }

}

?>
