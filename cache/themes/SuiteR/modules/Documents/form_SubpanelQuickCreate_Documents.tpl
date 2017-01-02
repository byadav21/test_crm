

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
<input type="hidden" name="old_id" value="{$fields.document_revision_id.value}">   
<input type="hidden" name="parent_id" value="{$smarty.request.parent_id}">   
<input type="hidden" name="parent_type" value="{$smarty.request.parent_type}">   
<div class="action_buttons">{if $bean->aclAccess("save")}<input title="{$APP.LBL_SAVE_BUTTON_TITLE}"  class="button" onclick="var _form = document.getElementById('form_SubpanelQuickCreate_Documents'); disableOnUnloadEditView(); _form.action.value='Save';if(check_form('form_SubpanelQuickCreate_Documents'))return SUGAR.subpanelUtils.inlineSave(_form.id, 'Documents_subpanel_save_button');return false;" type="submit" name="Documents_subpanel_save_button" id="Documents_subpanel_save_button" value="{$APP.LBL_SAVE_BUTTON_LABEL}">{/if}  <input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" class="button" onclick="return SUGAR.subpanelUtils.cancelCreate($(this).attr('id'));return false;" type="submit" name="Documents_subpanel_cancel_button" id="Documents_subpanel_cancel_button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">  <input title="{$APP.LBL_FULL_FORM_BUTTON_TITLE}" class="button" onclick="var _form = document.getElementById('form_SubpanelQuickCreate_Documents'); disableOnUnloadEditView(_form); _form.return_action.value='DetailView'; _form.action.value='EditView'; if(typeof(_form.to_pdf)!='undefined') _form.to_pdf.value='0';" type="submit" name="Documents_subpanel_full_form_button" id="Documents_subpanel_full_form_button" value="{$APP.LBL_FULL_FORM_BUTTON_LABEL}"> <input type="hidden" name="full_form" value="full_form"> {if $bean->aclAccess("detail")}{if !empty($fields.id.value) && $isAuditEnabled}<input id="btn_view_change_log" title="{$APP.LNK_VIEW_CHANGE_LOG}" class="button" onclick='open_popup("Audit", "600", "400", "&record={$fields.id.value}&module_name=Documents", true, false,  {ldelim} "call_back_function":"set_return","form_name":"EditView","field_to_name_array":[] {rdelim} ); return false;' type="button" value="{$APP.LNK_VIEW_CHANGE_LOG}">{/if}{/if}<div class="clear"></div></div>
</td>
<td align='right'>
{$PAGINATION}
</td>
</tr>
</table>{sugar_include include=$includes}
<span id='tabcounterJS'><script>SUGAR.TabFields=new Array();//this will be used to track tabindexes for references</script></span>
<div id="form_SubpanelQuickCreate_Documents_tabs"
>
<div >
<div id="detailpanel_1" >
{counter name="panelFieldCount" start=0 print=false assign="panelFieldCount"}
<table width="100%" border="0" cellspacing="1" cellpadding="0"  id='Default_{$module}_Subpanel'  class="yui3-skin-sam edit view panelContainer">
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{capture name="tr" assign="tableRow"}
<tr>
<td valign="top" id='filename_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_FILENAME' module='Documents'}{/capture}
{$label|strip_semicolon}:
<span class="required">*</span>
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' >
{counter name="panelFieldCount"}

<script type="text/javascript" src='cache/include/externalAPI.cache.js?v=wUfeT5IQUbwii78MflriMw'></script>
<script type="text/javascript" src='include/SugarFields/Fields/File/SugarFieldFile.js?v=wUfeT5IQUbwii78MflriMw'></script>
{if !empty($fields.filename.value) }
{assign var=showRemove value=true}
{else}
{assign var=showRemove value=false}
{/if}
{if !empty($fields.filename.value) }
{assign var=showRemove value=true}
{assign var=noChange value=true}
{else}
{assign var=noChange value=false}
{/if}
<input type="hidden" name="deleteAttachment" value="0">
<input type="hidden" name="{$fields.filename.name}" id="{$fields.filename.name}" value="{$fields.filename.value}">
<input type="hidden" name="doc_id" id="doc_id" value="{$fields.doc_id.value}">
<input type="hidden" name="doc_url" id="doc_url" value="{$fields.doc_url.value}">
<input type="hidden" name="{$fields.filename.name}_old_doctype" id="{$fields.filename.name}_old_doctype" value="{$fields.doc_type.value}">
<span id="{$fields.filename.name}_old" style="display:{if !$showRemove}none;{/if}">
<a href="index.php?entryPoint=download&id={$fields.document_revision_id.value}&type={$module}" class="tabDetailViewDFLink">{$fields.filename.value}</a>
{if isset($fields.doc_type) && !empty($fields.doc_type.value) && $fields.doc_type.value != 'Sugar' && !empty($fields.doc_url.value) }
{capture name=imageNameCapture assign=imageName}
{$fields.doc_type.value}_image_inline.png
{/capture}
<a href="{$fields.doc_url.value}" class="tabDetailViewDFLink" target="_blank">{sugar_getimage name=$imageName alt=$imageName other_attributes='border="0" '}</a>
{/if}
{if !$noChange}
<input type='button' class='button' id='remove_button' value='{$APP.LBL_REMOVE}' onclick='SUGAR.field.file.deleteAttachment("{$fields.filename.name}","doc_type",this);'>
{/if}
</span>
{if !$noChange}
<span id="{$fields.filename.name}_new" style="display:{if $showRemove}none;{/if}">
<input type="hidden" name="{$fields.filename.name}_escaped">
<input id="{$fields.filename.name}_file" name="{$fields.filename.name}_file" 
type="file" title='' size="30"
accesskey='7'  
maxlength="255"
>
<span id="{$fields.filename.name}_externalApiSelector" style="display:none;">
<br><h4 id="{$fields.filename.name}_externalApiLabel">
<span id="{$fields.filename.name}_more">{sugar_image name="advanced_search" width="8px" height="8px"}</span>
<span id="{$fields.filename.name}_less" style="display: none;">{sugar_image name="basic_search" width="8px" height="8px"}</span>
{$APP.LBL_SEARCH_EXTERNAL_API}</h4>
<span id="{$fields.filename.name}_remoteNameSpan" style="display: none;">
<input type="text" class="sqsEnabled" name="{$fields.filename.name}_remoteName" id="{$fields.filename.name}_remoteName" size="30" 
accesskey='7'  
maxlength="255"
autocomplete="off" value="{if !empty($fields[doc_id].value)}{$fields.filename.name}{/if}">
<span class="id-ff multiple">
<button type="button" name="{$fields.filename.name}_remoteSelectBtn" id="{$fields.filename.name}_remoteSelectBtn" tabindex="0" title="{sugar_translate label="LBL_ACCESSKEY_SELECT_FILE_TITLE"}" class="button firstChild" value="{sugar_translate label="LBL_ACCESSKEY_SELECT_FILE_LABEL"}"
onclick="SUGAR.field.file.openPopup('{$fields.filename.name}'); return false;">
{sugar_getimage alt=$app_strings.LBL_ID_FF_SELECT name="id-ff-select" ext=".png" other_attributes=''}</button>
<button type="button" name="{$fields.filename.name}_remoteClearBtn" id="{$fields.filename.name}_remoteClearBtn" tabindex="0" title="{$APP.LBL_CLEAR_BUTTON_TITLE}" class="button lastChild" value="{$APP.LBL_CLEAR_BUTTON_LABEL}" onclick="SUGAR.field.file.clearRemote('{$fields.filename.name}'); return false;">
{sugar_getimage name="id-ff-clear" alt=$app_strings.LBL_ID_FF_CLEAR ext=".png" other_attributes=''}
</button>
</span>
</span>
<div style="display: none;" id="{$fields.filename.name}_securityLevelBox">
<b>{$APP.LBL_EXTERNAL_SECURITY_LEVEL}: </b>
<select name="{$fields.filename.name}_securityLevel" id="{$fields.filename.name}_securityLevel">
</select>
</div>
<script type="text/javascript">
YAHOO.util.Event.onDOMReady(function() {ldelim}
SUGAR.field.file.setupEapiShowHide("{$fields.filename.name}","doc_type","{$form_name}");
{rdelim});

if ( typeof(sqs_objects) == 'undefined' ) {ldelim}
    sqs_objects = new Array;
{rdelim}

sqs_objects["{$form_name}_{$fields.filename.name}_remoteName"] = {ldelim}
"form":"{$form_name}",
"method":"externalApi",
"api":"",
"modules":["EAPM"],
"field_list":["name", "id", "url", "id"],
"populate_list":["{$fields.filename.name}_remoteName", "doc_id", "doc_url", "{$fields.filename.name}"],
"required_list":["name"],
"conditions":[],
"no_match_text":"No Match"
{rdelim};

if(typeof QSProcessedFieldsArray != 'undefined') {ldelim}
	QSProcessedFieldsArray["{$form_name}_{$fields.filename.name}_remoteName"] = false;
{rdelim}
{if $showRemove && strlen("doc_type") > 0 }
document.getElementById("doc_type").disabled = true;
{/if}
enableQS(false);
</script>
{else}

<script type="text/javascript">
YAHOO.util.Event.onDOMReady(function() 
{ldelim}
document.getElementById("doc_type").disabled = true;
{rdelim});
</script>
{/if}
<script type="text/javascript">

var {$fields.filename.name}_setFileName = function()
{literal}
{
    var dom = YAHOO.util.Dom;
{/literal}    
    sourceElement = "{$fields.filename.name}_file";
    targetElement = "document_name";
	src = new String(dom.get(sourceElement).value);
	target = new String(dom.get(targetElement).value);
{literal}
	if (target.length == 0) 
	{
		lastindex=src.lastIndexOf("/");
		if (lastindex == -1) {
			lastindex=src.lastIndexOf("\\");
		} 
		if (lastindex == -1) {
			dom.get(targetElement).value=src;
		} else {
			dom.get(targetElement).value=src.substr(++lastindex, src.length);
		}	
	}	
}
{/literal}

YAHOO.util.Event.onDOMReady(function() 
{ldelim}
if(document.getElementById("document_name"))
{ldelim}
YAHOO.util.Event.addListener('{$fields.filename.name}_file', 'change', {$fields.filename.name}_setFileName);
YAHOO.util.Event.addListener(['{$fields.filename.name}_file', 'doc_type'], 'change', SUGAR.field.file.checkFileExtension,{ldelim} fileEl: '{$fields.filename.name}_file', targEl: 'document_name'{rdelim});
{rdelim}
{rdelim});
</script>
</span>
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
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{capture name="tr" assign="tableRow"}
<tr>
<td valign="top" id='document_name_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_NAME' module='Documents'}{/capture}
{$label|strip_semicolon}:
<span class="required">*</span>
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' >
{counter name="panelFieldCount"}

{if strlen($fields.document_name.value) <= 0}
{assign var="value" value=$fields.document_name.default_value }
{else}
{assign var="value" value=$fields.document_name.value }
{/if}  
<input type='text' name='{$fields.document_name.name}' 
id='{$fields.document_name.name}' size='30' 
maxlength='255' 
value='{$value}' title=''      >
<td valign="top" id='revision_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_DOC_VERSION' module='Documents'}{/capture}
{$label|strip_semicolon}:
<span class="required">*</span>
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' >
{counter name="panelFieldCount"}
<input accesskey=""  tabindex="0"  name="revision" type="text" value="{$fields.revision.value}" {$DISABLED}>
</tr>
{/capture}
{if $fieldsUsed > 0 }
{$tableRow}
{/if}
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{capture name="tr" assign="tableRow"}
<tr>
<td valign="top" id='active_date_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_DOC_ACTIVE_DATE' module='Documents'}{/capture}
{$label|strip_semicolon}:
<span class="required">*</span>
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' >
{counter name="panelFieldCount"}

<span class="dateTime">
{assign var=date_value value=$fields.active_date.value }
<input class="date_input" autocomplete="off" type="text" name="{$fields.active_date.name}" id="{$fields.active_date.name}" value="{$date_value}" title=''  tabindex='0'    size="11" maxlength="10" >
{capture assign="other_attributes"}alt="{$APP.LBL_ENTER_DATE}" style="position:relative; top:6px" border="0" id="{$fields.active_date.name}_trigger"{/capture}
{sugar_getimage name="jscalendar" ext=".gif" other_attributes="$other_attributes"}
</span>
<script type="text/javascript">
Calendar.setup ({ldelim}
inputField : "{$fields.active_date.name}",
form : "form_SubpanelQuickCreate_Documents",
ifFormat : "{$CALENDAR_FORMAT}",
daFormat : "{$CALENDAR_FORMAT}",
button : "{$fields.active_date.name}_trigger",
singleClick : true,
dateStr : "{$date_value}",
startWeekday: {$CALENDAR_FDOW|default:'0'},
step : 1,
weekNumbers:false
{rdelim}
);
</script>
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
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{capture name="tr" assign="tableRow"}
<tr>
<td valign="top" id='_label' width='12.5%' scope="col">
&nbsp;
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' >
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
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{capture name="tr" assign="tableRow"}
<tr>
<td valign="top" id='_label' width='12.5%' scope="col">
&nbsp;
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' colspan='3'>
</tr>
{/capture}
{if $fieldsUsed > 0 }
{$tableRow}
{/if}
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{capture name="tr" assign="tableRow"}
<tr>
<td valign="top" id='_label' width='12.5%' scope="col">
&nbsp;
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' colspan='3'>
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
<div class="action_buttons">{if $bean->aclAccess("save")}<input title="{$APP.LBL_SAVE_BUTTON_TITLE}"  class="button" onclick="var _form = document.getElementById('form_SubpanelQuickCreate_Documents'); disableOnUnloadEditView(); _form.action.value='Save';if(check_form('form_SubpanelQuickCreate_Documents'))return SUGAR.subpanelUtils.inlineSave(_form.id, 'Documents_subpanel_save_button');return false;" type="submit" name="Documents_subpanel_save_button" id="Documents_subpanel_save_button" value="{$APP.LBL_SAVE_BUTTON_LABEL}">{/if}  <input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" class="button" onclick="return SUGAR.subpanelUtils.cancelCreate($(this).attr('id'));return false;" type="submit" name="Documents_subpanel_cancel_button" id="Documents_subpanel_cancel_button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">  <input title="{$APP.LBL_FULL_FORM_BUTTON_TITLE}" class="button" onclick="var _form = document.getElementById('form_SubpanelQuickCreate_Documents'); disableOnUnloadEditView(_form); _form.return_action.value='DetailView'; _form.action.value='EditView'; if(typeof(_form.to_pdf)!='undefined') _form.to_pdf.value='0';" type="submit" name="Documents_subpanel_full_form_button" id="Documents_subpanel_full_form_button" value="{$APP.LBL_FULL_FORM_BUTTON_LABEL}"> <input type="hidden" name="full_form" value="full_form"> {if $bean->aclAccess("detail")}{if !empty($fields.id.value) && $isAuditEnabled}<input id="btn_view_change_log" title="{$APP.LNK_VIEW_CHANGE_LOG}" class="button" onclick='open_popup("Audit", "600", "400", "&record={$fields.id.value}&module_name=Documents", true, false,  {ldelim} "call_back_function":"set_return","form_name":"EditView","field_to_name_array":[] {rdelim} ); return false;' type="button" value="{$APP.LNK_VIEW_CHANGE_LOG}">{/if}{/if}<div class="clear"></div></div>
</div>
</form>
{$set_focus_block}
<script>SUGAR.util.doWhen("document.getElementById('EditView') != null",
        function(){ldelim}SUGAR.util.buildAccessKeyLabels();{rdelim});
</script><script type="text/javascript">
YAHOO.util.Event.onContentReady("form_SubpanelQuickCreate_Documents",
    function () {ldelim} initEditView(document.forms.form_SubpanelQuickCreate_Documents) {rdelim});
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
addForm('form_SubpanelQuickCreate_Documents');addToValidate('form_SubpanelQuickCreate_Documents', 'name', 'varchar', false,'{/literal}{sugar_translate label='LBL_NAME' module='Documents' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_Documents', 'date_entered_date', 'date', false,'Date Created' );
addToValidate('form_SubpanelQuickCreate_Documents', 'date_modified_date', 'date', false,'Date Modified' );
addToValidate('form_SubpanelQuickCreate_Documents', 'modified_user_id', 'assigned_user_name', false,'{/literal}{sugar_translate label='LBL_MODIFIED' module='Documents' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_Documents', 'modified_by_name', 'relate', false,'{/literal}{sugar_translate label='LBL_MODIFIED_NAME' module='Documents' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_Documents', 'created_by', 'assigned_user_name', false,'{/literal}{sugar_translate label='LBL_CREATED' module='Documents' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_Documents', 'created_by_name', 'relate', false,'{/literal}{sugar_translate label='LBL_CREATED' module='Documents' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_Documents', 'description', 'text', false,'{/literal}{sugar_translate label='LBL_DESCRIPTION' module='Documents' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_Documents', 'deleted', 'bool', false,'{/literal}{sugar_translate label='LBL_DELETED' module='Documents' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_Documents', 'assigned_user_id', 'relate', false,'{/literal}{sugar_translate label='LBL_ASSIGNED_TO_ID' module='Documents' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_Documents', 'assigned_user_name', 'relate', false,'{/literal}{sugar_translate label='LBL_ASSIGNED_TO_NAME' module='Documents' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_Documents', 'document_name', 'varchar', true,'{/literal}{sugar_translate label='LBL_NAME' module='Documents' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_Documents', 'doc_id', 'varchar', false,'{/literal}{sugar_translate label='LBL_DOC_ID' module='Documents' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_Documents', 'doc_type', 'enum', false,'{/literal}{sugar_translate label='LBL_DOC_TYPE' module='Documents' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_Documents', 'doc_url', 'varchar', false,'{/literal}{sugar_translate label='LBL_DOC_URL' module='Documents' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_Documents', 'filename', 'file', true,'{/literal}{sugar_translate label='LBL_FILENAME' module='Documents' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_Documents', 'active_date', 'date', true,'{/literal}{sugar_translate label='LBL_DOC_ACTIVE_DATE' module='Documents' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_Documents', 'exp_date', 'date', false,'{/literal}{sugar_translate label='LBL_DOC_EXP_DATE' module='Documents' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_Documents', 'category_id', 'enum', false,'{/literal}{sugar_translate label='LBL_SF_CATEGORY' module='Documents' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_Documents', 'subcategory_id', 'enum', false,'{/literal}{sugar_translate label='LBL_SF_SUBCATEGORY' module='Documents' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_Documents', 'status_id', 'enum', false,'{/literal}{sugar_translate label='LBL_DOC_STATUS' module='Documents' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_Documents', 'status', 'varchar', false,'{/literal}{sugar_translate label='LBL_DOC_STATUS' module='Documents' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_Documents', 'document_revision_id', 'varchar', false,'{/literal}{sugar_translate label='LBL_LATEST_REVISION' module='Documents' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_Documents', 'revision', 'varchar', true,'{/literal}{sugar_translate label='LBL_DOC_VERSION' module='Documents' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_Documents', 'last_rev_created_name', 'varchar', false,'{/literal}{sugar_translate label='LBL_LAST_REV_CREATOR' module='Documents' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_Documents', 'last_rev_mime_type', 'varchar', false,'{/literal}{sugar_translate label='LBL_LAST_REV_MIME_TYPE' module='Documents' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_Documents', 'latest_revision', 'varchar', false,'{/literal}{sugar_translate label='LBL_LATEST_REVISION' module='Documents' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_Documents', 'last_rev_create_date', 'date', false,'{/literal}{sugar_translate label='LBL_LAST_REV_CREATE_DATE' module='Documents' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_Documents', 'related_doc_id', 'varchar', false,'{/literal}{sugar_translate label='LBL_RELATED_DOCUMENT_ID' module='Documents' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_Documents', 'related_doc_name', 'relate', false,'{/literal}{sugar_translate label='LBL_DET_RELATED_DOCUMENT' module='Documents' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_Documents', 'related_doc_rev_id', 'varchar', false,'{/literal}{sugar_translate label='LBL_RELATED_DOCUMENT_REVISION_ID' module='Documents' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_Documents', 'related_doc_rev_number', 'varchar', false,'{/literal}{sugar_translate label='LBL_DET_RELATED_DOCUMENT_VERSION' module='Documents' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_Documents', 'is_template', 'bool', false,'{/literal}{sugar_translate label='LBL_IS_TEMPLATE' module='Documents' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_Documents', 'template_type', 'enum', false,'{/literal}{sugar_translate label='LBL_TEMPLATE_TYPE' module='Documents' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_Documents', 'latest_revision_name', 'varchar', false,'{/literal}{sugar_translate label='LBL_LASTEST_REVISION_NAME' module='Documents' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_Documents', 'selected_revision_name', 'varchar', false,'{/literal}{sugar_translate label='LBL_SELECTED_REVISION_NAME' module='Documents' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_Documents', 'contract_status', 'varchar', false,'{/literal}{sugar_translate label='LBL_CONTRACT_STATUS' module='Documents' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_Documents', 'contract_name', 'varchar', false,'{/literal}{sugar_translate label='LBL_CONTRACT_NAME' module='Documents' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_Documents', 'linked_id', 'varchar', false,'{/literal}{sugar_translate label='LBL_LINKED_ID' module='Documents' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_Documents', 'selected_revision_id', 'varchar', false,'{/literal}{sugar_translate label='LBL_SELECTED_REVISION_ID' module='Documents' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_Documents', 'latest_revision_id', 'varchar', false,'{/literal}{sugar_translate label='LBL_LATEST_REVISION_ID' module='Documents' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_Documents', 'selected_revision_filename', 'varchar', false,'{/literal}{sugar_translate label='LBL_SELECTED_REVISION_FILENAME' module='Documents' for_js=true}{literal}' );
addToValidateBinaryDependency('form_SubpanelQuickCreate_Documents', 'assigned_user_name', 'alpha', false,'{/literal}{sugar_translate label='ERR_SQS_NO_MATCH_FIELD' module='Documents' for_js=true}{literal}: {/literal}{sugar_translate label='LBL_ASSIGNED_TO' module='Documents' for_js=true}{literal}', 'assigned_user_id' );
</script>{/literal}
