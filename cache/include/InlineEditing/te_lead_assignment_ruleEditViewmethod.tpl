
{if empty($fields.method.value)}
{assign var="value" value=$fields.method.default_value }
{else}
{assign var="value" value=$fields.method.value }
{/if}
{capture name=idname assign=idname}{$fields.method.name}{/capture}

{if isset($fields.method.value) && $fields.method.value != ''}
	{html_radios id="$idname"    name="$idname" title="" options=$fields.method.options selected=$fields.method.value separator="<br>"}
{else}
	{html_radios id="$idname"   name="$idname" title="" options=$fields.method.options selected=$fields.method.default separator="<br>"}
{/if}