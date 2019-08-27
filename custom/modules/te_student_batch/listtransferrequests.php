<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

?>

<style>
	 
	.revenue h1{      font-size: 20px;
    margin: 18px 0;
    font-weight: bold;}
	.revenue{    line-height: 36px;}
	.revenue .innerdiv .div{border: 1px solid silver;    min-height: 73px;
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
	</style>
	
<div class="container revenue" ng-controller="transferbatch">
  <h1>Transfer Requests</h1>
             
<div class="row">

    
    
       <div class="col-xs-12 innerdiv">
		   
			<div class="col-xs-2 div text-center headrtbl">Student</div>
			<div class="col-xs-2 div text-center headrtbl">Email</div>
			<div class="col-xs-2 div text-center headrtbl">Old Batch</div>
			<div class="col-xs-2 div text-center headrtbl"> New Batch</div>
			<div class="col-xs-2 div text-center headrtbl"> Status</div>			
			<div class="col-xs-2 div divlast text-center headrtbl"> Requested By</div>			
       
      </div>
    
    <div class="maincont">
		<div class="col-xs-12 innerdiv" ng-repeat="(key,obj) in results">	 
				 
			<div class="col-xs-2 div text-center  "><% obj.sname %><br></div>
			<div class="col-xs-2 div text-center  "><% obj.email %></div>
			<div class="col-xs-2 div text-center  "><% obj.oldbatch %></div>
			<div class="col-xs-2 div text-center  "> <% obj.newbatch %></div>
			<div class="col-xs-2 div text-center  "> <% obj.transfer_status %></div>						
			<div class="col-xs-2  div text-center divlast "> <% obj.user_name %></div>						
						
		</div>
		
    </div>

</div>
<div id="loadingPages" align="center" style="vertical-align:middle;opacity:0"><img src="themes/default/images/img_loading.gif?v=pjh5Q-Y5ZM5LOLJN0GRbHQ" align="absmiddle"> <b>Loading results, please wait...</b></div>
<script type='text/javascript' src='custom/modules/te_student_batch/js/transfer.js'></script>
