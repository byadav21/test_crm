<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('include/Dashlets/Dashlet.php');
require_once('include/Sugar_Smarty.php');
require_once('include/TimeDate.php');
class TargetVsActualContactCenter extends Dashlet{ 
    protected $TargetVsActualContactCenter = '';
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

		if(!empty($def['TargetVsActualContactCenter'])){
            $this->TargetVsActualContactCenter = $def['TargetVsActualContactCenter'];
        }else{			       
			$this->TargetVsActualContactCenter=10;
		} 		
		if(!empty($def['height'])) // set a default height if none is set
           $this->height = $def['height'];		
        $this->loadLanguage('RSSDashlet', 'modules/Home/Dashlets/'); // load the language strings here            
        $this->title="Target Vs Actual Contact Center";
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
        $ss->assign('TargetVsActualContactCenter', $this->TargetVsActualContactCenter);
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
		$ss->assign('TargetVsActualContactCenter', $this->TargetVsActualContactCenter);
        $ss->assign('id', $this->id);
		if($this->isAutoRefreshable()) {
       		$ss->assign('isRefreshable', true);
			$ss->assign('autoRefresh', $GLOBALS['app_strings']['LBL_DASHLET_CONFIGURE_AUTOREFRESH']);
			$ss->assign('autoRefreshOptions', $this->getAutoRefreshOptions());
			$ss->assign('autoRefreshSelect', $this->autoRefresh);
		}
		 return parent::displayOptions() . $ss->fetch('custom/modules/Leads/Dashlets/TargetVsActualContactCenter/TargetVsActualContactCenterOptions.tpl');
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
        $options['TargetVsActualContactCenter'] = $req['TargetVsActualContactCenter'];
        $options['height'] = $req['height'];
        $options['autoRefresh'] = empty($req['autoRefresh']) ? '0' : $req['autoRefresh'];        
        return $options;
    }
    protected function getCurrentBenchOutput()
    {
		
		global $sugar_config,$app_list_strings,$current_user;
        $leadsData=array();
		$user_id=$current_user->id;
		$leadQuery = "SELECT b.id,b.name,b.batch_size,GROUP_CONCAT(DISTINCT(te_utm.name))UTM FROM te_ba_batch b LEFT JOIN te_utm ON te_utm.te_ba_batch_id_c=b.id WHERE b.deleted = 0 AND b.batch_status = 'enrollment_in_progress'AND te_utm.utm_status='Live' GROUP BY b.id limit 0,".$this->TargetVsActualContactCenter;
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
						<div style="white-space: normal;" width="100%" align="left">Target</div>
					</th>
					 <th scope="col" width="10%">
						<div style="white-space: normal;" width="100%" align="left">Converted</div>
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
			
			
			$output.="<tr class='".$class."' height='20'><td scope='row' align='left' valign='top'>".$data['name']."</td><td scope='row' align='left' valign='top'>".$data['batch_size']."</td><td scope='row' align='left' valign='top'>".$Conversion."</td></tr>";
		}		
		$output.="</table></div>";
        return $output;
    }
	/*public function getConvertedLeads($batch){
		if($batch){
			$result = explode(',',$batch);
			$result = "'" . implode ( "', '",$result  ) . "'";
			$leadQuery="select count(*) as total from leads l WHERE l.utm in ($result) AND l.deleted=0 AND l.status='Converted'";
			$leadObj=$resultDate=$GLOBALS['db']->query($leadQuery);			  
			$row=$GLOBALS['db']->fetchByAssoc($leadObj);
			return $row['total'];
		}
		else{
				return 0;
		}
		
	}*/
	
	public function getConSUMConversionLeads($batch1){
		if(!$batch1){
			return 0;
		}
		$leadQuery="select count(*) as total from leads l INNER JOIN leads_cstm lc on l.id=lc.id_c WHERE lc.te_ba_batch_id_c='".$batch1."' AND l.deleted=0 AND l.status='Converted'";
	    $leadObj=$resultDate=$GLOBALS['db']->query($leadQuery);			  
        $row=$GLOBALS['db']->fetchByAssoc($leadObj);
		return $row['total'];
	}
	
}
// @MAnish Gupta
?>
