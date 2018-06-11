<?php
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');

class listviewClass {
    function listview(&$bean, $event, $arguments) {
    global $db;
    
    //echo '<pre>'; print_r($bean);

       //**** Student list View Details **************/
	//	$aa="SELECT mobile,email,country FROM te_student WHERE id=(SELECT te_student_te_student_batch_1te_student_ida FROM te_student_te_student_batch_1_c WHERE 'te_student_te_student_batch_1te_student_batch_idb'='".$bean->id."'";

			$row1 =$db->query("SELECT mobile,email,country,lead_id_c FROM te_student WHERE id=(SELECT te_student_te_student_batch_1te_student_ida FROM te_student_te_student_batch_1_c WHERE `te_student_te_student_batch_1te_student_batch_idb`='".$bean->id."')");
			$res1 =$db->fetchByAssoc($row1);
                        $mobile = $res1['mobile'];
                        $LeadID = $res1['lead_id_c'];

			$bean->email=$res1['email'];
			$bean->mobile= $mobile.'  <img src="custom/themes/default/images/phone.png" href="" onclick="clickToCall('.$mobile.',\''.$LeadID.'\')" alt="Smiley face" height="20" width="20">';
      //echo "SELECT SUM(`amount`)amt_paid FROM `te_student_payment` WHERE `te_student_batch_id_c`='".$bean->id."'";
      //exit();
			$row =$db->query("SELECT SUM(`amount`)amt_paid FROM `te_student_payment` WHERE `te_student_batch_id_c`='".$bean->id."'  AND payment_realized=1");
			$res =$db->fetchByAssoc($row);

		//$bean->feepaid=$res['fee_usd'];
      if($res['amt_paid']!=='0.00'){
        $inr=$res['amt_paid'];
        if($res1['country']=="INDIA" || $res1['country']=="india" || $res1['country']=="India" || $res1['country']=="")
  			{

    			$bean->feepaid="INR- ".number_format($inr, 2, '.', ' ');
  			}
  			else
  			{
  			  $bean->feepaid="USD- ".number_format($inr, 2, '.', ' ');
  			}
      }
      else{
        $bean->feepaid="NA";
      }


			// $bean->feepaid=$row1;

		}
 }


?>
	<script>
	function clickToCall(phone, lead_id) {

					//~ alert(phone)
					if (confirm('Are you sure to make a call')) {
						SUGAR.ajaxUI.showLoadingPanel();
						var callback = {
							success: function (b) {
								SUGAR.ajaxUI.hideLoadingPanel();
								if (b.responseText)
									swal(b.responseText);
							}

						}

						var connectionObject = YAHOO.util.Connect.asyncRequest('GET', 'index.php?entryPoint=clickToCall&lead=' + lead_id + '&number=' + phone, callback);
					}
				}




			</script>

<?php
