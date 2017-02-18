<?php 
 //WARNING: The contents of this file are auto-generated

	
	 // created: 2016-09-15 13:52:52


	$dictionary['User']['fields']['user_access_type']['name']='user_access_type';
$dictionary['User']['fields']['user_access_type']['vname']='LBL_USERTYPE';
$dictionary['User']['fields']['user_access_type']['type']='enum';
$dictionary['User']['fields']['user_access_type']['options']='user_access_type_dom';
$dictionary['User']['fields']['user_access_type']['len']='100';
$dictionary['User']['fields']['user_access_type']['audited']='false';


 
 
 


 // created: 2016-11-03 22:50:53
$dictionary['User']['fields']['last_name']['inline_edit']=true;
$dictionary['User']['fields']['last_name']['merge_filter']='disabled';
$dictionary['User']['fields']['last_name']['required']=false;



$dictionary['User']['fields']['designation'] =array (
	'name' => 'designation',
	'vname' => 'LBL_DESIGNATION',
	'required' => false,
	'type' => 'enum',
	'importable' => 'true',
	'len' => 50,
	'size' => '20',
	'options' => 'designation_list',	
);


	
	 // created: 2016-09-15 13:52:52


	$dictionary['User']['fields']['neox_user']['name']='neox_user';
$dictionary['User']['fields']['neox_user']['vname']='LBL_NEOXUSER';
$dictionary['User']['fields']['neox_user']['type']='varchar';
$dictionary['User']['fields']['neox_user']['len']='100';
$dictionary['User']['fields']['neox_user']['audited']='false';


$dictionary['User']['fields']['neox_password']['name']='neox_password';
$dictionary['User']['fields']['neox_password']['type']='varchar';
$dictionary['User']['fields']['neox_password']['vname']='LBL_NEOXPASS';
$dictionary['User']['fields']['neox_password']['len']='100';
$dictionary['User']['fields']['neox_password']['audited']='false';

$dictionary['User']['fields']['neox_extension']['name']='neox_extension';
$dictionary['User']['fields']['neox_extension']['type']='varchar';
$dictionary['User']['fields']['neox_extension']['vname']='LBL_NEOXEXTENSION';
$dictionary['User']['fields']['neox_extension']['len']='100';
$dictionary['User']['fields']['neox_extension']['audited']='false';

 
 
 

?>
