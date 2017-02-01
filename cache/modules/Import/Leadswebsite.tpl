
	{if !empty($fields.website.value)}
	<input type='text' name='{$fields.website.name}' id='{$fields.website.name}' size='30' 
	   maxlength='255' value='{$fields.website.value}' title='' tabindex='1'  >
	{else}
	<input type='text' name='{$fields.website.name}' id='{$fields.website.name}' size='30' 
	   maxlength='255'	   	   {if $displayView=='advanced_search'||$displayView=='basic_search'}value=''{else}value='http://'{/if} 
	    title='' tabindex='1'  >
	{/if}
