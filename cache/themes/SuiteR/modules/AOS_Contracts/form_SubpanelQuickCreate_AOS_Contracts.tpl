

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
<div class="action_buttons">{if $bean->aclAccess("save")}<input title="{$APP.LBL_SAVE_BUTTON_TITLE}"  class="button" onclick="var _form = document.getElementById('form_SubpanelQuickCreate_AOS_Contracts'); disableOnUnloadEditView(); _form.action.value='Save';if(check_form('form_SubpanelQuickCreate_AOS_Contracts'))return SUGAR.subpanelUtils.inlineSave(_form.id, 'AOS_Contracts_subpanel_save_button');return false;" type="submit" name="AOS_Contracts_subpanel_save_button" id="AOS_Contracts_subpanel_save_button" value="{$APP.LBL_SAVE_BUTTON_LABEL}">{/if}  <input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" class="button" onclick="return SUGAR.subpanelUtils.cancelCreate($(this).attr('id'));return false;" type="submit" name="AOS_Contracts_subpanel_cancel_button" id="AOS_Contracts_subpanel_cancel_button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">  <input title="{$APP.LBL_FULL_FORM_BUTTON_TITLE}" class="button" onclick="var _form = document.getElementById('form_SubpanelQuickCreate_AOS_Contracts'); disableOnUnloadEditView(_form); _form.return_action.value='DetailView'; _form.action.value='EditView'; if(typeof(_form.to_pdf)!='undefined') _form.to_pdf.value='0';" type="submit" name="AOS_Contracts_subpanel_full_form_button" id="AOS_Contracts_subpanel_full_form_button" value="{$APP.LBL_FULL_FORM_BUTTON_LABEL}"> <input type="hidden" name="full_form" value="full_form"> {if $bean->aclAccess("detail")}{if !empty($fields.id.value) && $isAuditEnabled}<input id="btn_view_change_log" title="{$APP.LNK_VIEW_CHANGE_LOG}" class="button" onclick='open_popup("Audit", "600", "400", "&record={$fields.id.value}&module_name=AOS_Contracts", true, false,  {ldelim} "call_back_function":"set_return","form_name":"EditView","field_to_name_array":[] {rdelim} ); return false;' type="button" value="{$APP.LNK_VIEW_CHANGE_LOG}">{/if}{/if}<div class="clear"></div></div>
</td>
<td align='right'>
{$PAGINATION}
</td>
</tr>
</table>{sugar_include include=$includes}
<span id='tabcounterJS'><script>SUGAR.TabFields=new Array();//this will be used to track tabindexes for references</script></span>
<div id="form_SubpanelQuickCreate_AOS_Contracts_tabs"
>
<div >
<div id="detailpanel_1" >
{counter name="panelFieldCount" start=0 print=false assign="panelFieldCount"}
<table width="100%" border="0" cellspacing="1" cellpadding="0"  id='Default_{$module}_Subpanel'  class="yui3-skin-sam edit view panelContainer">
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{capture name="tr" assign="tableRow"}
<tr>
<td valign="top" id='name_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_NAME' module='AOS_Contracts'}{/capture}
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
<td valign="top" id='status_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_STATUS' module='AOS_Contracts'}{/capture}
{$label|strip_semicolon}:
<span class="required">*</span>
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' >
{counter name="panelFieldCount"}

{if !isset($config.enable_autocomplete) || $config.enable_autocomplete==false}
<select name="{$fields.status.name}" 
id="{$fields.status.name}" 
title=''       
>
{if isset($fields.status.value) && $fields.status.value != ''}
{html_options options=$fields.status.options selected=$fields.status.value}
{else}
{html_options options=$fields.status.options selected=$fields.status.default}
{/if}
</select>
{else}
{assign var="field_options" value=$fields.status.options }
{capture name="field_val"}{$fields.status.value}{/capture}
{assign var="field_val" value=$smarty.capture.field_val}
{capture name="ac_key"}{$fields.status.name}{/capture}
{assign var="ac_key" value=$smarty.capture.ac_key}
<select style='display:none' name="{$fields.status.name}" 
id="{$fields.status.name}" 
title=''          
>
{if isset($fields.status.value) && $fields.status.value != ''}
{html_options options=$fields.status.options selected=$fields.status.value}
{else}
{html_options options=$fields.status.options selected=$fields.status.default}
{/if}
</select>
<input
id="{$fields.status.name}-input"
name="{$fields.status.name}-input"
size="30"
value="{$field_val|lookup:$field_options}"
type="text" style="vertical-align: top;">
<span class="id-ff multiple">
<button type="button"><img src="{sugar_getimagepath file="id-ff-down.png"}" id="{$fields.status.name}-image"></button><button type="button"
id="btn-clear-{$fields.status.name}-input"
title="Clear"
onclick="SUGAR.clearRelateField(this.form, '{$fields.status.name}-input', '{$fields.status.name}');sync_{$fields.status.name}()"><img src="{sugar_getimagepath file="id-ff-clear.png"}"></button>
</span>
{literal}
<script>
	SUGAR.AutoComplete.{/literal}{$ac_key}{literal} = [];
	{/literal}

			{literal}
		(function (){
			var selectElem = document.getElementById("{/literal}{$fields.status.name}{literal}");
			
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
			
	SUGAR.AutoComplete.{$ac_key}.inputNode = Y.one('#{$fields.status.name}-input');
	SUGAR.AutoComplete.{$ac_key}.inputImage = Y.one('#{$fields.status.name}-image');
	SUGAR.AutoComplete.{$ac_key}.inputHidden = Y.one('#{$fields.status.name}');
	
			{literal}
			function SyncToHidden(selectme){
				var selectElem = document.getElementById("{/literal}{$fields.status.name}{literal}");
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
			sync_{/literal}{$fields.status.name}{literal} = function(){
				SyncToHidden();
			}
			function syncFromHiddenToWidget(){

				var selectElem = document.getElementById("{/literal}{$fields.status.name}{literal}");

				//if select no longer on page, kill timer
				if (selectElem==null || selectElem.options == null)
					return;

				var currentvalue = SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.get('value');

				SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.simulate('keyup');

				for (i=0;i<selectElem.options.length;i++){

					if (selectElem.options[i].value==selectElem.value && document.activeElement != document.getElementById('{/literal}{$fields.status.name}-input{literal}'))
						SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.set('value',selectElem.options[i].innerHTML);
				}
			}

            YAHOO.util.Event.onAvailable("{/literal}{$fields.status.name}{literal}", syncFromHiddenToWidget);
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
			var selectElem = document.getElementById("{/literal}{$fields.status.name}{literal}");
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
<td valign="top" id='total_contract_value_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_TOTAL_CONTRACT_VALUE' module='AOS_Contracts'}{/capture}
{$label|strip_semicolon}:
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' >
{counter name="panelFieldCount"}

{if strlen($fields.total_contract_value.value) <= 0}
{assign var="value" value=$fields.total_contract_value.default_value }
{else}
{assign var="value" value=$fields.total_contract_value.value }
{/if}  
<input type='text' name='{$fields.total_contract_value.name}' 
id='{$fields.total_contract_value.name}' size='30' maxlength='26,6' value='{sugar_number_format var=$value}' title='' tabindex='0'
>
<td valign="top" id='renewal_reminder_date_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_EXPIRY_DATE' module='AOS_Contracts'}{/capture}
{$label|strip_semicolon}:
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' >
{counter name="panelFieldCount"}

<span class="dateTime">
{assign var=date_value value=$fields.renewal_reminder_date.value }
<input class="date_input" autocomplete="off" type="text" name="{$fields.renewal_reminder_date.name}" id="{$fields.renewal_reminder_date.name}" value="{$date_value}" title=''  tabindex='0'    size="11" maxlength="10" >
{capture assign="other_attributes"}alt="{$APP.LBL_ENTER_DATE}" style="position:relative; top:6px" border="0" id="{$fields.renewal_reminder_date.name}_trigger"{/capture}
{sugar_getimage name="jscalendar" ext=".gif" other_attributes="$other_attributes"}
</span>
<script type="text/javascript">
Calendar.setup ({ldelim}
inputField : "{$fields.renewal_reminder_date.name}",
form : "form_SubpanelQuickCreate_AOS_Contracts",
ifFormat : "{$CALENDAR_FORMAT}",
daFormat : "{$CALENDAR_FORMAT}",
button : "{$fields.renewal_reminder_date.name}_trigger",
singleClick : true,
dateStr : "{$date_value}",
startWeekday: {$CALENDAR_FDOW|default:'0'},
step : 1,
weekNumbers:false
{rdelim}
);
</script>
</tr>
{/capture}
{if $fieldsUsed > 0 }
{$tableRow}
{/if}
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{capture name="tr" assign="tableRow"}
<tr>
<td valign="top" id='rate_c_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_RATE' module='AOS_Contracts'}{/capture}
{$label|strip_semicolon}:
<span class="required">*</span>
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' >
{counter name="panelFieldCount"}

{if strlen($fields.rate_c.value) <= 0}
{assign var="value" value=$fields.rate_c.default_value }
{else}
{assign var="value" value=$fields.rate_c.value }
{/if}  
<input type='text' name='{$fields.rate_c.name}' 
id='{$fields.rate_c.name}' size='30' maxlength='26' value='{sugar_number_format var=$value}' title='' tabindex='0'
>
<td valign="top" id='start_date_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_START_DATE' module='AOS_Contracts'}{/capture}
{$label|strip_semicolon}:
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' >
{counter name="panelFieldCount"}

<span class="dateTime">
{assign var=date_value value=$fields.start_date.value }
<input class="date_input" autocomplete="off" type="text" name="{$fields.start_date.name}" id="{$fields.start_date.name}" value="{$date_value}" title=''  tabindex='0'    size="11" maxlength="10" >
{capture assign="other_attributes"}alt="{$APP.LBL_ENTER_DATE}" style="position:relative; top:6px" border="0" id="{$fields.start_date.name}_trigger"{/capture}
{sugar_getimage name="jscalendar" ext=".gif" other_attributes="$other_attributes"}
</span>
<script type="text/javascript">
Calendar.setup ({ldelim}
inputField : "{$fields.start_date.name}",
form : "form_SubpanelQuickCreate_AOS_Contracts",
ifFormat : "{$CALENDAR_FORMAT}",
daFormat : "{$CALENDAR_FORMAT}",
button : "{$fields.start_date.name}_trigger",
singleClick : true,
dateStr : "{$date_value}",
startWeekday: {$CALENDAR_FDOW|default:'0'},
step : 1,
weekNumbers:false
{rdelim}
);
</script>
</tr>
{/capture}
{if $fieldsUsed > 0 }
{$tableRow}
{/if}
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{capture name="tr" assign="tableRow"}
<tr>
<td valign="top" id='target_c_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_TARGET' module='AOS_Contracts'}{/capture}
{$label|strip_semicolon}:
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' >
{counter name="panelFieldCount"}

{if strlen($fields.target_c.value) <= 0}
{assign var="value" value=$fields.target_c.default_value }
{else}
{assign var="value" value=$fields.target_c.value }
{/if}  
<input type='text' name='{$fields.target_c.name}' 
id='{$fields.target_c.name}' size='30' 
maxlength='20' 
value='{$value}' title=''      >
<td valign="top" id='end_date_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_END_DATE' module='AOS_Contracts'}{/capture}
{$label|strip_semicolon}:
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' >
{counter name="panelFieldCount"}

<span class="dateTime">
{assign var=date_value value=$fields.end_date.value }
<input class="date_input" autocomplete="off" type="text" name="{$fields.end_date.name}" id="{$fields.end_date.name}" value="{$date_value}" title=''  tabindex='0'    size="11" maxlength="10" >
{capture assign="other_attributes"}alt="{$APP.LBL_ENTER_DATE}" style="position:relative; top:6px" border="0" id="{$fields.end_date.name}_trigger"{/capture}
{sugar_getimage name="jscalendar" ext=".gif" other_attributes="$other_attributes"}
</span>
<script type="text/javascript">
Calendar.setup ({ldelim}
inputField : "{$fields.end_date.name}",
form : "form_SubpanelQuickCreate_AOS_Contracts",
ifFormat : "{$CALENDAR_FORMAT}",
daFormat : "{$CALENDAR_FORMAT}",
button : "{$fields.end_date.name}_trigger",
singleClick : true,
dateStr : "{$date_value}",
startWeekday: {$CALENDAR_FDOW|default:'0'},
step : 1,
weekNumbers:false
{rdelim}
);
</script>
</tr>
{/capture}
{if $fieldsUsed > 0 }
{$tableRow}
{/if}
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{capture name="tr" assign="tableRow"}
<tr>
<td valign="top" id='contract_type_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_CONTRACT_TYPE' module='AOS_Contracts'}{/capture}
{$label|strip_semicolon}:
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' >
{counter name="panelFieldCount"}

{if !isset($config.enable_autocomplete) || $config.enable_autocomplete==false}
<select name="{$fields.contract_type.name}" 
id="{$fields.contract_type.name}" 
title=''       
>
{if isset($fields.contract_type.value) && $fields.contract_type.value != ''}
{html_options options=$fields.contract_type.options selected=$fields.contract_type.value}
{else}
{html_options options=$fields.contract_type.options selected=$fields.contract_type.default}
{/if}
</select>
{else}
{assign var="field_options" value=$fields.contract_type.options }
{capture name="field_val"}{$fields.contract_type.value}{/capture}
{assign var="field_val" value=$smarty.capture.field_val}
{capture name="ac_key"}{$fields.contract_type.name}{/capture}
{assign var="ac_key" value=$smarty.capture.ac_key}
<select style='display:none' name="{$fields.contract_type.name}" 
id="{$fields.contract_type.name}" 
title=''          
>
{if isset($fields.contract_type.value) && $fields.contract_type.value != ''}
{html_options options=$fields.contract_type.options selected=$fields.contract_type.value}
{else}
{html_options options=$fields.contract_type.options selected=$fields.contract_type.default}
{/if}
</select>
<input
id="{$fields.contract_type.name}-input"
name="{$fields.contract_type.name}-input"
size="30"
value="{$field_val|lookup:$field_options}"
type="text" style="vertical-align: top;">
<span class="id-ff multiple">
<button type="button"><img src="{sugar_getimagepath file="id-ff-down.png"}" id="{$fields.contract_type.name}-image"></button><button type="button"
id="btn-clear-{$fields.contract_type.name}-input"
title="Clear"
onclick="SUGAR.clearRelateField(this.form, '{$fields.contract_type.name}-input', '{$fields.contract_type.name}');sync_{$fields.contract_type.name}()"><img src="{sugar_getimagepath file="id-ff-clear.png"}"></button>
</span>
{literal}
<script>
	SUGAR.AutoComplete.{/literal}{$ac_key}{literal} = [];
	{/literal}

			{literal}
		(function (){
			var selectElem = document.getElementById("{/literal}{$fields.contract_type.name}{literal}");
			
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
			
	SUGAR.AutoComplete.{$ac_key}.inputNode = Y.one('#{$fields.contract_type.name}-input');
	SUGAR.AutoComplete.{$ac_key}.inputImage = Y.one('#{$fields.contract_type.name}-image');
	SUGAR.AutoComplete.{$ac_key}.inputHidden = Y.one('#{$fields.contract_type.name}');
	
			{literal}
			function SyncToHidden(selectme){
				var selectElem = document.getElementById("{/literal}{$fields.contract_type.name}{literal}");
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
			sync_{/literal}{$fields.contract_type.name}{literal} = function(){
				SyncToHidden();
			}
			function syncFromHiddenToWidget(){

				var selectElem = document.getElementById("{/literal}{$fields.contract_type.name}{literal}");

				//if select no longer on page, kill timer
				if (selectElem==null || selectElem.options == null)
					return;

				var currentvalue = SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.get('value');

				SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.simulate('keyup');

				for (i=0;i<selectElem.options.length;i++){

					if (selectElem.options[i].value==selectElem.value && document.activeElement != document.getElementById('{/literal}{$fields.contract_type.name}-input{literal}'))
						SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.set('value',selectElem.options[i].innerHTML);
				}
			}

            YAHOO.util.Event.onAvailable("{/literal}{$fields.contract_type.name}{literal}", syncFromHiddenToWidget);
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
			var selectElem = document.getElementById("{/literal}{$fields.contract_type.name}{literal}");
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
<td valign="top" id='description_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_DESCRIPTION' module='AOS_Contracts'}{/capture}
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
cols="84" 
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
<div class="action_buttons">{if $bean->aclAccess("save")}<input title="{$APP.LBL_SAVE_BUTTON_TITLE}"  class="button" onclick="var _form = document.getElementById('form_SubpanelQuickCreate_AOS_Contracts'); disableOnUnloadEditView(); _form.action.value='Save';if(check_form('form_SubpanelQuickCreate_AOS_Contracts'))return SUGAR.subpanelUtils.inlineSave(_form.id, 'AOS_Contracts_subpanel_save_button');return false;" type="submit" name="AOS_Contracts_subpanel_save_button" id="AOS_Contracts_subpanel_save_button" value="{$APP.LBL_SAVE_BUTTON_LABEL}">{/if}  <input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" class="button" onclick="return SUGAR.subpanelUtils.cancelCreate($(this).attr('id'));return false;" type="submit" name="AOS_Contracts_subpanel_cancel_button" id="AOS_Contracts_subpanel_cancel_button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">  <input title="{$APP.LBL_FULL_FORM_BUTTON_TITLE}" class="button" onclick="var _form = document.getElementById('form_SubpanelQuickCreate_AOS_Contracts'); disableOnUnloadEditView(_form); _form.return_action.value='DetailView'; _form.action.value='EditView'; if(typeof(_form.to_pdf)!='undefined') _form.to_pdf.value='0';" type="submit" name="AOS_Contracts_subpanel_full_form_button" id="AOS_Contracts_subpanel_full_form_button" value="{$APP.LBL_FULL_FORM_BUTTON_LABEL}"> <input type="hidden" name="full_form" value="full_form"> {if $bean->aclAccess("detail")}{if !empty($fields.id.value) && $isAuditEnabled}<input id="btn_view_change_log" title="{$APP.LNK_VIEW_CHANGE_LOG}" class="button" onclick='open_popup("Audit", "600", "400", "&record={$fields.id.value}&module_name=AOS_Contracts", true, false,  {ldelim} "call_back_function":"set_return","form_name":"EditView","field_to_name_array":[] {rdelim} ); return false;' type="button" value="{$APP.LNK_VIEW_CHANGE_LOG}">{/if}{/if}<div class="clear"></div></div>
</div>
</form>
{$set_focus_block}
<script>SUGAR.util.doWhen("document.getElementById('EditView') != null",
        function(){ldelim}SUGAR.util.buildAccessKeyLabels();{rdelim});
</script><script type="text/javascript">
YAHOO.util.Event.onContentReady("form_SubpanelQuickCreate_AOS_Contracts",
    function () {ldelim} initEditView(document.forms.form_SubpanelQuickCreate_AOS_Contracts) {rdelim});
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
addForm('form_SubpanelQuickCreate_AOS_Contracts');addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'name', 'name', true,'{/literal}{sugar_translate label='LBL_NAME' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'date_entered_date', 'date', false,'Date Created' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'date_modified_date', 'date', false,'Date Modified' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'modified_user_id', 'assigned_user_name', false,'{/literal}{sugar_translate label='LBL_MODIFIED' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'modified_by_name', 'relate', false,'{/literal}{sugar_translate label='LBL_MODIFIED_NAME' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'created_by', 'assigned_user_name', false,'{/literal}{sugar_translate label='LBL_CREATED' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'created_by_name', 'relate', false,'{/literal}{sugar_translate label='LBL_CREATED' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'description', 'text', false,'{/literal}{sugar_translate label='LBL_DESCRIPTION' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'deleted', 'bool', false,'{/literal}{sugar_translate label='LBL_DELETED' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'assigned_user_id', 'relate', false,'{/literal}{sugar_translate label='LBL_ASSIGNED_TO_ID' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'assigned_user_name', 'relate', false,'{/literal}{sugar_translate label='LBL_ASSIGNED_TO_NAME' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'reference_code', 'varchar', false,'{/literal}{sugar_translate label='LBL_REFERENCE_CODE ' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'start_date', 'date', false,'{/literal}{sugar_translate label='LBL_START_DATE' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'end_date', 'date', false,'{/literal}{sugar_translate label='LBL_END_DATE' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'total_contract_value', 'currency', false,'{/literal}{sugar_translate label='LBL_TOTAL_CONTRACT_VALUE' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'total_contract_value_usdollar', 'currency', false,'{/literal}{sugar_translate label='LBL_TOTAL_CONTRACT_VALUE_USDOLLAR' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'currency_id', 'id', false,'{/literal}{sugar_translate label='LBL_CURRENCY' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'status', 'enum', true,'{/literal}{sugar_translate label='LBL_STATUS' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'customer_signed_date', 'date', false,'{/literal}{sugar_translate label='LBL_CUSTOMER_SIGNED_DATE' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'company_signed_date', 'date', false,'{/literal}{sugar_translate label='LBL_COMPANY_SIGNED_DATE' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'renewal_reminder_date', 'date', false,'{/literal}{sugar_translate label='LBL_RENEWAL_REMINDER_DATE' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'contract_type', 'enum', false,'{/literal}{sugar_translate label='LBL_CONTRACT_TYPE' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'contract_account_id', 'id', false,'{/literal}{sugar_translate label='' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'contract_account', 'relate', true,'{/literal}{sugar_translate label='LBL_CONTRACT_ACCOUNT' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'opportunity_id', 'id', false,'{/literal}{sugar_translate label='' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'opportunity', 'relate', false,'{/literal}{sugar_translate label='LBL_OPPORTUNITY' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'contact_id', 'id', false,'{/literal}{sugar_translate label='' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'contact', 'relate', false,'{/literal}{sugar_translate label='LBL_CONTACT' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'call_id', 'id', false,'{/literal}{sugar_translate label='' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'line_items', 'function', false,'{/literal}{sugar_translate label='LBL_LINE_ITEMS' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'total_amt', 'currency', false,'{/literal}{sugar_translate label='LBL_TOTAL_AMT' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'total_amt_usdollar', 'currency', false,'{/literal}{sugar_translate label='LBL_TOTAL_AMT_USDOLLAR' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'subtotal_amount', 'currency', false,'{/literal}{sugar_translate label='LBL_SUBTOTAL_AMOUNT' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'subtotal_amount_usdollar', 'currency', false,'{/literal}{sugar_translate label='LBL_SUBTOTAL_AMOUNT_USDOLLAR' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'discount_amount', 'currency', false,'{/literal}{sugar_translate label='LBL_DISCOUNT_AMOUNT' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'discount_amount_usdollar', 'currency', false,'{/literal}{sugar_translate label='LBL_DISCOUNT_AMOUNT_USDOLLAR' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'tax_amount', 'currency', false,'{/literal}{sugar_translate label='LBL_TAX_AMOUNT' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'tax_amount_usdollar', 'currency', false,'{/literal}{sugar_translate label='LBL_TAX_AMOUNT_USDOLLAR' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'shipping_amount', 'currency', false,'{/literal}{sugar_translate label='LBL_SHIPPING_AMOUNT' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'shipping_amount_usdollar', 'currency', false,'{/literal}{sugar_translate label='LBL_SHIPPING_AMOUNT_USDOLLAR' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'shipping_tax', 'enum', false,'{/literal}{sugar_translate label='LBL_SHIPPING_TAX' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'shipping_tax_amt', 'currency', false,'{/literal}{sugar_translate label='LBL_SHIPPING_TAX_AMT' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'shipping_tax_amt_usdollar', 'currency', false,'{/literal}{sugar_translate label='LBL_SHIPPING_TAX_AMT_USDOLLAR' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'total_amount', 'currency', false,'{/literal}{sugar_translate label='LBL_GRAND_TOTAL' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'total_amount_usdollar', 'currency', false,'{/literal}{sugar_translate label='LBL_GRAND_TOTAL_USDOLLAR' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'te_vendor_aos_contracts_1_name', 'relate', true,'{/literal}{sugar_translate label='LBL_TE_VENDOR_AOS_CONTRACTS_1_FROM_TE_VENDOR_TITLE' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'te_vendor_id_c', 'id', false,'{/literal}{sugar_translate label='LBL_VENDOR_TE_VENDOR_ID' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'vendor', 'relate', false,'{/literal}{sugar_translate label='LBL_VENDOR' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'expiry_valume_c', 'int', false,'{/literal}{sugar_translate label='LBL_EXPIRY_VALUME' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'performance_metrics', 'enum', false,'{/literal}{sugar_translate label='Performance Metrics' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'volume_c', 'varchar', false,'{/literal}{sugar_translate label='LBL_VOLUME' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'target_c', 'varchar', false,'{/literal}{sugar_translate label='LBL_TARGET' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'rate_c', 'currency', true,'{/literal}{sugar_translate label='LBL_RATE' module='AOS_Contracts' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOS_Contracts', 'po_number', 'varchar', false,'{/literal}{sugar_translate label='LBL_PO_NUMBER' module='AOS_Contracts' for_js=true}{literal}' );
addToValidateBinaryDependency('form_SubpanelQuickCreate_AOS_Contracts', 'assigned_user_name', 'alpha', false,'{/literal}{sugar_translate label='ERR_SQS_NO_MATCH_FIELD' module='AOS_Contracts' for_js=true}{literal}: {/literal}{sugar_translate label='LBL_ASSIGNED_TO' module='AOS_Contracts' for_js=true}{literal}', 'assigned_user_id' );
</script>{/literal}
