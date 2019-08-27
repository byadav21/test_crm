<?php

 $db=DBManagerFactory::getInstance();
 $itemDetal=$db->query("select refrenceid from te_expensepo where deleted='0' order by date_entered desc limit 0,1");
 $row=$db->fetchByAssoc($itemDetal);
 $refID= intval(date('Y')).'-';
 $refID.= intval(date('y'))+1 .'-';
 if($row && count($row)>0){
	 
	 $newRef=explode('-',$row['refrenceid']);
	 if(count($newRef)==3){
		 $refID.=str_pad(intval($newRef[2])+1,3,'0',STR_PAD_LEFT);
	 }else{
		$refID.=str_pad('1',3,'0',STR_PAD_LEFT);	
	 }
 }else{
  $refID.=str_pad('1',3,'0',STR_PAD_LEFT);	 
 }
 echo $refID;
 
