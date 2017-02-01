<?php /* Smarty version 2.6.29, created on 2017-01-30 03:03:23
         compiled from custom/modules/te_student/tpls/batchtransfer.tpl */ ?>
<section class="moduleTitle"> <h2>Student Batch Transfer</h2><br/><br/>
<form name="search_form" id="search_form" class="search_form" method="post" action="index.php?module=te_student&action=batchtransfer">
<div id="te_budgeted_campaignbasic_searchSearchForm" style="" class="edit view search basic">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
		<tr>      
			<td scope="row" nowrap="nowrap" width="1%">		
				<label for="email_basic">Email</label>
			</td>
			<td nowrap="nowrap" width="10%">			
				<input type="text" name="email" id="email" value="<?php echo $this->_tpl_vars['selected_email']; ?>
">
			</td>	
			<td scope="row" nowrap="nowrap" width="1%">		
				<label for="phone_basic">phone</label>
			</td>	
			<td nowrap="nowrap" width="10%">			
				<input type="text" name="phone" id="phone" value="<?php echo $this->_tpl_vars['phone']; ?>
">
			</td>				
			
			<td class="sumbitButtons">
				<input tabindex="2" title="Search" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="button" value="Search" id="search_form_submit">&nbsp;
				<input tabindex="2" title="Clear" onclick="SUGAR.searchForm.clear_form(this.form); return false;" class="button" type="button" name="clear" id="search_form_clear" value="Clear">
	        </td>
			<td nowrap="nowrap" width="10%">&nbsp;</td>
			<td class="helpIcon" width="*"><img alt="Help" border="0" id="filterHelp" src="themes/SuiteR/images/help-dashlet.png?v=mjry3sKU3KG11ojfGn-sdg"></td>
		</tr>
		</tbody>
	</table>
</div>
</form>
<table cellpadding="0" cellspacing="0" width="100%" border="0" class="list view table footable-loaded footable default">
	<thead>    	
	<tr height="20">
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">	
			<strong>Name</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>Email</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>Phone</strong>
		</th>
	</tr>
	<?php $_from = $this->_tpl_vars['studentList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['student']):
?>
		<tr height="20" class="oddListRowS1">
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">
				<a href="index.php?module=te_student&return_module=te_student&action=DetailView&record=<?php echo $this->_tpl_vars['student']['id']; ?>
" target="_blank"> <?php echo $this->_tpl_vars['student']['name']; ?>

				</a>
			</td>
		  	<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">
			<?php echo $this->_tpl_vars['student']['email']; ?>

		   </td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">
			<?php echo $this->_tpl_vars['student']['mobile']; ?>

		   </td>
		</tr>				
	<?php endforeach; endif; unset($_from); ?>
</table>
<section> <br/><h4>Student Batch List</h4><br/>
<table cellpadding="0" cellspacing="0" width="100%" border="0" class="list view table footable-loaded footable default">
	<thead>    	
	<tr height="20">
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">	
			<strong>Current Batch</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">	
			<strong>Start Date</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>Programs</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>Transfer Batch</strong>
		</th>		
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>Action</strong>
		</th>	
	</tr>
	</thead>
	<?php $this->assign('rowcount', 1); ?>
	<?php $_from = $this->_tpl_vars['studentBatchList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['studentBatch']):
?>		
		<tr height="20" class="oddListRowS1">
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">
				 <?php echo $this->_tpl_vars['studentBatch']['name']; ?>

				 <input type="hidden" id="old_batch<?php echo $this->_tpl_vars['rowcount']; ?>
" value="<?php echo $this->_tpl_vars['studentBatch']['id']; ?>
">
				 <input type="student_country" id="student_country<?php echo $this->_tpl_vars['rowcount']; ?>
" value="<?php echo $this->_tpl_vars['student']['country']; ?>
">
			</td>
		  	<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">
			<?php echo $this->_tpl_vars['studentBatch']['batch_start_date']; ?>

		   </td>			
		   <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">
				<select name="transfer_to_program" id="transfer_to_program<?php echo $this->_tpl_vars['rowcount']; ?>
" onchange="getBatchOption(<?php echo $this->_tpl_vars['rowcount']; ?>
);">
					<option value="">--Select Program--</option>
					<?php $_from = $this->_tpl_vars['studentBatch']['transferProgramList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key1'] => $this->_tpl_vars['transferProgram']):
?>
						<option value="<?php echo $this->_tpl_vars['transferProgram']['id']; ?>
"><?php echo $this->_tpl_vars['transferProgram']['name']; ?>
</option>
					<?php endforeach; endif; unset($_from); ?>
				</select>
		   </td>
		   <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">
				<select name="transfer_to_batch"id="transfer_to_batch<?php echo $this->_tpl_vars['rowcount']; ?>
">
					<option value="">--Select Batch--</option>
					<?php $_from = $this->_tpl_vars['studentBatch']['transferBatchList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key1'] => $this->_tpl_vars['transferBatch']):
?>
						<option value="<?php echo $this->_tpl_vars['transferBatch']['id']; ?>
"><?php echo $this->_tpl_vars['transferBatch']['name']; ?>
</option>
					<?php endforeach; endif; unset($_from); ?>
				</select>
		   </td>
		   <td align="left" valign="top" type="relate" id="transfer_batch_button<?php echo $this->_tpl_vars['rowcount']; ?>
">
				<input tabindex="2" title="Batch Transfer" class="button" type="button" name="button" value="Transfer Batch" id="batch_transfer_form_submit" onclick="transferStudentBatch('<?php echo $this->_tpl_vars['student']['id']; ?>
',<?php echo $this->_tpl_vars['rowcount']; ?>
);">
				<span id="batch_transfer<?php echo $this->_tpl_vars['rowcount']; ?>
"></span>
		   </td>
		</tr>	
		<?php $this->assign('rowcount', $this->_tpl_vars['rowcount']+1); ?>
	<?php endforeach; endif; unset($_from); ?>
</table>
<?php echo '
<script>
function getBatchOption(rowcount){
	var programId= $("#transfer_to_program"+rowcount).val();
	if(programId!=\'\'){
		$.ajax({url: "index.php?entryPoint=getbatch&programId="+programId, success: function(result){
			var result = JSON.parse(result);
			if(result.status==\'ok\'){
				var batch=\'<option value=""></option>\';
				 for(var i=0;i<result.res.length;i++){
						var id = result.res[i].id;
						var name = result.res[i].name;
						batch+=\'<option value="\'+id+\'">\'+name+\'</option>\'
				 }
				 $("#transfer_to_batch"+rowcount).html(batch);
			}
		}});
	}
	
}

function transferStudentBatch(student_id,rowcount){
	var span_id="batch_transfer"+rowcount;
	var old_batch= $("#old_batch"+rowcount).val();
	var new_batch= $("#transfer_to_batch"+rowcount).val();
	var student_country= $("#student_country"+rowcount).val();
	if(new_batch!=""){
		$("#"+span_id).html(\'<img id="previewimage" src="custom/themes/default/images/spin.gif" width="32" height="32"/>\');	
		jQuery.ajax({
		type: "POST",
		url: \'index.php?entryPoint=transferbatch\',
		data: {student_id: student_id,old_batch: old_batch,new_batch: new_batch,student_country:student_country},
		success: function (result)
		{
			var result = JSON.parse(result);			
			$("#transfer_batch_button"+rowcount).html(result.status);
			if(result.status==\'Transferred\'){
				 $("#transfer_batch_button"+rowcount).html(result.status);
			}
		}
		}); 
	}	 
}
</script>
'; ?>
