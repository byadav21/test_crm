<?php
$dictionary['te_actual_campaign']['fields']['vendor_id'] = array(
	'required' => false,
	'name' => 'vendor_id',
	'vname' => 'vendor_id',
	'type' => 'varchar',
	'default'=>NULL,
	'audited' => false,
	'massupdate' => false,
	'studio' => 'visible',
	'len' => '36',
	'size' => '36',
	'dbType' => 'char',
);

$dictionary['te_actual_campaign']['fields']['type']['required']=false;
$dictionary['te_actual_campaign']['fields']['rate']['required']=false;
$dictionary['te_actual_campaign']['fields']['volume']['required']=false;
$dictionary['te_actual_campaign']['fields']['batch']['required']=true;
?>
