<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('include/Dashlets/Dashlet.php');
require_once('include/Sugar_Smarty.php');
require_once('include/TimeDate.php');
class SRM_wise_referral extends Dashlet{
    protected $SRM_wise_referral = '';
    protected $height = '200'; // height of the pad
    protected $images_dir = 'modules/Home/Dashlets/RSSDashlet/images';

    /**
     * Constructor
     *
     * @global string current language
     * @param guid $id id for the current dashlet (assigned from Home module)
     * @param array $def options saved for this dashlet
     */
    public function __construct($id, $def)
    {

		if(!empty($def['SRM_wise_referral'])){
            $this->SRM_wise_referral = $def['SRM_wise_referral'];
        }else{
			$this->SRM_wise_referral=10;
		}
		if(!empty($def['height'])) // set a default height if none is set
           $this->height = $def['height'];
        $this->loadLanguage('RSSDashlet', 'modules/Home/Dashlets/'); // load the language strings here
        $this->title="SRM wise Referral";
		if(isset($def['autoRefresh'])) $this->autoRefresh = $def['autoRefresh'];
        parent::Dashlet($id); // call parent constructor
        $this->isConfigurable = true; // dashlet is configurable
        $this->hasScript = false;  // dashlet has javascript attached to it


    }

    /**
     * Displays the dashlet
     *
     * @return string html to display dashlet
     */

    public function display()
    {

        $ss = new Sugar_Smarty();
        $ss->assign('saving', $this->dashletStrings['LBL_SAVING']);
        $ss->assign('saved', $this->dashletStrings['LBL_SAVED']);
        $ss->assign('id', $this->id);
		$ss->assign('height', $this->height);
        $ss->assign('SRM_wise_referral', $this->SRM_wise_referral);
        $ss->assign('rss_output', $this->getCurrentBenchOutput());
        $str = $ss->fetch('modules/Home/Dashlets/RSSDashlet/RSSDashlet.tpl');
        return parent::display($this->dashletStrings['LBL_DBLCLICK_HELP']) . $str; // return parent::display for title and such
    }

    /**
     * Displays the configuration form for the dashlet
     *
     * @return string html to display form
     */
    public function displayOptions(){
        global $app_strings, $sugar_version, $sugar_config,$current_user;
        $ss = new Sugar_Smarty();
        $ss->assign('titleLbl', $this->dashletStrings['LBL_CONFIGURE_TITLE']);
        $ss->assign('heightLbl', $this->dashletStrings['LBL_CONFIGURE_HEIGHT']);
		$ss->assign('saveLbl', $app_strings['LBL_SAVE_BUTTON_LABEL']);
        $ss->assign('title', $this->title);
        $ss->assign('height', $this->height);
		$ss->assign('SRM_wise_referral', $this->SRM_wise_referral);
        $ss->assign('id', $this->id);
		if($this->isAutoRefreshable()) {
       		$ss->assign('isRefreshable', true);
			$ss->assign('autoRefresh', $GLOBALS['app_strings']['LBL_DASHLET_CONFIGURE_AUTOREFRESH']);
			$ss->assign('autoRefreshOptions', $this->getAutoRefreshOptions());
			$ss->assign('autoRefreshSelect', $this->autoRefresh);
		}
		 return parent::displayOptions() . $ss->fetch('custom/modules/te_student_batch/Dashlets/SRM wise referral/SRM_wise_referralOptions.tpl');
    }
	/**
     * called to filter out $_REQUEST object when the user submits the configure dropdown
     *
     * @param array $req $_REQUEST @manish
     * @return array filtered options to save
     */
    public function saveOptions(array $req){
        $options = array();
        $options['title'] = $req['title'];
        $options['SRM_wise_referral'] = $req['SRM_wise_referral'];
        $options['height'] = $req['height'];
        $options['autoRefresh'] = empty($req['autoRefresh']) ? '0' : $req['autoRefresh'];
        return $options;
    }
    protected function getCurrentBenchOutput()
    {

		global $sugar_config,$app_list_strings,$current_user,$overallusers_res,$overallusers,$overallusers_str;
        $leadsData=array();
		    $user_id=$current_user->id;
        $users_str='';

			/*$this->report_to_id[]=$user_id;
			$users = $this->reportingUser($user_id);
			$uid=$this->report_to_id;
			$str = implode("','",$uid);*/

      $UserQuery ="SELECT is_admin FROM `users` WHERE id='".$user_id."'";
   	  $userObj=$resultDate=$GLOBALS['db']->query($UserQuery);
      $is_admin = 0;
      while($row=$GLOBALS['db']->fetchByAssoc($userObj)){
   		   $is_admin=$row['is_admin'];
   		}
      $overallusers=$this->get_users_for_admin();
      if($overallusers){
        $overallusers_str = "'".implode("','", $overallusers)."'";
        if($overallusers){
            $overallusers_sql = "SELECT (SELECT count(*) FROM leads WHERE (leads.created_by IN($overallusers_str) OR leads.parent_id IN($overallusers_str)) AND leads.deleted=0 AND leads.lead_source='Referrals')totalref,(SELECT count(*) FROM leads WHERE (leads.created_by IN($overallusers_str) OR leads.parent_id IN($overallusers_str)) AND leads.deleted=0 AND leads.lead_source='Referrals' AND leads.status='Converted')totalrefConverted FROM leads LIMIT 0,1";
            $overallusersObj = $GLOBALS['db']->query($overallusers_sql);
            $overallusers_res = $GLOBALS['db']->fetchByAssoc($overallusersObj);

        }

      }

      if($is_admin==1){
        $users=$this->get_users_for_admin();
        if($users){
          $users_str = "'".implode("','", $users)."'";
        }

        //echo "hello".$users_str;exit();
      }
      else{
        $SRMRoles = array('86800aa5-c8c2-5868-a690-58a88d188265','30957fe0-3494-e372-656d-58a9a6296516');
        $userRole = $this->check_user_role();
        if(!empty($userRole)){
          if(array_intersect($SRMRoles,$userRole)){
            $users=$this->reportingUser($user_id);
            $uid=$this->report_to_id;
            if(empty($uid)){
              $uid[0]=$user_id;
            }
            else{
             array_push($uid,$user_id);
            }

      			$users_str = "'".implode("','", $uid)."'";
          }
        }


      }

      if($users_str){
        /*$leadQuery ="SELECT concat(u.first_name,' ',u.last_name)userfullname,(SELECT count(*) FROM leads WHERE leads.deleted=0 AND leads.lead_source='Referrals' AND (leads.created_by IN($users_str) OR leads.parent_id IN($users_str)))toalreferral,(SELECT count(*) FROM leads WHERE leads.deleted=0 AND leads.lead_source='Referrals' AND (leads.created_by=u.id OR leads.parent_id=u.id))referral,(SELECT count(*) FROM leads WHERE leads.deleted=0 AND leads.lead_source='Referrals' AND leads.status='Converted' AND (leads.created_by=u.id OR leads.parent_id=u.id))conreferral from users AS u LEFT JOIN leads AS l ON l.created_by=u.id OR l.parent_id=u.id AND l.lead_source='Referrals'  WHERE u.id IN($users_str) GROUP BY u.id LIMIT 0 ,".$this->SRM_wise_referral;
  	    $leadObj=$GLOBALS['db']->query($leadQuery);
          while($row=$GLOBALS['db']->fetchByAssoc($leadObj)){
  			  $leadsData[]=$row;
  		  }*/
  		  $leadsData[]=array();

      }

        $output = "<div class='bd-center'><table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>";
		$output.=' <tr height="20">
        	        <th scope="col" width="20%">
						<div style="white-space: normal;" width="100%" align="left">SRM</div>
					</th>
        	        <th scope="col" width="10%">
						<div style="white-space: normal;" width="100%" align="left">Referral</div>
					</th>
					 <th scope="col" width="20%">
						<div style="white-space: normal;" width="100%" align="left">Team Contribution</div>
					</th>
					<th scope="col" width="10%">
						<div style="white-space: normal;" width="100%" align="left">Ref.Converted</div>
					</th>
          <th scope="col" width="20%">
						<div style="white-space: normal;" width="100%" align="left">Referral Conversion %</div>
					</th>
		    </tr>';
		$row=1;
    $class="evenListRowS1";

      if($leadsData){
        $totalref='';$totalteamcon='';$totalcon='';
        foreach($leadsData as $data1){
          if($row==1){
    				$class="oddListRowS1";
    				$row++;
    			}else{
    				$class="evenListRowS1";
    				$row--;
    			}
          $teamcontribution = ($data1['referral']/$overallusers_res['totalref'])*100;
          $teamcontribution=number_format((float)$teamcontribution, 2, '.', '');
          $refcoversion = ($data1['conreferral']/$data1['referral'])*100;
          $refcoversion=number_format((float)$refcoversion, 2, '.', '');

          $totalcon[]=$data1['conreferral'];
          $totalteamcon[]=$teamcontribution;
          $totalref[]=$data1['referral'];

            $output.="<tr class='".$class."' height='20'><td scope='row' align='left' valign='top'>".$data1['userfullname']."</td><td scope='row' align='left' valign='top'>".$data1['referral']."</td><td scope='row' align='left' valign='top'>".$teamcontribution."%</td><td scope='row' align='left' valign='top'>".$data1['conreferral']."</td><td scope='row' align='left' valign='top'>".$refcoversion."%</td></tr>";
        }

        if($overallusers_res){
            $totalrefconper=($overallusers_res['totalrefConverted']/$overallusers_res['totalref'])*100;
            $totalrefconper=number_format((float)$totalrefconper, 2, '.', '');
            $totalteamcon=($overallusers_res['totalref']/$overallusers_res['totalref'])*100;
            $totalteamcon=number_format((float)$totalteamcon, 2, '.', '');
            $output.="<tr class='".$class."' height='20'><td scope='row' align='left' valign='top'>Overall</td><td scope='row' align='left' valign='top'>".$overallusers_res['totalref']."</td><td scope='row' align='left' valign='top'>".$totalteamcon."%</td><td scope='row' align='left' valign='top'>".$overallusers_res['totalrefConverted']."</td><td scope='row' align='left' valign='top'>".$totalrefconper."%</td></tr>";
        }

      }

		$output.="</table></div>";
        return $output;
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
      function check_user_role(){
        global $sugar_config,$app_list_strings,$current_user;
        $roles=array();
    		$user_id=$current_user->id;
        $leadQuery ="SELECT distinct(ru.role_id) FROM `acl_roles` AS r INNER JOIN acl_roles_users AS ru ON ru.role_id=r.id AND ru.user_id='".$user_id."'";
     	  $leadObj=$resultDate=$GLOBALS['db']->query($leadQuery);
             while($row=$GLOBALS['db']->fetchByAssoc($leadObj)){
                 if(isset($row['role_id']) && !empty($row['role_id'])){
                   $roles[]=$row['role_id'];
                 }

     		}
        return $roles;

      }

      function get_users_for_admin(){
        global $sugar_config,$app_list_strings,$current_user;
        $users=array();
    		$user_id=$current_user->id;
        $leadQuery ="SELECT ru.user_id FROM `acl_roles` AS r INNER JOIN acl_roles_users AS ru ON ru.role_id=r.id AND r.id IN('86800aa5-c8c2-5868-a690-58a88d188265','30957fe0-3494-e372-656d-58a9a6296516')";
     	  $leadObj=$resultDate=$GLOBALS['db']->query($leadQuery);
             while($row=$GLOBALS['db']->fetchByAssoc($leadObj)){
               if(isset($row['user_id']) && !empty($row['user_id'])){
                 $users[]=$row['user_id'];
               }

     		}
        return $users;

      }

}
// @Anup Kumar
?>
