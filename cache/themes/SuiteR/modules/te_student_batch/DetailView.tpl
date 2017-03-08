

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
<ul id="detail_header_action_menu" class="clickMenu fancymenu" ><li class="sugar_action_button" >{if $bean->aclAccess("edit")}<input title="{$APP.LBL_EDIT_BUTTON_TITLE}" accessKey="{$APP.LBL_EDIT_BUTTON_KEY}" class="button primary" onclick="var _form = document.getElementById('formDetailView'); _form.return_module.value='te_student_batch'; _form.return_action.value='DetailView'; _form.return_id.value='{$id}'; _form.action.value='EditView';SUGAR.ajaxUI.submitForm(_form);" type="button" name="Edit" id="edit_button" value="{$APP.LBL_EDIT_BUTTON_LABEL}">{/if} <ul id class="subnav" ><li>{if $bean->aclAccess("edit")}<input title="{$APP.LBL_DUPLICATE_BUTTON_TITLE}" accessKey="{$APP.LBL_DUPLICATE_BUTTON_KEY}" class="button" onclick="var _form = document.getElementById('formDetailView'); _form.return_module.value='te_student_batch'; _form.return_action.value='DetailView'; _form.isDuplicate.value=true; _form.action.value='EditView'; _form.return_id.value='{$id}';SUGAR.ajaxUI.submitForm(_form);" type="button" name="Duplicate" value="{$APP.LBL_DUPLICATE_BUTTON_LABEL}" id="duplicate_button">{/if} </li><li>{if $bean->aclAccess("delete")}<input title="{$APP.LBL_DELETE_BUTTON_TITLE}" accessKey="{$APP.LBL_DELETE_BUTTON_KEY}" class="button" onclick="var _form = document.getElementById('formDetailView'); _form.return_module.value='te_student_batch'; _form.return_action.value='ListView'; _form.action.value='Delete'; if(confirm('{$APP.NTC_DELETE_CONFIRMATION}')) SUGAR.ajaxUI.submitForm(_form);" type="submit" name="Delete" value="{$APP.LBL_DELETE_BUTTON_LABEL}" id="delete_button">{/if} </li><li>{if $bean->aclAccess("edit") && $bean->aclAccess("delete")}<input title="{$APP.LBL_DUP_MERGE}" class="button" onclick="var _form = document.getElementById('formDetailView'); _form.return_module.value='te_student_batch'; _form.return_action.value='DetailView'; _form.return_id.value='{$id}'; _form.action.value='Step1'; _form.module.value='MergeRecords';SUGAR.ajaxUI.submitForm(_form);" type="button" name="Merge" value="{$APP.LBL_DUP_MERGE}" id="merge_duplicate_button">{/if} </li><li>{if $bean->aclAccess("detail")}{if !empty($fields.id.value) && $isAuditEnabled}<input id="btn_view_change_log" title="{$APP.LNK_VIEW_CHANGE_LOG}" class="button" onclick='open_popup("Audit", "600", "400", "&record={$fields.id.value}&module_name=te_student_batch", true, false,  {ldelim} "call_back_function":"set_return","form_name":"EditView","field_to_name_array":[] {rdelim} ); return false;' type="button" value="{$APP.LNK_VIEW_CHANGE_LOG}">{/if}{/if}</li></ul></li></ul>
</div>
</td>
<td align="right" width="20%">{$ADMIN_EDIT}
{$PAGINATION}
</td>
</tr>
</table>{sugar_include include=$includes}
<div id="te_student_batch_detailview_tabs"
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
{if !$fields.batch.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_BATCH' module='te_student_batch'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="relate" field="batch" width='37.5%'  >
{if !$fields.batch.hidden}
{counter name="panelFieldCount"}

{if !empty($fields.te_ba_batch_id_c.value)}
{capture assign="detail_url"}index.php?module=te_ba_Batch&action=DetailView&record={$fields.te_ba_batch_id_c.value}{/capture}
<a href="{sugar_ajax_url url=$detail_url}">{/if}
<span id="te_ba_batch_id_c" class="sugar_field" data-id-value="{$fields.te_ba_batch_id_c.value}">{$fields.batch.value}</span>
{if !empty($fields.te_ba_batch_id_c.value)}</a>{/if}
{/if}
<div class="inlineEditIcon"> {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}</div>			</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.batch_code.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_BATCH_CODE' module='te_student_batch'}{/capture}
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
{if !$fields.te_student_te_student_batch_1_name.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_TE_STUDENT_TE_STUDENT_BATCH_1_FROM_TE_STUDENT_TITLE' module='te_student_batch'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="relate" field="te_student_te_student_batch_1_name" width='37.5%'  >
{if !$fields.te_student_te_student_batch_1_name.hidden}
{counter name="panelFieldCount"}

{if !empty($fields.te_student_te_student_batch_1te_student_ida.value)}
{capture assign="detail_url"}index.php?module=te_student&action=DetailView&record={$fields.te_student_te_student_batch_1te_student_ida.value}{/capture}
<a href="{sugar_ajax_url url=$detail_url}">{/if}
<span id="te_student_te_student_batch_1te_student_ida" class="sugar_field" data-id-value="{$fields.te_student_te_student_batch_1te_student_ida.value}">{$fields.te_student_te_student_batch_1_name.value}</span>
{if !empty($fields.te_student_te_student_batch_1te_student_ida.value)}</a>{/if}
{/if}
<div class="inlineEditIcon"> {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}</div>			</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.institute.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_INSTITUTE' module='te_student_batch'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="relate" field="institute" width='37.5%'  >
{if !$fields.institute.hidden}
{counter name="panelFieldCount"}

{if !empty($fields.te_in_institutes_id_c.value)}
{capture assign="detail_url"}index.php?module=te_in_institutes&action=DetailView&record={$fields.te_in_institutes_id_c.value}{/capture}
<a href="{sugar_ajax_url url=$detail_url}">{/if}
<span id="te_in_institutes_id_c" class="sugar_field" data-id-value="{$fields.te_in_institutes_id_c.value}">{$fields.institute.value}</span>
{if !empty($fields.te_in_institutes_id_c.value)}</a>{/if}
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
{if !$fields.program.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_PROGRAM' module='te_student_batch'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="relate" field="program" width='37.5%' colspan='3' >
{if !$fields.program.hidden}
{counter name="panelFieldCount"}

{if !empty($fields.te_pr_programs_id_c.value)}
{capture assign="detail_url"}index.php?module=te_pr_Programs&action=DetailView&record={$fields.te_pr_programs_id_c.value}{/capture}
<a href="{sugar_ajax_url url=$detail_url}">{/if}
<span id="te_pr_programs_id_c" class="sugar_field" data-id-value="{$fields.te_pr_programs_id_c.value}">{$fields.program.value}</span>
{if !empty($fields.te_pr_programs_id_c.value)}</a>{/if}
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
{if !$fields.fee_inr.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_FEE_INR' module='te_student_batch'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="decimal" field="fee_inr" width='37.5%'  >
{if !$fields.fee_inr.hidden}
{counter name="panelFieldCount"}

<span class="sugar_field" id="{$fields.fee_inr.name}">
{sugar_number_format var=$fields.fee_inr.value precision=2 }
</span>
{/if}
<div class="inlineEditIcon"> {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}</div>			</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.fee_usd.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_FEE_USD' module='te_student_batch'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="decimal" field="fee_usd" width='37.5%'  >
{if !$fields.fee_usd.hidden}
{counter name="panelFieldCount"}

<span class="sugar_field" id="{$fields.fee_usd.name}">
{sugar_number_format var=$fields.fee_usd.value precision=2 }
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
{if !$fields.status.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_STATUS' module='te_student_batch'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="enum" field="status" width='37.5%'  >
{if !$fields.status.hidden}
{counter name="panelFieldCount"}


{if is_string($fields.status.options)}
<input type="hidden" class="sugar_field" id="{$fields.status.name}" value="{ $fields.status.options }">
{ $fields.status.options }
{else}
<input type="hidden" class="sugar_field" id="{$fields.status.name}" value="{ $fields.status.value }">
{ $fields.status.options[$fields.status.value]}
{/if}
{/if}
<div class="inlineEditIcon"> {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}</div>			</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.result.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_RESULT' module='te_student_batch'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="enum" field="result" width='37.5%'  >
{if !$fields.result.hidden}
{counter name="panelFieldCount"}


{if is_string($fields.result.options)}
<input type="hidden" class="sugar_field" id="{$fields.result.name}" value="{ $fields.result.options }">
{ $fields.result.options }
{else}
<input type="hidden" class="sugar_field" id="{$fields.result.name}" value="{ $fields.result.value }">
{ $fields.result.options[$fields.result.value]}
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
{if !$fields.eligible_for_certificate.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_ELIGIBLE_FOR_CERTIFICATE' module='te_student_batch'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="enum" field="eligible_for_certificate" width='37.5%'  >
{if !$fields.eligible_for_certificate.hidden}
{counter name="panelFieldCount"}


{if is_string($fields.eligible_for_certificate.options)}
<input type="hidden" class="sugar_field" id="{$fields.eligible_for_certificate.name}" value="{ $fields.eligible_for_certificate.options }">
{ $fields.eligible_for_certificate.options }
{else}
<input type="hidden" class="sugar_field" id="{$fields.eligible_for_certificate.name}" value="{ $fields.eligible_for_certificate.value }">
{ $fields.eligible_for_certificate.options[$fields.eligible_for_certificate.value]}
{/if}
{/if}
<div class="inlineEditIcon"> {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}</div>			</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.assessment_mode.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_ASSESSMENT_MODE' module='te_student_batch'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="enum" field="assessment_mode" width='37.5%'  >
{if !$fields.assessment_mode.hidden}
{counter name="panelFieldCount"}


{if is_string($fields.assessment_mode.options)}
<input type="hidden" class="sugar_field" id="{$fields.assessment_mode.name}" value="{ $fields.assessment_mode.options }">
{ $fields.assessment_mode.options }
{else}
<input type="hidden" class="sugar_field" id="{$fields.assessment_mode.name}" value="{ $fields.assessment_mode.value }">
{ $fields.assessment_mode.options[$fields.assessment_mode.value]}
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
{if !$fields.actual_attendance.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_ACTUAL_ATTENDANCE' module='te_student_batch'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="int" field="actual_attendance" width='37.5%'  >
{if !$fields.actual_attendance.hidden}
{counter name="panelFieldCount"}

<span class="sugar_field" id="{$fields.actual_attendance.name}">
{sugar_number_format precision=0 var=$fields.actual_attendance.value}
</span>
{/if}
<div class="inlineEditIcon"> {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}</div>			</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.feedback_given.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_FEEDBACH_GIVEN' module='te_student_batch'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="enum" field="feedback_given" width='37.5%'  >
{if !$fields.feedback_given.hidden}
{counter name="panelFieldCount"}


{if is_string($fields.feedback_given.options)}
<input type="hidden" class="sugar_field" id="{$fields.feedback_given.name}" value="{ $fields.feedback_given.options }">
{ $fields.feedback_given.options }
{else}
<input type="hidden" class="sugar_field" id="{$fields.feedback_given.name}" value="{ $fields.feedback_given.value }">
{ $fields.feedback_given.options[$fields.feedback_given.value]}
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
{if !$fields.Assessment_center_lcocation_preference.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_ASSESSMENT_CENTER_LOCATION_PREFERENCE' module='te_student_batch'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="varchar" field="Assessment_center_lcocation_preference" width='37.5%'  >
{if !$fields.Assessment_center_lcocation_preference.hidden}
{counter name="panelFieldCount"}

{if strlen($fields.Assessment_center_lcocation_preference.value) <= 0}
{assign var="value" value=$fields.Assessment_center_lcocation_preference.default_value }
{else}
{assign var="value" value=$fields.Assessment_center_lcocation_preference.value }
{/if} 
<span class="sugar_field" id="{$fields.Assessment_center_lcocation_preference.name}">{$fields.Assessment_center_lcocation_preference.value}</span>
{/if}
<div class="inlineEditIcon"> {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}</div>			</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.total_session_required.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_TOTAL_SESSION_REQUIRED' module='te_student_batch'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="int" field="total_session_required" width='37.5%'  >
{if !$fields.total_session_required.hidden}
{counter name="panelFieldCount"}

<span class="sugar_field" id="{$fields.total_session_required.name}">
{sugar_number_format precision=0 var=$fields.total_session_required.value}
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
{if !$fields.channel.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_CHANNEL' module='te_student_batch'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="varchar" field="channel" width='37.5%'  >
{if !$fields.channel.hidden}
{counter name="panelFieldCount"}

{if strlen($fields.channel.value) <= 0}
{assign var="value" value=$fields.channel.default_value }
{else}
{assign var="value" value=$fields.channel.value }
{/if} 
<span class="sugar_field" id="{$fields.channel.name}">{$fields.channel.value}</span>
{/if}
<div class="inlineEditIcon"> {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}</div>			</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.completion_certificate_address.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_COMPLETION_CERTIFICATE_ADDRESS' module='te_student_batch'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="text" field="completion_certificate_address" width='37.5%'  >
{if !$fields.completion_certificate_address.hidden}
{counter name="panelFieldCount"}

<span class="sugar_field" id="{$fields.completion_certificate_address.name|escape:'html'|url2html|nl2br}">{$fields.completion_certificate_address.value|escape:'html'|escape:'html_entity_decode'|url2html|nl2br}</span>
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
{if !$fields.assigned_user_name.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_ASSIGNED_TO_NAME' module='te_student_batch'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="relate" field="assigned_user_name" width='37.5%'  >
{if !$fields.assigned_user_name.hidden}
{counter name="panelFieldCount"}

<span id="assigned_user_id" class="sugar_field" data-id-value="{$fields.assigned_user_id.value}">{$fields.assigned_user_name.value}</span>
{/if}
<div class="inlineEditIcon"> {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}</div>			</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.description.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_DESCRIPTION' module='te_student_batch'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="text" field="description" width='37.5%'  >
{if !$fields.description.hidden}
{counter name="panelFieldCount"}

<span class="sugar_field" id="{$fields.description.name|escape:'html'|url2html|nl2br}">{$fields.description.value|escape:'html'|escape:'html_entity_decode'|url2html|nl2br}</span>
{/if}
<div class="inlineEditIcon"> {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}</div>			</td>
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
<div id='detailpanel_2' class='detail view  detail508 expanded'>
{counter name="panelFieldCount" start=0 print=false assign="panelFieldCount"}
<h4>
<a href="javascript:void(0)" class="collapseLink" onclick="collapsePanel(2);">
<img border="0" id="detailpanel_2_img_hide" src="{sugar_getimagepath file="basic_search.gif"}"></a>
<a href="javascript:void(0)" class="expandLink" onclick="expandPanel(2);">
<img border="0" id="detailpanel_2_img_show" src="{sugar_getimagepath file="advanced_search.gif"}"></a>
{sugar_translate label='LBL_EDITVIEW_PANEL1' module='te_student_batch'}
<script>
      document.getElementById('detailpanel_2').className += ' expanded';
    </script>
</h4>
<!-- PANEL CONTAINER HERE.. -->
<table id='LBL_EDITVIEW_PANEL1' class="panelContainer" cellspacing='{$gridline}'>
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{counter name="fieldsHidden" start=0 print=false assign="fieldsHidden"}
{capture name="tr" assign="tableRow"}
<tr>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.dropout_type.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_DROPOUT_TYPE' module='te_student_batch'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="enum" field="dropout_type" width='37.5%'  >
{if !$fields.dropout_type.hidden}
{counter name="panelFieldCount"}


{if is_string($fields.dropout_type.options)}
<input type="hidden" class="sugar_field" id="{$fields.dropout_type.name}" value="{ $fields.dropout_type.options }">
{ $fields.dropout_type.options }
{else}
<input type="hidden" class="sugar_field" id="{$fields.dropout_type.name}" value="{ $fields.dropout_type.value }">
{ $fields.dropout_type.options[$fields.dropout_type.value]}
{/if}
{/if}
<div class="inlineEditIcon"> {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}</div>			</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.qualify_for_refund.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_QUALIFY_FOR_REFUND' module='te_student_batch'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="enum" field="qualify_for_refund" width='37.5%'  >
{if !$fields.qualify_for_refund.hidden}
{counter name="panelFieldCount"}


{if is_string($fields.qualify_for_refund.options)}
<input type="hidden" class="sugar_field" id="{$fields.qualify_for_refund.name}" value="{ $fields.qualify_for_refund.options }">
{ $fields.qualify_for_refund.options }
{else}
<input type="hidden" class="sugar_field" id="{$fields.qualify_for_refund.name}" value="{ $fields.qualify_for_refund.value }">
{ $fields.qualify_for_refund.options[$fields.qualify_for_refund.value]}
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
{if !$fields.refund_request_date.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_REFUND_REQUEST_DATE' module='te_student_batch'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="date" field="refund_request_date" width='37.5%'  >
{if !$fields.refund_request_date.hidden}
{counter name="panelFieldCount"}


{if strlen($fields.refund_request_date.value) <= 0}
{assign var="value" value=$fields.refund_request_date.default_value }
{else}
{assign var="value" value=$fields.refund_request_date.value }
{/if}
<span class="sugar_field" id="{$fields.refund_request_date.name}">{$value}</span>
{/if}
<div class="inlineEditIcon"> {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}</div>			</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.refund_amount.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_REFUND_AMOUNT' module='te_student_batch'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="int" field="refund_amount" width='37.5%'  >
{if !$fields.refund_amount.hidden}
{counter name="panelFieldCount"}

<span class="sugar_field" id="{$fields.refund_amount.name}">
{sugar_number_format precision=0 var=$fields.refund_amount.value}
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
{if !$fields.refund_date.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_REFUND_DATE' module='te_student_batch'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="date" field="refund_date" width='37.5%'  >
{if !$fields.refund_date.hidden}
{counter name="panelFieldCount"}


{if strlen($fields.refund_date.value) <= 0}
{assign var="value" value=$fields.refund_date.default_value }
{else}
{assign var="value" value=$fields.refund_date.value }
{/if}
<span class="sugar_field" id="{$fields.refund_date.name}">{$value}</span>
{/if}
<div class="inlineEditIcon"> {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}</div>			</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.dropout_status.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_DROPOUT_STATUS' module='te_student_batch'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="enum" field="dropout_status" width='37.5%'  >
{if !$fields.dropout_status.hidden}
{counter name="panelFieldCount"}


{if is_string($fields.dropout_status.options)}
<input type="hidden" class="sugar_field" id="{$fields.dropout_status.name}" value="{ $fields.dropout_status.options }">
{ $fields.dropout_status.options }
{else}
<input type="hidden" class="sugar_field" id="{$fields.dropout_status.name}" value="{ $fields.dropout_status.value }">
{ $fields.dropout_status.options[$fields.dropout_status.value]}
{/if}
{/if}
<div class="inlineEditIcon"> {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}</div>			</td>
</tr>
{/capture}
{if $fieldsUsed > 0 && $fieldsUsed != $fieldsHidden}
{$tableRow}
{/if}
</table>
<script type="text/javascript">SUGAR.util.doWhen("typeof initPanel == 'function'", function() {ldelim} initPanel(2, 'expanded'); {rdelim}); </script>
</div>
{if $panelFieldCount == 0}
<script>document.getElementById("LBL_EDITVIEW_PANEL1").style.display='none';</script>
{/if}
</div>
</div>

</form>
<script>SUGAR.util.doWhen("document.getElementById('form') != null",
        function(){ldelim}SUGAR.util.buildAccessKeyLabels();{rdelim});
</script><script type="text/javascript" src="include/InlineEditing/inlineEditing.js"></script>
<script type="text/javascript" src="modules/Favorites/favorites.js"></script>