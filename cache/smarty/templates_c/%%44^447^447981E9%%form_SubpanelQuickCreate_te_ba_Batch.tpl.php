<?php /* Smarty version 2.6.29, created on 2016-12-28 23:40:42
         compiled from cache/themes/SuiteR/modules/te_ba_Batch/form_SubpanelQuickCreate_te_ba_Batch.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sugar_include', 'cache/themes/SuiteR/modules/te_ba_Batch/form_SubpanelQuickCreate_te_ba_Batch.tpl', 44, false),array('function', 'counter', 'cache/themes/SuiteR/modules/te_ba_Batch/form_SubpanelQuickCreate_te_ba_Batch.tpl', 50, false),array('function', 'sugar_translate', 'cache/themes/SuiteR/modules/te_ba_Batch/form_SubpanelQuickCreate_te_ba_Batch.tpl', 56, false),array('function', 'sugar_getimage', 'cache/themes/SuiteR/modules/te_ba_Batch/form_SubpanelQuickCreate_te_ba_Batch.tpl', 115, false),array('function', 'html_options', 'cache/themes/SuiteR/modules/te_ba_Batch/form_SubpanelQuickCreate_te_ba_Batch.tpl', 148, false),array('function', 'sugar_getimagepath', 'cache/themes/SuiteR/modules/te_ba_Batch/form_SubpanelQuickCreate_te_ba_Batch.tpl', 176, false),array('function', 'sugar_number_format', 'cache/themes/SuiteR/modules/te_ba_Batch/form_SubpanelQuickCreate_te_ba_Batch.tpl', 416, false),array('modifier', 'strip_semicolon', 'cache/themes/SuiteR/modules/te_ba_Batch/form_SubpanelQuickCreate_te_ba_Batch.tpl', 57, false),array('modifier', 'default', 'cache/themes/SuiteR/modules/te_ba_Batch/form_SubpanelQuickCreate_te_ba_Batch.tpl', 126, false),array('modifier', 'lookup', 'cache/themes/SuiteR/modules/te_ba_Batch/form_SubpanelQuickCreate_te_ba_Batch.tpl', 173, false),array('modifier', 'count', 'cache/themes/SuiteR/modules/te_ba_Batch/form_SubpanelQuickCreate_te_ba_Batch.tpl', 275, false),)), $this); ?>


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
"  class="button" onclick="var _form = document.getElementById('form_SubpanelQuickCreate_te_ba_Batch'); disableOnUnloadEditView(); _form.action.value='Save';if(check_form('form_SubpanelQuickCreate_te_ba_Batch'))return SUGAR.subpanelUtils.inlineSave(_form.id, 'te_ba_Batch_subpanel_save_button');return false;" type="submit" name="te_ba_Batch_subpanel_save_button" id="te_ba_Batch_subpanel_save_button" value="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
"><?php endif; ?>  <input title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_TITLE']; ?>
" class="button" onclick="return SUGAR.subpanelUtils.cancelCreate($(this).attr('id'));return false;" type="submit" name="te_ba_Batch_subpanel_cancel_button" id="te_ba_Batch_subpanel_cancel_button" value="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
">  <input title="<?php echo $this->_tpl_vars['APP']['LBL_FULL_FORM_BUTTON_TITLE']; ?>
" class="button" onclick="var _form = document.getElementById('form_SubpanelQuickCreate_te_ba_Batch'); disableOnUnloadEditView(_form); _form.return_action.value='DetailView'; _form.action.value='EditView'; if(typeof(_form.to_pdf)!='undefined') _form.to_pdf.value='0';" type="submit" name="te_ba_Batch_subpanel_full_form_button" id="te_ba_Batch_subpanel_full_form_button" value="<?php echo $this->_tpl_vars['APP']['LBL_FULL_FORM_BUTTON_LABEL']; ?>
"> <input type="hidden" name="full_form" value="full_form"> <?php if ($this->_tpl_vars['bean']->aclAccess('detail')): ?><?php if (! empty ( $this->_tpl_vars['fields']['id']['value'] ) && $this->_tpl_vars['isAuditEnabled']): ?><input id="btn_view_change_log" title="<?php echo $this->_tpl_vars['APP']['LNK_VIEW_CHANGE_LOG']; ?>
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
<div id="form_SubpanelQuickCreate_te_ba_Batch_tabs"
>
<div >
<div id="detailpanel_1" >
<?php echo smarty_function_counter(array('name' => 'panelFieldCount','start' => 0,'print' => false,'assign' => 'panelFieldCount'), $this);?>

<table width="100%" border="0" cellspacing="1" cellpadding="0"  id='Default_<?php echo $this->_tpl_vars['module']; ?>
_Subpanel'  class="yui3-skin-sam edit view panelContainer">
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
' title=''      accesskey='7'  >
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
form : "form_SubpanelQuickCreate_te_ba_Batch",
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
</tr>
<?php $this->_smarty_vars['capture']['tr'] = ob_get_contents();  $this->assign('tableRow', ob_get_contents());ob_end_clean(); ?>
<?php if ($this->_tpl_vars['fieldsUsed'] > 0): ?>
<?php echo $this->_tpl_vars['tableRow']; ?>

<?php endif; ?>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed','start' => 0,'print' => false,'assign' => 'fieldsUsed'), $this);?>

<?php ob_start(); ?>
<tr>
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
</tr>
<?php $this->_smarty_vars['capture']['tr'] = ob_get_contents();  $this->assign('tableRow', ob_get_contents());ob_end_clean(); ?>
<?php if ($this->_tpl_vars['fieldsUsed'] > 0): ?>
<?php echo $this->_tpl_vars['tableRow']; ?>

<?php endif; ?>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed','start' => 0,'print' => false,'assign' => 'fieldsUsed'), $this);?>

<?php ob_start(); ?>
<tr>
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
form : "form_SubpanelQuickCreate_te_ba_Batch",
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
rows="6" 
cols="103" 
title='' tabindex="0" 
 ><?php echo $this->_tpl_vars['value']; ?>
</textarea>
<td valign="top" id='class_schedule_c_label' width='12.5%' scope="col">
<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_CLASS_SCHEDULE','module' => 'te_ba_Batch'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
</td>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed'), $this);?>


<td valign="top" width='37.5%' >
<?php echo smarty_function_counter(array('name' => 'panelFieldCount'), $this);?>


<?php if (empty ( $this->_tpl_vars['fields']['class_schedule_c']['value'] )): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['class_schedule_c']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['class_schedule_c']['value']); ?>
<?php endif; ?>  
<textarea  id='<?php echo $this->_tpl_vars['fields']['class_schedule_c']['name']; ?>
' name='<?php echo $this->_tpl_vars['fields']['class_schedule_c']['name']; ?>
'
rows="4" 
cols="20" 
title='' tabindex="0" 
 ><?php echo $this->_tpl_vars['value']; ?>
</textarea>
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
"  class="button" onclick="var _form = document.getElementById('form_SubpanelQuickCreate_te_ba_Batch'); disableOnUnloadEditView(); _form.action.value='Save';if(check_form('form_SubpanelQuickCreate_te_ba_Batch'))return SUGAR.subpanelUtils.inlineSave(_form.id, 'te_ba_Batch_subpanel_save_button');return false;" type="submit" name="te_ba_Batch_subpanel_save_button" id="te_ba_Batch_subpanel_save_button" value="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
"><?php endif; ?>  <input title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_TITLE']; ?>
" class="button" onclick="return SUGAR.subpanelUtils.cancelCreate($(this).attr('id'));return false;" type="submit" name="te_ba_Batch_subpanel_cancel_button" id="te_ba_Batch_subpanel_cancel_button" value="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
">  <input title="<?php echo $this->_tpl_vars['APP']['LBL_FULL_FORM_BUTTON_TITLE']; ?>
" class="button" onclick="var _form = document.getElementById('form_SubpanelQuickCreate_te_ba_Batch'); disableOnUnloadEditView(_form); _form.return_action.value='DetailView'; _form.action.value='EditView'; if(typeof(_form.to_pdf)!='undefined') _form.to_pdf.value='0';" type="submit" name="te_ba_Batch_subpanel_full_form_button" id="te_ba_Batch_subpanel_full_form_button" value="<?php echo $this->_tpl_vars['APP']['LBL_FULL_FORM_BUTTON_LABEL']; ?>
"> <input type="hidden" name="full_form" value="full_form"> <?php if ($this->_tpl_vars['bean']->aclAccess('detail')): ?><?php if (! empty ( $this->_tpl_vars['fields']['id']['value'] ) && $this->_tpl_vars['isAuditEnabled']): ?><input id="btn_view_change_log" title="<?php echo $this->_tpl_vars['APP']['LNK_VIEW_CHANGE_LOG']; ?>
" class="button" onclick='open_popup("Audit", "600", "400", "&record=<?php echo $this->_tpl_vars['fields']['id']['value']; ?>
&module_name=te_ba_Batch", true, false,  { "call_back_function":"set_return","form_name":"EditView","field_to_name_array":[] } ); return false;' type="button" value="<?php echo $this->_tpl_vars['APP']['LNK_VIEW_CHANGE_LOG']; ?>
"><?php endif; ?><?php endif; ?><div class="clear"></div></div>
</div>
</form>
<?php echo $this->_tpl_vars['set_focus_block']; ?>

<script>SUGAR.util.doWhen("document.getElementById('EditView') != null",
        function(){SUGAR.util.buildAccessKeyLabels();});
</script><script type="text/javascript">
YAHOO.util.Event.onContentReady("form_SubpanelQuickCreate_te_ba_Batch",
    function () { initEditView(document.forms.form_SubpanelQuickCreate_te_ba_Batch) });
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
addForm(\'form_SubpanelQuickCreate_te_ba_Batch\');addToValidate(\'form_SubpanelQuickCreate_te_ba_Batch\', \'name\', \'name\', true,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_NAME','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'form_SubpanelQuickCreate_te_ba_Batch\', \'date_entered_date\', \'date\', false,\'Date Created\' );
addToValidate(\'form_SubpanelQuickCreate_te_ba_Batch\', \'date_modified_date\', \'date\', false,\'Date Modified\' );
addToValidate(\'form_SubpanelQuickCreate_te_ba_Batch\', \'modified_user_id\', \'assigned_user_name\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_MODIFIED','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'form_SubpanelQuickCreate_te_ba_Batch\', \'modified_by_name\', \'relate\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_MODIFIED_NAME','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'form_SubpanelQuickCreate_te_ba_Batch\', \'created_by\', \'assigned_user_name\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_CREATED','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'form_SubpanelQuickCreate_te_ba_Batch\', \'created_by_name\', \'relate\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_CREATED','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'form_SubpanelQuickCreate_te_ba_Batch\', \'description\', \'text\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_DESCRIPTION','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'form_SubpanelQuickCreate_te_ba_Batch\', \'deleted\', \'bool\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_DELETED','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'form_SubpanelQuickCreate_te_ba_Batch\', \'assigned_user_id\', \'relate\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_ASSIGNED_TO_ID','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'form_SubpanelQuickCreate_te_ba_Batch\', \'assigned_user_name\', \'relate\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_ASSIGNED_TO_NAME','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'form_SubpanelQuickCreate_te_ba_Batch\', \'batch_code\', \'varchar\', true,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_BATCH_CODE','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'form_SubpanelQuickCreate_te_ba_Batch\', \'batch_status\', \'enum\', true,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_BATCH_STATUS','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'form_SubpanelQuickCreate_te_ba_Batch\', \'batch_start_date\', \'date\', true,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_BATCH_START_DATE','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'form_SubpanelQuickCreate_te_ba_Batch\', \'no_of_installments\', \'int\', true,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_NO_OF_INSTALLMENTS','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'form_SubpanelQuickCreate_te_ba_Batch\', \'batch_size\', \'int\', true,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_BATCH_SIZE','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'form_SubpanelQuickCreate_te_ba_Batch\', \'initial_payment_inr\', \'int\', true,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_INITIAL_PAYMENT_INR','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'form_SubpanelQuickCreate_te_ba_Batch\', \'initial_payment_usd\', \'int\', true,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_INITIAL_PAYMENT_USD','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'form_SubpanelQuickCreate_te_ba_Batch\', \'initial_payment_date\', \'date\', true,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_INITIAL_PAYMENT_DATE','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidateRange(\'form_SubpanelQuickCreate_te_ba_Batch\', \'duration\', \'int\', true, \''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_DURATION','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\', false, 60);
addToValidate(\'form_SubpanelQuickCreate_te_ba_Batch\', \'total_sessions_planned\', \'int\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_TOTAL_SESSIONS_PLANNED','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'form_SubpanelQuickCreate_te_ba_Batch\', \'fees_inr\', \'float\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_FEES_INR','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'form_SubpanelQuickCreate_te_ba_Batch\', \'fees_in_usd\', \'float\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_FEES_IN_USD','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'form_SubpanelQuickCreate_te_ba_Batch\', \'registration_closing_date\', \'date\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_REGISTRATION_CLOSING_DATE','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'form_SubpanelQuickCreate_te_ba_Batch\', \'minimum_attendance_criteria\', \'float\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_MINIMUM_ATTENDANCE_CRITERIA','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'form_SubpanelQuickCreate_te_ba_Batch\', \'te_in_institutes_te_ba_batch_1_name\', \'relate\', true,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_TE_IN_INSTITUTES_TE_BA_BATCH_1_FROM_TE_IN_INSTITUTES_TITLE','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'form_SubpanelQuickCreate_te_ba_Batch\', \'class_schedule_c\', \'text\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_CLASS_SCHEDULE','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'form_SubpanelQuickCreate_te_ba_Batch\', \'batch_start_date1\', \'date\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_BATCH_START_DATE','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'form_SubpanelQuickCreate_te_ba_Batch\', \'enrolled_students_c\', \'varchar\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_ENROLLED_STUDENTS','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'form_SubpanelQuickCreate_te_ba_Batch\', \'minimum_batch_size_c\', \'varchar\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_MINIMUM_BATCH_SIZE','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidate(\'form_SubpanelQuickCreate_te_ba_Batch\', \'te_pr_programs_te_ba_batch_1_name\', \'relate\', true,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_TE_PR_PROGRAMS_TE_BA_BATCH_1_FROM_TE_PR_PROGRAMS_TITLE','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\' );
addToValidateBinaryDependency(\'form_SubpanelQuickCreate_te_ba_Batch\', \'assigned_user_name\', \'alpha\', false,\''; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'ERR_SQS_NO_MATCH_FIELD','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo ': '; ?>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_ASSIGNED_TO','module' => 'te_ba_Batch','for_js' => true), $this);?>
<?php echo '\', \'assigned_user_id\' );
</script>'; ?>
