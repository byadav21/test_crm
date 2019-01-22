<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
ini_set('memory_limit', '1024M');
require_once('include/entryPoint.php');
require_once('custom/include/Email/sendmail_cron.php');
global $db;
class sendDailyJunkLead
{

    public $fromDate;
    public $toDate;

    public function __construct()
    {
        $this->fromDate = date('Y-m-d');
        $this->toDate   = date('Y-m-d');
    }

    public function main()
    {
        global $sugar_config, $app_list_strings, $current_user, $db;
        $mail = new FalconideEmail();

        $file     = "DailyJunkLead";
        $where    = '';
        $filename = $file . "_" . $this->toDate;
		$AllLeadData = $this->getAll();
		$getSummary = $this->getSummary();
		
		$data = $AllLeadData;
		
        $fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/reports/" . $filename . ".csv", "wb");
        fwrite($fp, $data);
        fclose($fp);
        chmod($_SERVER['DOCUMENT_ROOT'] . "/reports/" . $filename . ".csv", 0777);
		$email_summary = '<table border="0" cellpadding="0" cellspacing="0" border="1" height="100%" width="100%" id="bodyTable">
            <tr>
                <td align="center" valign="top">
                    <table border="0" cellpadding="20" cellspacing="0" border="1" width="600" id="emailContainer">
                        <tr>
                            <td valign="top">
                                Total Leads.
                            </td>
							<td valign="top">
                                '.$getSummary['total'].'
                            </td>
                        </tr>
						<tr>
                            <td valign="top">
                                Junk Leads.
                            </td>
							<td valign="top">
                                '.$getSummary['junk'].'
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>';
		//'pawan.kumar@talentedge.in','pritam.dutta@talentedge.in','ajay.kumar@talentedge.in', 'ashwani.sharma@talentedge.in','pramod.singh@talentedge.in'
//		$to = array('pawan.kumar@talentedge.in','pritam.dutta@talentedge.in','ajay.kumar@talentedge.in', 'ashwani.sharma@talentedge.in','pramod.singh@talentedge.in','deepak.sharma@talentedge.in','vivek.bathla@talentedge.in','sreedevi.sreekumar@talentedge.in');
                $to = array(
                'pawan.kumar@talentedge.in','pritam.dutta@talentedge.in',
                'ajay.kumar@talentedge.in', 'ashwani.sharma@talentedge.in','aastha.verma@talentedge.in','kunal.soni@talentedge.in',
                //B Head
                'sreedevi.sreekumar@talentedge.in',
                //CC Team:
                'ritika.nayak@talentedge.in','kiran.mathew@talentedge.in',
                #'eleazer.rohit@talentedge.in', 
                #'amit.arora@talentedge.in', 'deepak.yadav@talentedge.in','abha.saxena@talentedge.in',
                
                //Marketing Team :
                'varun.vashistha@talentedge.in', 'amit.sati@talentedge.in', 'sachin.jain@talentedge.in',
                'vivek.bathla@talentedge.in','sandeep.sharma@talentedge.in','ashish.somvanshi@talentedge.in',
                //BA Team :
                'duke.banerjee@talentedge.in');
        $emailData = $mail->cron_email_Data('Daily Junk Lead Data', $filename, $this->toDate,$to,$email_summary);
        //$emailData = $mail->emailData('Daily Junk Lead Data', $filename, $this->toDate,$email_summary);
        $mail->sendCertificateEmail($emailData);
    }
	public function getAll(){
		global $sugar_config, $app_list_strings, $current_user, $db;
		$leadSql = "SELECT id,phone_mobile FROM  `leads` WHERE LENGTH( phone_mobile ) <>10 AND neoxstatus=0 AND DATE(`date_entered`)='$this->fromDate'";
		//$leadSql = "SELECT id,phone_mobile FROM  `leads` WHERE LENGTH( phone_mobile ) <>10 AND neoxstatus=0";
        
        $leadObj = $db->query($leadSql);
		$programList = '';
        while ($row = $db->fetchByAssoc($leadObj))
        {
            $programList[$row['id']]['id']         = $row['id'];
            $programList[$row['id']]['phone_mobile']       = $row['phone_mobile'];
        }
		//echo "<pre>";print_r($programList);exit();
		# Create heading
        $data = "Id";
        $data .= ",Mobile";
        $data .= "\n";
        foreach ($programList as $key => $councelor)
        {
            $data .= "\"" . $councelor['id'];
            $data .= "\",\"" . $councelor['phone_mobile'];
            $data .= "\"\n";
        }
		return $data;
	}
	public function getSummary(){
		global $sugar_config, $app_list_strings, $current_user, $db;
		
		$leadSql = "SELECT count(id)junk FROM  `leads` WHERE LENGTH( phone_mobile ) <>10 AND neoxstatus=0 AND DATE(`date_entered`)='$this->fromDate'";
        $leadObj = $db->query($leadSql);
		$row = $db->fetchByAssoc($leadObj);
		$junk = $row['junk'];
        
		$leadSql = "SELECT count(id)total FROM  `leads` WHERE DATE(`date_entered`)='$this->fromDate'";
        $leadObj = $db->query($leadSql);
		$row = $db->fetchByAssoc($leadObj);
		$total = $row['total'];
		
		return array('junk'=>$junk,'total'=>$total);
		
	}
}

$mainObj           = new sendDailyJunkLead();
//$mainObj->toDate   = '2017-09-30';
//$mainObj->fromDate = '2017-09-01';
if (strtotime($mainObj->fromDate) == strtotime($mainObj->toDate))
{
    $fromDate = date('Y-m-d', (strtotime('-1 day', strtotime($mainObj->fromDate))));
}

$mainObj->toDate   = $fromDate;
$mainObj->fromDate = $fromDate;

$mainObj->main();

