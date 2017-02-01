<?php /* Smarty version 2.6.29, created on 2017-02-01 07:21:13
         compiled from cache/modules/Import/Leadsamount.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sugar_number_format', 'cache/modules/Import/Leadsamount.tpl', 10, false),)), $this); ?>

<?php if (strlen ( $this->_tpl_vars['fields']['amount']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['amount']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['amount']['value']); ?>
<?php endif; ?>  
<input type='text' name='<?php echo $this->_tpl_vars['fields']['amount']['name']; ?>
'
id='<?php echo $this->_tpl_vars['fields']['amount']['name']; ?>
'
size='30'
maxlength='18'value='<?php echo smarty_function_sugar_number_format(array('var' => $this->_tpl_vars['value'],'precision' => 2), $this);?>
'
title=''
tabindex='1'
 
>