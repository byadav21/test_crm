<?php
$dictionary['te_Expensepo_Vendor']['fields']['pancard_file_mime_type'] = array(

  'name' => 'pancard_file_mime_type',

  'vname' => 'LBL_PANCARD_FILE_MIME_TYPE',

  'type' => 'varchar',

  'len' => '100',

  'importable' => false,

);

$dictionary['te_Expensepo_Vendor']['fields']['pancard_file_url'] = array(

  'name'=>'pancard_file_url',

  'vname' => 'LBL_PANCARD_FILE_URL',

  'type'=>'function',

  'function_class'=>'UploadFile',

  'function_name'=>'get_upload_url',

  'function_params'=> array('$this'),

  'source'=>'function',

  'reportable'=>false,

  'importable' => false,

);

$dictionary['te_Expensepo_Vendor']['fields']['pancard_filename'] = array(

  'name' => 'pancard_filename',

  'vname' => 'LBL_PANCARD_FILENAME',

  'type' => 'file',

  'dbType' => 'varchar',

  'len' => '255',

  'reportable'=>true,

  'importable' => false,

);


$dictionary['te_Expensepo_Vendor']['fields']['servicetax_file_mime_type'] = array(

  'name' => 'servicetax_file_mime_type',

  'vname' => 'LBL_SERVICETAX_FILE_MIME_TYPE',

  'type' => 'varchar',

  'len' => '100',

  'importable' => false,

);

$dictionary['te_Expensepo_Vendor']['fields']['servicetax_file_url'] = array(

  'name'=>'servicetax_file_url',

  'vname' => 'LBL_SERVICETAX_FILE_URL',

  'type'=>'function',

  'function_class'=>'UploadFile',

  'function_name'=>'get_upload_url',

  'function_params'=> array('$this'),

  'source'=>'function',

  'reportable'=>false,

  'importable' => false,

);

$dictionary['te_Expensepo_Vendor']['fields']['servicetax_filename'] = array(

  'name' => 'servicetax_filename',

  'vname' => 'LBL_SERVICETAX_FILENAME',

  'type' => 'file',

  'dbType' => 'varchar',

  'len' => '255',

  'reportable'=>true,

  'importable' => false,

);

