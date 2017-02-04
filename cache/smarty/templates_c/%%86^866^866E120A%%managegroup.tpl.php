<?php /* Smarty version 2.6.29, created on 2017-02-03 05:08:00
         compiled from custom/modules/te_lead_assignment_rule/tpls/managegroup.tpl */ ?>
<section class="moduleTitle"> <h2>Security Groups</h2><br/><br/>

<table cellpadding="0" cellspacing="0" width="100%" border="0" class="list view table footable-loaded footable default">
	<thead>    	
	<tr height="20">
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">	
			<strong>Name</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">	
			<strong>Assigned To</strong>
		</th>
		
	</tr>
	<?php $_from = $this->_tpl_vars['groupDataList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['data']):
?>
	<tr height="20" class="oddListRowS1">
		<td align="left" valign="top" type="relate" field="vendor" class="inlineEdit footable-visible footable-last-column"><a href="index.php?module=te_lead_assignment_rule&action=updategroup&record=<?php echo $this->_tpl_vars['data']['id']; ?>
"><?php echo $this->_tpl_vars['data']['name']; ?>
</a></td>
		<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column"><a href=""><?php echo $this->_tpl_vars['data']['first_name']; ?>
&nbsp;<?php echo $this->_tpl_vars['data']['last_name']; ?>
</a></td>	
		
	</tr>				
	<?php endforeach; endif; unset($_from); ?>
</table>