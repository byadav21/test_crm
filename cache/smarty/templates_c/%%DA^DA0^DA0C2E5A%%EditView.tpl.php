<?php /* Smarty version 2.6.29, created on 2016-12-28 23:18:36
         compiled from cache/themes/SuiteR/modules/KReports/EditView.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sugar_include', 'cache/themes/SuiteR/modules/KReports/EditView.tpl', 42, false),array('function', 'sugar_translate', 'cache/themes/SuiteR/modules/KReports/EditView.tpl', 100, false),)), $this); ?>


<script>
    <?php echo '
    $(document).ready(function(){
	    $("ul.clickMenu").each(function(index, node){
	        $(node).sugarActionMenu();
	    });
    });
    '; ?>

</script>
<div class="clear"></div>
<form action="index.php" method="POST" name="<?php echo $this->_tpl_vars['form_name']; ?>
" id="<?php echo $this->_tpl_vars['form_id']; ?>
" <?php echo $this->_tpl_vars['enctype']; ?>
>
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="dcQuickEdit">
<tr>
<td class="buttons">
<input type="hidden" name="module" value="<?php echo $this->_tpl_vars['module']; ?>
">
<?php if (isset ( $_REQUEST['isDuplicate'] ) && $_REQUEST['isDuplicate'] == 'true'): ?>
<input type="hidden" name="record" value="">
<input type="hidden" name="duplicateSave" value="true">
<input type="hidden" name="duplicateId" value="<?php echo $this->_tpl_vars['fields']['id']['value']; ?>
">
<?php else: ?>
<input type="hidden" name="record" value="<?php echo $this->_tpl_vars['fields']['id']['value']; ?>
">
<?php endif; ?>
<input type="hidden" name="isDuplicate" value="false">
<input type="hidden" name="action">
<input type="hidden" name="return_module" value="<?php echo $_REQUEST['return_module']; ?>
">
<input type="hidden" name="return_action" value="<?php echo $_REQUEST['return_action']; ?>
">
<input type="hidden" name="return_id" value="<?php echo $_REQUEST['return_id']; ?>
">
<input type="hidden" name="module_tab"> 
<input type="hidden" name="contact_role">
<?php if (( ! empty ( $_REQUEST['return_module'] ) || ! empty ( $_REQUEST['relate_to'] ) ) && ! ( isset ( $_REQUEST['isDuplicate'] ) && $_REQUEST['isDuplicate'] == 'true' )): ?>
<input type="hidden" name="relate_to" value="<?php if ($_REQUEST['return_relationship']): ?><?php echo $_REQUEST['return_relationship']; ?>
<?php elseif ($_REQUEST['relate_to'] && empty ( $_REQUEST['from_dcmenu'] )): ?><?php echo $_REQUEST['relate_to']; ?>
<?php elseif (empty ( $this->_tpl_vars['isDCForm'] ) && empty ( $_REQUEST['from_dcmenu'] )): ?><?php echo $_REQUEST['return_module']; ?>
<?php endif; ?>">
<input type="hidden" name="relate_id" value="<?php echo $_REQUEST['return_id']; ?>
">
<?php endif; ?>
<input type="hidden" name="offset" value="<?php echo $this->_tpl_vars['offset']; ?>
">
<?php $this->assign('place', '_HEADER'); ?> <!-- to be used for id for buttons with custom code in def files-->
</td>
<td align='right'>
</td>
</tr>
</table><?php echo smarty_function_sugar_include(array('include' => $this->_tpl_vars['includes']), $this);?>

<span id='tabcounterJS'><script>SUGAR.TabFields=new Array();//this will be used to track tabindexes for references</script></span>
<div id="EditView_tabs"
>
<div >
</div></div>

<input type='hidden' name='whereconditions' id='whereconditions' value='<?php echo $this->_tpl_vars['fields']['whereconditions']['value']; ?>
'>
<input type='hidden' name='wheregroups' id='wheregroups' value='<?php echo $this->_tpl_vars['fields']['wheregroups']['value']; ?>
'>
<input type='hidden' name='listfields' id='listfields' value='<?php echo $this->_tpl_vars['fields']['listfields']['value']; ?>
'>
<input type='hidden' name='unionlistfields' id='unionlistfields' value='<?php echo $this->_tpl_vars['fields']['unionlistfields']['value']; ?>
'>
<input type='hidden' name='listtype' id='listtype' value='<?php echo $this->_tpl_vars['fields']['listtype']['value']; ?>
'>
<input type='hidden' name='listtypeproperties' id='listtypeproperties' value='<?php echo $this->_tpl_vars['fields']['listtypeproperties']['value']; ?>
'>
<input type='hidden' name='jsonlanguage' id='jsonlanguage' value='<?php echo $this->_tpl_vars['jsonlanguage']; ?>
'>
<input type='hidden' name='selectionlimit' id='selectionlimit' value='<?php echo $this->_tpl_vars['fields']['selectionlimit']['value']; ?>
'>
<input type='hidden' name='presentation_params' id='presentation_params' value='<?php echo $this->_tpl_vars['fields']['presentation_params']['value']; ?>
'>
<input type='hidden' name='visualization_params' id='visualization_params' value='<?php echo $this->_tpl_vars['fields']['visualization_params']['value']; ?>
'>
<input type='hidden' name='integration_params' id='integration_params' value='<?php echo $this->_tpl_vars['fields']['integration_params']['value']; ?>
'>
<input type='hidden' name='report_module' id='report_module' value='<?php echo $this->_tpl_vars['fields']['report_module']['value']; ?>
'>
<input type='hidden' name='reportoptions' id='reportoptions' value='<?php echo $this->_tpl_vars['fields']['reportoptions']['value']; ?>
'>
<input type='hidden' name='union_modules' id='union_modules' value='<?php echo $this->_tpl_vars['fields']['union_modules']['value']; ?>
'>
<input type='hidden' name='name' id='name' value='<?php echo $this->_tpl_vars['fields']['name']['value']; ?>
'>
<input type='hidden' name='description' id='description' value='<?php echo $this->_tpl_vars['fields']['description']['value']; ?>
'>
<input type='hidden' name='report_status' id='report_status' value='<?php echo $this->_tpl_vars['fields']['report_status']['value']; ?>
'>
<input type='hidden' name='assigned_user_name' id='assigned_user_name' value='<?php echo $this->_tpl_vars['fields']['assigned_user_name']['value']; ?>
'>
<input type='hidden' name='assigned_user_id' id='assigned_user_id' value='<?php echo $this->_tpl_vars['fields']['assigned_user_id']['value']; ?>
'>
<input type='hidden' name='team_name' id='team_name' value='<?php echo $this->_tpl_vars['team_name']; ?>
'>
<input type='hidden' name='team_id' id='team_id' value='<?php echo $this->_tpl_vars['fields']['team_id']['value']; ?>
'>
<input type='hidden' name='authaccess_id' id='authaccess_id' value='<?php echo $this->_tpl_vars['authaccess_id']; ?>
'>
<input type='hidden' name='authaccess_name' id='authaccess_name' value='<?php echo $this->_tpl_vars['authaccess_name']; ?>
'>
<input type='hidden' name='korgobject_name' id='korgobject_name' value='<?php echo $this->_tpl_vars['fields']['korgobject_name']['value']; ?>
'>
<input type='hidden' name='korgobject_id' id='korgobject_id' value='<?php echo $this->_tpl_vars['fields']['korgobject_id']['value']; ?>
'>
<link rel="stylesheet" type="text/css" href="custom/k/extjs4/resources/css/ext-all-gray.css" />
<link rel="stylesheet" type="text/css" href="custom/k/css/ext_override.css" />
<script type="text/javascript" src="custom/k/extjs4/ext-all<?php if ($this->_tpl_vars['kreportDebug']): ?>-debug<?php endif; ?>.js"></script>

<script type='text/javascript'><?php echo $this->_tpl_vars['jsVariables']; ?>
</script>
<div id='toolbarArea' style='margin-bottom: 5px;'></div>
<div id="layoutregion"></div>
<?php echo $this->_tpl_vars['editViewAddJs']; ?>

<script type='text/javascript' src='modules/KReports/js/kreportsbase1<?php if ($this->_tpl_vars['kreportDebug']): ?>_debug<?php endif; ?>.js'></script>
<script type="text/javascript" src="modules/KReports/js/kreportsbase2<?php if ($this->_tpl_vars['kreportDebug']): ?>_debug<?php endif; ?>.js"></script>
<script type="text/javascript" src="modules/KReports/js/kreportsbase3<?php if ($this->_tpl_vars['kreportDebug']): ?>_debug<?php endif; ?>.js"></script>
<?php echo $this->_tpl_vars['pluginJS']; ?>
<?php echo $this->_tpl_vars['pluginData']; ?>

<script type="text/javascript" src="modules/KReports/js/kreportsbase5<?php if ($this->_tpl_vars['kreportDebug']): ?>_debug<?php endif; ?>.js"></script>
<script type="text/javascript">
YAHOO.util.Event.onContentReady("EditView",
    function () { initEditView(document.forms.EditView) });
//window.setTimeout(, 100);
window.onbeforeunload = function () { return onUnloadEditView(); };
// bug 55468 -- IE is too aggressive with onUnload event
if ($.browser.msie) {
$(document).ready(function() {
    $(".collapseLink,.expandLink").click(function (e) { e.preventDefault(); });
  });
}
</script><?php echo '
<script type="text/javascript">
addForm(\'EditView\');addToValidate(\'EditView\', \'name\', \'name\', true,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_NAME','module' => 'KReports','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'date_entered_date\', \'date\', false,\'Date Created\' );
addToValidate(\'EditView\', \'date_modified_date\', \'date\', false,\'Date Modified\' );
addToValidate(\'EditView\', \'modified_user_id\', \'assigned_user_name\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_MODIFIED','module' => 'KReports','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'modified_by_name\', \'relate\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_MODIFIED_NAME','module' => 'KReports','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'created_by\', \'assigned_user_name\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_CREATED','module' => 'KReports','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'created_by_name\', \'relate\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_CREATED','module' => 'KReports','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'description\', \'text\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_DESCRIPTION','module' => 'KReports','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'deleted\', \'bool\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_DELETED','module' => 'KReports','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'assigned_user_id\', \'relate\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_ASSIGNED_TO_ID','module' => 'KReports','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'assigned_user_name\', \'relate\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_ASSIGNED_TO_NAME','module' => 'KReports','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'report_module\', \'enum\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_MODULE','module' => 'KReports','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'report_status\', \'enum\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_REPORT_STATUS','module' => 'KReports','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'reportoptions\', \'text\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_REPORTOPTIONS','module' => 'KReports','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'listtype\', \'varchar\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_LISTTYPE','module' => 'KReports','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'selectionlimit\', \'varchar\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_SELECTIONLIMIT','module' => 'KReports','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'presentation_params\', \'text\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_PRESENTATION_PARAMS','module' => 'KReports','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'visualization_params\', \'text\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_VISUALIZATION_PARAMS','module' => 'KReports','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'integration_params\', \'text\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_INTEGRATION_PARAMS','module' => 'KReports','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'wheregroups\', \'text\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_WHEREGROUPS','module' => 'KReports','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'whereconditions\', \'text\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_WHERECONDITION','module' => 'KReports','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'listfields\', \'text\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_LISTFIELDS','module' => 'KReports','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'unionlistfields\', \'text\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_UNIONLISTFIELDS','module' => 'KReports','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'advancedoptions\', \'text\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_ADVANCEDOPTIONS','module' => 'KReports','for_js' => true), $this);?>
<?php echo '\' );
addToValidateBinaryDependency(\'EditView\', \'assigned_user_name\', \'alpha\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'ERR_SQS_NO_MATCH_FIELD','module' => 'KReports','for_js' => true), $this);?>
<?php echo ': '; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_ASSIGNED_TO','module' => 'KReports','for_js' => true), $this);?>
<?php echo '\', \'assigned_user_id\' );
</script>'; ?>
