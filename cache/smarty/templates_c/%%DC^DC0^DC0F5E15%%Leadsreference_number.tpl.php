<?php /* Smarty version 2.6.29, created on 2017-02-01 07:21:13
         compiled from cache/modules/Import/Leadsreference_number.tpl */ ?>

<?php if (strlen ( $this->_tpl_vars['fields']['reference_number']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['reference_number']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['reference_number']['value']); ?>
<?php endif; ?>  
<input type='text' name='<?php echo $this->_tpl_vars['fields']['reference_number']['name']; ?>
' 
    id='<?php echo $this->_tpl_vars['fields']['reference_number']['name']; ?>
' size='30' 
    maxlength='100' 
    value='<?php echo $this->_tpl_vars['value']; ?>
' title=''  tabindex='1'      >