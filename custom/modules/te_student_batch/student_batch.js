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
        var is_new = $( "input[name='is_new_basic']" ).val();
        var is_new_dropout_basic = $( "input[name='is_new_dropout_basic']" ).val(); //
           if(is_new==1){
            updateLead();   
           }
          
           if(is_new_dropout_basic==1){
            updateDropout();   
           }
	$("#total_payment").closest('tr').hide();
	var total_payment=$("#total_payment").text();
	$("#list_subpanel_te_student_batch_te_student_payment_plan_1>table>tbody").last('tr').after("<tr><th colspan='8' style='border: 1px solid #ddd;font-weight: bold;font-size: 1.5em;text-align: right;'>Total Payment: "+total_payment+"</th></tr>");
});
function updateLead(){
    
    $.ajax({
        async: false,
        type: "GET",
        data: { 
          action2:'updateLeads'
         },
        dataType: "json",
        url: 'index.php?action=seen&type=new_conversion&module=te_student_batch&is_new_basic=1',
        error: function(responseData){
        },
        success:function(responseData)
        { 
           
            if(responseData.status==1){
                
            }

        } 
    });
    
}

function updateDropout(){
    
    $.ajax({
        async: false,
        type: "GET",
        data: { 
          action2:'updateDropout'
         },
        dataType: "json",
        url: 'index.php?action=seen&type=new_dropout&module=te_student_batch&is_new_dropout_basic=1&to_pdf=1',
        error: function(responseData){
        },
        success:function(responseData)
        { 
            
            if(responseData.status==1){
                
            }

        } 
    });
    
}