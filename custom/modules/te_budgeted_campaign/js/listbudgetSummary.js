app.controller("revenueSummary", function($rootScope,$scope, $http) {
	
	$scope.results={};
	$scope.request={};
	$scope.request.email='';
	$scope.request.batch='';
	$scope.request.installment='';
	$scope.page=1;
	$scope.isload=0;

	$scope.getResults=function(){
		
		$('.maincont').addClass('disablediv');	  
		$('#loadingPages').css('opacity:1');		
		$('.certsavebtn').hide();
		$('.cert_show_progress').show();
		$http.post('index.php?module=te_budgeted_campaign&action=listbudegetCampaignSummary_ajax&to_pdf=1&page='+$scope.page).success(function(data, status) {
			if($scope.page>1){
				
				if(Object.keys(data.data).length>0){
					angular.forEach(data.data, function(item, key){
					$scope.results.push(item);
				})
			  }	
				 
			}else{
				$scope.results=data.data;
			}
			$scope.page=data.page;
			$scope.isload=data.isload;
			$('.maincont').removeClass('disablediv');
			$('#loadingPages').css('opacity:0');			
		});
	}
	
	$scope.doSearch=function(){
		$scope.page=1;
		$scope.results={};
		$scope.getResults();		
	}	
	
	$scope.loadMore=function(){		 
		$scope.getResults();		
	}	
	 	
	
	$scope.doSearch();
	
	
	
});	 
