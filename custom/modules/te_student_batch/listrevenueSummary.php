<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

require_once('custom/modules/te_student/te_student_override.php');

global  $current_user;
 


$obj=new te_student_override();
$batchesarr=$obj->getAllStudentBatch();
$instLabels=$obj->getAllStudentInstallmentLabel(); 
?>

<style>
	 
	.revenue h1{      font-size: 20px;
    margin: 18px 0;
    font-weight: bold;}
	.revenue{    line-height: 36px;}
	.revenue .innerdiv .div{    border: 1px solid silver;
    border-right: 0px;
    border-bottom: 0px;
    height: 74px;
    overflow: hidden;}
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
    .revenue input[type=text], .revenue select {width:100%!important}
	</style>
	
<div class="container revenue" ng-controller="revenueSummary">
  <h1>Revenue</h1>
             
<div class="row">
    <!--
    <div class="col-xs-12 div" style="margin-bottom: 23px;">
		<div class="col-xs-3 text-center">
			<label>Email</label>
			<input type="text"  ng-model="request.email" class="itemtxt" name="items">
		</div>
		<div class="col-xs-3 text-center">
			<label>Batches</label>
			<select id="batched" ng-model="request.batch" ><option value="0">--Select--</option>
			<?php if($batchesarr && count($batchesarr)>0){ ?>
					<?php foreach($batchesarr as $btch){ ?>
						<option value="<?php echo $btch['id']?>"><?php echo $btch['name']?></option>
					<?php } ?>	
			<?php } ?>	
			</select>		
		</div>
		<div class="col-xs-3 text-center">
			<label>Installments</label>
			<select id="instLabel" ng-model="request.installment" >
				<option value="0">--Select--</option>
			<?php if($instLabels && count($instLabels)>0){ ?>
					<?php foreach($instLabels as $btch){ ?>
						<option value="<?php echo $btch['name']?>"><?php echo $btch['name']?></option>
					<?php } ?>	
			<?php } ?>				
			
			</select>		
		</div>
		<div class="col-xs-3 text-left">
			<label>&nbsp;</label>
			<button ng-click="doSearch()" class="button buttonsearch">Search</button>		
		</div>

		
	</div>	
    -->
    
       <div class="col-xs-12 innerdiv">
		 
			<div class="col-xs-1 div text-center headrtbl">Institute</div>			 
			<div class="col-xs-2 div text-center headrtbl">Programme & Batch</div>			 
			<div class="col-xs-2 div  text-center headrtbl">Start Date</div>
		 
			<div class="col-xs-2 div  text-center headrtbl"> Total Reg.</div>
			<div class="col-xs-1 div text-center headrtbl">Drop Out</div>
			<div class="col-xs-2 div text-center headrtbl">GSV</div>
			<div class="col-xs-2 divlast div text-center headrtbl">Revenue</div>
      </div>
    
    <div class="maincont">
		<div class="col-xs-12 innerdiv" ng-repeat="(key,obj) in results">	 
			<div class="col-xs-1 text-center div"><% obj.iname %></div>
			<div class="col-xs-2 text-center div"><% obj.pname %> - <% obj.bname %></div>
			 
			<div class="col-xs-2  text-center div"><% obj.batch_start_date %></div>
		 
			<div class="col-xs-2  text-center div"><a href="index.php?searchFormTab=basic_search&module=te_student_batch&batch_basic=<% obj.bname %>&action=index&query=true&status_basic[]=Active&status_basic[]=Inactive" ><% obj.activeStudent %> </a></div>
			<div class="col-xs-1  text-center div"><a href="index.php?searchFormTab=basic_search&module=te_student_batch&batch_basic=<% obj.bname %>&action=index&query=true&status_basic[]=Dropout" ><% obj.dropOutStudent %> </a></div>
			<div class="col-xs-2  text-center div"><% obj.totalamt %></div> 
			<div class="col-xs-2 divlast text-center div"><a href="index.php?module=te_student&action=listrevenue"><% obj.amt %></a></div> 
						
						
		</div>
		<div ng-show="isload==1" class="col-xs-12 text-center"><button ng-click="loadMore()" class="loadmore button">Load More</button></div>
    
    </div>

</div>
<div id="loadingPages" align="center" style="vertical-align:middle;opacity:0"><img src="themes/default/images/img_loading.gif?v=pjh5Q-Y5ZM5LOLJN0GRbHQ" align="absmiddle"> <b>Loading results, please wait...</b></div>
<script type='text/javascript' src='custom/modules/te_student_batch/js/listrevenueSummary.js'></script>
