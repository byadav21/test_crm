

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
<div class="action_buttons">{if $bean->aclAccess("save")}<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="button primary" onclick="var _form = document.getElementById('EditView'); {if $isDuplicate}_form.return_id.value=''; {/if}_form.action.value='Save'; if(check_form('EditView'))SUGAR.ajaxUI.submitForm(_form);return false;" type="submit" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}" id="SAVE_HEADER">{/if}  {if !empty($smarty.request.return_action) && ($smarty.request.return_action == "DetailView" && !empty($smarty.request.return_id))}<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="SUGAR.ajaxUI.loadContent('index.php?action=DetailView&module={$smarty.request.return_module|escape:"url"}&record={$smarty.request.return_id|escape:"url"}'); return false;" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" type="button" id="CANCEL_HEADER"> {elseif !empty($smarty.request.return_action) && ($smarty.request.return_action == "DetailView" && !empty($fields.id.value))}<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="SUGAR.ajaxUI.loadContent('index.php?action=DetailView&module={$smarty.request.return_module|escape:"url"}&record={$fields.id.value}'); return false;" type="button" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" id="CANCEL_HEADER"> {elseif !empty($smarty.request.return_action) && ($smarty.request.return_action == "DetailView" && empty($fields.id.value)) && empty($smarty.request.return_id)}<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="SUGAR.ajaxUI.loadContent('index.php?action=ListView&module={$smarty.request.return_module|escape:"url"}&record={$fields.id.value}'); return false;" type="button" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" id="CANCEL_HEADER"> {elseif !empty($smarty.request.return_action) && !empty($smarty.request.return_module)}<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="SUGAR.ajaxUI.loadContent('index.php?action={$smarty.request.return_action}&module={$smarty.request.return_module|escape:"url"}'); return false;" type="button" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" id="CANCEL_HEADER"> {elseif empty($smarty.request.return_action) || empty($smarty.request.return_id) && !empty($fields.id.value)}<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="SUGAR.ajaxUI.loadContent('index.php?action=index&module=te_budgeted_campaign'); return false;" type="button" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" id="CANCEL_HEADER"> {else}<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="SUGAR.ajaxUI.loadContent('index.php?action=index&module={$smarty.request.return_module|escape:"url"}&record={$smarty.request.return_id|escape:"url"}'); return false;" type="button" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" id="CANCEL_HEADER"> {/if} {if $bean->aclAccess("detail")}{if !empty($fields.id.value) && $isAuditEnabled}<input id="btn_view_change_log" title="{$APP.LNK_VIEW_CHANGE_LOG}" class="button" onclick='open_popup("Audit", "600", "400", "&record={$fields.id.value}&module_name=te_budgeted_campaign", true, false,  {ldelim} "call_back_function":"set_return","form_name":"EditView","field_to_name_array":[] {rdelim} ); return false;' type="button" value="{$APP.LNK_VIEW_CHANGE_LOG}">{/if}{/if}<div class="clear"></div></div>
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
<td valign="top" id='campaign_date_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_CAMPAIGN_DATE' module='te_budgeted_campaign'}{/capture}
{$label|strip_semicolon}:
<span class="required">*</span>
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' >
{counter name="panelFieldCount"}

<span class="dateTime">
{assign var=date_value value=$fields.campaign_date.value }
<input class="date_input" autocomplete="off" type="text" name="{$fields.campaign_date.name}" id="{$fields.campaign_date.name}" value="{$date_value}" title=''  tabindex='0'  accesskey='7'    size="11" maxlength="10" >
{capture assign="other_attributes"}alt="{$APP.LBL_ENTER_DATE}" style="position:relative; top:6px" border="0" id="{$fields.campaign_date.name}_trigger"{/capture}
{sugar_getimage name="jscalendar" ext=".gif" other_attributes="$other_attributes"}
</span>
<script type="text/javascript">
Calendar.setup ({ldelim}
inputField : "{$fields.campaign_date.name}",
form : "EditView",
ifFormat : "{$CALENDAR_FORMAT}",
daFormat : "{$CALENDAR_FORMAT}",
button : "{$fields.campaign_date.name}_trigger",
singleClick : true,
dateStr : "{$date_value}",
startWeekday: {$CALENDAR_FDOW|default:'0'},
step : 1,
weekNumbers:false
{rdelim}
);
</script>
<td valign="top" id='te_utm_te_budgeted_campaign_1_name_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_TE_UTM_TE_BUDGETED_CAMPAIGN_1_FROM_TE_UTM_TITLE' module='te_budgeted_campaign'}{/capture}
{$label|strip_semicolon}:
<span class="required">*</span>
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' >
{counter name="panelFieldCount"}

<input type="text" name="{$fields.te_utm_te_budgeted_campaign_1_name.name}" class="sqsEnabled" tabindex="0" id="{$fields.te_utm_te_budgeted_campaign_1_name.name}" size="" value="{$fields.te_utm_te_budgeted_campaign_1_name.value}" title='' autocomplete="off"  	 >
<input type="hidden" name="{$fields.te_utm_te_budgeted_campaign_1_name.id_name}" 
id="{$fields.te_utm_te_budgeted_campaign_1_name.id_name}" 
value="{$fields.te_utm_te_budgeted_campaign_1te_utm_ida.value}">
<span class="id-ff multiple">
<button type="button" name="btn_{$fields.te_utm_te_budgeted_campaign_1_name.name}" id="btn_{$fields.te_utm_te_budgeted_campaign_1_name.name}" tabindex="0" title="{sugar_translate label="LBL_SELECT_BUTTON_TITLE"}" class="button firstChild" value="{sugar_translate label="LBL_SELECT_BUTTON_LABEL"}"
onclick='open_popup(
"{$fields.te_utm_te_budgeted_campaign_1_name.module}", 
600, 
400, 
"", 
true, 
false, 
{literal}{"call_back_function":"set_return","form_name":"EditView","field_to_name_array":{"id":"te_utm_te_budgeted_campaign_1te_utm_ida","name":"te_utm_te_budgeted_campaign_1_name"}}{/literal}, 
"single", 
true
);' ><img src="{sugar_getimagepath file="id-ff-select.png"}"></button><button type="button" name="btn_clr_{$fields.te_utm_te_budgeted_campaign_1_name.name}" id="btn_clr_{$fields.te_utm_te_budgeted_campaign_1_name.name}" tabindex="0" title="{sugar_translate label="LBL_ACCESSKEY_CLEAR_RELATE_TITLE"}"  class="button lastChild"
onclick="SUGAR.clearRelateField(this.form, '{$fields.te_utm_te_budgeted_campaign_1_name.name}', '{$fields.te_utm_te_budgeted_campaign_1_name.id_name}');"  value="{sugar_translate label="LBL_ACCESSKEY_CLEAR_RELATE_LABEL"}" ><img src="{sugar_getimagepath file="id-ff-clear.png"}"></button>
</span>
<script type="text/javascript">
SUGAR.util.doWhen(
		"typeof(sqs_objects) != 'undefined' && typeof(sqs_objects['{$form_name}_{$fields.te_utm_te_budgeted_campaign_1_name.name}']) != 'undefined'",
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
<td valign="top" id='volume_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_VOLUME' module='te_budgeted_campaign'}{/capture}
{$label|strip_semicolon}:
<span class="required">*</span>
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' >
{counter name="panelFieldCount"}

{if strlen($fields.volume.value) <= 0}
{assign var="value" value=$fields.volume.default_value }
{else}
{assign var="value" value=$fields.volume.value }
{/if}  
<input type='text' name='{$fields.volume.name}' 
id='{$fields.volume.name}' size='30' maxlength='255' value='{sugar_number_format precision=0 var=$value}' title='' tabindex='0'    >
<td valign="top" id='cost_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_COST' module='te_budgeted_campaign'}{/capture}
{$label|strip_semicolon}:
<span class="required">*</span>
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' >
{counter name="panelFieldCount"}

{if strlen($fields.cost.value) <= 0}
{assign var="value" value=$fields.cost.default_value }
{else}
{assign var="value" value=$fields.cost.value }
{/if}  
<input type='text' name='{$fields.cost.name}' 
id='{$fields.cost.name}' size='30' maxlength='255' value='{sugar_number_format precision=0 var=$value}' title='' tabindex='0'    >
</tr>
{/capture}
{if $fieldsUsed > 0 }
{$tableRow}
{/if}
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{capture name="tr" assign="tableRow"}
<tr>
<td valign="top" id='conversion_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_CONVERSION' module='te_budgeted_campaign'}{/capture}
{$label|strip_semicolon}:
<span class="required">*</span>
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' >
{counter name="panelFieldCount"}

{if strlen($fields.conversion.value) <= 0}
{assign var="value" value=$fields.conversion.default_value }
{else}
{assign var="value" value=$fields.conversion.value }
{/if}  
<input type='text' name='{$fields.conversion.name}' 
id='{$fields.conversion.name}' size='30' maxlength='255' value='{sugar_number_format precision=0 var=$value}' title='' tabindex='0'    >
<td valign="top" id='conversion_rate_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_CONVERSION_RATE' module='te_budgeted_campaign'}{/capture}
{$label|strip_semicolon}:
<span class="required">*</span>
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' >
{counter name="panelFieldCount"}

{if strlen($fields.conversion_rate.value) <= 0}
{assign var="value" value=$fields.conversion_rate.default_value }
{else}
{assign var="value" value=$fields.conversion_rate.value }
{/if}  
<input type='text' name='{$fields.conversion_rate.name}' 
id='{$fields.conversion_rate.name}' size='30' 
maxlength='255' 
value='{$value}' title=''      >
</tr>
{/capture}
{if $fieldsUsed > 0 }
{$tableRow}
{/if}
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{capture name="tr" assign="tableRow"}
<tr>
<td valign="top" id='leads_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_LEADS' module='te_budgeted_campaign'}{/capture}
{$label|strip_semicolon}:
<span class="required">*</span>
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' >
{counter name="panelFieldCount"}

{if strlen($fields.leads.value) <= 0}
{assign var="value" value=$fields.leads.default_value }
{else}
{assign var="value" value=$fields.leads.value }
{/if}  
<input type='text' name='{$fields.leads.name}' 
id='{$fields.leads.name}' size='30' maxlength='255' value='{sugar_number_format precision=0 var=$value}' title='' tabindex='0'    >
<td valign="top" id='clp_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_CLP' module='te_budgeted_campaign'}{/capture}
{$label|strip_semicolon}:
<span class="required">*</span>
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' >
{counter name="panelFieldCount"}

{if strlen($fields.clp.value) <= 0}
{assign var="value" value=$fields.clp.default_value }
{else}
{assign var="value" value=$fields.clp.value }
{/if}  
<input type='text' name='{$fields.clp.name}' 
id='{$fields.clp.name}' size='30' 
maxlength='10' 
value='{$value}' title=''      >
</tr>
{/capture}
{if $fieldsUsed > 0 }
{$tableRow}
{/if}
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{capture name="tr" assign="tableRow"}
<tr>
<td valign="top" id='cpa_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_CPA' module='te_budgeted_campaign'}{/capture}
{$label|strip_semicolon}:
<span class="required">*</span>
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' >
{counter name="panelFieldCount"}

{if strlen($fields.cpa.value) <= 0}
{assign var="value" value=$fields.cpa.default_value }
{else}
{assign var="value" value=$fields.cpa.value }
{/if}  
<input type='text' name='{$fields.cpa.name}' 
id='{$fields.cpa.name}' size='30' 
maxlength='10' 
value='{$value}' title=''      >
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
<div class="action_buttons">{if $bean->aclAccess("save")}<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="button primary" onclick="var _form = document.getElementById('EditView'); {if $isDuplicate}_form.return_id.value=''; {/if}_form.action.value='Save'; if(check_form('EditView'))SUGAR.ajaxUI.submitForm(_form);return false;" type="submit" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}" id="SAVE_FOOTER">{/if}  {if !empty($smarty.request.return_action) && ($smarty.request.return_action == "DetailView" && !empty($smarty.request.return_id))}<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="SUGAR.ajaxUI.loadContent('index.php?action=DetailView&module={$smarty.request.return_module|escape:"url"}&record={$smarty.request.return_id|escape:"url"}'); return false;" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" type="button" id="CANCEL_FOOTER"> {elseif !empty($smarty.request.return_action) && ($smarty.request.return_action == "DetailView" && !empty($fields.id.value))}<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="SUGAR.ajaxUI.loadContent('index.php?action=DetailView&module={$smarty.request.return_module|escape:"url"}&record={$fields.id.value}'); return false;" type="button" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" id="CANCEL_FOOTER"> {elseif !empty($smarty.request.return_action) && ($smarty.request.return_action == "DetailView" && empty($fields.id.value)) && empty($smarty.request.return_id)}<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="SUGAR.ajaxUI.loadContent('index.php?action=ListView&module={$smarty.request.return_module|escape:"url"}&record={$fields.id.value}'); return false;" type="button" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" id="CANCEL_FOOTER"> {elseif !empty($smarty.request.return_action) && !empty($smarty.request.return_module)}<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="SUGAR.ajaxUI.loadContent('index.php?action={$smarty.request.return_action}&module={$smarty.request.return_module|escape:"url"}'); return false;" type="button" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" id="CANCEL_FOOTER"> {elseif empty($smarty.request.return_action) || empty($smarty.request.return_id) && !empty($fields.id.value)}<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="SUGAR.ajaxUI.loadContent('index.php?action=index&module=te_budgeted_campaign'); return false;" type="button" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" id="CANCEL_FOOTER"> {else}<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="SUGAR.ajaxUI.loadContent('index.php?action=index&module={$smarty.request.return_module|escape:"url"}&record={$smarty.request.return_id|escape:"url"}'); return false;" type="button" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" id="CANCEL_FOOTER"> {/if} {if $bean->aclAccess("detail")}{if !empty($fields.id.value) && $isAuditEnabled}<input id="btn_view_change_log" title="{$APP.LNK_VIEW_CHANGE_LOG}" class="button" onclick='open_popup("Audit", "600", "400", "&record={$fields.id.value}&module_name=te_budgeted_campaign", true, false,  {ldelim} "call_back_function":"set_return","form_name":"EditView","field_to_name_array":[] {rdelim} ); return false;' type="button" value="{$APP.LNK_VIEW_CHANGE_LOG}">{/if}{/if}<div class="clear"></div></div>
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
addForm('EditView');addToValidate('EditView', 'name', 'name', true,'{/literal}{sugar_translate label='LBL_NAME' module='te_budgeted_campaign' for_js=true}{literal}' );
addToValidate('EditView', 'date_entered_date', 'date', false,'Date Created' );
addToValidate('EditView', 'date_modified_date', 'date', false,'Date Modified' );
addToValidate('EditView', 'modified_user_id', 'assigned_user_name', false,'{/literal}{sugar_translate label='LBL_MODIFIED' module='te_budgeted_campaign' for_js=true}{literal}' );
addToValidate('EditView', 'modified_by_name', 'relate', false,'{/literal}{sugar_translate label='LBL_MODIFIED_NAME' module='te_budgeted_campaign' for_js=true}{literal}' );
addToValidate('EditView', 'created_by', 'assigned_user_name', false,'{/literal}{sugar_translate label='LBL_CREATED' module='te_budgeted_campaign' for_js=true}{literal}' );
addToValidate('EditView', 'created_by_name', 'relate', false,'{/literal}{sugar_translate label='LBL_CREATED' module='te_budgeted_campaign' for_js=true}{literal}' );
addToValidate('EditView', 'description', 'text', false,'{/literal}{sugar_translate label='LBL_DESCRIPTION' module='te_budgeted_campaign' for_js=true}{literal}' );
addToValidate('EditView', 'deleted', 'bool', false,'{/literal}{sugar_translate label='LBL_DELETED' module='te_budgeted_campaign' for_js=true}{literal}' );
addToValidate('EditView', 'assigned_user_id', 'relate', false,'{/literal}{sugar_translate label='LBL_ASSIGNED_TO_ID' module='te_budgeted_campaign' for_js=true}{literal}' );
addToValidate('EditView', 'assigned_user_name', 'relate', false,'{/literal}{sugar_translate label='LBL_ASSIGNED_TO_NAME' module='te_budgeted_campaign' for_js=true}{literal}' );
addToValidate('EditView', 'week', 'varchar', true,'{/literal}{sugar_translate label='LBL_WEEK' module='te_budgeted_campaign' for_js=true}{literal}' );
addToValidate('EditView', 'year', 'varchar', true,'{/literal}{sugar_translate label='LBL_YEAR' module='te_budgeted_campaign' for_js=true}{literal}' );
addToValidate('EditView', 'leads', 'int', true,'{/literal}{sugar_translate label='LBL_LEADS' module='te_budgeted_campaign' for_js=true}{literal}' );
addToValidate('EditView', 'conversion', 'int', true,'{/literal}{sugar_translate label='LBL_CONVERSION' module='te_budgeted_campaign' for_js=true}{literal}' );
addToValidate('EditView', 'conversion_rate', 'varchar', true,'{/literal}{sugar_translate label='LBL_CONVERSION_RATE' module='te_budgeted_campaign' for_js=true}{literal}' );
addToValidate('EditView', 'clp', 'varchar', true,'{/literal}{sugar_translate label='LBL_CLP' module='te_budgeted_campaign' for_js=true}{literal}' );
addToValidate('EditView', 'cpa', 'varchar', true,'{/literal}{sugar_translate label='LBL_CPA' module='te_budgeted_campaign' for_js=true}{literal}' );
addToValidate('EditView', 'volume', 'int', true,'{/literal}{sugar_translate label='LBL_VOLUME' module='te_budgeted_campaign' for_js=true}{literal}' );
addToValidate('EditView', 'cost', 'int', true,'{/literal}{sugar_translate label='LBL_COST' module='te_budgeted_campaign' for_js=true}{literal}' );
addToValidate('EditView', 'te_ba_batch_id_c', 'id', false,'{/literal}{sugar_translate label='LBL_BATCH_TE_BA_BATCH_ID' module='te_budgeted_campaign' for_js=true}{literal}' );
addToValidate('EditView', 'batch', 'relate', false,'{/literal}{sugar_translate label='LBL_BATCH' module='te_budgeted_campaign' for_js=true}{literal}' );
addToValidate('EditView', 'te_utm_te_budgeted_campaign_1_name', 'relate', true,'{/literal}{sugar_translate label='LBL_TE_UTM_TE_BUDGETED_CAMPAIGN_1_FROM_TE_UTM_TITLE' module='te_budgeted_campaign' for_js=true}{literal}' );
addToValidate('EditView', 'campaign_date', 'date', true,'{/literal}{sugar_translate label='LBL_CAMPAIGN_DATE' module='te_budgeted_campaign' for_js=true}{literal}' );
addToValidateBinaryDependency('EditView', 'assigned_user_name', 'alpha', false,'{/literal}{sugar_translate label='ERR_SQS_NO_MATCH_FIELD' module='te_budgeted_campaign' for_js=true}{literal}: {/literal}{sugar_translate label='LBL_ASSIGNED_TO' module='te_budgeted_campaign' for_js=true}{literal}', 'assigned_user_id' );
addToValidateBinaryDependency('EditView', 'te_utm_te_budgeted_campaign_1_name', 'alpha', true,'{/literal}{sugar_translate label='ERR_SQS_NO_MATCH_FIELD' module='te_budgeted_campaign' for_js=true}{literal}: {/literal}{sugar_translate label='LBL_TE_UTM_TE_BUDGETED_CAMPAIGN_1_FROM_TE_UTM_TITLE' module='te_budgeted_campaign' for_js=true}{literal}', 'te_utm_te_budgeted_campaign_1te_utm_ida' );
</script><script language="javascript">if(typeof sqs_objects == 'undefined'){var sqs_objects = new Array;}sqs_objects['EditView_te_utm_te_budgeted_campaign_1_name']={"form":"EditView","method":"query","modules":["te_utm"],"group":"or","field_list":["name","id"],"populate_list":["te_utm_te_budgeted_campaign_1_name","te_utm_te_budgeted_campaign_1te_utm_ida"],"required_list":["parent_id"],"conditions":[{"name":"name","op":"like_custom","end":"%","value":""}],"order":"name","limit":"30","no_match_text":"No Match"};</script>{/literal}
