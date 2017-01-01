

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
<ul id="detail_header_action_menu" class="clickMenu fancymenu" ><li class="sugar_action_button" >{if $bean->aclAccess("edit")}<input title="{$APP.LBL_EDIT_BUTTON_TITLE}" accessKey="{$APP.LBL_EDIT_BUTTON_KEY}" class="button primary" onclick="var _form = document.getElementById('formDetailView'); _form.return_module.value='te_utm'; _form.return_action.value='DetailView'; _form.return_id.value='{$id}'; _form.action.value='EditView';SUGAR.ajaxUI.submitForm(_form);" type="button" name="Edit" id="edit_button" value="{$APP.LBL_EDIT_BUTTON_LABEL}">{/if} <ul id class="subnav" ><li>{if $bean->aclAccess("edit")}<input title="{$APP.LBL_DUPLICATE_BUTTON_TITLE}" accessKey="{$APP.LBL_DUPLICATE_BUTTON_KEY}" class="button" onclick="var _form = document.getElementById('formDetailView'); _form.return_module.value='te_utm'; _form.return_action.value='DetailView'; _form.isDuplicate.value=true; _form.action.value='EditView'; _form.return_id.value='{$id}';SUGAR.ajaxUI.submitForm(_form);" type="button" name="Duplicate" value="{$APP.LBL_DUPLICATE_BUTTON_LABEL}" id="duplicate_button">{/if} </li><li>{if $bean->aclAccess("delete")}<input title="{$APP.LBL_DELETE_BUTTON_TITLE}" accessKey="{$APP.LBL_DELETE_BUTTON_KEY}" class="button" onclick="var _form = document.getElementById('formDetailView'); _form.return_module.value='te_utm'; _form.return_action.value='ListView'; _form.action.value='Delete'; if(confirm('{$APP.NTC_DELETE_CONFIRMATION}')) SUGAR.ajaxUI.submitForm(_form);" type="submit" name="Delete" value="{$APP.LBL_DELETE_BUTTON_LABEL}" id="delete_button">{/if} </li><li>{if $bean->aclAccess("edit") && $bean->aclAccess("delete")}<input title="{$APP.LBL_DUP_MERGE}" class="button" onclick="var _form = document.getElementById('formDetailView'); _form.return_module.value='te_utm'; _form.return_action.value='DetailView'; _form.return_id.value='{$id}'; _form.action.value='Step1'; _form.module.value='MergeRecords';SUGAR.ajaxUI.submitForm(_form);" type="button" name="Merge" value="{$APP.LBL_DUP_MERGE}" id="merge_duplicate_button">{/if} </li><li><input class="button" type="button" name="expire_button" value="Mark as Expired" onclick="var _form = document.getElementById('formDetailView'); var _onclick=(function(){ldelim}return makeExpire(_form);{rdelim}()); if(_onclick!==false) _form.submit();"/></li><li>{if $bean->aclAccess("detail")}{if !empty($fields.id.value) && $isAuditEnabled}<input id="btn_view_change_log" title="{$APP.LNK_VIEW_CHANGE_LOG}" class="button" onclick='open_popup("Audit", "600", "400", "&record={$fields.id.value}&module_name=te_utm", true, false,  {ldelim} "call_back_function":"set_return","form_name":"EditView","field_to_name_array":[] {rdelim} ); return false;' type="button" value="{$APP.LNK_VIEW_CHANGE_LOG}">{/if}{/if}</li></ul></li></ul>
</div>
</td>
<td align="right" width="20%">{$ADMIN_EDIT}
{$PAGINATION}
</td>
</tr>
</table>{sugar_include include=$includes}
<div id="te_utm_detailview_tabs"
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
{if !$fields.name.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_NAME' module='te_utm'}{/capture}
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
{if !$fields.te_vendor_te_utm_1_name.hidden}
{capture name="label" assign="label"}{sugar_translate label='UTM Source' module='te_utm'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="relate" field="te_vendor_te_utm_1_name" width='37.5%'  >
{if !$fields.te_vendor_te_utm_1_name.hidden}
{counter name="panelFieldCount"}

{if !empty($fields.te_vendor_te_utm_1te_vendor_ida.value)}
{capture assign="detail_url"}index.php?module=te_vendor&action=DetailView&record={$fields.te_vendor_te_utm_1te_vendor_ida.value}{/capture}
<a href="{sugar_ajax_url url=$detail_url}">{/if}
<span id="te_vendor_te_utm_1te_vendor_ida" class="sugar_field" data-id-value="{$fields.te_vendor_te_utm_1te_vendor_ida.value}">{$fields.te_vendor_te_utm_1_name.value}</span>
{if !empty($fields.te_vendor_te_utm_1te_vendor_ida.value)}</a>{/if}
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
{if !$fields.contract.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_CONTRACT' module='te_utm'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="relate" field="contract" width='37.5%'  >
{if !$fields.contract.hidden}
{counter name="panelFieldCount"}

{if !empty($fields.aos_contracts_id_c.value)}
{capture assign="detail_url"}index.php?module=AOS_Contracts&action=DetailView&record={$fields.aos_contracts_id_c.value}{/capture}
<a href="{sugar_ajax_url url=$detail_url}">{/if}
<span id="aos_contracts_id_c" class="sugar_field" data-id-value="{$fields.aos_contracts_id_c.value}">{$fields.contract.value}</span>
{if !empty($fields.aos_contracts_id_c.value)}</a>{/if}
{/if}
<div class="inlineEditIcon"> {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}</div>			</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.utm_campaign.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_UTM_CAMPAIGN' module='te_utm'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="varchar" field="utm_campaign" width='37.5%'  >
{if !$fields.utm_campaign.hidden}
{counter name="panelFieldCount"}

{if strlen($fields.utm_campaign.value) <= 0}
{assign var="value" value=$fields.utm_campaign.default_value }
{else}
{assign var="value" value=$fields.utm_campaign.value }
{/if} 
<span class="sugar_field" id="{$fields.utm_campaign.name}">{$fields.utm_campaign.value}</span>
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
{if !$fields.batch.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_BATCH' module='te_utm'}{/capture}
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
{if !$fields.utm_status.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_UTM_STATUS' module='te_utm'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="enum" field="utm_status" width='37.5%'  >
{if !$fields.utm_status.hidden}
{counter name="panelFieldCount"}


{if is_string($fields.utm_status.options)}
<input type="hidden" class="sugar_field" id="{$fields.utm_status.name}" value="{ $fields.utm_status.options }">
{ $fields.utm_status.options }
{else}
<input type="hidden" class="sugar_field" id="{$fields.utm_status.name}" value="{ $fields.utm_status.value }">
{ $fields.utm_status.options[$fields.utm_status.value]}
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
{if !$fields.description.hidden}
{capture name="label" assign="label"}{sugar_translate label='Notes' module='te_utm'}{/capture}
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
{if !$fields.date_entered.hidden}
{capture name="label" assign="label"}{sugar_translate label='Created On' module='te_utm'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="" type="datetime" field="date_entered" width='37.5%'  >
{if !$fields.date_entered.hidden}
{counter name="panelFieldCount"}


{if strlen($fields.date_entered.value) <= 0}
{assign var="value" value=$fields.date_entered.default_value }
{else}
{assign var="value" value=$fields.date_entered.value }
{/if}
<span class="sugar_field" id="{$fields.date_entered.name}">{$value}</span>
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
{if !$fields.live_on.hidden}
{capture name="label" assign="label"}{sugar_translate label='Live On' module='te_utm'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="date" field="live_on" width='37.5%'  >
{if !$fields.live_on.hidden}
{counter name="panelFieldCount"}


{if strlen($fields.live_on.value) <= 0}
{assign var="value" value=$fields.live_on.default_value }
{else}
{assign var="value" value=$fields.live_on.value }
{/if}
<span class="sugar_field" id="{$fields.live_on.name}">{$value}</span>
{/if}
<div class="inlineEditIcon"> {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}</div>			</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.utm_url.hidden}
{capture name="label" assign="label"}{sugar_translate label='URL' module='te_utm'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="inlineEdit" type="varchar" field="utm_url" width='37.5%'  >
{if !$fields.utm_url.hidden}
{counter name="panelFieldCount"}

{if strlen($fields.utm_url.value) <= 0}
{assign var="value" value=$fields.utm_url.default_value }
{else}
{assign var="value" value=$fields.utm_url.value }
{/if} 
<span class="sugar_field" id="{$fields.utm_url.name}">{$fields.utm_url.value}</span>
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
</div>
</div>

</form>
<script>SUGAR.util.doWhen("document.getElementById('form') != null",
        function(){ldelim}SUGAR.util.buildAccessKeyLabels();{rdelim});
</script><script type="text/javascript" src="include/InlineEditing/inlineEditing.js"></script>
<script type="text/javascript" src="modules/Favorites/favorites.js"></script>