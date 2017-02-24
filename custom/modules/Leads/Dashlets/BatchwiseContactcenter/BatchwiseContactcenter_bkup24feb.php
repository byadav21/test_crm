	<?php
	if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
	require_once('include/Dashlets/Dashlet.php');
	require_once('include/Sugar_Smarty.php');
	require_once('include/TimeDate.php');
	//@Manish Kumar
	class BatchwiseContactcenter extends Dashlet{ 
		protected $top_batchs = '';
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

			if(!empty($def['top_batchs'])){
				$this->top_batchs = $def['top_batchs'];
			}else{			       
				$this->top_batchs=10;
			} 		
			if(!empty($def['height'])) // set a default height if none is set
			   $this->height = $def['height'];		
			$this->loadLanguage('RSSDashlet', 'modules/Home/Dashlets/'); // load the language strings here            
			$this->title="Batch wise Contact Center";
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
			$ss->assign('top_batchs', $this->top_batchs);
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
			$ss->assign('top_batchs', $this->top_batchs);
			$ss->assign('id', $this->id);
			if($this->isAutoRefreshable()) {
				$ss->assign('isRefreshable', true);
				$ss->assign('autoRefresh', $GLOBALS['app_strings']['LBL_DASHLET_CONFIGURE_AUTOREFRESH']);
				$ss->assign('autoRefreshOptions', $this->getAutoRefreshOptions());
				$ss->assign('autoRefreshSelect', $this->autoRefresh);
			}
			 return parent::displayOptions() . $ss->fetch('custom/modules/Leads/Dashlets/BatchwiseContactcenter/BatchwiseContactcenter.tpl');
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
			$options['top_batchs'] = $req['top_batchs'];
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
			
			$str = implode("','",$uid);
			
			date_default_timezone_set("Asia/Kolkata");
				$leadQuery = "SELECT COUNT(b.id) AS total_leads,b.id batch_id,GROUP_CONCAT(DISTINCT(l.utm)) utm_name,b.name FROM leads l INNER JOIN leads_cstm lc ON l.id = lc.id_c 
							LEFT JOIN te_utm ON te_utm.name = l.utm INNER JOIN te_ba_batch b ON b.id = CASE WHEN l.utm = 'NA' THEN lc.te_ba_batch_id_c WHEN l.utm != 'NA' THEN te_utm.te_ba_batch_id_c 
							END WHERE l.assigned_user_id in('".$str."') AND l.deleted = 0 AND b.batch_status = 'enrollment_in_progress'GROUP BY b.id ORDER BY total_leads DESC LIMIT 0 ,".$this->top_batchs; 
												  
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
							<div style="white-space: normal;" width="100%" align="left">Leads</div>
						</th>
						 <th scope="col" width="10%">
							<div style="white-space: normal;" width="100%" align="left">Conversion</div>
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
				
				 //$converted=$this->getConvertedLeads($data['utm_name']);
				  $con=$this->getConSUMConversionLeads($data['batch_id']);
				  
				 // $Conversion=$converted+$con;
				  $Conversion=$con;
				  
			
				 $output.="<tr class='".$class."' height='20'><td scope='row' align='left' valign='top'>".$data['name']."</td><td scope='row' align='left' valign='top'>".$data['total_leads']."</td><td scope='row' align='left' valign='top'>".$Conversion."</td><td scope='row' align='left' valign='top'>".number_format(($Conversion*100)/$data['total_leads'],2)."</td></tr>";
				}		
				 $output.="</table></div>";
			
			return $output;
		}
		//@Converted Leads
		
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

	?>
