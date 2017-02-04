

<script>
    {literal}
    $(document).ready(function(){
	    $("ul.clickMenu").each(function(index, node){
	        $(node).sugarActionMenu();
	    });
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
{if (!empty($smarty.request.return_module) || !empty($smarty.request.relate_to)) && !(isset($smarty.request.isDuplicate) && $smarty.request.isDuplicate eq "true")}
<input type="hidden" name="relate_to" value="{if $smarty.request.return_relationship}{$smarty.request.return_relationship}{elseif $smarty.request.relate_to && empty($smarty.request.from_dcmenu)}{$smarty.request.relate_to}{elseif empty($isDCForm) && empty($smarty.request.from_dcmenu)}{$smarty.request.return_module}{/if}">
<input type="hidden" name="relate_id" value="{$smarty.request.return_id}">
{/if}
<input type="hidden" name="offset" value="{$offset}">
{assign var='place' value="_HEADER"} <!-- to be used for id for buttons with custom code in def files-->
<div class="action_buttons">{if $bean->aclAccess("save")}<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="button primary" onclick="var _form = document.getElementById('EditView'); {if $isDuplicate}_form.return_id.value=''; {/if}_form.action.value='Save'; if(check_form('EditView'))SUGAR.ajaxUI.submitForm(_form);return false;" type="submit" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}" id="SAVE_HEADER">{/if}  {if !empty($smarty.request.return_action) && ($smarty.request.return_action == "DetailView" && !empty($smarty.request.return_id))}<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="SUGAR.ajaxUI.loadContent('index.php?action=DetailView&module={$smarty.request.return_module|escape:"url"}&record={$smarty.request.return_id|escape:"url"}'); return false;" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" type="button" id="CANCEL_HEADER"> {elseif !empty($smarty.request.return_action) && ($smarty.request.return_action == "DetailView" && !empty($fields.id.value))}<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="SUGAR.ajaxUI.loadContent('index.php?action=DetailView&module={$smarty.request.return_module|escape:"url"}&record={$fields.id.value}'); return false;" type="button" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" id="CANCEL_HEADER"> {elseif !empty($smarty.request.return_action) && ($smarty.request.return_action == "DetailView" && empty($fields.id.value)) && empty($smarty.request.return_id)}<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="SUGAR.ajaxUI.loadContent('index.php?action=ListView&module={$smarty.request.return_module|escape:"url"}&record={$fields.id.value}'); return false;" type="button" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" id="CANCEL_HEADER"> {elseif !empty($smarty.request.return_action) && !empty($smarty.request.return_module)}<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="SUGAR.ajaxUI.loadContent('index.php?action={$smarty.request.return_action}&module={$smarty.request.return_module|escape:"url"}'); return false;" type="button" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" id="CANCEL_HEADER"> {elseif empty($smarty.request.return_action) || empty($smarty.request.return_id) && !empty($fields.id.value)}<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="SUGAR.ajaxUI.loadContent('index.php?action=index&module=te_drip_campaign'); return false;" type="button" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" id="CANCEL_HEADER"> {else}<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="SUGAR.ajaxUI.loadContent('index.php?action=index&module={$smarty.request.return_module|escape:"url"}&record={$smarty.request.return_id|escape:"url"}'); return false;" type="button" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" id="CANCEL_HEADER"> {/if} {if $bean->aclAccess("detail")}{if !empty($fields.id.value) && $isAuditEnabled}<input id="btn_view_change_log" title="{$APP.LNK_VIEW_CHANGE_LOG}" class="button" onclick='open_popup("Audit", "600", "400", "&record={$fields.id.value}&module_name=te_drip_campaign", true, false,  {ldelim} "call_back_function":"set_return","form_name":"EditView","field_to_name_array":[] {rdelim} ); return false;' type="button" value="{$APP.LNK_VIEW_CHANGE_LOG}">{/if}{/if}<div class="clear"></div></div>
</td>
<td align='right'>
{$PAGINATION}
</td>
</tr>
</table>{sugar_include include=$includes}
<span id='tabcounterJS'><script>SUGAR.TabFields=new Array();//this will be used to track tabindexes for references</script></span>
<div id="EditView_tabs"
>
<div >
<div id="detailpanel_1" >
{counter name="panelFieldCount" start=0 print=false assign="panelFieldCount"}
<table width="100%" border="0" cellspacing="1" cellpadding="0"  id='Default_{$module}_Subpanel'  class="yui3-skin-sam edit view panelContainer">
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{capture name="tr" assign="tableRow"}
<tr>
<td valign="top" id='name_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_NAME' module='te_drip_campaign'}{/capture}
{$label|strip_semicolon}:
<span class="required">*</span>
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' >
{counter name="panelFieldCount"}

{if strlen($fields.name.value) <= 0}
{assign var="value" value=$fields.name.default_value }
{else}
{assign var="value" value=$fields.name.value }
{/if}  
<input type='text' name='{$fields.name.name}' 
id='{$fields.name.name}' size='30' 
maxlength='255' 
value='{$value}' title=''      accesskey='7'  >
<td valign="top" id='batch_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_BATCH' module='te_drip_campaign'}{/capture}
{$label|strip_semicolon}:
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' >
{counter name="panelFieldCount"}

<input type="text" name="{$fields.batch.name}" class="sqsEnabled" tabindex="0" id="{$fields.batch.name}" size="" value="{$fields.batch.value}" title='' autocomplete="off"  	 >
<input type="hidden" name="{$fields.batch.id_name}" 
id="{$fields.batch.id_name}" 
value="{$fields.te_ba_batch_id_c.value}">
<span class="id-ff multiple">
<button type="button" name="btn_{$fields.batch.name}" id="btn_{$fields.batch.name}" tabindex="0" title="{sugar_translate label="LBL_SELECT_BUTTON_TITLE"}" class="button firstChild" value="{sugar_translate label="LBL_SELECT_BUTTON_LABEL"}"
onclick='open_popup(
"{$fields.batch.module}", 
600, 
400, 
"", 
true, 
false, 
{literal}{"call_back_function":"set_return","form_name":"EditView","field_to_name_array":{"id":"te_ba_batch_id_c","name":"batch"}}{/literal}, 
"single", 
true
);' ><img src="{sugar_getimagepath file="id-ff-select.png"}"></button><button type="button" name="btn_clr_{$fields.batch.name}" id="btn_clr_{$fields.batch.name}" tabindex="0" title="{sugar_translate label="LBL_ACCESSKEY_CLEAR_RELATE_TITLE"}"  class="button lastChild"
onclick="SUGAR.clearRelateField(this.form, '{$fields.batch.name}', '{$fields.batch.id_name}');"  value="{sugar_translate label="LBL_ACCESSKEY_CLEAR_RELATE_LABEL"}" ><img src="{sugar_getimagepath file="id-ff-clear.png"}"></button>
</span>
<script type="text/javascript">
SUGAR.util.doWhen(
		"typeof(sqs_objects) != 'undefined' && typeof(sqs_objects['{$form_name}_{$fields.batch.name}']) != 'undefined'",
		enableQS
);
</script>
</tr>
{/capture}
{if $fieldsUsed > 0 }
{$tableRow}
{/if}
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{capture name="tr" assign="tableRow"}
<tr>
<td valign="top" id='total_mailers_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_TOTAL_MAILERS' module='te_drip_campaign'}{/capture}
{$label|strip_semicolon}:
<span class="required">*</span>
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' >
{counter name="panelFieldCount"}

{if strlen($fields.total_mailers.value) <= 0}
{assign var="value" value=$fields.total_mailers.default_value }
{else}
{assign var="value" value=$fields.total_mailers.value }
{/if}  
<input type='text' name='{$fields.total_mailers.name}' 
id='{$fields.total_mailers.name}' size='30' maxlength='11' value='{sugar_number_format precision=0 var=$value}' title='' tabindex='0'    >
<td valign="top" id='_label' width='12.5%' scope="col">
&nbsp;
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' >
</tr>
{/capture}
{if $fieldsUsed > 0 }
{$tableRow}
{/if}
</table>
</div>
{if $panelFieldCount == 0}
<script>document.getElementById("DEFAULT").style.display='none';</script>
{/if}
</div></div>
<div class="panel panel-default">
<div class="panel-heading ">		
<div class="col-xs-10 col-sm-11 col-md-11" style="padding-left:5px;">
<strong>Mailer Details</strong>
</div>	
</div>	
</div>
{literal}
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#total_mailers').blur(function (){
		 var total_mailers = $("#total_mailers").val();
		hideRows();
		addMoreRows(total_mailers);
	});
	
	function hideRows() {
		for(rowCount=1;rowCount<=10;rowCount++){
			document.getElementById("row"+rowCount).style.display="none";
		}		
	}
	function addMoreRows(rows) {
		for(rowCount=1;rowCount<=rows;rowCount++){
			document.getElementById("row"+rowCount).style.display="";
		}		
	}
	
});
</script>
{/literal}
<table cellspacing="1" cellpadding="10" border="0" width="100%" class="yui3-skin-sam edit view panelContainer" id="Payment">

{if $drip_campain_list|@count > 0}
{assign var="count" value=1}
{foreach from=$drip_campain_list key=index item=campain_list}
<tr id="row{$count}">
<td style="padding-top:10px;">Day</td>
<td style="padding-top:10px;">
<input type="text" name="day_{$count}" value="{$campain_list.mailer_day}">
</td>
<td style="padding-top:10px;">Template</td>
<td>
<select name="template_{$count}">
<option value="">Select Template</option>
{foreach from=$templateList key=index item=template}
{if $campain_list.template_id eq $template.id}
<option value="{$template.id}" selected>{$template.name}</option>
{else}
<option value="{$template.id}">{$template.name}</option>
{/if}
{/foreach}
</select>
</td>		
</tr>
{assign var='count' value=$count+1}
{/foreach}
{else}
<tr id="row1" style="display:none" >
<td>Day</td>
<td><input name="day_1" id="day_1" type="text"  value="" size="17%"/></td>
<td >Template</td>
<td style="padding-top:-10px;">
<select name="template_1">
<option value="">Select Template</option>
{foreach from=$templateList key=index item=template}
<option value="{$template.id}">{$template.name}</option>
{/foreach}
</select>				
</td>				
</tr>
<tr id="row2" style="display:none">
<td>Day</td>
<td><input name="day_2" id="day_2" type="text"  value="" size="17%"/></td>
<td>Template</td>
<td>
<select name="template_2">
<option value="">Select Template</option>
{foreach from=$templateList key=index item=template}
<option value="{$template.id}">{$template.name}</option>
{/foreach}
</select>				
</td>	
</tr>
<tr id="row3" style="display:none">
<td style="padding-top:10px;">Day</td>
<td style="padding-top:10px;"><input name="day_3" id="day_3" type="text"  value="" size="17%"/></td>
<td style="padding-top:10px;">Template</td>
<td style="padding-top:10px;">
<select name="template_3">
<option value="">Select Template</option>
{foreach from=$templateList key=index item=template}
<option value="{$template.id}">{$template.name}</option>
{/foreach}
</select>				
</td>	
</tr>
<tr id="row4" style="display:none">
<td style="padding-top:10px;">Day</td>
<td style="padding-top:10px;"><input name="day_4" id="day_4" type="text"  value="" size="17%"/></td>
<td style="padding-top:10px;">Template</td>
<td style="padding-top:10px;">
<select name="template_4">
<option value="">Select Template</option>
{foreach from=$templateList key=index item=template}
<option value="{$template.id}">{$template.name}</option>
{/foreach}
</select>				
</td>	
</tr>
<tr id="row5" style="display:none">
<td style="padding-top:10px;">Day</td>
<td style="padding-top:10px;"><input name="day_5" id="day_5" type="text"  value="" size="17%"/></td>
<td style="padding-top:10px;">Template</td>
<td style="padding-top:10px;">
<select name="template_5">
<option value="">Select Template</option>
{foreach from=$templateList key=index item=template}
<option value="{$template.id}">{$template.name}</option>
{/foreach}
</select>				
</td>	
</tr>
<tr id="row6" style="display:none">
<td style="padding-top:10px;">Day</td>
<td style="padding-top:10px;"><input name="day_6" id="day_6" type="text"  value="" size="17%"/></td>
<td style="padding-top:10px;">Template</td>
<td style="padding-top:10px;">
<select name="template_6">
<option value="">Select Template</option>
{foreach from=$templateList key=index item=template}
<option value="{$template.id}">{$template.name}</option>
{/foreach}
</select>				
</td>	
</tr>
<tr id="row7" style="display:none">
<td style="padding-top:10px;">Day</td>
<td style="padding-top:10px;"><input name="day_7" id="day_7" type="text"  value="" size="17%"/></td>
<td style="padding-top:10px;">Template</td>
<td style="padding-top:10px;">
<select name="template_7">
<option value="">Select Template</option>
{foreach from=$templateList key=index item=template}
<option value="{$template.id}">{$template.name}</option>
{/foreach}
</select>				
</td>	
</tr>
<tr id="row8" style="display:none">
<td style="padding-top:10px;">Day</td>
<td style="padding-top:10px;"><input name="day_8" id="day_8" type="text"  value="" size="17%"/></td>
<td style="padding-top:10px;">Template</td>
<td style="padding-top:10px;">
<select name="template_8">
<option value="">Select Template</option>
{foreach from=$templateList key=index item=template}
<option value="{$template.id}">{$template.name}</option>
{/foreach}
</select>				
</td>	
</tr>
<tr id="row9" style="display:none">
<td style="padding-top:10px;">Day</td>
<td style="padding-top:10px;"><input name="day_9" id="day_9" type="text"  value="" size="17%"/></td>
<td style="padding-top:10px;">Template</td>
<td style="padding-top:10px;">
<select name="template_9">
<option value="">Select Template</option>
{foreach from=$templateList key=index item=template}
<option value="{$template.id}">{$template.name}</option>
{/foreach}
</select>				
</td>	
</tr>
<tr id="row10" style="display:none">
<td style="padding-top:10px;">Day</td>
<td style="padding-top:10px;"><input name="day_10" id="day_10" type="text"  value="" size="17%"/></td>
<td style="padding-top:10px;">Template</td>
<td style="padding-top:10px;">
<select name="template_10">
<option value="">Select Template</option>
{foreach from=$templateList key=index item=template}
<option value="{$template.id}">{$template.name}</option>
{/foreach}
</select>				
</td>	
</tr>			
{/if}
</table>		
<div id="addedRows"></div>

<script language="javascript">
    var _form_id = '{$form_id}';
    {literal}
    SUGAR.util.doWhen(function(){
        _form_id = (_form_id == '') ? 'EditView' : _form_id;
        return document.getElementById(_form_id) != null;
    }, SUGAR.themes.actionMenu);
    {/literal}
</script>
{assign var='place' value="_FOOTER"} <!-- to be used for id for buttons with custom code in def files-->
<div class="buttons">
<div class="action_buttons">{if $bean->aclAccess("save")}<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="button primary" onclick="var _form = document.getElementById('EditView'); {if $isDuplicate}_form.return_id.value=''; {/if}_form.action.value='Save'; if(check_form('EditView'))SUGAR.ajaxUI.submitForm(_form);return false;" type="submit" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}" id="SAVE_FOOTER">{/if}  {if !empty($smarty.request.return_action) && ($smarty.request.return_action == "DetailView" && !empty($smarty.request.return_id))}<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="SUGAR.ajaxUI.loadContent('index.php?action=DetailView&module={$smarty.request.return_module|escape:"url"}&record={$smarty.request.return_id|escape:"url"}'); return false;" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" type="button" id="CANCEL_FOOTER"> {elseif !empty($smarty.request.return_action) && ($smarty.request.return_action == "DetailView" && !empty($fields.id.value))}<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="SUGAR.ajaxUI.loadContent('index.php?action=DetailView&module={$smarty.request.return_module|escape:"url"}&record={$fields.id.value}'); return false;" type="button" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" id="CANCEL_FOOTER"> {elseif !empty($smarty.request.return_action) && ($smarty.request.return_action == "DetailView" && empty($fields.id.value)) && empty($smarty.request.return_id)}<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="SUGAR.ajaxUI.loadContent('index.php?action=ListView&module={$smarty.request.return_module|escape:"url"}&record={$fields.id.value}'); return false;" type="button" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" id="CANCEL_FOOTER"> {elseif !empty($smarty.request.return_action) && !empty($smarty.request.return_module)}<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="SUGAR.ajaxUI.loadContent('index.php?action={$smarty.request.return_action}&module={$smarty.request.return_module|escape:"url"}'); return false;" type="button" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" id="CANCEL_FOOTER"> {elseif empty($smarty.request.return_action) || empty($smarty.request.return_id) && !empty($fields.id.value)}<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="SUGAR.ajaxUI.loadContent('index.php?action=index&module=te_drip_campaign'); return false;" type="button" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" id="CANCEL_FOOTER"> {else}<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="SUGAR.ajaxUI.loadContent('index.php?action=index&module={$smarty.request.return_module|escape:"url"}&record={$smarty.request.return_id|escape:"url"}'); return false;" type="button" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" id="CANCEL_FOOTER"> {/if} {if $bean->aclAccess("detail")}{if !empty($fields.id.value) && $isAuditEnabled}<input id="btn_view_change_log" title="{$APP.LNK_VIEW_CHANGE_LOG}" class="button" onclick='open_popup("Audit", "600", "400", "&record={$fields.id.value}&module_name=te_drip_campaign", true, false,  {ldelim} "call_back_function":"set_return","form_name":"EditView","field_to_name_array":[] {rdelim} ); return false;' type="button" value="{$APP.LNK_VIEW_CHANGE_LOG}">{/if}{/if}<div class="clear"></div></div>
</div>
</form>
{$set_focus_block}
<script>SUGAR.util.doWhen("document.getElementById('EditView') != null",
        function(){ldelim}SUGAR.util.buildAccessKeyLabels();{rdelim});
</script><script type="text/javascript">
YAHOO.util.Event.onContentReady("EditView",
    function () {ldelim} initEditView(document.forms.EditView) {rdelim});
//window.setTimeout(, 100);
window.onbeforeunload = function () {ldelim} return onUnloadEditView(); {rdelim};
// bug 55468 -- IE is too aggressive with onUnload event
if ($.browser.msie) {ldelim}
$(document).ready(function() {ldelim}
    $(".collapseLink,.expandLink").click(function (e) {ldelim} e.preventDefault(); {rdelim});
  {rdelim});
{rdelim}
</script>{literal}
<script type="text/javascript">
addForm('EditView');addToValidate('EditView', 'name', 'name', true,'{/literal}{sugar_translate label='LBL_NAME' module='te_drip_campaign' for_js=true}{literal}' );
addToValidate('EditView', 'date_entered_date', 'date', false,'Date Created' );
addToValidate('EditView', 'date_modified_date', 'date', false,'Date Modified' );
addToValidate('EditView', 'modified_user_id', 'assigned_user_name', false,'{/literal}{sugar_translate label='LBL_MODIFIED' module='te_drip_campaign' for_js=true}{literal}' );
addToValidate('EditView', 'modified_by_name', 'relate', false,'{/literal}{sugar_translate label='LBL_MODIFIED_NAME' module='te_drip_campaign' for_js=true}{literal}' );
addToValidate('EditView', 'created_by', 'assigned_user_name', false,'{/literal}{sugar_translate label='LBL_CREATED' module='te_drip_campaign' for_js=true}{literal}' );
addToValidate('EditView', 'created_by_name', 'relate', false,'{/literal}{sugar_translate label='LBL_CREATED' module='te_drip_campaign' for_js=true}{literal}' );
addToValidate('EditView', 'description', 'text', false,'{/literal}{sugar_translate label='LBL_DESCRIPTION' module='te_drip_campaign' for_js=true}{literal}' );
addToValidate('EditView', 'deleted', 'bool', false,'{/literal}{sugar_translate label='LBL_DELETED' module='te_drip_campaign' for_js=true}{literal}' );
addToValidate('EditView', 'assigned_user_id', 'relate', false,'{/literal}{sugar_translate label='LBL_ASSIGNED_TO_ID' module='te_drip_campaign' for_js=true}{literal}' );
addToValidate('EditView', 'assigned_user_name', 'relate', false,'{/literal}{sugar_translate label='LBL_ASSIGNED_TO_NAME' module='te_drip_campaign' for_js=true}{literal}' );
addToValidate('EditView', 'te_in_institutes_id_c', 'id', false,'{/literal}{sugar_translate label='LBL_INSTITUE_TE_IN_INSTITUTES_ID' module='te_drip_campaign' for_js=true}{literal}' );
addToValidate('EditView', 'institue', 'relate', true,'{/literal}{sugar_translate label='LBL_INSTITUE' module='te_drip_campaign' for_js=true}{literal}' );
addToValidate('EditView', 'te_pr_programs_id_c', 'id', false,'{/literal}{sugar_translate label='LBL_PROGRAM_TE_PR_PROGRAMS_ID' module='te_drip_campaign' for_js=true}{literal}' );
addToValidate('EditView', 'program', 'relate', false,'{/literal}{sugar_translate label='LBL_PROGRAM' module='te_drip_campaign' for_js=true}{literal}' );
addToValidate('EditView', 'te_ba_batch_id_c', 'id', false,'{/literal}{sugar_translate label='LBL_BATCH_TE_BA_BATCH_ID' module='te_drip_campaign' for_js=true}{literal}' );
addToValidate('EditView', 'batch', 'relate', false,'{/literal}{sugar_translate label='LBL_BATCH' module='te_drip_campaign' for_js=true}{literal}' );
addToValidate('EditView', 'total_mailers', 'int', true,'{/literal}{sugar_translate label='LBL_TOTAL_MAILERS' module='te_drip_campaign' for_js=true}{literal}' );
addToValidateBinaryDependency('EditView', 'assigned_user_name', 'alpha', false,'{/literal}{sugar_translate label='ERR_SQS_NO_MATCH_FIELD' module='te_drip_campaign' for_js=true}{literal}: {/literal}{sugar_translate label='LBL_ASSIGNED_TO' module='te_drip_campaign' for_js=true}{literal}', 'assigned_user_id' );
addToValidateBinaryDependency('EditView', 'batch', 'alpha', false,'{/literal}{sugar_translate label='ERR_SQS_NO_MATCH_FIELD' module='te_drip_campaign' for_js=true}{literal}: {/literal}{sugar_translate label='LBL_BATCH' module='te_drip_campaign' for_js=true}{literal}', 'te_ba_batch_id_c' );
</script><script language="javascript">if(typeof sqs_objects == 'undefined'){var sqs_objects = new Array;}sqs_objects['EditView_batch']={"form":"EditView","method":"query","modules":["te_ba_Batch"],"group":"or","field_list":["name","id"],"populate_list":["batch","te_ba_batch_id_c"],"required_list":["parent_id"],"conditions":[{"name":"name","op":"like_custom","end":"%","value":""}],"order":"name","limit":"30","no_match_text":"No Match"};</script>{/literal}
