

<script language="javascript">
{literal}
SUGAR.util.doWhen(function(){
    return $("#contentTable").length == 0;
}, SUGAR.themes.actionMenu);
{/literal}
</script>
<table cellpadding="0" cellspacing="0" border="0" width="100%" id="">
<tr>
<td class="buttons" align="left" NOWRAP width="80%">
<div class="actionsContainer">
<form action="index.php" method="post" name="DetailView" id="formDetailView">
<input type="hidden" name="module" value="{$module}">
<input type="hidden" name="record" value="{$fields.id.value}">
<input type="hidden" name="return_action">
<input type="hidden" name="return_module">
<input type="hidden" name="return_id">
<input type="hidden" name="module_tab">
<input type="hidden" name="isDuplicate" value="false">
<input type="hidden" name="offset" value="{$offset}">
<input type="hidden" name="action" value="EditView">
<input type="hidden" name="sugar_body_only">
</form>
<ul id="detail_header_action_menu" class="clickMenu fancymenu" ><li class="sugar_action_button" >{if $bean->aclAccess("edit")}<input title="{$APP.LBL_EDIT_BUTTON_TITLE}" accessKey="{$APP.LBL_EDIT_BUTTON_KEY}" class="button primary" onclick="var _form = document.getElementById('formDetailView'); _form.return_module.value='te_ba_Batch'; _form.return_action.value='DetailView'; _form.return_id.value='{$id}'; _form.action.value='EditView';SUGAR.ajaxUI.submitForm(_form);" type="button" name="Edit" id="edit_button" value="{$APP.LBL_EDIT_BUTTON_LABEL}">{/if} <ul id class="subnav" ><li>{if $bean->aclAccess("edit")}<input title="{$APP.LBL_DUPLICATE_BUTTON_TITLE}" accessKey="{$APP.LBL_DUPLICATE_BUTTON_KEY}" class="button" onclick="var _form = document.getElementById('formDetailView'); _form.return_module.value='te_ba_Batch'; _form.return_action.value='DetailView'; _form.isDuplicate.value=true; _form.action.value='EditView'; _form.return_id.value='{$id}';SUGAR.ajaxUI.submitForm(_form);" type="button" name="Duplicate" value="{$APP.LBL_DUPLICATE_BUTTON_LABEL}" id="duplicate_button">{/if} </li><li>{if $bean->aclAccess("delete")}<input title="{$APP.LBL_DELETE_BUTTON_TITLE}" accessKey="{$APP.LBL_DELETE_BUTTON_KEY}" class="button" onclick="var _form = document.getElementById('formDetailView'); _form.return_module.value='te_ba_Batch'; _form.return_action.value='ListView'; _form.action.value='Delete'; if(confirm('{$APP.NTC_DELETE_CONFIRMATION}')) SUGAR.ajaxUI.submitForm(_form);" type="submit" name="Delete" value="{$APP.LBL_DELETE_BUTTON_LABEL}" id="delete_button">{/if} </li><li>{if $bean->aclAccess("edit") && $bean->aclAccess("delete")}<input title="{$APP.LBL_DUP_MERGE}" class="button" onclick="var _form = document.getElementById('formDetailView'); _form.return_module.value='te_ba_Batch'; _form.return_action.value='DetailView'; _form.return_id.value='{$id}'; _form.action.value='Step1'; _form.module.value='MergeRecords';SUGAR.ajaxUI.submitForm(_form);" type="button" name="Merge" value="{$APP.LBL_DUP_MERGE}" id="merge_duplicate_button">{/if} </li><li>{if $bean->aclAccess("detail")}{if !empty($fields.id.value) && $isAuditEnabled}<input id="btn_view_change_log" title="{$APP.LNK_VIEW_CHANGE_LOG}" class="button" onclick='open_popup("Audit", "600", "400", "&record={$fields.id.value}&module_name=te_ba_Batch", true, false,  {ldelim} "call_back_function":"set_return","form_name":"EditView","field_to_name_array":[] {rdelim} ); return false;' type="button" value="{$APP.LNK_VIEW_CHANGE_LOG}">{/if}{/if}</li></ul></li></ul>
</div>
</td>
<td align="right" width="20%">{$ADMIN_EDIT}
{$PAGINATION}
</td>
</tr>
</table>{sugar_include include=$includes}
<div id="te_ba_Batch_detailview_tabs"
>
<div >
<div id='detailpanel_1' class='detail view  detail508 expanded'>
{counter name="panelFieldCount" start=0 print=false assign="panelFieldCount"}
<!-- PANEL CONTAINER HERE.. -->
<table id='DEFAULT' class="panelContainer" cellspacing='{$gridline}'>
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{counter name="fieldsHidden" start=0 print=false assign="fieldsHidden"}
{capture name="tr" assign="tableRow"}
<tr>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.te_in_institutes_te_ba_batch_1_name.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_TE_IN_INSTITUTES_TE_BA_BATCH_1_FROM_TE_IN_INSTITUTES_TITLE' module='te_ba_Batch'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="relate" field="te_in_institutes_te_ba_batch_1_name" width='37.5%'  >
{if !$fields.te_in_institutes_te_ba_batch_1_name.hidden}
{counter name="panelFieldCount"}

{if !empty($fields.te_in_institutes_te_ba_batch_1te_in_institutes_ida.value)}
{capture assign="detail_url"}index.php?module=te_in_institutes&action=DetailView&record={$fields.te_in_institutes_te_ba_batch_1te_in_institutes_ida.value}{/capture}
<a href="{sugar_ajax_url url=$detail_url}">{/if}
<span id="te_in_institutes_te_ba_batch_1te_in_institutes_ida" class="sugar_field" data-id-value="{$fields.te_in_institutes_te_ba_batch_1te_in_institutes_ida.value}">{$fields.te_in_institutes_te_ba_batch_1_name.value}</span>
{if !empty($fields.te_in_institutes_te_ba_batch_1te_in_institutes_ida.value)}</a>{/if}
{/if}
<div class="inlineEditIcon"> {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}</div>			</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.te_pr_programs_te_ba_batch_1_name.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_TE_PR_PROGRAMS_TE_BA_BATCH_1_FROM_TE_PR_PROGRAMS_TITLE' module='te_ba_Batch'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="relate" field="te_pr_programs_te_ba_batch_1_name" width='37.5%'  >
{if !$fields.te_pr_programs_te_ba_batch_1_name.hidden}
{counter name="panelFieldCount"}

{if !empty($fields.te_pr_programs_te_ba_batch_1te_pr_programs_ida.value)}
{capture assign="detail_url"}index.php?module=te_pr_Programs&action=DetailView&record={$fields.te_pr_programs_te_ba_batch_1te_pr_programs_ida.value}{/capture}
<a href="{sugar_ajax_url url=$detail_url}">{/if}
<span id="te_pr_programs_te_ba_batch_1te_pr_programs_ida" class="sugar_field" data-id-value="{$fields.te_pr_programs_te_ba_batch_1te_pr_programs_ida.value}">{$fields.te_pr_programs_te_ba_batch_1_name.value}</span>
{if !empty($fields.te_pr_programs_te_ba_batch_1te_pr_programs_ida.value)}</a>{/if}
{/if}
<div class="inlineEditIcon"> {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}</div>			</td>
</tr>
{/capture}
{if $fieldsUsed > 0 && $fieldsUsed != $fieldsHidden}
{$tableRow}
{/if}
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{counter name="fieldsHidden" start=0 print=false assign="fieldsHidden"}
{capture name="tr" assign="tableRow"}
<tr>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.name.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_NAME' module='te_ba_Batch'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="name" field="name" width='37.5%'  >
{if !$fields.name.hidden}
{counter name="panelFieldCount"}

{if strlen($fields.name.value) <= 0}
{assign var="value" value=$fields.name.default_value }
{else}
{assign var="value" value=$fields.name.value }
{/if} 
<span class="sugar_field" id="{$fields.name.name}">{$fields.name.value}</span>
{/if}
<div class="inlineEditIcon"> {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}</div>			</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.batch_code.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_BATCH_CODE' module='te_ba_Batch'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="varchar" field="batch_code" width='37.5%'  >
{if !$fields.batch_code.hidden}
{counter name="panelFieldCount"}

{if strlen($fields.batch_code.value) <= 0}
{assign var="value" value=$fields.batch_code.default_value }
{else}
{assign var="value" value=$fields.batch_code.value }
{/if} 
<span class="sugar_field" id="{$fields.batch_code.name}">{$fields.batch_code.value}</span>
{/if}
<div class="inlineEditIcon"> {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}</div>			</td>
</tr>
{/capture}
{if $fieldsUsed > 0 && $fieldsUsed != $fieldsHidden}
{$tableRow}
{/if}
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{counter name="fieldsHidden" start=0 print=false assign="fieldsHidden"}
{capture name="tr" assign="tableRow"}
<tr>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.batch_start_date.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_BATCH_START_DATE' module='te_ba_Batch'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="date" field="batch_start_date" width='37.5%'  >
{if !$fields.batch_start_date.hidden}
{counter name="panelFieldCount"}


{if strlen($fields.batch_start_date.value) <= 0}
{assign var="value" value=$fields.batch_start_date.default_value }
{else}
{assign var="value" value=$fields.batch_start_date.value }
{/if}
<span class="sugar_field" id="{$fields.batch_start_date.name}">{$value}</span>
{/if}
<div class="inlineEditIcon"> {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}</div>			</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.batch_status.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_BATCH_STATUS' module='te_ba_Batch'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="enum" field="batch_status" width='37.5%'  >
{if !$fields.batch_status.hidden}
{counter name="panelFieldCount"}


{if is_string($fields.batch_status.options)}
<input type="hidden" class="sugar_field" id="{$fields.batch_status.name}" value="{ $fields.batch_status.options }">
{ $fields.batch_status.options }
{else}
<input type="hidden" class="sugar_field" id="{$fields.batch_status.name}" value="{ $fields.batch_status.value }">
{ $fields.batch_status.options[$fields.batch_status.value]}
{/if}
{/if}
<div class="inlineEditIcon"> {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}</div>			</td>
</tr>
{/capture}
{if $fieldsUsed > 0 && $fieldsUsed != $fieldsHidden}
{$tableRow}
{/if}
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{counter name="fieldsHidden" start=0 print=false assign="fieldsHidden"}
{capture name="tr" assign="tableRow"}
<tr>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.fees_inr.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_FEES_INR' module='te_ba_Batch'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="float" field="fees_inr" width='37.5%'  >
{if !$fields.fees_inr.hidden}
{counter name="panelFieldCount"}

<span class="sugar_field" id="{$fields.fees_inr.name}">
{sugar_number_format var=$fields.fees_inr.value precision=2 }
</span>
{/if}
<div class="inlineEditIcon"> {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}</div>			</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.batch_size.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_BATCH_SIZE' module='te_ba_Batch'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="int" field="batch_size" width='37.5%'  >
{if !$fields.batch_size.hidden}
{counter name="panelFieldCount"}

<span class="sugar_field" id="{$fields.batch_size.name}">
{sugar_number_format precision=0 var=$fields.batch_size.value}
</span>
{/if}
<div class="inlineEditIcon"> {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}</div>			</td>
</tr>
{/capture}
{if $fieldsUsed > 0 && $fieldsUsed != $fieldsHidden}
{$tableRow}
{/if}
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{counter name="fieldsHidden" start=0 print=false assign="fieldsHidden"}
{capture name="tr" assign="tableRow"}
<tr>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.duration.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_DURATION' module='te_ba_Batch'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="int" field="duration" width='37.5%'  >
{if !$fields.duration.hidden}
{counter name="panelFieldCount"}

<span class="sugar_field" id="{$fields.duration.name}">
{sugar_number_format precision=0 var=$fields.duration.value}
</span>
{/if}
<div class="inlineEditIcon"> {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}</div>			</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.minimum_attendance_criteria.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_MINIMUM_ATTENDANCE_CRITERIA' module='te_ba_Batch'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="float" field="minimum_attendance_criteria" width='37.5%'  >
{if !$fields.minimum_attendance_criteria.hidden}
{counter name="panelFieldCount"}

<span class="sugar_field" id="{$fields.minimum_attendance_criteria.name}">
{sugar_number_format var=$fields.minimum_attendance_criteria.value precision=2 }
</span>
{/if}
<div class="inlineEditIcon"> {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}</div>			</td>
</tr>
{/capture}
{if $fieldsUsed > 0 && $fieldsUsed != $fieldsHidden}
{$tableRow}
{/if}
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{counter name="fieldsHidden" start=0 print=false assign="fieldsHidden"}
{capture name="tr" assign="tableRow"}
<tr>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.total_sessions_planned.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_TOTAL_SESSIONS_PLANNED' module='te_ba_Batch'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="int" field="total_sessions_planned" width='37.5%'  >
{if !$fields.total_sessions_planned.hidden}
{counter name="panelFieldCount"}

<span class="sugar_field" id="{$fields.total_sessions_planned.name}">
{sugar_number_format precision=0 var=$fields.total_sessions_planned.value}
</span>
{/if}
<div class="inlineEditIcon"> {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}</div>			</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.registration_closing_date.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_REGISTRATION_CLOSING_DATE' module='te_ba_Batch'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="date" field="registration_closing_date" width='37.5%'  >
{if !$fields.registration_closing_date.hidden}
{counter name="panelFieldCount"}


{if strlen($fields.registration_closing_date.value) <= 0}
{assign var="value" value=$fields.registration_closing_date.default_value }
{else}
{assign var="value" value=$fields.registration_closing_date.value }
{/if}
<span class="sugar_field" id="{$fields.registration_closing_date.name}">{$value}</span>
{/if}
<div class="inlineEditIcon"> {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}</div>			</td>
</tr>
{/capture}
{if $fieldsUsed > 0 && $fieldsUsed != $fieldsHidden}
{$tableRow}
{/if}
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{counter name="fieldsHidden" start=0 print=false assign="fieldsHidden"}
{capture name="tr" assign="tableRow"}
<tr>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.fees_in_usd.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_FEES_IN_USD' module='te_ba_Batch'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="float" field="fees_in_usd" width='37.5%'  >
{if !$fields.fees_in_usd.hidden}
{counter name="panelFieldCount"}

<span class="sugar_field" id="{$fields.fees_in_usd.name}">
{sugar_number_format var=$fields.fees_in_usd.value precision=2 }
</span>
{/if}
<div class="inlineEditIcon"> {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}</div>			</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
&nbsp;
</td>
<td class="" type="" field="" width='37.5%'  >
</td>
</tr>
{/capture}
{if $fieldsUsed > 0 && $fieldsUsed != $fieldsHidden}
{$tableRow}
{/if}
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{counter name="fieldsHidden" start=0 print=false assign="fieldsHidden"}
{capture name="tr" assign="tableRow"}
<tr>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.description.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_DESCRIPTION' module='te_ba_Batch'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="text" field="description" width='37.5%'  >
{if !$fields.description.hidden}
{counter name="panelFieldCount"}

<span class="sugar_field" id="{$fields.description.name|escape:'html'|url2html|nl2br}">{$fields.description.value|escape:'html'|escape:'html_entity_decode'|url2html|nl2br}</span>
{/if}
<div class="inlineEditIcon"> {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}</div>			</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
&nbsp;
</td>
<td class="" type="" field="" width='37.5%'  >
</td>
</tr>
{/capture}
{if $fieldsUsed > 0 && $fieldsUsed != $fieldsHidden}
{$tableRow}
{/if}
</table>
</div>
{if $panelFieldCount == 0}
<script>document.getElementById("DEFAULT").style.display='none';</script>
{/if}
</div>
</div>

</form>
<script>SUGAR.util.doWhen("document.getElementById('form') != null",
        function(){ldelim}SUGAR.util.buildAccessKeyLabels();{rdelim});
</script><script type="text/javascript" src="include/InlineEditing/inlineEditing.js"></script>
<script type="text/javascript" src="modules/Favorites/favorites.js"></script>