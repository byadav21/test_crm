{*
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/

*}
 

    <script type="text/javascript" src="{sugar_getjspath file='include/SubPanel/SubPanelTiles.js'}"></script>
    <script>
        {literal}
    if(document.DetailView != null &&
        document.DetailView.elements != null &&
        document.DetailView.elements.layout_def_key != null &&
        typeof document.DetailView.elements['layout_def_key'] != 'undefined'){
            document.DetailView.elements['layout_def_key'].value = '{/literal}{$layout_def_key}{literal}';
    }
        {/literal}
    </script>  
    
{literal}    
 <style> .rowpadd{ padding-bottom: 19px;    padding: 0 77px 23px 23px;} .firstrowdel{font-size: 18px; display: inline; margin-right: 25px; cursor:pointer}   .exdetail h3{font-weight: bold; font-size: 16px; text-align: center;} .uploadedimg{padding: 5px 0;    border-bottom: 1px dotted #000000; margin-bottom: 0px; display: block; overflow: hidden;}.dompar {margin-bottom: 5px;display: block; overflow: hidden; clear: both; }.maincontainer input[type=text], .maincontainer select { width: 100%!important; }  .headpaym{overflow: hidden; display: block; margin-bottom: 22px; border-bottom: 1px dotted silver; padding-bottom: 18px;}    .errdiv{color:red;display:none} .paymdiv{line-height: 32px;border-bottom: 1px dotted silver; padding-bottom: 8px; margin-top: 12px;}</style>
 {/literal}
 
{{include file=$headerTpl}}
{sugar_include include=$includes}
 
 
 <ul class="nav nav-tabs" style="margin-top:15px">
  <li class="active"><a href="#1a" data-toggle="tab" href="#">PO Detail</a></li>
 
  {if $status==2 && $overview->expense_type=='PO'}
    {if $isfacility>0}
		<li><a href="#2a" data-toggle="tab" href="#">Add PO</a></li>
	{/if}	
	
	<li><a href="#3a" data-toggle="tab" href="#">Payment</a></li>

  {/if}
</ul>
 
 
<div class="tab-content clearfix">
	<div id="1a" class="tab-pane active">
		<div  class="row overview">
			<div class="col-sm-6 rowpadd">
			
					<b class="name">Name : {$overview->name}</b>
					 
						 
						 <p>Date: {$overview->dated} </p>
						 {if $overview->expense_type=='PR'}
							<p>Invoice No: {$overview->inv_num} </p>
						 {/if}
								
					 
						 
						<b> <p>Amount : <i class="fa fa-inr" aria-hidden="true"></i> {$overview->amount} </p> </b>
						 
						   
			
			</div>
		  
			<div class="col-sm-6 rowpadd">
					{if $overview->expense_type=='PO'}
								<label>Status</label>: 
								{if $overview->status eq 0  }
										<p style="color:red;font-weight:bold;display:inline">Rejected</p> 
										 
								 {elseif $overview->status eq 1}
										<p style="color:orange;font-weight:bold;display:inline">Open</p> 
								 {elseif $overview->status eq 2}
										<p style="color:limegreen;font-weight:bold;display:inline">Approved</p>
								 
								 {elseif $overview->status eq 3}
										<p style="color:red;font-weight:bold;display:inline">Cancelled</p>
								 
								   {/if}
								
								  <p> <label>Po Required  </label>: {$overview->porequired}</p>
								  
					{/if}			  
								  <p>Ref# {$overview->refrenceid} </p>
								  <p>Submitter: {$overview->assigned_user_name} </p>
								  
			</div>
		

		</div>

		<div class="row overview exdetail">
		<h3>Expense Detail</h3>
			<div class="col-sm-6 rowpadd"  >
						
				
				{if count($items)>0}	
					<h2> Expenses</h2>
					{foreach from=$items key=id item=val}
						<div class="col-sm-12 " style="line-height: 32px;">
							<div class="col-sm-4 ">
							  {$val.proname}
							</div>
                                                        <div class="col-sm-2 ">
							  {$val.description}
							</div>
							<div class="col-sm-2 ">
							  {$val.unit} 							</div>
							<div class="col-sm-3 ">
							  <i class="fa fa-inr" aria-hidden="true"></i> {$val.rate}
							</div>
							<div class="col-sm-3 text-right ">
							   <i class="fa fa-inr" aria-hidden="true"></i> {$val.amt}
							</div>
						</div>
					{/foreach}
				{/if}
					
				{if count($taxesarr)>0}	
					<h2> Taxes</h2>	
					{foreach from=$taxesarr key=id item=val}
						<div class="col-sm-12 " style="line-height: 32px;">
							<div class="col-sm-6 ">
							  {$val.name}
							</div>
							<div class="col-sm-6 text-right">
							   <i class="fa fa-inr" aria-hidden="true"></i> {$val.amt}
							</div>
						</div>
					{/foreach}
				{/if}
				<div class="col-sm-12 " style="line-height: 32px;border-top: 1px solid silver">
							<div class="col-sm-6 text-right">
							  <b>Total</b>
							</div>
							<div class="col-sm-6 text-right">
							   <b><i class="fa fa-inr" aria-hidden="true"></i> {$overview->amount}</b>
							</div>		
				</div>

			</div>
			<div class="col-sm-6 rowpadd">

				<h2> Documents</h2>		
				{if count($docuarray)>0}	
					<div style="clear:both" class="apendnewdocs ">

					{foreach from=$docuarray key=id item=val}
					  <div class="uploadedimg" style="line-height: 32px;">
					  
					  <div class="col-sm-12"><a tarhet="new" href="index.php?module=te_ExpensePO&action=download&id={$id}&records={$overview->id}&type=attch"> <img src="custom/themes/SuiteR/css/uploader/not_available-generic.png" style="width:25px;height:25px"> {$val->nameOrg} </a></div>
					  </div>
					{/foreach}

					</div>	
				{/if}

			
			</div>
		  <div class="col-xs-12 text-center">
						{if $overview->status=='-1' || $overview->status=='3'}	
							<p> Reason: {$overview->reason_rejection}</p>
						{/if}	
							   

						  {if $roleStatus == 1 }	
								<b style="color:green">Approved by you</b>
						  {elseif $roleStatus == -1 || $roleStatus == 3}	
						 	<!--<p> Reason: {$overview->reason_rejection}</p>-->
							   
						  {elseif  $roleStatus == 0}
									<button class="button approveme">Approve</button>
									<button class="button rejectme">Reject</button>
						  {elseif  $roleStatus == -2 && $overview->status!='2' && $overview->status!='3' }
									<button class="button cancelme">Cancel</button>								
						  {/if}
						  
						  {if $podownloader==2  and $overview->porequired=='yes' and $overview->podocument!=''}
								{if count($podocs)==1}
								  <a href="index.php?module=te_ExpensePO&action=download&id=0&records={$overview->id}"><button class="button">DOWNLOAD PO </button></a>
								  {else}
								     <h2 style="color: #3562a6;font-weight: bold;" class="text-left">DOWNLOAD PO </h2>
								  {foreach from=$podocs key=id item=val}
										<div class="uploadedimg text-left" style="line-height: 32px;"><div class="col-sm-6"><a target="new" href="index.php?module=te_ExpensePO&action=download&id={$id}&records={$overview->id}"> <img src="custom/themes/SuiteR/css/uploader/not_available-generic.png" style="width:25px;height:25px"> {$val->orgname} </a></div></div>
									{/foreach}
								  {/if}
						  {/if}
						 
		   </div>
		</div>
	</div>
	
 {if $status==2 && $overview->expense_type=='PO'}
	{sugar_getscript file="custom/themes/SuiteR/css/uploader/all.fine-uploader.min.js"}
    {if $isfacility>0}	

			
			<div id="2a" class="tab-pane   row overview">
						<div style="clear:both;margin-bottom: 25px;" class="apendnewdocs col-sm-6">						
						
						{foreach from=$podocs key=id item=val}
							<div class="uploadedimg" style="line-height: 32px;"><div class="col-sm-6"><a target="new" href="index.php?module=te_ExpensePO&action=download&id={$id}&records={$overview->id}"> <img src="custom/themes/SuiteR/css/uploader/not_available-generic.png" style="width:25px;height:25px"> {$val->orgname} </a></div></div>
						{/foreach}
						</div>
						<div class="clear"></div>
						<div id="fine-uploader-gallery"></div>
			 
			 
			</div>
			
	{/if}
	 
		<div id="3a" class="tab-pane   row ">
		  {{include file='custom/modules/te_ExpensePO/tpls/DetailView/payment.tpl'}}
		</div>
	 
{/if}	
		
</div>		



<script>
 {literal}
    var records='{{$overview->id}}';
	$( ".rejectme" ).on('click',function( event ) {	
	
		 swal({
			  title: "Reject!",
			  text: "Write reason for rejection",
			  type: "input",
			  showCancelButton: true,
			  closeOnConfirm: true,
			  animation: "slide-from-top",
			  inputPlaceholder: "Write here"
			},
			function(inputValue){
			  if (inputValue === false) return false;
			  
			  if (inputValue === "") {
				swal.showInputError("You need to write reason!");
				return false
			  }
			  
				 $.post( "index.php?module=te_ExpensePO&action=approval&to_pdf=1", { type: "reject", record: records ,reason:inputValue })
				  .done(function( data ) {
					 
					  toastr.options = { "positionClass": "toast-top-center","timeOut": "8000",}
					  var obj= eval('(' + data + ')');
					  if(obj.error==0){
							toastr["success"](obj.msg);
							swal({title:"Finished!",timer: -1});
							location.reload();
					  }else{
							toastr["error"](obj.msg);
							swal({title:"Finished!",timer: -1});
					  }
				 });
				  
			 
			});
	
	
	});
	$( ".cancelme" ).on('click',function( event ) {	
	
		 swal({
			  title: "Cancel!",
			  text: "Write reason for rejection",
			  type: "input",
			  showCancelButton: true,
			  closeOnConfirm: true,
			  animation: "slide-from-top",
			  inputPlaceholder: "Write here"
			},
			function(inputValue){
			  if (inputValue === false) return false;
			  
			  if (inputValue === "") {
				swal.showInputError("You need to write reason!");
				return false
			  }
			  
				 $.post( "index.php?module=te_ExpensePO&action=approval&to_pdf=1", { type: "cancel", record: records ,reason:inputValue })
				  .done(function( data ) {
					 
					  toastr.options = { "positionClass": "toast-top-center","timeOut": "8000",}
					  var obj= eval('(' + data + ')');
					  if(obj.error==0){
							toastr["success"](obj.msg);
							swal({title:"Finished!",timer: -1});
							location.reload();
					  }else{
							toastr["error"](obj.msg);
							swal({title:"Finished!",timer: -1});
					  }
				 });
				  
			 
			});
	
	
	});
	
	$( ".approveme" ).on('click',function( event ) {
	
	{{if $sendtofin==1 || $isfacility>0}}
	
		$.post( "index.php?module=te_ExpensePO&action=approval&to_pdf=1", { type: "approve", record: records  })
			  .done(function( data ) {
				 
				  toastr.options = { "positionClass": "toast-top-center","timeOut": "8000",}
				  var obj= eval('(' + data + ')');
				  if(obj.error==0){
						toastr["success"](obj.msg);
						location.reload();
				  }else{
						toastr["error"](obj.msg);
				  }
			 });
	
	
	
	{{ else }}
		swal({
		  title: "Facility Member?",
		  text: "Are you want to send to facility Member?",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonColor: "#DD6B55",
		  confirmButtonText: "No!",
		  cancelButtonText: "Yes, send to Facility",
		  closeOnConfirm: false,
		  closeOnCancel: false
		},
		function(isConfirm){
		  if (isConfirm) {
			$.post( "index.php?module=te_ExpensePO&action=approval&to_pdf=1", { type: "approve", record: records })
			  .done(function( data ) {
				 
				  toastr.options = { "positionClass": "toast-top-center","timeOut": "8000",}
				  var obj= eval('(' + data + ')');
				  if(obj.error==0){
						toastr["success"](obj.msg);
						
						location.reload();
				  }else{
						toastr["error"](obj.msg);
				  }
			 });			
		  } else {
			$.post( "index.php?module=te_ExpensePO&action=approval&to_pdf=1", { type: "approve", record: records, facility:1 })
			  .done(function( data ) {
				 
				  toastr.options = { "positionClass": "toast-top-center","timeOut": "8000",}
				  var obj= eval('(' + data + ')');
				  if(obj.error==0){
						toastr["success"](obj.msg);
						location.reload();
				  }else{
						toastr["error"](obj.msg);
				  }
			 });
			
		  }
		});
	{{/if }}

	
	
	

	});	
 {{if $status==2 && $overview->expense_type=='PO'}}
    {{if $isfacility>0}}		
		 var ids='{{$overview->id}}';
         var finalParams={records:ids};
         var restrictedUploader = new qq.FineUploader({
            element: document.getElementById("fine-uploader-gallery"),
            template: 'qq-template-gallery',           
            request: {
                 endpoint: 'index.php?module=te_ExpensePO&action=uploadsPO&to_pdf=1',                 
            },
          
            thumbnails: {
                placeholders: {
                    waitingPath: 'custom/themes/SuiteR/css/uploader/waiting-generic.png',
                    notAvailablePath: 'custom/themes/SuiteR/css/uploader/not_available-generic.png'
                }
            },           
            validation: {                
                itemLimit: 10,
                sizeLimit: 1024*1024*20 // 50 kB = 50 * 1024 bytes
            },
            callbacks: {
				
				onSubmit: function (id, fileName) {
 
						this.setParams(finalParams);
				},
				
				 
				onComplete: function(id, fileName, responseJSON) {	
					toastr.options = { "positionClass": "toast-top-center","timeOut": "8000",}
					if(responseJSON.success==true){ 
						
						$('.apendnewdocs').append('<div class="uploadedimg" style="line-height: 32px;"><div class="col-sm-6"><a target="new" href="index.php?module=te_ExpensePO&action=download&id='+ responseJSON.id  +'&records='+ ids +'"> <img src="custom/themes/SuiteR/css/uploader/not_available-generic.png" style="width:25px;height:25px"> '+ responseJSON.orgfilename +' </a></div></div>');
						
						toastr["success"](responseJSON.message);
					}else{
						toastr["error"](responseJSON.message);
					}
				}	
			}	
        });
         
         
	 {{/if}}	
  {{/if}}	
		
 {/literal}
</script>

{{include file=$footerTpl}}
<script type="text/javascript" src="include/InlineEditing/inlineEditing.js"></script>
<script type="text/javascript" src="modules/Favorites/favorites.js"></script>

