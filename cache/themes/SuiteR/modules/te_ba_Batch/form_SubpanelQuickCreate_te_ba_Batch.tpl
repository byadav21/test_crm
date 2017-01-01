

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
<div class="action_buttons">{if $bean->aclAccess("save")}<input title="{$APP.LBL_SAVE_BUTTON_TITLE}"  class="button" onclick="var _form = document.getElementById('form_SubpanelQuickCreate_te_ba_Batch'); disableOnUnloadEditView(); _form.action.value='Save';if(check_form('form_SubpanelQuickCreate_te_ba_Batch'))return SUGAR.subpanelUtils.inlineSave(_form.id, 'te_ba_Batch_subpanel_save_button');return false;" type="submit" name="te_ba_Batch_subpanel_save_button" id="te_ba_Batch_subpanel_save_button" value="{$APP.LBL_SAVE_BUTTON_LABEL}">{/if}  <input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" class="button" onclick="return SUGAR.subpanelUtils.cancelCreate($(this).attr('id'));return false;" type="submit" name="te_ba_Batch_subpanel_cancel_button" id="te_ba_Batch_subpanel_cancel_button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">  <input title="{$APP.LBL_FULL_FORM_BUTTON_TITLE}" class="button" onclick="var _form = document.getElementById('form_SubpanelQuickCreate_te_ba_Batch'); disableOnUnloadEditView(_form); _form.return_action.value='DetailView'; _form.action.value='EditView'; if(typeof(_form.to_pdf)!='undefined') _form.to_pdf.value='0';" type="submit" name="te_ba_Batch_subpanel_full_form_button" id="te_ba_Batch_subpanel_full_form_button" value="{$APP.LBL_FULL_FORM_BUTTON_LABEL}"> <input type="hidden" name="full_form" value="full_form"> {if $bean->aclAccess("detail")}{if !empty($fields.id.value) && $isAuditEnabled}<input id="btn_view_change_log" title="{$APP.LNK_VIEW_CHANGE_LOG}" class="button" onclick='open_popup("Audit", "600", "400", "&record={$fields.id.value}&module_name=te_ba_Batch", true, false,  {ldelim} "call_back_function":"set_return","form_name":"EditView","field_to_name_array":[] {rdelim} ); return false;' type="button" value="{$APP.LNK_VIEW_CHANGE_LOG}">{/if}{/if}<div class="clear"></div></div>
</td>
<td align='right'>
{$PAGINATION}
</td>
</tr>
</table>{sugar_include include=$includes}
<span id='tabcounterJS'><script>SUGAR.TabFields=new Array();//this will be used to track tabindexes for references</script></span>
<div id="form_SubpanelQuickCreate_te_ba_Batch_tabs"
>
<div >
<div id="detailpanel_1" >
{counter name="panelFieldCount" start=0 print=false assign="panelFieldCount"}
<table width="100%" border="0" cellspacing="1" cellpadding="0"  id='Default_{$module}_Subpanel'  class="yui3-skin-sam edit view panelContainer">
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{capture name="tr" assign="tableRow"}
<tr>
<td valign="top" id='name_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_NAME' module='te_ba_Batch'}{/capture}
{$label|strip_semicolon}:
<span class="required">*</span>
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' >
{counter name="panelFieldCount"}

{if strlen($fields.name.value) <= 0}
{assign var="value" value=$fields.name.default_value }
{else}
{assign var="value" value=$fields.name.value }
{/if}  
<input type='text' name='{$fields.name.name}' 
id='{$fields.name.name}' size='30' 
maxlength='255' 
value='{$value}' title=''      accesskey='7'  >
<td valign="top" id='batch_code_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_BATCH_CODE' module='te_ba_Batch'}{/capture}
{$label|strip_semicolon}:
<span class="required">*</span>
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' >
{counter name="panelFieldCount"}

{if strlen($fields.batch_code.value) <= 0}
{assign var="value" value=$fields.batch_code.default_value }
{else}
{assign var="value" value=$fields.batch_code.value }
{/if}  
<input type='text' name='{$fields.batch_code.name}' 
id='{$fields.batch_code.name}' size='30' 
maxlength='255' 
value='{$value}' title=''      >
</tr>
{/capture}
{if $fieldsUsed > 0 }
{$tableRow}
{/if}
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{capture name="tr" assign="tableRow"}
<tr>
<td valign="top" id='batch_start_date_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_BATCH_START_DATE' module='te_ba_Batch'}{/capture}
{$label|strip_semicolon}:
<span class="required">*</span>
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' >
{counter name="panelFieldCount"}

<span class="dateTime">
{assign var=date_value value=$fields.batch_start_date.value }
<input class="date_input" autocomplete="off" type="text" name="{$fields.batch_start_date.name}" id="{$fields.batch_start_date.name}" value="{$date_value}" title=''  tabindex='0'    size="11" maxlength="10" >
{capture assign="other_attributes"}alt="{$APP.LBL_ENTER_DATE}" style="position:relative; top:6px" border="0" id="{$fields.batch_start_date.name}_trigger"{/capture}
{sugar_getimage name="jscalendar" ext=".gif" other_attributes="$other_attributes"}
</span>
<script type="text/javascript">
Calendar.setup ({ldelim}
inputField : "{$fields.batch_start_date.name}",
form : "form_SubpanelQuickCreate_te_ba_Batch",
ifFormat : "{$CALENDAR_FORMAT}",
daFormat : "{$CALENDAR_FORMAT}",
button : "{$fields.batch_start_date.name}_trigger",
singleClick : true,
dateStr : "{$date_value}",
startWeekday: {$CALENDAR_FDOW|default:'0'},
step : 1,
weekNumbers:false
{rdelim}
);
</script>
<td valign="top" id='batch_status_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_BATCH_STATUS' module='te_ba_Batch'}{/capture}
{$label|strip_semicolon}:
<span class="required">*</span>
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' >
{counter name="panelFieldCount"}

{if !isset($config.enable_autocomplete) || $config.enable_autocomplete==false}
<select name="{$fields.batch_status.name}" 
id="{$fields.batch_status.name}" 
title=''       
>
{if isset($fields.batch_status.value) && $fields.batch_status.value != ''}
{html_options options=$fields.batch_status.options selected=$fields.batch_status.value}
{else}
{html_options options=$fields.batch_status.options selected=$fields.batch_status.default}
{/if}
</select>
{else}
{assign var="field_options" value=$fields.batch_status.options }
{capture name="field_val"}{$fields.batch_status.value}{/capture}
{assign var="field_val" value=$smarty.capture.field_val}
{capture name="ac_key"}{$fields.batch_status.name}{/capture}
{assign var="ac_key" value=$smarty.capture.ac_key}
<select style='display:none' name="{$fields.batch_status.name}" 
id="{$fields.batch_status.name}" 
title=''          
>
{if isset($fields.batch_status.value) && $fields.batch_status.value != ''}
{html_options options=$fields.batch_status.options selected=$fields.batch_status.value}
{else}
{html_options options=$fields.batch_status.options selected=$fields.batch_status.default}
{/if}
</select>
<input
id="{$fields.batch_status.name}-input"
name="{$fields.batch_status.name}-input"
size="30"
value="{$field_val|lookup:$field_options}"
type="text" style="vertical-align: top;">
<span class="id-ff multiple">
<button type="button"><img src="{sugar_getimagepath file="id-ff-down.png"}" id="{$fields.batch_status.name}-image"></button><button type="button"
id="btn-clear-{$fields.batch_status.name}-input"
title="Clear"
onclick="SUGAR.clearRelateField(this.form, '{$fields.batch_status.name}-input', '{$fields.batch_status.name}');sync_{$fields.batch_status.name}()"><img src="{sugar_getimagepath file="id-ff-clear.png"}"></button>
</span>
{literal}
<script>
	SUGAR.AutoComplete.{/literal}{$ac_key}{literal} = [];
	{/literal}

			{literal}
		(function (){
			var selectElem = document.getElementById("{/literal}{$fields.batch_status.name}{literal}");
			
			if (typeof select_defaults =="undefined")
				select_defaults = [];
			
			select_defaults[selectElem.id] = {key:selectElem.value,text:''};

			//get default
			for (i=0;i<selectElem.options.length;i++){
				if (selectElem.options[i].value==selectElem.value)
					select_defaults[selectElem.id].text = selectElem.options[i].innerHTML;
			}

			//SUGAR.AutoComplete.{$ac_key}.ds = 
			//get options array from vardefs
			var options = SUGAR.AutoComplete.getOptionsArray("");

			YUI().use('datasource', 'datasource-jsonschema',function (Y) {
				SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.ds = new Y.DataSource.Function({
				    source: function (request) {
				    	var ret = [];
				    	for (i=0;i<selectElem.options.length;i++)
				    		if (!(selectElem.options[i].value=='' && selectElem.options[i].innerHTML==''))
				    			ret.push({'key':selectElem.options[i].value,'text':selectElem.options[i].innerHTML});
				    	return ret;
				    }
				});
			});
		})();
		{/literal}
	
	{literal}
		YUI().use("autocomplete", "autocomplete-filters", "autocomplete-highlighters", "node","node-event-simulate", function (Y) {
	{/literal}
			
	SUGAR.AutoComplete.{$ac_key}.inputNode = Y.one('#{$fields.batch_status.name}-input');
	SUGAR.AutoComplete.{$ac_key}.inputImage = Y.one('#{$fields.batch_status.name}-image');
	SUGAR.AutoComplete.{$ac_key}.inputHidden = Y.one('#{$fields.batch_status.name}');
	
			{literal}
			function SyncToHidden(selectme){
				var selectElem = document.getElementById("{/literal}{$fields.batch_status.name}{literal}");
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
					SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputHidden.simulate('change');
			}

			//global variable 
			sync_{/literal}{$fields.batch_status.name}{literal} = function(){
				SyncToHidden();
			}
			function syncFromHiddenToWidget(){

				var selectElem = document.getElementById("{/literal}{$fields.batch_status.name}{literal}");

				//if select no longer on page, kill timer
				if (selectElem==null || selectElem.options == null)
					return;

				var currentvalue = SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.get('value');

				SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.simulate('keyup');

				for (i=0;i<selectElem.options.length;i++){

					if (selectElem.options[i].value==selectElem.value && document.activeElement != document.getElementById('{/literal}{$fields.batch_status.name}-input{literal}'))
						SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.set('value',selectElem.options[i].innerHTML);
				}
			}

            YAHOO.util.Event.onAvailable("{/literal}{$fields.batch_status.name}{literal}", syncFromHiddenToWidget);
		{/literal}

		SUGAR.AutoComplete.{$ac_key}.minQLen = 0;
		SUGAR.AutoComplete.{$ac_key}.queryDelay = 0;
		SUGAR.AutoComplete.{$ac_key}.numOptions = {$field_options|@count};
		if(SUGAR.AutoComplete.{$ac_key}.numOptions >= 300) {literal}{
			{/literal}
			SUGAR.AutoComplete.{$ac_key}.minQLen = 1;
			SUGAR.AutoComplete.{$ac_key}.queryDelay = 200;
			{literal}
		}
		{/literal}
		if(SUGAR.AutoComplete.{$ac_key}.numOptions >= 3000) {literal}{
			{/literal}
			SUGAR.AutoComplete.{$ac_key}.minQLen = 1;
			SUGAR.AutoComplete.{$ac_key}.queryDelay = 500;
			{literal}
		}
		{/literal}
		
	SUGAR.AutoComplete.{$ac_key}.optionsVisible = false;
	
	{literal}
	SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.plug(Y.Plugin.AutoComplete, {
		activateFirstItem: true,
		{/literal}
		minQueryLength: SUGAR.AutoComplete.{$ac_key}.minQLen,
		queryDelay: SUGAR.AutoComplete.{$ac_key}.queryDelay,
		zIndex: 99999,

				
		{literal}
		source: SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.ds,
		
		resultTextLocator: 'text',
		resultHighlighter: 'phraseMatch',
		resultFilters: 'phraseMatch',
	});

	SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.expandHover = function(ex){
		var hover = YAHOO.util.Dom.getElementsByClassName('dccontent');
		if(hover[0] != null){
			if (ex) {
				var h = '1000px';
				hover[0].style.height = h;
			}
			else{
				hover[0].style.height = '';
			}
		}
	}
		
	if({/literal}SUGAR.AutoComplete.{$ac_key}.minQLen{literal} == 0){
		// expand the dropdown options upon focus
		SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.on('focus', function () {
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.ac.sendRequest('');
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.optionsVisible = true;
		});
	}

			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.on('click', function(e) {
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputHidden.simulate('click');
		});
		
		SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.on('dblclick', function(e) {
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputHidden.simulate('dblclick');
		});

		SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.on('focus', function(e) {
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputHidden.simulate('focus');
		});

		SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.on('mouseup', function(e) {
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputHidden.simulate('mouseup');
		});

		SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.on('mousedown', function(e) {
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputHidden.simulate('mousedown');
		});

		SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.on('blur', function(e) {
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputHidden.simulate('blur');
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.optionsVisible = false;
			var selectElem = document.getElementById("{/literal}{$fields.batch_status.name}{literal}");
			//if typed value is a valid option, do nothing
			for (i=0;i<selectElem.options.length;i++)
				if (selectElem.options[i].innerHTML==SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.get('value'))
					return;
			
			//typed value is invalid, so set the text and the hidden to blank
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.set('value', select_defaults[selectElem.id].text);
			SyncToHidden(select_defaults[selectElem.id].key);
		});
	
	// when they click on the arrow image, toggle the visibility of the options
	SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputImage.ancestor().on('click', function () {
		if (SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.optionsVisible) {
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.blur();
		} else {
			SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.focus();
		}
	});

	SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.ac.on('query', function () {
		SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputHidden.set('value', '');
	});

	SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.ac.on('visibleChange', function (e) {
		SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.expandHover(e.newVal); // expand
	});

	// when they select an option, set the hidden input with the KEY, to be saved
	SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.ac.on('select', function(e) {
		SyncToHidden(e.result.raw.key);
	});
 
});
</script> 
{/literal}
{/if}
</tr>
{/capture}
{if $fieldsUsed > 0 }
{$tableRow}
{/if}
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{capture name="tr" assign="tableRow"}
<tr>
<td valign="top" id='fees_inr_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_FEES_INR' module='te_ba_Batch'}{/capture}
{$label|strip_semicolon}:
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' >
{counter name="panelFieldCount"}

{if strlen($fields.fees_inr.value) <= 0}
{assign var="value" value=$fields.fees_inr.default_value }
{else}
{assign var="value" value=$fields.fees_inr.value }
{/if}  
<input type='text' name='{$fields.fees_inr.name}'
id='{$fields.fees_inr.name}'
size='30'
maxlength='18'value='{sugar_number_format var=$value precision=2 }'
title=''
tabindex='0'
>
<td valign="top" id='fees_in_usd_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_FEES_IN_USD' module='te_ba_Batch'}{/capture}
{$label|strip_semicolon}:
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' >
{counter name="panelFieldCount"}

{if strlen($fields.fees_in_usd.value) <= 0}
{assign var="value" value=$fields.fees_in_usd.default_value }
{else}
{assign var="value" value=$fields.fees_in_usd.value }
{/if}  
<input type='text' name='{$fields.fees_in_usd.name}'
id='{$fields.fees_in_usd.name}'
size='30'
maxlength='18'value='{sugar_number_format var=$value precision=2 }'
title=''
tabindex='0'
>
</tr>
{/capture}
{if $fieldsUsed > 0 }
{$tableRow}
{/if}
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{capture name="tr" assign="tableRow"}
<tr>
<td valign="top" id='minimum_attendance_criteria_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_MINIMUM_ATTENDANCE_CRITERIA' module='te_ba_Batch'}{/capture}
{$label|strip_semicolon}:
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' >
{counter name="panelFieldCount"}

{if strlen($fields.minimum_attendance_criteria.value) <= 0}
{assign var="value" value=$fields.minimum_attendance_criteria.default_value }
{else}
{assign var="value" value=$fields.minimum_attendance_criteria.value }
{/if}  
<input type='text' name='{$fields.minimum_attendance_criteria.name}'
id='{$fields.minimum_attendance_criteria.name}'
size='30'
maxlength='18'value='{sugar_number_format var=$value precision=2 }'
title=''
tabindex='0'
>
<td valign="top" id='duration_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_DURATION' module='te_ba_Batch'}{/capture}
{$label|strip_semicolon}:
<span class="required">*</span>
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' >
{counter name="panelFieldCount"}

{if strlen($fields.duration.value) <= 0}
{assign var="value" value=$fields.duration.default_value }
{else}
{assign var="value" value=$fields.duration.value }
{/if}  
<input type='text' name='{$fields.duration.name}' 
id='{$fields.duration.name}' size='30' maxlength='255' value='{sugar_number_format precision=0 var=$value}' title='In Months' tabindex='0'    >
</tr>
{/capture}
{if $fieldsUsed > 0 }
{$tableRow}
{/if}
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{capture name="tr" assign="tableRow"}
<tr>
<td valign="top" id='registration_closing_date_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_REGISTRATION_CLOSING_DATE' module='te_ba_Batch'}{/capture}
{$label|strip_semicolon}:
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' >
{counter name="panelFieldCount"}

<span class="dateTime">
{assign var=date_value value=$fields.registration_closing_date.value }
<input class="date_input" autocomplete="off" type="text" name="{$fields.registration_closing_date.name}" id="{$fields.registration_closing_date.name}" value="{$date_value}" title=''  tabindex='0'    size="11" maxlength="10" >
{capture assign="other_attributes"}alt="{$APP.LBL_ENTER_DATE}" style="position:relative; top:6px" border="0" id="{$fields.registration_closing_date.name}_trigger"{/capture}
{sugar_getimage name="jscalendar" ext=".gif" other_attributes="$other_attributes"}
</span>
<script type="text/javascript">
Calendar.setup ({ldelim}
inputField : "{$fields.registration_closing_date.name}",
form : "form_SubpanelQuickCreate_te_ba_Batch",
ifFormat : "{$CALENDAR_FORMAT}",
daFormat : "{$CALENDAR_FORMAT}",
button : "{$fields.registration_closing_date.name}_trigger",
singleClick : true,
dateStr : "{$date_value}",
startWeekday: {$CALENDAR_FDOW|default:'0'},
step : 1,
weekNumbers:false
{rdelim}
);
</script>
<td valign="top" id='total_sessions_planned_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_TOTAL_SESSIONS_PLANNED' module='te_ba_Batch'}{/capture}
{$label|strip_semicolon}:
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' >
{counter name="panelFieldCount"}

{if strlen($fields.total_sessions_planned.value) <= 0}
{assign var="value" value=$fields.total_sessions_planned.default_value }
{else}
{assign var="value" value=$fields.total_sessions_planned.value }
{/if}  
<input type='text' name='{$fields.total_sessions_planned.name}' 
id='{$fields.total_sessions_planned.name}' size='30' maxlength='255' value='{sugar_number_format precision=0 var=$value}' title='' tabindex='0'    >
</tr>
{/capture}
{if $fieldsUsed > 0 }
{$tableRow}
{/if}
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{capture name="tr" assign="tableRow"}
<tr>
<td valign="top" id='description_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_DESCRIPTION' module='te_ba_Batch'}{/capture}
{$label|strip_semicolon}:
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' >
{counter name="panelFieldCount"}

{if empty($fields.description.value)}
{assign var="value" value=$fields.description.default_value }
{else}
{assign var="value" value=$fields.description.value }
{/if}  
<textarea  id='{$fields.description.name}' name='{$fields.description.name}'
rows="6" 
cols="103" 
title='' tabindex="0" 
 >{$value}</textarea>
<td valign="top" id='class_schedule_c_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_CLASS_SCHEDULE' module='te_ba_Batch'}{/capture}
{$label|strip_semicolon}:
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' >
{counter name="panelFieldCount"}

{if empty($fields.class_schedule_c.value)}
{assign var="value" value=$fields.class_schedule_c.default_value }
{else}
{assign var="value" value=$fields.class_schedule_c.value }
{/if}  
<textarea  id='{$fields.class_schedule_c.name}' name='{$fields.class_schedule_c.name}'
rows="4" 
cols="20" 
title='' tabindex="0" 
 >{$value}</textarea>
</tr>
{/capture}
{if $fieldsUsed > 0 }
{$tableRow}
{/if}
</table>
</div>
{if $panelFieldCount == 0}
<script>document.getElementById("DEFAULT").style.display='none';</script>
{/if}
</div></div>

<script language="javascript">
    var _form_id = '{$form_id}';
    {literal}
    SUGAR.util.doWhen(function(){
        _form_id = (_form_id == '') ? 'EditView' : _form_id;
        return document.getElementById(_form_id) != null;
    }, SUGAR.themes.actionMenu);
    {/literal}
</script>
{assign var='place' value="_FOOTER"} <!-- to be used for id for buttons with custom code in def files-->
<div class="buttons">
<div class="action_buttons">{if $bean->aclAccess("save")}<input title="{$APP.LBL_SAVE_BUTTON_TITLE}"  class="button" onclick="var _form = document.getElementById('form_SubpanelQuickCreate_te_ba_Batch'); disableOnUnloadEditView(); _form.action.value='Save';if(check_form('form_SubpanelQuickCreate_te_ba_Batch'))return SUGAR.subpanelUtils.inlineSave(_form.id, 'te_ba_Batch_subpanel_save_button');return false;" type="submit" name="te_ba_Batch_subpanel_save_button" id="te_ba_Batch_subpanel_save_button" value="{$APP.LBL_SAVE_BUTTON_LABEL}">{/if}  <input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" class="button" onclick="return SUGAR.subpanelUtils.cancelCreate($(this).attr('id'));return false;" type="submit" name="te_ba_Batch_subpanel_cancel_button" id="te_ba_Batch_subpanel_cancel_button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">  <input title="{$APP.LBL_FULL_FORM_BUTTON_TITLE}" class="button" onclick="var _form = document.getElementById('form_SubpanelQuickCreate_te_ba_Batch'); disableOnUnloadEditView(_form); _form.return_action.value='DetailView'; _form.action.value='EditView'; if(typeof(_form.to_pdf)!='undefined') _form.to_pdf.value='0';" type="submit" name="te_ba_Batch_subpanel_full_form_button" id="te_ba_Batch_subpanel_full_form_button" value="{$APP.LBL_FULL_FORM_BUTTON_LABEL}"> <input type="hidden" name="full_form" value="full_form"> {if $bean->aclAccess("detail")}{if !empty($fields.id.value) && $isAuditEnabled}<input id="btn_view_change_log" title="{$APP.LNK_VIEW_CHANGE_LOG}" class="button" onclick='open_popup("Audit", "600", "400", "&record={$fields.id.value}&module_name=te_ba_Batch", true, false,  {ldelim} "call_back_function":"set_return","form_name":"EditView","field_to_name_array":[] {rdelim} ); return false;' type="button" value="{$APP.LNK_VIEW_CHANGE_LOG}">{/if}{/if}<div class="clear"></div></div>
</div>
</form>
{$set_focus_block}
<script>SUGAR.util.doWhen("document.getElementById('EditView') != null",
        function(){ldelim}SUGAR.util.buildAccessKeyLabels();{rdelim});
</script><script type="text/javascript">
YAHOO.util.Event.onContentReady("form_SubpanelQuickCreate_te_ba_Batch",
    function () {ldelim} initEditView(document.forms.form_SubpanelQuickCreate_te_ba_Batch) {rdelim});
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
addForm('form_SubpanelQuickCreate_te_ba_Batch');addToValidate('form_SubpanelQuickCreate_te_ba_Batch', 'name', 'name', true,'{/literal}{sugar_translate label='LBL_NAME' module='te_ba_Batch' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_te_ba_Batch', 'date_entered_date', 'date', false,'Date Created' );
addToValidate('form_SubpanelQuickCreate_te_ba_Batch', 'date_modified_date', 'date', false,'Date Modified' );
addToValidate('form_SubpanelQuickCreate_te_ba_Batch', 'modified_user_id', 'assigned_user_name', false,'{/literal}{sugar_translate label='LBL_MODIFIED' module='te_ba_Batch' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_te_ba_Batch', 'modified_by_name', 'relate', false,'{/literal}{sugar_translate label='LBL_MODIFIED_NAME' module='te_ba_Batch' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_te_ba_Batch', 'created_by', 'assigned_user_name', false,'{/literal}{sugar_translate label='LBL_CREATED' module='te_ba_Batch' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_te_ba_Batch', 'created_by_name', 'relate', false,'{/literal}{sugar_translate label='LBL_CREATED' module='te_ba_Batch' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_te_ba_Batch', 'description', 'text', false,'{/literal}{sugar_translate label='LBL_DESCRIPTION' module='te_ba_Batch' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_te_ba_Batch', 'deleted', 'bool', false,'{/literal}{sugar_translate label='LBL_DELETED' module='te_ba_Batch' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_te_ba_Batch', 'assigned_user_id', 'relate', false,'{/literal}{sugar_translate label='LBL_ASSIGNED_TO_ID' module='te_ba_Batch' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_te_ba_Batch', 'assigned_user_name', 'relate', false,'{/literal}{sugar_translate label='LBL_ASSIGNED_TO_NAME' module='te_ba_Batch' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_te_ba_Batch', 'batch_code', 'varchar', true,'{/literal}{sugar_translate label='LBL_BATCH_CODE' module='te_ba_Batch' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_te_ba_Batch', 'batch_status', 'enum', true,'{/literal}{sugar_translate label='LBL_BATCH_STATUS' module='te_ba_Batch' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_te_ba_Batch', 'batch_start_date', 'date', true,'{/literal}{sugar_translate label='LBL_BATCH_START_DATE' module='te_ba_Batch' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_te_ba_Batch', 'no_of_installments', 'int', true,'{/literal}{sugar_translate label='LBL_NO_OF_INSTALLMENTS' module='te_ba_Batch' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_te_ba_Batch', 'batch_size', 'int', true,'{/literal}{sugar_translate label='LBL_BATCH_SIZE' module='te_ba_Batch' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_te_ba_Batch', 'initial_payment_inr', 'int', true,'{/literal}{sugar_translate label='LBL_INITIAL_PAYMENT_INR' module='te_ba_Batch' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_te_ba_Batch', 'initial_payment_usd', 'int', true,'{/literal}{sugar_translate label='LBL_INITIAL_PAYMENT_USD' module='te_ba_Batch' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_te_ba_Batch', 'initial_payment_date', 'date', true,'{/literal}{sugar_translate label='LBL_INITIAL_PAYMENT_DATE' module='te_ba_Batch' for_js=true}{literal}' );
addToValidateRange('form_SubpanelQuickCreate_te_ba_Batch', 'duration', 'int', true, '{/literal}{sugar_translate label='LBL_DURATION' module='te_ba_Batch' for_js=true}{literal}', false, 60);
addToValidate('form_SubpanelQuickCreate_te_ba_Batch', 'total_sessions_planned', 'int', false,'{/literal}{sugar_translate label='LBL_TOTAL_SESSIONS_PLANNED' module='te_ba_Batch' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_te_ba_Batch', 'fees_inr', 'float', false,'{/literal}{sugar_translate label='LBL_FEES_INR' module='te_ba_Batch' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_te_ba_Batch', 'fees_in_usd', 'float', false,'{/literal}{sugar_translate label='LBL_FEES_IN_USD' module='te_ba_Batch' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_te_ba_Batch', 'registration_closing_date', 'date', false,'{/literal}{sugar_translate label='LBL_REGISTRATION_CLOSING_DATE' module='te_ba_Batch' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_te_ba_Batch', 'minimum_attendance_criteria', 'float', false,'{/literal}{sugar_translate label='LBL_MINIMUM_ATTENDANCE_CRITERIA' module='te_ba_Batch' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_te_ba_Batch', 'te_in_institutes_te_ba_batch_1_name', 'relate', true,'{/literal}{sugar_translate label='LBL_TE_IN_INSTITUTES_TE_BA_BATCH_1_FROM_TE_IN_INSTITUTES_TITLE' module='te_ba_Batch' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_te_ba_Batch', 'class_schedule_c', 'text', false,'{/literal}{sugar_translate label='LBL_CLASS_SCHEDULE' module='te_ba_Batch' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_te_ba_Batch', 'batch_start_date1', 'date', false,'{/literal}{sugar_translate label='LBL_BATCH_START_DATE' module='te_ba_Batch' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_te_ba_Batch', 'enrolled_students_c', 'varchar', false,'{/literal}{sugar_translate label='LBL_ENROLLED_STUDENTS' module='te_ba_Batch' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_te_ba_Batch', 'minimum_batch_size_c', 'varchar', false,'{/literal}{sugar_translate label='LBL_MINIMUM_BATCH_SIZE' module='te_ba_Batch' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_te_ba_Batch', 'te_pr_programs_te_ba_batch_1_name', 'relate', true,'{/literal}{sugar_translate label='LBL_TE_PR_PROGRAMS_TE_BA_BATCH_1_FROM_TE_PR_PROGRAMS_TITLE' module='te_ba_Batch' for_js=true}{literal}' );
addToValidateBinaryDependency('form_SubpanelQuickCreate_te_ba_Batch', 'assigned_user_name', 'alpha', false,'{/literal}{sugar_translate label='ERR_SQS_NO_MATCH_FIELD' module='te_ba_Batch' for_js=true}{literal}: {/literal}{sugar_translate label='LBL_ASSIGNED_TO' module='te_ba_Batch' for_js=true}{literal}', 'assigned_user_id' );
</script>{/literal}
