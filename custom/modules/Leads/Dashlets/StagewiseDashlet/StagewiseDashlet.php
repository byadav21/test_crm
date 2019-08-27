<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('include/Dashlets/Dashlet.php');
require_once('include/Sugar_Smarty.php');
require_once('include/TimeDate.php');
//9452039224
class StagewiseDashlet extends Dashlet{ 
    protected $StagewiseDashletOptions_dyna = '';
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

		if(!empty($def['StagewiseDashletOptions_dyna'])){
            $this->StagewiseDashletOptions_dyna = $def['StagewiseDashletOptions_dyna'];
        }else{			       
			$this->StagewiseDashletOptions_dyna=10;
		} 		
		if(!empty($def['height'])) // set a default height if none is set
           $this->height = $def['height'];		
        $this->loadLanguage('RSSDashlet', 'modules/Home/Dashlets/'); // load the language strings here            
        $this->title="Stage wise Count Leads";
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
        $ss->assign('StagewiseDashletOptions_dyna', $this->StagewiseDashletOptions_dyna);
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
		$ss->assign('StagewiseDashletOptions_dyna', $this->StagewiseDashletOptions_dyna);
        $ss->assign('id', $this->id);
		if($this->isAutoRefreshable()) {
       		$ss->assign('isRefreshable', true);
			$ss->assign('autoRefresh', $GLOBALS['app_strings']['LBL_DASHLET_CONFIGURE_AUTOREFRESH']);
			$ss->assign('autoRefreshOptions', $this->getAutoRefreshOptions());
			$ss->assign('autoRefreshSelect', $this->autoRefresh);
		}
		 return parent::displayOptions() . $ss->fetch('custom/modules/Leads/Dashlets/StagewiseDashlet/StagewiseDashletOptions.tpl');
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
        $options['StagewiseDashletOptions_dyna'] = $req['StagewiseDashletOptions_dyna'];
        $options['height'] = $req['height'];
        $options['autoRefresh'] = empty($req['autoRefresh']) ? '0' : $req['autoRefresh'];        
        return $options;
    }
    protected function getCurrentBenchOutput()
    {
		
		global $sugar_config,$app_list_strings,$current_user;
        $leadsData=array();
		$user_id=$current_user->id;
		
		$user_id=$current_user->id;
		$this->report_to_id[]=$user_id;
		$users = $this->reportingUser($user_id);
		//print_r($users);
		//print_r($this->report_to_id);
		$uid=$this->report_to_id;
		
		$str = implode("','",$uid);
		
		$leadQuery="select status, count(status) as statuscount from leads where assigned_user_id IN('".$str."') group by status limit 0,".$this->StagewiseDashletOptions_dyna;
		$leadObj=$resultDate=$GLOBALS['db']->query($leadQuery);			  
        while($row=$GLOBALS['db']->fetchByAssoc($leadObj)){	
			$leadsData[]=$row;			 
		}		
        $output = "<div class='bd-center'><table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>";
		$output.=' <tr height="20">
        	        <th scope="col" width="30%" >
						<div style="white-space: normal;" width="100%" align="left">Status</div>
					</th>
        	        <th scope="col" width="30%">
						<div style="white-space: normal;" width="100%" align="center">Leads Count</div>
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
		//	$converted=$this->getConvertedLeads($data['id']);
			$output.="<tr class='".$class."' height='20'><td scope='row' align='left' valign='top'>".ucwords($data['status'])."</td><td scope='row' align='center' valign='top'>".$data['statuscount']."</td></tr>";
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
