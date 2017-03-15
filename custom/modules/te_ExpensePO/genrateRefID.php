<?php

 $i=0;
 $duplicate=false;
 $db=DBManagerFactory::getInstance();
 do{
	 $refID=rand(123456,999999);
	 $itemDetal=$db->query("select refrenceid from te_expensepo where refrenceid='$refID'");
	 $row=$db->fetchByAssoc($itemDetal);
	 if($row && count($row)>0){
		$duplicate=true; 
		if($i>7){			
			 $refID=rand(12345678,99999999);
			 $itemDetal=$db->query("select refrenceid from te_expensepo where refrenceid='$refID'");
			 $row=$db->fetchByAssoc($itemDetal);
			 if($row && count($row)>0){
				 $duplicate=true; 
				 if($i>15){
					 $refID='';
					 $duplicate=false;
				 }
		     }
		}
	 }
	 $i++;
  }while($duplicate);
  
  echo $refID;
