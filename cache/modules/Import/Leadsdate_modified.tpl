
<span class="dateTime">
{assign var=date_value value=$fields.date_modified.value }
<input class="date_input" autocomplete="off" type="text" name="{$fields.date_modified.name}" id="{$fields.date_modified.name}" value="{$date_value}" title=''  tabindex='1'    size="11" maxlength="10" >
{capture assign="other_attributes"}alt="{$APP.LBL_ENTER_DATE}" style="position:relative; top:6px" border="0" id="{$fields.date_modified.name}_trigger"{/capture}
{sugar_getimage name="jscalendar" ext=".gif" other_attributes="$other_attributes"}
&nbsp;(<span class="dateFormat">{$USER_DATEFORMAT}</span>)
</span>
<script type="text/javascript">
Calendar.setup ({ldelim}
inputField : "{$fields.date_modified.name}",
form : "importstep3",
ifFormat : "{$CALENDAR_FORMAT}",
daFormat : "{$CALENDAR_FORMAT}",
button : "{$fields.date_modified.name}_trigger",
singleClick : true,
dateStr : "{$date_value}",
startWeekday: {$CALENDAR_FDOW|default:'0'},
step : 1,
weekNumbers:false
{rdelim}
);
</script>
