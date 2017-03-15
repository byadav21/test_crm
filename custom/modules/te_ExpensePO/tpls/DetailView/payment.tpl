{assign var='error' value=''}

{if $isfacility!=0}
	 {assign var='error' value='You are not authorised to add Payment'}
{/if}

{if $status!=2}
	 {assign var='error' value="Payment can't be added in this PO"}
{else}	

	 {if $overview->porequired=='yes' and $overview->podocument==''}
				 {assign var='error' value="Payment can't be added untill PO not uploaded"}
	 {/if}

{/if}
	<div class="row overview exdetail">
	  <div class="maincontainer headpaym">
	     <h3>Payment Overview</h3>
		<div class="col-sm-4 rowpadd">
			<p><b>Amount</b></p>
			<p><i class="fa fa-inr" aria-hidden="true"></i> {$totalamt.total}</p>
		</div>	
		<div class="col-sm-4 rowpadd">
			<p><b>Tax</b></p>
			<p><i class="fa fa-inr" aria-hidden="true"></i> {$totalamt.taxes}</p>
		</div>	
		<div class="col-sm-4 rowpadd">
			<p><b>Total</b></p>
			<p><i class="fa fa-inr" aria-hidden="true"></i><span class="totalamtnet">{$totalamt.nettotal}</span></p>
		</div>	
	</div>	
	{if $error!=''}

		<div class="alert alert-danger fade in alert-dismissable">
			<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
			<strong>Error!</strong> {$error}
		</div>	
	{elseif  $isfacility==0}	
		<div class="maincontainer col-sm-6">
		<div class="row items">
			<div class="col-sm-4 text-center">Invoive No</div>
			<div class="col-sm-4 text-center">Dated</div>
			<div class="col-sm-4 text-center">Amount</div>
		</div>
		<div class="row dompar">
		 
			<div class="col-sm-4"><input type="text" class="itemtxt invoiceno" name="invoice[]"><div class="errdiv">Please enter invoice number</div></div>
			<div class="col-sm-4"><span class="dateTime">
				<input class="date_input" autocomplete="off" type="text" name="dated" id="dated"   title="" tabindex="0" size="11" maxlength="10"><div class="errdiv">Please enter valid date</div>
				
			 
				</span>
				 {literal}<script type="text/javascript">
						$( "#dated" ).datepicker({
						  showButtonPanel: true
						});
				</script> {/literal}
			</div>
			<div class="col-sm-4"><input type="text" class="onlynum amtval" name="amount[]"><div class="errdiv">Please enter valid amount</div></div>
			
	 
		</div>
		<div class="row items" style="margin-top: 22px;">
			<div class="col-sm-4 text-center">Tax name</div>
			<div class="col-sm-4 text-center">Taxamt</div>
			<div class="col-sm-4 text-center">Total</div>
		</div>
		
		<div class="row dompar">
		
			<div class="col-sm-4">
				<select class="itemtxttx" name="taxesp[]">
					{foreach  from=$taxeslbl key=keys item=val}
						<option  value="{$keys}">{$val}</option>	 
					{/foreach}
				</select>
			</div>
			<div class="col-sm-4">
				<input type="text" class="onlynum taxval" name="taxes[]">
				<div class="errdiv">Please enter valid tax</div>
			</div>
			<div class="col-sm-4">
				<input class="disablepointer" type="text"  id="totamt">
				<div class="errdiv">Please enter amount less than total</div>
				 
			</div>
		
		</div>
		<div class="col-xs-12 items" style="margin-top: 15px;">
			<button type="button" class="button saveinvoice">SAVE INVOICE </button>	
		     <input type="checkbox" id="islast" style="top:-9px;"> Is this last payment 
		     
		</div>	
		
	 </div> 
	 <div class="col-xs-6">
		<div id="invoiceuploader"></div>
	 </div>
	{/if}	
		
	</div>	 

<div class="row overview exdetail addpaymentajax">
 <h3>Raised Invoice</h3>
 <br>
 <div class="row items">
	
	<div class="col-sm-2 text-center">Invoive No</div>
	<div class="col-sm-1 text-center">Dated</div>
	<div class="col-sm-2 text-center">Amount</div>
	<div class="col-sm-1 text-center">Tax name</div>
	<div class="col-sm-2 text-center">Taxamt</div>
	<div class="col-sm-2 text-center">Total</div>
	<div class="col-sm-1 text-center">Status</div>
	<div class="col-sm-1 text-center">Last paym.</div>
</div>

{foreach from=$payments key=i item=val}
 {assign var='lastpaym' value=''}
 {if $val.is_last_payment==1}
    {assign var='lastpaym' value='Yes'}
 {/if}
 <div class="row items paymdiv">
 
	<div class="col-sm-2 text-{if $val.status_c ==1}left{else}center{/if}">{if $val.status_c ==1}<i    class="fa fa-minus-circle deletepaym firstrowdel" aria-hidden="true"  data-id={$val.id}  ></i>{/if}	 {$val.invoice_no}</div>
 
	<div class="col-sm-1 text-center">{$val.date_entered|date_format:"%D"}</div>
	<div class="col-sm-2 text-center">{$val.amount}</div>
	<div class="col-sm-1 text-center">{$val.taxlabel}</div>
	<div class="col-sm-2 text-center">{$val.tax}</div>
	<div class="col-sm-2 text-center">{$val.totalamt}</div>
	<div class="col-sm-1 text-center">
	{if $val.status_c ==0}
	<span style="color:red"> Rejected </span>
	{elseif $val.status_c ==1}
	 <span style="color:orange">Open </span>
	{elseif $val.status_c ==2}
	 <span style="color:green">Approved </span>
	{/if}
	</div>
	<div class="col-sm-1 text-center">{$lastpaym}</div>
	{if count($val.files)>0}
	  <div class="col-sm-6 text-left">
	  {foreach from=$val.files key=idk item=image}
	   
	   <div class="uploadedimg" style="line-height: 32px;border-bottom:0"><a href="index.php?module=te_ExpensePO&action=download&id={$idk}&records={$val.id}&type=invoice"><img src="custom/themes/SuiteR/css/uploader/not_available-generic.png" style="width:25px;height:25px"> {$image->orgname}</a>
	   </div>
	  {/foreach}
	  </div>
	{/if}
	
	{if $val.status_c ==0}
		 <div class="col-sm-6 text-right">
           Reason : {$val.reject_reason_c}	
          </div> 
	{/if}
	
	
	{if $isfacility==1 && $val.status_c ==1}
	  <div class="col-sm-6 text-right">
	     <button style="padding-top: 1px;padding-bottom: 1px;" data-id="{$val.id|base64_encode}" class="button approvepaym">Approve</button>
	     <button style="padding-top: 1px;padding-bottom: 1px;" data-id="{$val.id|base64_encode}" class="button rejectpaym">Reject</button>
	  </div>
	{/if}
	
</div>
<div class="clear"></div>
{/foreach}
  

</div> 
{literal}	
<script>
	$('.onlynum').bind('copy paste cut',function(e) {
		e. preventDefault(); //disable cut,copy,paste.
	 
	});

	$('body').on('click','.deletepaym',function(e) {
	
            var thisobj=$(this);	
			var sw=swal({
			  title: "Are you sure?",
			  text: "You will not be able to recover this PO payment!",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonColor: "#DD6B55",
			  confirmButtonText: "Yes, delete it!",
			  closeOnConfirm: false,
			  showLoaderOnConfirm: true,
			},
			function(){
			  var attr=thisobj.attr('data-id');
				var overid='{{$overview->id}}';
				$.post( "index.php?module=te_ExpensePO&action=payment_del&to_pdf=1", { record: overid ,data:attr })
				  .done(function( dataobj ) {
					 
					  toastr.options = { "positionClass": "toast-top-center","timeOut": "8000",}
					  var obj= eval('(' + dataobj + ')');
					  if(obj.error==0){
							toastr["success"](obj.msg);	
							 					
							 thisobj.parent().parent().remove();
							 
								swal({title:"Finished!",timer: -1});
 
					  }else{
							toastr["error"](obj.msg);
							swal({title:"Finished!",timer: -1});
					  }
				 });
			});
	
	});
	
	
	$('body').on('keyup','.onlynum',function(e) {
		 calculate();
	});

	function calculate(){
		 var amount=0;
		 if($.trim($('.amtval').val())!=''){				
			var regex  = /(?=.)^\$?(([1-9][0-9]{0,2}(,[0-9]{3})*)|[0-9]+)?(\.[0-9]{1,2})?$/;
			if(regex.test($.trim($('.amtval').val()))){
				amount +=parseFloat($.trim($('.amtval').val()));
			}					
		}
		 if($.trim($('.taxval').val())!=''){				
			var regex  = /(?=.)^\$?(([1-9][0-9]{0,2}(,[0-9]{3})*)|[0-9]+)?(\.[0-9]{1,2})?$/;
			if(regex.test($.trim($('.taxval').val()))){
				amount +=parseFloat($.trim($('.taxval').val()));
			}					
		}
		
		$('#totamt').val(amount.toFixed(2));
	}
	var objUpload=[];	
	$('.saveinvoice').on('click',function(){
			var error=0;
			$('.errdiv').hide();
			if($.trim($('.invoiceno').val())==''){
				$('.invoiceno').next('.errdiv').show();	error=1;			
			}
			
			if($.trim($('#dated').val())==''){
				$('#dated').next('.errdiv').show();error=1;	
				
			}else if(!vallidateDate($.trim($('#dated').val()))){
				$('#dated').next('.errdiv').show();error=1;	
			}			
			if($.trim($('.amtval').val())=='' || $.trim($('.amtval').val())=='0' ){
				$('.amtval').next('.errdiv').show();error=1;	
				
			}			
			var regex  = /(?=.)^\$?(([1-9][0-9]{0,2}(,[0-9]{3})*)|[0-9]+)?(\.[0-9]{1,2})?$/;
			if(!regex.test($.trim($('.amtval').val()))){
				$('.taxval').next('.errdiv').show();error=1;	
			}
			if($.trim($('.amtval').val())!=''){
				var regex  = /(?=.)^\$?(([1-9][0-9]{0,2}(,[0-9]{3})*)|[0-9]+)?(\.[0-9]{1,2})?$/;
				if(!regex.test($.trim($('.taxval').val()))){
					$('.taxval').next('.errdiv').show();error=1;					
				}
			}
			
			if(parseFloat($('.totalamtnet').html()) < parseFloat($('#totamt').val())){
			
				$('#totamt').next('.errdiv').show();error=1;	
			}
			
			if(objUpload.length==0){
			
				toastr.options = { "positionClass": "toast-top-center","timeOut": "8000",}
				toastr["error"]("Please upload invoice to save");
				error=1;	
			}
			
			 
			
			if(error==0){
			 var overid='{{$overview->id}}';
			 var data={};
			 data.invoice_no=$.trim($('.invoiceno').val());
			 data.taxlabel=$.trim($('.itemtxttx').val());
			 data.is_last_payment=$('#islast').is(":checked") ? 1:0;
			 data.tax=$.trim($('.taxval').val());
			 data.amount=$.trim($('.amtval').val());
			 data.date_entered=$.trim($('#dated').val());
			 
			 $.post( "index.php?module=te_ExpensePO&action=payment&to_pdf=1", { record: overid ,data:data,invoice:objUpload })
				  .done(function( dataobj ) {
					 
					  toastr.options = { "positionClass": "toast-top-center","timeOut": "8000",}
					  var obj= eval('(' + dataobj + ')');
					  if(obj.error==0){
							toastr["success"](obj.msg);
							location.reload();
							 
					  }else{
							toastr["error"](obj.msg);
					  }
				 });
			
			}
			
			
	});
	
	function vallidateDate(text){
	 
		var comp = text.split('/');
		var m = parseInt(comp[0], 10);
		var d = parseInt(comp[1], 10);
		var y = parseInt(comp[2], 10);
		var date = new Date(y,m-1,d);
		if (date.getFullYear() == y && date.getMonth() + 1 == m && date.getDate() == d) {
			return true;
		} else {
			return false;
		}
	}
	
	
	{{if $isfacility==1}}
	
		$( ".approvepaym" ).on('click',function( event ) {
			var recordspaym=$(this).attr('data-id');
	 
	
			$.post( "index.php?module=te_ExpensePO&action=approvalinvoice&to_pdf=1", { type: "approve", record: recordspaym  })
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
		});
	
		
	
		$( ".rejectpaym" ).on('click',function( event ) {	
			var recordspaym=$(this).attr('data-id');
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
			  
				 $.post( "index.php?module=te_ExpensePO&action=approvalinvoice&to_pdf=1", { type: "reject", record: recordspaym ,reason:inputValue })
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
	
	{{/if}}
	{{if $isfacility==0}}	
	    
		 var ids='{{$overview->id}}';
       
         var restrictedUploaders = new qq.FineUploader({
            element: document.getElementById("invoiceuploader"),
            template: 'qq-template-gallery',           
            request: {
                 endpoint: 'index.php?module=te_ExpensePO&action=uploadsInvoice&to_pdf=1',                 
            },
            multiple:false,
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
				 
				onComplete: function(id, fileName, responseJSON) {	
					toastr.options = { "positionClass": "toast-top-center","timeOut": "8000",}
					if(responseJSON.success==true){ 
						 
							  objUpload[0]={'filename': responseJSON.filename,'orgname': responseJSON.orgfilename};
							 
							 					
						toastr["success"](responseJSON.message);
					}else{
						toastr["error"](responseJSON.message);
					}
				}	
			}	
        });
         
         
	 {{/if}}	
	
	
</script>
{/literal}
