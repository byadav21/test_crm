<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('include/Dashlets/Dashlet.php');
require_once('include/Sugar_Smarty.php');
require_once('include/TimeDate.php');
//@Manish 9650211216
class LiveBatchROI extends Dashlet{ 
    protected $Live_batch = '';
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

		if(!empty($def['Live_batch'])){
            $this->Live_batch = $def['Live_batch'];
        }else{			       
			$this->Live_batch=10;
		} 		
		if(!empty($def['height'])) // set a default height if none is set
           $this->height = $def['height'];		
        $this->loadLanguage('RSSDashlet', 'modules/Home/Dashlets/'); // load the language strings here            
        $this->title="Live Batch ROI";
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
        $ss->assign('Live_batch', $this->Live_batch);
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
		$ss->assign('Live_batch', $this->Live_batch);
        $ss->assign('id', $this->id);
		if($this->isAutoRefreshable()) {
       		$ss->assign('isRefreshable', true);
			$ss->assign('autoRefresh', $GLOBALS['app_strings']['LBL_DASHLET_CONFIGURE_AUTOREFRESH']);
			$ss->assign('autoRefreshOptions', $this->getAutoRefreshOptions());
			$ss->assign('autoRefreshSelect', $this->autoRefresh);
		}
		 return parent::displayOptions() . $ss->fetch('custom/modules/te_utm/Dashlets/LiveBatchROI/LiveBatchROIOptions.tpl');
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
        $options['Live_batch'] = $req['Live_batch'];
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
		$leadQuery = "SELECT b.id batch_id,b.name,b.fees_inr,b.fees_in_usd,GROUP_CONCAT(distinct(u.id)) UTM,GROUP_CONCAT(distinct(u.name)) utm_name FROM te_ba_batch b LEFT JOIN te_utm u ON u.te_ba_batch_id_c = b.id AND u.utm_status='Live' WHERE b.batch_status = 'enrollment_in_progress' AND b.deleted=0 GROUP BY b.name DESC LIMIT 0 ,".$this->Live_batch;
                      
	    $leadObj=$resultDate=$GLOBALS['db']->query($leadQuery);			  
        while($row=$GLOBALS['db']->fetchByAssoc($leadObj)){	
			$leadsData1[]=$row;			 
		}		
        $output = "<div class='bd-center'><table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>";
		$output.=' <tr height="20">
        	        <th scope="col" width="30%">
						<div style="white-space: normal;" width="100%" align="left">Batch ROI</div>
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
		$i=0;
		
		foreach($leadsData1 as $data){		
			if($row==1){
				$class="oddListRowS1";
				$row++;
			}else{
				$class="evenListRowS1";
				$row--;
			}
			$LeadFromBatch = $this->getConvertedLeadsByBatch($data['batch_id']);
			//$leadFromUtm = $this->getConvertedLeadsByUTM($data['utm_name']);
			//$total_leads = $LeadFromBatch+$leadFromUtm;
			$total_leads = $LeadFromBatch;
			$total_spend = $this->GetTotalCost($data['UTM']);
			$revenue = $total_leads*$data['fees_inr'];
			$revenueBySpend = $total_spend/$revenue;
		//	$cpa_percentage = number_format(($total_leads*100)/$total_spend,2);
		
			 $output.="<tr class='".$class."' height='20'><td scope='row' align='left' valign='top'>".$data['name']."</td><td scope='row' align='left' valign='top'>".$total_spend."</td><td scope='row' align='left' valign='top'>".$revenue."</td><td scope='row' align='left' valign='top'>".ROUND($revenueBySpend,2)."</td></tr>";
		    }		
		     $output.="</table></div>";
        
        return $output;
    }
    //@Converted Leads
 
    
	public function GetTotalCost($utm_ids){
		if($utm_ids){
			$result = explode(',',$utm_ids);
			$result = "'" . implode ( "', '",$result  ) . "'";
			$leadQuery="SELECT SUM(te_actual_campaign.total_cost) total_spend FROM te_actual_campaign INNER JOIN te_utm_te_actual_campaign_1_c AS t2 ON t2.te_utm_te_actual_campaign_1te_actual_campaign_idb=te_actual_campaign.id WHERE t2.te_utm_te_actual_campaign_1te_utm_ida IN($result) AND te_actual_campaign.deleted=0";
			$leadObj=$resultDate=$GLOBALS['db']->query($leadQuery);			  
			$row=$GLOBALS['db']->fetchByAssoc($leadObj);
			return $row['total_spend'];	
		}
		else{
			return 0;
		}
		
	}
	public function getConvertedLeadsByUTM($batch){
		if($batch){
			$result = explode(',',$batch);
			$result = "'" . implode ( "', '",$result  ) . "'";
			$leadQuery="select count(*) as total from leads l WHERE l.utm IN ($result) AND l.deleted=0 AND l.status='Converted'";
			$leadObj=$resultDate=$GLOBALS['db']->query($leadQuery);			  
			$row=$GLOBALS['db']->fetchByAssoc($leadObj)		;
			return $row['total'];
		}
		else{
				return 0;
		}
		
	}
	
	public function getConvertedLeadsByBatch($batch){
		$leadQuery="select count(*) as total from leads l INNER JOIN leads_cstm lc on l.id=lc.id_c WHERE lc.te_ba_batch_id_c='".$batch."' AND l.deleted=0 AND l.status='Converted'";
	    $leadObj=$resultDate=$GLOBALS['db']->query($leadQuery);			  
        $row=$GLOBALS['db']->fetchByAssoc($leadObj)		;
		return $row['total'];
	}
}

?>
