

<table border="0" cellpadding="0" cellspacing="0" class="dateTime">
<tr valign="middle">
<td nowrap>
<input autocomplete="off" type="text" id="{$fields.date_of_callback.name}_date" value="{$fields[$fields.date_of_callback.name].value}" size="11" maxlength="10" title='' tabindex="1" onblur="combo_{$fields.date_of_callback.name}.update();" onchange="combo_{$fields.date_of_callback.name}.update(); "    >
{capture assign="other_attributes"}alt="{$APP.LBL_ENTER_DATE}" style="position:relative; top:6px" border="0" id="{$fields.date_of_callback.name}_trigger"{/capture}
{sugar_getimage name="jscalendar" ext=".gif" other_attributes="$other_attributes"}&nbsp;
</td>
<td nowrap>
<div id="{$fields.date_of_callback.name}_time_section"></div>
</td>
</tr>
<tr valign="middle">
<td nowrap>
<span class="dateFormat">{$USER_DATEFORMAT}</span>
</td>
<td nowrap>
<span class="dateFormat">{$TIME_FORMAT}</span>
</td>
</tr>
</table>
<input type="hidden" class="DateTimeCombo" id="{$fields.date_of_callback.name}" name="{$fields.date_of_callback.name}" value="{$fields[$fields.date_of_callback.name].value}">
<script type="text/javascript" src="{sugar_getjspath file="include/SugarFields/Fields/Datetimecombo/Datetimecombo.js"}"></script>
<script type="text/javascript">
var combo_{$fields.date_of_callback.name} = new Datetimecombo("{$fields[$fields.date_of_callback.name].value}", "{$fields.date_of_callback.name}", "{$TIME_FORMAT}", "1", '', false, true);
//Render the remaining widget fields
text = combo_{$fields.date_of_callback.name}.html('');
document.getElementById('{$fields.date_of_callback.name}_time_section').innerHTML = text;

//Call eval on the update function to handle updates to calendar picker object
eval(combo_{$fields.date_of_callback.name}.jsscript(''));

//bug 47718: this causes too many addToValidates to be called, resulting in the error messages being displayed multiple times
//    removing it here to mirror the Datetime SugarField, where the validation is not added at this level
//addToValidate('{$form_name}',"{$fields.date_of_callback.name}_date",'date',false,"{$fields.date_of_callback.name}");
addToValidateBinaryDependency('{$form_name}',"{$fields.date_of_callback.name}_hours", 'alpha', false, "{$APP.ERR_MISSING_REQUIRED_FIELDS} {$APP.LBL_HOURS}" ,"{$fields.date_of_callback.name}_date");
addToValidateBinaryDependency('{$form_name}', "{$fields.date_of_callback.name}_minutes", 'alpha', false, "{$APP.ERR_MISSING_REQUIRED_FIELDS} {$APP.LBL_MINUTES}" ,"{$fields.date_of_callback.name}_date");
addToValidateBinaryDependency('{$form_name}', "{$fields.date_of_callback.name}_meridiem", 'alpha', false, "{$APP.ERR_MISSING_REQUIRED_FIELDS} {$APP.LBL_MERIDIEM}","{$fields.date_of_callback.name}_date");

YAHOO.util.Event.onDOMReady(function()
{ldelim}

	Calendar.setup ({ldelim}
	onClose : update_{$fields.date_of_callback.name},
	inputField : "{$fields.date_of_callback.name}_date",
    form : "importstep3",
	ifFormat : "{$CALENDAR_FORMAT}",
	daFormat : "{$CALENDAR_FORMAT}",
	button : "{$fields.date_of_callback.name}_trigger",
	singleClick : true,
	step : 1,
	weekNumbers: false,
        startWeekday: {$CALENDAR_FDOW|default:'0'},
	comboObject: combo_{$fields.date_of_callback.name}
	{rdelim});

	//Call update for first time to round hours and minute values
	combo_{$fields.date_of_callback.name}.update(false);

{rdelim}); 
</script>