<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('include/Dashlets/Dashlet.php');
require_once('include/Sugar_Smarty.php');
require_once('include/TimeDate.php');
//==>9650211216@engenia.in
class Counsellorwiseleadstatus extends Dashlet{ 
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
        $this->title="Counsellor Wise Lead Status";
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
		
		global $sugar_config,$app_list_strings,$current_user;
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
		
		//exit();
		 		
		foreach($uid as $Usr){
			
			
	   $leadQuery="SELECT users.first_name,users.last_name,(SELECT COUNT(leads.id) FROM leads WHERE leads.status='Alive' AND leads.deleted=0 AND leads.assigned_user_id='".$Usr."')Alive,(SELECT COUNT(leads.id) FROM leads WHERE leads.status='Warm' AND leads.deleted=0 AND leads.assigned_user_id='".$Usr."')Warm,(SELECT COUNT(leads.id) FROM leads WHERE leads.status='Dead' AND leads.deleted=0 AND leads.assigned_user_id='".$Usr."')Dead,(SELECT COUNT(leads.id) FROM leads WHERE leads.status='Converted' AND leads.deleted=0 AND leads.assigned_user_id='".$Usr."')Converted,(SELECT COUNT(leads.id) FROM leads WHERE leads.status='Duplicate' AND leads.deleted=0 AND leads.assigned_user_id='".$Usr."')Duplicate  FROM leads INNER JOIN users ON users.id=leads.assigned_user_id WHERE leads.deleted=0 AND leads.assigned_user_id='".$Usr."' GROUP BY leads.assigned_user_id";
      
	    $leadObj=$resultDate=$GLOBALS['db']->query($leadQuery);			  
        while($row=$GLOBALS['db']->fetchByAssoc($leadObj)){	
			$leadsData[]=$row;			 
		}
	}		
        $output = "<div class='bd-center'><table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>";
		$output.=' <tr height="20">
        	        <th scope="col" width="30%" >
						<div style="white-space: normal;" width="100%" align="left">Agents</div>
					</th>
        	        <th scope="col" width="30%">
						<div style="white-space: normal;" width="100%" align="center">Alive</div>
					</th>
					<th scope="col" width="30%">
						<div style="white-space: normal;" width="100%" align="center">Warm</div>
					</th>
					<th scope="col" width="30%">
						<div style="white-space: normal;" width="100%" align="center">Dead</div>
					</th>	
					<th scope="col" width="30%">
						<div style="white-space: normal;" width="100%" align="center">Converted</div>
					</th>
					</th>	
					<th scope="col" width="30%">
						<div style="white-space: normal;" width="100%" align="center">Duplicate</div>
					</th>					
		    </tr>';
		$row=1;
		foreach($leadsData as $data){			
			if($row==1){
				$class="oddListRowS1";
				$row++;
			}else{
				$class="evenListRowS1";
				$row--;
			}
			$sts=ucwords($data['status']);
			$spl=str_replace("_"," ",$sts);
		//$converted=$this->getConvertedLeads($data['id']);
			$output.="<tr class='".$class."' height='20'><td scope='row' align='left' valign='top'>".$data['first_name'].$data['last_name']."</td><td scope='row' align='center' valign='top'>".$data['Alive']."</td><td scope='row' align='center' valign='top'>".$data['Warm']."</td><td scope='row' align='center' valign='top'>".$data['Dead']."</td><td scope='row' align='center' valign='top'>".$data['Converted']."</td><td scope='row' align='center' valign='top'>".$data['Duplicate']."</td></tr>";
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
