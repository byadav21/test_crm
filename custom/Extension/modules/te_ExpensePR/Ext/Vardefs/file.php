<?php

$dictionary['te_ExpensePR']['fields']['status'] =array (
	'name' => 'status',
	'label' => 'Reference ID',
	'type' => 'varchar',	
	'len' => '1',
	'default'=>'1'
     
);

$dictionary['te_ExpensePR']['fields']['refrenceid'] =array (
	'name' => 'refrenceid',
	'label' => 'Reference ID',
	'type' => 'varchar',	
	'len' => '30',
     
);

$dictionary['te_ExpensePR']['fields']['amount'] =array (
	'name' => 'amount',
	'label' => 'Amount',
	'type' => 'decimal',
        'len'=>'8,2'	
	 
     
);

$dictionary['te_ExpensePR']['fields']['documents'] =array (
	'name' => 'documents',
	'label' => 'Documents',
	'type' => 'text',	
	 
     
);

$dictionary['te_ExpensePR']['fields']['reason_rejection'] =array (
	'name' => 'reason_rejection',
	'label' => 'Reason Rejection',
	'type' => 'text',
);

$dictionary['te_ExpensePR']['fields']['dated'] =array (
	'name' => 'dated',
	'label' => 'Date',
	'type' => 'date',	
	 
     
);
