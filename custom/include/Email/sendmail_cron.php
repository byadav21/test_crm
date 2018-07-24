<?php

class FalconideEmail
{

    public function sendEmail($sentTo, $emailSubject, $emailMessage, $emailFromName = NULL, $emailFrom = NULL, $attachData = array())
    {
        $sentTo                = (!is_array($sentTo)) ? array($sentTo) : $sentTo;
        // $sentTo = "virendra.bhardwaj@talentedge.in;
        $data                  = array();
        $data['api_key']       = 'fbb5606b326850fce2fa335cdce8dc16';
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

    public function emailData($reponame, $filename, $date, $email_summary=NULL)
    {
		$emailData = array('email' => array(
                'pawan.kumar@talentedge.in'
                ,'pritam.dutta@talentedge.in',
                'ajay.kumar@talentedge.in', 'ashwani.sharma@talentedge.in',
                //B Head
                'sreedevi.sreekumar@talentedge.in',
                //CC Team:
                'ritika.nayak@talentedge.in',
                //'eleazer.rohit@talentedge.in', 'deepak.yadav@talentedge.in',
                //'amit.arora@talentedge.in', 'pramod.singh@talentedge.in','abha.saxena@talentedge.in',
                
                //Marketing Team :
                'varun.vashistha@talentedge.in', 'amit.sati@talentedge.in', 'sachin.jain@talentedge.in',
                'vivek.bathla@talentedge.in', 'rajendra.digari@talentedge.in','vaibhav.gupta@talentedge.in',
                //BA Team :
                'duke.banerjee@talentedge.in'
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
    
    public function TestemailData($reponame, $filename, $date)
    {

           $emailData = array('email' => array('pawan.kumar@talentedge.in',
                                               'ashwani.sharma@talentedge.in',
                                               'ajay.kumar@talentedge.in', 
                                               'pritam.dutta@talentedge.in',
                                               'pramod.singh@talentedge.in'
                                                ),
            'subject'       => $reponame . ' - ' . date("F d, Y", strtotime($date)),
            'email_message' => '<p>Hi,</p> '
            . '<p>Please find in here attached, ' . $reponame . ' for "' . date("F d, Y", strtotime($date)) . '"</p>',
            'pdfFileName'   => $filename,
            'certFilePath'  => $_SERVER['DOCUMENT_ROOT'] . "/reports/" . $filename . ".csv");
        return $emailData;
    }

}

?>
