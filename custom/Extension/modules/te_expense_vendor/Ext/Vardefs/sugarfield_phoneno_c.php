<?php
$dictionary['te_expense_vendor']['fields']['phone_no'] =array (
	'name' => 'phone_no',
	'label' => 'Phone',
	'type' => 'varchar',
	
	'len' => '15',
        'size' => '20',
	'required' => false, 
	'reportable' => true, 
	'audited' => false, 
	'importable' => 'true', 
	'duplicate_merge' => false, 
);


$dictionary['te_expense_vendor']['fields']['email_address'] =array (
        'name' => 'email_address',
        'label' => 'Email',
        'type' => 'varchar',
        
        'len' => '50',
        'size' => '20',
        'required' => false, 
        'reportable' => true, 
        'audited' => false, 
        'importable' => 'true',  
        'duplicate_merge' => false, 
);

 


$dictionary['te_expense_vendor']['fields']['bank_name'] =array (
        'name' => 'bank_name',  'label' => 'Name of bank',      
        'type' => 'varchar',        
        'len' => '60',       
);

$dictionary['te_expense_vendor']['fields']['account_no'] =array (
        'name' => 'account_no',     'label' => 'Account Number',    
        'type' => 'varchar',        
        'len' => '25',       
);


$dictionary['te_expense_vendor']['fields']['ifsc'] =array (
        'name' => 'ifsc',        'label' => 'Ifsc Code',     
        'type' => 'varchar',        
        'len' => '25',       
);

$dictionary['te_expense_vendor']['fields']['contact_person'] =array (
        'name' => 'contact_person',  'label' => 'Contact Person',           
        'type' => 'varchar',        
        'len' => '25',       
);

 


