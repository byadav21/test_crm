<?php /* Smarty version 2.6.29, created on 2017-02-01 07:21:15
         compiled from cache/modules/Import/Leadsbatch_c.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sugar_translate', 'cache/modules/Import/Leadsbatch_c.tpl', 7, false),array('function', 'sugar_getimagepath', 'cache/modules/Import/Leadsbatch_c.tpl', 18, false),)), $this); ?>

<input type="text" name="<?php echo $this->_tpl_vars['fields']['batch_c']['name']; ?>
" class="sqsEnabled" tabindex="1" id="<?php echo $this->_tpl_vars['fields']['batch_c']['name']; ?>
" size="" value="<?php echo $this->_tpl_vars['fields']['batch_c']['value']; ?>
" title='' autocomplete="off"  	 >
<input type="hidden" name="<?php echo $this->_tpl_vars['fields']['batch_c']['id_name']; ?>
" 
	id="<?php echo $this->_tpl_vars['fields']['batch_c']['id_name']; ?>
" 
	value="<?php echo $this->_tpl_vars['fields']['te_ba_batch_id_c']['value']; ?>
">
<span class="id-ff multiple">
<button type="button" name="btn_<?php echo $this->_tpl_vars['fields']['batch_c']['name']; ?>
" id="btn_<?php echo $this->_tpl_vars['fields']['batch_c']['name']; ?>
" tabindex="1" title="<?php echo smarty_function_sugar_translate(array('label' => 'LBL_SELECT_BUTTON_TITLE'), $this);?>
" class="button firstChild" value="<?php echo smarty_function_sugar_translate(array('label' => 'LBL_SELECT_BUTTON_LABEL'), $this);?>
"
onclick='open_popup(
    "<?php echo $this->_tpl_vars['fields']['batch_c']['module']; ?>
", 
	600, 
	400, 
	"", 
	true, 
	false, 
	<?php echo '{"call_back_function":"set_return","form_name":"importstep3","field_to_name_array":{"id":"te_ba_batch_id_c","name":"batch_c"}}'; ?>
, 
	"single", 
	true
);' ><img src="<?php echo smarty_function_sugar_getimagepath(array('file' => "id-ff-select.png"), $this);?>
"></button><button type="button" name="btn_clr_<?php echo $this->_tpl_vars['fields']['batch_c']['name']; ?>
" id="btn_clr_<?php echo $this->_tpl_vars['fields']['batch_c']['name']; ?>
" tabindex="1" title="<?php echo smarty_function_sugar_translate(array('label' => 'LBL_ACCESSKEY_CLEAR_RELATE_TITLE'), $this);?>
"  class="button lastChild"
onclick="SUGAR.clearRelateField(this.form, '<?php echo $this->_tpl_vars['fields']['batch_c']['name']; ?>
', '<?php echo $this->_tpl_vars['fields']['batch_c']['id_name']; ?>
');"  value="<?php echo smarty_function_sugar_translate(array('label' => 'LBL_ACCESSKEY_CLEAR_RELATE_LABEL'), $this);?>
" ><img src="<?php echo smarty_function_sugar_getimagepath(array('file' => "id-ff-clear.png"), $this);?>
"></button>
</span>
<script type="text/javascript">
SUGAR.util.doWhen(
		"typeof(sqs_objects) != 'undefined' && typeof(sqs_objects['<?php echo $this->_tpl_vars['form_name']; ?>
_<?php echo $this->_tpl_vars['fields']['batch_c']['name']; ?>
']) != 'undefined'",
		enableQS
);
</script>