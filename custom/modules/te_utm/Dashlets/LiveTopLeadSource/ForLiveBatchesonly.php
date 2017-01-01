<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('include/Dashlets/Dashlet.php');
require_once('include/Sugar_Smarty.php');
require_once('include/TimeDate.php');
//
class ForLiveBatchesonly extends Dashlet{ 
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
        $this->title="Live Top Lead Source";
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
		 return parent::displayOptions() . $ss->fetch('custom/modules/te_utm/Dashlets/LiveTopLeadSource/ForLiveBatchesonlyOptions.tpl');
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
		$leadQuery = "SELECT l.utm as utm_name,t1.name,COUNT(distinct(l.id)) total_leads,GROUP_CONCAT(DISTINCT(te_actual_campaign.id))total_cost FROM te_vendor t1 INNER JOIN te_vendor_te_utm_1_c t2 ON t1.id=t2.te_vendor_te_utm_1te_vendor_ida INNER JOIN te_utm t4 ON t4.id=t2.te_vendor_te_utm_1te_utm_idb INNER JOIN leads l ON l.utm=t4.name and l.deleted=0 left join te_utm_te_actual_campaign_1_c on te_utm_te_actual_campaign_1_c.te_utm_te_actual_campaign_1te_utm_ida=t4.id left join te_actual_campaign on te_actual_campaign.id=te_utm_te_actual_campaign_1_c.te_utm_te_actual_campaign_1te_actual_campaign_idb WHERE t4.utm_status='Live' GROUP BY t1.name ORDER BY total_leads DESC LIMIT 0 ,".$this->top_camp;
                      
	    $leadObj=$resultDate=$GLOBALS['db']->query($leadQuery);			  
        while($row=$GLOBALS['db']->fetchByAssoc($leadObj)){	
			$leadsData[]=$row;			 
		}		
        $output = "<div class='bd-center'><table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>";
		$output.=' <tr height="20">
        	        <th scope="col" width="30%">
						<div style="white-space: normal;" width="100%" align="left">Live Top Lead Source</div>
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
			$converted=$this->getConvertedLeads($data['utm_name']);
			$total_cost_id=$this->getCPLLeads($data['total_cost']);
		
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
		$leadQuery="select count(*) as total from leads l WHERE l.utm='".$batch."' AND l.deleted=0 AND l.status='Converted'";
	    $leadObj=$resultDate=$GLOBALS['db']->query($leadQuery);			  
        $row=$GLOBALS['db']->fetchByAssoc($leadObj)		;
		return $row['total'];
	}
	//@ CPL Calculations
	public function getCPLLeads($ids){
		if($ids){
			$result = explode(',',$ids);
			$result = "'" . implode ( "', '",$result  ) . "'";
		    $leadQuery="select SUM(total_cost) as total from te_actual_campaign WHERE te_actual_campaign.id in($result) ";
			$leadObj=$resultDate=$GLOBALS['db']->query($leadQuery);			  
			$row=$GLOBALS['db']->fetchByAssoc($leadObj)		;
			return $row['total'];
		}
		else
		{
			return '0';
		}
		
	}
}

?>
