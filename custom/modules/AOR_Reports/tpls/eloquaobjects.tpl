<section class="moduleTitle"> <h2>Eloqua Objects</h2><br/><br/>
     {sugar_getscript file="custom/modules/AOR_Reports/include/js/jquery_dataTable.js"}

  



<table cellpadding="0"  id="batchwisereferalsX" cellspacing="0" style="width:99%" border="0" class="table-bordered table-striped fx-layout display nowrap dataTable dtr-inline list view table footable-loaded footable default">
	<thead>
	<tr height="20">

		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>ID</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Name</strong>
		</th>
 
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Email Address</strong>
		</th>
		
        

	</tr>
        </thead>
        <tbody>
	{foreach from = $leadListx key=key item=val}
		<tr height="20" class="oddListRowS1">
			   <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$val.id}</td>
                    <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$val.name}</td>
                    <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$val.emailAddress}</td>
		</tr>
	{/foreach}
        </tbody>
</table>
