<?php /* Smarty version 2.6.29, created on 2017-02-01 07:21:11
         compiled from cache/modules/Import/Leadsopportunity_amount.tpl */ ?>

<?php if (strlen ( $this->_tpl_vars['fields']['opportunity_amount']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['opportunity_amount']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['opportunity_amount']['value']); ?>
<?php endif; ?>  
<input type='text' name='<?php echo $this->_tpl_vars['fields']['opportunity_amount']['name']; ?>
' 
    id='<?php echo $this->_tpl_vars['fields']['opportunity_amount']['name']; ?>
' size='30' 
    maxlength='50' 
    value='<?php echo $this->_tpl_vars['value']; ?>
' title=''  tabindex='1'      >