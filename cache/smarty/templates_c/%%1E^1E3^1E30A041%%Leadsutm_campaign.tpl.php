<?php /* Smarty version 2.6.29, created on 2017-02-01 07:21:14
         compiled from cache/modules/Import/Leadsutm_campaign.tpl */ ?>

<?php if (strlen ( $this->_tpl_vars['fields']['utm_campaign']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['utm_campaign']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['utm_campaign']['value']); ?>
<?php endif; ?>  
<input type='text' name='<?php echo $this->_tpl_vars['fields']['utm_campaign']['name']; ?>
' 
    id='<?php echo $this->_tpl_vars['fields']['utm_campaign']['name']; ?>
' size='30' 
    maxlength='50' 
    value='<?php echo $this->_tpl_vars['value']; ?>
' title=''  tabindex='1'      >