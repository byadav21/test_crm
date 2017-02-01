<?php /* Smarty version 2.6.29, created on 2017-02-01 07:21:14
         compiled from cache/modules/Import/Leadsdate_of_callback.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sugar_getimage', 'cache/modules/Import/Leadsdate_of_callback.tpl', 8, false),array('function', 'sugar_getjspath', 'cache/modules/Import/Leadsdate_of_callback.tpl', 24, false),array('modifier', 'default', 'cache/modules/Import/Leadsdate_of_callback.tpl', 54, false),)), $this); ?>


<table border="0" cellpadding="0" cellspacing="0" class="dateTime">
<tr valign="middle">
<td nowrap>
<input autocomplete="off" type="text" id="<?php echo $this->_tpl_vars['fields']['date_of_callback']['name']; ?>
_date" value="<?php echo $this->_tpl_vars['fields'][$this->_tpl_vars['fields']['date_of_callback']['name']]['value']; ?>
" size="11" maxlength="10" title='' tabindex="1" onblur="combo_<?php echo $this->_tpl_vars['fields']['date_of_callback']['name']; ?>
.update();" onchange="combo_<?php echo $this->_tpl_vars['fields']['date_of_callback']['name']; ?>
.update(); "    >
<?php ob_start(); ?>alt="<?php echo $this->_tpl_vars['APP']['LBL_ENTER_DATE']; ?>
" style="position:relative; top:6px" border="0" id="<?php echo $this->_tpl_vars['fields']['date_of_callback']['name']; ?>
_trigger"<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('other_attributes', ob_get_contents());ob_end_clean(); ?>
<?php echo smarty_function_sugar_getimage(array('name' => 'jscalendar','ext' => ".gif",'other_attributes' => ($this->_tpl_vars['other_attributes'])), $this);?>
&nbsp;
</td>
<td nowrap>
<div id="<?php echo $this->_tpl_vars['fields']['date_of_callback']['name']; ?>
_time_section"></div>
</td>
</tr>
<tr valign="middle">
<td nowrap>
<span class="dateFormat"><?php echo $this->_tpl_vars['USER_DATEFORMAT']; ?>
</span>
</td>
<td nowrap>
<span class="dateFormat"><?php echo $this->_tpl_vars['TIME_FORMAT']; ?>
</span>
</td>
</tr>
</table>
<input type="hidden" class="DateTimeCombo" id="<?php echo $this->_tpl_vars['fields']['date_of_callback']['name']; ?>
" name="<?php echo $this->_tpl_vars['fields']['date_of_callback']['name']; ?>
" value="<?php echo $this->_tpl_vars['fields'][$this->_tpl_vars['fields']['date_of_callback']['name']]['value']; ?>
">
<script type="text/javascript" src="<?php echo smarty_function_sugar_getjspath(array('file' => "include/SugarFields/Fields/Datetimecombo/Datetimecombo.js"), $this);?>
"></script>
<script type="text/javascript">
var combo_<?php echo $this->_tpl_vars['fields']['date_of_callback']['name']; ?>
 = new Datetimecombo("<?php echo $this->_tpl_vars['fields'][$this->_tpl_vars['fields']['date_of_callback']['name']]['value']; ?>
", "<?php echo $this->_tpl_vars['fields']['date_of_callback']['name']; ?>
", "<?php echo $this->_tpl_vars['TIME_FORMAT']; ?>
", "1", '', false, true);
//Render the remaining widget fields
text = combo_<?php echo $this->_tpl_vars['fields']['date_of_callback']['name']; ?>
.html('');
document.getElementById('<?php echo $this->_tpl_vars['fields']['date_of_callback']['name']; ?>
_time_section').innerHTML = text;

//Call eval on the update function to handle updates to calendar picker object
eval(combo_<?php echo $this->_tpl_vars['fields']['date_of_callback']['name']; ?>
.jsscript(''));

//bug 47718: this causes too many addToValidates to be called, resulting in the error messages being displayed multiple times
//    removing it here to mirror the Datetime SugarField, where the validation is not added at this level
//addToValidate('<?php echo $this->_tpl_vars['form_name']; ?>
',"<?php echo $this->_tpl_vars['fields']['date_of_callback']['name']; ?>
_date",'date',false,"<?php echo $this->_tpl_vars['fields']['date_of_callback']['name']; ?>
");
addToValidateBinaryDependency('<?php echo $this->_tpl_vars['form_name']; ?>
',"<?php echo $this->_tpl_vars['fields']['date_of_callback']['name']; ?>
_hours", 'alpha', false, "<?php echo $this->_tpl_vars['APP']['ERR_MISSING_REQUIRED_FIELDS']; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_HOURS']; ?>
" ,"<?php echo $this->_tpl_vars['fields']['date_of_callback']['name']; ?>
_date");
addToValidateBinaryDependency('<?php echo $this->_tpl_vars['form_name']; ?>
', "<?php echo $this->_tpl_vars['fields']['date_of_callback']['name']; ?>
_minutes", 'alpha', false, "<?php echo $this->_tpl_vars['APP']['ERR_MISSING_REQUIRED_FIELDS']; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_MINUTES']; ?>
" ,"<?php echo $this->_tpl_vars['fields']['date_of_callback']['name']; ?>
_date");
addToValidateBinaryDependency('<?php echo $this->_tpl_vars['form_name']; ?>
', "<?php echo $this->_tpl_vars['fields']['date_of_callback']['name']; ?>
_meridiem", 'alpha', false, "<?php echo $this->_tpl_vars['APP']['ERR_MISSING_REQUIRED_FIELDS']; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_MERIDIEM']; ?>
","<?php echo $this->_tpl_vars['fields']['date_of_callback']['name']; ?>
_date");

YAHOO.util.Event.onDOMReady(function()
{

	Calendar.setup ({
	onClose : update_<?php echo $this->_tpl_vars['fields']['date_of_callback']['name']; ?>
,
	inputField : "<?php echo $this->_tpl_vars['fields']['date_of_callback']['name']; ?>
_date",
    form : "importstep3",
	ifFormat : "<?php echo $this->_tpl_vars['CALENDAR_FORMAT']; ?>
",
	daFormat : "<?php echo $this->_tpl_vars['CALENDAR_FORMAT']; ?>
",
	button : "<?php echo $this->_tpl_vars['fields']['date_of_callback']['name']; ?>
_trigger",
	singleClick : true,
	step : 1,
	weekNumbers: false,
        startWeekday: <?php echo ((is_array($_tmp=@$this->_tpl_vars['CALENDAR_FDOW'])) ? $this->_run_mod_handler('default', true, $_tmp, '0') : smarty_modifier_default($_tmp, '0')); ?>
,
	comboObject: combo_<?php echo $this->_tpl_vars['fields']['date_of_callback']['name']; ?>

	});

	//Call update for first time to round hours and minute values
	combo_<?php echo $this->_tpl_vars['fields']['date_of_callback']['name']; ?>
.update(false);

}); 
</script>