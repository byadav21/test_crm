

    $(document).ready(function () {

	
	 var option = document.getElementById("status").options;
		   var status_detail = document.getElementById('status_detail').value;
		   
            if (document.getElementById('status').value == "Alive") {
				$("#status_detail option").remove() ; 
				 $("#status_detail").append('<option></option>');
				
				if (status_detail == 'Call Back'){
					$("#status_detail").append('<option value="Call Back" selected="selected" >Call Back</option>');
				}
				else{
					$("#status_detail").append('<option value="Call Back" >Call Back</option>');
				}
				if (status_detail == 'Follow Up'){
					 $("#status_detail").append('<option value="Follow Up" selected="selected">Follow Up</option>');
				}
				else{
				 $("#status_detail").append('<option value="Follow Up" >Follow Up</option>');
				}
				
				if (status_detail == 'New Lead'){
					$("#status_detail").append('<option  value="New Lead" selected="selected" >New Lead</option>');
				}
               else{
					$("#status_detail").append('<option  value="New Lead" >New Lead</option>');
				}
              }
            if (document.getElementById('status').value == "Dead") {
				//~ alert(status_detail)
				$("#status_detail option").remove() ; 
				 $("#status_detail").append('<option></option>');
				if (status_detail == 'Dead Number'){
				   $("#status_detail").append('<option  selected="selected" >Dead Number</option>');
				}
				else{
					$("#status_detail").append('<option>Dead Number</option>');
				}
				if (status_detail == 'Wrong Number'){
					$("#status_detail").append('<option  selected="selected" >Wrong Number</option>');
                }
				else{
					$("#status_detail").append('<option >Wrong Number</option>');
				}
                if (status_detail == 'Ringing Multiple Times'){
					$("#status_detail").append('<option  selected="selected" >Ringing Multiple Times</option>');
				}
				else{
					$("#status_detail").append('<option>Ringing Multiple Times</option>');
				}
                if (status_detail == 'Not Enquired'){
					$("#status_detail").append('<option  selected="selected" >Not Enquired</option>');
				}
				else{
					$("#status_detail").append('<option>Not Enquired</option>');
				}
                if (status_detail == 'Not Eligible'){
					$("#status_detail").append('<option  selected="selected" >Not Eligible</option>');
				}
				else{
					$("#status_detail").append('<option>Not Eligible</option>');
				}
                if (status_detail == 'Rejected'){
					$("#status_detail").append('<option  selected="selected" >Rejected</option>');
				}
				else{
					$("#status_detail").append('<option>Rejected</option>');
				}	
                if (status_detail == 'Fallout'){
					$("#status_detail").append('<option  selected="selected" >Fallout</option>');
				}
				else{
					$("#status_detail").append('<option >Fallout</option>');
				}	
                if (status_detail == 'Retired'){
					$("#status_detail").append('<option  selected="selected" >Retired</option>');
				}
				else{
					$("#status_detail").append('<option>Retired</option>');
				}	
            }
             if (document.getElementById('status').value == "Converted") {
				 $("#status_detail option").remove() ; 
				 $("#status_detail").append('<option></option>');
				if (status_detail == 'Converted'){
					$("#status_detail").append('<option  selected="selected">Converted</option>');
				}
				else{
					$("#status_detail").append('<option>Converted</option>');
				}
             }
             if (document.getElementById('status').value == "Warm") {
				 $("#status_detail option").remove() ; 
				 $("#status_detail").append('<option></option>');
                if (status_detail == 'Re-Enquired'){
					$("#status_detail").append('<option  selected="selected">Re-Enquired</option>');
				}
				else{
					$("#status_detail").append('<option>Re-Enquired</option>');
				}
               if (status_detail == 'Prospect'){
					$("#status_detail").append('<option  selected="selected">Prospect</option>');
				}
				else{
					$("#status_detail").append('<option>Prospect</option>');
				}
             }
             
             
             $("#status").change(function() {

				var el = $(this) ;
//~ alert(el.val())
				if(el.val() === "Alive" ) {
					$("#status_detail option").remove() ; 
					 $("#status_detail").append('<option></option>');
					$("#status_detail").append('<option>Call Back</option>');
					$("#status_detail").append('<option>Follow Up</option>');
					$("#status_detail").append('<option>New Lead</option>');
				}
				else if(el.val() === "Dead" ) {
					$("#status_detail option").remove() ; 
					 $("#status_detail").append('<option></option>');
					 $("#status_detail").append('<option>Dead Number</option>');
					$("#status_detail").append('<option>Wrong Number</option>');
					$("#status_detail").append('<option>Ringing Multiple Times</option>');
					$("#status_detail").append('<option>Not Enquired</option>');
					$("#status_detail").append('<option>Not Eligible</option>');
					$("#status_detail").append('<option>Rejected</option>');
					$("#status_detail").append('<option>Fallout</option>');
					$("#status_detail").append('<option>Retired</option>');
				}
				else if(el.val() === "Converted" ) {
					$("#status_detail option").remove() ; 
					 $("#status_detail").append('<option></option>');
					 $("#status_detail").append('<option>Converted</option>');
				}
				else if(el.val() === "Warm" ) {
					$("#status_detail option").remove() ; 
					 $("#status_detail").append('<option></option>');
					 $("#status_detail").append('<option>Re-Enquired</option>');
                $("#status_detail").append('<option>Prospect</option>');
				}
			  });

	
	  });
            
         
