<?php /* Smarty version 2.6.29, created on 2017-02-01 07:21:14
         compiled from cache/modules/Import/Leadsutm.tpl */ ?>

<?php if (strlen ( $this->_tpl_vars['fields']['utm']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['utm']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['utm']['value']); ?>
<?php endif; ?>  
<input type='text' name='<?php echo $this->_tpl_vars['fields']['utm']['name']; ?>
' 
    id='<?php echo $this->_tpl_vars['fields']['utm']['name']; ?>
' size='30' 
    maxlength='50' 
    value='<?php echo $this->_tpl_vars['value']; ?>
' title=''  tabindex='1'      >