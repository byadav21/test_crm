$(document).ready(function(){
						
 	$('#program').change(function (){
		var programId = this.value;
		if(programId!=0){
			jQuery.ajax({
				type: "POST",
				url: 'index.php?entryPoint=getbatch',
				data: {programId: programId},
				success: function (result)
				{
					var result = JSON.parse(result);
					if(result.status=='ok'){
						var batch='<option value=""></option>';
						 for(var i=0;i<result.res.length;i++){
								var id = result.res[i].id;
								var name = result.res[i].name;
								batch+='<option value="'+id+'">'+name+'</option>'
						 }
						 $("#batch").html(batch);
					}
				}
			});
		}	
	}); 
	
	$('#batch').change(function (){
		var batchId = this.value;
		if(batchId!=0){
			jQuery.ajax({
				type: "POST",
				url: 'index.php?entryPoint=getvendors',
				data: {batchId: batchId},
				success: function (result)
				{
					var result = JSON.parse(result);
					if(result.status=='ok'){
						var vendor='<option value=""></option>';
						 for(var i=0;i<result.res.length;i++){
								var id = result.res[i].id;
								var name = result.res[i].name;
								vendor+='<option value="'+id+'">'+name+'</option>'
						 }
						 $("#vendor").html(vendor);
					}
				}
			});
		}	
	});	
});
	$('#Status').multiselect({
    columns: 2,
    selectAll: true
});				
