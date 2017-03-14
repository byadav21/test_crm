<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('include/Dashlets/Dashlet.php');
require_once('include/Sugar_Smarty.php');
require_once('include/TimeDate.php');
class Programwise extends Dashlet{
    protected $Programwise = '';
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

		if(!empty($def['Programwise'])){
            $this->Programwise = $def['Programwise'];
        }else{
			$this->Programwise=20;
		}
		if(!empty($def['height'])) // set a default height if none is set
           $this->height = $def['height'];
        $this->loadLanguage('RSSDashlet', 'modules/Home/Dashlets/'); // load the language strings here
        $this->title="Program wise Students";
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
        $ss->assign('Programwise', $this->Programwise);
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
		$ss->assign('Programwise', $this->Programwise);
        $ss->assign('id', $this->id);
		if($this->isAutoRefreshable()) {
       		$ss->assign('isRefreshable', true);
			$ss->assign('autoRefresh', $GLOBALS['app_strings']['LBL_DASHLET_CONFIGURE_AUTOREFRESH']);
			$ss->assign('autoRefreshOptions', $this->getAutoRefreshOptions());
			$ss->assign('autoRefreshSelect', $this->autoRefresh);
		}
		 return parent::displayOptions() . $ss->fetch('custom/modules/te_student/Dashlets/Programwise/ProgramwiseOptions.tpl');
    }
	/**
     * called to filter out $_REQUEST object when the user submits the configure dropdown
     *
     * @param array $req $_REQUEST @manish
     * @return array filtered options to save
     */
    public function saveOptions(array $req){
        $options = array();
        $options['title'] = $req['title'];
        $options['Programwise'] = $req['Programwise'];
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
			$str1 = implode("','",$uid);
		# display Query
		$leadQuery ="SELECT b.name AS batch ,(SELECT COUNT(*) FROM te_student_batch WHERE te_student_batch.deleted=0 AND te_student_batch.te_ba_batch_id_c=b.id) AS total_admission,(SELECT COUNT(*) FROM leads INNER JOIN leads_cstm ON leads.id=leads_cstm.id_c AND leads.deleted=0 WHERE leads_cstm.te_ba_batch_id_c=b.id AND leads.lead_source='Referrals') AS total_ref,(SELECT COUNT(*) FROM leads INNER JOIN leads_cstm ON leads.id=leads_cstm.id_c AND leads.deleted=0 WHERE leads_cstm.te_ba_batch_id_c=b.id AND leads.lead_source='Referrals' AND leads.status='Converted') AS total_ref_converted FROM te_ba_batch AS b WHERE b.deleted=0 GROUP BY b.id ORDER BY total_admission DESC limit 0,".$this->Programwise;
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
						<div style="white-space: normal;" width="100%" align="left">Referral</div>
					</th>
					<th scope="col" width="10%">
						<div style="white-space: normal;" width="100%" align="left">Ref.Converted</div>
					</th>
					<th scope="col" width="10%">
						<div style="white-space: normal;" width="100%" align="left">Referral %</div>
					</th>
					<th scope="col" width="10%">
						<div style="white-space: normal;" width="100%" align="left">Referral Conversion%</div>
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

			#Referal %
      $Referralp=($data['total_ref']/$data['total_admission'])*100;
      $Referralp=number_format((float)$Referralp, 2, '.', '');
			# Referal Coversion---
			$Referral_Conversion=($data['total_ref_converted']/$data['total_ref'])*100;
			$format=number_format((float)$Referral_Conversion, 2, '.', '');

		$output.="<tr class='".$class."' height='20'><td scope='row' align='left' valign='top'>".$data['batch']."</td><td scope='row' align='left' valign='top'>".$data['total_admission']."</td><td scope='row' align='left' valign='top'>".$data['total_ref']."</td><td scope='row' align='left' valign='top'>".$data['total_ref_converted']."</td><td scope='row' align='left' valign='top'>".$Referralp."</td><td scope='row' align='left' valign='top'>".$format."</td></tr>";
		}
		$output.="</table></div>";
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
// @MAnish Gupta dated *8march 2017
?>
