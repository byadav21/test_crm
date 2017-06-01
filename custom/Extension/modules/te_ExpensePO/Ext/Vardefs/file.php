<?php

$dictionary['te_ExpensePO']['fields']['expense_type'] =array (
	'name' => 'expense_type', 'options'=>'exptypedom',
	'label' => 'Expense type',
	'type' => 'enum',	
	'len' => '15',
    'size' => '20',
	'required' => false, 
	'default'=>'PO'
	 
);


$dictionary['te_ExpensePO']['fields']['inv_num'] =array (
	'name' => 'inv_num',
	'label' => 'Invoce No.',
	'type' => 'varchar',	
	'len' => '30',
    'size' => '20',
	'required' => false 
);

$dictionary['te_ExpensePO']['fields']['cost_center'] =array (
	'name' => 'cost_center',
	'label' => 'Cost Center',
	'type' => 'varchar',	
	'len' => '30',
    'size' => '20',
	'required' => false 
);
