

{if strlen($fields.assistant_phone.value) <= 0}
{assign var="value" value=$fields.assistant_phone.default_value }
{else}
{assign var="value" value=$fields.assistant_phone.value }
{/if}  

<input type='text' name='{$fields.assistant_phone.name}' id='{$fields.assistant_phone.name}' size='30' maxlength='100' value='{$value}' title='' tabindex='1'	  class="phone" >
