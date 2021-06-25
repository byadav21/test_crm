<?php

class FalconideEmail
{

    public function sendEmail($sentTo, $emailSubject, $emailMessage, $emailFromName = NULL, $emailFrom = NULL, $attachData = array())
    {
        global $sugar_config;
        $sentTo                = (!is_array($sentTo)) ? array($sentTo) : $sentTo;
        // $sentTo = "virendra.bhardwaj@talentedge.in;
        $data                  = array();
        $data['api_key']       = $sugar_config['falconide_apikey'];
        $data['email_details'] = array(
            'fromname' => rawurlencode("CRM Report - Talentedge"),
            'subject'  => rawurlencode($emailSubject),
            'from'     => "notifications@talentedge.in",
            'content'  => rawurlencode($emailMessage),
        );
        $data['recipients']    = $sentTo;
        if (!empty($attachData))
        {
            $data['files'] = $attachData;
        }

        $data = array('data' => json_encode($data));

        $url = "http://api.falconide.com/falconapi/web.send.json";
        $ch  = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RANGE, "1-2000000");

        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_REFERER, 'http://www.talentedge.in');
        $result = curl_exec($ch);
        $result = curl_error($ch) ? curl_error($ch) : $result;
        curl_close($ch);
        return $result;
    }

    public function sendCertificateEmail($emailData)
    {

        if (!empty($emailData))
        {
            //$userId = $emailData['userId'];
            $sentTo = $emailData['email'];

            //print_r($sentTo); die;
            $emailSubject = $emailData['subject'];
            $emailMessage = $emailData['email_message'];
            $certFilePath = $emailData['certFilePath'];
            $attachData   = array();
          
            if (file_exists($certFilePath))
            {
                
                $attachFile    = file_get_contents($certFilePath);
                $attachName    = $emailData['pdfFileName'] . ".csv";
                $attachContent = rawurlencode($attachFile);
                $attachData    = array($attachName => $attachContent);

                //$Notification = ClassRegistry::init('Notification');
                echo $this->sendEmail($sentTo, $emailSubject, $emailMessage, NULL, NULL, $attachData);
            }
        }
    }
    
    public function btApprovalEmail($emailData)
    {

        if (!empty($emailData))
        {
            //$userId = $emailData['userId'];
            $sentTo = $emailData['email'];

           
            $emailSubject = $emailData['subject'];
            $emailMessage = $emailData['email_message'];
            $certFilePath = $emailData['certFilePath'];
        
            $attachData   = array();
            //echo 'wwww=='.$certFilePath; 
            //$certFilePath = 'upload/srm_docs/hh.txt';
            if (file_exists($certFilePath))
            {
                //echo '$certFilePath==='.$certFilePath; die;
                $attachFile    = file_get_contents($certFilePath);
                $attachName    = $emailData['pdfFileName'];
                $attachContent = rawurlencode($attachFile);
                $attachData    = array($attachName => $attachContent);
                    
                //$Notification = ClassRegistry::init('Notification');
                $this->sendEmail($sentTo, $emailSubject, $emailMessage, NULL, NULL, $attachData);
            }else
            {
                echo 'check file permission!';
            }
        }
    }
    
    public function emailData3pm($reponame, $filename, $date, $email_summary=NULL)
    {
		 $emailData = array('email' => array(
                'brijesh.kumar@talentedge.in',
                'kunal.soni@talentedge.in',
                //B Head
              
                //CC Team:
                
	            'rachit.vohra@talentedge.in','deepak.yadav@talentedge.in','rohan.munshi@talentedge.in','prabhjot.tiwana@talentedge.com','abhinav.upadhyay@talentedge.com','chirag.talwar@talentedge.com',
                //Marketing Team :
                'prashant.shrivastav@talentedge.in','rohit.lall@talentedge.in','ravi.sharma@talentedge.com','gaurav.kukreja@talentedge.com','rishi.anand@talentedge.in','ashish.somvanshi@talentedge.in','ravinder.saini@talentedge.in','parvez.ali@talentedge.in','ankur.rajput@talentedge.com','aditi.tiwari@talentedge.com','indramani.das@talentedge.com'
                ),
            'subject'       => $reponame . ' - ' . date("F d, Y", strtotime($date)),
            'email_message' => '<p>Hi,</p> '
            . '<p>Please find in here attached, ' . $reponame . ' for "' . date("F d, Y", strtotime($date)) . '"</p>'
                        . $email_summary,
            'pdfFileName'   => $filename,
            'certFilePath'  => $_SERVER['DOCUMENT_ROOT'] . "/reports/" . $filename . ".csv");
        return $emailData;

    }

    public function emailData($reponame, $filename, $date, $email_summary=NULL)
    {
		$emailData = array('email' => array(
                'brijesh.kumar@talentedge.in','kunal.soni@talentedge.in',
                //B Head
		        'vishwanath.nair@talentedge.in',
                'sreedevi.sreekumar@talentedge.in',
                //CC Team:
		        'rachit.vohra@talentedge.in','deepak.yadav@talentedge.in','rohan.munshi@talentedge.in','prabhjot.tiwana@talentedge.com','abhinav.upadhyay@talentedge.com','chirag.talwar@talentedge.com',
                 //BA Team :
                //Marketing Team :
                'prashant.shrivastav@talentedge.in','rohit.lall@talentedge.in','ravi.sharma@talentedge.com','gaurav.kukreja@talentedge.com','rishi.anand@talentedge.in','ashish.somvanshi@talentedge.in','ravinder.saini@talentedge.in','parvez.ali@talentedge.in','ankur.rajput@talentedge.com','aditi.tiwari@talentedge.com','indramani.das@talentedge.com'
                ),
            'subject'       => $reponame . ' - ' . date("F d, Y", strtotime($date)),
            'email_message' => '<p>Hi,</p> '
            . '<p>Please find in here attached, ' . $reponame . ' for "' . date("F d, Y", strtotime($date)) . '"</p>'
			. $email_summary,
            'pdfFileName'   => $filename,
            'certFilePath'  => $_SERVER['DOCUMENT_ROOT'] . "/reports/" . $filename . ".csv");
        return $emailData;
    }
	public function cron_email_Data($reponame, $filename, $date, $to, $email_summary=NULL)
    {
		$emailData = array('email' => $to,
            'subject'       => $reponame . ' - ' . date("F d, Y", strtotime($date)),
            'email_message' => '<p>Hi,</p> '
            . '<p>Please find in here attached, ' . $reponame . ' for "' . date("F d, Y", strtotime($date)) . '"</p>'
			. $email_summary,
            'pdfFileName'   => $filename,
            'certFilePath'  => $_SERVER['DOCUMENT_ROOT'] . "/reports/" . $filename . ".csv");
        return $emailData;
    }
    
    public function TestemailData($reponame, $filename, $date, $email_summary=NULL)
    {

           $emailData = array('email' => array('pawan.kumar@talentedge.in'),
             'subject'       => $reponame . ' - ' . date("F d, Y", strtotime($date)),
            'email_message' => '<p>Hi,</p> '
            . '<p>Please find in here attached, ' . $reponame . ' for "' . date("F d, Y", strtotime($date)) . '"</p>'
			. $email_summary,
            'pdfFileName'   => $filename,
            'certFilePath'  => $_SERVER['DOCUMENT_ROOT'] . "/reports/" . $filename . ".csv");
        return $emailData;
    }
    
    public function toVendorData($reponame, $filename, $date, $email_summary=NULL)
    {

           $emailData = array('email' => array('pawan.kumar@talentedge.in','duke.banerjee@talentedge.in','kunal.soni@talentedge.in'),
             'subject'       => $reponame . ' - ' . date("F d, Y", strtotime($date)),
            'email_message' => ''
			. $email_summary,
            'pdfFileName'   => $filename,
            'certFilePath'  => $_SERVER['DOCUMENT_ROOT'] . "/reports/" . $filename . ".csv");
        return $emailData;
    }
    
    public function toBtApprover($reponame, $filename, $date, $email_summary=NULL,$btApprover=array())
    {

           $emailData = array('email' => $btApprover,
             'subject'       => $reponame . ' - ' . date("F d, Y", strtotime($date)),
            'email_message' => ''
			. $email_summary,
            'pdfFileName'   => $filename,
               'certFilePath'  => "upload/srm_docs/" . $filename);
            //'certFilePath'  => $_SERVER['DOCUMENT_ROOT'] . "/reports/srm_docs/" . $filename);
        return $emailData;
    }
    
    public function inboundleadList($reponame, $filename, $date, $email_summary=NULL,$btApprover=array())
    {

           $emailData = array('email' => $btApprover,
             'subject'       => $reponame . ' - ' . date("F d, Y", strtotime($date)),
            'email_message' => ''
			. $email_summary
            //'pdfFileName'   => $filename,
               //'certFilePath'  => "upload/srm_docs/" . $filename
                   );
            //'certFilePath'  => $_SERVER['DOCUMENT_ROOT'] . "/reports/srm_docs/" . $filename);
        return $emailData;
    }

}

?>
