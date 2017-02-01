
{if strlen($fields.mailer_day.value) <= 0}
{assign var="value" value=$fields.mailer_day.default_value }
{else}
{assign var="value" value=$fields.mailer_day.value }
{/if}  
<input type='text' name='{$fields.mailer_day.name}' 
id='{$fields.mailer_day.name}' size='30' maxlength='11' value='{sugar_number_format precision=0 var=$value}' title='' tabindex='1'    >