{literal}
<style>	 
	.revenue h1{      font-size: 20px;
    margin: 18px 0;
    font-weight: bold;}
	.revenue{    line-height: 36px;}
	.revenue .innerdiv .div{    border: 1px solid silver;
    border-right: 0px;
    border-bottom: 0px;    word-wrap: break-word;
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
    .revmulti .ms-options-wrap ,.revmulti .ms-options-wrap > .ms-options{width:100%}
    .revmulti .ms-options-wrap > .ms-options > ul input[type="checkbox"] {top: 15px;}
	</style>
{/literal}	
<div class="container revenue" ng-controller="revenueSummary">
  <h1>Summary</h1>
             
<div class="row">
    
    <div class="col-xs-12 div revmulti" style="margin-bottom: 23px;">
		
		<div class="col-xs-4 text-left">
			<label>Select Batch Status : </label>
			<select multiple="multiple" class="multiselbox" id="batched" ng-model="request.batch" > 
				 
				<option   value="" selected="selected">All</option>
				<option   value="planned"  >Planned</option>
				<option label="Enrollment In-Progress" value="enrollment_in_progress">Enrollment In-Progress</option>
				<option label="Enrollment Closed" value="enrollment_closed">Enrollment Closed</option>
				<option label="Classes In-Progress" value="classes_in_progress">Classes In-Progress</option>
				<option label="Completed" value="completed">Completed</option>
				<option label="Certification in progress" value="certification_in_progress">Certification in progress</option>
				<option label="Closed" value="closed">Closed</option>
 
			</select>		
		</div>
		<div class="col-xs-3 text-left">
			<label>&nbsp;</label>
			<button ng-click="doSearch()" class="button buttonsearch">Filter</button>		
		</div>

		
	</div>	
    
    
       <div  class="col-xs-12 innerdiv">
		 
			<div class="col-xs-1 div text-center headrtbl">Institute</div>			 
			<div class="col-xs-2 div text-center headrtbl">Programme & Batch</div>			 
			<div class="col-xs-2 div  text-center headrtbl">Start Date</div>
			<div class="col-xs-1 div  text-center headrtbl">Status</div>
		 
			<div class="col-xs-1 div  text-center headrtbl"> Total Reg.</div>
			<div class="col-xs-1 div text-center headrtbl">Drop Out</div>
			<div class="col-xs-2 div text-center headrtbl">GSV</div>
			<div class="col-xs-2 divlast div text-center headrtbl">Revenue</div>
      </div>
    
    <div class="maincont">
        <div class="col-xs-12 innerdiv" ng-if="results.length == 0"  > <div class="col-sm-12 text-center div"><strong style="font-size:18px;">No data found</strong></div></div>
        
		<div class="col-xs-12 innerdiv" ng-if="results.length > 0" ng-repeat="(key,obj) in results">	 
			<div class="col-xs-1 text-center div"><% obj.iname %></div>
			<div class="col-xs-2 text-center div"><% obj.pname %> - <% obj.bname %></div>
			 
			<div class="col-xs-2  text-center div"><% obj.batch_start_date %></div>
			<div class="col-xs-1  text-center div"><% obj.batch_status %></div>
		 
			<div class="col-xs-1  text-center div"><a href="index.php?searchFormTab=basic_search&module=te_student_batch&batch_basic=<% obj.bname %>&action=index&query=true" ><% obj.activeStudent %> </a></div>
			<div class="col-xs-1  text-center div"><a href="index.php?searchFormTab=basic_search&module=te_student_batch&batch_basic=<% obj.bname %>&action=index&query=true&status_basic[]=Dropout" ><% obj.dropOutStudent %> </a></div>
			<div class="col-xs-2  text-center div"><% obj.totalamt %></div> 
			<div class="col-xs-2 divlast text-center div"><a href="index.php?module=te_student&action=listrevenue&records=<% obj.id %>"><% obj.amt %></a></div> 
						
						
		</div>
		<div ng-show="isload==1" class="col-xs-12 text-center"><button ng-click="loadMore()" class="loadmore button">Load More</button></div>
    
    </div>

</div>
<div id="loadingPages" align="center" style="vertical-align:middle;opacity:0"><img src="themes/default/images/img_loading.gif?v=pjh5Q-Y5ZM5LOLJN0GRbHQ" align="absmiddle"> <b>Loading results, please wait...</b></div>

<script type='text/javascript' src='custom/modules/te_student_batch/js/listrevenueSummary.js'></script>
