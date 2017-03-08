<?php /* Smarty version 2.6.29, created on 2017-03-08 02:46:50
         compiled from cache/include/InlineEditing/te_student_batchEditViewfeepaid.tpl */ ?>

<?php if (strlen ( $this->_tpl_vars['fields']['feepaid']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['feepaid']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['feepaid']['value']); ?>
<?php endif; ?>  
<input type='text' name='<?php echo $this->_tpl_vars['fields']['feepaid']['name']; ?>
' 
    id='<?php echo $this->_tpl_vars['fields']['feepaid']['name']; ?>
' size='30' 
     
    value='<?php echo $this->_tpl_vars['value']; ?>
' title=''  tabindex='1'      >