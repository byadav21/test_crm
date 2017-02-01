<?php /* Smarty version 2.6.29, created on 2017-02-01 07:21:14
         compiled from cache/modules/Import/Leadsvendor.tpl */ ?>

<?php if (strlen ( $this->_tpl_vars['fields']['vendor']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['vendor']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['vendor']['value']); ?>
<?php endif; ?>  
<input type='text' name='<?php echo $this->_tpl_vars['fields']['vendor']['name']; ?>
' 
    id='<?php echo $this->_tpl_vars['fields']['vendor']['name']; ?>
' size='30' 
    maxlength='50' 
    value='<?php echo $this->_tpl_vars['value']; ?>
' title=''  tabindex='1'      >