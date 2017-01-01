<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('include/Dashlets/Dashlet.php');
require_once('include/Sugar_Smarty.php');
require_once('include/TimeDate.php');
//@Manish
class TopCampaignDashboard extends Dashlet{ 
    protected $top_camp = '';
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

		if(!empty($def['top_camp'])){
            $this->top_camp = $def['top_camp'];
        }else{			       
			$this->top_camp=10;
		} 		
		if(!empty($def['height'])) // set a default height if none is set
           $this->height = $def['height'];		
        $this->loadLanguage('RSSDashlet', 'modules/Home/Dashlets/'); // load the language strings here            
        $this->title="Top Campaign Dashboard";
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
        $ss->assign('top_camp', $this->top_camp);
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
		$ss->assign('top_camp', $this->top_camp);
        $ss->assign('id', $this->id);
		if($this->isAutoRefreshable()) {
       		$ss->assign('isRefreshable', true);
			$ss->assign('autoRefresh', $GLOBALS['app_strings']['LBL_DASHLET_CONFIGURE_AUTOREFRESH']);
			$ss->assign('autoRefreshOptions', $this->getAutoRefreshOptions());
			$ss->assign('autoRefreshSelect', $this->autoRefresh);
		}
		 return parent::displayOptions() . $ss->fetch('custom/modules/te_utm/Dashlets/TopCampaignDashboard/TopCampaignDashboardOptions.tpl');
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
        $options['top_camp'] = $req['top_camp'];
        $options['height'] = $req['height'];
        $options['autoRefresh'] = empty($req['autoRefresh']) ? '0' : $req['autoRefresh'];        
        return $options;
    }
    protected function getCurrentBenchOutput()
    {
		
		global $sugar_config,$app_list_strings,$current_user;
        $leadsData=array();
		$user_id=$current_user->id;
		date_default_timezone_set("Asia/Kolkata");
		$leadQuery = " SELECT t1.id,t1.name,(SELECT COUNT(l.id) FROM leads l WHERE l.utm = t1.name AND l.deleted = 0) total_leads FROM te_utm t1 INNER JOIN leads l ON t1.name = l.utm  WHERE t1.utm_status = 'Live' GROUP BY t1.name ORDER BY total_leads DESC LIMIT 0 ,".$this->top_camp;
                      
	    $leadObj=$resultDate=$GLOBALS['db']->query($leadQuery);			  
        while($row=$GLOBALS['db']->fetchByAssoc($leadObj)){	
			$leadsData[]=$row;			 
		}		
        $output = "<div class='bd-center'><table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>";
		$output.=' <tr height="20">
        	        <th scope="col" width="30%">
						<div style="white-space: normal;" width="100%" align="left">Live Top Campaigns</div>
					</th>
        	        <th scope="col" width="30%">
						<div style="white-space: normal;" width="100%" align="left">No of Leads</div>
					</th>
					 <th scope="col" width="10%">
						<div style="white-space: normal;" width="100%" align="left">Converted leads</div>
					</th>
					 <th scope="col" width="15%">
						<div style="white-space: normal;" width="100%" align="left">CPL</div>
					</th>
					<th scope="col" width="15%">
						<div style="white-space: normal;" width="100%" align="left">Conversion %</div>
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
			$converted=$this->getConvertedLeads($data['name']);
			$actual = $this->getActuals($data['id']);
			$total_cost_id=$this->getCPLLeads($actual);
		
			$cpl='NA';
			if($total_cost_id!=0)
			{
		     $cpl=$total_cost_id/$data['total_leads'];
		     //$val=number_format((float)$cpl, 2, '.', '');
		    // $val=round($cpl,2);
		    }
			 $output.="<tr class='".$class."' height='20'><td scope='row' align='left' valign='top'>".$data['name']."</td><td scope='row' align='left' valign='top'>".$data['total_leads']."</td><td scope='row' align='left' valign='top'>".$converted."</td><td scope='row' align='left' valign='top'>".round($cpl,2)."</td><td scope='row' align='left' valign='top'>".number_format(($converted*100)/$data['total_leads'],2)."</td></tr>";
		    }		
		     $output.="</table></div>";
        //$GLOBALS['log']->fatal($trackerData);
        return $output;
    }
    //@Converted Leads
	public function getConvertedLeads($batch){
		$leadQuery="select count(*) as total from leads l INNER JOIN leads_cstm lc on l.id=lc.id_c WHERE l.utm='".$batch."' AND l.deleted=0 AND l.status='Converted'";
	    $leadObj=$resultDate=$GLOBALS['db']->query($leadQuery);			  
        $row=$GLOBALS['db']->fetchByAssoc($leadObj)		;
		return $row['total'];
	}
	//@ CPL Calculations
	public function getCPLLeads($ids){
		if($ids){
			$result = "'" . implode ( "', '", explode(',',$ids) ) . "'";
			$leadQuery="select SUM(total_cost) as total from te_actual_campaign WHERE te_actual_campaign.id in($result) ";
			$leadObj=$resultDate=$GLOBALS['db']->query($leadQuery);			  
			$row=$GLOBALS['db']->fetchByAssoc($leadObj);
			return $row['total'];
		}
		else
		{
			return '0';
		}
		
	}
	//@ CPL Calculations
	public function getActuals($ids){
		if($ids){
			$leadQuery=" SELECT GROUP_CONCAT(DISTINCT(t3.id))actuals FROM te_utm_te_actual_campaign_1_c AS t2  INNER JOIN te_actual_campaign AS t3 ON t3.id =t2.te_utm_te_actual_campaign_1te_actual_campaign_idb AND t3.deleted=0 AND t2.te_utm_te_actual_campaign_1te_utm_ida='".$ids."' GROUP BY t3.id";
			$leadObj=$resultDate=$GLOBALS['db']->query($leadQuery);			  
			$row=$GLOBALS['db']->fetchByAssoc($leadObj);
			return $row['actuals'];
		}
		else
		{
			return '0';
		}
		
	}
}

?>
