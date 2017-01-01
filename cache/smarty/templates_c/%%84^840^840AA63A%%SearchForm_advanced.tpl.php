<?php /* Smarty version 2.6.29, created on 2016-12-28 23:52:52
         compiled from cache/themes/SuiteR/modules/AOS_Contracts/SearchForm_advanced.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'cache/themes/SuiteR/modules/AOS_Contracts/SearchForm_advanced.tpl', 26, false),array('function', 'math', 'cache/themes/SuiteR/modules/AOS_Contracts/SearchForm_advanced.tpl', 27, false),array('function', 'sugar_getimagepath', 'cache/themes/SuiteR/modules/AOS_Contracts/SearchForm_advanced.tpl', 35, false),array('function', 'sugar_translate', 'cache/themes/SuiteR/modules/AOS_Contracts/SearchForm_advanced.tpl', 44, false),array('function', 'sugar_getimage', 'cache/themes/SuiteR/modules/AOS_Contracts/SearchForm_advanced.tpl', 86, false),array('function', 'html_options', 'cache/themes/SuiteR/modules/AOS_Contracts/SearchForm_advanced.tpl', 157, false),array('modifier', 'default', 'cache/themes/SuiteR/modules/AOS_Contracts/SearchForm_advanced.tpl', 172, false),)), $this); ?>

<script>
<?php echo '
	$(function() {
	var $dialog = $(\'<div></div>\')
		.html(SUGAR.language.get(\'app_strings\', \'LBL_SEARCH_HELP_TEXT\'))
		.dialog({
			autoOpen: false,
			title: SUGAR.language.get(\'app_strings\', \'LBL_SEARCH_HELP_TITLE\'),
			width: 700
		});
		
		$(\'.help-search\').click(function() {
		$dialog.dialog(\'open\');
		// prevent the default action, e.g., following a link
	});
	
	});
'; ?>

</script>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
      
      
	
	<?php echo smarty_function_counter(array('assign' => 'index'), $this);?>

	<?php echo smarty_function_math(array('equation' => "left % right",'left' => $this->_tpl_vars['index'],'right' => $this->_tpl_vars['templateMeta']['maxColumns'],'assign' => 'modVal'), $this);?>

	<?php if (( $this->_tpl_vars['index'] % $this->_tpl_vars['templateMeta']['maxColumns'] == 1 && $this->_tpl_vars['index'] != 1 )): ?>
        <?php if ($this->_tpl_vars['isHelperShown'] == 0): ?>
            <?php $this->assign('isHelperShown', '1'); ?>
            <td class="helpIcon" width="*">
                <img alt="<?php echo $this->_tpl_vars['APP']['LBL_SEARCH_HELP_TITLE']; ?>
" id="helper_popup_image" border="0" src='<?php echo smarty_function_sugar_getimagepath(array('file' => "help-dashlet.gif"), $this);?>
' class="help-search">
            </td>
        <?php else: ?>
            <td>&nbsp;</td>
        <?php endif; ?>
		</tr><tr>
	<?php endif; ?>
	
	<td scope="row" nowrap="nowrap" width='8.33333333333%' >
			<label for='name_advanced'><?php echo smarty_function_sugar_translate(array('label' => 'LBL_NAME','module' => 'AOS_Contracts'), $this);?>
</label>
		</td>
	<td  nowrap="nowrap" width='25%'>
			
<?php if (strlen ( $this->_tpl_vars['fields']['name_advanced']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['name_advanced']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['name_advanced']['value']); ?>
<?php endif; ?>  
<input type='text' name='<?php echo $this->_tpl_vars['fields']['name_advanced']['name']; ?>
' 
    id='<?php echo $this->_tpl_vars['fields']['name_advanced']['name']; ?>
' size='30' 
    maxlength='255' 
    value='<?php echo $this->_tpl_vars['value']; ?>
' title=''      accesskey='9'  >
   	   	</td>
    
      
	
	<?php echo smarty_function_counter(array('assign' => 'index'), $this);?>

	<?php echo smarty_function_math(array('equation' => "left % right",'left' => $this->_tpl_vars['index'],'right' => $this->_tpl_vars['templateMeta']['maxColumns'],'assign' => 'modVal'), $this);?>

	<?php if (( $this->_tpl_vars['index'] % $this->_tpl_vars['templateMeta']['maxColumns'] == 1 && $this->_tpl_vars['index'] != 1 )): ?>
        <?php if ($this->_tpl_vars['isHelperShown'] == 0): ?>
            <?php $this->assign('isHelperShown', '1'); ?>
            <td class="helpIcon" width="*">
                <img alt="<?php echo $this->_tpl_vars['APP']['LBL_SEARCH_HELP_TITLE']; ?>
" id="helper_popup_image" border="0" src='<?php echo smarty_function_sugar_getimagepath(array('file' => "help-dashlet.gif"), $this);?>
' class="help-search">
            </td>
        <?php else: ?>
            <td>&nbsp;</td>
        <?php endif; ?>
		</tr><tr>
	<?php endif; ?>
	
	<td scope="row" nowrap="nowrap" width='8.33333333333%' >
			<label for='contract_account_advanced'><?php echo smarty_function_sugar_translate(array('label' => 'LBL_CONTRACT_ACCOUNT','module' => 'AOS_Contracts'), $this);?>
</label>
		</td>
	<td  nowrap="nowrap" width='25%'>
			
<input type="text" name="<?php echo $this->_tpl_vars['fields']['contract_account_advanced']['name']; ?>
"  class="sqsEnabled"   id="<?php echo $this->_tpl_vars['fields']['contract_account_advanced']['name']; ?>
" size="" value="<?php echo $this->_tpl_vars['fields']['contract_account_advanced']['value']; ?>
" title='' autocomplete="off"  >
<input type="hidden"  id="<?php echo $this->_tpl_vars['fields']['contract_account_id_advanced']['name']; ?>
" value="<?php echo $this->_tpl_vars['fields']['contract_account_id_advanced']['value']; ?>
">
<span class="id-ff multiple">
<button type="button" name="btn_<?php echo $this->_tpl_vars['fields']['contract_account_advanced']['name']; ?>
"   title="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_BUTTON_TITLE']; ?>
" class="button firstChild" value="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_BUTTON_LABEL']; ?>
" onclick='open_popup("<?php echo $this->_tpl_vars['fields']['contract_account_advanced']['module']; ?>
", 600, 400, "", true, false, <?php echo '{"call_back_function":"set_return","form_name":"search_form","field_to_name_array":{"id":"contract_account_id_advanced","name":"contract_account_advanced"}}'; ?>
, "single", true);'><?php echo smarty_function_sugar_getimage(array('alt' => $this->_tpl_vars['app_strings']['LBL_ID_FF_SELECT'],'name' => "id-ff-select",'ext' => ".png",'other_attributes' => ''), $this);?>
</button><button type="button" name="btn_clr_<?php echo $this->_tpl_vars['fields']['contract_account_advanced']['name']; ?>
"   title="<?php echo $this->_tpl_vars['APP']['LBL_CLEAR_BUTTON_TITLE']; ?>
" class="button lastChild" onclick="this.form.<?php echo $this->_tpl_vars['fields']['contract_account_advanced']['name']; ?>
.value = ''; this.form.<?php echo $this->_tpl_vars['fields']['contract_account_id_advanced']['name']; ?>
.value = '';" value="<?php echo $this->_tpl_vars['APP']['LBL_CLEAR_BUTTON_LABEL']; ?>
"><?php echo smarty_function_sugar_getimage(array('name' => "id-ff-clear",'alt' => $this->_tpl_vars['app_strings']['LBL_ID_FF_CLEAR'],'ext' => ".png",'other_attributes' => ''), $this);?>
</button>
</span>

   	   	</td>
    
      
	
	<?php echo smarty_function_counter(array('assign' => 'index'), $this);?>

	<?php echo smarty_function_math(array('equation' => "left % right",'left' => $this->_tpl_vars['index'],'right' => $this->_tpl_vars['templateMeta']['maxColumns'],'assign' => 'modVal'), $this);?>

	<?php if (( $this->_tpl_vars['index'] % $this->_tpl_vars['templateMeta']['maxColumns'] == 1 && $this->_tpl_vars['index'] != 1 )): ?>
        <?php if ($this->_tpl_vars['isHelperShown'] == 0): ?>
            <?php $this->assign('isHelperShown', '1'); ?>
            <td class="helpIcon" width="*">
                <img alt="<?php echo $this->_tpl_vars['APP']['LBL_SEARCH_HELP_TITLE']; ?>
" id="helper_popup_image" border="0" src='<?php echo smarty_function_sugar_getimagepath(array('file' => "help-dashlet.gif"), $this);?>
' class="help-search">
            </td>
        <?php else: ?>
            <td>&nbsp;</td>
        <?php endif; ?>
		</tr><tr>
	<?php endif; ?>
	
	<td scope="row" nowrap="nowrap" width='8.33333333333%' >
			<label for='opportunity_advanced'><?php echo smarty_function_sugar_translate(array('label' => 'LBL_OPPORTUNITY','module' => 'AOS_Contracts'), $this);?>
</label>
		</td>
	<td  nowrap="nowrap" width='25%'>
			
<input type="text" name="<?php echo $this->_tpl_vars['fields']['opportunity_advanced']['name']; ?>
"  class="sqsEnabled"   id="<?php echo $this->_tpl_vars['fields']['opportunity_advanced']['name']; ?>
" size="" value="<?php echo $this->_tpl_vars['fields']['opportunity_advanced']['value']; ?>
" title='' autocomplete="off"  >
<input type="hidden"  id="<?php echo $this->_tpl_vars['fields']['opportunity_id_advanced']['name']; ?>
" value="<?php echo $this->_tpl_vars['fields']['opportunity_id_advanced']['value']; ?>
">
<span class="id-ff multiple">
<button type="button" name="btn_<?php echo $this->_tpl_vars['fields']['opportunity_advanced']['name']; ?>
"   title="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_BUTTON_TITLE']; ?>
" class="button firstChild" value="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_BUTTON_LABEL']; ?>
" onclick='open_popup("<?php echo $this->_tpl_vars['fields']['opportunity_advanced']['module']; ?>
", 600, 400, "", true, false, <?php echo '{"call_back_function":"set_return","form_name":"search_form","field_to_name_array":{"id":"opportunity_id_advanced","name":"opportunity_advanced"}}'; ?>
, "single", true);'><?php echo smarty_function_sugar_getimage(array('alt' => $this->_tpl_vars['app_strings']['LBL_ID_FF_SELECT'],'name' => "id-ff-select",'ext' => ".png",'other_attributes' => ''), $this);?>
</button><button type="button" name="btn_clr_<?php echo $this->_tpl_vars['fields']['opportunity_advanced']['name']; ?>
"   title="<?php echo $this->_tpl_vars['APP']['LBL_CLEAR_BUTTON_TITLE']; ?>
" class="button lastChild" onclick="this.form.<?php echo $this->_tpl_vars['fields']['opportunity_advanced']['name']; ?>
.value = ''; this.form.<?php echo $this->_tpl_vars['fields']['opportunity_id_advanced']['name']; ?>
.value = '';" value="<?php echo $this->_tpl_vars['APP']['LBL_CLEAR_BUTTON_LABEL']; ?>
"><?php echo smarty_function_sugar_getimage(array('name' => "id-ff-clear",'alt' => $this->_tpl_vars['app_strings']['LBL_ID_FF_CLEAR'],'ext' => ".png",'other_attributes' => ''), $this);?>
</button>
</span>

   	   	</td>
    
      
	
	<?php echo smarty_function_counter(array('assign' => 'index'), $this);?>

	<?php echo smarty_function_math(array('equation' => "left % right",'left' => $this->_tpl_vars['index'],'right' => $this->_tpl_vars['templateMeta']['maxColumns'],'assign' => 'modVal'), $this);?>

	<?php if (( $this->_tpl_vars['index'] % $this->_tpl_vars['templateMeta']['maxColumns'] == 1 && $this->_tpl_vars['index'] != 1 )): ?>
        <?php if ($this->_tpl_vars['isHelperShown'] == 0): ?>
            <?php $this->assign('isHelperShown', '1'); ?>
            <td class="helpIcon" width="*">
                <img alt="<?php echo $this->_tpl_vars['APP']['LBL_SEARCH_HELP_TITLE']; ?>
" id="helper_popup_image" border="0" src='<?php echo smarty_function_sugar_getimagepath(array('file' => "help-dashlet.gif"), $this);?>
' class="help-search">
            </td>
        <?php else: ?>
            <td>&nbsp;</td>
        <?php endif; ?>
		</tr><tr>
	<?php endif; ?>
	
	<td scope="row" nowrap="nowrap" width='8.33333333333%' >
			<label for='start_date_advanced'><?php echo smarty_function_sugar_translate(array('label' => 'LBL_START_DATE','module' => 'AOS_Contracts'), $this);?>
</label>
		</td>
	<td  nowrap="nowrap" width='25%'>
			
<?php $this->assign('id', $this->_tpl_vars['fields']['start_date_advanced']['name']); ?>

<?php if (isset ( $_REQUEST['start_date_advanced_range_choice'] )): ?>
<?php $this->assign('starting_choice', $_REQUEST['start_date_advanced_range_choice']); ?>
<?php else: ?>
<?php $this->assign('starting_choice', "="); ?>
<?php endif; ?>

<div style="white-space:nowrap !important;">
<select id="<?php echo $this->_tpl_vars['id']; ?>
_range_choice" name="<?php echo $this->_tpl_vars['id']; ?>
_range_choice" style="width:125px !important;" onchange="<?php echo $this->_tpl_vars['id']; ?>
_range_change(this.value);">
<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['fields']['start_date_advanced']['options'],'selected' => $this->_tpl_vars['starting_choice']), $this);?>

</select>
</div>

<div id="<?php echo $this->_tpl_vars['id']; ?>
_range_div" style="<?php if (preg_match ( '/^\[/' , $_REQUEST['range_start_date_advanced'] ) || $this->_tpl_vars['starting_choice'] == 'between'): ?>display:none<?php else: ?>display:''<?php endif; ?>;">
<input autocomplete="off" type="text" name="range_<?php echo $this->_tpl_vars['id']; ?>
" id="range_<?php echo $this->_tpl_vars['id']; ?>
" value='<?php if (empty ( $_REQUEST['range_start_date_advanced'] ) && ! empty ( $_REQUEST['start_date_advanced'] )): ?><?php echo $_REQUEST['start_date_advanced']; ?>
<?php else: ?><?php echo $_REQUEST['range_start_date_advanced']; ?>
<?php endif; ?>' title=''   size="11" style=" float:left;">
<?php ob_start(); ?>alt="<?php echo $this->_tpl_vars['APP']['LBL_ENTER_DATE']; ?>
" style="position:relative; top:36px" border="0" id="<?php echo $this->_tpl_vars['id']; ?>
_trigger"<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('other_attributes', ob_get_contents());ob_end_clean(); ?>
<?php echo smarty_function_sugar_getimage(array('name' => 'jscalendar','ext' => ".gif",'other_attributes' => ($this->_tpl_vars['other_attributes'])), $this);?>

<script type="text/javascript">
Calendar.setup ({
inputField : "range_<?php echo $this->_tpl_vars['id']; ?>
",
daFormat : "<?php echo $this->_tpl_vars['CALENDAR_FORMAT']; ?>
",
button : "<?php echo $this->_tpl_vars['id']; ?>
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
    
</div>

<div id="<?php echo $this->_tpl_vars['id']; ?>
_between_range_div" style="<?php if ($this->_tpl_vars['starting_choice'] == 'between'): ?>display:'';<?php else: ?>display:none;<?php endif; ?>">
<?php $this->assign('date_value', $this->_tpl_vars['fields']['start_date_advanced']['value']); ?>
<input autocomplete="off" type="text" name="start_range_<?php echo $this->_tpl_vars['id']; ?>
" id="start_range_<?php echo $this->_tpl_vars['id']; ?>
" value='<?php echo $_REQUEST['start_range_start_date_advanced']; ?>
' title=''  tabindex='' size="11" style="width:100px !important;">
<?php ob_start(); ?>align="absmiddle" border="0" id="start_range_<?php echo $this->_tpl_vars['id']; ?>
_trigger"<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('other_attributes', ob_get_contents());ob_end_clean(); ?>
<?php echo smarty_function_sugar_getimage(array('name' => 'jscalendar','ext' => ".gif",'alt' => ($this->_tpl_vars['APP']).".LBL_ENTER_DATE other_attributes=".($this->_tpl_vars['other_attributes'])), $this);?>

<script type="text/javascript">
Calendar.setup ({
inputField : "start_range_<?php echo $this->_tpl_vars['id']; ?>
",
daFormat : "<?php echo $this->_tpl_vars['CALENDAR_FORMAT']; ?>
",
button : "start_range_<?php echo $this->_tpl_vars['id']; ?>
_trigger",
singleClick : true,
dateStr : "<?php echo $this->_tpl_vars['date_value']; ?>
",
step : 1,
weekNumbers:false
}
);
</script>
 
<?php echo $this->_tpl_vars['APP']['LBL_AND']; ?>

<?php $this->assign('date_value', $this->_tpl_vars['fields']['start_date_advanced']['value']); ?>
<input autocomplete="off" type="text" name="end_range_<?php echo $this->_tpl_vars['id']; ?>
" id="end_range_<?php echo $this->_tpl_vars['id']; ?>
" value='<?php echo $_REQUEST['end_range_start_date_advanced']; ?>
' title=''  tabindex='' size="11" style="width:100px !important;" maxlength="10">
<?php ob_start(); ?>align="absmiddle" border="0" id="end_range_<?php echo $this->_tpl_vars['id']; ?>
_trigger"<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('other_attributes', ob_get_contents());ob_end_clean(); ?>
<?php echo smarty_function_sugar_getimage(array('name' => 'jscalendar','ext' => ".gif",'alt' => ($this->_tpl_vars['APP']).".LBL_ENTER_DATE other_attributes=".($this->_tpl_vars['other_attributes'])), $this);?>

<script type="text/javascript">
Calendar.setup ({
inputField : "end_range_<?php echo $this->_tpl_vars['id']; ?>
",
daFormat : "<?php echo $this->_tpl_vars['CALENDAR_FORMAT']; ?>
",
button : "end_range_<?php echo $this->_tpl_vars['id']; ?>
_trigger",
singleClick : true,
dateStr : "<?php echo $this->_tpl_vars['date_value']; ?>
",
step : 1,
weekNumbers:false
}
);
</script>
 
</div>


<script type='text/javascript'>

function <?php echo $this->_tpl_vars['id']; ?>
_range_change(val) 
{
  if(val == 'between') {
     document.getElementById("range_<?php echo $this->_tpl_vars['id']; ?>
").value = '';  
     document.getElementById("<?php echo $this->_tpl_vars['id']; ?>
_range_div").style.display = 'none';
     document.getElementById("<?php echo $this->_tpl_vars['id']; ?>
_between_range_div").style.display = ''; 
  } else if (val == '=' || val == 'not_equal' || val == 'greater_than' || val == 'less_than') {
     if((/^\[.*\]$/).test(document.getElementById("range_<?php echo $this->_tpl_vars['id']; ?>
").value))
     {
     	document.getElementById("range_<?php echo $this->_tpl_vars['id']; ?>
").value = '';
     }
     document.getElementById("start_range_<?php echo $this->_tpl_vars['id']; ?>
").value = '';
     document.getElementById("end_range_<?php echo $this->_tpl_vars['id']; ?>
").value = '';
     document.getElementById("<?php echo $this->_tpl_vars['id']; ?>
_range_div").style.display = '';
     document.getElementById("<?php echo $this->_tpl_vars['id']; ?>
_between_range_div").style.display = 'none';
  } else {
     document.getElementById("range_<?php echo $this->_tpl_vars['id']; ?>
").value = '[' + val + ']';    
     document.getElementById("start_range_<?php echo $this->_tpl_vars['id']; ?>
").value = '';
     document.getElementById("end_range_<?php echo $this->_tpl_vars['id']; ?>
").value = ''; 
     document.getElementById("<?php echo $this->_tpl_vars['id']; ?>
_range_div").style.display = 'none';
     document.getElementById("<?php echo $this->_tpl_vars['id']; ?>
_between_range_div").style.display = 'none';         
  }
}

var <?php echo $this->_tpl_vars['id']; ?>
_range_reset = function()
{
<?php echo $this->_tpl_vars['id']; ?>
_range_change('=');
}

YAHOO.util.Event.onDOMReady(function() {
if(document.getElementById('search_form_clear'))
{
YAHOO.util.Event.addListener('search_form_clear', 'click', <?php echo $this->_tpl_vars['id']; ?>
_range_reset);
}

});

YAHOO.util.Event.onDOMReady(function() {
 	if(document.getElementById('search_form_clear_advanced'))
 	 {
 	     YAHOO.util.Event.addListener('search_form_clear_advanced', 'click', <?php echo $this->_tpl_vars['id']; ?>
_range_reset);
 	 }

});

YAHOO.util.Event.onDOMReady(function() {
    //register on basic search form button if it exists
    if(document.getElementById('search_form_submit'))
     {
         YAHOO.util.Event.addListener('search_form_submit', 'click',<?php echo $this->_tpl_vars['id']; ?>
_range_validate);
     }
    //register on advanced search submit button if it exists
   if(document.getElementById('search_form_submit_advanced'))
    {
        YAHOO.util.Event.addListener('search_form_submit_advanced', 'click',<?php echo $this->_tpl_vars['id']; ?>
_range_validate);
    }

});

// this function is specific to range date searches and will check that both start and end date ranges have been
// filled prior to submitting search form.  It is called from the listener added above.
function <?php echo $this->_tpl_vars['id']; ?>
_range_validate(e){
    if (
            (document.getElementById("start_range_<?php echo $this->_tpl_vars['id']; ?>
").value.length >0 && document.getElementById("end_range_<?php echo $this->_tpl_vars['id']; ?>
").value.length == 0)
          ||(document.getElementById("end_range_<?php echo $this->_tpl_vars['id']; ?>
").value.length >0 && document.getElementById("start_range_<?php echo $this->_tpl_vars['id']; ?>
").value.length == 0)
       )
    {
        e.preventDefault();
        alert('<?php echo $this->_tpl_vars['APP']['LBL_CHOOSE_START_AND_END_DATES']; ?>
');
        if (document.getElementById("start_range_<?php echo $this->_tpl_vars['id']; ?>
").value.length == 0) {
            document.getElementById("start_range_<?php echo $this->_tpl_vars['id']; ?>
").focus();
        }
        else {
            document.getElementById("end_range_<?php echo $this->_tpl_vars['id']; ?>
").focus();
        }
    }

}

</script>
   	   	</td>
    
      
	
	<?php echo smarty_function_counter(array('assign' => 'index'), $this);?>

	<?php echo smarty_function_math(array('equation' => "left % right",'left' => $this->_tpl_vars['index'],'right' => $this->_tpl_vars['templateMeta']['maxColumns'],'assign' => 'modVal'), $this);?>

	<?php if (( $this->_tpl_vars['index'] % $this->_tpl_vars['templateMeta']['maxColumns'] == 1 && $this->_tpl_vars['index'] != 1 )): ?>
        <?php if ($this->_tpl_vars['isHelperShown'] == 0): ?>
            <?php $this->assign('isHelperShown', '1'); ?>
            <td class="helpIcon" width="*">
                <img alt="<?php echo $this->_tpl_vars['APP']['LBL_SEARCH_HELP_TITLE']; ?>
" id="helper_popup_image" border="0" src='<?php echo smarty_function_sugar_getimagepath(array('file' => "help-dashlet.gif"), $this);?>
' class="help-search">
            </td>
        <?php else: ?>
            <td>&nbsp;</td>
        <?php endif; ?>
		</tr><tr>
	<?php endif; ?>
	
	<td scope="row" nowrap="nowrap" width='8.33333333333%' >
			<label for='contract_type_advanced'><?php echo smarty_function_sugar_translate(array('label' => 'LBL_CONTRACT_TYPE','module' => 'AOS_Contracts'), $this);?>
</label>
		</td>
	<td  nowrap="nowrap" width='25%'>
			
<?php echo smarty_function_html_options(array('id' => 'contract_type_advanced','name' => 'contract_type_advanced[]','options' => $this->_tpl_vars['fields']['contract_type_advanced']['options'],'size' => '6','style' => "width: 150px",'multiple' => '1','selected' => $this->_tpl_vars['fields']['contract_type_advanced']['value']), $this);?>

   	   	</td>
    
      
	
	<?php echo smarty_function_counter(array('assign' => 'index'), $this);?>

	<?php echo smarty_function_math(array('equation' => "left % right",'left' => $this->_tpl_vars['index'],'right' => $this->_tpl_vars['templateMeta']['maxColumns'],'assign' => 'modVal'), $this);?>

	<?php if (( $this->_tpl_vars['index'] % $this->_tpl_vars['templateMeta']['maxColumns'] == 1 && $this->_tpl_vars['index'] != 1 )): ?>
        <?php if ($this->_tpl_vars['isHelperShown'] == 0): ?>
            <?php $this->assign('isHelperShown', '1'); ?>
            <td class="helpIcon" width="*">
                <img alt="<?php echo $this->_tpl_vars['APP']['LBL_SEARCH_HELP_TITLE']; ?>
" id="helper_popup_image" border="0" src='<?php echo smarty_function_sugar_getimagepath(array('file' => "help-dashlet.gif"), $this);?>
' class="help-search">
            </td>
        <?php else: ?>
            <td>&nbsp;</td>
        <?php endif; ?>
		</tr><tr>
	<?php endif; ?>
	
	<td scope="row" nowrap="nowrap" width='8.33333333333%' >
			<label for='status_advanced'><?php echo smarty_function_sugar_translate(array('label' => 'LBL_STATUS','module' => 'AOS_Contracts'), $this);?>
</label>
		</td>
	<td  nowrap="nowrap" width='25%'>
			
<?php echo smarty_function_html_options(array('id' => 'status_advanced','name' => 'status_advanced[]','options' => $this->_tpl_vars['fields']['status_advanced']['options'],'size' => '6','style' => "width: 150px",'multiple' => '1','selected' => $this->_tpl_vars['fields']['status_advanced']['value']), $this);?>

   	   	</td>
    
      
	
	<?php echo smarty_function_counter(array('assign' => 'index'), $this);?>

	<?php echo smarty_function_math(array('equation' => "left % right",'left' => $this->_tpl_vars['index'],'right' => $this->_tpl_vars['templateMeta']['maxColumns'],'assign' => 'modVal'), $this);?>

	<?php if (( $this->_tpl_vars['index'] % $this->_tpl_vars['templateMeta']['maxColumns'] == 1 && $this->_tpl_vars['index'] != 1 )): ?>
        <?php if ($this->_tpl_vars['isHelperShown'] == 0): ?>
            <?php $this->assign('isHelperShown', '1'); ?>
            <td class="helpIcon" width="*">
                <img alt="<?php echo $this->_tpl_vars['APP']['LBL_SEARCH_HELP_TITLE']; ?>
" id="helper_popup_image" border="0" src='<?php echo smarty_function_sugar_getimagepath(array('file' => "help-dashlet.gif"), $this);?>
' class="help-search">
            </td>
        <?php else: ?>
            <td>&nbsp;</td>
        <?php endif; ?>
		</tr><tr>
	<?php endif; ?>
	
	<td scope="row" nowrap="nowrap" width='8.33333333333%' >
			<label for='end_date_advanced'><?php echo smarty_function_sugar_translate(array('label' => 'LBL_END_DATE','module' => 'AOS_Contracts'), $this);?>
</label>
		</td>
	<td  nowrap="nowrap" width='25%'>
			
<?php $this->assign('id', $this->_tpl_vars['fields']['end_date_advanced']['name']); ?>

<?php if (isset ( $_REQUEST['end_date_advanced_range_choice'] )): ?>
<?php $this->assign('starting_choice', $_REQUEST['end_date_advanced_range_choice']); ?>
<?php else: ?>
<?php $this->assign('starting_choice', "="); ?>
<?php endif; ?>

<div style="white-space:nowrap !important;">
<select id="<?php echo $this->_tpl_vars['id']; ?>
_range_choice" name="<?php echo $this->_tpl_vars['id']; ?>
_range_choice" style="width:125px !important;" onchange="<?php echo $this->_tpl_vars['id']; ?>
_range_change(this.value);">
<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['fields']['end_date_advanced']['options'],'selected' => $this->_tpl_vars['starting_choice']), $this);?>

</select>
</div>

<div id="<?php echo $this->_tpl_vars['id']; ?>
_range_div" style="<?php if (preg_match ( '/^\[/' , $_REQUEST['range_end_date_advanced'] ) || $this->_tpl_vars['starting_choice'] == 'between'): ?>display:none<?php else: ?>display:''<?php endif; ?>;">
<input autocomplete="off" type="text" name="range_<?php echo $this->_tpl_vars['id']; ?>
" id="range_<?php echo $this->_tpl_vars['id']; ?>
" value='<?php if (empty ( $_REQUEST['range_end_date_advanced'] ) && ! empty ( $_REQUEST['end_date_advanced'] )): ?><?php echo $_REQUEST['end_date_advanced']; ?>
<?php else: ?><?php echo $_REQUEST['range_end_date_advanced']; ?>
<?php endif; ?>' title=''   size="11" style=" float:left;">
<?php ob_start(); ?>alt="<?php echo $this->_tpl_vars['APP']['LBL_ENTER_DATE']; ?>
" style="position:relative; top:36px" border="0" id="<?php echo $this->_tpl_vars['id']; ?>
_trigger"<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('other_attributes', ob_get_contents());ob_end_clean(); ?>
<?php echo smarty_function_sugar_getimage(array('name' => 'jscalendar','ext' => ".gif",'other_attributes' => ($this->_tpl_vars['other_attributes'])), $this);?>

<script type="text/javascript">
Calendar.setup ({
inputField : "range_<?php echo $this->_tpl_vars['id']; ?>
",
daFormat : "<?php echo $this->_tpl_vars['CALENDAR_FORMAT']; ?>
",
button : "<?php echo $this->_tpl_vars['id']; ?>
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
    
</div>

<div id="<?php echo $this->_tpl_vars['id']; ?>
_between_range_div" style="<?php if ($this->_tpl_vars['starting_choice'] == 'between'): ?>display:'';<?php else: ?>display:none;<?php endif; ?>">
<?php $this->assign('date_value', $this->_tpl_vars['fields']['end_date_advanced']['value']); ?>
<input autocomplete="off" type="text" name="start_range_<?php echo $this->_tpl_vars['id']; ?>
" id="start_range_<?php echo $this->_tpl_vars['id']; ?>
" value='<?php echo $_REQUEST['start_range_end_date_advanced']; ?>
' title=''  tabindex='' size="11" style="width:100px !important;">
<?php ob_start(); ?>align="absmiddle" border="0" id="start_range_<?php echo $this->_tpl_vars['id']; ?>
_trigger"<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('other_attributes', ob_get_contents());ob_end_clean(); ?>
<?php echo smarty_function_sugar_getimage(array('name' => 'jscalendar','ext' => ".gif",'alt' => ($this->_tpl_vars['APP']).".LBL_ENTER_DATE other_attributes=".($this->_tpl_vars['other_attributes'])), $this);?>

<script type="text/javascript">
Calendar.setup ({
inputField : "start_range_<?php echo $this->_tpl_vars['id']; ?>
",
daFormat : "<?php echo $this->_tpl_vars['CALENDAR_FORMAT']; ?>
",
button : "start_range_<?php echo $this->_tpl_vars['id']; ?>
_trigger",
singleClick : true,
dateStr : "<?php echo $this->_tpl_vars['date_value']; ?>
",
step : 1,
weekNumbers:false
}
);
</script>
 
<?php echo $this->_tpl_vars['APP']['LBL_AND']; ?>

<?php $this->assign('date_value', $this->_tpl_vars['fields']['end_date_advanced']['value']); ?>
<input autocomplete="off" type="text" name="end_range_<?php echo $this->_tpl_vars['id']; ?>
" id="end_range_<?php echo $this->_tpl_vars['id']; ?>
" value='<?php echo $_REQUEST['end_range_end_date_advanced']; ?>
' title=''  tabindex='' size="11" style="width:100px !important;" maxlength="10">
<?php ob_start(); ?>align="absmiddle" border="0" id="end_range_<?php echo $this->_tpl_vars['id']; ?>
_trigger"<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('other_attributes', ob_get_contents());ob_end_clean(); ?>
<?php echo smarty_function_sugar_getimage(array('name' => 'jscalendar','ext' => ".gif",'alt' => ($this->_tpl_vars['APP']).".LBL_ENTER_DATE other_attributes=".($this->_tpl_vars['other_attributes'])), $this);?>

<script type="text/javascript">
Calendar.setup ({
inputField : "end_range_<?php echo $this->_tpl_vars['id']; ?>
",
daFormat : "<?php echo $this->_tpl_vars['CALENDAR_FORMAT']; ?>
",
button : "end_range_<?php echo $this->_tpl_vars['id']; ?>
_trigger",
singleClick : true,
dateStr : "<?php echo $this->_tpl_vars['date_value']; ?>
",
step : 1,
weekNumbers:false
}
);
</script>
 
</div>


<script type='text/javascript'>

function <?php echo $this->_tpl_vars['id']; ?>
_range_change(val) 
{
  if(val == 'between') {
     document.getElementById("range_<?php echo $this->_tpl_vars['id']; ?>
").value = '';  
     document.getElementById("<?php echo $this->_tpl_vars['id']; ?>
_range_div").style.display = 'none';
     document.getElementById("<?php echo $this->_tpl_vars['id']; ?>
_between_range_div").style.display = ''; 
  } else if (val == '=' || val == 'not_equal' || val == 'greater_than' || val == 'less_than') {
     if((/^\[.*\]$/).test(document.getElementById("range_<?php echo $this->_tpl_vars['id']; ?>
").value))
     {
     	document.getElementById("range_<?php echo $this->_tpl_vars['id']; ?>
").value = '';
     }
     document.getElementById("start_range_<?php echo $this->_tpl_vars['id']; ?>
").value = '';
     document.getElementById("end_range_<?php echo $this->_tpl_vars['id']; ?>
").value = '';
     document.getElementById("<?php echo $this->_tpl_vars['id']; ?>
_range_div").style.display = '';
     document.getElementById("<?php echo $this->_tpl_vars['id']; ?>
_between_range_div").style.display = 'none';
  } else {
     document.getElementById("range_<?php echo $this->_tpl_vars['id']; ?>
").value = '[' + val + ']';    
     document.getElementById("start_range_<?php echo $this->_tpl_vars['id']; ?>
").value = '';
     document.getElementById("end_range_<?php echo $this->_tpl_vars['id']; ?>
").value = ''; 
     document.getElementById("<?php echo $this->_tpl_vars['id']; ?>
_range_div").style.display = 'none';
     document.getElementById("<?php echo $this->_tpl_vars['id']; ?>
_between_range_div").style.display = 'none';         
  }
}

var <?php echo $this->_tpl_vars['id']; ?>
_range_reset = function()
{
<?php echo $this->_tpl_vars['id']; ?>
_range_change('=');
}

YAHOO.util.Event.onDOMReady(function() {
if(document.getElementById('search_form_clear'))
{
YAHOO.util.Event.addListener('search_form_clear', 'click', <?php echo $this->_tpl_vars['id']; ?>
_range_reset);
}

});

YAHOO.util.Event.onDOMReady(function() {
 	if(document.getElementById('search_form_clear_advanced'))
 	 {
 	     YAHOO.util.Event.addListener('search_form_clear_advanced', 'click', <?php echo $this->_tpl_vars['id']; ?>
_range_reset);
 	 }

});

YAHOO.util.Event.onDOMReady(function() {
    //register on basic search form button if it exists
    if(document.getElementById('search_form_submit'))
     {
         YAHOO.util.Event.addListener('search_form_submit', 'click',<?php echo $this->_tpl_vars['id']; ?>
_range_validate);
     }
    //register on advanced search submit button if it exists
   if(document.getElementById('search_form_submit_advanced'))
    {
        YAHOO.util.Event.addListener('search_form_submit_advanced', 'click',<?php echo $this->_tpl_vars['id']; ?>
_range_validate);
    }

});

// this function is specific to range date searches and will check that both start and end date ranges have been
// filled prior to submitting search form.  It is called from the listener added above.
function <?php echo $this->_tpl_vars['id']; ?>
_range_validate(e){
    if (
            (document.getElementById("start_range_<?php echo $this->_tpl_vars['id']; ?>
").value.length >0 && document.getElementById("end_range_<?php echo $this->_tpl_vars['id']; ?>
").value.length == 0)
          ||(document.getElementById("end_range_<?php echo $this->_tpl_vars['id']; ?>
").value.length >0 && document.getElementById("start_range_<?php echo $this->_tpl_vars['id']; ?>
").value.length == 0)
       )
    {
        e.preventDefault();
        alert('<?php echo $this->_tpl_vars['APP']['LBL_CHOOSE_START_AND_END_DATES']; ?>
');
        if (document.getElementById("start_range_<?php echo $this->_tpl_vars['id']; ?>
").value.length == 0) {
            document.getElementById("start_range_<?php echo $this->_tpl_vars['id']; ?>
").focus();
        }
        else {
            document.getElementById("end_range_<?php echo $this->_tpl_vars['id']; ?>
").focus();
        }
    }

}

</script>
   	   	</td>
    
      
	
	<?php echo smarty_function_counter(array('assign' => 'index'), $this);?>

	<?php echo smarty_function_math(array('equation' => "left % right",'left' => $this->_tpl_vars['index'],'right' => $this->_tpl_vars['templateMeta']['maxColumns'],'assign' => 'modVal'), $this);?>

	<?php if (( $this->_tpl_vars['index'] % $this->_tpl_vars['templateMeta']['maxColumns'] == 1 && $this->_tpl_vars['index'] != 1 )): ?>
        <?php if ($this->_tpl_vars['isHelperShown'] == 0): ?>
            <?php $this->assign('isHelperShown', '1'); ?>
            <td class="helpIcon" width="*">
                <img alt="<?php echo $this->_tpl_vars['APP']['LBL_SEARCH_HELP_TITLE']; ?>
" id="helper_popup_image" border="0" src='<?php echo smarty_function_sugar_getimagepath(array('file' => "help-dashlet.gif"), $this);?>
' class="help-search">
            </td>
        <?php else: ?>
            <td>&nbsp;</td>
        <?php endif; ?>
		</tr><tr>
	<?php endif; ?>
	
	<td scope="row" nowrap="nowrap" width='8.33333333333%' >
		
		<label for='assigned_user_id_advanced'><?php echo smarty_function_sugar_translate(array('label' => 'LBL_ASSIGNED_TO_NAME','module' => 'AOS_Contracts'), $this);?>
</label>
    	</td>
	<td  nowrap="nowrap" width='25%'>
			
<?php echo smarty_function_html_options(array('id' => 'assigned_user_id_advanced','name' => 'assigned_user_id_advanced[]','options' => $this->_tpl_vars['fields']['assigned_user_id_advanced']['options'],'size' => '6','style' => "width: 150px",'multiple' => '1','selected' => $this->_tpl_vars['fields']['assigned_user_id_advanced']['value']), $this);?>

   	   	</td>
	</tr>
<tr>
	<td colspan='20'>
		&nbsp;
	</td>
</tr>	
<?php if ($this->_tpl_vars['DISPLAY_SAVED_SEARCH']): ?>
<tr>
	<td colspan='2'>
		<a class='tabFormAdvLink' onhover href='javascript:toggleInlineSearch()'>
            <?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_ALT_SHOW_OPTIONS'), $this);?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('alt_show_hide', ob_get_contents());ob_end_clean(); ?>
		<?php echo smarty_function_sugar_getimage(array('alt' => $this->_tpl_vars['alt_show_hide'],'name' => 'advanced_search','ext' => ".gif",'other_attributes' => 'border="0" id="up_down_img" '), $this);?>
&nbsp;<?php echo $this->_tpl_vars['APP']['LNK_SAVED_VIEWS']; ?>

		</a><br>
		<input type='hidden' id='showSSDIV' name='showSSDIV' value='<?php echo $this->_tpl_vars['SHOWSSDIV']; ?>
'><p>
	</td>
	<td scope='row' width='10%' nowrap="nowrap">
		<?php echo smarty_function_sugar_translate(array('label' => 'LBL_SAVE_SEARCH_AS','module' => 'SavedSearch'), $this);?>
:
	</td>
	<td width='30%' nowrap>
		<input type='text' name='saved_search_name'>
		<input type='hidden' name='search_module' value=''>
		<input type='hidden' name='saved_search_action' value=''>
		<input title='<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
' value='<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
' class='button' type='button' name='saved_search_submit' onclick='SUGAR.savedViews.setChooser(); return SUGAR.savedViews.saved_search_action("save");'>
	</td>
	<td scope='row' width='10%' nowrap="nowrap">
	    <?php echo smarty_function_sugar_translate(array('label' => 'LBL_MODIFY_CURRENT_SEARCH','module' => 'SavedSearch'), $this);?>
:
	</td>
	<td width='30%' nowrap>
        <input class='button' onclick='SUGAR.savedViews.setChooser(); return SUGAR.savedViews.saved_search_action("update")' value='<?php echo $this->_tpl_vars['APP']['LBL_UPDATE']; ?>
' title='<?php echo $this->_tpl_vars['APP']['LBL_UPDATE']; ?>
' name='ss_update' id='ss_update' type='button' >
		<input class='button' onclick='return SUGAR.savedViews.saved_search_action("delete", "<?php echo smarty_function_sugar_translate(array('label' => 'LBL_DELETE_CONFIRM','module' => 'SavedSearch'), $this);?>
")' value='<?php echo $this->_tpl_vars['APP']['LBL_DELETE']; ?>
' title='<?php echo $this->_tpl_vars['APP']['LBL_DELETE']; ?>
' name='ss_delete' id='ss_delete' type='button'>
		<br><span id='curr_search_name'></span>
	</td>
</tr>

<tr>
<td colspan='6'>
<div style='<?php echo $this->_tpl_vars['DISPLAYSS']; ?>
' id='inlineSavedSearch' >
	<?php echo $this->_tpl_vars['SAVED_SEARCH']; ?>

</div>
</td>
</tr>

<?php endif; ?>
<?php if ($this->_tpl_vars['displayType'] != 'popupView'): ?>
<tr>
	<td colspan='5'>
        <input tabindex='2' title='<?php echo $this->_tpl_vars['APP']['LBL_SEARCH_BUTTON_TITLE']; ?>
' onclick='SUGAR.savedViews.setChooser()' class='button' type='submit' name='button' value='<?php echo $this->_tpl_vars['APP']['LBL_SEARCH_BUTTON_LABEL']; ?>
' id='search_form_submit_advanced'/>&nbsp;
        <input tabindex='2' title='<?php echo $this->_tpl_vars['APP']['LBL_CLEAR_BUTTON_TITLE']; ?>
'  onclick='SUGAR.searchForm.clear_form(this.form); document.getElementById("saved_search_select").options[0].selected=true; return false;' class='button' type='button' name='clear' id='search_form_clear_advanced' value='<?php echo $this->_tpl_vars['APP']['LBL_CLEAR_BUTTON_LABEL']; ?>
'/>
        <?php if ($this->_tpl_vars['DOCUMENTS_MODULE']): ?>
        &nbsp;<input title="<?php echo $this->_tpl_vars['APP']['LBL_BROWSE_DOCUMENTS_BUTTON_TITLE']; ?>
" type="button" class="button" value="<?php echo $this->_tpl_vars['APP']['LBL_BROWSE_DOCUMENTS_BUTTON_LABEL']; ?>
" onclick='open_popup("Documents", 600, 400, "&caller=Documents", true, false, "");' />
        <?php endif; ?>
        <a id="basic_search_link" href="javascript:void(0)" accesskey="<?php echo $this->_tpl_vars['APP']['LBL_ADV_SEARCH_LNK_KEY']; ?>
" ><?php echo $this->_tpl_vars['APP']['LNK_BASIC_SEARCH']; ?>
</a>
        <span class='white-space'>
            &nbsp;&nbsp;&nbsp;<?php if ($this->_tpl_vars['SAVED_SEARCHES_OPTIONS']): ?>|&nbsp;&nbsp;&nbsp;<b><?php echo $this->_tpl_vars['APP']['LBL_SAVED_SEARCH_SHORTCUT']; ?>
</b>&nbsp;
            <?php echo $this->_tpl_vars['SAVED_SEARCHES_OPTIONS']; ?>
 <?php endif; ?>
            <span id='go_btn_span' style='display:none'><input tabindex='2' title='go_select' id='go_select'  onclick='SUGAR.searchForm.clear_form(this.form);' class='button' type='button' name='go_select' value=' <?php echo $this->_tpl_vars['APP']['LBL_GO_BUTTON_LABEL']; ?>
 '/></span>	
        </span>
	</td>
	<td class="help">
	    <?php if ($this->_tpl_vars['DISPLAY_SEARCH_HELP']): ?>
	    <img  border='0' src='<?php echo smarty_function_sugar_getimagepath(array('file' => "help-dashlet.gif"), $this);?>
' class="help-search">
	    <?php endif; ?>
    </td>
</tr>
<?php endif; ?>
</table>

<script>
<?php echo '
	if(typeof(loadSSL_Scripts)==\'function\'){
		loadSSL_Scripts();
	}
'; ?>
	
</script>
<script>
	<?php echo '
	$(document).ready(function () {
		$( \'#basic_search_link\' ).one( "click", function() {
			//alert( "This will be displayed only once." );
			SUGAR.searchForm.searchFormSelect(\''; ?>
<?php echo $this->_tpl_vars['module']; ?>
<?php echo '|basic_search\',\''; ?>
<?php echo $this->_tpl_vars['module']; ?>
<?php echo '|advanced_search\');
		});
	});
	'; ?>

</script><?php echo '<script language="javascript">if(typeof sqs_objects == \'undefined\'){var sqs_objects = new Array;}sqs_objects[\'search_form_modified_by_name_advanced\']={"form":"search_form","method":"get_user_array","field_list":["user_name","id"],"populate_list":["modified_by_name_advanced","modified_user_id_advanced"],"required_list":["modified_user_id"],"conditions":[{"name":"user_name","op":"like_custom","end":"%","value":""}],"limit":"30","no_match_text":"No Match"};sqs_objects[\'search_form_created_by_name_advanced\']={"form":"search_form","method":"get_user_array","field_list":["user_name","id"],"populate_list":["created_by_name_advanced","created_by_advanced"],"required_list":["created_by"],"conditions":[{"name":"user_name","op":"like_custom","end":"%","value":""}],"limit":"30","no_match_text":"No Match"};sqs_objects[\'search_form_assigned_user_name_advanced\']={"form":"search_form","method":"get_user_array","field_list":["user_name","id"],"populate_list":["assigned_user_name_advanced","assigned_user_id_advanced"],"required_list":["assigned_user_id"],"conditions":[{"name":"user_name","op":"like_custom","end":"%","value":""}],"limit":"30","no_match_text":"No Match"};sqs_objects[\'search_form_contract_account_advanced\']={"form":"search_form","method":"query","modules":["Accounts"],"group":"or","field_list":["name","id"],"populate_list":["search_form_contract_account_advanced","contract_account_id_advanced"],"conditions":[{"name":"name","op":"like_custom","end":"%","value":""}],"required_list":["contract_account_id"],"order":"name","limit":"30","no_match_text":"No Match"};sqs_objects[\'search_form_opportunity_advanced\']={"form":"search_form","method":"query","modules":["Opportunities"],"group":"or","field_list":["name","id"],"populate_list":["opportunity_advanced","opportunity_id_advanced"],"required_list":["parent_id"],"conditions":[{"name":"name","op":"like_custom","end":"%","value":""}],"order":"name","limit":"30","no_match_text":"No Match"};sqs_objects[\'search_form_contact_advanced\']={"form":"search_form","method":"get_contact_array","modules":["Contacts"],"field_list":["salutation","first_name","last_name","id"],"populate_list":["contact_advanced","contact_id_advanced","contact_id_advanced","contact_id_advanced"],"required_list":["contact_id"],"group":"or","conditions":[{"name":"first_name","op":"like_custom","end":"%","value":""},{"name":"last_name","op":"like_custom","end":"%","value":""}],"order":"last_name","limit":"30","no_match_text":"No Match"};sqs_objects[\'search_form_te_vendor_aos_contracts_1_name_advanced\']={"form":"search_form","method":"query","modules":["te_vendor"],"group":"or","field_list":["name","id"],"populate_list":["te_vendor_aos_contracts_1_name_advanced","te_vendor_aos_contracts_1te_vendor_ida_advanced"],"required_list":["parent_id"],"conditions":[{"name":"name","op":"like_custom","end":"%","value":""}],"order":"name","limit":"30","no_match_text":"No Match"};sqs_objects[\'search_form_vendor_advanced\']={"form":"search_form","method":"query","modules":["te_vendor"],"group":"or","field_list":["name","id"],"populate_list":["vendor_advanced","te_vendor_id_c_advanced"],"required_list":["parent_id"],"conditions":[{"name":"name","op":"like_custom","end":"%","value":""}],"order":"name","limit":"30","no_match_text":"No Match"};</script>'; ?>