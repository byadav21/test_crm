<?php

$glArray=[]; 
echo '<option value="">-- GL Code--</option>';
foreach($GLOBALS['app_list_strings']['list_glcode'] as $key=>$val){
	 $glcodeex=explode('_',$key);
	 if($glcodeex & count($glcodeex)>0){				 
		 if($glcodeex[0]==$_REQUEST['cost_center']){
		  echo '<option value="'.$key.'">'. $val .'</option>';	 
		 }
	 }
}
exit();		 
