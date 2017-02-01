<?php /* Smarty version 2.6.29, created on 2017-02-01 07:21:15
         compiled from cache/modules/Import/Leadsneoxstatus.tpl */ ?>

<?php if (strlen ( $this->_tpl_vars['fields']['neoxstatus']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['neoxstatus']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['neoxstatus']['value']); ?>
<?php endif; ?>  
<input type='text' name='<?php echo $this->_tpl_vars['fields']['neoxstatus']['name']; ?>
' 
    id='<?php echo $this->_tpl_vars['fields']['neoxstatus']['name']; ?>
' size='30' 
     
    value='<?php echo $this->_tpl_vars['value']; ?>
' title=''  tabindex='1'      >