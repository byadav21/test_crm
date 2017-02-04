<?php /* Smarty version 2.6.29, created on 2017-02-02 12:11:27
         compiled from cache/themes/SuiteR/modules/Users/DetailView.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sugar_getjspath', 'cache/themes/SuiteR/modules/Users/DetailView.tpl', 40, false),array('function', 'sugar_action_menu', 'cache/themes/SuiteR/modules/Users/DetailView.tpl', 83, false),array('function', 'sugar_include', 'cache/themes/SuiteR/modules/Users/DetailView.tpl', 104, false),array('function', 'counter', 'cache/themes/SuiteR/modules/Users/DetailView.tpl', 109, false),array('function', 'sugar_getimagepath', 'cache/themes/SuiteR/modules/Users/DetailView.tpl', 112, false),array('function', 'sugar_translate', 'cache/themes/SuiteR/modules/Users/DetailView.tpl', 115, false),array('function', 'sugar_getimage', 'cache/themes/SuiteR/modules/Users/DetailView.tpl', 144, false),array('function', 'sugar_help', 'cache/themes/SuiteR/modules/Users/DetailView.tpl', 680, false),array('modifier', 'strip_semicolon', 'cache/themes/SuiteR/modules/Users/DetailView.tpl', 130, false),)), $this); ?>

<!--
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
-->
<script type='text/javascript' src='<?php echo smarty_function_sugar_getjspath(array('file' => 'modules/Users/DetailView.js'), $this);?>
'></script>
<script type="text/javascript" src="<?php echo smarty_function_sugar_getjspath(array('file' => 'cache/include/javascript/sugar_grp_yui_widgets.js'), $this);?>
"></script>
<script type='text/javascript'>
var LBL_NEW_USER_PASSWORD = '<?php echo $this->_tpl_vars['MOD']['LBL_NEW_USER_PASSWORD_2']; ?>
';
<?php if (! empty ( $this->_tpl_vars['ERRORS'] )): ?>
<?php echo '
YAHOO.SUGAR.MessageBox.show({title: \''; ?>
<?php echo $this->_tpl_vars['ERROR_MESSAGE']; ?>
<?php echo '\', msg: \''; ?>
<?php echo $this->_tpl_vars['ERRORS']; ?>
<?php echo '\'} );
'; ?>

<?php endif; ?>
</script>
<script type="text/javascript">
var user_detailview_tabs = new YAHOO.widget.TabView("user_detailview_tabs");

<?php echo '
user_detailview_tabs.on(\'contentReady\', function(e){
'; ?>

});
<?php echo '
$(document).ready(function(){
        $("ul.clickMenu").each(function(index, node){
            $(node).sugarActionMenu();
        });
    });
'; ?>

</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="actionsContainer">
<tr>
<td width="20%">
<form action="index.php" method="post" name="DetailView" id="form">
<input type="hidden" name="module" value="Users">
<input type="hidden" name="record" value="<?php echo $this->_tpl_vars['ID']; ?>
">
<input type="hidden" name="isDuplicate" value=false>
<input type="hidden" name="action">
<input type="hidden" name="user_name" value="<?php echo $this->_tpl_vars['USER_NAME']; ?>
">
<input type="hidden" id="user_type" name="user_type" value="<?php echo $this->_tpl_vars['UserType']; ?>
">
<input type="hidden" name="password_generate">
<input type="hidden" name="old_password">
<input type="hidden" name="new_password">
<input type="hidden" name="return_module">
<input type="hidden" name="return_action">
<input type="hidden" name="return_id">
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td colspan='2' width="100%" nowrap>
<?php echo smarty_function_sugar_action_menu(array('id' => 'detail_header_action_menu','class' => 'clickMenu fancymenu','buttons' => $this->_tpl_vars['EDITBUTTONS']), $this);?>

</td></tr>
</table>
</form>
</td>
<td width="100%">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php echo $this->_tpl_vars['PAGINATION']; ?>

</table>
</td>
</tr>
</table>
<div id="user_detailview_tabs" class="yui-navset detailview_tabs">
<ul class="yui-nav">
<li class="selected"><a id="tab1" href="#tab1"><em><?php echo $this->_tpl_vars['MOD']['LBL_USER_INFORMATION']; ?>
</em></a></li>
<li <?php if ($this->_tpl_vars['IS_GROUP_OR_PORTAL']): ?>style="display: none;"<?php endif; ?>><a id="tab2" href="#tab2"><em><?php echo $this->_tpl_vars['MOD']['LBL_ADVANCED']; ?>
</em></a></li>
<?php if ($this->_tpl_vars['SHOW_ROLES']): ?>
<li><a id="tab3" href="#tab3"><em><?php echo $this->_tpl_vars['MOD']['LBL_USER_ACCESS']; ?>
</em></a></li>
<?php endif; ?>
</ul>
<div class="yui-content">
<div><?php echo smarty_function_sugar_include(array('include' => $this->_tpl_vars['includes']), $this);?>

<div id="Users_detailview_tabs"
>
<div >
<div id='detailpanel_1' class='detail view  detail508 expanded'>
<?php echo smarty_function_counter(array('name' => 'panelFieldCount','start' => 0,'print' => false,'assign' => 'panelFieldCount'), $this);?>

<h4>
<a href="javascript:void(0)" class="collapseLink" onclick="collapsePanel(1);">
<img border="0" id="detailpanel_1_img_hide" src="<?php echo smarty_function_sugar_getimagepath(array('file' => "basic_search.gif"), $this);?>
"></a>
<a href="javascript:void(0)" class="expandLink" onclick="expandPanel(1);">
<img border="0" id="detailpanel_1_img_show" src="<?php echo smarty_function_sugar_getimagepath(array('file' => "advanced_search.gif"), $this);?>
"></a>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_USER_INFORMATION','module' => 'Users'), $this);?>

<script>
      document.getElementById('detailpanel_1').className += ' expanded';
    </script>
</h4>
<!-- PANEL CONTAINER HERE.. -->
<table id='LBL_USER_INFORMATION' class="panelContainer" cellspacing='<?php echo $this->_tpl_vars['gridline']; ?>
'>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed','start' => 0,'print' => false,'assign' => 'fieldsUsed'), $this);?>

<?php echo smarty_function_counter(array('name' => 'fieldsHidden','start' => 0,'print' => false,'assign' => 'fieldsHidden'), $this);?>

<?php ob_start(); ?>
<tr>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed'), $this);?>

<td width='12.5%' scope="col">
<?php if (! $this->_tpl_vars['fields']['user_name']['hidden']): ?>
<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_USER_NAME','module' => 'Users'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
<?php endif; ?>
</td>
<td class="inlineEdit" type="user_name" field="user_name" width='37.5%'  >
<?php if (! $this->_tpl_vars['fields']['user_name']['hidden']): ?>
<?php echo smarty_function_counter(array('name' => 'panelFieldCount'), $this);?>


<?php if (strlen ( $this->_tpl_vars['fields']['user_name']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['user_name']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['user_name']['value']); ?>
<?php endif; ?> 
<span class="sugar_field" id="<?php echo $this->_tpl_vars['fields']['user_name']['name']; ?>
"><?php echo $this->_tpl_vars['fields']['user_name']['value']; ?>
</span>
<?php endif; ?>
<div class="inlineEditIcon"> <?php echo smarty_function_sugar_getimage(array('name' => "inline_edit_icon.svg",'attr' => 'border="0" ','alt' => ($this->_tpl_vars['alt_edit'])), $this);?>
</div>			</td>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed'), $this);?>

<td width='12.5%' scope="col">
&nbsp;
</td>
<td class="" type="" field="" width='37.5%'  >
</td>
</tr>
<?php $this->_smarty_vars['capture']['tr'] = ob_get_contents();  $this->assign('tableRow', ob_get_contents());ob_end_clean(); ?>
<?php if ($this->_tpl_vars['fieldsUsed'] > 0 && $this->_tpl_vars['fieldsUsed'] != $this->_tpl_vars['fieldsHidden']): ?>
<?php echo $this->_tpl_vars['tableRow']; ?>

<?php endif; ?>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed','start' => 0,'print' => false,'assign' => 'fieldsUsed'), $this);?>

<?php echo smarty_function_counter(array('name' => 'fieldsHidden','start' => 0,'print' => false,'assign' => 'fieldsHidden'), $this);?>

<?php ob_start(); ?>
<tr>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed'), $this);?>

<td width='12.5%' scope="col">
<?php if (! $this->_tpl_vars['fields']['first_name']['hidden']): ?>
<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_FIRST_NAME','module' => 'Users'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
<?php endif; ?>
</td>
<td class="inlineEdit" type="name" field="first_name" width='37.5%'  >
<?php if (! $this->_tpl_vars['fields']['first_name']['hidden']): ?>
<?php echo smarty_function_counter(array('name' => 'panelFieldCount'), $this);?>


<?php if (strlen ( $this->_tpl_vars['fields']['first_name']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['first_name']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['first_name']['value']); ?>
<?php endif; ?> 
<span class="sugar_field" id="<?php echo $this->_tpl_vars['fields']['first_name']['name']; ?>
"><?php echo $this->_tpl_vars['fields']['first_name']['value']; ?>
</span>
<?php endif; ?>
<div class="inlineEditIcon"> <?php echo smarty_function_sugar_getimage(array('name' => "inline_edit_icon.svg",'attr' => 'border="0" ','alt' => ($this->_tpl_vars['alt_edit'])), $this);?>
</div>			</td>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed'), $this);?>

<td width='12.5%' scope="col">
<?php if (! $this->_tpl_vars['fields']['last_name']['hidden']): ?>
<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_LAST_NAME','module' => 'Users'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
<?php endif; ?>
</td>
<td class="inlineEdit" type="name" field="last_name" width='37.5%'  >
<?php if (! $this->_tpl_vars['fields']['last_name']['hidden']): ?>
<?php echo smarty_function_counter(array('name' => 'panelFieldCount'), $this);?>


<?php if (strlen ( $this->_tpl_vars['fields']['last_name']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['last_name']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['last_name']['value']); ?>
<?php endif; ?> 
<span class="sugar_field" id="<?php echo $this->_tpl_vars['fields']['last_name']['name']; ?>
"><?php echo $this->_tpl_vars['fields']['last_name']['value']; ?>
</span>
<?php endif; ?>
<div class="inlineEditIcon"> <?php echo smarty_function_sugar_getimage(array('name' => "inline_edit_icon.svg",'attr' => 'border="0" ','alt' => ($this->_tpl_vars['alt_edit'])), $this);?>
</div>			</td>
</tr>
<?php $this->_smarty_vars['capture']['tr'] = ob_get_contents();  $this->assign('tableRow', ob_get_contents());ob_end_clean(); ?>
<?php if ($this->_tpl_vars['fieldsUsed'] > 0 && $this->_tpl_vars['fieldsUsed'] != $this->_tpl_vars['fieldsHidden']): ?>
<?php echo $this->_tpl_vars['tableRow']; ?>

<?php endif; ?>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed','start' => 0,'print' => false,'assign' => 'fieldsUsed'), $this);?>

<?php echo smarty_function_counter(array('name' => 'fieldsHidden','start' => 0,'print' => false,'assign' => 'fieldsHidden'), $this);?>

<?php ob_start(); ?>
<tr>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed'), $this);?>

<td width='12.5%' scope="col">
<?php if (! $this->_tpl_vars['fields']['status']['hidden']): ?>
<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_STATUS','module' => 'Users'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
<?php endif; ?>
</td>
<td class="inlineEdit" type="enum" field="status" width='37.5%'  >
<?php if (! $this->_tpl_vars['fields']['status']['hidden']): ?>
<?php echo smarty_function_counter(array('name' => 'panelFieldCount'), $this);?>



<?php if (is_string ( $this->_tpl_vars['fields']['status']['options'] )): ?>
<input type="hidden" class="sugar_field" id="<?php echo $this->_tpl_vars['fields']['status']['name']; ?>
" value="<?php echo $this->_tpl_vars['fields']['status']['options']; ?>
">
<?php echo $this->_tpl_vars['fields']['status']['options']; ?>

<?php else: ?>
<input type="hidden" class="sugar_field" id="<?php echo $this->_tpl_vars['fields']['status']['name']; ?>
" value="<?php echo $this->_tpl_vars['fields']['status']['value']; ?>
">
<?php echo $this->_tpl_vars['fields']['status']['options'][$this->_tpl_vars['fields']['status']['value']]; ?>

<?php endif; ?>
<?php endif; ?>
<div class="inlineEditIcon"> <?php echo smarty_function_sugar_getimage(array('name' => "inline_edit_icon.svg",'attr' => 'border="0" ','alt' => ($this->_tpl_vars['alt_edit'])), $this);?>
</div>			</td>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed'), $this);?>

<td width='12.5%' scope="col">
<?php if (! $this->_tpl_vars['fields']['UserType']['hidden']): ?>
<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_USER_TYPE','module' => 'Users'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
<?php endif; ?>
</td>
<td class="inlineEdit" type="enum" field="UserType" width='37.5%'  >
<?php if (! $this->_tpl_vars['fields']['UserType']['hidden']): ?>
<?php echo smarty_function_counter(array('name' => 'panelFieldCount'), $this);?>

<span id="UserType" class="sugar_field"><?php echo $this->_tpl_vars['USER_TYPE_READONLY']; ?>
</span>
<?php endif; ?>
<div class="inlineEditIcon"> <?php echo smarty_function_sugar_getimage(array('name' => "inline_edit_icon.svg",'attr' => 'border="0" ','alt' => ($this->_tpl_vars['alt_edit'])), $this);?>
</div>			</td>
</tr>
<?php $this->_smarty_vars['capture']['tr'] = ob_get_contents();  $this->assign('tableRow', ob_get_contents());ob_end_clean(); ?>
<?php if ($this->_tpl_vars['fieldsUsed'] > 0 && $this->_tpl_vars['fieldsUsed'] != $this->_tpl_vars['fieldsHidden']): ?>
<?php echo $this->_tpl_vars['tableRow']; ?>

<?php endif; ?>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed','start' => 0,'print' => false,'assign' => 'fieldsUsed'), $this);?>

<?php echo smarty_function_counter(array('name' => 'fieldsHidden','start' => 0,'print' => false,'assign' => 'fieldsHidden'), $this);?>

<?php ob_start(); ?>
<tr>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed'), $this);?>

<td width='12.5%' scope="col">
<?php if (! $this->_tpl_vars['fields']['neox_user']['hidden']): ?>
<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_NEOXUSER','module' => 'Users'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
<?php endif; ?>
</td>
<td class="inlineEdit" type="varchar" field="neox_user" width='37.5%'  >
<?php if (! $this->_tpl_vars['fields']['neox_user']['hidden']): ?>
<?php echo smarty_function_counter(array('name' => 'panelFieldCount'), $this);?>


<?php if (strlen ( $this->_tpl_vars['fields']['neox_user']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['neox_user']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['neox_user']['value']); ?>
<?php endif; ?> 
<span class="sugar_field" id="<?php echo $this->_tpl_vars['fields']['neox_user']['name']; ?>
"><?php echo $this->_tpl_vars['fields']['neox_user']['value']; ?>
</span>
<?php endif; ?>
<div class="inlineEditIcon"> <?php echo smarty_function_sugar_getimage(array('name' => "inline_edit_icon.svg",'attr' => 'border="0" ','alt' => ($this->_tpl_vars['alt_edit'])), $this);?>
</div>			</td>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed'), $this);?>

<td width='12.5%' scope="col">
<?php if (! $this->_tpl_vars['fields']['neox_password']['hidden']): ?>
<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_NEOXPASS','module' => 'Users'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
<?php endif; ?>
</td>
<td class="inlineEdit" type="varchar" field="neox_password" width='37.5%'  >
<?php if (! $this->_tpl_vars['fields']['neox_password']['hidden']): ?>
<?php echo smarty_function_counter(array('name' => 'panelFieldCount'), $this);?>


<?php if (strlen ( $this->_tpl_vars['fields']['neox_password']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['neox_password']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['neox_password']['value']); ?>
<?php endif; ?> 
<span class="sugar_field" id="<?php echo $this->_tpl_vars['fields']['neox_password']['name']; ?>
"><?php echo $this->_tpl_vars['fields']['neox_password']['value']; ?>
</span>
<?php endif; ?>
<div class="inlineEditIcon"> <?php echo smarty_function_sugar_getimage(array('name' => "inline_edit_icon.svg",'attr' => 'border="0" ','alt' => ($this->_tpl_vars['alt_edit'])), $this);?>
</div>			</td>
</tr>
<?php $this->_smarty_vars['capture']['tr'] = ob_get_contents();  $this->assign('tableRow', ob_get_contents());ob_end_clean(); ?>
<?php if ($this->_tpl_vars['fieldsUsed'] > 0 && $this->_tpl_vars['fieldsUsed'] != $this->_tpl_vars['fieldsHidden']): ?>
<?php echo $this->_tpl_vars['tableRow']; ?>

<?php endif; ?>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed','start' => 0,'print' => false,'assign' => 'fieldsUsed'), $this);?>

<?php echo smarty_function_counter(array('name' => 'fieldsHidden','start' => 0,'print' => false,'assign' => 'fieldsHidden'), $this);?>

<?php ob_start(); ?>
<tr>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed'), $this);?>

<td width='12.5%' scope="col">
<?php if (! $this->_tpl_vars['fields']['neox_extension']['hidden']): ?>
<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_NEOXEXTENSION','module' => 'Users'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
<?php endif; ?>
</td>
<td class="inlineEdit" type="varchar" field="neox_extension" width='37.5%'  >
<?php if (! $this->_tpl_vars['fields']['neox_extension']['hidden']): ?>
<?php echo smarty_function_counter(array('name' => 'panelFieldCount'), $this);?>


<?php if (strlen ( $this->_tpl_vars['fields']['neox_extension']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['neox_extension']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['neox_extension']['value']); ?>
<?php endif; ?> 
<span class="sugar_field" id="<?php echo $this->_tpl_vars['fields']['neox_extension']['name']; ?>
"><?php echo $this->_tpl_vars['fields']['neox_extension']['value']; ?>
</span>
<?php endif; ?>
<div class="inlineEditIcon"> <?php echo smarty_function_sugar_getimage(array('name' => "inline_edit_icon.svg",'attr' => 'border="0" ','alt' => ($this->_tpl_vars['alt_edit'])), $this);?>
</div>			</td>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed'), $this);?>

<td width='12.5%' scope="col">
&nbsp;
</td>
<td class="" type="" field="" width='37.5%'  >
</td>
</tr>
<?php $this->_smarty_vars['capture']['tr'] = ob_get_contents();  $this->assign('tableRow', ob_get_contents());ob_end_clean(); ?>
<?php if ($this->_tpl_vars['fieldsUsed'] > 0 && $this->_tpl_vars['fieldsUsed'] != $this->_tpl_vars['fieldsHidden']): ?>
<?php echo $this->_tpl_vars['tableRow']; ?>

<?php endif; ?>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed','start' => 0,'print' => false,'assign' => 'fieldsUsed'), $this);?>

<?php echo smarty_function_counter(array('name' => 'fieldsHidden','start' => 0,'print' => false,'assign' => 'fieldsHidden'), $this);?>

<?php ob_start(); ?>
<tr>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed'), $this);?>

<td width='12.5%' scope="col">
<?php if (! $this->_tpl_vars['fields']['full_name']['hidden']): ?>
<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_NAME','module' => 'Users'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
<?php endif; ?>
</td>
<td class="inlineEdit" type="name" field="full_name" width='37.5%'  >
<?php if (! $this->_tpl_vars['fields']['full_name']['hidden']): ?>
<?php echo smarty_function_counter(array('name' => 'panelFieldCount'), $this);?>


<?php if (strlen ( $this->_tpl_vars['fields']['full_name']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['full_name']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['full_name']['value']); ?>
<?php endif; ?> 
<span class="sugar_field" id="<?php echo $this->_tpl_vars['fields']['full_name']['name']; ?>
"><?php echo $this->_tpl_vars['fields']['full_name']['value']; ?>
</span>
<?php endif; ?>
<div class="inlineEditIcon"> <?php echo smarty_function_sugar_getimage(array('name' => "inline_edit_icon.svg",'attr' => 'border="0" ','alt' => ($this->_tpl_vars['alt_edit'])), $this);?>
</div>			</td>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed'), $this);?>

<td width='12.5%' scope="col">
<?php if (! $this->_tpl_vars['fields']['user_access_type']['hidden']): ?>
<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_USERTYPE','module' => 'Users'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
<?php endif; ?>
</td>
<td class="inlineEdit" type="enum" field="user_access_type" width='37.5%'  >
<?php if (! $this->_tpl_vars['fields']['user_access_type']['hidden']): ?>
<?php echo smarty_function_counter(array('name' => 'panelFieldCount'), $this);?>



<?php if (is_string ( $this->_tpl_vars['fields']['user_access_type']['options'] )): ?>
<input type="hidden" class="sugar_field" id="<?php echo $this->_tpl_vars['fields']['user_access_type']['name']; ?>
" value="<?php echo $this->_tpl_vars['fields']['user_access_type']['options']; ?>
">
<?php echo $this->_tpl_vars['fields']['user_access_type']['options']; ?>

<?php else: ?>
<input type="hidden" class="sugar_field" id="<?php echo $this->_tpl_vars['fields']['user_access_type']['name']; ?>
" value="<?php echo $this->_tpl_vars['fields']['user_access_type']['value']; ?>
">
<?php echo $this->_tpl_vars['fields']['user_access_type']['options'][$this->_tpl_vars['fields']['user_access_type']['value']]; ?>

<?php endif; ?>
<?php endif; ?>
<div class="inlineEditIcon"> <?php echo smarty_function_sugar_getimage(array('name' => "inline_edit_icon.svg",'attr' => 'border="0" ','alt' => ($this->_tpl_vars['alt_edit'])), $this);?>
</div>			</td>
</tr>
<?php $this->_smarty_vars['capture']['tr'] = ob_get_contents();  $this->assign('tableRow', ob_get_contents());ob_end_clean(); ?>
<?php if ($this->_tpl_vars['fieldsUsed'] > 0 && $this->_tpl_vars['fieldsUsed'] != $this->_tpl_vars['fieldsHidden']): ?>
<?php echo $this->_tpl_vars['tableRow']; ?>

<?php endif; ?>
</table>
<script type="text/javascript">SUGAR.util.doWhen("typeof initPanel == 'function'", function() { initPanel(1, 'expanded'); }); </script>
</div>
<?php if ($this->_tpl_vars['panelFieldCount'] == 0): ?>
<script>document.getElementById("LBL_USER_INFORMATION").style.display='none';</script>
<?php endif; ?>
<div id='detailpanel_2' class='detail view  detail508 expanded'>
<?php echo smarty_function_counter(array('name' => 'panelFieldCount','start' => 0,'print' => false,'assign' => 'panelFieldCount'), $this);?>

<h4>
<a href="javascript:void(0)" class="collapseLink" onclick="collapsePanel(2);">
<img border="0" id="detailpanel_2_img_hide" src="<?php echo smarty_function_sugar_getimagepath(array('file' => "basic_search.gif"), $this);?>
"></a>
<a href="javascript:void(0)" class="expandLink" onclick="expandPanel(2);">
<img border="0" id="detailpanel_2_img_show" src="<?php echo smarty_function_sugar_getimagepath(array('file' => "advanced_search.gif"), $this);?>
"></a>
<?php echo smarty_function_sugar_translate(array('label' => 'LBL_EMPLOYEE_INFORMATION','module' => 'Users'), $this);?>

<script>
      document.getElementById('detailpanel_2').className += ' expanded';
    </script>
</h4>
<!-- PANEL CONTAINER HERE.. -->
<table id='LBL_EMPLOYEE_INFORMATION' class="panelContainer" cellspacing='<?php echo $this->_tpl_vars['gridline']; ?>
'>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed','start' => 0,'print' => false,'assign' => 'fieldsUsed'), $this);?>

<?php echo smarty_function_counter(array('name' => 'fieldsHidden','start' => 0,'print' => false,'assign' => 'fieldsHidden'), $this);?>

<?php ob_start(); ?>
<tr>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed'), $this);?>

<td width='12.5%' scope="col">
<?php if (! $this->_tpl_vars['fields']['employee_status']['hidden']): ?>
<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_EMPLOYEE_STATUS','module' => 'Users'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
<?php endif; ?>
</td>
<td class="inlineEdit" type="varchar" field="employee_status" width='37.5%'  >
<?php if (! $this->_tpl_vars['fields']['employee_status']['hidden']): ?>
<?php echo smarty_function_counter(array('name' => 'panelFieldCount'), $this);?>

<span id='employee_status_span'>
<?php echo $this->_tpl_vars['fields']['employee_status']['value']; ?>

</span>
<?php endif; ?>
<div class="inlineEditIcon"> <?php echo smarty_function_sugar_getimage(array('name' => "inline_edit_icon.svg",'attr' => 'border="0" ','alt' => ($this->_tpl_vars['alt_edit'])), $this);?>
</div>			</td>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed'), $this);?>

<td width='12.5%' scope="col">
<?php if (! $this->_tpl_vars['fields']['department']['hidden']): ?>
<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_DEPARTMENT','module' => 'Users'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
<?php endif; ?>
</td>
<td class="inlineEdit" type="varchar" field="department" width='37.5%'  >
<?php if (! $this->_tpl_vars['fields']['department']['hidden']): ?>
<?php echo smarty_function_counter(array('name' => 'panelFieldCount'), $this);?>


<?php if (strlen ( $this->_tpl_vars['fields']['department']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['department']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['department']['value']); ?>
<?php endif; ?> 
<span class="sugar_field" id="<?php echo $this->_tpl_vars['fields']['department']['name']; ?>
"><?php echo $this->_tpl_vars['fields']['department']['value']; ?>
</span>
<?php endif; ?>
<div class="inlineEditIcon"> <?php echo smarty_function_sugar_getimage(array('name' => "inline_edit_icon.svg",'attr' => 'border="0" ','alt' => ($this->_tpl_vars['alt_edit'])), $this);?>
</div>			</td>
</tr>
<?php $this->_smarty_vars['capture']['tr'] = ob_get_contents();  $this->assign('tableRow', ob_get_contents());ob_end_clean(); ?>
<?php if ($this->_tpl_vars['fieldsUsed'] > 0 && $this->_tpl_vars['fieldsUsed'] != $this->_tpl_vars['fieldsHidden']): ?>
<?php echo $this->_tpl_vars['tableRow']; ?>

<?php endif; ?>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed','start' => 0,'print' => false,'assign' => 'fieldsUsed'), $this);?>

<?php echo smarty_function_counter(array('name' => 'fieldsHidden','start' => 0,'print' => false,'assign' => 'fieldsHidden'), $this);?>

<?php ob_start(); ?>
<tr>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed'), $this);?>

<td width='12.5%' scope="col">
<?php if (! $this->_tpl_vars['fields']['reports_to_name']['hidden']): ?>
<?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_REPORTS_TO_NAME','module' => 'Users'), $this);?>
<?php $this->_smarty_vars['capture']['label'] = ob_get_contents();  $this->assign('label', ob_get_contents());ob_end_clean(); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:
<?php endif; ?>
</td>
<td class="inlineEdit" type="relate" field="reports_to_name" width='37.5%'  >
<?php if (! $this->_tpl_vars['fields']['reports_to_name']['hidden']): ?>
<?php echo smarty_function_counter(array('name' => 'panelFieldCount'), $this);?>


<span id="reports_to_id" class="sugar_field" data-id-value="<?php echo $this->_tpl_vars['fields']['reports_to_id']['value']; ?>
"><?php echo $this->_tpl_vars['fields']['reports_to_name']['value']; ?>
</span>
<?php endif; ?>
<div class="inlineEditIcon"> <?php echo smarty_function_sugar_getimage(array('name' => "inline_edit_icon.svg",'attr' => 'border="0" ','alt' => ($this->_tpl_vars['alt_edit'])), $this);?>
</div>			</td>
<?php echo smarty_function_counter(array('name' => 'fieldsUsed'), $this);?>

<td width='12.5%' scope="col">
&nbsp;
</td>
<td class="" type="" field="" width='37.5%'  >
</td>
</tr>
<?php $this->_smarty_vars['capture']['tr'] = ob_get_contents();  $this->assign('tableRow', ob_get_contents());ob_end_clean(); ?>
<?php if ($this->_tpl_vars['fieldsUsed'] > 0 && $this->_tpl_vars['fieldsUsed'] != $this->_tpl_vars['fieldsHidden']): ?>
<?php echo $this->_tpl_vars['tableRow']; ?>

<?php endif; ?>
</table>
<script type="text/javascript">SUGAR.util.doWhen("typeof initPanel == 'function'", function() { initPanel(2, 'expanded'); }); </script>
</div>
<?php if ($this->_tpl_vars['panelFieldCount'] == 0): ?>
<script>document.getElementById("LBL_EMPLOYEE_INFORMATION").style.display='none';</script>
<?php endif; ?>
</div>
</div>
<!--
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
-->
<!-- END METADATA SECTION -->
</div>
<div>
<div id="settings">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail view">
<tr>
<th colspan='4' align="left" width="100%" valign="top"><h4><slot><?php echo $this->_tpl_vars['MOD']['LBL_USER_SETTINGS']; ?>
</slot></h4></th>
</tr>
<tr>
<td scope="row"><slot><?php echo ((is_array($_tmp=$this->_tpl_vars['MOD']['LBL_RECEIVE_NOTIFICATIONS'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:</slot></td>
<td><slot><input class="checkbox" type="checkbox" disabled <?php echo $this->_tpl_vars['RECEIVE_NOTIFICATIONS']; ?>
></slot></td>
<td><slot><?php echo $this->_tpl_vars['MOD']['LBL_RECEIVE_NOTIFICATIONS_TEXT']; ?>
&nbsp;</slot></td>
</tr>
<tr>
<td scope="row" valign="top"><slot><?php echo ((is_array($_tmp=$this->_tpl_vars['MOD']['LBL_REMINDER'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:</td>
<!--
<td valign="top" nowrap><slot><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/Meetings/tpls/reminders.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></slot></td>
-->
<td valign="top" nowrap><slot><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/Reminders/tpls/remindersDefaults.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></slot></td>
<td ><slot><?php echo $this->_tpl_vars['MOD']['LBL_REMINDER_TEXT']; ?>
&nbsp;</slot></td>
</tr>
<tr>
<td valign="top" scope="row"><slot><?php echo ((is_array($_tmp=$this->_tpl_vars['MOD']['LBL_MAILMERGE'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:</slot></td>
<td valign="top" nowrap><slot><input tabindex='3' name='mailmerge_on' disabled class="checkbox" type="checkbox" <?php echo $this->_tpl_vars['MAILMERGE_ON']; ?>
></slot></td>
<td><slot><?php echo $this->_tpl_vars['MOD']['LBL_MAILMERGE_TEXT']; ?>
&nbsp;</slot></td>
</tr>
<tr>
<td valign="top" scope="row"><slot><?php echo ((is_array($_tmp=$this->_tpl_vars['MOD']['LBL_SETTINGS_URL'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:</slot></td>
<td valign="top" nowrap><slot><?php echo $this->_tpl_vars['SETTINGS_URL']; ?>
</slot></td>
<td><slot><?php echo $this->_tpl_vars['MOD']['LBL_SETTINGS_URL_DESC']; ?>
&nbsp;</slot></td>
</tr>
<tr>
<td scope="row" valign="top"><slot><?php echo ((is_array($_tmp=$this->_tpl_vars['MOD']['LBL_EXPORT_DELIMITER'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:</slot></td>
<td><slot><?php echo $this->_tpl_vars['EXPORT_DELIMITER']; ?>
</slot></td>
<td><slot><?php echo $this->_tpl_vars['MOD']['LBL_EXPORT_DELIMITER_DESC']; ?>
</slot></td>
</tr>
<tr>
<td scope="row" valign="top"><slot><?php echo ((is_array($_tmp=$this->_tpl_vars['MOD']['LBL_EXPORT_CHARSET'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:</slot></td>
<td><slot><?php echo $this->_tpl_vars['EXPORT_CHARSET_DISPLAY']; ?>
</slot></td>
<td><slot><?php echo $this->_tpl_vars['MOD']['LBL_EXPORT_CHARSET_DESC']; ?>
</slot></td>
</tr>
<tr>
<td scope="row" valign="top"><slot><?php echo ((is_array($_tmp=$this->_tpl_vars['MOD']['LBL_USE_REAL_NAMES'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:</slot></td>
<td><slot><input tabindex='3' name='use_real_names' disabled class="checkbox" type="checkbox" <?php echo $this->_tpl_vars['USE_REAL_NAMES']; ?>
></slot></td>
<td><slot><?php echo $this->_tpl_vars['MOD']['LBL_USE_REAL_NAMES_DESC']; ?>
</slot></td>
</tr>
<?php if ($this->_tpl_vars['DISPLAY_EXTERNAL_AUTH']): ?>
<tr>
<td scope="row" valign="top"><slot><?php echo ((is_array($_tmp=$this->_tpl_vars['EXTERNAL_AUTH_CLASS'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:</slot></td>
<td valign="top" nowrap><slot><input id="external_auth_only" name="external_auth_only" type="checkbox" class="checkbox" <?php echo $this->_tpl_vars['EXTERNAL_AUTH_ONLY_CHECKED']; ?>
></slot></td>
<td><slot><?php echo $this->_tpl_vars['MOD']['LBL_EXTERNAL_AUTH_ONLY']; ?>
 <?php echo $this->_tpl_vars['EXTERNAL_AUTH_CLASS']; ?>
</slot></td>
</tr>
<?php endif; ?>
</table>
</div>
<div id='locale'>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail view">
<tr>
<th colspan='4' align="left" width="100%" valign="top">
<h4><slot><?php echo $this->_tpl_vars['MOD']['LBL_USER_LOCALE']; ?>
</slot></h4></th>
</tr>
<tr>
<td width="15%" scope="row"><slot><?php echo ((is_array($_tmp=$this->_tpl_vars['MOD']['LBL_DATE_FORMAT'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:</slot></td>
<td><slot><?php echo $this->_tpl_vars['DATEFORMAT']; ?>
&nbsp;</slot></td>
<td><slot><?php echo $this->_tpl_vars['MOD']['LBL_DATE_FORMAT_TEXT']; ?>
&nbsp;</slot></td>
</tr>
<tr>
<td width="15%" scope="row"><slot><?php echo ((is_array($_tmp=$this->_tpl_vars['MOD']['LBL_TIME_FORMAT'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:</slot></td>
<td><slot><?php echo $this->_tpl_vars['TIMEFORMAT']; ?>
&nbsp;</slot></td>
<td><slot><?php echo $this->_tpl_vars['MOD']['LBL_TIME_FORMAT_TEXT']; ?>
&nbsp;</slot></td>
</tr>
<tr>
<td width="15%" scope="row"><slot><?php echo ((is_array($_tmp=$this->_tpl_vars['MOD']['LBL_TIMEZONE'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:</slot></td>
<td nowrap><slot><?php echo $this->_tpl_vars['TIMEZONE']; ?>
&nbsp;</slot></td>
<td><slot><?php echo $this->_tpl_vars['MOD']['LBL_ZONE_TEXT']; ?>
&nbsp;</slot></td>
</tr>
<tr>
<td width="15%" scope="row"><slot><?php echo ((is_array($_tmp=$this->_tpl_vars['MOD']['LBL_CURRENCY'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:</slot></td>
<td><slot><?php echo $this->_tpl_vars['CURRENCY_DISPLAY']; ?>
&nbsp;</slot></td>
<td><slot><?php echo $this->_tpl_vars['MOD']['LBL_CURRENCY_TEXT']; ?>
&nbsp;</slot></td>
</tr>
<tr>
<td width="15%" scope="row"><slot><?php echo ((is_array($_tmp=$this->_tpl_vars['MOD']['LBL_CURRENCY_SIG_DIGITS'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:</slot></td>
<td><slot><?php echo $this->_tpl_vars['CURRENCY_SIG_DIGITS']; ?>
&nbsp;</slot></td>
<td><slot><?php echo $this->_tpl_vars['MOD']['LBL_CURRENCY_SIG_DIGITS_DESC']; ?>
&nbsp;</slot></td>
</tr>
<tr>
<td width="15%" scope="row"><slot><?php echo ((is_array($_tmp=$this->_tpl_vars['MOD']['LBL_NUMBER_GROUPING_SEP'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:</slot></td>
<td><slot><?php echo $this->_tpl_vars['NUM_GRP_SEP']; ?>
&nbsp;</slot></td>
<td><slot><?php echo $this->_tpl_vars['MOD']['LBL_NUMBER_GROUPING_SEP_TEXT']; ?>
&nbsp;</slot></td>
</tr><tr>
<td width="15%" scope="row"><slot><?php echo ((is_array($_tmp=$this->_tpl_vars['MOD']['LBL_DECIMAL_SEP'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:</slot></td>
<td><slot><?php echo $this->_tpl_vars['DEC_SEP']; ?>
&nbsp;</slot></td>
<td><slot></slot><?php echo $this->_tpl_vars['MOD']['LBL_DECIMAL_SEP_TEXT']; ?>
&nbsp;</td>
</tr>
</tr><tr>
<td width="15%" scope="row"><slot><?php echo ((is_array($_tmp=$this->_tpl_vars['MOD']['LBL_LOCALE_DEFAULT_NAME_FORMAT'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:</slot></td>
<td><slot><?php echo $this->_tpl_vars['NAME_FORMAT']; ?>
&nbsp;</slot></td>
<td><slot></slot><?php echo $this->_tpl_vars['MOD']['LBL_LOCALE_NAME_FORMAT_DESC']; ?>
&nbsp;</td>
</tr>
</table>
</div>
<div id='calendar_options'>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail view">
<tr>
<th colspan='4' align="left" width="100%" valign="top"><h4><slot><?php echo $this->_tpl_vars['MOD']['LBL_CALENDAR_OPTIONS']; ?>
</slot></h4></th>
</tr>
<tr>
<td width="15%" scope="row"><slot><?php echo ((is_array($_tmp=$this->_tpl_vars['MOD']['LBL_PUBLISH_KEY'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:</slot></td>
<td width="20%"><slot><?php echo $this->_tpl_vars['CALENDAR_PUBLISH_KEY']; ?>
&nbsp;</slot></td>
<td width="65%"><slot><?php echo $this->_tpl_vars['MOD']['LBL_CHOOSE_A_KEY']; ?>
&nbsp;</slot></td>
</tr>
<tr>
<td width="15%" scope="row"><slot><nobr><?php echo ((is_array($_tmp=$this->_tpl_vars['MOD']['LBL_YOUR_PUBLISH_URL'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:</nobr></slot></td>
<td colspan=2><?php if ($this->_tpl_vars['CALENDAR_PUBLISH_KEY']): ?><?php echo $this->_tpl_vars['CALENDAR_PUBLISH_URL']; ?>
<?php else: ?><?php echo $this->_tpl_vars['MOD']['LBL_NO_KEY']; ?>
<?php endif; ?></td>
</tr>
<tr>
<td width="15%" scope="row"><slot><?php echo ((is_array($_tmp=$this->_tpl_vars['MOD']['LBL_SEARCH_URL'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:</slot></td>
<td colspan=2><slot><?php if ($this->_tpl_vars['CALENDAR_PUBLISH_KEY']): ?><?php echo $this->_tpl_vars['CALENDAR_SEARCH_URL']; ?>
<?php else: ?><?php echo $this->_tpl_vars['MOD']['LBL_NO_KEY']; ?>
<?php endif; ?></slot></td>
</tr>
<tr>
<td width="15%" scope="row"><slot><?php echo ((is_array($_tmp=$this->_tpl_vars['MOD']['LBL_ICAL_PUB_URL'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
: <?php echo smarty_function_sugar_help(array('text' => $this->_tpl_vars['MOD']['LBL_ICAL_PUB_URL_HELP']), $this);?>
</slot></td>
<td colspan=2><slot><?php if ($this->_tpl_vars['CALENDAR_PUBLISH_KEY']): ?><?php echo $this->_tpl_vars['CALENDAR_ICAL_URL']; ?>
<?php else: ?><?php echo $this->_tpl_vars['MOD']['LBL_NO_KEY']; ?>
<?php endif; ?></slot></td>
</tr>
<tr>
<td width="15%" scope="row"><slot><?php echo ((is_array($_tmp=$this->_tpl_vars['MOD']['LBL_FDOW'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:</slot></td>
<td><slot><?php echo $this->_tpl_vars['FDOWDISPLAY']; ?>
&nbsp;</slot></td>
<td><slot></slot><?php echo $this->_tpl_vars['MOD']['LBL_FDOW_TEXT']; ?>
&nbsp;</td>
</tr>
</table>
</div>
<div id='edit_tabs'>
<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="detail view">
<tr>
<th colspan='4' align="left" width="100%" valign="top"><h4><slot><?php echo $this->_tpl_vars['MOD']['LBL_LAYOUT_OPTIONS']; ?>
</slot></h4></th>
</tr>
<tr>
<td width="15%" scope="row"><slot><?php echo ((is_array($_tmp=$this->_tpl_vars['MOD']['LBL_USE_GROUP_TABS'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:</slot></td>
<td><slot><input class="checkbox" type="checkbox" disabled <?php echo $this->_tpl_vars['USE_GROUP_TABS']; ?>
></slot></td>
<td><slot><?php echo $this->_tpl_vars['MOD']['LBL_NAVIGATION_PARADIGM_DESCRIPTION']; ?>
&nbsp;</slot></td>
</tr>
<tr>
<td width="15%" scope="row"><slot><?php echo ((is_array($_tmp=$this->_tpl_vars['MOD']['LBL_SUBPANEL_TABS'])) ? $this->_run_mod_handler('strip_semicolon', true, $_tmp) : smarty_modifier_strip_semicolon($_tmp)); ?>
:</slot></td>
<td><slot><input class="checkbox" type="checkbox" disabled <?php echo $this->_tpl_vars['SUBPANEL_TABS']; ?>
></slot></td>
<td><slot><?php echo $this->_tpl_vars['MOD']['LBL_SUBPANEL_TABS_DESCRIPTION']; ?>
&nbsp;</slot></td>
</tr>
</table>
</div>
</div>
<?php if ($this->_tpl_vars['SHOW_ROLES']): ?>

<?php else: ?>
</div>
<?php endif; ?><script type="text/javascript" src="include/InlineEditing/inlineEditing.js"></script>
<script type="text/javascript" src="modules/Favorites/favorites.js"></script>