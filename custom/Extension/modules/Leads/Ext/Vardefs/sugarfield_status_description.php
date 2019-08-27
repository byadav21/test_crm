<?php
 // created: 2016-09-15 13:52:20
$dictionary['Lead']['fields']['status_description']['inline_edit']=true;
$dictionary['Lead']['fields']['status_description']['comments']='Description of the status of the lead';
$dictionary['Lead']['fields']['status_description']['type']='enum';
$dictionary['Lead']['fields']['status_description']['len']='100';
$dictionary['Lead']['fields']['status_description']['options']='lead_status_details_custom_dom';
$dictionary['Lead']['fields']['status_description']['audited']='true';
$dictionary['Lead']['fields']['status_description']['default']='New Lead';
$dictionary['Lead']['fields']['status_description']['required']=true;

$dictionary['Lead']['fields']['status']['options']='lead_status_custom_dom';
$dictionary['Lead']['fields']['status']['default']='Alive';

$dictionary['Lead']['fields']['lead_source']['options']='lead_source_custom_dom';

$dictionary['Lead']['fields']['gender']['name']='gender';
$dictionary['Lead']['fields']['gender']['comments']='Gender of the status of the lead';
$dictionary['Lead']['fields']['gender']['type']='enum';
$dictionary['Lead']['fields']['gender']['vname']='Gender';
$dictionary['Lead']['fields']['gender']['len']='100';
$dictionary['Lead']['fields']['gender']['options']='gender_dom';
$dictionary['Lead']['fields']['gender']['audited']='false';


 ?>
 
 
