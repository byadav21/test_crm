<?php /* Smarty version 2.6.29, created on 2017-02-01 07:21:11
         compiled from cache/modules/Import/Leadsalt_address_state.tpl */ ?>

<?php if (strlen ( $this->_tpl_vars['fields']['alt_address_state']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['alt_address_state']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['alt_address_state']['value']); ?>
<?php endif; ?>  
<input type='text' name='<?php echo $this->_tpl_vars['fields']['alt_address_state']['name']; ?>
' 
    id='<?php echo $this->_tpl_vars['fields']['alt_address_state']['name']; ?>
' size='30' 
    maxlength='100' 
    value='<?php echo $this->_tpl_vars['value']; ?>
' title=''  tabindex='1'      >