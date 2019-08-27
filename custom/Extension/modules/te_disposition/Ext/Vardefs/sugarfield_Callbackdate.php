<?php
 // created: 2016-09-15 13:52:52
$dictionary['te_disposition']['fields']['date_of_callback']['name']='date_of_callback';
$dictionary['te_disposition']['fields']['date_of_callback']['vname']='LBL_DATEOFCALLBACK';
$dictionary['te_disposition']['fields']['date_of_callback']['type']='datetimecombo';
$dictionary['te_disposition']['fields']['date_of_callback']['dbType']='datetime';
$dictionary['te_disposition']['fields']['date_of_callback']['enable_range_search']=true;
$dictionary['te_disposition']['fields']['date_of_callback']['options']='date_range_search_dom';



$dictionary['te_disposition']['fields']['date_of_followup']['name']='date_of_followup';
$dictionary['te_disposition']['fields']['date_of_followup']['vname']='LBL_DATEOFFOLLOWUP';
$dictionary['te_disposition']['fields']['date_of_followup']['type']='datetimecombo';
$dictionary['te_disposition']['fields']['date_of_followup']['dbType']='datetime';
$dictionary['te_disposition']['fields']['date_of_followup']['enable_range_search']=true;
$dictionary['te_disposition']['fields']['date_of_followup']['options']='date_range_search_dom';


$dictionary['te_disposition']['fields']['date_of_prospect']['name']='date_of_prospect';
$dictionary['te_disposition']['fields']['date_of_prospect']['vname']='LBL_DATEOFPROSPECT';
$dictionary['te_disposition']['fields']['date_of_prospect']['type']='datetimecombo';
$dictionary['te_disposition']['fields']['date_of_prospect']['dbType']='datetime';
$dictionary['te_disposition']['fields']['date_of_prospect']['enable_range_search']=true;
$dictionary['te_disposition']['fields']['date_of_prospect']['options']='date_range_search_dom';


$dictionary['te_disposition']['fields']['unique_call_id']['name']='unique_call_id';
$dictionary['te_disposition']['fields']['unique_call_id']['vname']='LBL_UNIQUECALLID';
$dictionary['te_disposition']['fields']['unique_call_id']['type']='varchar';
$dictionary['te_disposition']['fields']['unique_call_id']['dbType']='varchar';
$dictionary['te_disposition']['fields']['unique_call_id']['len']='100';
$dictionary['te_disposition']['fields']['unique_call_id']['audited']='false';

/*
$dictionary['te_disposition']['fields']['dispositionName']['name']='dispositionName';
$dictionary['te_disposition']['fields']['dispositionName']['vname']='LBL_Disposition_Name';
$dictionary['te_disposition']['fields']['dispositionName']['type']='varchar';
$dictionary['te_disposition']['fields']['dispositionName']['dbType']='varchar';
$dictionary['te_disposition']['fields']['dispositionName']['len']='100';
$dictionary['te_disposition']['fields']['dispositionName']['audited']='false';

$dictionary['te_disposition']['fields']['callType']['name']='callType';
$dictionary['te_disposition']['fields']['callType']['vname']='LBL_Call_Type';
$dictionary['te_disposition']['fields']['callType']['type']='varchar';
$dictionary['te_disposition']['fields']['callType']['dbType']='varchar';
$dictionary['te_disposition']['fields']['callType']['len']='150';
$dictionary['te_disposition']['fields']['callType']['audited']='false';
*/
$dictionary['te_disposition']['fields']['dispositionname']['name']='dispositionname';
$dictionary['te_disposition']['fields']['dispositionname']['vname']='LBL_Disposition_Name';
$dictionary['te_disposition']['fields']['dispositionname']['type']='varchar';
$dictionary['te_disposition']['fields']['dispositionname']['dbType']='varchar';
$dictionary['te_disposition']['fields']['dispositionname']['len']='100';
$dictionary['te_disposition']['fields']['dispositionname']['audited']='false';

$dictionary['te_disposition']['fields']['calltype']['name']='calltype';
$dictionary['te_disposition']['fields']['calltype']['vname']='LBL_Call_Type';
$dictionary['te_disposition']['fields']['calltype']['type']='varchar';
$dictionary['te_disposition']['fields']['calltype']['dbType']='varchar';
$dictionary['te_disposition']['fields']['calltype']['len']='150';
$dictionary['te_disposition']['fields']['calltype']['audited']='false';

$dictionary['te_disposition']['fields']['attempt_count']['name']='attempt_count';
$dictionary['te_disposition']['fields']['attempt_count']['vname']='LBL_Attempt_Count';
$dictionary['te_disposition']['fields']['attempt_count']['type']='varchar';
$dictionary['te_disposition']['fields']['attempt_count']['dbType']='varchar';
$dictionary['te_disposition']['fields']['attempt_count']['len']='10';
$dictionary['te_disposition']['fields']['attempt_count']['audited']='false';

$dictionary['te_disposition']['fields']['status']['required']=true;
$dictionary['te_disposition']['fields']['status']['options']='lead_status_custom_dis_dom';
$dictionary['te_disposition']['fields']['status_detail']['options']='lead_status_details_custom_dis_dom';
 ?>
 
 
