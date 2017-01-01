$(document).ready(function(){
	$('#name').blur(function (){
		var name= $("#name").val();
		$.ajax({
			url: "index.php?entryPoint=duplicateutm",
			data: {name:name},
			type: 'POST',
			dataType: 'json',
			success: function(result){
				if(result.name!=""){
					alert("Duplicate UTM Name");
					$("#name").val("");
				}
			},
		});
	
	});
	$('#utm_campaign').blur(function (){
		var utm_campaign= $("#utm_campaign").val();
		$.ajax({
			url: "index.php?entryPoint=duplicateutm",
			data: {utm_campaign:utm_campaign},
			type: 'POST',
			dataType: 'json',
			success: function(result){
				if(result.utm_campaign!=""){
					alert("Duplicate UTM Campaign");
					$("#utm_campaign").val("");
				}
			},
		});
	
	});
});

