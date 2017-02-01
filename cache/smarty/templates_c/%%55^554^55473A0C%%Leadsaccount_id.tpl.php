<?php /* Smarty version 2.6.29, created on 2017-02-01 07:21:12
         compiled from cache/modules/Import/Leadsaccount_id.tpl */ ?>

<?php if (strlen ( $this->_tpl_vars['fields']['account_id']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['account_id']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['account_id']['value']); ?>
<?php endif; ?>  
<input type='text' name='<?php echo $this->_tpl_vars['fields']['account_id']['name']; ?>
' 
    id='<?php echo $this->_tpl_vars['fields']['account_id']['name']; ?>
' size='30' 
     
    value='<?php echo $this->_tpl_vars['value']; ?>
' title=''  tabindex='1'      >