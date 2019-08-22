<?php
if(!defined('sugarEntry'))define('sugarEntry', true);
require_once('include/entryPoint.php');
require_once('custom/include/Email/sendmail.php'); 
require_once('modules/EmailTemplates/EmailTemplate.php');
global $db;
if($_GET['student_batch']!=''){
	$student_batch	= $_GET['student_batch'];
}else{
	echo "Wrong URL";exit; 
}
if($_POST['Submit']){
	$updatedata="UPDATE te_student_batch set bt_fee_waiver='".$_POST['one']."', bt_approver_comments='".$_POST['approve_comment']."' where id='".$student_batch."'";
	$updatequerydata=$db->query($updatedata);
	$updatestatus="UPDATE te_transfer_batch set status='".$_POST['two']."' where batch_id_rel='".$student_batch."'";
	$updatequerydata=$db->query($updatestatus);

	//API Call
	global $sugar_config;
	$data=array();
	$user     = 'talentedgeadmin';
    $password = 'Inkoniq@2016';
    //$url      = 'https://talentedge.in/order-api/';
   echo $url      = $sugar_config['website_URL'] . '/batch_transfer.php';
    $headers  = array(
        'Authorization: Basic ' . base64_encode("$user:$password")
    );
    $data['new_batch_code']=$_POST['newbatchcode'];
	$data['old_batch_code']=$_POST['oldbatchcode'];
	$data['email']	=	$_POST['emailid'];
    $ch     = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $result = curl_exec($ch);
    $res    = json_decode($result,TRUE);
    echo "=====<pre>";print_r($result);echo "</pre>";exit;
	$subject="Batch transfer Mail";
	$body = "Hi,<br/>The batch transfer request of the candidate, name <b>'".$_POST['studentname']."'</b> which email id <b>'".$_POST['emailid']."'</b> has been <b>'".$_POST['two']."'</b>.";
	$to='ashis.mohanty@talentedge.in';
	$mail = new NetCoreEmail();
	$mail -> sendEmail($to,$subject,$body);
	//header('Location:'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
	//die;
}

$query = "SELECT sb.name as old_program_name,sb.batch_code as old_batch_code, ii.name as old_institute_name, bb.name as new_program_name, bb.batch_code as new_batch_code, s.name as student_name, s.email, s.mobile, tb.status, sb.bt_srm_comments,sb.bt_approver_comments, sb.bt_fee_waiver,sb.bt_srm_attachment from te_student_batch sb, te_student s,te_transfer_batch tb,te_ba_batch bb, te_in_institutes ii where sb.id='".$student_batch."' and sb.leads_id=s.lead_id_c and tb.batch_id_rel=sb.id and bb.id=tb.te_ba_batch_id_c and ii.id=sb.te_in_institutes_id_c";
$result = $db->query($query);
$row = $db->fetchByAssoc($result);

//echo "<pre>";print_r($_SERVER);echo "</pre>";
?>

<!doctype html>
<html> 
<head> 
<meta charset="utf-8">
<title>CRM</title>
<!-- <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=0"> -->
<meta name="viewport" content="user-scalable = 1">
<link href="css/stylesheet.css" rel="stylesheet" type="text/css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
	<form method="post">
	<div class="crm-detail-wrapper">
		<div class="crm-detail-container">		
		<input type="hidden" name="emailid" id="emailid" value="<?php echo $row['email'];?>"/>
		<input type="hidden" name="studentname" id="studentname" value="<?php echo $row['student_name'];?>"/>
		<input type="hidden" name="oldbatchcode" id="oldbatchcode" value="<?php echo $row['old_batch_code'];?>"/>
		<input type="hidden" name="newbatchcode" id="newbatchcode" value="<?php echo $row['new_batch_code'];?>"/>
			<div class="profile-section">
				
				<div class="profile-details">
					<div class="student-name"><?php echo $row['student_name'];?></div>
					<ul>
						<li><i style="font-weight: bold;">Email</i><?php echo $row['email'];?></li>
						<li><i style="font-weight: bold;">Mobile</i><?php echo $row['mobile'];?></li>
					</ul>
					<div class="profile-block">
						<div class="status"><span><?php echo $row['status'];?></span></div>
					</div>	
					<div class="program-info">
						<div class="block">		
							<ol>
								<li><i style="font-weight: bold;">Old Programe Name</i><?php echo $row['old_program_name'];?></li>
								<li><i style="font-weight: bold;">Old Batch Name</i><?php echo $row['old_batch_code'];?></li>
								<li><i style="font-weight: bold;">Old Institute Name</i><?php echo $row['old_institute_name'];?></li>
							</ol>
						</div>
						<div class="block">
							<ol>
								<li><i style="font-weight: bold;">New Programe Name</i><?php echo $row['new_program_name'];?></li>
								<li><i style="font-weight: bold;">New Batch Name</i><?php echo $row['new_batch_code'];?></li>
								<li><i style="font-weight: bold;">New Institute Name</i><?php echo $row['new_institute_name'];?></li>
							</ol>
						</div>
					</div>
				</div>			
			</div>

				<section>
					<div class="block">
						<label>SRM Comment</label>
						<p><?php echo $row['bt_srm_comments'];?></p>
					</div>
					<div class="block">
						<label>Topic</label>
						<label><input type="radio" name="one" value="1" <?php echo ($row['bt_fee_waiver']== '1') ?  "checked" : "" ;  ?>/> Waiver</label>
						<label><input type="radio" name="one" value="2" <?php echo ($row['bt_fee_waiver']== '2') ?  "checked" : "" ;  ?>/> To be Deducted</label>
						<label><input type="radio" name="one" value="3"<?php echo ($row['bt_fee_waiver']== '3') ?  "checked" : "" ;  ?> /> To be Paid</label>
					</div>
					<div class="block">
						<label>Status</label>
						<label><input type="radio" name="two" value="Approve" <?php echo ($row['status']== 'Approve') ?  "checked" : "" ;  ?>/> Approve</label>
						<label><input type="radio" name="two" value="Reject" <?php echo ($row['status']== 'Reject') ?  "checked" : "" ;  ?>/> Reject</label>
						<?php if($row['bt_srm_attachment']!=''){?>
						<div class="block-action">
							<button><a href="<?php echo "/crm/upload/srm_docs/".$row['bt_srm_attachment'];?>" target="_blank">Download Attached File</a></button>
						</div>
						<?php }?>
					</div>
					<div class="block">
						<label>Comment</label>
						<textarea placeholder="Enter your Comments here" name="approve_comment" ><?php echo $row['bt_approver_comments'];?></textarea>
					</div> 
					<div class="block-action">
						<input type="submit" value="Submit" name="Submit">
					</div>

			</section>	
		</div>		
	</div>
</form>
</body>
</html>	
<style type="text/css">
	
	* {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
body{margin:0; padding:0; scroll-behavior: smooth; background-color: #f7f7f7;}
html{margin:0; padding:0; scroll-behavior: smooth;}
@font-face {
    font-family: 'latoregular';
    src: url(../fonts/Lato-Regular.ttf);
    font-weight: normal;
    font-style: normal
}

@font-face {
    font-family: 'latobold';
    src: url(../fonts/Lato-Bold.ttf);
    font-weight: normal;
    font-style: normal
}

@font-face {
    font-family: 'latoblack';
    src: url(../fonts/Lato-Black.ttf);
    font-weight: normal;
    font-style: normal
}

@font-face {
    font-family: 'latolight';
    src: url(../fonts/Lato-Light.ttf);
    font-weight: normal;
    font-style: normal
}

.crm-detail-wrapper{display:flex; flex-direction: column; width: 100%; max-width: 800px; margin:auto;}
.crm-detail-wrapper .crm-detail-container{display:flex; width: 100%; border:1px solid#ddd; border-radius:6px; flex-direction: column;  padding:20px; background-color: #fff;}
.profile-section{display: flex; flex-direction: column;  width: 100%;}
.profile-section .profile-block { display: flex; flex-direction: column; align-items: center; margin-bottom:15px;}
.profile-section .profile-block .profile-thumb{box-shadow:1px 3px 5px #666; width:120px; height: 120px; border-radius: 100%; background-color: #f7f7f7;}
.profile-section .profile-block .profile-thumb img{max-width: 100%; border-radius: 100%; }
.profile-section .profile-block .status {display:flex; align-items: center; justify-content: center; margin-top: 10px;}
.profile-section .profile-block .status span{background-color: #22a9eb;   font-family: 'latoregular'; padding: 5px 15px; color: #fff; font-size: 13px; border-radius:15px;}
.profile-section .profile-details{display: flex; flex-direction: column; align-items: center; justify-content: center;}
.profile-section .profile-details .program-info{display: flex; width: 100%; margin-top: 25px;}
.profile-section .profile-details .program-info .block{box-shadow: 1px 3px 5px #eaeaea; border-radius:6px; width: 50%; margin-left:25px; background-color: #fff; border:1px solid #ddd; padding:10px;}
.profile-section .profile-details .program-info .block:first-child{margin-left: 0;}
.profile-section .profile-details .student-name{font-size: 20px; margin-bottom:10px;  font-family: 'latobold'; color:#303030;}
.profile-section .profile-details ul{margin:0; padding: 0;}
.profile-section .profile-details ul li{margin:5px 0 0; justify-content: center; display: flex; font-size: 13px; padding: 0; list-style-type: none; font-family: 'latoregular'; color:#bdbdbd; font-size: 13px;}
.profile-section .profile-details ul li i{font-style: normal; margin-right: 5px; font-size: 13px; font-family: 'latobold'; color:#808080;}
.profile-section .profile-details ol{margin:0; padding: 0;}
.profile-section .profile-details ol li{margin:15px 0 0; display: flex; font-size: 13px; flex-direction:column;  padding: 0; list-style-type: none; font-family: 'latoregular'; color:#bdbdbd; font-size: 13px;}
.profile-section .profile-details ol li:first-child{margin-top: 0;}
.profile-section .profile-details ol li i{font-style: normal; margin-bottom: 5px; font-size: 13px; font-family: 'latobold'; color:#808080;}
.crm-detail-wrapper section{padding:20px 0 0; margin-top:20px;  border-top:1px solid #ddd;}
.crm-detail-wrapper section input[type="radio"]{margin:0 5px 0; padding: 0; display: block}
.crm-detail-wrapper section .block{display: flex; align-items: flex-start; margin-bottom: 25px;}
.crm-detail-wrapper section .block label:first-child{font-family: 'latobold';}
.crm-detail-wrapper section .block label{font-family: 'latoregular'; min-width: 70px; margin-right: 15px; display:flex; align-items: center; vertical-align: middle; color:#303030; font-size: 13px;}
.crm-detail-wrapper section .block label:last-child{margin-right: 0;}
.crm-detail-wrapper section .block textarea{ height: 100px; font-family: 'latoregular'; width: 100%; resize: none; background-color: #fdfdfd; border:1px solid #ddd; border-radius: 6px; padding:10px; }
.crm-detail-wrapper section .block textarea:focus{outline: 0px none;}
.crm-detail-wrapper section .block p{margin: 0px; font-family: 'latoregular'; font-size: 13px; color: #999; line-height: 22px;}
.crm-detail-wrapper .block-action{display: flex; align-items: center; justify-content: center;}
.crm-detail-wrapper .block-action button{background-color: #22a9eb;   font-family: 'latoregular'; border:0px none; cursor: pointer; padding:7px 35px; color: #fff; font-size: 13px; border-radius:15px;}
.crm-detail-wrapper .block-action button:focus{outline: 0px none;}
</style>