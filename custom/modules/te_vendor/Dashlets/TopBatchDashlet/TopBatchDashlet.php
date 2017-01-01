<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('include/Dashlets/Dashlet.php');
require_once('include/Sugar_Smarty.php');
require_once('include/TimeDate.php');
//9452039224
class TopBatchDashlet extends Dashlet{ 
    protected $top_batch = '';
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

		if(!empty($def['top_batch'])){
            $this->top_batch = $def['top_batch'];
        }else{			       
			$this->top_batch=10;
		} 		
		if(!empty($def['height'])) // set a default height if none is set
           $this->height = $def['height'];		
        $this->loadLanguage('RSSDashlet', 'modules/Home/Dashlets/'); // load the language strings here            
        $this->title="Top Batch Dashboard";
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
        $ss->assign('top_batch', $this->top_batch);
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
		$ss->assign('top_batch', $this->top_batch);
        $ss->assign('id', $this->id);
		if($this->isAutoRefreshable()) {
       		$ss->assign('isRefreshable', true);
			$ss->assign('autoRefresh', $GLOBALS['app_strings']['LBL_DASHLET_CONFIGURE_AUTOREFRESH']);
			$ss->assign('autoRefreshOptions', $this->getAutoRefreshOptions());
			$ss->assign('autoRefreshSelect', $this->autoRefresh);
		}
		 return parent::displayOptions() . $ss->fetch('modules/te_ba_Batch/Dashlets/TopBatchDashlet/TopBatchDashletOptions.tpl');
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
        $options['top_batch'] = $req['top_batch'];
        $options['height'] = $req['height'];
        $options['autoRefresh'] = empty($req['autoRefresh']) ? '0' : $req['autoRefresh'];        
        return $options;
    }
    protected function getCurrentBenchOutput()
    {
		
		global $sugar_config,$app_list_strings,$current_user;
        $leadsData=array();
		$user_id=$current_user->id;
		$leadQuery = "SELECT COUNT(b.id) AS total_leads,b.id,b.name,GROUP_CONCAT(distinct(l.utm)) UTM FROM leads l INNER JOIN leads_cstm lc ON l.id = lc.id_c LEFT JOIN te_utm ON te_utm.name = l.utm INNER JOIN te_ba_batch b ON b.id = CASE WHEN l.utm = 'NA' THEN lc.te_ba_batch_id_c WHEN l.utm != 'NA' THEN te_utm.te_ba_batch_id_c END WHERE l.deleted = 0 AND b.batch_status = 'enrollment_in_progress' GROUP BY b.id ORDER BY total_leads DESC limit 0,".$this->top_batch;
		//$leadQuery="select count(b.id) as total_leads,b.id,b.name, l.first_name,l.status from leads l INNER JOIN leads_cstm lc on l.id=lc.id_c INNER JOIN te_ba_batch b on lc.te_ba_batch_id_c=b.id where l.deleted=0 AND b.batch_status ='enrollment_in_progress' group by b.id order by total_leads DESC LIMIT 0,".$this->top_batch;
	    $leadObj=$resultDate=$GLOBALS['db']->query($leadQuery);			  
        while($row=$GLOBALS['db']->fetchByAssoc($leadObj)){	
			$leadsData[]=$row;			 
		}		
        $output = "<div class='bd-center'><table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>";
		$output.=' <tr height="20">
        	        <th scope="col" width="30%">
						<div style="white-space: normal;" width="100%" align="left">Live Top Batches</div>
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
			//$converted=$this->getConvertedLeads($data['UTM']);
			$con=$this->getConSUMConversionLeads($data['id']);
			  
			  //$Conversion=$converted+$con;
			  $Conversion=$con;
			$cpl=$this->getCPLBatchWise($data['id']);
			$actual_cpl='NA';
			if($data['total_leads'] && $cpl){
				$actual_cpl=$cpl/$data['total_leads'];
			}
			
			$output.="<tr class='".$class."' height='20'><td scope='row' align='left' valign='top'>".$data['name']."</td><td scope='row' align='left' valign='top'>".$data['total_leads']."</td><td scope='row' align='left' valign='top'>".$Conversion."</td><td scope='row' align='left' valign='top'>".number_format($actual_cpl,2)."</td><td scope='row' align='left' valign='top'>".number_format(($Conversion*100)/$data['total_leads'],2)."</td></tr>";
		}		
		$output.="</table></div>";
        //$GLOBALS['log']->fatal($trackerData);
        return $output;
    }
	public function getConvertedLeads($batch){
		if($batch){
			$result = explode(',',$batch);
			 $arr = array_diff($result, array('NA'));
			$result = "'" . implode ( "', '",$arr  ) . "'";
		}
		$leadQuery="select count(*) as total from leads l WHERE l.utm in ($result) AND l.deleted=0 AND l.status='Converted'";
	    $leadObj=$resultDate=$GLOBALS['db']->query($leadQuery);			  
        $row=$GLOBALS['db']->fetchByAssoc($leadObj);
		return $row['total'];
	}
	
	public function getConSUMConversionLeads($batch1){
		if(!$batch1){
			return 0;
		}
		$leadQuery="select count(*) as total from leads l INNER JOIN leads_cstm lc on l.id=lc.id_c WHERE lc.te_ba_batch_id_c='".$batch1."' AND l.deleted=0 AND l.status='Converted'";
	    $leadObj=$resultDate=$GLOBALS['db']->query($leadQuery);			  
        $row=$GLOBALS['db']->fetchByAssoc($leadObj);
		return $row['total'];
	}
	public function getCPLBatchWise($batch){
		$leadQuery="SELECT te_utm.`te_ba_batch_id_c`,sum(t3.total_cost) total_cost FROM `te_utm` inner join te_utm_te_actual_campaign_1_c as t2 on t2.te_utm_te_actual_campaign_1te_utm_ida=te_utm.id inner join te_actual_campaign as t3 on t3.id=t2.te_utm_te_actual_campaign_1te_actual_campaign_idb where te_utm.`te_ba_batch_id_c`='".$batch."' AND t3.deleted=0 AND t2.deleted=0 AND t3.type='paid'";
	    $leadObj=$resultDate=$GLOBALS['db']->query($leadQuery);			  
        $row=$GLOBALS['db']->fetchByAssoc($leadObj)		;
	return $row['total_cost'];
	}
}

?>
