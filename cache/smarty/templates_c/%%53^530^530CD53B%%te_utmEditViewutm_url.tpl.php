<?php /* Smarty version 2.6.29, created on 2017-02-03 04:28:19
         compiled from cache/include/InlineEditing/te_utmEditViewutm_url.tpl */ ?>

<?php if (strlen ( $this->_tpl_vars['fields']['utm_url']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['utm_url']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['utm_url']['value']); ?>
<?php endif; ?>  
<input type='text' name='<?php echo $this->_tpl_vars['fields']['utm_url']['name']; ?>
' 
    id='<?php echo $this->_tpl_vars['fields']['utm_url']['name']; ?>
' size='30' 
     
    value='<?php echo $this->_tpl_vars['value']; ?>
' title=''  tabindex='1'      >