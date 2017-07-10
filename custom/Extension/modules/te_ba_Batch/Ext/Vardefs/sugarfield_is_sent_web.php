<?php
$dictionary['te_ba_Batch']['fields']['is_sent_web'] =array (
		'name' => 'is_sent_web',
		'vname' => 'Is sent web',
		'type' => 'int',
		'required' => false,
		'comments' => 'web api leads update or insert for batch',
		'help' => '',
		'default'=> 0,
		'importable' => 'false',
		'duplicate_merge' => 'disabled',
		'duplicate_merge_dom_value' => '0',
		'audited' => false,
		'reportable' => false,
		'len' => '50',
		'size' => '50',
	);

$dictionary['te_ba_Batch']['fields']['d_campaign_id'] =array (
		'name' => 'd_campaign_id',
		'vname' => 'Campagain ID',
		'type' => 'varchar',
		'required' => false,
		'comments' => 'camp leads update or insert for batch',
		'help' => '',
	 
		'importable' => 'true',	
		'len' => '15',
		'size' => '50',
);

$dictionary['te_ba_Batch']['fields']['d_lead_id'] =array (
		'name' => 'd_lead_id',
		'vname' => 'Lead ID',
		'type' => 'varchar',
		'required' => false,
		'comments' => 'camp leads idupdate or insert for batch',
		'help' => '',
		 
		'importable' => 'true',	
		'len' => '15',
		'size' => '50',
);

$dictionary['te_ba_Batch']['fields']['lastCampagain'] =array (
		'name' => 'lastCampagain',
		'vname' => 'lastCampagain',
		'type' => 'varchar',
		'required' => false,
		'comments' => 'camp leads idupdate or insert for batch',
		'help' => '',
	 
		'importable' => 'true',	
		'len' => '15',
		'size' => '50'
);


?>
