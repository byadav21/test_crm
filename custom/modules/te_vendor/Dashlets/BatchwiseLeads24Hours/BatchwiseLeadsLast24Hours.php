<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('include/Dashlets/Dashlet.php');
require_once('include/Sugar_Smarty.php');
require_once('include/TimeDate.php');
//9452039224
class BatchwiseLeadsLast24Hours extends Dashlet{ 
    protected $BatchwiseLeadsLast24Hours = '';
    protected $height = '150'; // height of the pad
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

		if(!empty($def['BatchwiseLeadsLast24Hours'])){
            $this->BatchwiseLeadsLast24Hours = $def['BatchwiseLeadsLast24Hours'];
        }else{			       
			$this->BatchwiseLeadsLast24Hours=10;
		} 		
		if(!empty($def['height'])) // set a default height if none is set
           $this->height = $def['height'];		
        $this->loadLanguage('RSSDashlet', 'modules/Home/Dashlets/'); // load the language strings here            
        $this->title="Batch wise Leads Last 24 Hours";
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
        $ss->assign('BatchwiseLeadsLast24Hours', $this->BatchwiseLeadsLast24Hours);
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
		$ss->assign('BatchwiseLeadsLast24Hours', $this->BatchwiseLeadsLast24Hours);
        $ss->assign('id', $this->id);
		if($this->isAutoRefreshable()) {
       		$ss->assign('isRefreshable', true);
			$ss->assign('autoRefresh', $GLOBALS['app_strings']['LBL_DASHLET_CONFIGURE_AUTOREFRESH']);
			$ss->assign('autoRefreshOptions', $this->getAutoRefreshOptions());
			$ss->assign('autoRefreshSelect', $this->autoRefresh);
		}
		 return parent::displayOptions() . $ss->fetch('custom/modules/te_ba_Batch/Dashlets/BatchwiseLeads24Hours/BatchwiseLeadsLast24HoursOptions.tpl');
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
        $options['BatchwiseLeadsLast24Hours'] = $req['BatchwiseLeadsLast24Hours'];
        $options['height'] = $req['height'];
        $options['autoRefresh'] = empty($req['autoRefresh']) ? '0' : $req['autoRefresh'];        
        return $options;
    }
    protected function getCurrentBenchOutput()
    {
		
		global $sugar_config,$app_list_strings,$current_user;
        $leadsData=array();
		$user_id=$current_user->id;
		
		$leadQuery="SELECT COUNT(b.id) AS total_leads,b.id,b.name,GROUP_CONCAT(distinct(l.utm)) UTM FROM leads l INNER JOIN leads_cstm lc ON l.id = lc.id_c LEFT JOIN te_utm ON te_utm.name = l.utm INNER JOIN te_ba_batch b ON b.id = CASE WHEN l.utm = 'NA' THEN lc.te_ba_batch_id_c WHEN l.utm != 'NA' THEN te_utm.te_ba_batch_id_c END WHERE l.deleted = 0 AND  l.date_entered > DATE_SUB(NOW(), INTERVAL 24 HOUR) AND l.date_entered <= NOW() AND b.batch_status = 'enrollment_in_progress' GROUP BY b.id ORDER BY total_leads DESC limit 0,".$this->BatchwiseLeadsLast24Hours;
	    
	    $leadObj=$resultDate=$GLOBALS['db']->query($leadQuery);			  
        while($row=$GLOBALS['db']->fetchByAssoc($leadObj)){	
			$leadsData[]=$row;			 
		}		
        $output = "<div class='bd-center'><table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>";
		$output.=' <tr height="20">
        	        <th scope="col" width="30%">
						<div style="white-space: normal;" width="100%" align="left">Batch Name</div>
					</th>
        	        <th scope="col" width="30%">
						<div style="white-space: normal;" width="100%" align="center">No of Leads</div>
					
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
			$output.="<tr class='".$class."' height='20'><td scope='row' align='left' valign='top'>".$data['name']."</td><td scope='row' align='center' valign='top'>".$data['total_leads']."</td></tr>";
		}		
		$output.="</table></div>";
        //$GLOBALS['log']->fatal($trackerData);
        return $output;
    } 
}

?>
