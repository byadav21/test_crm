<?php
  //include a javascript file
  
class ContractHook
{
	public function renameDocument(&$bean, $event, $arguments)
    {	
		$old_file="upload/7c69eac5-ae40-67ae-16f3-57df6a23bd5c_document_c";
		$new_file="upload/".$bean->id."_".$bean->document_c;
		rename($old_file,$new_file);
	}
	public function updateRate(&$bean, $event, $arguments)
    {	
		$bean->rate_c=($bean->total_contract_value/$bean->target_c);
	}
	
}
