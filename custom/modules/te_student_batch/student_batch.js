$(document).ready(function(){	
	$(window).load(function() {
		  $('.id-ff').html('');
		  $('.utils').html('');
		  if($("#status").val() != "Dropout" ){
			document.getElementById("detailpanel_2").style.display ='none';
		  }else{
			  document.getElementById("detailpanel_2").style.display ='inline';
		  }
	});
	$("#status").change(function() {
		if(this.value === "Dropout" ){
			document.getElementById("detailpanel_2").style.display ='inline';
		}else{
			document.getElementById("detailpanel_2").style.display ='none';
		}
	})
});

