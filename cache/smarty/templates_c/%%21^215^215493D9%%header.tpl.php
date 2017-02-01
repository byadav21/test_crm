<?php /* Smarty version 2.6.29, created on 2017-02-01 06:46:25
         compiled from custom/modules/Leads/tpls/header.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sugar_button', 'custom/modules/Leads/tpls/header.tpl', 187, false),array('function', 'sugar_action_menu', 'custom/modules/Leads/tpls/header.tpl', 197, false),)), $this); ?>
{*
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2012 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

*}

<script>
    {literal}
    $(document).ready(function(){
	    $("ul.clickMenu").each(function(index, node){
	        $(node).sugarActionMenu();
	    });
    });
    
    
	function callHoldPusher(method){
			
			
			number = document.getElementById('phone_mobile').value;
			//~ alert(number);
			SUGAR.ajaxUI.showLoadingPanel();
			var callback = {
				success:function(b){
					SUGAR.ajaxUI.hideLoadingPanel();
					//alert(b.responseText);
					if(b.responseText.trim()=="200"){	
						
						if(method=='hold'){
							
							document.getElementById("hold").style.display ='none';
							document.getElementById("unhold").style.display ='inline';
						}
						else{
							
							document.getElementById("hold").style.display ='inline';
							document.getElementById("unhold").style.display ='none';
						}
					}
					else{
						if(method=='hold'){
						alert('Error!! Not putting on hold')
						}
						else{
							alert('Error!! Not putting on un hold')
						}
					}
				}
						
			}
			
			var connectionObject = YAHOO.util.Connect.asyncRequest('GET', 'index.php?entryPoint=callHold&number='+number+'&method='+method, callback);
		 }

	
	function callHangupPusher(){
			
		
			
			number = document.getElementById('phone_mobile').value;
			//~ alert(number);
			SUGAR.ajaxUI.showLoadingPanel();
			var callback = {
				success:function(b){
					SUGAR.ajaxUI.hideLoadingPanel();
					//~ alert(b.responseText);
					if(b.responseText.trim()=="200"){	
						
						document.getElementById("hangup").disabled = true;
						document.getElementById("hold").disabled = true;
						document.getElementById("unhold").disabled = true;

					}
					else{
						alert('Error!! Not Disconnected')
					}
				}
						
			}
			
			var connectionObject = YAHOO.util.Connect.asyncRequest('GET', 'index.php?entryPoint=callHangup&number='+number, callback);
		 }



    
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

    {/literal}
</script>
<div class="clear"></div>
<form action="index.php" method="POST" name="{$form_name}" id="{$form_id}" {$enctype}>
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="dcQuickEdit">
<tr>
<td class="buttons">
<input type="hidden" name="module" value="{$module}">
{if isset($smarty.request.isDuplicate) && $smarty.request.isDuplicate eq "true"}
<input type="hidden" name="record" value="">
<input type="hidden" name="duplicateSave" value="true">
<input type="hidden" name="duplicateId" value="{$fields.id.value}">
{else}
<input type="hidden" name="record" value="{$fields.id.value}">
{/if}
<input type="hidden" name="isDuplicate" value="false">
<input type="hidden" name="action">
<input type="hidden" name="return_module" value="{$smarty.request.return_module}">
<input type="hidden" name="return_action" value="{$smarty.request.return_action}">
<input type="hidden" name="return_id" value="{$smarty.request.return_id}">
<input type="hidden" name="module_tab"> 
<input type="hidden" name="contact_role">
{if !empty($smarty.request.return_module) || !empty($smarty.request.relate_to)}
<input type="hidden" name="relate_to" value="{if $smarty.request.return_relationship}{$smarty.request.return_relationship}{elseif $smarty.request.relate_to && empty($smarty.request.from_dcmenu)}{$smarty.request.relate_to}{elseif empty($isDCForm) && empty($smarty.request.from_dcmenu)}{$smarty.request.return_module}{/if}">
<input type="hidden" name="relate_id" value="{$smarty.request.return_id}">
{/if}
<input type="hidden" name="offset" value="{$offset}">
{assign var='place' value="_HEADER"} <!-- to be used for id for buttons with custom code in def files-->
<?php if (isset ( $this->_tpl_vars['form']['hidden'] )): ?>
<?php $_from = $this->_tpl_vars['form']['hidden']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['field']):
?>
<?php echo $this->_tpl_vars['field']; ?>
   
<?php endforeach; endif; unset($_from); ?>
<?php endif; ?>
<?php if (empty ( $this->_tpl_vars['form']['button_location'] ) || $this->_tpl_vars['form']['button_location'] == 'top'): ?>
<?php if (! empty ( $this->_tpl_vars['form'] ) && ! empty ( $this->_tpl_vars['form']['buttons'] )): ?>
   <?php $_from = $this->_tpl_vars['form']['buttons']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val'] => $this->_tpl_vars['button']):
?>
      <?php echo smarty_function_sugar_button(array('module' => ($this->_tpl_vars['module']),'id' => ($this->_tpl_vars['button']),'form_id' => ($this->_tpl_vars['form_id']),'view' => ($this->_tpl_vars['view']),'appendTo' => 'header_buttons','location' => 'HEADER'), $this);?>

   <?php endforeach; endif; unset($_from); ?>
<?php else: ?>
<?php echo smarty_function_sugar_button(array('module' => ($this->_tpl_vars['module']),'id' => 'SAVE','view' => ($this->_tpl_vars['view']),'form_id' => ($this->_tpl_vars['form_id']),'location' => 'HEADER','appendTo' => 'header_buttons'), $this);?>

<?php echo smarty_function_sugar_button(array('module' => ($this->_tpl_vars['module']),'id' => 'CANCEL','view' => ($this->_tpl_vars['view']),'form_id' => ($this->_tpl_vars['form_id']),'location' => 'HEADER','appendTo' => 'header_buttons'), $this);?>

<?php endif; ?>
<?php if (empty ( $this->_tpl_vars['form']['hideAudit'] ) || ! $this->_tpl_vars['form']['hideAudit']): ?>
<?php echo smarty_function_sugar_button(array('module' => ($this->_tpl_vars['module']),'id' => 'Audit','view' => ($this->_tpl_vars['view']),'form_id' => ($this->_tpl_vars['form_id']),'appendTo' => 'header_buttons'), $this);?>

<?php endif; ?>
<?php endif; ?>
<?php echo smarty_function_sugar_action_menu(array('buttons' => $this->_tpl_vars['header_buttons'],'class' => 'fancymenu','flat' => true), $this);?>

</td>
<td align='right'><?php echo $this->_tpl_vars['ADMIN_EDIT']; ?>

<?php if ($this->_tpl_vars['panelCount'] == 0): ?>
    	<?php if ($this->_tpl_vars['SHOW_VCR_CONTROL']): ?>
		{$PAGINATION}
	<?php endif; ?>
<?php endif; ?>
</td>
</tr>
{if $from_pusher ==1}
<tr>
	<td>
		<table border='1' cellpadding='0' cellspacing='0' width='100%'>
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
						 <tr><td></td>
						 <td> <input type="hidden" name="disposition_id" id="disposition_id" value="{$disposition_id}">
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
							<input autocomplete="off" type="text" name="date_of_callback_date_d" id="date_of_callback_date_d" value="" size="11" maxlength="10" title="" tabindex="0" onblur="combo_date_of_callback.update();" onchange="combo_date_of_callback.update(); " style="display: inline;"><img src="themes/SuiteR/images/jscalendar.gif?v=wUfeT5IQUbwii78MflriMw" alt="Enter Date" style="position: relative; top: -2px; display: inline;" border="0" id="date_of_callback_trigger_d">&nbsp;&nbsp;<br>
							<select class="datetimecombo_time" size="1"  name="date_of_callback_hours_d" id="date_of_callback_hours_d" tabindex="0">
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
							<select class="datetimecombo_time" size="1" id="date_of_callback_minutes_d"  name="date_of_callback_minutes_d" tabindex="0">
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
							<input autocomplete="off" type="text" name="date_of_followup_date_d" id="date_of_followup_date_d" value="" size="11" maxlength="10" title="" tabindex="0" onblur="combo_date_of_followup.update();" onchange="combo_date_of_followup.update(); " style="display: inline;"><img src="themes/SuiteR/images/jscalendar.gif?v=wUfeT5IQUbwii78MflriMw" alt="Enter Date" style="position: relative; top: 6px; display: inline;" border="0" id="date_of_followup_trigger_d">&nbsp;&nbsp;<br>
							<select class="datetimecombo_time" size="1" name="date_of_followup_hours_d" id="date_of_followup_hours_d" tabindex="0" >
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
							<select class="datetimecombo_time" size="1"  name="date_of_followup_minutes_d" id="date_of_followup_minutes_d" tabindex="0">
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
							<input autocomplete="off" type="text" name="date_of_prospect_date_d" id="date_of_prospect_date_d" value="" size="11" maxlength="10" title="" tabindex="0" onblur="combo_date_of_prospect.update();" onchange="combo_date_of_prospect.update(); " style="display: inline;"><img src="themes/SuiteR/images/jscalendar.gif?v=wUfeT5IQUbwii78MflriMw" alt="Enter Date" style="position: relative; top: 6px; display: inline;" border="0" id="date_of_prospect_trigger_d">&nbsp;&nbsp;<br>
							<select class="datetimecombo_time" size="1" name="date_of_prospect_hours_d" id="date_of_prospect_hours_d" tabindex="0" style="display: inline;">
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
							<select class="datetimecombo_time" size="1" id="date_of_prospect_minutes_d" name="date_of_prospect_minutes_d" tabindex="0" style="display: inline;">

								<option></option>
								<option value="00">00</option>
								<option value="15">15</option>
								<option value="30">30</option>
								<option value="45">45</option>
								</select>
							</span></td> 
						  </tr>
						  <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
	<tr>
		
		<td> <button type="button" id ="hangup" onclick="callHangupPusher()">Hangup</button></td>
		<td><button type="button" id ="hold" onclick="callHoldPusher('hold')">Hold</button>
		<button type="button" style="display: none" id ="unhold" onclick="callHoldPusher('unhold')">Un Hold</button></td>
		
  </tr>
  <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
		</table>	
		</td>
	</tr>
{/if}	
	
	
</table>