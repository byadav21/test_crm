<?php
/* This is Custom file  For Budgeted vs Compaign 
 * Display menu from Action at Module te_budgeted campaign
 *  Created date -02-dec-2016 @Manish Gupta 9650211216
 * */
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
ini_set('display_errors', '0');
error_reporting(E_ALL);
global $app_list_strings, $current_user, $sugar_config, $db;
?>


<style>	 
   .revenue h1{      font-size: 20px;
   margin: 18px 0;
   font-weight: bold;}
   .revenue{    line-height: 36px;}
   .revenue .innerdiv .div{    border: 1px solid silver;
   border-right: 0px;
   border-bottom: 0px;    word-wrap: break-word;
   height: auto;
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

<div class="container revenue" ng-controller="revenueSummary">
<h1>Select Batch</h1>
 <div class=" text-right ">
<span class="utils">
<a id="create_image" href="?action=ajaxui#ajaxUILoc=index.php?Fmodule=te_budgeted_campaign&action=EditView&return_module=te_budgeted_campaign&return_action=budget_summary" class="utilsLink">
<img src="themes/default/images/create-record.gif?v=G9oBIubjfusviQdLpVzJkw" alt="Create"></a>
<a id="create_link" href="index.php?module=te_budgeted_campaign&action=EditView&return_module=te_budgeted_campaign&return_action=budget_summary" class="utilsLink">
Create
</a>
</span>
 </div>
<div class="row">

   <div class="maincont">
      <div class="col-xs-12 innerdiv" ng-if="results.length == 0"  >
         <div class="col-sm-12 text-center div"><strong style="font-size:18px;">No data found</strong></div>
      </div>
      <div class="col-xs-12 innerdiv">
		  <div class="col-xs-3 div text-center headrtbl">Batch</div>
		  <div class="col-xs-2 div text-center headrtbl">Volume</div>
		  <div class="col-xs-2 div text-center headrtbl">Leads</div>
		  <div class="col-xs-2 div text-center headrtbl">Cost</div>
		  <div class="col-xs-1 div text-center headrtbl">Conversion</div>
		  <div class="col-xs-1 div text-center headrtbl">CPL</div>
		  <div class="col-xs-1 div text-center headrtbl">CPA</div>
      </div>
      <div class="col-xs-12 innerdiv" ng-if="results.length > 0" ng-repeat="(key,obj) in results">
          <div class="col-xs-3 text-center div"><a ng-href='index.php?searchFormTab=basic_search&module=te_budgeted_campaign&action=index&query=true&batch_basic=<% obj.name %>'  ><% obj.name %></a></div>
			<div class="col-xs-2 text-center div"><% obj.volume  | number : 0 %></div>	
			<div class="col-xs-2 text-center div"><% obj.leads  | number : 2 %></div>	
			<div class="col-xs-2 text-center div"><% obj.cost  | number : 2 %></div>	
			<div class="col-xs-1 text-center div"><% obj.conversion | number : 2 %></div>	
			<div class="col-xs-1 text-center div"><% obj.clp | number : 2 %></div>	
			<div class="col-xs-1 text-center div"><% obj.cpa | number : 2 %></div>	
      </div>
      <div ng-show="isload==1" class="col-xs-12 text-center"><button ng-click="loadMore()" class="loadmore button">Load More</button></div>
   </div>
</div>
<div id="loadingPages" align="center" style="vertical-align:middle;opacity:0"><img src="themes/default/images/img_loading.gif?v=pjh5Q-Y5ZM5LOLJN0GRbHQ" align="absmiddle"> <b>Loading results, please wait...</b></div>
<script type='text/javascript' src='custom/modules/te_budgeted_campaign/js/listbudgetSummary.js'></script>








