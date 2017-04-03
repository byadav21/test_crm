<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('include/Dashlets/Dashlet.php');
require_once('include/Sugar_Smarty.php');
require_once('include/TimeDate.php');
class Dropout extends Dashlet{ 
    protected $Dropout = '';
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

		if(!empty($def['Dropout'])){
            $this->Dropout = $def['Dropout'];
        }else{			       
			$this->Dropout=10;
		} 		
		if(!empty($def['height'])) // set a default height if none is set
           $this->height = $def['height'];		
        $this->loadLanguage('RSSDashlet', 'modules/Home/Dashlets/'); // load the language strings here            
        $this->title="DropOut Student";
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
        $ss->assign('Dropout', $this->Dropout);
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
		$ss->assign('Dropout', $this->Dropout);
        $ss->assign('id', $this->id);
		if($this->isAutoRefreshable()) {
       		$ss->assign('isRefreshable', true);
			$ss->assign('autoRefresh', $GLOBALS['app_strings']['LBL_DASHLET_CONFIGURE_AUTOREFRESH']);
			$ss->assign('autoRefreshOptions', $this->getAutoRefreshOptions());
			$ss->assign('autoRefreshSelect', $this->autoRefresh);
		}
		 return parent::displayOptions() . $ss->fetch('custom/modules/Leads/Dashlets/Dropout/DropoutOptions.tpl');
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
        $options['Dropout'] = $req['Dropout'];
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
		$uid=$this->report_to_id;
		$str = implode("','",$uid);
		
	    $leadQuery ="SELECT b.name,(SELECT COUNT(*) FROM te_student_batch WHERE te_student_batch.`te_ba_batch_id_c`=b.id AND te_student_batch.deleted=0)total_student,(SELECT COUNT(*) FROM te_student_batch WHERE te_student_batch.`te_ba_batch_id_c`=b.id AND te_student_batch.deleted=0 AND te_student_batch.status='Dropout' AND te_student_batch.dropout_type='pre_dropout')predropout,(SELECT COUNT(*) FROM te_student_batch WHERE te_student_batch.`te_ba_batch_id_c`=b.id AND te_student_batch.deleted=0 AND te_student_batch.status='Dropout' AND te_student_batch.dropout_type='post_dropout')postdropout FROM `te_student_batch` as sb INNER JOIN te_ba_batch AS b ON sb.`te_ba_batch_id_c`=b.id WHERE sb.assigned_user_id IN('".$str."') AND sb.deleted=0 AND b.deleted=0 GROUP BY sb.`te_ba_batch_id_c` ORDER BY total_student DESC";
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
						<div style="white-space: normal;" width="100%" align="left">Total Admission</div>
					</th>
					 <th scope="col" width="10%">
						<div style="white-space: normal;" width="100%" align="left">Pre-Dropout%</div>
					</th>
					<th scope="col" width="10%">
						<div style="white-space: normal;" width="100%" align="left">Postdropout%</div>
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
		//	$con=$this->getConSUMConversionLeads($data['id']);
			  
			  //$Conversion=$converted+$con;
			$total=($data['postdropout']+$data['predropout']);
			$DropOut=($data['total_student']* $total)/100;
			
			$preDropout1=($data['predropout']/$data['total_student'])*100;
			$postDropout1=($data['postdropout']/($data['total_student']-$data['predropout']))*100;
			
			$preDropout_format=number_format((float)$preDropout1, 2, '.', '');
			
			$output.="<tr class='".$class."' height='20'><td scope='row' align='left' valign='top'>".$data['name']."</td><td scope='row' align='left' valign='top'>".$data['total_student']."</td><td scope='row' align='left' valign='top'>".$preDropout_format."</td><td scope='row' align='left' valign='top'>".$postDropout1."</td></tr>";
		}		
		$output.="</table></div>";
        return $output;
    }

	//@current logedin user wit Reporting Users
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
// @MAnish Gupta 2april17
?>
