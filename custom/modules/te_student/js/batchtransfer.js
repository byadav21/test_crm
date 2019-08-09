app.controller("studentlisting", function($rootScope,$scope, $http) {
	
	$scope.results={};
	$scope.req={};
	$scope.req.newprogram='';
	$scope.req.newbatch='';
	$scope.batch={};
	$scope.groupProgram={};
	$scope.groupBatch={};	 
	$scope.isprogramme=0;
 
	 
	
	$scope.doTransfer=function(){	
		
		if($scope.req.newprogram=='' && $scope.isprogramme==0 &&  batch.is_transfer==1){
			toastr["error"]("Please select programme!"); return false;
		}
		
		if($scope.req.newbatch=='' && $scope.isprogramme==1){
			toastr["error"]("Please select batches!");
			  return false;
		}
		
		$('.modal-body').css('pointer-events','none');
		$('.modal-body').css('opacity','0.7');
		
		$http({
			url: 'index.php?module=te_student&action=transferbatchrequest&to_pdf=1', 
			method: "POST",
			params: {student_id: $scope.results.id,old_batch: $scope.batch.id_org,new_batch: $scope.req.newbatch,student_country:'india'}
		 }).success(function(data, status) {
			if(data.status=='queued'){
				window.location.href="index.php?module=te_student&action=index&parentTab=SRM";
			}else{
			  
				toastr["error"]("something gone wrong. Please try again!");
			   		$('.modal-body').css('pointer-events','all');
					$('.modal-body').css('opacity','1');
			   	
			}
			
		});
		
		
	}	 
	
	$scope.GetSelectedBatch=function(){	
		$scope.groupBatch={};
		$http.post('index.php?entryPoint=getbatch&programId='+ $scope.req.newprogram).success(function(data, status) {
			if(data.status=='ok'){
				$scope.groupBatch=data.res;
			}
			
		});
	}
			 
	$scope.openTransfer=function(id){		 
		 $scope.groupProgram={};
		 $scope.groupBatch={};
		 $scope.isprogramme=0;
		 $scope.results={};
		 $scope.batch={};
		 $http.post('index.php?module=te_student&action=batchTransfer_ajax&type=fetch_student&to_pdf=1&records='+ id).success(function(data, status) {
			$scope.results=data.result;
			$scope.batch=data.batch;
			$scope.groupProgram=data.programme;
			$scope.groupBatch=data.selbatch;
			$scope.isprogramme=0;
			
			$('#studentModal').modal('show',{
				backdrop: 'static',
				keyboard: false,
			});
						
		});
		 
		 	
	}	
	
	 
	
	
});	 
