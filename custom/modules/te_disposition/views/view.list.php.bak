<?php
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Enterprise Subscription
 * Agreement ("License") which can be viewed at
 * http://www.sugarcrm.com/crm/products/sugar-enterprise-eula.html
 * By installing or using this file, You have unconditionally agreed to the
 * terms and conditions of the License, and You may not use this file except in
 * compliance with the License.  Under the terms of the license, You shall not,
 * among other things: 1) sublicense, resell, rent, lease, redistribute, assign
 * or otherwise transfer Your rights to the Software, and 2) use the Software
 * for timesharing or service bureau purposes such as hosting the Software for
 * commercial gain and/or for the benefit of a third party.  Use of the Software
 * may be subject to applicable fees and any use of the Software without first
 * paying applicable fees is strictly prohibited.  You do not have the right to
 * remove SugarCRM copyrights from the source code or user interface.
 *
 * All copies of the Covered Code must include on each user interface screen:
 *  (i) the "Powered by SugarCRM" logo and
 *  (ii) the SugarCRM copyright notice
 * in the same form as they appear in the distribution.  See full license for
 * requirements.
 *
 * Your Warranty, Limitations of liability and Indemnity are expressly stated
 * in the License.  Please refer to the License for the specific language
 * governing these rights and limitations under the License.  Portions created
 * by SugarCRM are Copyright (C) 2004-2009 SugarCRM, Inc.; All Rights Reserved.
 ********************************************************************************/
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('include/MVC/View/views/view.list.php');
class te_dispositionViewList extends ViewList
{   
	
	
     function listViewProcess(){		
		$this->processSearchForm();
       
		$this->lv->searchColumns = $this->searchForm->searchColumns;
		if(!$this->headers)
			return;
		if(empty($_REQUEST['search_form_only']) || $_REQUEST['search_form_only'] == false){
		
			$this->lv->ss->assign("SEARCH",true);
			
			
			$this->lv->setup($this->seed, 'custom/modules/te_disposition/tpls/ListViewGeneric.tpl', $this->where, $this->params);
			$savedSearchName = empty($_REQUEST['saved_search_select_name']) ? '' : (' - ' . $_REQUEST['saved_search_select_name']);
			echo $this->lv->display();
		}
 	}
     
 	
 public function display(){
	
	
		?>
		<link href="custom/modules/te_disposition/include/css/popup.css" rel="stylesheet">
<script type="text/javascript" src="custom/modules/te_disposition/include/js/popup.js"></script>
<script>
	setInterval("getRunningCalls()", 25000 );
	
	function getRunningCalls(){
			
				//~ 
				//~ var callback_date = document.getElementById('date_of_callback_date_d').value;
				//~ SUGAR.ajaxUI.showLoadingPanel();
				var callback = {
					success:function(b){
						//~ SUGAR.ajaxUI.hideLoadingPanel();
						//~ alert(b.responseText)
						document.getElementById('running_call_container').innerHTML='';
						document.getElementById('running_call_container').innerHTML=b.responseText;
						//~ if(b.responseText.trim()=="1"){	
							//~ 
							//~ window.location.href='index.php?module=te_disposition&action=index';
						//~ }
						//~ else{
							//~ alert('Error!! Record not saved')
						//~ }
					}
							
				}
				
				var connectionObject = YAHOO.util.Connect.asyncRequest('GET', 'index.php?entryPoint=getCurrentCalls&user_id=1', callback);
			
		 }
		
        
  function update_disposition_forrunning(dispo_id,mobile){

		//~ alert(dispo_id)
			document.getElementById('disposition_id').value=dispo_id;
			var url_open = "http://localhost/project/scrm/index.php?entryPoint=openDispositionPopup&disposition_id="+dispo_id+"&mobile"+mobile;
			window.open(url_open, '_blank', 'location=yes,height=570,width=520,status=yes');
		//~ $(this).popupModal('atomBox');
	}
	 
	function update_disposition(dispo_id){

		//~ alert(dispo_id)
			document.getElementById('disposition_id').value=dispo_id;
			//~ var url_open = "http://localhost/project/scrm/index.php?entryPoint=openDispositionPopup&disposition_id="+dispo_id;
			//~ window.open(url_open, '_blank', 'location=yes,height=570,width=520,status=yes');
		$(this).popupModal('atomBox');
	}    
  
	function saveDisposition(){
			
			var status = document.getElementById('status_d').value;
			var status_detail = document.getElementById('status_detail_d').value;
			var msg = "Please fill the following required field !!";
			var flag =1;
			if(status==''){
				msg = msg +"\n\t --Status \n"
				flag =0;
			}
			if(status_detail ==''){
				msg = msg +"\t --Status Detail \n"	
				flag =0;
			}
			if(flag ==0){
				alert(msg);
				return false;
			}
			else{	
				var description = document.getElementById('description_d').value;
				//~ 
				var callback_date = document.getElementById('date_of_callback_date_d').value;
				var callback_hr = document.getElementById('date_of_callback_hours_d').value;
				var callback_min = document.getElementById('date_of_callback_minutes_d').value;
				var disposition_id = document.getElementById('disposition_id').value;
				//~ 
				var callback = callback_date+" "+callback_hr+":"+callback_min+":00";
				
				
				//~ 
				var followup_date = document.getElementById('date_of_followup_date_d').value;
				var followup_hr = document.getElementById('date_of_followup_hours_d').value;
				var followup_min = document.getElementById('date_of_followup_minutes_d').value;
				//~ 
				var followup = followup_date+" "+followup_hr+":"+followup_min+":00";
				//~ 
				var prospect_date = document.getElementById('date_of_prospect_date_d').value;
				var prospect_hr = document.getElementById('date_of_prospect_hours_d').value;
				var prospect_min = document.getElementById('date_of_prospect_minutes_d').value;
				//~ 
				var prospect = prospect_date+" "+prospect_hr+":"+prospect_min+":00";
				//~ 
				//~ 
				var params = '&disposition_id='+disposition_id+'&status='+status+'&status_detail='+status_detail+'&description='+description+'&callback='+callback+'&followup='+followup+'&prospect='+prospect
				//~ alert(params)
				//~ return false;
				//~ SUGAR.ajaxUI.showLoadingPanel();
				var callback = {
					success:function(b){
						//~ SUGAR.ajaxUI.hideLoadingPanel();
						//~ alert(b.responseText)
						if(b.responseText.trim()=="1"){	
							//~ window.opener = self;
		  //~ window.close();
							window.location.href='index.php?module=te_disposition&action=index';
						}
						else{
							alert('Error!! Record not saved')
						}
					}
							
				}
				
				var connectionObject = YAHOO.util.Connect.asyncRequest('GET', 'index.php?entryPoint=saveDisposition'+params, callback);
			}
		 }
  
		

     </script>


<?php
		
		parent::display();
		require_once('custom/modules/te_disposition/include/ShowCallPopup.html');
	}
 
 	
}
?>
