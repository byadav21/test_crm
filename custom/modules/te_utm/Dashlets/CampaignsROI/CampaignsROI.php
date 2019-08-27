<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('include/Dashlets/Dashlet.php');
require_once('include/Sugar_Smarty.php');
require_once('include/TimeDate.php');
//@Manish 
class CampaignsROI extends Dashlet{ 
    protected $top_Campaigns = '';
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

		if(!empty($def['top_Campaigns'])){
            $this->top_Campaigns = $def['top_Campaigns'];
        }else{			       
			$this->top_Campaigns=10;
		} 		
		if(!empty($def['height'])) // set a default height if none is set
           $this->height = $def['height'];		
        $this->loadLanguage('RSSDashlet', 'modules/Home/Dashlets/'); // load the language strings here            
        $this->title="Live Campaigns ROI";
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
        $ss->assign('top_Campaigns', $this->top_Campaigns);
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
		$ss->assign('top_Campaigns', $this->top_Campaigns);
        $ss->assign('id', $this->id);
		if($this->isAutoRefreshable()) {
       		$ss->assign('isRefreshable', true);
			$ss->assign('autoRefresh', $GLOBALS['app_strings']['LBL_DASHLET_CONFIGURE_AUTOREFRESH']);
			$ss->assign('autoRefreshOptions', $this->getAutoRefreshOptions());
			$ss->assign('autoRefreshSelect', $this->autoRefresh);
		}
		 return parent::displayOptions() . $ss->fetch('custom/modules/te_utm/Dashlets/CampaignsROI/CampaignsROIOptions.tpl');
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
        $options['top_Campaigns'] = $req['top_Campaigns'];
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
		$leadQuery = "SELECT t1.name,(select COUNT(l.id) from leads l where l.utm=t1.name AND l.deleted=0 AND l.status='Converted') total_leads,GROUP_CONCAT(DISTINCT(t3.id)) total_cost_id,t4.id,t4.fees_inr,t4.fees_in_usd FROM te_utm t1 INNER JOIN leads l ON t1.name=l.utm INNER JOIN te_ba_batch t4 on t4.id=t1.te_ba_batch_id_c left join te_utm_te_actual_campaign_1_c as t2 on t2.te_utm_te_actual_campaign_1te_utm_ida=t1.id left join te_actual_campaign as t3 on t3.id=t2.te_utm_te_actual_campaign_1te_actual_campaign_idb WHERE t1.utm_status='Live' AND t3.deleted=0 GROUP BY t1.name ORDER BY total_leads DESC LIMIT 0 ,".$this->top_Campaigns;
                      
	    $leadObj=$resultDate=[];//$GLOBALS['db']->query($leadQuery);			  
        while($row=$GLOBALS['db']->fetchByAssoc($leadObj)){	
			$leadsData[]=$row;			 
		}		
        $output = "<div class='bd-center'><table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>";
		$output.=' <tr height="20">
        	        <th scope="col" width="30%">
						<div style="white-space: normal;" width="100%" align="left">Campaign</div>
					</th>
        	        <th scope="col" width="30%">
						<div style="white-space: normal;" width="100%" align="left">Spend</div>
					</th>
					 <th scope="col" width="10%">
						<div style="white-space: normal;" width="100%" align="left">GSV</div>
					</th>
					 <th scope="col" width="15%">
						<div style="white-space: normal;" width="100%" align="left">Spend/GSV %</div>
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
			
			 $total_spend = $this->GetTotalCost($data['total_cost_id']);
			 $revenue = $data['total_leads']*$data['fees_inr'];
			 $revenueBySpend = $total_spend/$revenue;
			// $cpa_percentage = number_format(($data['total_leads']*100)/$total_spend,2);
		
			 $output.="<tr class='".$class."' height='20'><td scope='row' align='left' valign='top'>".$data['name']."</td><td scope='row' align='left' valign='top'>".$total_spend."</td><td scope='row' align='left' valign='top'>".$revenue."</td><td scope='row' align='left' valign='top'>".ROUND($revenueBySpend,2)."</td></tr>";
		    }		
		     $output.="</table></div>";
        
        return $output;
    }
    //@Converted Leads
  
    
	public function GetTotalCost($total_cost_id){
		if($total_cost_id){
			$result = explode(',',$total_cost_id);
			$result = "'" . implode ( "', '",$result  ) . "'";
			$leadQuery="SELECT SUM(te_actual_campaign.total_cost) total_spend FROM te_actual_campaign WHERE te_actual_campaign.id IN($result)";
			$leadObj=$resultDate=$GLOBALS['db']->query($leadQuery);			  
			$row=$GLOBALS['db']->fetchByAssoc($leadObj);
			return $row['total_spend'];	
		}
		else{
			return 0;
		}
		
	}
	
	
}
//@Manish
?>
