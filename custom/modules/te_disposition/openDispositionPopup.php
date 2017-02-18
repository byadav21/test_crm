<?php
//~ echo "<pre>";
//~ print_r($_REQUEST);


//~ print_r($_REQUEST);
if(isset($_REQUEST['disposition_id']) && !empty($_REQUEST['disposition_id'])){
	//~ echo "here--";
	$disposition = new te_disposition();
	$disposition->retrieve($_REQUEST['disposition_id']);
	$disposition->name 		   	 = 'unsaved';
	$disposition->status 		   	 = 'unsaved';
	$disposition->unique_call_id = $_REQUEST['call_id'];
	$disposition->te_disposition_leadsleads_ida = $_REQUEST['lead_id'];
	//~ $disposition_id = $disposition->save();
	//~ echo $disposition_id;
	$disposition_id = $_REQUEST['disposition_id'];
	$mobile = $_REQUEST['mobile'];
}


//~ echo "</pre>";
?>
<script type="text/javascript" src="cache/include/javascript/sugar_grp1_jquery.js?v=wUfeT5IQUbwii78MflriMw"></script>
<script type="text/javascript" src="cache/include/javascript/sugar_grp1_yui.js?v=wUfeT5IQUbwii78MflriMw"></script>
<script type="text/javascript" src="cache/include/javascript/sugar_grp1.js?v=wUfeT5IQUbwii78MflriMw"></script>
<script type="text/javascript" src="include/javascript/calendar.js?v=wUfeT5IQUbwii78MflriMw"></script>

<script type="text/javascript" src="custom/modules/Leads/include/js/popup.js"></script>
<link href="themes/SuiteR/css/bootstrap.min.css" rel="stylesheet">
    <link href="themes/SuiteR/css/footable.core.css" rel="stylesheet" type="text/css" />
     <link rel="stylesheet" type="text/css" href="include/javascript/qtip/jquery.qtip.min.css" />
     <link rel="stylesheet" type="text/css" href="cache/themes/SuiteR/css/yui.css?v=wUfeT5IQUbwii78MflriMw" />
     <link rel="stylesheet" type="text/css" href="include/javascript/jquery/themes/base/jquery.ui.all.css" />
     <link rel="stylesheet" type="text/css" href="cache/themes/SuiteR/css/deprecated.css?v=wUfeT5IQUbwii78MflriMw" />
     <link rel="stylesheet" type="text/css" href="cache/themes/SuiteR/css/style.css?v=wUfeT5IQUbwii78MflriMw" />
    <link rel="stylesheet" type="text/css" href="themes/SuiteR/css/colourSelector.php">
<style type="text/css">
.modalContentpop th, .modalContentpop td {
    border: none;
    padding: 0;
    width: 240px;
}
.modalContentpop {
    background-color: #fff !important;;
    border-bottom-right-radius: 0px !important;
    border-bottom-left-radius: 0px !important;
    padding: 10px 30px !important;
    overflow: auto;
	min-height:none !important;
}
.modalContentpop input[type=text]{
    WIDTH: 190PX !important;
}
.modalContentpop select {
    WIDTH: 190PX !important;
}
.modalContentpop textarea {
    WIDTH: 190PX !important;
}
.dumbBoxpop {
    width: 80% !important;
    position: relative;
    margin: 0 auto;
    background-color: white !important;
    padding: -1px;
    border: 1px solid #A3A0A0;
    border-radius: 0px !important;
}
.modalHeaderpop h4 {
    margin: 6px 0 5px 0 !important;
    color: #fff;
}
.closeModalpop {
    top: 7px !important;
}
.head_textpop {
    display: inline-block;
    max-width: 100%;
    margin-top: 8px;
    font-weight: 700;
	font-size:14px;
}
.modalHeaderpop {
    min-height: 41px !important;
    background: #3C8DBC none repeat scroll 0 0 !important;
    border-top-left-radius: 0px !important;
    border-top-right-radius: 0px !important;
    border-bottom: 2px solid #CCC!important;
    text-align: -webkit-center;
    text-align: center;
    padding-top: 6px !important;
}
.vertical-offsetpop {
    width: 85% !important;
}
.buttonpop {
	background-color: #3C8DBC !important;
    margin: 10px 0px !important;
    padding: 10px 115px !important;
    font-size: 16px !important;
}

</style>



<script type="text/javascript">

Calendar.setup ({
   inputField : "date_of_prospect_date_d",
   daFormat : "%Y-%m-%d %I:%M%P",
   button : "date_of_prospect_trigger_d",
   singleClick : true,
   dateStr : "",
   step : 1,
   weekNumbers:false,
});



Calendar.setup ({
   inputField : "date_of_callback_date_d",
   daFormat : "%Y-%m-%d %I:%M%P",
   button : "date_of_callback_trigger_d",
   singleClick : true,
   dateStr : "",
   step : 1,
   weekNumbers:false,
});


Calendar.setup ({
   inputField : "date_of_followup_date_d",
   daFormat : "%Y-%m-%d %I:%M%P",
   button : "date_of_followup_trigger_d",
   singleClick : true,
   dateStr : "",
   step : 1,
   weekNumbers:false,
});

	function detailLead(){
			//~ alert(window.parent)
			//~ parent.window.open
			
			var lead_id = document.getElementById('lead_id').value;
			var disposition_id = document.getElementById('disposition_id').value;
			//~ var url_open = "http://localhost/TalentEdge/index.php?module=Leads&action=EditView&record="+lead_id+"&disposition_id="+disposition_id+"&from_pusher=1";
			var url_open = "http://35.154.138.186/crm/index.php?module=Leads&action=EditView&record="+lead_id+"&disposition_id="+disposition_id+"&from_pusher=1";
			window.opener = self;
			window.close();
			
			parent.window.open(url_open);
				
	}
	
	function saveDisposition(){
			
			var status = document.getElementById('status_d').value;
			var status_detail = document.getElementById('status_detail_d').value;
			var msg = "Please fill the following required field !!";
			var flag =1;
			if(status==''){
				msg = msg +"\n\t --Status \n"
				flag =0;
			}
			if(status_detail ==''){
				msg = msg +"\t --Status Detail \n"	
				flag =0;
			}
			if(flag ==0){
				alert(msg);
				return false;
			}
			else{	
				var description = document.getElementById('description_d').value;
				//~ 
				var callback_date = document.getElementById('date_of_callback_date_d').value;
				var callback_hr = document.getElementById('date_of_callback_hours_d').value;
				var callback_min = document.getElementById('date_of_callback_minutes_d').value;
				var disposition_id = document.getElementById('disposition_id').value;
				//~ 
				var callback = callback_date+" "+callback_hr+":"+callback_min+":00";
				
				
				//~ 
				var followup_date = document.getElementById('date_of_followup_date_d').value;
				var followup_hr = document.getElementById('date_of_followup_hours_d').value;
				var followup_min = document.getElementById('date_of_followup_minutes_d').value;
				//~ 
				var followup = followup_date+" "+followup_hr+":"+followup_min+":00";
				//~ 
				var prospect_date = document.getElementById('date_of_prospect_date_d').value;
				var prospect_hr = document.getElementById('date_of_prospect_hours_d').value;
				var prospect_min = document.getElementById('date_of_prospect_minutes_d').value;
				//~ 
				var prospect = prospect_date+" "+prospect_hr+":"+prospect_min+":00";
				//~ 
				//~ 
				var params = '&disposition_id='+disposition_id+'&status='+status+'&status_detail='+status_detail+'&description='+description+'&callback='+callback+'&followup='+followup+'&prospect='+prospect
				//~ alert(params)
				//~ return false;
				//~ SUGAR.ajaxUI.showLoadingPanel();
				var callback = {
					success:function(b){
						//~ SUGAR.ajaxUI.hideLoadingPanel();
						//~ alert(b.responseText)
						if(b.responseText.trim()=="1"){	
							window.opener = self;
						window.close();
							//~ window.location.href='index.php?module=te_disposition&action=index';
						}
						else if(b.responseText.trim()=="2"){
							alert('Please disconnect the call first and save the record')
						}
						else{
							alert('Error!! Record not saved')
						}
					}
							
				}
				
				var connectionObject = YAHOO.util.Connect.asyncRequest('GET', 'index.php?entryPoint=saveDisposition'+params, callback);
			}
		 }
  
</script>

<div class="dumbBoxWrap" id="atomBox"> 
			<div class="dumbBoxOverlay"></div>
			<div class="vertical-offset vertical-offsetpop">
				<div class="dumbBox dumbBoxpop">
<!--
					<a id="closeModal"  class="closeModalpop" onclick="hideAtomBox();"><img src="custom/modules/Leads/include/img/modal_close.png"/></a>
-->
				 	<div class="modalHeader modalHeaderpop">
				 		<h4>Disposition</h4>
				 		
				 	</div>
				 	<div class="modalContent modalContentpop">
						<span id="call_status" style="color:red">&nbsp;</span>
						<table style="width:100%">
	
	
	
<!-- Lead Detail Code Goes Here------->		
<?php 	if(isset($_REQUEST['from_pusher']) && $_REQUEST['from_pusher']==1){  ?>
						<tr>
							<td  align="left"><span class="head_textpop">First Name</span></td>
							<td  align="left"><span>
								&nbsp;&nbsp;<?=$_REQUEST['fname']?>
							</span></td>
						</tr>
						<tr>
							<td  align="left"><span class="head_textpop">Last Name</span></td>
							<td  align="left"><span>
								&nbsp;&nbsp;<?=$_REQUEST['lname']?>
							</span></td>
						</tr>
						<tr>
							<td  align="left"><span class="head_textpop">Email</span></td>
							<td  align="left"><span>
								&nbsp;&nbsp;<?=$_REQUEST['email']?>
							</span></td>
						</tr>
						<tr>
							<td  align="left"><span class="head_textpop">Address</span></td>
							<td  align="left"><span>
								&nbsp;&nbsp;<?=$_REQUEST['address']?>
							</span></td>
						</tr>
						<tr>
							<td  align="left"><span class="head_textpop">Batch</span></td>
							<td  align="left"><span>
								&nbsp;&nbsp;<?=$_REQUEST['bname']?>
							</span></td>
						</tr>
						<tr>
							<td  align="left"><span class="head_textpop">Program</span></td>
							<td  align="left"><span>
								&nbsp;&nbsp;<?=$_REQUEST['pname']?>
							</span></td>
						</tr>
						<tr>
							<td  align="left"><span class="head_textpop">Education</span></td>
							<td  align="left"><span>
								&nbsp;&nbsp;<?=$_REQUEST['edu']?>
							</span></td>
						</tr>
						<tr>
							<td  align="left"><span class="head_textpop">Experience</span></td>
							<td  align="left"><span>
								&nbsp;&nbsp;<?=$_REQUEST['work']?>
							</span></td>
						</tr>
						

<?php 	} 	?>
<!---------------------End-------->

	
						   <tr>
							<td  align="left"><span class="head_textpop">Status</span></td>
							<td  align="left"><span>
								<select name="status_d" id="status_d" title="" accesskey="7">
								<option label="" value=""></option>
								<option label="Alive" value="Alive">Alive</option>
								<option label="Dead" value="Dead">Dead</option>
								<option label="Warm" value="Warm">Warm</option>
								</select>
							</span></td>
							</tr>
							<tr>
							
							<td  align="left"><span class="head_textpop">Status Detail:</span></td>
							<td  align="left"><span>
								<select name="status_detail_d" id="status_detail_d" title="">
								<option label="" value=""></option>
								<option label="Dead Number" value="Dead Number">Dead Number</option>
								<option label="Wrong Number" value="Wrong Number">Wrong Number</option>
								<option label="Ringing Multiple Times" value="Ringing Multiple Times">Ringing Multiple Times</option>
								<option label="Not Enquired" value="Not Enquired">Not Enquired</option>
								<option label="Not Eligible" value="Not Eligible">Not Eligible</option>
								<option label="Rejected" value="Rejected">Rejected</option>
								<option label="Fallout" value="Fallout">Fallout</option>
								<option label="Retired" value="Retired">Retired</option>
								<option label="Call Back" value="Call Back">Call Back</option>
								<option label="Follow Up" value="Follow Up">Follow Up</option>
								<option label="New Lead" value="New Lead">New Lead</option>
								<option label="Re-Enquired" value="Re-Enquired">Re-Enquired</option>
								<option label="Prospect" value="Prospect">Prospect</option>
								</select>
							</span></td> 
						  </tr>
						 <tr><td><input type="hidden" id="call_id" value="<?=$_REQUEST['call_id']?>"></td>
						 <td><input type="hidden" id="lead_id" value="<?=$_REQUEST['lead_id']?>">
						 <input type="hidden" id="mobile" value="<?=$_REQUEST['mobile']?>">
						 <input type="hidden" id="disposition_id" value="<?=$disposition_id?>">
						 </td></tr>
						 <tr>
							<td  align="left"><span class="head_textpop">Note:</span></td>
							<td  align="left"><span>
							<textarea id="description_d" name="description_d" rows="3" cols="29" title="" tabindex="0"></textarea>
							</span></td>
						 </tr>
						 
						 <tr>	 
							<td align="left"><span class="head_textpop" id ="call_back_label">Call back Date:</span></td>
							<td  align="left"><span>
							<input autocomplete="off" type="text" id="date_of_callback_date_d" value="" size="11" maxlength="10" title="" tabindex="0" onblur="combo_date_of_callback.update();" onchange="combo_date_of_callback.update(); " style="display: inline;">
							<img src="themes/SuiteR/images/jscalendar.gif?v=wUfeT5IQUbwii78MflriMw" alt="Enter Date" style="position: relative; top: -2px; display: inline;" border="0" id="date_of_callback_trigger_d">&nbsp;&nbsp;
							<select class="datetimecombo_time" size="1" id="date_of_callback_hours_d" tabindex="0">
								<option></option>
								<option value="00">00</option>
								<option value="01">01</option>
								<option value="02">02</option>
								<option value="03">03</option>
								<option value="04">04</option>
								<option value="05">05</option>
								<option value="06">06</option>
								<option value="07">07</option>
								<option value="08">08</option>
								<option value="09">09</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
								<option value="13">13</option>
								<option value="14">14</option>
								<option value="15">15</option>
								<option value="16">16</option>
								<option value="17">17</option>
								<option value="18">18</option>
								<option value="19">19</option>
								<option value="20">20</option>
								<option value="21">21</option>
								<option value="22">22</option>
								<option value="23">23</option>
							</select>&nbsp;&nbsp;
							<select class="datetimecombo_time" size="1" id="date_of_callback_minutes_d" tabindex="0">
								<option></option>
								<option value="00">00</option>
								<option value="15">15</option>
								<option value="30">30</option>
								<option value="45">45</option>
								</select>
							</span></td> 
						  </tr>
						 
						
						 <tr id="followup_d">	 
							<td align="left"><span id ="followup_label" class="head_textpop">Followup Date:</span></td>
							<td  align="left"><span>
							<input autocomplete="off" type="text" id="date_of_followup_date_d" value="" size="11" maxlength="10" title="" tabindex="0" onblur="combo_date_of_followup.update();" onchange="combo_date_of_followup.update(); " style="display: inline;">
							<img src="themes/SuiteR/images/jscalendar.gif?v=wUfeT5IQUbwii78MflriMw" alt="Enter Date" style="position: relative; top: 6px; display: inline;" border="0" id="date_of_followup_trigger_d">&nbsp;&nbsp;
							<select class="datetimecombo_time" size="1" id="date_of_followup_hours_d" tabindex="0" >
								<option></option>
								<option value="00">00</option>
								<option value="01">01</option>
								<option value="02">02</option>
								<option value="03">03</option>
								<option value="04">04</option>
								<option value="05">05</option>
								<option value="06">06</option>
								<option value="07">07</option>
								<option value="08">08</option>
								<option value="09">09</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
								<option value="13">13</option>
								<option value="14">14</option>
								<option value="15">15</option>
								<option value="16">16</option>
								<option value="17">17</option>
								<option value="18">18</option>
								<option value="19">19</option>
								<option value="20">20</option>
								<option value="21">21</option>
								<option value="22">22</option>
								<option value="23">23</option>
							</select>&nbsp;&nbsp;
							<select class="datetimecombo_time" size="1" id="date_of_followup_minutes_d" tabindex="0">
								<option></option>
								<option value="00">00</option>
								<option value="15">15</option>
								<option value="30">30</option>
								<option value="45">45</option>
								</select>
							</span></td> 
						  </tr>
						 
						
						 <tr>	 
							<td align="left"><span id ="prospect_label" class="head_textpop">Prospect Date:</span></td>
							<td  align="left"><span>
							<input autocomplete="off" type="text" id="date_of_prospect_date_d" value="" size="11" maxlength="10" title="" tabindex="0" onblur="combo_date_of_prospect.update();" onchange="combo_date_of_prospect.update(); " style="display: inline;">
							<img src="themes/SuiteR/images/jscalendar.gif?v=wUfeT5IQUbwii78MflriMw" alt="Enter Date" style="position: relative; top: 6px; display: inline;" border="0" id="date_of_prospect_trigger_d">&nbsp;&nbsp;
							<select class="datetimecombo_time" size="1" id="date_of_prospect_hours_d" tabindex="0" style="display: inline;">
								<option></option>
								<option value="00">00</option>
								<option value="01">01</option>
								<option value="02">02</option>
								<option value="03">03</option>
								<option value="04">04</option>
								<option value="05">05</option>
								<option value="06">06</option>
								<option value="07">07</option>
								<option value="08">08</option>
								<option value="09">09</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
								<option value="13">13</option>
								<option value="14">14</option>
								<option value="15">15</option>
								<option value="16">16</option>
								<option value="17">17</option>
								<option value="18">18</option>
								<option value="19">19</option>
								<option value="20">20</option>
								<option value="21">21</option>
								<option value="22">22</option>
								<option value="23">23</option>
							</select>&nbsp;&nbsp;
							<select class="datetimecombo_time" size="1" id="date_of_prospect_minutes_d" tabindex="0" style="display: inline;">

								<option></option>
								<option value="00">00</option>
								<option value="15">15</option>
								<option value="30">30</option>
								<option value="45">45</option>
								</select>
							</span></td> 
						  </tr>
						
						  <table width="100%" border="0" >
  <tr>
    <td><table width="100%" border="0" style="text-align:center">
  <tr>
    <td><div onclick="saveDisposition('<?=$disposition_id?>')"><img src="custom/modules/Leads/include/img/save_btn.png"/></div></td>
    <td> <div id ="hangup" onclick="callHangup()"><img src="custom/modules/Leads/include/img/hang_up_btn.png"/></div></td>
    <td>
    <div id ="hold" onclick="callHold('hold')"><img src="custom/modules/Leads/include/img/hold_on_btn.png"/></div></td>
 <td>
    <div style="display: none"  id ="unhold" onclick="callHold('unhold')"><img src="custom/modules/Leads/include/img/unhold_btn.png"/></div>
    </td>
    <?php
		if(isset($_REQUEST['from_pusher']) && $_REQUEST['from_pusher']==1){
		?>
    <td>
		
    <button type="button" onclick="detailLead()">Detail</button>
    </td>
    <?php
	}
		?>
  </tr>
</table>
</td>
  </tr>
</table>

						
						</table>
				 	</div>
				 </div> 
			</div> 
		</div>

