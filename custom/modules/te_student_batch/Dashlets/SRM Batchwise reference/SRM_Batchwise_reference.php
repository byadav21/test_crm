<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('include/Dashlets/Dashlet.php');
require_once('include/Sugar_Smarty.php');
require_once('include/TimeDate.php');
class SRM_Batchwise_reference extends Dashlet{
    protected $SRM_Batchwise_reference = '';
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

		if(!empty($def['SRM_Batchwise_reference'])){
            $this->SRM_Batchwise_reference = $def['SRM_Batchwise_reference'];
        }else{
			$this->SRM_Batchwise_reference=10;
		}
		if(!empty($def['height'])) // set a default height if none is set
           $this->height = $def['height'];
        $this->loadLanguage('RSSDashlet', 'modules/Home/Dashlets/'); // load the language strings here
        $this->title="SRM Batchwise Reference";
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
        $ss->assign('SRM_Batchwise_reference', $this->SRM_Batchwise_reference);
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
		$ss->assign('SRM_Batchwise_reference', $this->SRM_Batchwise_reference);
        $ss->assign('id', $this->id);
		if($this->isAutoRefreshable()) {
       		$ss->assign('isRefreshable', true);
			$ss->assign('autoRefresh', $GLOBALS['app_strings']['LBL_DASHLET_CONFIGURE_AUTOREFRESH']);
			$ss->assign('autoRefreshOptions', $this->getAutoRefreshOptions());
			$ss->assign('autoRefreshSelect', $this->autoRefresh);
		}
		 return parent::displayOptions() . $ss->fetch('custom/modules/te_student_batch/Dashlets/SRM Batchwise reference/SRM_Batchwise_referenceOptions.tpl');
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
        $options['SRM_Batchwise_reference'] = $req['SRM_Batchwise_reference'];
        $options['height'] = $req['height'];
        $options['autoRefresh'] = empty($req['autoRefresh']) ? '0' : $req['autoRefresh'];
        return $options;
    }
    protected function getCurrentBenchOutput()
    {
		global $sugar_config,$app_list_strings,$current_user;
        $leadsData=array();
		    $user_id=$current_user->id;
        $users_str='';

      $UserQuery ="SELECT is_admin FROM `users` WHERE id='".$user_id."'";
   	  $userObj=$resultDate=$GLOBALS['db']->query($UserQuery);
      $is_admin = 0;
      while($row=$GLOBALS['db']->fetchByAssoc($userObj)){
   		   $is_admin=$row['is_admin'];
   		}

      if($is_admin==1){
        $users=$this->get_users_for_admin();
        if($users){
          $users_str = "'".implode("','", $users)."'";
        }

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
      $userArr='';
      $batchArr=$this->get_batch_list();
      if($users_str){
        $userArr=$this->get_users_list($users_str);
      }

      if($userArr && $batchArr){
        $output = "<div class='bd-center'><table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>";
    $output.=' <tr height="20">
                  <th scope="col" width="20%">
            <div style="white-space: normal;" width="100%" align="left">Batch</div>
          </th>';
          foreach($userArr as $val){
              $output.='<th scope="col">
                      <div style="white-space: normal;" width="100%" align="left">'.$val['name'].'</div>
                    </th>';
          }
    $output.='</tr>';
    $row=1;$class="evenListRowS1";
    foreach($batchArr as $bval){
      if($row==1){
        $class="oddListRowS1";
        $row++;
      }else{
        $class="evenListRowS1";
        $row--;
      }
      $output.='<tr height="20" class="'.$class.'"><td scope="row" align="left" valign="top">'.$bval["name"].'</td>';
      foreach($userArr as $uval){
        $refcount = $this->get_referal($bval["id"],$uval["id"]);
        $output.='<td scope="row" align="left" valign="top">'.$refcount.'</td>';
      }
      $output.='</tr>';
    }
    $output.="</table></div>";
    return $output;
      }
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

      function get_batch_list(){
        global $sugar_config,$app_list_strings,$current_user;
        $batch=array();
        $leadQuery ="SELECT b.name,b.id FROM te_ba_batch AS b INNER JOIN leads_cstm ON leads_cstm.te_ba_batch_id_c=b.id AND b.deleted=0 INNER JOIN leads ON leads.id=leads_cstm.id_c GROUP BY b.id";
     	  $leadObj=$resultDate=$GLOBALS['db']->query($leadQuery);
             while($row=$GLOBALS['db']->fetchByAssoc($leadObj)){
                 $batch[]=array('id'=>$row['id'],'name'=>$row['name']);
     		}
        return $batch;
      }

      function get_users_list($users_str){
        global $sugar_config,$app_list_strings,$current_user;
        $userList=array();
        $leadQuery ="SELECT concat(u.first_name,' ',u.last_name) AS fullname,u.id FROM users u WHERE u.deleted=0 AND u.id IN($users_str)";
     	  $leadObj=$resultDate=$GLOBALS['db']->query($leadQuery);
             while($row=$GLOBALS['db']->fetchByAssoc($leadObj)){
                 $userList[]=array('id'=>$row['id'],'name'=>$row['fullname']);
     		}
        return $userList;

      }

      function get_referal($batchid,$userid){
        global $sugar_config,$app_list_strings,$current_user;
        $leadcount=0;
        $leadQuery ="SELECT count(l.id)totalref FROM leads AS l INNER JOIN leads_cstm AS lc ON l.id=lc.id_c WHERE lc.te_ba_batch_id_c='".$batchid."' AND (l.created_by='".$userid."' OR l.parent_id='".$userid."') GROUP BY lc.te_ba_batch_id_c";
     	  $leadObj=$resultDate=$GLOBALS['db']->query($leadQuery);
             while($row=$GLOBALS['db']->fetchByAssoc($leadObj)){
                if(isset($row['totalref']) && !empty($row['totalref']) && $row['totalref']>0){
                    $leadcount=$row['totalref'];
                }
                else{
                  $leadcount=0;
                }

     		}
        return $leadcount;
      }

}
// @Anup Kumar
?>
