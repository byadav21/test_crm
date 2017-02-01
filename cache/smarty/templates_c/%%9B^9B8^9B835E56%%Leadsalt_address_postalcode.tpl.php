<?php /* Smarty version 2.6.29, created on 2017-02-01 07:21:11
         compiled from cache/modules/Import/Leadsalt_address_postalcode.tpl */ ?>

<?php if (strlen ( $this->_tpl_vars['fields']['alt_address_postalcode']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['alt_address_postalcode']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['alt_address_postalcode']['value']); ?>
<?php endif; ?>  
<input type='text' name='<?php echo $this->_tpl_vars['fields']['alt_address_postalcode']['name']; ?>
' 
    id='<?php echo $this->_tpl_vars['fields']['alt_address_postalcode']['name']; ?>
' size='30' 
    maxlength='20' 
    value='<?php echo $this->_tpl_vars['value']; ?>
' title=''  tabindex='1'      >