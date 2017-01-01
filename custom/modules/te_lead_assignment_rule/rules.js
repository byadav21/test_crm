$(document).ready(function(){
	if($("#assign_rule").val() !='Group'){	
		document.getElementById("security_group").style.display ='none';
		document.getElementById("btn_clr_security_group").style.display ='none';
		document.getElementById("btn_security_group").style.display ='none';
		document.getElementById("security_group_label").innerHTML='';	
				
     }
 	$('#assign_rule').change(function (){
		if($("#assign_rule").val() !='Agent'){
			document.getElementById("security_group").style.display ='inline';
			document.getElementById("btn_clr_security_group").style.display ='inline';
			document.getElementById("btn_security_group").style.display ='inline';
			document.getElementById("security_group_label").innerHTML='Group:';
			
			document.getElementById("agent").style.display ='none';
			document.getElementById("btn_clr_agent").style.display ='none';
			document.getElementById("btn_agent").style.display ='none';
			document.getElementById("user_id_c").value ='';
			document.getElementById("agent").value ='';
			document.getElementById("agent_label").innerHTML='';
			
		}else{
			document.getElementById("security_group").style.display ='none';
			document.getElementById("btn_clr_security_group").style.display ='none';
			document.getElementById("btn_security_group").style.display ='none';
			document.getElementById("securitygroup_id_c").value ='';
			document.getElementById("security_group").value ='';
			document.getElementById("security_group_label").innerHTML='';
			
			document.getElementById("agent").style.display ='inline';
			document.getElementById("btn_clr_agent").style.display ='inline';
			document.getElementById("btn_agent").style.display ='inline';
			document.getElementById("agent_label").innerHTML='Agent:';
		}	
	
	}); 

});

