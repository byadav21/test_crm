<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
error_reporting(E_ALL);
ini_set('display_errors', 'On');
ini_set('memory_limit', '1024M');

require_once('include/entryPoint.php');
require_once('custom/include/Email/sendmail_cron.php');
global $db;


//print_r($_FILES['bt_attached_file']);
//print_r($_REQUEST); 
$old_batch_id = $_REQUEST['old_batch_id'];
$new_batch_id = $_REQUEST['batch_dropdown'];
$student_id   = $_REQUEST['student_id'];
$cbid         = $_REQUEST['te_student_batch_id'];

function getInstProBatName($id)
{
    global $db;

    $sql = " SELECT i.`name` AS insname,
                   i.id AS insid,
                   i.web_institute_id,
                   b.batch_code,
                   b.name AS batchname,
                   b.id AS batchid,
                   p.name AS programname,
                   p.id AS programid
                  
            FROM `te_in_institutes` AS i
            INNER JOIN te_in_institutes_te_ba_batch_1_c AS ib ON ib.te_in_institutes_te_ba_batch_1te_in_institutes_ida=i.id
            INNER JOIN te_ba_batch AS b ON b.id=ib.te_in_institutes_te_ba_batch_1te_ba_batch_idb
            INNER JOIN te_pr_programs_te_ba_batch_1_c AS pb ON pb.te_pr_programs_te_ba_batch_1te_ba_batch_idb=b.id
            INNER JOIN te_pr_programs AS p ON p.id=pb.te_pr_programs_te_ba_batch_1te_pr_programs_ida
            WHERE i.deleted=0
              AND ib.deleted=0
              AND pb.deleted=0 and b.id='$id'";

    $itemDetal = $db->query($sql);
    return $db->fetchByAssoc($itemDetal);
}

// If form is submitted 
if (isset($_FILES['bt_attached_file']) && !empty($_FILES['bt_attached_file']))
{


    $uploadedFile = '';
    $uploadStatus = '';
    if (!empty($_FILES["bt_attached_file"]["name"]))
    {

        // File path config 
        //$_SERVER['SCRIPT_FILENAME']) . "upload/apilog/$filename"
        //print_r($_FILES['bt_attached_file']);
        $fileName       = date('d_m_Y_H_i_s') . '_' . basename($_FILES["bt_attached_file"]["name"]);
        $targetFilePath = 'upload/srm_docs/' . $fileName;
        $fileType       = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        $allowTypes = array('pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg');
        if (in_array($fileType, $allowTypes))
        {

            if (move_uploaded_file($_FILES["bt_attached_file"]["tmp_name"], $targetFilePath))
            {
                $uploadStatus = 1;
                $uploadedFile = $fileName;
                //$response['message'] = 'Uploaded';
            }
            else
            {
                $uploadStatus        = 0;
                $response['message'] = 'Sorry, there was an error uploading your file.';
            }
        }
        else
        {
            $uploadStatus        = 0;
            $response['message'] = 'Sorry, only PDF, DOC, JPG, JPEG, & PNG files are allowed to upload.';
        }
    }

    if ($uploadStatus == 1)
    {


        // Insert form data in the database 
        $str             = trim($_POST['bt_srm_comments']);
        $bt_srm_comments = htmlspecialchars($str, ENT_QUOTES);
        $insert          = $db->query("update te_student_batch set bt_srm_attachment='$fileName',bt_srm_comments='$bt_srm_comments' where id='$cbid'");

        if ($insert)
        {
            $response['status']  = 1;
            $response['message'] = 'Form data submitted successfully!';
        }
    }
}

// Return response 
if ($response['status'] != 1)
{
    echo json_encode($response);
    return;
}

//$student_country=$_REQUEST['student_country'];
//echo '$old_batch_id='.$old_batch_id.'$new_batch_id='.$new_batch_id.'$student_id='.$student_id.'$cbid='.$cbid;die;

$studentSql      = "SELECT * FROM te_student WHERE id='" . $student_id . "' AND deleted=0";
$studentObj      = $GLOBALS['db']->query($studentSql);
$studentDetails  = $GLOBALS['db']->fetchByAssoc($studentObj);
$student_country = $studentDetails['country'];
$studentemail    = $studentDetails['email'];
$studentmobile   = $studentDetails['mobile'];
$studentname     = $studentDetails['name'];

$studentBatchObj                        = new te_transfer_batch();
$studentBatchObj->te_student_batch_id_c = $old_batch_id;
$studentBatchObj->old_batch_records     = $old_batch_id;
$studentBatchObj->batch_id_rel          = $cbid;
$studentBatchObj->te_ba_batch_id_c      = $new_batch_id;
$studentBatchObj->te_student_id_c       = $student_id;
$studentBatchObj->status                = "Pending";
$studentBatchObj->country               = $student_country;
$tid                                    = $studentBatchObj->save();
$utmOptions['status']                   = "queued";

//$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/reports/srm_docs/" . $uploadedFile, "wb");
//fwrite($fp, $AllLeadData);
//fclose($fp);
//
//

   $oldRecords      = getInstProBatName($old_batch_id);
$newRecords      = getInstProBatName($new_batch_id);
$str             = trim($_POST['bt_srm_comments']);
$bt_srm_comments = htmlspecialchars($str, ENT_QUOTES);
//print_r($oldRecords);
//print_r($newRecords); 
$mail            = new FalconideEmail();

sugar_chmod($targetFilePath, 0777);
//$btApprover = array('pawan.kumar@talentedge.in', 'kunal.soni@talentedge.in', 'ashis.mohanty@talentedge.in','anup.kumar@talentedge.in');

$btApprover = array('pawan.kumar@talentedge.in');

//print_r($emailData);
foreach ($btApprover as $val)
{

    $email_summary = '
        
   <table cellpadding="0" cellspacing="0" style="width: 600px; border:1px solid #999; padding: 10px;" align="center">
        
        <tr>
            <td style="font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#333; text-align: center; font-weight: bold;">SRM Batch Transferred Details</td>
        </tr>
        <tr>
            <td><hr/></td>
        </tr>
        <tr>
            <td height="15"></td>
        </tr>
        <tr>
        	<td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333; text-align: left; font-weight: bold;">Hi,</td>
        </tr>
        
        <tr>
            <td height="15"></td>
        </tr>
        <tr>
            <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333; text-align: left; font-weight: bold;">Below is the information of Batch Transfer Request</td>
        </tr>
        <tr>
        	<td height="15"></td>
        </tr>
        <tr>
            <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333; text-align: left; font-weight: bold;">
               <table cellpadding="0" cellspacing="0" style="width: 600px; border:1px solid #999; padding: 10px; border-collapse: collapse;" align="center">
                <tr>
                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif; width: 28%;  padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: bold;">Name :</td>
                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif; width: 72%;  padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: normal;">'.$studentname.'</td>
                </tr>
                <tr>
                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif; padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: bold;">Email :</td>
                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif; padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: normal;"><a href="#">'.$studentemail.'</a></td>
                </tr>
                <tr>
                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif; padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: bold;">Mobile :</td>
                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif; padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: normal;">'. $studentmobile.'</td>
                </tr>
                <tr>
                <td></td> <td></td>
                </tr>
                <tr>
                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif; padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: bold;">Old Institute Name :</td>
                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif; padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: normal;">'.$oldRecords['insname'].'</td>
                </tr>
                <tr>
                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif; padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: bold;">Old Programe Name : </strong></td>
                    <td style="font-family:Arial, Helvetica, sans-serif; padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: normal;">'. $oldRecords['programname'].'</td>
                </tr>
                <tr>
                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif; padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: bold;">Old Batch Name :</td>
                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif; padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: normal;">' . $oldRecords['batchname'] . '</td>
                </tr>
                <tr>
                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif; padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: bold;">Batch Code :</td>
                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif; padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: normal;">' . $oldRecords['batch_code'] . '</td>
                </tr>
                <tr>
                <td></td> <td></td>
                </tr>
                <tr>
                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif; padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: bold;">New Institute Name :</td>
                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif; padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: normal;">' . $newRecords['insname'] . '</td>
                </tr>
                <tr>
                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif; padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: bold;">New Programe Name : </strong></td>
                    <td style="font-family:Arial, Helvetica, sans-serif; padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: normal;">' . $newRecords['programname'] . '</td>
                </tr>
                <tr>
                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif; padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: bold;">New Batch Name :</td>
                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif; padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: normal;">' . $newRecords['batchname'] . '</td>
                </tr>
                <tr>
                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif; padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: bold;">Batch Code :</td>
                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif; padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: normal;">' . $oldRecords['batch_code'] . '</td>
                </tr>
                <tr>
                    <td style="padding: 10px; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333; text-align: left; font-weight: normal;"><strong style="margin-right: 10px;">SRM Comments : </strong></td>
                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif; padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: normal;">'.substr($bt_srm_comments, 0, 100).'...(<a href="http://crmstage.talentedge.in/crm/srmrequeststatus.php?student_batch='.$cbid.'&tid='.$tid.'&appusr=' . md5($val) . '">Click the approval URl for more details</a>)</td>
                </tr>
               </table> 
            </td>
        </tr>
        <tr>
            <td height="15"></td>
        </tr>
        <tr>
            <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333; text-align: left; font-weight: bold;">Click the Below links to approve the request</td>
        </tr>
        <tr>
            <td height="15"></td>
        </tr>
        <tr>
            <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333; text-align: left; font-weight: bold;"><strong>Approval URL:</strong>&nbsp;<a href="http://crmstage.talentedge.in/crm/srmrequeststatus.php?student_batch='.$cbid.'&tid='.$tid.'&appusr=' . md5($val) . '" style="font-weight: normal;">the crmstage.talentedge.in</a></td>
        </tr>
        <tr>
            <td height="15"></td>
        </tr>
       
        <tr>
            <td height="15"></td>
        </tr>
        <tr>
            <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333; text-align: left; font-weight: bold;">Regards</td>
        </tr>
         <tr>
            <td height="8"></td>
        </tr>
        <tr>
            <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333; text-align: left;">SRM Team</td>
        </tr>
     </table>





';


    $emailData = $mail->toBtApprover('Batch Trasfer Request', $uploadedFile, date('Y-m-d'), $email_summary, array($val));
    $nnn       = $mail->btApprovalEmail($emailData);
}

echo json_encode($utmOptions);
return false;
