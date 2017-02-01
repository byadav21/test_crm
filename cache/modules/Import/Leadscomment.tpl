
{if empty($fields.comment.value)}
{assign var="value" value=$fields.comment.default_value }
{else}
{assign var="value" value=$fields.comment.value }
{/if}  




<textarea  id='{$fields.comment.name}' name='{$fields.comment.name}'
rows="6" 
cols="103" 
title='' tabindex="1" 
 >{$value}</textarea>


