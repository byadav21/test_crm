

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
</td>
<td align='right'>
</td>
</tr>
</table>{sugar_include include=$includes}
<span id='tabcounterJS'><script>SUGAR.TabFields=new Array();//this will be used to track tabindexes for references</script></span>
<div id="EditView_tabs"
>
<div >
</div></div>

<input type='hidden' name='whereconditions' id='whereconditions' value='{$fields.whereconditions.value}'>
<input type='hidden' name='wheregroups' id='wheregroups' value='{$fields.wheregroups.value}'>
<input type='hidden' name='listfields' id='listfields' value='{$fields.listfields.value}'>
<input type='hidden' name='unionlistfields' id='unionlistfields' value='{$fields.unionlistfields.value}'>
<input type='hidden' name='listtype' id='listtype' value='{$fields.listtype.value}'>
<input type='hidden' name='listtypeproperties' id='listtypeproperties' value='{$fields.listtypeproperties.value}'>
<input type='hidden' name='jsonlanguage' id='jsonlanguage' value='{$jsonlanguage}'>
<input type='hidden' name='selectionlimit' id='selectionlimit' value='{$fields.selectionlimit.value}'>
<input type='hidden' name='presentation_params' id='presentation_params' value='{$fields.presentation_params.value}'>
<input type='hidden' name='visualization_params' id='visualization_params' value='{$fields.visualization_params.value}'>
<input type='hidden' name='integration_params' id='integration_params' value='{$fields.integration_params.value}'>
<input type='hidden' name='report_module' id='report_module' value='{$fields.report_module.value}'>
<input type='hidden' name='reportoptions' id='reportoptions' value='{$fields.reportoptions.value}'>
<input type='hidden' name='union_modules' id='union_modules' value='{$fields.union_modules.value}'>
<input type='hidden' name='name' id='name' value='{$fields.name.value}'>
<input type='hidden' name='description' id='description' value='{$fields.description.value}'>
<input type='hidden' name='report_status' id='report_status' value='{$fields.report_status.value}'>
<input type='hidden' name='assigned_user_name' id='assigned_user_name' value='{$fields.assigned_user_name.value}'>
<input type='hidden' name='assigned_user_id' id='assigned_user_id' value='{$fields.assigned_user_id.value}'>
<input type='hidden' name='team_name' id='team_name' value='{$team_name}'>
<input type='hidden' name='team_id' id='team_id' value='{$fields.team_id.value}'>
<input type='hidden' name='authaccess_id' id='authaccess_id' value='{$authaccess_id}'>
<input type='hidden' name='authaccess_name' id='authaccess_name' value='{$authaccess_name}'>
<input type='hidden' name='korgobject_name' id='korgobject_name' value='{$fields.korgobject_name.value}'>
<input type='hidden' name='korgobject_id' id='korgobject_id' value='{$fields.korgobject_id.value}'>
<link rel="stylesheet" type="text/css" href="custom/k/extjs4/resources/css/ext-all-gray.css" />
<link rel="stylesheet" type="text/css" href="custom/k/css/ext_override.css" />
<script type="text/javascript" src="custom/k/extjs4/ext-all{if $kreportDebug}-debug{/if}.js"></script>

<script type='text/javascript'>{$jsVariables}</script>
<div id='toolbarArea' style='margin-bottom: 5px;'></div>
<div id="layoutregion"></div>
{$editViewAddJs}
<script type='text/javascript' src='modules/KReports/js/kreportsbase1{if $kreportDebug}_debug{/if}.js'></script>
<script type="text/javascript" src="modules/KReports/js/kreportsbase2{if $kreportDebug}_debug{/if}.js"></script>
<script type="text/javascript" src="modules/KReports/js/kreportsbase3{if $kreportDebug}_debug{/if}.js"></script>
{$pluginJS}{$pluginData}
<script type="text/javascript" src="modules/KReports/js/kreportsbase5{if $kreportDebug}_debug{/if}.js"></script>
<script type="text/javascript">
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
addForm('EditView');addToValidate('EditView', 'name', 'name', true,'{/literal}{sugar_translate label='LBL_NAME' module='KReports' for_js=true}{literal}' );
addToValidate('EditView', 'date_entered_date', 'date', false,'Date Created' );
addToValidate('EditView', 'date_modified_date', 'date', false,'Date Modified' );
addToValidate('EditView', 'modified_user_id', 'assigned_user_name', false,'{/literal}{sugar_translate label='LBL_MODIFIED' module='KReports' for_js=true}{literal}' );
addToValidate('EditView', 'modified_by_name', 'relate', false,'{/literal}{sugar_translate label='LBL_MODIFIED_NAME' module='KReports' for_js=true}{literal}' );
addToValidate('EditView', 'created_by', 'assigned_user_name', false,'{/literal}{sugar_translate label='LBL_CREATED' module='KReports' for_js=true}{literal}' );
addToValidate('EditView', 'created_by_name', 'relate', false,'{/literal}{sugar_translate label='LBL_CREATED' module='KReports' for_js=true}{literal}' );
addToValidate('EditView', 'description', 'text', false,'{/literal}{sugar_translate label='LBL_DESCRIPTION' module='KReports' for_js=true}{literal}' );
addToValidate('EditView', 'deleted', 'bool', false,'{/literal}{sugar_translate label='LBL_DELETED' module='KReports' for_js=true}{literal}' );
addToValidate('EditView', 'assigned_user_id', 'relate', false,'{/literal}{sugar_translate label='LBL_ASSIGNED_TO_ID' module='KReports' for_js=true}{literal}' );
addToValidate('EditView', 'assigned_user_name', 'relate', false,'{/literal}{sugar_translate label='LBL_ASSIGNED_TO_NAME' module='KReports' for_js=true}{literal}' );
addToValidate('EditView', 'report_module', 'enum', false,'{/literal}{sugar_translate label='LBL_MODULE' module='KReports' for_js=true}{literal}' );
addToValidate('EditView', 'report_status', 'enum', false,'{/literal}{sugar_translate label='LBL_REPORT_STATUS' module='KReports' for_js=true}{literal}' );
addToValidate('EditView', 'reportoptions', 'text', false,'{/literal}{sugar_translate label='LBL_REPORTOPTIONS' module='KReports' for_js=true}{literal}' );
addToValidate('EditView', 'listtype', 'varchar', false,'{/literal}{sugar_translate label='LBL_LISTTYPE' module='KReports' for_js=true}{literal}' );
addToValidate('EditView', 'selectionlimit', 'varchar', false,'{/literal}{sugar_translate label='LBL_SELECTIONLIMIT' module='KReports' for_js=true}{literal}' );
addToValidate('EditView', 'presentation_params', 'text', false,'{/literal}{sugar_translate label='LBL_PRESENTATION_PARAMS' module='KReports' for_js=true}{literal}' );
addToValidate('EditView', 'visualization_params', 'text', false,'{/literal}{sugar_translate label='LBL_VISUALIZATION_PARAMS' module='KReports' for_js=true}{literal}' );
addToValidate('EditView', 'integration_params', 'text', false,'{/literal}{sugar_translate label='LBL_INTEGRATION_PARAMS' module='KReports' for_js=true}{literal}' );
addToValidate('EditView', 'wheregroups', 'text', false,'{/literal}{sugar_translate label='LBL_WHEREGROUPS' module='KReports' for_js=true}{literal}' );
addToValidate('EditView', 'whereconditions', 'text', false,'{/literal}{sugar_translate label='LBL_WHERECONDITION' module='KReports' for_js=true}{literal}' );
addToValidate('EditView', 'listfields', 'text', false,'{/literal}{sugar_translate label='LBL_LISTFIELDS' module='KReports' for_js=true}{literal}' );
addToValidate('EditView', 'unionlistfields', 'text', false,'{/literal}{sugar_translate label='LBL_UNIONLISTFIELDS' module='KReports' for_js=true}{literal}' );
addToValidate('EditView', 'advancedoptions', 'text', false,'{/literal}{sugar_translate label='LBL_ADVANCEDOPTIONS' module='KReports' for_js=true}{literal}' );
addToValidateBinaryDependency('EditView', 'assigned_user_name', 'alpha', false,'{/literal}{sugar_translate label='ERR_SQS_NO_MATCH_FIELD' module='KReports' for_js=true}{literal}: {/literal}{sugar_translate label='LBL_ASSIGNED_TO' module='KReports' for_js=true}{literal}', 'assigned_user_id' );
</script>{/literal}
