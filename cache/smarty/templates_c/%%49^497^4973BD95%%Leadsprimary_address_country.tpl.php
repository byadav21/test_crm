<?php /* Smarty version 2.6.29, created on 2017-02-01 07:21:10
         compiled from cache/modules/Import/Leadsprimary_address_country.tpl */ ?>

<?php if (strlen ( $this->_tpl_vars['fields']['primary_address_country']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['primary_address_country']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['primary_address_country']['value']); ?>
<?php endif; ?>  
<input type='text' name='<?php echo $this->_tpl_vars['fields']['primary_address_country']['name']; ?>
' 
    id='<?php echo $this->_tpl_vars['fields']['primary_address_country']['name']; ?>
' size='30' 
     
    value='<?php echo $this->_tpl_vars['value']; ?>
' title=''  tabindex='1'      >