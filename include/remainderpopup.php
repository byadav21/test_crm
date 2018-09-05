<?php
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2016 Salesagility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/


class remainderpopup{

    function __get_user_callback(){
	global $db, $current_user;
	$call_backSql     = "SELECT c.id,c.lead_id,c.status_description,c.callback_date_time,l.first_name FROM callback_log AS c INNER JOIN leads AS l on l.id=c.lead_id WHERE c.is_seen=0 AND c.deleted=0 AND DATE(c.callback_date_time)<='".date('Y-m-d')."' AND c.assigned_user_id='".$current_user->id."' LIMIT 0,30";
	$call_backObj     = $db->query($call_backSql);
	$call_backOptions = array();
	while ($row   = $db->fetchByAssoc($call_backObj))
	{
	    $call_backOptions[] = $row;
	}
	return $call_backOptions;
	
    }
    function load_js($event, $arguments){
	global $db, $current_user;
	$data=$this->__get_user_callback();
	$json_data = json_encode($data);
	$popup_url = $GLOBALS['sugar_config']['site_url']."/index.php?entryPoint=leads_callback";
?>
<script type="text/javascript">
var t1=<?php echo $json_data ?>;
var popup_url="<?php echo $popup_url ?>";
if(t1.length>0){
	t1 = JSON.stringify(t1);
	localStorage.setItem("call_back", t1);	
}


//var d1 = new Date("2018-09-03 17:45:00");
//var d2 = new Date();
//alert(d1);
//alert(d2);
//if(diff_minutes(d2,d1)>=-15){alert('Hi'+diff_minutes(d2,d1));}
function diff_minutes(dt2, dt1) 
 {

  return Math.round((dt2.getTime() - dt1.getTime())/60000);
  
 }
/*setInterval(function() {
    alert(localStorage.getItem("call_back"));
}, 10 * 1000);*/

function fn60sec() {
        var callback_data = JSON.parse(localStorage.getItem("call_back"));
	var lead_url = '';
	for(var i=0;i<callback_data.length;i++){
		var d2 = new Date();
		var d1 = new Date(callback_data[i].callback_date_time);
		if(diff_minutes(d2,d1)>=-15){
		lead_url ="&lead_id="+callback_data[i].lead_id;
		lead_url +="&id="+callback_data[i].id;
		lead_url +="&first_name="+callback_data[i].first_name;
		lead_url +="&callback_date_time="+callback_data[i].callback_date_time;
		lead_url +="&status_description="+callback_data[i].status_description;
		
		window.open(popup_url+lead_url, "popupWindow", "width=600,height=600,scrollbars=yes");
		//console.log(popup_url);
		break;
		}
	}
	
}
fn60sec();
setInterval(fn60sec, 300*1000);
</script>
<?php
	/*echo '<script type="text/javascript">
		    $(window).on("load",function(){
			window.open("http://google.com", "popupWindow", "width=600,height=600,scrollbars=yes");
		    });
		</script>';*/
    }

}
?>

