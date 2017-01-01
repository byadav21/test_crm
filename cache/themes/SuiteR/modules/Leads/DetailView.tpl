

{assign var=preForm value="<table width='100%' border='1' cellspacing='0' cellpadding='0' class='converted_account'><tr><td><table width='100%'><tr><td>"}
{assign var=displayPreform value=false}
{if isset($bean->contact_id) && !empty($bean->contact_id)}
{assign var=displayPreform value=true}
{assign var=preForm value=$preForm|cat:$MOD.LBL_CONVERTED_CONTACT}
{assign var=preForm value=$preForm|cat:"&nbsp;<a href='index.php?module=Contacts&action=DetailView&record="}
{assign var=preForm value=$preForm|cat:$bean->contact_id}
{assign var=preForm value=$preForm|cat:"'>"}
{assign var=preForm value=$preForm|cat:$bean->contact_name}
{assign var=preForm value=$preForm|cat:"</a>"}
{/if}
{assign var=preForm value=$preForm|cat:"</td><td>"}
{if isset($bean->account_id) && !empty($bean->account_id)}
{assign var=displayPreform value=true}
{assign var=preForm value=$preForm|cat:$MOD.LBL_CONVERTED_ACCOUNT}
{assign var=preForm value=$preForm|cat:"&nbsp;<a href='index.php?module=Accounts&action=DetailView&record="}
{assign var=preForm value=$preForm|cat:$bean->account_id}
{assign var=preForm value=$preForm|cat:"'>"}
{assign var=preForm value=$preForm|cat:$bean->account_name}
{assign var=preForm value=$preForm|cat:"</a>"}
{/if}
{assign var=preForm value=$preForm|cat:"</td><td>"}
{if isset($bean->opportunity_id) && !empty($bean->opportunity_id)}
{assign var=displayPreform value=true}
{assign var=preForm value=$preForm|cat:$MOD.LBL_CONVERTED_OPP}
{assign var=preForm value=$preForm|cat:"&nbsp;<a href='index.php?module=Opportunities&action=DetailView&record="}
{assign var=preForm value=$preForm|cat:$bean->opportunity_id}
{assign var=preForm value=$preForm|cat:"'>"}
{assign var=preForm value=$preForm|cat:$bean->opportunity_name}
{assign var=preForm value=$preForm|cat:"</a>"}
{/if}
{assign var=preForm value=$preForm|cat:"</td></tr></table></td></tr></table>"}
{if $displayPreform}
{$preForm}
<br>
{/if}

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
<ul id="detail_header_action_menu" class="clickMenu fancymenu" ><li class="sugar_action_button" >{if $bean->aclAccess("edit")}<input title="{$APP.LBL_EDIT_BUTTON_TITLE}" accessKey="{$APP.LBL_EDIT_BUTTON_KEY}" class="button primary" onclick="var _form = document.getElementById('formDetailView'); _form.return_module.value='Leads'; _form.return_action.value='DetailView'; _form.return_id.value='{$id}'; _form.action.value='EditView';SUGAR.ajaxUI.submitForm(_form);" type="button" name="Edit" id="edit_button" value="{$APP.LBL_EDIT_BUTTON_LABEL}">{/if} <ul id class="subnav" ><li>{if $bean->aclAccess("edit")}<input title="{$APP.LBL_DUPLICATE_BUTTON_TITLE}" accessKey="{$APP.LBL_DUPLICATE_BUTTON_KEY}" class="button" onclick="var _form = document.getElementById('formDetailView'); _form.return_module.value='Leads'; _form.return_action.value='DetailView'; _form.isDuplicate.value=true; _form.action.value='EditView'; _form.return_id.value='{$id}';SUGAR.ajaxUI.submitForm(_form);" type="button" name="Duplicate" value="{$APP.LBL_DUPLICATE_BUTTON_LABEL}" id="duplicate_button">{/if} </li><li>{if $bean->aclAccess("delete")}<input title="{$APP.LBL_DELETE_BUTTON_TITLE}" accessKey="{$APP.LBL_DELETE_BUTTON_KEY}" class="button" onclick="var _form = document.getElementById('formDetailView'); _form.return_module.value='Leads'; _form.return_action.value='ListView'; _form.action.value='Delete'; if(confirm('{$APP.NTC_DELETE_CONFIRMATION}')) SUGAR.ajaxUI.submitForm(_form);" type="submit" name="Delete" value="{$APP.LBL_DELETE_BUTTON_LABEL}" id="delete_button">{/if} </li><li>{if $bean->aclAccess("edit") && $bean->aclAccess("delete")}<input title="{$APP.LBL_DUP_MERGE}" class="button" onclick="var _form = document.getElementById('formDetailView'); _form.return_module.value='Leads'; _form.return_action.value='DetailView'; _form.return_id.value='{$id}'; _form.action.value='Step1'; _form.module.value='MergeRecords';SUGAR.ajaxUI.submitForm(_form);" type="button" name="Merge" value="{$APP.LBL_DUP_MERGE}" id="merge_duplicate_button">{/if} </li><li><input title="{$APP.LBL_MANAGE_SUBSCRIPTIONS}" class="button" id="manage_subscriptions_button" onclick="var _form = document.getElementById('formDetailView');_form.return_module.value='Leads'; _form.return_action.value='DetailView';_form.return_id.value='{$fields.id.value}'; _form.action.value='Subscriptions'; _form.module.value='Campaigns'; _form.module_tab.value='Leads';_form.submit();" name="{$APP.LBL_MANAGE_SUBSCRIPTIONS}" type="button" value="{$APP.LBL_MANAGE_SUBSCRIPTIONS}"/></li><li><input type="button" class="button" onClick="showPopup();" value="{$APP.LBL_GENERATE_LETTER}"/></li><li>{if $bean->aclAccess("detail")}{if !empty($fields.id.value) && $isAuditEnabled}<input id="btn_view_change_log" title="{$APP.LNK_VIEW_CHANGE_LOG}" class="button" onclick='open_popup("Audit", "600", "400", "&record={$fields.id.value}&module_name=Leads", true, false,  {ldelim} "call_back_function":"set_return","form_name":"EditView","field_to_name_array":[] {rdelim} ); return false;' type="button" value="{$APP.LNK_VIEW_CHANGE_LOG}">{/if}{/if}</li></ul></li></ul>
</div>
</td>
<td align="right" width="20%">{$ADMIN_EDIT}
{$PAGINATION}
</td>
</tr>
</table>{sugar_include include=$includes}
<div id="Leads_detailview_tabs"
>
<div >
<div id='detailpanel_1' class='detail view  detail508 expanded'>
{counter name="panelFieldCount" start=0 print=false assign="panelFieldCount"}
<h4>
<a href="javascript:void(0)" class="collapseLink" onclick="collapsePanel(1);">
<img border="0" id="detailpanel_1_img_hide" src="{sugar_getimagepath file="basic_search.gif"}"></a>
<a href="javascript:void(0)" class="expandLink" onclick="expandPanel(1);">
<img border="0" id="detailpanel_1_img_show" src="{sugar_getimagepath file="advanced_search.gif"}"></a>
{sugar_translate label='LBL_CONTACT_INFORMATION' module='Leads'}
<script>
      document.getElementById('detailpanel_1').className += ' expanded';
    </script>
</h4>
<!-- PANEL CONTAINER HERE.. -->
<table id='LBL_CONTACT_INFORMATION' class="panelContainer" cellspacing='{$gridline}'>
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{counter name="fieldsHidden" start=0 print=false assign="fieldsHidden"}
{capture name="tr" assign="tableRow"}
<tr>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.first_name.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_FIRST_NAME' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="varchar" field="first_name" width='37.5%'  >
{if !$fields.first_name.hidden}
{counter name="panelFieldCount"}

{if strlen($fields.first_name.value) <= 0}
{assign var="value" value=$fields.first_name.default_value }
{else}
{assign var="value" value=$fields.first_name.value }
{/if} 
<span class="sugar_field" id="{$fields.first_name.name}">{$fields.first_name.value}</span>
{/if}
<div class="inlineEditIcon"> {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}</div>			</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.last_name.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_LAST_NAME' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="varchar" field="last_name" width='37.5%'  >
{if !$fields.last_name.hidden}
{counter name="panelFieldCount"}

{if strlen($fields.last_name.value) <= 0}
{assign var="value" value=$fields.last_name.default_value }
{else}
{assign var="value" value=$fields.last_name.value }
{/if} 
<span class="sugar_field" id="{$fields.last_name.name}">{$fields.last_name.value}</span>
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
{if !$fields.email1.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_EMAIL_ADDRESS' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="varchar" field="email1" width='37.5%'  >
{if !$fields.email1.hidden}
{counter name="panelFieldCount"}
<span id='email1_span'>
{$fields.email1.value}
</span>
{/if}
<div class="inlineEditIcon"> {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}</div>			</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.phone_mobile.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_MOBILE_PHONE' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="" type="phone" field="phone_mobile" width='37.5%'  class="phone">
{if !$fields.phone_mobile.hidden}
{counter name="panelFieldCount"}

{if !empty($fields.phone_mobile.value)}
{assign var="phone_value" value=$fields.phone_mobile.value }
{sugar_phone value=$phone_value usa_format="0"}
{/if}
{/if}
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
{if !$fields.min_attendance_c.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_MIN_ATTENDANCE' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="varchar" field="min_attendance_c" width='37.5%'  >
{if !$fields.min_attendance_c.hidden}
{counter name="panelFieldCount"}

{if strlen($fields.min_attendance_c.value) <= 0}
{assign var="value" value=$fields.min_attendance_c.default_value }
{else}
{assign var="value" value=$fields.min_attendance_c.value }
{/if} 
<span class="sugar_field" id="{$fields.min_attendance_c.name}">{$fields.min_attendance_c.value}</span>
{/if}
<div class="inlineEditIcon"> {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}</div>			</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.phone_other.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_MOBILE_TWO' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="" type="phone" field="phone_other" width='37.5%'  class="phone">
{if !$fields.phone_other.hidden}
{counter name="panelFieldCount"}

{if !empty($fields.phone_other.value)}
{assign var="phone_value" value=$fields.phone_other.value }
{sugar_phone value=$phone_value usa_format="0"}
{/if}
{/if}
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
{if !$fields.batch_c.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_BATCH' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="relate" field="batch_c" width='37.5%'  >
{if !$fields.batch_c.hidden}
{counter name="panelFieldCount"}

{if !empty($fields.te_ba_batch_id_c.value)}
{capture assign="detail_url"}index.php?module=te_ba_Batch&action=DetailView&record={$fields.te_ba_batch_id_c.value}{/capture}
<a href="{sugar_ajax_url url=$detail_url}">{/if}
<span id="te_ba_batch_id_c" class="sugar_field" data-id-value="{$fields.te_ba_batch_id_c.value}">{$fields.batch_c.value}</span>
{if !empty($fields.te_ba_batch_id_c.value)}</a>{/if}
{/if}
<div class="inlineEditIcon"> {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}</div>			</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.assigned_user_name.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_ASSIGNED_TO' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="relate" field="assigned_user_name" width='37.5%'  >
{if !$fields.assigned_user_name.hidden}
{counter name="panelFieldCount"}

<span id="assigned_user_id" class="sugar_field" data-id-value="{$fields.assigned_user_id.value}">{$fields.assigned_user_name.value}</span>
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
{if !$fields.comment.hidden}
{capture name="label" assign="label"}{sugar_translate label='COMMENT' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="text" field="comment" width='37.5%'  >
{if !$fields.comment.hidden}
{counter name="panelFieldCount"}

<span class="sugar_field" id="{$fields.comment.name|escape:'html'|url2html|nl2br}">{$fields.comment.value|escape:'html'|escape:'html_entity_decode'|url2html|nl2br}</span>
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
{if !$fields.program.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_PROGRAM' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="varchar" field="program" width='37.5%'  >
{if !$fields.program.hidden}
{counter name="panelFieldCount"}

{if strlen($fields.program.value) <= 0}
{assign var="value" value=$fields.program.default_value }
{else}
{assign var="value" value=$fields.program.value }
{/if} 
<span class="sugar_field" id="{$fields.program.name}">{$fields.program.value}</span>
{/if}
<div class="inlineEditIcon"> {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}</div>			</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.institute.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_INSTITUTE' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="varchar" field="institute" width='37.5%'  >
{if !$fields.institute.hidden}
{counter name="panelFieldCount"}

{if strlen($fields.institute.value) <= 0}
{assign var="value" value=$fields.institute.default_value }
{else}
{assign var="value" value=$fields.institute.value }
{/if} 
<span class="sugar_field" id="{$fields.institute.name}">{$fields.institute.value}</span>
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
{if !$fields.primary_address_city.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_CITY' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="varchar" field="primary_address_city" width='37.5%'  >
{if !$fields.primary_address_city.hidden}
{counter name="panelFieldCount"}

{if strlen($fields.primary_address_city.value) <= 0}
{assign var="value" value=$fields.primary_address_city.default_value }
{else}
{assign var="value" value=$fields.primary_address_city.value }
{/if} 
<span class="sugar_field" id="{$fields.primary_address_city.name}">{$fields.primary_address_city.value}</span>
{/if}
<div class="inlineEditIcon"> {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}</div>			</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.primary_address_state.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_STATE' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="varchar" field="primary_address_state" width='37.5%'  >
{if !$fields.primary_address_state.hidden}
{counter name="panelFieldCount"}

{if strlen($fields.primary_address_state.value) <= 0}
{assign var="value" value=$fields.primary_address_state.default_value }
{else}
{assign var="value" value=$fields.primary_address_state.value }
{/if} 
<span class="sugar_field" id="{$fields.primary_address_state.name}">{$fields.primary_address_state.value}</span>
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
{if !$fields.primary_address_country.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_COUNTRY' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="varchar" field="primary_address_country" width='37.5%'  >
{if !$fields.primary_address_country.hidden}
{counter name="panelFieldCount"}

{if strlen($fields.primary_address_country.value) <= 0}
{assign var="value" value=$fields.primary_address_country.default_value }
{else}
{assign var="value" value=$fields.primary_address_country.value }
{/if} 
<span class="sugar_field" id="{$fields.primary_address_country.name}">{$fields.primary_address_country.value}</span>
{/if}
<div class="inlineEditIcon"> {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}</div>			</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.birthdate.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_BIRTHDATE' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="date" field="birthdate" width='37.5%'  >
{if !$fields.birthdate.hidden}
{counter name="panelFieldCount"}


{if strlen($fields.birthdate.value) <= 0}
{assign var="value" value=$fields.birthdate.default_value }
{else}
{assign var="value" value=$fields.birthdate.value }
{/if}
<span class="sugar_field" id="{$fields.birthdate.name}">{$value}</span>
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
{if !$fields.gender.hidden}
{capture name="label" assign="label"}{sugar_translate label='Gender' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="enum" field="gender" width='37.5%' colspan='3' >
{if !$fields.gender.hidden}
{counter name="panelFieldCount"}


{if is_string($fields.gender.options)}
<input type="hidden" class="sugar_field" id="{$fields.gender.name}" value="{ $fields.gender.options }">
{ $fields.gender.options }
{else}
<input type="hidden" class="sugar_field" id="{$fields.gender.name}" value="{ $fields.gender.value }">
{ $fields.gender.options[$fields.gender.value]}
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
{if !$fields.lead_source.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_LEAD_SOURCE' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="enum" field="lead_source" width='37.5%'  >
{if !$fields.lead_source.hidden}
{counter name="panelFieldCount"}


{if is_string($fields.lead_source.options)}
<input type="hidden" class="sugar_field" id="{$fields.lead_source.name}" value="{ $fields.lead_source.options }">
{ $fields.lead_source.options }
{else}
<input type="hidden" class="sugar_field" id="{$fields.lead_source.name}" value="{ $fields.lead_source.value }">
{ $fields.lead_source.options[$fields.lead_source.value]}
{/if}
{/if}
<div class="inlineEditIcon"> {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}</div>			</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.leads_leads_1_name.hidden}
{capture name="label" assign="label"}{sugar_translate label='Referral Lead' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="relate" field="leads_leads_1_name" width='37.5%'  >
{if !$fields.leads_leads_1_name.hidden}
{counter name="panelFieldCount"}

{if !empty($fields.leads_leads_1leads_ida.value)}
{capture assign="detail_url"}index.php?module=Leads&action=DetailView&record={$fields.leads_leads_1leads_ida.value}{/capture}
<a href="{sugar_ajax_url url=$detail_url}">{/if}
<span id="leads_leads_1leads_ida" class="sugar_field" data-id-value="{$fields.leads_leads_1leads_ida.value}">{$fields.leads_leads_1_name.value}</span>
{if !empty($fields.leads_leads_1leads_ida.value)}</a>{/if}
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
{if !$fields.company_c.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_COMPANY' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="varchar" field="company_c" width='37.5%'  >
{if !$fields.company_c.hidden}
{counter name="panelFieldCount"}

{if strlen($fields.company_c.value) <= 0}
{assign var="value" value=$fields.company_c.default_value }
{else}
{assign var="value" value=$fields.company_c.value }
{/if} 
<span class="sugar_field" id="{$fields.company_c.name}">{$fields.company_c.value}</span>
{/if}
<div class="inlineEditIcon"> {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}</div>			</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.functional_area_c.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_FUNCTIONAL_AREA' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="varchar" field="functional_area_c" width='37.5%'  >
{if !$fields.functional_area_c.hidden}
{counter name="panelFieldCount"}

{if strlen($fields.functional_area_c.value) <= 0}
{assign var="value" value=$fields.functional_area_c.default_value }
{else}
{assign var="value" value=$fields.functional_area_c.value }
{/if} 
<span class="sugar_field" id="{$fields.functional_area_c.name}">{$fields.functional_area_c.value}</span>
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
{if !$fields.work_experience_c.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_WORK_EXPERIENCE' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="varchar" field="work_experience_c" width='37.5%'  >
{if !$fields.work_experience_c.hidden}
{counter name="panelFieldCount"}

{if strlen($fields.work_experience_c.value) <= 0}
{assign var="value" value=$fields.work_experience_c.default_value }
{else}
{assign var="value" value=$fields.work_experience_c.value }
{/if} 
<span class="sugar_field" id="{$fields.work_experience_c.name}">{$fields.work_experience_c.value}</span>
{/if}
<div class="inlineEditIcon"> {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}</div>			</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.education_c.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_EDUCATION' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="varchar" field="education_c" width='37.5%'  >
{if !$fields.education_c.hidden}
{counter name="panelFieldCount"}

{if strlen($fields.education_c.value) <= 0}
{assign var="value" value=$fields.education_c.default_value }
{else}
{assign var="value" value=$fields.education_c.value }
{/if} 
<span class="sugar_field" id="{$fields.education_c.name}">{$fields.education_c.value}</span>
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
&nbsp;
</td>
<td class="" type="" field="" width='37.5%'  >
</td>
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
<script type="text/javascript">SUGAR.util.doWhen("typeof initPanel == 'function'", function() {ldelim} initPanel(1, 'expanded'); {rdelim}); </script>
</div>
{if $panelFieldCount == 0}
<script>document.getElementById("LBL_CONTACT_INFORMATION").style.display='none';</script>
{/if}
</div>
</div>

</form>
<script>SUGAR.util.doWhen("document.getElementById('form') != null",
        function(){ldelim}SUGAR.util.buildAccessKeyLabels();{rdelim});
</script><script type="text/javascript" src="include/InlineEditing/inlineEditing.js"></script>
<script type="text/javascript" src="modules/Favorites/favorites.js"></script>