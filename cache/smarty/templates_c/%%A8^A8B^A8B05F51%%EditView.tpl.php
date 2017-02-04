<?php /* Smarty version 2.6.29, created on 2017-02-03 03:41:24
         compiled from cache/themes/SuiteR/modules/te_ba_Batch/EditView.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'cache/themes/SuiteR/modules/te_ba_Batch/EditView.tpl', 38, false),array('modifier', 'strip_semicolon', 'cache/themes/SuiteR/modules/te_ba_Batch/EditView.tpl', 57, false),array('modifier', 'default', 'cache/themes/SuiteR/modules/te_ba_Batch/EditView.tpl', 204, false),array('modifier', 'lookup', 'cache/themes/SuiteR/modules/te_ba_Batch/EditView.tpl', 251, false),array('modifier', 'count', 'cache/themes/SuiteR/modules/te_ba_Batch/EditView.tpl', 353, false),array('function', 'sugar_include', 'cache/themes/SuiteR/modules/te_ba_Batch/EditView.tpl', 44, false),array('function', 'counter', 'cache/themes/SuiteR/modules/te_ba_Batch/EditView.tpl', 50, false),array('function', 'sugar_translate', 'cache/themes/SuiteR/modules/te_ba_Batch/EditView.tpl', 56, false),array('function', 'sugar_getimagepath', 'cache/themes/SuiteR/modules/te_ba_Batch/EditView.tpl', 81, false),array('function', 'sugar_getimage', 'cache/themes/SuiteR/modules/te_ba_Batch/EditView.tpl', 193, false),array('function', 'html_options', 'cache/themes/SuiteR/modules/te_ba_Batch/EditView.tpl', 226, false),array('function', 'sugar_number_format', 'cache/themes/SuiteR/modules/te_ba_Batch/EditView.tpl', 494, false),)), $this); ?>


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
<div class="action_buttons"><?php if ($this->_tpl_vars['bean']->aclAccess('save')): ?><input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="button primary" onclick="var _form = document.getElementById('EditView'); <?php if ($this->_tpl_vars['isDuplicate']): ?>_form.return_id.value=''; <?php endif; ?>_form.action.value='Save'; if(check_form('EditView'))SUGAR.ajaxUI.submitForm(_form);return false;" type="submit" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
" id="SAVE_HEADER"><?php endif; ?>  <?php if (! empty ( $_REQUEST['return_action'] ) && ( $_REQUEST['return_action'] == 'DetailView' && ! empty ( $_REQUEST['return_id'] ) )): ?><input title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_KEY']; ?>
" class="button" onclick="SUGAR.ajaxUI.loadContent('index.php?action=DetailView&module=<?php echo ((is_array($_tmp=$_REQUEST['return_module'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
&record=<?php echo ((is_array($_tmp=$_REQUEST['return_id'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
'); return false;" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
" type="button" id="CANCEL_HEADER"> <?php elseif (! empty ( $_REQUEST['return_action'] ) && ( $_REQUEST['return_action'] == 'DetailView' && ! empty ( $this->_tpl_vars['fields']['id']['value'] ) )): ?><input title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_KEY']; ?>
" class="button" onclick="SUGAR.ajaxUI.loadContent('index.php?action=DetailView&module=<?php echo ((is_array($_tmp=$_REQUEST['return_module'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
&record=<?php echo $this->_tpl_vars['fields']['id']['value']; ?>
'); return false;" type="button" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
" id="CANCEL_HEADER"> <?php elseif (! empty ( $_REQUEST['return_action'] ) && ( $_REQUEST['return_action'] == 'DetailView' && empty ( $this->_tpl_vars['fields']['id']['value'] ) ) && empty ( $_REQUEST['return_id'] )): ?><input title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_KEY']; ?>
" class="button" onclick="SUGAR.ajaxUI.loadContent('index.php?action=ListView&module=<?php echo ((is_array($_tmp=$_REQUEST['return_module'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
&record=<?php echo $this->_tpl_vars['fields']['id']['value']; ?>
'); return false;" type="button" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
" id="CANCEL_HEADER"> <?php elseif (! empty ( $_REQUEST['return_action'] ) && ! empty ( $_REQUEST['return_module'] )): ?><input title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_KEY']; ?>
" class="button" onclick="SUGAR.ajaxUI.loadContent('index.php?action=<?php echo $_REQUEST['return_action']; ?>
&module=<?php echo ((is_array($_tmp=$_REQUEST['return_module'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
'); return false;" type="button" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
" id="CANCEL_HEADER"> <?php elseif (empty ( $_REQUEST['return_action'] ) || empty ( $_REQUEST['return_id'] ) && ! empty ( $this->_tpl_vars['fields']['id']['value'] )): ?><input title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_KEY']; ?>
" class="button" onclick="SUGAR.ajaxUI.loadContent('index.php?action=index&module=te_ba_Batch'); return false;" type="button" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
" id="CANCEL_HEADER"> <?php else: ?><input title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_KEY']; ?>
" class="button" onclick="SUGAR.ajaxUI.loadContent('index.php?action=index&module=<?php echo ((is_array($_tmp=$_REQUEST['return_module'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
&record=<?php echo ((is_array($_tmp=$_REQUEST['return_id'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
'); return false;" type="button" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
" id="CANCEL_HEADER"> <?php endif; ?> <?php if ($this->_tpl_vars['bean']->aclAccess('detail')): ?><?php if (! empty ( $this->_tpl_vars['fields']['id']['value'] ) && $this->_tpl_vars['isAuditEnabled']): ?><input id="btn_view_change_log" title="<?php echo $this->_tpl_vars['APP']['LNK_VIEW_CHANGE_LOG']; ?>
" class="button" onclick='open_popup("Audit", "600", "400", "&record=<?php echo $this->_tpl_vars['fields']['id']['value']; ?>
&module_name=te_ba_Batch", true, false,  { "call_back_function":"set_return","form_name":"EditView","field_to_name_array":[] } ); return false;' type="button" value="<?php echo $this->_tpl_vars['APP']['LNK_VIEW_CHANGE_LOG']; ?>
"><?php endif; ?><?php endif; ?><div class="clear"></div></div>
</td>
<td align='right'>
<?php echo $this->_tpl_vars['PAGINATION']; ?>

</td>
</tr>
</table><?php echo smarty_function_sugar_include(array('include' => $this->_tpl_vars['includes']), $this);?>

<span id='tabcounterJS'><script>SUGAR.TabFields=new Array();//this will be used to track tabindexes for references</script></span>
<div id="EditView_tabs"
>
<div >
<div id="detailpanel_1" >
<?php echo smarty_function_counter(array('name' => 'panelFieldCount','start' => 0,'print' => false,'assign' => 'panelFieldCount'), $this);?>

<table width="100%" border="0" cellspacing="1" cellpadding="0"  id='Default_<?php echo $this->_tpl_vars['module']; ?>
_Subpanel'  class="yui3-skin-sam edit view panelContainer">
<?php echo smarty_function_counter(array('name' => 'fieldsUsed','start' => 0,'print' => false,'assign' => 'fieldsUsed'), $this);?>

<?php ob_start(); ?>
<tr>
<td valign="top" id='te_in_institutes_te_ba_batch_1_name_label' width='12.5%' scope="col">
<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_TE_IN_INSTITUTES_TE_BA_BATCH_1_FROM_TE_IN_INSTITUTES_TITLE','module' => 'te_ba_Batch'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
<span class="required">*</span>
</td>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed'), $this);?>


<td valign="top" width='37.5%' >
<?php echo smarty_function_counter(array('name' => 'panelFieldCount'), $this);?>


<input type="text" name="<?php echo $this->_tpl_vars['fields']['te_in_institutes_te_ba_batch_1_name']['name']; ?>
" class="sqsEnabled" tabindex="0" id="<?php echo $this->_tpl_vars['fields']['te_in_institutes_te_ba_batch_1_name']['name']; ?>
" size="" value="<?php echo $this->_tpl_vars['fields']['te_in_institutes_te_ba_batch_1_name']['value']; ?>
" title='' autocomplete="off"  	 accesskey='7'  >
<input type="hidden" name="<?php echo $this->_tpl_vars['fields']['te_in_institutes_te_ba_batch_1_name']['id_name']; ?>
" 
id="<?php echo $this->_tpl_vars['fields']['te_in_institutes_te_ba_batch_1_name']['id_name']; ?>
" 
value="<?php echo $this->_tpl_vars['fields']['te_in_institutes_te_ba_batch_1te_in_institutes_ida']['value']; ?>
">
<span class="id-ff multiple">
<button type="button" name="btn_<?php echo $this->_tpl_vars['fields']['te_in_institutes_te_ba_batch_1_name']['name']; ?>
" id="btn_<?php echo $this->_tpl_vars['fields']['te_in_institutes_te_ba_batch_1_name']['name']; ?>
" tabindex="0" title="<?php echo smarty_function_sugar_translate(array('label' => 'LBL_SELECT_BUTTON_TITLE'), $this);?>
" class="button firstChild" value="<?php echo smarty_function_sugar_translate(array('label' => 'LBL_SELECT_BUTTON_LABEL'), $this);?>
"
onclick='open_popup(
"<?php echo $this->_tpl_vars['fields']['te_in_institutes_te_ba_batch_1_name']['module']; ?>
", 
600, 
400, 
"", 
true, 
false, 
<?php echo '{"call_back_function":"set_return","form_name":"EditView","field_to_name_array":{"id":"te_in_institutes_te_ba_batch_1te_in_institutes_ida","name":"te_in_institutes_te_ba_batch_1_name"}}'; ?>
, 
"single", 
true
);' ><img src="<?php echo smarty_function_sugar_getimagepath(array('file' => "id-ff-select.png"), $this);?>
"></button><button type="button" name="btn_clr_<?php echo $this->_tpl_vars['fields']['te_in_institutes_te_ba_batch_1_name']['name']; ?>
" id="btn_clr_<?php echo $this->_tpl_vars['fields']['te_in_institutes_te_ba_batch_1_name']['name']; ?>
" tabindex="0" title="<?php echo smarty_function_sugar_translate(array('label' => 'LBL_ACCESSKEY_CLEAR_RELATE_TITLE'), $this);?>
"  class="button lastChild"
onclick="SUGAR.clearRelateField(this.form, '<?php echo $this->_tpl_vars['fields']['te_in_institutes_te_ba_batch_1_name']['name']; ?>
', '<?php echo $this->_tpl_vars['fields']['te_in_institutes_te_ba_batch_1_name']['id_name']; ?>
');"  value="<?php echo smarty_function_sugar_translate(array('label' => 'LBL_ACCESSKEY_CLEAR_RELATE_LABEL'), $this);?>
" ><img src="<?php echo smarty_function_sugar_getimagepath(array('file' => "id-ff-clear.png"), $this);?>
"></button>
</span>
<script type="text/javascript">
SUGAR.util.doWhen(
		"typeof(sqs_objects) != 'undefined' && typeof(sqs_objects['<?php echo $this->_tpl_vars['form_name']; ?>
_<?php echo $this->_tpl_vars['fields']['te_in_institutes_te_ba_batch_1_name']['name']; ?>
']) != 'undefined'",
		enableQS
);
</script>
<td valign="top" id='te_pr_programs_te_ba_batch_1_name_label' width='12.5%' scope="col">
<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_TE_PR_PROGRAMS_TE_BA_BATCH_1_FROM_TE_PR_PROGRAMS_TITLE','module' => 'te_ba_Batch'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
<span class="required">*</span>
</td>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed'), $this);?>


<td valign="top" width='37.5%' >
<?php echo smarty_function_counter(array('name' => 'panelFieldCount'), $this);?>


<input type="text" name="<?php echo $this->_tpl_vars['fields']['te_pr_programs_te_ba_batch_1_name']['name']; ?>
" class="sqsEnabled" tabindex="0" id="<?php echo $this->_tpl_vars['fields']['te_pr_programs_te_ba_batch_1_name']['name']; ?>
" size="" value="<?php echo $this->_tpl_vars['fields']['te_pr_programs_te_ba_batch_1_name']['value']; ?>
" title='' autocomplete="off"  	 >
<input type="hidden" name="<?php echo $this->_tpl_vars['fields']['te_pr_programs_te_ba_batch_1_name']['id_name']; ?>
" 
id="<?php echo $this->_tpl_vars['fields']['te_pr_programs_te_ba_batch_1_name']['id_name']; ?>
" 
value="<?php echo $this->_tpl_vars['fields']['te_pr_programs_te_ba_batch_1te_pr_programs_ida']['value']; ?>
">
<span class="id-ff multiple">
<button type="button" name="btn_<?php echo $this->_tpl_vars['fields']['te_pr_programs_te_ba_batch_1_name']['name']; ?>
" id="btn_<?php echo $this->_tpl_vars['fields']['te_pr_programs_te_ba_batch_1_name']['name']; ?>
" tabindex="0" title="<?php echo smarty_function_sugar_translate(array('label' => 'LBL_SELECT_BUTTON_TITLE'), $this);?>
" class="button firstChild" value="<?php echo smarty_function_sugar_translate(array('label' => 'LBL_SELECT_BUTTON_LABEL'), $this);?>
"
onclick='open_popup(
"<?php echo $this->_tpl_vars['fields']['te_pr_programs_te_ba_batch_1_name']['module']; ?>
", 
600, 
400, 
"", 
true, 
false, 
<?php echo '{"call_back_function":"set_return","form_name":"EditView","field_to_name_array":{"id":"te_pr_programs_te_ba_batch_1te_pr_programs_ida","name":"te_pr_programs_te_ba_batch_1_name"}}'; ?>
, 
"single", 
true
);' ><img src="<?php echo smarty_function_sugar_getimagepath(array('file' => "id-ff-select.png"), $this);?>
"></button><button type="button" name="btn_clr_<?php echo $this->_tpl_vars['fields']['te_pr_programs_te_ba_batch_1_name']['name']; ?>
" id="btn_clr_<?php echo $this->_tpl_vars['fields']['te_pr_programs_te_ba_batch_1_name']['name']; ?>
" tabindex="0" title="<?php echo smarty_function_sugar_translate(array('label' => 'LBL_ACCESSKEY_CLEAR_RELATE_TITLE'), $this);?>
"  class="button lastChild"
onclick="SUGAR.clearRelateField(this.form, '<?php echo $this->_tpl_vars['fields']['te_pr_programs_te_ba_batch_1_name']['name']; ?>
', '<?php echo $this->_tpl_vars['fields']['te_pr_programs_te_ba_batch_1_name']['id_name']; ?>
');"  value="<?php echo smarty_function_sugar_translate(array('label' => 'LBL_ACCESSKEY_CLEAR_RELATE_LABEL'), $this);?>
" ><img src="<?php echo smarty_function_sugar_getimagepath(array('file' => "id-ff-clear.png"), $this);?>
"></button>
</span>
<script type="text/javascript">
SUGAR.util.doWhen(
		"typeof(sqs_objects) != 'undefined' && typeof(sqs_objects['<?php echo $this->_tpl_vars['form_name']; ?>
_<?php echo $this->_tpl_vars['fields']['te_pr_programs_te_ba_batch_1_name']['name']; ?>
']) != 'undefined'",
		enableQS
);
</script>
</tr>
<?php $this->_smarty_vars['capture']['tr'] = ob_get_contents();  $this->assign('tableRow', ob_get_contents());ob_end_clean(); ?>
<?php if ($this->_tpl_vars['fieldsUsed'] > 0): ?>
<?php echo $this->_tpl_vars['tableRow']; ?>

<?php endif; ?>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed','start' => 0,'print' => false,'assign' => 'fieldsUsed'), $this);?>

<?php ob_start(); ?>
<tr>
<td valign="top" id='name_label' width='12.5%' scope="col">
<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_NAME','module' => 'te_ba_Batch'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
<span class="required">*</span>
</td>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed'), $this);?>


<td valign="top" width='37.5%' >
<?php echo smarty_function_counter(array('name' => 'panelFieldCount'), $this);?>


<?php if (strlen ( $this->_tpl_vars['fields']['name']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['name']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['name']['value']); ?>
<?php endif; ?>  
<input type='text' name='<?php echo $this->_tpl_vars['fields']['name']['name']; ?>
' 
id='<?php echo $this->_tpl_vars['fields']['name']['name']; ?>
' size='30' 
maxlength='255' 
value='<?php echo $this->_tpl_vars['value']; ?>
' title=''      >
<td valign="top" id='batch_code_label' width='12.5%' scope="col">
<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_BATCH_CODE','module' => 'te_ba_Batch'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
<span class="required">*</span>
</td>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed'), $this);?>


<td valign="top" width='37.5%' >
<?php echo smarty_function_counter(array('name' => 'panelFieldCount'), $this);?>


<?php if (strlen ( $this->_tpl_vars['fields']['batch_code']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['batch_code']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['batch_code']['value']); ?>
<?php endif; ?>  
<input type='text' name='<?php echo $this->_tpl_vars['fields']['batch_code']['name']; ?>
' 
id='<?php echo $this->_tpl_vars['fields']['batch_code']['name']; ?>
' size='30' 
maxlength='255' 
value='<?php echo $this->_tpl_vars['value']; ?>
' title=''      >
</tr>
<?php $this->_smarty_vars['capture']['tr'] = ob_get_contents();  $this->assign('tableRow', ob_get_contents());ob_end_clean(); ?>
<?php if ($this->_tpl_vars['fieldsUsed'] > 0): ?>
<?php echo $this->_tpl_vars['tableRow']; ?>

<?php endif; ?>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed','start' => 0,'print' => false,'assign' => 'fieldsUsed'), $this);?>

<?php ob_start(); ?>
<tr>
<td valign="top" id='batch_start_date_label' width='12.5%' scope="col">
<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_BATCH_START_DATE','module' => 'te_ba_Batch'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
<span class="required">*</span>
</td>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed'), $this);?>


<td valign="top" width='37.5%' >
<?php echo smarty_function_counter(array('name' => 'panelFieldCount'), $this);?>


<span class="dateTime">
<?php $this->assign('date_value', $this->_tpl_vars['fields']['batch_start_date']['value']); ?>
<input class="date_input" autocomplete="off" type="text" name="<?php echo $this->_tpl_vars['fields']['batch_start_date']['name']; ?>
" id="<?php echo $this->_tpl_vars['fields']['batch_start_date']['name']; ?>
" value="<?php echo $this->_tpl_vars['date_value']; ?>
" title=''  tabindex='0'    size="11" maxlength="10" >
<?php ob_start(); ?>alt="<?php echo $this->_tpl_vars['APP']['LBL_ENTER_DATE']; ?>
" style="position:relative; top:6px" border="0" id="<?php echo $this->_tpl_vars['fields']['batch_start_date']['name']; ?>
_trigger"<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('other_attributes', ob_get_contents());ob_end_clean(); ?>
<?php echo smarty_function_sugar_getimage(array('name' => 'jscalendar','ext' => ".gif",'other_attributes' => ($this->_tpl_vars['other_attributes'])), $this);?>

</span>
<script type="text/javascript">
Calendar.setup ({
inputField : "<?php echo $this->_tpl_vars['fields']['batch_start_date']['name']; ?>
",
form : "EditView",
ifFormat : "<?php echo $this->_tpl_vars['CALENDAR_FORMAT']; ?>
",
daFormat : "<?php echo $this->_tpl_vars['CALENDAR_FORMAT']; ?>
",
button : "<?php echo $this->_tpl_vars['fields']['batch_start_date']['name']; ?>
_trigger",
singleClick : true,
dateStr : "<?php echo $this->_tpl_vars['date_value']; ?>
",
startWeekday: <?php echo ((is_array($_tmp=@$this->_tpl_vars['CALENDAR_FDOW'])) ? $this->_run_mod_handler('default', true, $_tmp, '0') : smarty_modifier_default($_tmp, '0')); ?>
,
step : 1,
weekNumbers:false
}
);
</script>
<td valign="top" id='batch_status_label' width='12.5%' scope="col">
<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_BATCH_STATUS','module' => 'te_ba_Batch'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
<span class="required">*</span>
</td>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed'), $this);?>


<td valign="top" width='37.5%' >
<?php echo smarty_function_counter(array('name' => 'panelFieldCount'), $this);?>


<?php if (! isset ( $this->_tpl_vars['config']['enable_autocomplete'] ) || $this->_tpl_vars['config']['enable_autocomplete'] == false): ?>
<select name="<?php echo $this->_tpl_vars['fields']['batch_status']['name']; ?>
" 
id="<?php echo $this->_tpl_vars['fields']['batch_status']['name']; ?>
" 
title=''       
>
<?php if (isset ( $this->_tpl_vars['fields']['batch_status']['value'] ) && $this->_tpl_vars['fields']['batch_status']['value'] != ''): ?>
<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['fields']['batch_status']['options'],'selected' => $this->_tpl_vars['fields']['batch_status']['value']), $this);?>

<?php else: ?>
<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['fields']['batch_status']['options'],'selected' => $this->_tpl_vars['fields']['batch_status']['default']), $this);?>

<?php endif; ?>
</select>
<?php else: ?>
<?php $this->assign('field_options', $this->_tpl_vars['fields']['batch_status']['options']); ?>
<?php ob_start(); ?><?php echo $this->_tpl_vars['fields']['batch_status']['value']; ?>
<?php $this->_smarty_vars['capture']['field_val'] = ob_get_contents(); ob_end_clean(); ?>
<?php $this->assign('field_val', $this->_smarty_vars['capture']['field_val']); ?>
<?php ob_start(); ?><?php echo $this->_tpl_vars['fields']['batch_status']['name']; ?>
<?php $this->_smarty_vars['capture']['ac_key'] = ob_get_contents(); ob_end_clean(); ?>
<?php $this->assign('ac_key', $this->_smarty_vars['capture']['ac_key']); ?>
<select style='display:none' name="<?php echo $this->_tpl_vars['fields']['batch_status']['name']; ?>
" 
id="<?php echo $this->_tpl_vars['fields']['batch_status']['name']; ?>
" 
title=''          
>
<?php if (isset ( $this->_tpl_vars['fields']['batch_status']['value'] ) && $this->_tpl_vars['fields']['batch_status']['value'] != ''): ?>
<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['fields']['batch_status']['options'],'selected' => $this->_tpl_vars['fields']['batch_status']['value']), $this);?>

<?php else: ?>
<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['fields']['batch_status']['options'],'selected' => $this->_tpl_vars['fields']['batch_status']['default']), $this);?>

<?php endif; ?>
</select>
<input
id="<?php echo $this->_tpl_vars['fields']['batch_status']['name']; ?>
-input"
name="<?php echo $this->_tpl_vars['fields']['batch_status']['name']; ?>
-input"
size="30"
value="<?php echo ((is_array($_tmp=$this->_tpl_vars['field_val'])) ? $this->_run_mod_handler('lookup', true, $_tmp, $this->_tpl_vars['field_options']) : smarty_modifier_lookup($_tmp, $this->_tpl_vars['field_options'])); ?>
"
type="text" style="vertical-align: top;">
<span class="id-ff multiple">
<button type="button"><img src="<?php echo smarty_function_sugar_getimagepath(array('file' => "id-ff-down.png"), $this);?>
" id="<?php echo $this->_tpl_vars['fields']['batch_status']['name']; ?>
-image"></button><button type="button"
id="btn-clear-<?php echo $this->_tpl_vars['fields']['batch_status']['name']; ?>
-input"
title="Clear"
onclick="SUGAR.clearRelateField(this.form, '<?php echo $this->_tpl_vars['fields']['batch_status']['name']; ?>
-input', '<?php echo $this->_tpl_vars['fields']['batch_status']['name']; ?>
');sync_<?php echo $this->_tpl_vars['fields']['batch_status']['name']; ?>
()"><img src="<?php echo smarty_function_sugar_getimagepath(array('file' => "id-ff-clear.png"), $this);?>
"></button>
</span>
<?php echo '
<script>
	SUGAR.AutoComplete.'; ?>
<?php echo $this->_tpl_vars['ac_key']; ?>
<?php echo ' = [];
	'; ?>


			<?php echo '
		(function (){
			var selectElem = document.getElementById("'; ?>
<?php echo $this->_tpl_vars['fields']['batch_status']['name']; ?>
<?php echo '");
			
			if (typeof select_defaults =="undefined")
				select_defaults = [];
			
			select_defaults[selectElem.id] = {key:selectElem.value,text:\'\'};

			//get default
			for (i=0;i<selectElem.options.length;i++){
				if (selectElem.options[i].value==selectElem.value)
					select_defaults[selectElem.id].text = selectElem.options[i].innerHTML;
			}

			//SUGAR.AutoComplete.{$ac_key}.ds = 
			//get options array from vardefs
			var options = SUGAR.AutoComplete.getOptionsArray("");

			YUI().use(\'datasource\', \'datasource-jsonschema\',function (Y) {
				SUGAR.AutoComplete.'; ?>
<?php echo $this->_tpl_vars['ac_key']; ?>
<?php echo '.ds = new Y.DataSource.Function({
				    source: function (request) {
				    	var ret = [];
				    	for (i=0;i<selectElem.options.length;i++)
				    		if (!(selectElem.options[i].value==\'\' && selectElem.options[i].innerHTML==\'\'))
				    			ret.push({\'key\':selectElem.options[i].value,\'text\':selectElem.options[i].innerHTML});
				    	return ret;
				    }
				});
			});
		})();
		'; ?>

	
	<?php echo '
		YUI().use("autocomplete", "autocomplete-filters", "autocomplete-highlighters", "node","node-event-simulate", function (Y) {
	'; ?>

			
	SUGAR.AutoComplete.<?php echo $this->_tpl_vars['ac_key']; ?>
.inputNode = Y.one('#<?php echo $this->_tpl_vars['fields']['batch_status']['name']; ?>
-input');
	SUGAR.AutoComplete.<?php echo $this->_tpl_vars['ac_key']; ?>
.inputImage = Y.one('#<?php echo $this->_tpl_vars['fields']['batch_status']['name']; ?>
-image');
	SUGAR.AutoComplete.<?php echo $this->_tpl_vars['ac_key']; ?>
.inputHidden = Y.one('#<?php echo $this->_tpl_vars['fields']['batch_status']['name']; ?>
');
	
			<?php echo '
			function SyncToHidden(selectme){
				var selectElem = document.getElementById("'; ?>
<?php echo $this->_tpl_vars['fields']['batch_status']['name']; ?>
<?php echo '");
				var doSimulateChange = false;
				
				if (selectElem.value!=selectme)
					doSimulateChange=true;
				
				selectElem.value=selectme;

				for (i=0;i<selectElem.options.length;i++){
					selectElem.options[i].selected=false;
					if (selectElem.options[i].value==selectme)
						selectElem.options[i].selected=true;
				}

				if (doSimulateChange)
					SUGAR.AutoComplete.'; ?>
<?php echo $this->_tpl_vars['ac_key']; ?>
<?php echo '.inputHidden.simulate(\'change\');
			}

			//global variable 
			sync_'; ?>
<?php echo $this->_tpl_vars['fields']['batch_status']['name']; ?>
<?php echo ' = function(){
				SyncToHidden();
			}
			function syncFromHiddenToWidget(){

				var selectElem = document.getElementById("'; ?>
<?php echo $this->_tpl_vars['fields']['batch_status']['name']; ?>
<?php echo '");

				//if select no longer on page, kill timer
				if (selectElem==null || selectElem.options == null)
					return;

				var currentvalue = SUGAR.AutoComplete.'; ?>
<?php echo $this->_tpl_vars['ac_key']; ?>
<?php echo '.inputNode.get(\'value\');

				SUGAR.AutoComplete.'; ?>
<?php echo $this->_tpl_vars['ac_key']; ?>
<?php echo '.inputNode.simulate(\'keyup\');

				for (i=0;i<selectElem.options.length;i++){

					if (selectElem.options[i].value==selectElem.value && document.activeElement != document.getElementById(\''; ?>
<?php echo $this->_tpl_vars['fields']['batch_status']['name']; ?>
-input<?php echo '\'))
						SUGAR.AutoComplete.'; ?>
<?php echo $this->_tpl_vars['ac_key']; ?>
<?php echo '.inputNode.set(\'value\',selectElem.options[i].innerHTML);
				}
			}

            YAHOO.util.Event.onAvailable("'; ?>
<?php echo $this->_tpl_vars['fields']['batch_status']['name']; ?>
<?php echo '", syncFromHiddenToWidget);
		'; ?>


		SUGAR.AutoComplete.<?php echo $this->_tpl_vars['ac_key']; ?>
.minQLen = 0;
		SUGAR.AutoComplete.<?php echo $this->_tpl_vars['ac_key']; ?>
.queryDelay = 0;
		SUGAR.AutoComplete.<?php echo $this->_tpl_vars['ac_key']; ?>
.numOptions = <?php echo count($this->_tpl_vars['field_options']); ?>
;
		if(SUGAR.AutoComplete.<?php echo $this->_tpl_vars['ac_key']; ?>
.numOptions >= 300) <?php echo '{
			'; ?>

			SUGAR.AutoComplete.<?php echo $this->_tpl_vars['ac_key']; ?>
.minQLen = 1;
			SUGAR.AutoComplete.<?php echo $this->_tpl_vars['ac_key']; ?>
.queryDelay = 200;
			<?php echo '
		}
		'; ?>

		if(SUGAR.AutoComplete.<?php echo $this->_tpl_vars['ac_key']; ?>
.numOptions >= 3000) <?php echo '{
			'; ?>

			SUGAR.AutoComplete.<?php echo $this->_tpl_vars['ac_key']; ?>
.minQLen = 1;
			SUGAR.AutoComplete.<?php echo $this->_tpl_vars['ac_key']; ?>
.queryDelay = 500;
			<?php echo '
		}
		'; ?>

		
	SUGAR.AutoComplete.<?php echo $this->_tpl_vars['ac_key']; ?>
.optionsVisible = false;
	
	<?php echo '
	SUGAR.AutoComplete.'; ?>
<?php echo $this->_tpl_vars['ac_key']; ?>
<?php echo '.inputNode.plug(Y.Plugin.AutoComplete, {
		activateFirstItem: true,
		'; ?>

		minQueryLength: SUGAR.AutoComplete.<?php echo $this->_tpl_vars['ac_key']; ?>
.minQLen,
		queryDelay: SUGAR.AutoComplete.<?php echo $this->_tpl_vars['ac_key']; ?>
.queryDelay,
		zIndex: 99999,

				
		<?php echo '
		source: SUGAR.AutoComplete.'; ?>
<?php echo $this->_tpl_vars['ac_key']; ?>
<?php echo '.ds,
		
		resultTextLocator: \'text\',
		resultHighlighter: \'phraseMatch\',
		resultFilters: \'phraseMatch\',
	});

	SUGAR.AutoComplete.'; ?>
<?php echo $this->_tpl_vars['ac_key']; ?>
<?php echo '.expandHover = function(ex){
		var hover = YAHOO.util.Dom.getElementsByClassName(\'dccontent\');
		if(hover[0] != null){
			if (ex) {
				var h = \'1000px\';
				hover[0].style.height = h;
			}
			else{
				hover[0].style.height = \'\';
			}
		}
	}
		
	if('; ?>
SUGAR.AutoComplete.<?php echo $this->_tpl_vars['ac_key']; ?>
.minQLen<?php echo ' == 0){
		// expand the dropdown options upon focus
		SUGAR.AutoComplete.'; ?>
<?php echo $this->_tpl_vars['ac_key']; ?>
<?php echo '.inputNode.on(\'focus\', function () {
			SUGAR.AutoComplete.'; ?>
<?php echo $this->_tpl_vars['ac_key']; ?>
<?php echo '.inputNode.ac.sendRequest(\'\');
			SUGAR.AutoComplete.'; ?>
<?php echo $this->_tpl_vars['ac_key']; ?>
<?php echo '.optionsVisible = true;
		});
	}

			SUGAR.AutoComplete.'; ?>
<?php echo $this->_tpl_vars['ac_key']; ?>
<?php echo '.inputNode.on(\'click\', function(e) {
			SUGAR.AutoComplete.'; ?>
<?php echo $this->_tpl_vars['ac_key']; ?>
<?php echo '.inputHidden.simulate(\'click\');
		});
		
		SUGAR.AutoComplete.'; ?>
<?php echo $this->_tpl_vars['ac_key']; ?>
<?php echo '.inputNode.on(\'dblclick\', function(e) {
			SUGAR.AutoComplete.'; ?>
<?php echo $this->_tpl_vars['ac_key']; ?>
<?php echo '.inputHidden.simulate(\'dblclick\');
		});

		SUGAR.AutoComplete.'; ?>
<?php echo $this->_tpl_vars['ac_key']; ?>
<?php echo '.inputNode.on(\'focus\', function(e) {
			SUGAR.AutoComplete.'; ?>
<?php echo $this->_tpl_vars['ac_key']; ?>
<?php echo '.inputHidden.simulate(\'focus\');
		});

		SUGAR.AutoComplete.'; ?>
<?php echo $this->_tpl_vars['ac_key']; ?>
<?php echo '.inputNode.on(\'mouseup\', function(e) {
			SUGAR.AutoComplete.'; ?>
<?php echo $this->_tpl_vars['ac_key']; ?>
<?php echo '.inputHidden.simulate(\'mouseup\');
		});

		SUGAR.AutoComplete.'; ?>
<?php echo $this->_tpl_vars['ac_key']; ?>
<?php echo '.inputNode.on(\'mousedown\', function(e) {
			SUGAR.AutoComplete.'; ?>
<?php echo $this->_tpl_vars['ac_key']; ?>
<?php echo '.inputHidden.simulate(\'mousedown\');
		});

		SUGAR.AutoComplete.'; ?>
<?php echo $this->_tpl_vars['ac_key']; ?>
<?php echo '.inputNode.on(\'blur\', function(e) {
			SUGAR.AutoComplete.'; ?>
<?php echo $this->_tpl_vars['ac_key']; ?>
<?php echo '.inputHidden.simulate(\'blur\');
			SUGAR.AutoComplete.'; ?>
<?php echo $this->_tpl_vars['ac_key']; ?>
<?php echo '.optionsVisible = false;
			var selectElem = document.getElementById("'; ?>
<?php echo $this->_tpl_vars['fields']['batch_status']['name']; ?>
<?php echo '");
			//if typed value is a valid option, do nothing
			for (i=0;i<selectElem.options.length;i++)
				if (selectElem.options[i].innerHTML==SUGAR.AutoComplete.'; ?>
<?php echo $this->_tpl_vars['ac_key']; ?>
<?php echo '.inputNode.get(\'value\'))
					return;
			
			//typed value is invalid, so set the text and the hidden to blank
			SUGAR.AutoComplete.'; ?>
<?php echo $this->_tpl_vars['ac_key']; ?>
<?php echo '.inputNode.set(\'value\', select_defaults[selectElem.id].text);
			SyncToHidden(select_defaults[selectElem.id].key);
		});
	
	// when they click on the arrow image, toggle the visibility of the options
	SUGAR.AutoComplete.'; ?>
<?php echo $this->_tpl_vars['ac_key']; ?>
<?php echo '.inputImage.ancestor().on(\'click\', function () {
		if (SUGAR.AutoComplete.'; ?>
<?php echo $this->_tpl_vars['ac_key']; ?>
<?php echo '.optionsVisible) {
			SUGAR.AutoComplete.'; ?>
<?php echo $this->_tpl_vars['ac_key']; ?>
<?php echo '.inputNode.blur();
		} else {
			SUGAR.AutoComplete.'; ?>
<?php echo $this->_tpl_vars['ac_key']; ?>
<?php echo '.inputNode.focus();
		}
	});

	SUGAR.AutoComplete.'; ?>
<?php echo $this->_tpl_vars['ac_key']; ?>
<?php echo '.inputNode.ac.on(\'query\', function () {
		SUGAR.AutoComplete.'; ?>
<?php echo $this->_tpl_vars['ac_key']; ?>
<?php echo '.inputHidden.set(\'value\', \'\');
	});

	SUGAR.AutoComplete.'; ?>
<?php echo $this->_tpl_vars['ac_key']; ?>
<?php echo '.inputNode.ac.on(\'visibleChange\', function (e) {
		SUGAR.AutoComplete.'; ?>
<?php echo $this->_tpl_vars['ac_key']; ?>
<?php echo '.expandHover(e.newVal); // expand
	});

	// when they select an option, set the hidden input with the KEY, to be saved
	SUGAR.AutoComplete.'; ?>
<?php echo $this->_tpl_vars['ac_key']; ?>
<?php echo '.inputNode.ac.on(\'select\', function(e) {
		SyncToHidden(e.result.raw.key);
	});
 
});
</script> 
'; ?>

<?php endif; ?>
</tr>
<?php $this->_smarty_vars['capture']['tr'] = ob_get_contents();  $this->assign('tableRow', ob_get_contents());ob_end_clean(); ?>
<?php if ($this->_tpl_vars['fieldsUsed'] > 0): ?>
<?php echo $this->_tpl_vars['tableRow']; ?>

<?php endif; ?>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed','start' => 0,'print' => false,'assign' => 'fieldsUsed'), $this);?>

<?php ob_start(); ?>
<tr>
<td valign="top" id='fees_inr_label' width='12.5%' scope="col">
<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_FEES_INR','module' => 'te_ba_Batch'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
</td>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed'), $this);?>


<td valign="top" width='37.5%' >
<?php echo smarty_function_counter(array('name' => 'panelFieldCount'), $this);?>


<?php if (strlen ( $this->_tpl_vars['fields']['fees_inr']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['fees_inr']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['fees_inr']['value']); ?>
<?php endif; ?>  
<input type='text' name='<?php echo $this->_tpl_vars['fields']['fees_inr']['name']; ?>
'
id='<?php echo $this->_tpl_vars['fields']['fees_inr']['name']; ?>
'
size='30'
maxlength='18'value='<?php echo smarty_function_sugar_number_format(array('var' => $this->_tpl_vars['value'],'precision' => 2), $this);?>
'
title=''
tabindex='0'
>
<td valign="top" id='batch_size_label' width='12.5%' scope="col">
<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_BATCH_SIZE','module' => 'te_ba_Batch'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
<span class="required">*</span>
</td>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed'), $this);?>


<td valign="top" width='37.5%' >
<?php echo smarty_function_counter(array('name' => 'panelFieldCount'), $this);?>


<?php if (strlen ( $this->_tpl_vars['fields']['batch_size']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['batch_size']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['batch_size']['value']); ?>
<?php endif; ?>  
<input type='text' name='<?php echo $this->_tpl_vars['fields']['batch_size']['name']; ?>
' 
id='<?php echo $this->_tpl_vars['fields']['batch_size']['name']; ?>
' size='30' maxlength='5' value='<?php echo smarty_function_sugar_number_format(array('precision' => 0,'var' => $this->_tpl_vars['value']), $this);?>
' title='' tabindex='0'    >
</tr>
<?php $this->_smarty_vars['capture']['tr'] = ob_get_contents();  $this->assign('tableRow', ob_get_contents());ob_end_clean(); ?>
<?php if ($this->_tpl_vars['fieldsUsed'] > 0): ?>
<?php echo $this->_tpl_vars['tableRow']; ?>

<?php endif; ?>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed','start' => 0,'print' => false,'assign' => 'fieldsUsed'), $this);?>

<?php ob_start(); ?>
<tr>
<td valign="top" id='duration_label' width='12.5%' scope="col">
<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_DURATION','module' => 'te_ba_Batch'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
<span class="required">*</span>
</td>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed'), $this);?>


<td valign="top" width='37.5%' >
<?php echo smarty_function_counter(array('name' => 'panelFieldCount'), $this);?>


<?php if (strlen ( $this->_tpl_vars['fields']['duration']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['duration']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['duration']['value']); ?>
<?php endif; ?>  
<input type='text' name='<?php echo $this->_tpl_vars['fields']['duration']['name']; ?>
' 
id='<?php echo $this->_tpl_vars['fields']['duration']['name']; ?>
' size='30' maxlength='255' value='<?php echo smarty_function_sugar_number_format(array('precision' => 0,'var' => $this->_tpl_vars['value']), $this);?>
' title='In Months' tabindex='0'    >
<td valign="top" id='minimum_attendance_criteria_label' width='12.5%' scope="col">
<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_MINIMUM_ATTENDANCE_CRITERIA','module' => 'te_ba_Batch'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
</td>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed'), $this);?>


<td valign="top" width='37.5%' >
<?php echo smarty_function_counter(array('name' => 'panelFieldCount'), $this);?>


<?php if (strlen ( $this->_tpl_vars['fields']['minimum_attendance_criteria']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['minimum_attendance_criteria']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['minimum_attendance_criteria']['value']); ?>
<?php endif; ?>  
<input type='text' name='<?php echo $this->_tpl_vars['fields']['minimum_attendance_criteria']['name']; ?>
'
id='<?php echo $this->_tpl_vars['fields']['minimum_attendance_criteria']['name']; ?>
'
size='30'
maxlength='18'value='<?php echo smarty_function_sugar_number_format(array('var' => $this->_tpl_vars['value'],'precision' => 2), $this);?>
'
title=''
tabindex='0'
>
</tr>
<?php $this->_smarty_vars['capture']['tr'] = ob_get_contents();  $this->assign('tableRow', ob_get_contents());ob_end_clean(); ?>
<?php if ($this->_tpl_vars['fieldsUsed'] > 0): ?>
<?php echo $this->_tpl_vars['tableRow']; ?>

<?php endif; ?>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed','start' => 0,'print' => false,'assign' => 'fieldsUsed'), $this);?>

<?php ob_start(); ?>
<tr>
<td valign="top" id='total_sessions_planned_label' width='12.5%' scope="col">
<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_TOTAL_SESSIONS_PLANNED','module' => 'te_ba_Batch'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
</td>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed'), $this);?>


<td valign="top" width='37.5%' >
<?php echo smarty_function_counter(array('name' => 'panelFieldCount'), $this);?>


<?php if (strlen ( $this->_tpl_vars['fields']['total_sessions_planned']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['total_sessions_planned']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['total_sessions_planned']['value']); ?>
<?php endif; ?>  
<input type='text' name='<?php echo $this->_tpl_vars['fields']['total_sessions_planned']['name']; ?>
' 
id='<?php echo $this->_tpl_vars['fields']['total_sessions_planned']['name']; ?>
' size='30' maxlength='255' value='<?php echo smarty_function_sugar_number_format(array('precision' => 0,'var' => $this->_tpl_vars['value']), $this);?>
' title='' tabindex='0'    >
<td valign="top" id='registration_closing_date_label' width='12.5%' scope="col">
<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_REGISTRATION_CLOSING_DATE','module' => 'te_ba_Batch'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
</td>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed'), $this);?>


<td valign="top" width='37.5%' >
<?php echo smarty_function_counter(array('name' => 'panelFieldCount'), $this);?>


<span class="dateTime">
<?php $this->assign('date_value', $this->_tpl_vars['fields']['registration_closing_date']['value']); ?>
<input class="date_input" autocomplete="off" type="text" name="<?php echo $this->_tpl_vars['fields']['registration_closing_date']['name']; ?>
" id="<?php echo $this->_tpl_vars['fields']['registration_closing_date']['name']; ?>
" value="<?php echo $this->_tpl_vars['date_value']; ?>
" title=''  tabindex='0'    size="11" maxlength="10" >
<?php ob_start(); ?>alt="<?php echo $this->_tpl_vars['APP']['LBL_ENTER_DATE']; ?>
" style="position:relative; top:6px" border="0" id="<?php echo $this->_tpl_vars['fields']['registration_closing_date']['name']; ?>
_trigger"<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('other_attributes', ob_get_contents());ob_end_clean(); ?>
<?php echo smarty_function_sugar_getimage(array('name' => 'jscalendar','ext' => ".gif",'other_attributes' => ($this->_tpl_vars['other_attributes'])), $this);?>

</span>
<script type="text/javascript">
Calendar.setup ({
inputField : "<?php echo $this->_tpl_vars['fields']['registration_closing_date']['name']; ?>
",
form : "EditView",
ifFormat : "<?php echo $this->_tpl_vars['CALENDAR_FORMAT']; ?>
",
daFormat : "<?php echo $this->_tpl_vars['CALENDAR_FORMAT']; ?>
",
button : "<?php echo $this->_tpl_vars['fields']['registration_closing_date']['name']; ?>
_trigger",
singleClick : true,
dateStr : "<?php echo $this->_tpl_vars['date_value']; ?>
",
startWeekday: <?php echo ((is_array($_tmp=@$this->_tpl_vars['CALENDAR_FDOW'])) ? $this->_run_mod_handler('default', true, $_tmp, '0') : smarty_modifier_default($_tmp, '0')); ?>
,
step : 1,
weekNumbers:false
}
);
</script>
</tr>
<?php $this->_smarty_vars['capture']['tr'] = ob_get_contents();  $this->assign('tableRow', ob_get_contents());ob_end_clean(); ?>
<?php if ($this->_tpl_vars['fieldsUsed'] > 0): ?>
<?php echo $this->_tpl_vars['tableRow']; ?>

<?php endif; ?>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed','start' => 0,'print' => false,'assign' => 'fieldsUsed'), $this);?>

<?php ob_start(); ?>
<tr>
<td valign="top" id='fees_in_usd_label' width='12.5%' scope="col">
<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_FEES_IN_USD','module' => 'te_ba_Batch'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
</td>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed'), $this);?>


<td valign="top" width='37.5%' >
<?php echo smarty_function_counter(array('name' => 'panelFieldCount'), $this);?>


<?php if (strlen ( $this->_tpl_vars['fields']['fees_in_usd']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['fees_in_usd']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['fees_in_usd']['value']); ?>
<?php endif; ?>  
<input type='text' name='<?php echo $this->_tpl_vars['fields']['fees_in_usd']['name']; ?>
'
id='<?php echo $this->_tpl_vars['fields']['fees_in_usd']['name']; ?>
'
size='30'
maxlength='18'value='<?php echo smarty_function_sugar_number_format(array('var' => $this->_tpl_vars['value'],'precision' => 2), $this);?>
'
title=''
tabindex='0'
>
<td valign="top" id='_label' width='12.5%' scope="col">
&nbsp;
</td>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed'), $this);?>


<td valign="top" width='37.5%' >
</tr>
<?php $this->_smarty_vars['capture']['tr'] = ob_get_contents();  $this->assign('tableRow', ob_get_contents());ob_end_clean(); ?>
<?php if ($this->_tpl_vars['fieldsUsed'] > 0): ?>
<?php echo $this->_tpl_vars['tableRow']; ?>

<?php endif; ?>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed','start' => 0,'print' => false,'assign' => 'fieldsUsed'), $this);?>

<?php ob_start(); ?>
<tr>
<td valign="top" id='description_label' width='12.5%' scope="col">
<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_DESCRIPTION','module' => 'te_ba_Batch'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
</td>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed'), $this);?>


<td valign="top" width='37.5%' >
<?php echo smarty_function_counter(array('name' => 'panelFieldCount'), $this);?>


<?php if (empty ( $this->_tpl_vars['fields']['description']['value'] )): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['description']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['description']['value']); ?>
<?php endif; ?>  
<textarea  id='<?php echo $this->_tpl_vars['fields']['description']['name']; ?>
' name='<?php echo $this->_tpl_vars['fields']['description']['name']; ?>
'
rows="3" 
cols="32" 
title='' tabindex="0" 
 ><?php echo $this->_tpl_vars['value']; ?>
</textarea>
<td valign="top" id='_label' width='12.5%' scope="col">
&nbsp;
</td>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed'), $this);?>


<td valign="top" width='37.5%' >
</tr>
<?php $this->_smarty_vars['capture']['tr'] = ob_get_contents();  $this->assign('tableRow', ob_get_contents());ob_end_clean(); ?>
<?php if ($this->_tpl_vars['fieldsUsed'] > 0): ?>
<?php echo $this->_tpl_vars['tableRow']; ?>

<?php endif; ?>
</table>
</div>
<?php if ($this->_tpl_vars['panelFieldCount'] == 0): ?>
<script>document.getElementById("DEFAULT").style.display='none';</script>
<?php endif; ?>
</div></div>
<?php echo '
<script type="text/javascript">SUGAR.util.doWhen("typeof initPanel == \'function\'", function() { initPanel(2, \'expanded\'); }); </script>
<!--<script type="text/javascript" src="modules/sal_sale_Invoice/views/clickjs.js"></script>
<script type="text/javascript" src="modules/sal_sale_Invoice/views/add_field_value.js"></script>
<script type="text/javascript" src="modules/sal_sale_Invoice/views/quantity_checking.js"></script>-->
<script>
	if(document.getElementById(\'detailpanel_2\'))
	document.getElementById(\'detailpanel_2\').className += \' expanded\';
</script>
'; ?>

<div class="panel panel-default">
<div class="panel-heading ">		
<div class="col-xs-10 col-sm-11 col-md-11" style="padding-left:5px;">
Installments
</div>	
</div>
</div>
<div class="edit view edit508  expanded" id="detailpanel_2">
<table cellspacing="1" cellpadding="10" border="0" width="100%" class="yui3-skin-sam edit view panelContainer" style="border:none;" id="Payment">
<tr>
<td style="padding-top:10px;">No. Of Installments</td><td style="padding-top:10px;"><input name="installment" id="installment" type="text"  value="<?php echo $this->_tpl_vars['no_of_installments']; ?>
" size="17%"/></td>
<td style="padding-top:10px;">&nbsp;</td>
</tr>
<tr>
<td style="padding-top:10px;">Initial Payment In INR <span class="required">*</td><td style="padding-top:10px;"><input name="initial_payment_inr" id="initial_payment_inr" type="text"  value="<?php echo $this->_tpl_vars['initial_payment_inr']; ?>
" size="17%"/></td>			
<td style="padding-top:10px;">Initial Payments In USD <span class="required">*</td><td style="padding-top:10px;"><input name="initial_payment_usd" type="text"  value="<?php echo $this->_tpl_vars['initial_payment_usd']; ?>
" id='initial_payment_usd' />
</td>
<td style="padding-top:10px;">Initial Payments Date <span class="required">*</td><td style="padding-top:10px;"><input name="initial_payment_date" type="text"  value="<?php echo $this->_tpl_vars['initial_payment_date']; ?>
" id='initial_payment_date' />			
<img src="themes/SuiteR/images/jscalendar.gif?v=yt-yazfsU-Y9uR7ixqf7Lg" alt="Enter Date" style="position:relative; top:-1px" border="0" id="initial_payment_date_trigger">
</td>
</tr>
<?php if (count($this->_tpl_vars['installments']) > 0): ?>
<?php $this->assign('count', 1); ?>
<?php $_from = $this->_tpl_vars['installments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['installment']):
?>
<tr id="row<?php echo $this->_tpl_vars['count']; ?>
">
<td style="padding-top:10px;">Payment <?php echo $this->_tpl_vars['count']; ?>
 In INR</td><td style="padding-top:10px;"><input name="payment_inr_<?php echo $this->_tpl_vars['count']; ?>
" id="payment_inr_<?php echo $this->_tpl_vars['count']; ?>
" type="text"  value="<?php echo $this->_tpl_vars['installment']['payment_inr']; ?>
" size="17%"/>
</td>
<td style="padding-top:10px;">Payment <?php echo $this->_tpl_vars['count']; ?>
 In USD</td>
<td style="padding-top:10px;"><input name="payment_usd_<?php echo $this->_tpl_vars['count']; ?>
" id="payment_usd_<?php echo $this->_tpl_vars['count']; ?>
" type="text"  value="<?php echo $this->_tpl_vars['installment']['payment_usd']; ?>
" size="17%"/>
<td style="padding-top:10px;">Due Date</td><td style="padding-top:10px;"><input name="due_date_<?php echo $this->_tpl_vars['count']; ?>
" type="text"  value="<?php echo $this->_tpl_vars['installment']['due_date']; ?>
" id='due_date_<?php echo $this->_tpl_vars['count']; ?>
' />
<img src="themes/SuiteR/images/jscalendar.gif?v=yt-yazfsU-Y9uR7ixqf7Lg" alt="Enter Date" style="position:relative; top:-1px" border="0" id="due_date_trigger_<?php echo $this->_tpl_vars['count']; ?>
">
</td>
</tr>
<?php $this->assign('count', $this->_tpl_vars['count']+1); ?>
<?php endforeach; endif; unset($_from); ?>
<?php else: ?>
<tr id="row1" style="display:none" >
<td style="padding-top:10px;">Payment 1 In INR</td><td style="padding-top:10px;"><input name="payment_inr_1" id="payment_inr_1" type="text"  value="" size="17%"/></td>
<td style="padding-top:10px;">Payment 1 IN USD</td><td style="padding-top:10px;"><input name="payment_usd_1" id="payment_usd_1" type="text"  value="" size="17%"/></td>
<td style="padding-top:10px;">Due Date</td><td style="padding-top:10px;"><input name="due_date_1" type="text"  value="" id='due_date_1' />
<img src="themes/SuiteR/images/jscalendar.gif?v=yt-yazfsU-Y9uR7ixqf7Lg" alt="Enter Date" style="position:relative; top:-1px" border="0" id="due_date_trigger_1">
</td>
</tr>
<tr id="row2" style="display:none">
<td style="padding-top:10px;">Payment 2 In INR</td><td style="padding-top:10px;"><input name="payment_inr_2" id="payment_inr_2" type="text"  value="" size="17%"/></td>
<td style="padding-top:10px;">Payment 2 In USD</td><td style="padding-top:10px;"><input name="payment_usd_2" id="payment_usd_2" type="text"  value="" size="17%"/></td>
<td style="padding-top:10px;">Due Date</td><td style="padding-top:10px;"><input name="due_date_2" type="text"  value="" id='due_date_2' />
<img src="themes/SuiteR/images/jscalendar.gif?v=yt-yazfsU-Y9uR7ixqf7Lg" alt="Enter Date" style="position:relative; top:-1px" border="0" id="due_date_trigger_2">
</td>
</tr>
<tr id="row3" style="display:none">
<td style="padding-top:10px;">Payment 3 In INR</td><td style="padding-top:10px;"><input name="payment_inr_3" id="payment_inr_3" type="text"  value="" size="17%"/></td>
<td style="padding-top:10px;">Payment 3 In USD</td><td style="padding-top:10px;"><input name="payment_usd_3" id="payment_usd_3" type="text"  value="" size="17%"/></td>
<td style="padding-top:10px;">Due Date</td><td style="padding-top:10px;"><input name="due_date_3" type="text"  value="" id='due_date_3' />
<img src="themes/SuiteR/images/jscalendar.gif?v=yt-yazfsU-Y9uR7ixqf7Lg" alt="Enter Date" style="position:relative; top:-1px" border="0" id="due_date_trigger_3">
</td>
</tr>
<tr id="row4" style="display:none">
<td style="padding-top:10px;">Payment 4 In INR</td><td style="padding-top:10px;"><input name="payment_inr_4" id="payment_inr_4" type="text"  value="" size="17%"/></td>
<td style="padding-top:10px;">Payment 4 In USD</td><td style="padding-top:10px;"><input name="payment_usd_4" id="payment_usd_4" type="text"  value="" size="17%"/></td>
<td style="padding-top:10px;">Due Date</td><td style="padding-top:10px;"><input name="due_date_4" type="text"  value="" id='due_date_4' />
<img src="themes/SuiteR/images/jscalendar.gif?v=yt-yazfsU-Y9uR7ixqf7Lg" alt="Enter Date" style="position:relative; top:-1px" border="0" id="due_date_trigger_4">
</td>
</tr>
<tr id="row5" style="display:none">
<td style="padding-top:10px;">Payment 5 In INR</td><td style="padding-top:10px;"><input name="payment_inr_5" id="payment_inr_5" type="text"  value="" size="17%"/></td>
<td style="padding-top:10px;">Payment 5 In USD</td><td style="padding-top:10px;"><input name="payment_usd_5" id="payment_usd_5" type="text"  value="" size="17%"/></td>
<td style="padding-top:10px;">Due Date</td><td style="padding-top:10px;"><input name="due_date_5" type="text"  value="" id='due_date_5' />
<img src="themes/SuiteR/images/jscalendar.gif?v=yt-yazfsU-Y9uR7ixqf7Lg" alt="Enter Date" style="position:relative; top:-1px" border="0" id="due_date_trigger_5">
</td>
</tr>
<tr id="row6" style="display:none">
<td style="padding-top:10px;">Payment 6 In INR</td><td style="padding-top:10px;"><input name="payment_inr_6" id="payment_inr_6" type="text"  value="" size="17%"/></td>
<td style="padding-top:10px;">Payment 6 In USD</td><td style="padding-top:10px;"><input name="payment_usd_6" id="payment_usd_6" type="text"  value="" size="17%"/></td>
<td style="padding-top:10px;">Due Date</td><td style="padding-top:10px;"><input name="due_date_6" type="text"  value="" id='due_date_6' />
<img src="themes/SuiteR/images/jscalendar.gif?v=yt-yazfsU-Y9uR7ixqf7Lg" alt="Enter Date" style="position:relative; top:-1px" border="0" id="due_date_trigger_6">
</td>
</tr>
<tr id="row7" style="display:none">
<td style="padding-top:10px;">Payment 7 In INR</td><td style="padding-top:10px;"><input name="payment_inr_7" id="payment_inr_7" type="text"  value="" size="17%"/></td>
<td style="padding-top:10px;">Payment 7 In USD</td><td style="padding-top:10px;"><input name="payment_usd_7" id="payment_usd_7" type="text"  value="" size="17%"/></td>
<td style="padding-top:10px;">Due Date</td><td style="padding-top:10px;"><input name="due_date_7" type="text"  value="" id='due_date_7' />
<img src="themes/SuiteR/images/jscalendar.gif?v=yt-yazfsU-Y9uR7ixqf7Lg" alt="Enter Date" style="position:relative; top:-1px" border="0" id="due_date_trigger_7">
</td>
</tr>
<tr id="row8" style="display:none">
<td style="padding-top:10px;">Payment 8 In INR</td><td style="padding-top:10px;"><input name="payment_inr_8" id="payment_inr_8" type="text"  value="" size="17%"/></td>
<td style="padding-top:10px;">Payment 8 In USD</td><td style="padding-top:10px;"><input name="payment_usd_8" id="payment_usd_8" type="text"  value="" size="17%"/></td>
<td style="padding-top:10px;">Due Date</td><td style="padding-top:10px;"><input name="due_date_8" type="text"  value="" id='due_date_8' />
<img src="themes/SuiteR/images/jscalendar.gif?v=yt-yazfsU-Y9uR7ixqf7Lg" alt="Enter Date" style="position:relative; top:-1px" border="0" id="due_date_trigger_8">
</td>
</tr>
<tr id="row9" style="display:none">
<td style="padding-top:10px;">Payment 9 In INR</td><td style="padding-top:10px;"><input name="payment_inr_9" id="payment_inr_9" type="text"  value="" size="17%"/></td>
<td style="padding-top:10px;">Payment 9 In USD</td><td style="padding-top:10px;"><input name="payment_usd_9" id="payment_usd_9" type="text"  value="" size="17%"/></td>
<td style="padding-top:10px;">Due Date</td><td style="padding-top:10px;"><input name="due_date_9" type="text"  value="" id='due_date_9' />
<img src="themes/SuiteR/images/jscalendar.gif?v=yt-yazfsU-Y9uR7ixqf7Lg" alt="Enter Date" style="position:relative; top:-1px" border="0" id="due_date_trigger_9">
</td>
</tr>
<tr id="row10" style="display:none">
<td style="padding-top:10px;">Payment 10 In INR</td><td style="padding-top:10px;"><input name="payment_inr_10" id="payment_inr_10" type="text"  value="" size="17%"/></td>
<td style="padding-top:10px;">Payment 10 In USD</td><td style="padding-top:10px;"><input name="payment_usd_10" id="payment_usd_10" type="text"  value="" size="17%"/></td>
<td style="padding-top:10px;">Due Date</td><td style="padding-top:10px;"><input name="due_date_10" type="text"  value="" id='due_date_10' />
<img src="themes/SuiteR/images/jscalendar.gif?v=yt-yazfsU-Y9uR7ixqf7Lg" alt="Enter Date" style="position:relative; top:-1px" border="0" id="due_date_trigger_10">
</td>
</tr>
<?php endif; ?>
</table>		
<div id="addedRows"></div>
</div>
<?php echo '
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> -->
<script type="text/javascript">
$(document).ready(function(){
	$(\'#installment\').blur(function (){
		 var installment = $("#installment").val();
		   hideRows();
		   addMoreRows(installment);
	});
	function hideRows() {
		for(rowCount=1;rowCount<=10;rowCount++){
			document.getElementById("row"+rowCount).style.display="none";
		}		
	}
	function addMoreRows(installment) {
		for(rowCount=1;rowCount<=installment;rowCount++){
			document.getElementById("row"+rowCount).style.display="";
		}		
	}
	
});
Calendar.setup ({
   inputField : "initial_payment_date",
   daFormat : "%d/%m/%Y %I:%M%P",
   button : "initial_payment_date_trigger",
   singleClick : true,
   dateStr : "",
   step : 1,
   weekNumbers:false,
});
Calendar.setup ({
   inputField : "due_date_1",
   daFormat : "%d/%m/%Y %I:%M%P",
   button : "due_date_trigger_1",
   singleClick : true,
   dateStr : "",
   step : 1,
   weekNumbers:false,
});
Calendar.setup ({
   inputField : "due_date_2",
   daFormat : "%d/%m/%Y %I:%M%P",
   button : "due_date_trigger_2",
   singleClick : true,
   dateStr : "",
   step : 1,
   weekNumbers:false,
});
Calendar.setup ({
   inputField : "due_date_3",
   daFormat : "%d/%m/%Y %I:%M%P",
   button : "due_date_trigger_3",
   singleClick : true,
   dateStr : "",
   step : 1,
   weekNumbers:false,
});
Calendar.setup ({
   inputField : "due_date_4",
   daFormat : "%d/%m/%Y %I:%M%P",
   button : "due_date_trigger_4",
   singleClick : true,
   dateStr : "",
   step : 1,
   weekNumbers:false,
});
Calendar.setup ({
   inputField : "due_date_5",
   daFormat : "%d/%m/%Y %I:%M%P",
   button : "due_date_trigger_5",
   singleClick : true,
   dateStr : "",
   step : 1,
   weekNumbers:false,
});
Calendar.setup ({
   inputField : "due_date_6",
   daFormat : "%d/%m/%Y %I:%M%P",
   button : "due_date_trigger_6",
   singleClick : true,
   dateStr : "",
   step : 1,
   weekNumbers:false,
});
Calendar.setup ({
   inputField : "due_date_7",
   daFormat : "%d/%m/%Y %I:%M%P",
   button : "due_date_trigger_7",
   singleClick : true,
   dateStr : "",
   step : 1,
   weekNumbers:false,
});
Calendar.setup ({
   inputField : "due_date_8",
   daFormat : "%d/%m/%Y %I:%M%P",
   button : "due_date_trigger_8",
   singleClick : true,
   dateStr : "",
   step : 1,
   weekNumbers:false,
});
Calendar.setup ({
   inputField : "due_date_9",
   daFormat : "%d/%m/%Y %I:%M%P",
   button : "due_date_trigger_9",
   singleClick : true,
   dateStr : "",
   step : 1,
   weekNumbers:false,
});
Calendar.setup ({
   inputField : "due_date_10",
   daFormat : "%d/%/%Y %I:%M%P",
   button : "due_date_trigger_10",
   singleClick : true,
   dateStr : "",
   step : 1,
   weekNumbers:false,
});
</script>
'; ?>


<script language="javascript">
    var _form_id = '<?php echo $this->_tpl_vars['form_id']; ?>
';
    <?php echo '
    SUGAR.util.doWhen(function(){
        _form_id = (_form_id == \'\') ? \'EditView\' : _form_id;
        return document.getElementById(_form_id) != null;
    }, SUGAR.themes.actionMenu);
    '; ?>

</script>
<?php $this->assign('place', '_FOOTER'); ?> <!-- to be used for id for buttons with custom code in def files-->
<div class="buttons">
<div class="action_buttons"><?php if ($this->_tpl_vars['bean']->aclAccess('save')): ?><input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="button primary" onclick="var _form = document.getElementById('EditView'); <?php if ($this->_tpl_vars['isDuplicate']): ?>_form.return_id.value=''; <?php endif; ?>_form.action.value='Save'; if(check_form('EditView'))SUGAR.ajaxUI.submitForm(_form);return false;" type="submit" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
" id="SAVE_FOOTER"><?php endif; ?>  <?php if (! empty ( $_REQUEST['return_action'] ) && ( $_REQUEST['return_action'] == 'DetailView' && ! empty ( $_REQUEST['return_id'] ) )): ?><input title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_KEY']; ?>
" class="button" onclick="SUGAR.ajaxUI.loadContent('index.php?action=DetailView&module=<?php echo ((is_array($_tmp=$_REQUEST['return_module'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
&record=<?php echo ((is_array($_tmp=$_REQUEST['return_id'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
'); return false;" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
" type="button" id="CANCEL_FOOTER"> <?php elseif (! empty ( $_REQUEST['return_action'] ) && ( $_REQUEST['return_action'] == 'DetailView' && ! empty ( $this->_tpl_vars['fields']['id']['value'] ) )): ?><input title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_KEY']; ?>
" class="button" onclick="SUGAR.ajaxUI.loadContent('index.php?action=DetailView&module=<?php echo ((is_array($_tmp=$_REQUEST['return_module'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
&record=<?php echo $this->_tpl_vars['fields']['id']['value']; ?>
'); return false;" type="button" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
" id="CANCEL_FOOTER"> <?php elseif (! empty ( $_REQUEST['return_action'] ) && ( $_REQUEST['return_action'] == 'DetailView' && empty ( $this->_tpl_vars['fields']['id']['value'] ) ) && empty ( $_REQUEST['return_id'] )): ?><input title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_KEY']; ?>
" class="button" onclick="SUGAR.ajaxUI.loadContent('index.php?action=ListView&module=<?php echo ((is_array($_tmp=$_REQUEST['return_module'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
&record=<?php echo $this->_tpl_vars['fields']['id']['value']; ?>
'); return false;" type="button" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
" id="CANCEL_FOOTER"> <?php elseif (! empty ( $_REQUEST['return_action'] ) && ! empty ( $_REQUEST['return_module'] )): ?><input title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_KEY']; ?>
" class="button" onclick="SUGAR.ajaxUI.loadContent('index.php?action=<?php echo $_REQUEST['return_action']; ?>
&module=<?php echo ((is_array($_tmp=$_REQUEST['return_module'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
'); return false;" type="button" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
" id="CANCEL_FOOTER"> <?php elseif (empty ( $_REQUEST['return_action'] ) || empty ( $_REQUEST['return_id'] ) && ! empty ( $this->_tpl_vars['fields']['id']['value'] )): ?><input title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_KEY']; ?>
" class="button" onclick="SUGAR.ajaxUI.loadContent('index.php?action=index&module=te_ba_Batch'); return false;" type="button" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
" id="CANCEL_FOOTER"> <?php else: ?><input title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_KEY']; ?>
" class="button" onclick="SUGAR.ajaxUI.loadContent('index.php?action=index&module=<?php echo ((is_array($_tmp=$_REQUEST['return_module'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
&record=<?php echo ((is_array($_tmp=$_REQUEST['return_id'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
'); return false;" type="button" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
" id="CANCEL_FOOTER"> <?php endif; ?> <?php if ($this->_tpl_vars['bean']->aclAccess('detail')): ?><?php if (! empty ( $this->_tpl_vars['fields']['id']['value'] ) && $this->_tpl_vars['isAuditEnabled']): ?><input id="btn_view_change_log" title="<?php echo $this->_tpl_vars['APP']['LNK_VIEW_CHANGE_LOG']; ?>
" class="button" onclick='open_popup("Audit", "600", "400", "&record=<?php echo $this->_tpl_vars['fields']['id']['value']; ?>
&module_name=te_ba_Batch", true, false,  { "call_back_function":"set_return","form_name":"EditView","field_to_name_array":[] } ); return false;' type="button" value="<?php echo $this->_tpl_vars['APP']['LNK_VIEW_CHANGE_LOG']; ?>
"><?php endif; ?><?php endif; ?><div class="clear"></div></div>
</div>
</form>
<?php echo $this->_tpl_vars['set_focus_block']; ?>

<script>SUGAR.util.doWhen("document.getElementById('EditView') != null",
        function(){SUGAR.util.buildAccessKeyLabels();});
</script><script type="text/javascript">
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
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_NAME','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'date_entered_date\', \'date\', false,\'Date Created\' );
addToValidate(\'EditView\', \'date_modified_date\', \'date\', false,\'Date Modified\' );
addToValidate(\'EditView\', \'modified_user_id\', \'assigned_user_name\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_MODIFIED','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'modified_by_name\', \'relate\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_MODIFIED_NAME','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'created_by\', \'assigned_user_name\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_CREATED','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'created_by_name\', \'relate\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_CREATED','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'description\', \'text\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_DESCRIPTION','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'deleted\', \'bool\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_DELETED','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'assigned_user_id\', \'relate\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_ASSIGNED_TO_ID','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'assigned_user_name\', \'relate\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_ASSIGNED_TO_NAME','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'batch_code\', \'varchar\', true,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_BATCH_CODE','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'batch_status\', \'enum\', true,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_BATCH_STATUS','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'batch_start_date\', \'date\', true,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_BATCH_START_DATE','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'no_of_installments\', \'int\', true,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_NO_OF_INSTALLMENTS','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'batch_size\', \'int\', true,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_BATCH_SIZE','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'initial_payment_inr\', \'int\', true,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_INITIAL_PAYMENT_INR','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'initial_payment_usd\', \'int\', true,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_INITIAL_PAYMENT_USD','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'initial_payment_date\', \'date\', true,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_INITIAL_PAYMENT_DATE','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidateRange(\'EditView\', \'duration\', \'int\', true, \''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_DURATION','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\', false, 60);
addToValidate(\'EditView\', \'total_sessions_planned\', \'int\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_TOTAL_SESSIONS_PLANNED','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'fees_inr\', \'float\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_FEES_INR','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'fees_in_usd\', \'float\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_FEES_IN_USD','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'registration_closing_date\', \'date\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_REGISTRATION_CLOSING_DATE','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'minimum_attendance_criteria\', \'float\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_MINIMUM_ATTENDANCE_CRITERIA','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'te_in_institutes_te_ba_batch_1_name\', \'relate\', true,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_TE_IN_INSTITUTES_TE_BA_BATCH_1_FROM_TE_IN_INSTITUTES_TITLE','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'class_schedule_c\', \'text\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_CLASS_SCHEDULE','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'batch_start_date1\', \'date\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_BATCH_START_DATE','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'enrolled_students_c\', \'varchar\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_ENROLLED_STUDENTS','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'minimum_batch_size_c\', \'varchar\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_MINIMUM_BATCH_SIZE','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'EditView\', \'te_pr_programs_te_ba_batch_1_name\', \'relate\', true,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_TE_PR_PROGRAMS_TE_BA_BATCH_1_FROM_TE_PR_PROGRAMS_TITLE','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidateBinaryDependency(\'EditView\', \'assigned_user_name\', \'alpha\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'ERR_SQS_NO_MATCH_FIELD','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo ': '; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_ASSIGNED_TO','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\', \'assigned_user_id\' );
addToValidateBinaryDependency(\'EditView\', \'te_in_institutes_te_ba_batch_1_name\', \'alpha\', true,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'ERR_SQS_NO_MATCH_FIELD','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo ': '; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_TE_IN_INSTITUTES_TE_BA_BATCH_1_FROM_TE_IN_INSTITUTES_TITLE','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\', \'te_in_institutes_te_ba_batch_1te_in_institutes_ida\' );
addToValidateBinaryDependency(\'EditView\', \'te_pr_programs_te_ba_batch_1_name\', \'alpha\', true,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'ERR_SQS_NO_MATCH_FIELD','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo ': '; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_TE_PR_PROGRAMS_TE_BA_BATCH_1_FROM_TE_PR_PROGRAMS_TITLE','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\', \'te_pr_programs_te_ba_batch_1te_pr_programs_ida\' );
</script><script language="javascript">if(typeof sqs_objects == \'undefined\'){var sqs_objects = new Array;}sqs_objects[\'EditView_te_in_institutes_te_ba_batch_1_name\']={"form":"EditView","method":"query","modules":["te_in_institutes"],"group":"or","field_list":["name","id"],"populate_list":["te_in_institutes_te_ba_batch_1_name","te_in_institutes_te_ba_batch_1te_in_institutes_ida"],"required_list":["parent_id"],"conditions":[{"name":"name","op":"like_custom","end":"%","value":""}],"order":"name","limit":"30","no_match_text":"No Match"};sqs_objects[\'EditView_te_pr_programs_te_ba_batch_1_name\']={"form":"EditView","method":"query","modules":["te_pr_Programs"],"group":"or","field_list":["name","id"],"populate_list":["te_pr_programs_te_ba_batch_1_name","te_pr_programs_te_ba_batch_1te_pr_programs_ida"],"required_list":["parent_id"],"conditions":[{"name":"name","op":"like_custom","end":"%","value":""}],"order":"name","limit":"30","no_match_text":"No Match"};</script>'; ?>
