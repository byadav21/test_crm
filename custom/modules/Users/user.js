$(document).ready(function(){
	$('#designation').change(function (){
		var designation = $("#designation").val();			
		$.ajax({
			url: "index.php?entryPoint=duplicatebuh",
			data: {designation:designation},
			type: 'POST',
			dataType: 'json',
			success: function(result){
				 if(result.message == 'yes') {
					 alert("One user is already active on this designation");
					 $("#designation").val('');
				 }
			},
		});
	
	});
	
});