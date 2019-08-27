{*

/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/




*}


<script>
{literal}
function set_focus(){
	document.getElementById('name').focus();
}
{/literal}
</script>

<form method='POST' name='EditView' action='index.php'>
<TABLE width='100%' border='0' cellpadding=0 cellspacing = 0 class="actionsContainer">
<tbody>
<tr>
<td>
<input type='hidden' name='record' value='{$ROLE.id}'>
<input type='hidden' name='module' value='ACLRoles'>
<input type='hidden' name='action' value='Save'>
<input type='hidden' name='isduplicate' value='{$ISDUPLICATE}'>
<input type='hidden' name='return_record' value='{$RETURN.record}'>
<input type='hidden' name='return_action' value='{$RETURN.action}'>
<input type='hidden' name='return_module' value='{$RETURN.module}'> &nbsp;
{sugar_action_menu id="roleEditActions" class="clickMenu fancymenu" buttons=$ACTION_MENU flat=true}
</td>
</tr>
</tbody>
</table>
<TABLE width='100%' class="edit view"  border='0' cellpadding=0 cellspacing = 0  >
<TR>
<td scope="row" align='right'>{$MOD.LBL_NAME}:<span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span></td><td >
<input id='name' name='name' type='text' value='{$ROLE.name}'>
</td><td>&nbsp;</td><td>&nbsp;</td>
</tr>
<TR>
<td scope="row" align='right'>Slug:<span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span></td><td >
<input id='slug' name='slug' type='text' value='{$ROLE.slug}'>
</td><td>&nbsp;</td><td>&nbsp;</td>
</tr>
<tr>
<td scope="row" align='right'>{$MOD.LBL_DESCRIPTION}:</td>
<td ><textarea name='description' cols="80" rows="8">{$ROLE.description}</textarea></td>
</tr>
<tr>
<td scope="row" align='right'>Parent Role:</td>
<td >

<select  id='parent_role' name='parent_role' >
<option>-Select-</option>

{foreach from=$allRoles item=val}
<option {if $val.id==$otherRecords.parent_role} selected {/if} value="{$val.id}">  {$val.name} </option>
{/foreach}
</select>

</td>
</tr>
<tr>
<td scope="row" align='right'>Permission</td>
<td >
<input {if 1==$otherRecords.isvendor} checked {/if} style="     margin-top: -11px;"type="checkbox" name="isvendor" value="1"> Is vendor module
</td>
</tr>
<tr>
<td scope="row" align='right'>Permission</td>
<td >
<input {if 1==$otherRecords.issubmit} checked {/if} style="    margin-top: -11px;" type="checkbox" name="issubmit" value="1"> Can Submit 
<input {if 1==$otherRecords.isapprove} checked {/if} style="     margin-top: -11px;"type="checkbox" name="isapprove" value="1"> Can Approve 
<input {if 1==$otherRecords.sendtofin} checked {/if} style="     margin-top: -11px;"type="checkbox" name="sendtofin" value="1"> Can Send to Facility 
<input {if 1==$otherRecords.isfacility} checked {/if} style="     margin-top: -11px;"type="checkbox" name="isfacility" value="1"> Is Facility Role
</td>
</tr>
</table>

</form>
<script type="text/javascript">
addToValidate('EditView', 'name', 'varchar', true, '{$MOD.LBL_NAME}');
</script>
