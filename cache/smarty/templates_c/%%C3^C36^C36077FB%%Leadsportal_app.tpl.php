<?php /* Smarty version 2.6.29, created on 2017-02-01 07:21:12
         compiled from cache/modules/Import/Leadsportal_app.tpl */ ?>

<?php if (strlen ( $this->_tpl_vars['fields']['portal_app']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['portal_app']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['portal_app']['value']); ?>
<?php endif; ?>  
<input type='text' name='<?php echo $this->_tpl_vars['fields']['portal_app']['name']; ?>
' 
    id='<?php echo $this->_tpl_vars['fields']['portal_app']['name']; ?>
' size='30' 
    maxlength='255' 
    value='<?php echo $this->_tpl_vars['value']; ?>
' title=''  tabindex='1'      >