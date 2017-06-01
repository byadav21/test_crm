<?php

 $i=0;
 $duplicate=false;
 $db=DBManagerFactory::getInstance();
 $array['start'][]=01;
 $array['start'][]=101;
 $array['start'][]=1001;
 $array['start'][]=10001;
 $array['end'][]=100;
 $array['end'][]=1000;
 $array['end'][]=10000;
 $array['end'][]=100000;
 do{
	 $refID= intval(date('Y')).'-';
	 $refID.= intval(date('y'))+1 .'-' .rand($array['start'][$i],$array['end'][$i]);
	 $duplicate=false;	
	 $itemDetal=$db->query("select refrenceid from te_expensepo where refrenceid='$refID'");
	 $row=$db->fetchByAssoc($itemDetal);
	 if($row && count($row)>0){
		$duplicate=true; 
	 }
	 $i++;
  }while($duplicate);
  
  echo $refID;
