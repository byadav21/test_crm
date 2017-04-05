<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('include/Dashlets/Dashlet.php');
require_once('include/Sugar_Smarty.php');
require_once('include/TimeDate.php');
//9452039224
class InstallmentDue extends Dashlet{
    protected $InstallmentDue = '';
    protected $height = '300'; // height of the pad
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

		if(!empty($def['InstallmentDue'])){
            $this->InstallmentDue = $def['InstallmentDue'];
        }else{
			$this->InstallmentDue=10;
		}
		if(!empty($def['height'])) // set a default height if none is set
           $this->height = $def['height'];
        $this->loadLanguage('RSSDashlet', 'modules/Home/Dashlets/'); // load the language strings here
        $this->title="Instalment Due";
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
        $ss->assign('InstallmentDue', $this->InstallmentDue);
        $ss->assign('rss_output', $this->getStudentBatchOutput());
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
		$ss->assign('InstallmentDue', $this->InstallmentDue);
        $ss->assign('id', $this->id);
		if($this->isAutoRefreshable()) {
       		$ss->assign('isRefreshable', true);
			$ss->assign('autoRefresh', $GLOBALS['app_strings']['LBL_DASHLET_CONFIGURE_AUTOREFRESH']);
			$ss->assign('autoRefreshOptions', $this->getAutoRefreshOptions());
			$ss->assign('autoRefreshSelect', $this->autoRefresh);
		}
		 return parent::displayOptions() . $ss->fetch('custom/modules/te_student_batch/Dashlets/InstallmentDue/InstallmentDue.tpl');
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
        $options['InstallmentDue'] = $req['InstallmentDue'];
        $options['height'] = $req['height'];
        $options['autoRefresh'] = empty($req['autoRefresh']) ? '0' : $req['autoRefresh'];
        return $options;
    }
    protected function getStudentBatchOutput()
    {

		global $sugar_config,$app_list_strings,$current_user;
        $instalmentData=array();
		$user_id=$current_user->id;

		$instalmentSql="SELECT count(distinct(s.name)) as totalStudent,sb.name as batch,spp.name as instalment, (count(distinct(s.name))*spp.total_amount) as totalDue, sum(spp.paid_amount_inr) as totalPaid FROM te_student s INNER JOIN te_student_te_student_batch_1_c sbr ON s.id=sbr.te_student_te_student_batch_1te_student_ida INNER JOIN te_student_batch sb ON sbr.te_student_te_student_batch_1te_student_batch_idb=sb.id INNER JOIN te_student_batch_te_student_payment_plan_1_c sbpr ON sb.id=sbpr.te_student_batch_te_student_payment_plan_1te_student_batch_ida INNER JOIN te_student_payment_plan spp ON sbpr.te_student9d1ant_plan_idb=spp.id WHERE sb.status='Active' AND sb.deleted=0 AND ((spp.due_date>=DATE_SUB(CURDATE(), INTERVAL 15 DAY)) AND (spp.due_date<=DATE_ADD(CURDATE(), INTERVAL 15 DAY))) GROUP BY sb.name, spp.name";

	    $instalmentObj=$resultDate=$GLOBALS['db']->query($instalmentSql);
        while($row=$GLOBALS['db']->fetchByAssoc($instalmentObj)){
			$instalmentData[]=$row;
		}
        $output = "<div class='bd-center'><table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>";
		$output.=' <tr height="20">
        	        <th scope="col" width="30%">
						<div style="white-space: normal;" width="100%" align="left">Batch</div>
					</th>
        	        <th scope="col" width="30%">
						<div style="white-space: normal;" width="100%" align="center">Instalment</div>
					</th>
					<th scope="col" width="30%">
						<div style="white-space: normal;" width="100%" align="center">Total Students</div>
					</th>
					<th scope="col" width="30%">
						<div style="white-space: normal;" width="100%" align="center">Instalment Received</div>
					</th>
					<th scope="col" width="30%">
						<div style="white-space: normal;" width="100%" align="center">Instalment Due</div>
					</th>

		    </tr>';
		$row=1;

		foreach($instalmentData as $data){
			if($row==1){
				$class="oddListRowS1";
				$row++;
			}else{
				$class="evenListRowS1";
				$row--;
			}
			$output.="<tr class='".$class."' height='20'>
				<td scope='row' align='left' valign='top'>".$data['batch']."</td>
				<td scope='row' align='center' valign='top'>".$data['instalment']."</td>
				<td scope='row' align='left' valign='top'>".$data['totalStudent']."</td>
				<td scope='row' align='center' valign='top'>".$data['totalPaid']."</td>
				<td scope='row' align='left' valign='top'>".$data['totalDue']."</td>
			</tr>";
		}
		$output.="</table></div>";
        //$GLOBALS['log']->fatal($trackerData);
        return $output;
    }
}

?>
