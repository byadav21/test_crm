$(document).ready(function(){
	/*$(window).load(function() {
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
	})*/
	$(".actionmenulinks a").eq(4).attr('target','_blank');
	$("#total_payment").closest('tr').hide();
	var total_payment=$("#total_payment").text();
	$("#list_subpanel_te_student_batch_te_student_payment_plan_1>table>tbody").last('tr').after("<tr><th colspan='8' style='border: 1px solid #ddd;font-weight: bold;font-size: 1.5em;text-align: right;'>Total Payment: "+total_payment+"</th></tr>");
});
