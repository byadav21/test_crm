<?php /* Smarty version 2.6.29, created on 2016-12-28 23:18:20
         compiled from cache/themes/SuiteR/modules/KReports/DetailView.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sugar_include', 'cache/themes/SuiteR/modules/KReports/DetailView.tpl', 34, false),)), $this); ?>


<script language="javascript">
<?php echo '
SUGAR.util.doWhen(function(){
    return $("#contentTable").length == 0;
}, SUGAR.themes.actionMenu);
'; ?>

</script>
<table cellpadding="0" cellspacing="0" border="0" width="100%" id="">
<tr>
<td class="buttons" align="left" NOWRAP width="80%">
<div class="actionsContainer">
<form action="index.php" method="post" name="DetailView" id="formDetailView">
<input type="hidden" name="module" value="<?php echo $this->_tpl_vars['module']; ?>
">
<input type="hidden" name="record" value="<?php echo $this->_tpl_vars['fields']['id']['value']; ?>
">
<input type="hidden" name="return_action">
<input type="hidden" name="return_module">
<input type="hidden" name="return_id">
<input type="hidden" name="module_tab">
<input type="hidden" name="isDuplicate" value="false">
<input type="hidden" name="offset" value="<?php echo $this->_tpl_vars['offset']; ?>
">
<input type="hidden" name="action" value="EditView">
<input type="hidden" name="sugar_body_only">
<input type="hidden" name="to_pdf" id="to_pdf" value=""><input type="hidden" name="dynamicoptions" id="dynamicoptions" value="<?php echo $this->_tpl_vars['dynamicoptions']; ?>
"><input type="hidden" name="groupby" id="groupby" value=""><input type="hidden" name="dynamicols" id="dynamicols" value="">
</form>
<ul id="detail_header_action_menu" class="clickMenu fancymenu" ><li class="single" ><?php if ($this->_tpl_vars['bean']->aclAccess('detail')): ?><?php if (! empty ( $this->_tpl_vars['fields']['id']['value'] ) && $this->_tpl_vars['isAuditEnabled']): ?><input id="btn_view_change_log" title="<?php echo $this->_tpl_vars['APP']['LNK_VIEW_CHANGE_LOG']; ?>
" class="button" onclick='open_popup("Audit", "600", "400", "&record=<?php echo $this->_tpl_vars['fields']['id']['value']; ?>
&module_name=KReports", true, false,  { "call_back_function":"set_return","form_name":"EditView","field_to_name_array":[] } ); return false;' type="button" value="<?php echo $this->_tpl_vars['APP']['LNK_VIEW_CHANGE_LOG']; ?>
"><?php endif; ?><?php endif; ?></li></ul>
</div>
</td>
<td align="right" width="20%"><?php echo $this->_tpl_vars['ADMIN_EDIT']; ?>

<?php echo $this->_tpl_vars['PAGINATION']; ?>

</td>
</tr>
</table><?php echo smarty_function_sugar_include(array('include' => $this->_tpl_vars['includes']), $this);?>

<div id="KReports_detailview_tabs"
>
<div >
</div>
</div>

<input type="hidden" name="listfieldarray" id="listfieldarray" value="<?php echo $this->_tpl_vars['listfieldarray']; ?>
">
<input type="hidden" name="listfields" id="listfields" value="<?php echo $this->_tpl_vars['fields']['listfields']['value']; ?>
">
<input type="hidden" name="listtype" id="listtype" value="<?php echo $this->_tpl_vars['fields']['listtype']['value']; ?>
">
<input type='hidden' name='listtypeproperties' id='listtypeproperties' value='<?php echo $this->_tpl_vars['fields']['listtypeproperties']['value']; ?>
'>
<input type='hidden' name='reportoptions' id='reportoptions' value='<?php echo $this->_tpl_vars['reportoptions']; ?>
'>
<input type='hidden' name='jsonlanguage' id='jsonlanguage' value='<?php echo $this->_tpl_vars['jsonlanguage']; ?>
'>
<input type="hidden" name="recordid" id="recordid" value="<?php echo $this->_tpl_vars['fields']['id']['value']; ?>
">
<link rel="stylesheet" type="text/css" href="custom/k/extjs4/resources/css/ext-all-gray.css" />
<link rel="stylesheet" type="text/css" href="custom/k/css/ext_override.css" />
<script type="text/javascript" src="custom/k/extjs4/ext-all<?php if ($this->_tpl_vars['kreportDebug']): ?>-debug<?php endif; ?>.js"></script>

<script type='text/javascript'><?php echo $this->_tpl_vars['jsVariables']; ?>
</script>
<script type='text/javascript' src='modules/KReports/js/kreportsbase1<?php if ($this->_tpl_vars['kreportDebug']): ?>_debug<?php endif; ?>.js'></script>
<script type="text/javascript" src="modules/KReports/js/kreportsbase2<?php if ($this->_tpl_vars['kreportDebug']): ?>_debug<?php endif; ?>.js"></script>
<?php echo $this->_tpl_vars['integrationpluginjs']; ?>

<?php echo $this->_tpl_vars['visualizationpluginjs']; ?>

<?php echo $this->_tpl_vars['presentation']; ?>



<script type="text/javascript" src="modules/KReports/js/kreportsbase4<?php if ($this->_tpl_vars['kreportDebug']): ?>_debug<?php endif; ?>.js"></script> 
<div id='reportMain' style="margin-left:0px; margin-right:10px">
<div id='toolbarArea'></div>
<?php if ($this->_tpl_vars['dynamicoptions'] != ''): ?><div id='optionsArea' style='margin-top:5px;'></div><?php endif; ?>
<?php echo $this->_tpl_vars['visualization']; ?>

<div id='reportGrid' style='margin-top:5px;'><?php echo $this->_tpl_vars['reportData']; ?>
</div><br></div><script type="text/javascript" src="include/InlineEditing/inlineEditing.js"></script>
<script type="text/javascript" src="modules/Favorites/favorites.js"></script>