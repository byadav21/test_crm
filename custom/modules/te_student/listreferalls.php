<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

require_once('custom/modules/te_student/te_student_override.php');

global  $current_user;
if(!$current_user->is_admin){
   echo 'Unauthorized Access'; die;	
}

$isAjax=(isset($_REQUEST['to_pdf']) && $_REQUEST['to_pdf']==1)? true : false;
$page=(isset($_REQUEST['page']) && intval($_REQUEST['page'])>0)? intval($_REQUEST['page']) : 1;
$noofRow=18;
$obj=new te_student_override();
$start=$noofRow*($page-1);
$results=$obj->getAllRefrals($start,$noofRow);

if(!$isAjax){ 
?>
<style>
	 
	.revenue h1{      font-size: 20px;
    margin: 18px 0;
    font-weight: bold;}
	.revenue{    line-height: 36px;}
	.revenue .innerdiv .div{border: 1px solid silver;
			border-right: 0px;border-bottom:0px}
	.innerdiv div.divlast{border-right: 1px solid silver!important;}		
	.divlastbot{border-bottom: 1px solid silver;}
	.headrtbl{    background: #F6F6F6;}	
	.bordertopright{border-top: 0px!important;border-right: 0px!important;}	
	.bordertopleft{border-top: 0px!important;border-left: 0px!important;}
	label{display:block}
	.button{    padding: 0px 17px!important;}	
	#loadingPages{vertical-align: middle;
    position: absolute;
    top: 51%;
    right: 38%;    
    background: #f1f1f1;
    padding: 12px;}
    .disablediv{display: block;
    height: auto;
    opacity: 0.7;
    pointer-events: none;}
    .modal-body .form-horizontal .col-sm-2,
.modal-body .form-horizontal .col-sm-10 {
    width: 100%
}

.modal-body .form-horizontal .control-label {
    text-align: left;
}
.modal-body .form-horizontal .col-sm-offset-2 {
    margin-left: 15px;
}
	</style>
	
<div class="container revenue">
  <h1>Referals Check for Coupon</h1>
             
  <div class="row">
    
    
    
       <div class="col-xs-12 innerdiv">
		 <div  class="col-xs-6 div">   
			<div class="col-xs-4 text-center headrtbl">Student</div>
			<div class="col-xs-4  text-center headrtbl">Email</div>
			<div class="col-xs-4  text-center headrtbl">Status</div>
         </div>
         <div  class="col-xs-6 div divlast"> 
			<div class="col-xs-4  text-center headrtbl"> Refree Email</div>
			<div class="col-xs-8  text-center headrtbl"> Coupons</div>			
		</div>	
      </div>
    
    <div class="maincont">
<?php } ?>		
		<?php if($results && count($results)>0){ ?>
			 
			<?php 
				$i=0;
				$current='';
				foreach($results as $res){ ?>
				  <div class="col-xs-12 innerdiv <?php echo($i==count($results)-1) ? 'divlastbot' : '' ?>">	 
				
						 <div  class="col-xs-6 div">
						    <div  class="col-xs-4  text-center"><?php echo $res['sname'] ?></div>
							<div style="border-left: 0px;" class="col-xs-4  text-center"><?php echo $res['email'] ?></div>
							<div style="border-left: 0px;" class="col-xs-4  text-center"><?php echo $res['status'] ?></div>							
						 </div>	
						 <div  class="col-xs-6 div divlast">	
							<div class="col-xs-4  text-center"><?php echo $res['refree'] ?></div>
							<div class="col-xs-8  text-center"><button class="btn btn-primary btn-lg coupnbtn" data-id="<?php echo $res['id'] ?>" data-toggle="modal" data-target="#myModalNorm" style="padding:2px 13px!important">  Add Coupon</button></div> </div> 
				  
				 </div>
				 
		<?php 	$current=$res['id']; $i++; }
		     if(count($results)>=18){?>
		     <div class="col-xs-12 text-center"><button class="loadmore button " data-id="<?php echo ++$page ?>">Load More</button></div> 
		<?php } }else{ ?>	
			
				<div class="col-xs-12 innerdiv <?php echo($i==count($results)-1) ? 'divlastbot' : '' ?>">
						 <div  class="col-xs-12 div">
						     No Refferals found!							
						 </div>	
				 </div>
			
		<?php } ?>	
		
<?php if(!$isAjax){ ?>
    </div>

</div>
<script>
	var page=1;
	var currentCID=0;
$(document).ready(function(){	
	$('.maincont').on('click','.coupnbtn',function(){
		currentCID=$(this).attr('data-id');
	});	


$('.modal').on('click','.savecoupon',function(){
	 $('.modal-body span').hide();
	 
	 if($.trim($('#coupon_company').val())==''){
		 $('#coupon_company').next().show();return false;
	 }
	 if($.trim($('#coupon_code').val())==''){
		 $('#coupon_code').next().show();return false;
	 }
	 $(this).addClass('disabled');
	 var btnobj=$(this);
	  
	$.post( "index.php?module=te_student&action=saveCoupon&to_pdf=1", {coupon_name:$.trim($('#coupon_company').val()),coupon_code:$.trim($('#coupon_code').val()),user:currentCID })
	.done(function( data ) {
				  
				  btnobj.removeClass('disabled');
				  
				 
	});
	 
	 
	 
});
	
});		
$('.maincont').on('click','.loadmore',function(){
	page=$(this).attr('data-id');
	$(this).remove();
	getResult();
})
	
$('.buttonsearch').on('click',function(){
	page=1;
	$('.maincont').html('');
	getResult();
	
});
function getResult(){
	
	$('.maincont').addClass('disablediv');
	  
	$('#loadingPages').css('opacity:1');
	$.get( "index.php?module=te_student&action=listreferalls&to_pdf=1", {page:page })
	.done(function( data ) {
				  
				  $('.maincont').append(data);
				   $('.maincont').removeClass('disablediv');
				   $('#loadingPages').css('opacity:0');
				 
	}); 
}	
</script>
<div id="loadingPages" align="center" style="vertical-align:middle;opacity:0"><img src="themes/default/images/img_loading.gif?v=pjh5Q-Y5ZM5LOLJN0GRbHQ" align="absmiddle"> <b>Loading results, please wait...</b></div>


<!-- Modal -->
<div class="modal fade" id="myModalNorm" tabindex="-1" role="dialog" 
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" 
                   data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Add Coupon
                </h4>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body">
                
                
                  <div class="form-group">
                    <label for="exampleInputEmail1">Coupon Company</label>
                      <input type="text" required class="form-control"
                      id="coupon_company" placeholder="Flipkart, paytm ...."/>
                      <span style="color:red;display:none">Please enter coupn company</span>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Coupon Code/Voucher</label>
                      <input type="text" required class="form-control"
                          id="coupon_code" placeholder="CXYO...."/>
                       <span style="color:red;display:none">Please enter coupn code</span>   
                  </div>
                   
                  <button type="button" class="btn btn-default savecoupon">Save</button>
                         
                
            </div>            
        </div>
    </div>
</div>


<?php } ?>



