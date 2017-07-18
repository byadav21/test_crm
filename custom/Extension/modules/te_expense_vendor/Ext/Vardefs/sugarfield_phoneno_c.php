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



$dictionary['te_expense_vendor']['fields']['panpdf'] =array (
        'name' => 'panpdf',
        'label' => 'Pan Doc',
        'type' => 'file'        
        
);

$dictionary['te_expense_vendor']['fields']['staxpdf'] =array (
        'name' => 'staxpdf',
        'label' => 'Service Tax Doc',
        'type' => 'file'        
        
);

$dictionary['te_expense_vendor']['fields']['ccheckdoc'] =array (
        'name' => 'ccheckdoc',
        'label' => 'Cancled Check Doc',
        'type' => 'file'        
        
);

$dictionary['te_expense_vendor']['fields']['gstndoc'] =array (
        'name' => 'gstndoc',
        'label' => 'GSTN Doc',
        'type' => 'file'        
        
);

$dictionary['te_expense_vendor']['fields']['reg_cert'] =array (
        'name' => 'reg_cert',
        'label' => 'Registration Certificate',
        'type' => 'file'        
        
);

$dictionary['te_expense_vendor']['fields']['gst'] =array (
        'name' => 'gst',
        'label' => 'GST No',
        'type' => 'varchar',
       
        'len' => '40',
        
);


$dictionary['te_expense_vendor']['fields']['status'] =array (
        'name' => 'status',
        'label' => 'status',
        'type' => 'int',
         'default'=>1,
        'len' => '1',
        
);

 

$dictionary['te_expense_vendor']['fields']['reason_rejection'] =array (
        'name' => 'reason_rejection',  'label' => 'REject Reason',      
        'type' => 'varchar',        
        'len' => '255',       
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



$dictionary['te_expense_vendor']['fields']['glcode'] =array(
        'name' => 'glcode',  
        'label' => 'GL Code',      
        'type' => 'dynamicenum', 
         'dbType' => 'enum',
           'options' => 'list_glcode',
        'parentenum' => 'cost_center',       
        'len' => '255',       
);

$dictionary['te_expense_vendor']['fields']['cost_center'] =array(
	'name' => 'cost_center',
	'label' => 'Cost Center',
	'type' => 'enum',	
	'len' => '150',
        'size' => '20',
	'required' => false ,
	'options'=>'list_cost_center'
);



