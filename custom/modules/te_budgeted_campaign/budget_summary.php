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
	
<div class="container revenue" ng-controller="revenueSummary">
<h1>Select Batch</h1>
<div class="row">

   <div class="maincont">
      <div class="col-xs-12 innerdiv" ng-if="results.length == 0"  >
         <div class="col-sm-12 text-center div"><strong style="font-size:18px;">No data found</strong></div>
      </div>
      <div class="col-xs-7 " ng-if="results.length > 0" ng-repeat="(key,obj) in results">
          <div class="col-xs-7 text-left div"><a href="index.php?searchFormTab=basic_search&module=te_budgeted_campaign&batch_basic=<% obj.bname %>&action=index&query=true" ><% obj.name %></a></div>
     
      </div>
      <div ng-show="isload==1" class="col-xs-12 text-center"><button ng-click="loadMore()" class="loadmore button">Load More</button></div>
   </div>
</div>
<div id="loadingPages" align="center" style="vertical-align:middle;opacity:0"><img src="themes/default/images/img_loading.gif?v=pjh5Q-Y5ZM5LOLJN0GRbHQ" align="absmiddle"> <b>Loading results, please wait...</b></div>
<script type='text/javascript' src='custom/modules/te_budgeted_campaign/js/listbudgetSummary.js'></script>







