<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
ini_set('memory_limit', '1024M');
require_once('include/entryPoint.php');
require_once('include/SugarPHPMailer.php');
global $db;

class sendVisitReport
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

        $emailObj = new Email();
        //echo 'hhhee'; die;
        //$visitDataArry = $getDataObj->getExcelVisitReport($this->fromDate, $this->toDate);
        //$defaults = $emailObj->getSystemDefaultEmail(); 

        $mail           = new SugarPHPMailer();
        $mail->setMailerForSystem();
        $mail->From     = 'pawan.kumar@talentedge.in';
        $mail->FromName = 'Pawan';
        $mail->Subject  = 'Vendor Wise Report';
        $mail->Body     = '$body';
        $mail->isHTML(true);
        $mail->prepForOutbound();
        foreach ($emails as $email)
            $mail->AddAddress('pawan.kumar@talentedge.in');
        @$mail->Send();

        if (!$mail->Send())
        {
            $GLOBALS['log']->fatal("Email Reminder: error sending e-mail (method: {$mail->Mailer}), (error: {$mail->ErrorInfo})");
        }
    }

}

$mainObj  = new sendVisitReport();
$fromDate = isset($_SERVER['argv'][1]) ? $_SERVER['argv'][1] : date('Y-m-d');
$toDate   = isset($_SERVER['argv'][2]) ? $_SERVER['argv'][2] : date('Y-m-d');

if (strtotime($fromDate) == strtotime($toDate))
{
    $fromDate = date('Y-m-d', (strtotime('-1 day', strtotime($fromDate))));
}
$mainObj->fromDate = $fromDate;
$mainObj->toDate   = $toDate;
$mainObj->main();

