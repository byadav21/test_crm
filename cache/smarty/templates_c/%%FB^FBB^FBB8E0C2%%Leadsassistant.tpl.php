<?php /* Smarty version 2.6.29, created on 2017-02-01 07:21:12
         compiled from cache/modules/Import/Leadsassistant.tpl */ ?>

<?php if (strlen ( $this->_tpl_vars['fields']['assistant']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['assistant']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['assistant']['value']); ?>
<?php endif; ?>  
<input type='text' name='<?php echo $this->_tpl_vars['fields']['assistant']['name']; ?>
' 
    id='<?php echo $this->_tpl_vars['fields']['assistant']['name']; ?>
' size='30' 
    maxlength='75' 
    value='<?php echo $this->_tpl_vars['value']; ?>
' title=''  tabindex='1'      >