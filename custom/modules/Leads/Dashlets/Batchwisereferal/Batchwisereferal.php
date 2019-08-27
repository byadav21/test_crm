<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('include/Dashlets/Dashlet.php');
require_once('include/Sugar_Smarty.php');
require_once('include/TimeDate.php');
//==>9650211216@engenia.in
class Batchwisereferal extends Dashlet{ 
    protected $top_counsellor = '';
    protected $height = '200'; // height of the pad
    protected $images_dir = 'modules/Home/Dashlets/RSSDashlet/images';
	var $report_to_id;
	var $report_to_id1;
    /**
     * Constructor 
     * 
     * @global string current language
     * @param guid $id id for the current dashlet (assigned from Home module)
     * @param array $def options saved for this dashlet
     */
    public function __construct($id, $def) 
    {        	

		if(!empty($def['top_counsellor'])){
            $this->top_counsellor = $def['top_counsellor'];
        }else{			       
			$this->top_counsellor=10;
		} 		
		if(!empty($def['height'])) // set a default height if none is set
        $this->height = $def['height'];		
        $this->loadLanguage('RSSDashlet', 'modules/Home/Dashlets/'); // load the language strings here            
        $this->title="Batch WiseReferals";
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
        $ss->assign('top_counsellor', $this->top_counsellor);
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
		$ss->assign('top_counsellor', $this->top_counsellor);
        $ss->assign('id', $this->id);
		if($this->isAutoRefreshable()) {
       		$ss->assign('isRefreshable', true);
			$ss->assign('autoRefresh', $GLOBALS['app_strings']['LBL_DASHLET_CONFIGURE_AUTOREFRESH']);
			$ss->assign('autoRefreshOptions', $this->getAutoRefreshOptions());
			$ss->assign('autoRefreshSelect', $this->autoRefresh);
		}
		 return parent::displayOptions() . $ss->fetch('custom/modules/Leads/Dashlets/Counsellorwiseleadstatus/CounsellorwiseleadstatusOptions.tpl');
    }  
	/**
     * called to filter out $_REQUEST object when the user submits the configure dropdown
     * 
     * @param array $req $_REQUEST
     * @return array filtered options to save
     */  
    public function saveOptions(array $req){
        $options = array();
        $options['title'] = $req['title'];
        $options['top_counsellor'] = $req['top_counsellor'];
        $options['height'] = $req['height'];
        $options['autoRefresh'] = empty($req['autoRefresh']) ? '0' : $req['autoRefresh'];        
        return $options;
    }
   
		
    protected function getCurrentBenchOutput()
    {
           return false;		
		global $sugar_config,$app_list_strings,$current_user,$db;
        $leadsData=array();
		$user_id=$current_user->id;
		$this->report_to_id[]=$user_id;
		$users = $this->reportingUser($user_id);
		//print_r($users);
		//print_r($this->report_to_id);
		$uid=$this->report_to_id;
		
			
		//echo "hi123";
		//echo '<pre>';
		//print_r($users); 
		//print_r($this->report_to_id);
		
		//ers();
		$users='';
		foreach($uid as $Usr){
			$users= "'$Usr',";
		}
		$users .=substr($users,0,strlen($users)-1);
		$leadQuery="select te_ba_batch.id,te_ba_batch.name,count(leads.id) as TotalLead ,fees_inr  from leads inner join leads_cstm on leads_cstm.id_c=leads.id and leads_cstm.te_ba_batch_id_c!='' and leads.deleted=0   ";
		if(!is_admin($current_user) && $users) $leadQuery .=" and assigned_user_id in ($users)";
		$leadQuery .=" inner join te_ba_batch on leads_cstm.te_ba_batch_id_c=te_ba_batch.id
		group by te_ba_batch.id,te_ba_batch.name,fees_inr having totalLead >0 order by totalLead desc ";
		 		
        $output = "<div class='bd-center'><table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>";
		$output.=' <tr height="20">
        	        <th scope="col" width="30%" >
						<div style="white-space: normal;" width="100%" align="left">Batch</div>
					</th>
        	        <th scope="col" width="30%">
						<div style="white-space: normal;" width="100%" align="center">Total Lead</div>
					</th>
					<th scope="col" width="30%">
						<div style="white-space: normal;" width="100%" align="center">Converted</div>
					</th>
					<th scope="col" width="30%">
						<div style="white-space: normal;" width="100%" align="center">Referals</div>
					</th>	
					<th scope="col" width="30%">
						<div style="white-space: normal;" width="100%" align="center">GSV</div>
					</th>
					</th>	
					 					
		    </tr>';
		$row=1;
		$leadsData=$db->query($leadQuery);
		while($data=$db->fetchByAssoc($leadsData)){			
			if($row==1){
				$class="oddListRowS1";
				$row++;
			}else{
				$class="evenListRowS1";
				$row--;
			}
			
			 $leadQuery="select count(leads.id) as conv from leads inner join leads_cstm on leads_cstm.id_c=leads.id and leads_cstm.te_ba_batch_id_c='". $data['id'] . "' and leads.deleted=0  and leads.status='Converted' ";
			 if(!is_admin($current_user) && $users) $leadQuery .=" and assigned_user_id in ($users)";			 
			 $leadsDataConverteds=$db->query($leadQuery);
			 $converted=$db->fetchByAssoc($leadsDataConverteds);
			
			 $leadQuery="select count(leads.id) as conv from leads inner join leads_cstm on leads_cstm.id_c=leads.id and leads_cstm.te_ba_batch_id_c='". $data['id'] . "' and leads.deleted=0  and leads.parent_type='Leads' and   (leads.parent_id is not null or leads.parent_id!='' ) ";
			 if(!is_admin($current_user) && $users) $leadQuery .=" and assigned_user_id in ($users)";			 
			 $leadsDataConverteds=$db->query($leadQuery);
			 $referalls=$db->fetchByAssoc($leadsDataConverteds);
			 
			$output.="<tr class='".$class."' height='20'><td scope='row' align='left' valign='top'>".$data['name']."</td><td scope='row' align='center' valign='top'>". intval($data['TotalLead'])."</td><td scope='row' align='center' valign='top'>".intval($converted['conv'])."</td><td scope='row' align='center' valign='top'>".intval($referalls['conv'])."</td><td scope='row' align='center' valign='top'>". intval($data['TotalLead']) * floatval($data['fees_inr'])."</td></tr>";
			}		
			$output.="</table></div>";
        //$GLOBALS['log']->fatal($trackerData);
        return $output;
    }
    
   function reportingUser($currentUserId){
		
			$userObj = new User();
			$userObj->disable_row_level_security = true;
			
			$userList = $userObj->get_full_list("", "users.reports_to_id='".$currentUserId."'");
             
			if(!empty($userList)){
				//echo "<pre>";print_r($userList);
				//echo $userList[0]->id;exit();
				foreach($userList as $record){
                                    
					if(!empty($record->reports_to_id) && !empty($record->id)){
					
						$this->report_to_id[] = $record->id;
						$this->reportingUser($record->id);
					}
				}
			}
		}
		
    
	
}

?>
