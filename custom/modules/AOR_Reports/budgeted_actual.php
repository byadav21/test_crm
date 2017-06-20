<?php
/* This is Custom file  For Budgeted vs Compaign
 * Display menu from Action at Module te_budgeted campaign
 *  Created date -02-dec-2016 @Manish Gupta 9650211216
 * */
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');
	ini_set('display_errors','0');
	error_reporting(E_ALL);
	global $app_list_strings,$current_user,$sugar_config,$db;

?>

<html>
    <title>Budgeted Vs Actual Report</title>
  <head>
    <style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}
td, th {
    border-top: 1px solid #dddddd;
    border-bottom: 1px solid #dddddd;
    border-left: 1px solid #dddddd;
    border-right: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}
input[type=text], select {
    WIDTH: 132PX !IMPORTANT;
}
</style>
</head>
        <body>
            <section class="moduleTitle">
                <fieldset>
                    <form action="index.php?module=AOR_Reports&action=budgeted_actual&search_query=1" method="post" id="lead_trans">
                      <h2>Budgeted Vs Actual Report</h2><br/><br/>

                      <table>
						  <tr>
					<?php
            	     //@ Get All Batches for dropdown 1
							  $fetch="SELECT id,name FROM te_ba_batch WHERE batch_status='enrollment_in_progress' AND deleted=0";
                              $row =$db->query($fetch);?>

							  <td><b>Select Batch</b></td>
							   <td>
								   <!--onChange="this.form.submit()"-->
								  <select name="batch_val" id="batch_val">
								<option  value="">Select Batch</option>

									<?php while($records =$db->fetchByAssoc($row)){
									      //$_SESSION['name1']=$records['name'];

									 ?>
                                  <option  value="<?php echo $records['id']?>"><?php echo $records['name']?></option>
                                  <?php }?>
                                </select>
									</td>
										<td> <b>Select UTM</b> </td>
									<td>
								<select name="utm_val[]"  multiple id="utm_val"></select>
							    </td>
									<td><b>Select Week</b> </td>
								<td>
									<select name="week" id="week_val">
									<option value="">--Select Week--</option>
								<?php
								for($count = 1; $count<=52; $count++){

								?>
									<option  value="<?php echo $count;?>"><?php echo $count; ?></option>
								<?php  } ?>
                                </select></td>

							    </tr>
							    	<tr> <td align='center' style="border:none;"><input type="Submit" name="Submit" value="Find Report"></td>
							     </tr>
							     </table>
									</form>
										</fieldset>
										</section>


					<?php
						if(isset($_POST['Submit']) &&!empty($_POST['Submit'])) {
						extract($_POST);

					function getStartAndEndDate($week, $year)
					{

						$dates[0] = date("Y-m-d", strtotime($year.'W'.str_pad($week, 2, 0, STR_PAD_LEFT)));
	 				  $dates[1] = date("Y-m-d", strtotime($year.'W'.str_pad($week, 2, 0, STR_PAD_LEFT).' +6 days'));
	         return $dates;
					}


 //@Get Budgeted Lead,Coverted Lead,rate,volume,cpl,cpa,Conversion Rate,Volume,Cost by batch 9

									$where='';
									$whereActual='';
									$whereUtm='';
									$whereActual1='';

									if(count($_POST['utm_val'])>0 && !empty($_POST['week'])){
									 $where=' WHERE ';
									 $whereActual=' WHERE ';
									 $whereActual1=' WHERE';
									 $whereUtm = "'" . implode ( "', '",$_POST['utm_val']  ) . "'";
									 $where .= " te_utm.name IN($whereUtm)";
									 $whereActual .= " l.utm IN($whereUtm)";
									 $whereActual1 .=" t1.name IN($whereUtm)";
									 $weekdata=getStartAndEndDate($_POST['week'],date('Y'));
									 $where .=" AND t4.week='".$_POST['week']."'";
									 $whereActual .= " AND l.date_entered >= '".$weekdata[0]."' AND l.date_entered <= '".$weekdata[1]."'";
									 $whereActual1 .= " AND t3.plan_date >= '".$weekdata[0]."' AND t3.plan_date <= '".$weekdata[1]."'";
									}
									if(count($_POST['utm_val'])>0 && empty($_POST['week'])){
									 $where=' WHERE ';
									 $whereActual=' WHERE ';
									 $whereActual1=' WHERE';
									 $whereUtm = "'" . implode ( "', '",$_POST['utm_val']  ) . "'";
									 $where .= " te_utm.name IN($whereUtm)";
									 $whereActual .= " l.utm IN($whereUtm)";
									 $whereActual1 .=" t1.name IN($whereUtm)";
									}
									if(!empty($_POST['week']) && count($_POST['utm_val'])==0){
									 $where=' WHERE ';
									 $whereActual=' WHERE ';
									 $whereActual1=' WHERE';
									 $weekdata=getStartAndEndDate($_POST['week'],date('Y'));
									 $where .="  t4.week='".$_POST['week']."'";
									 $whereActual .= "  l.date_entered >= '".$weekdata[0]."' AND l.date_entered <= '".$weekdata[1]."'";
									 $whereActual1 .= "  t3.plan_date >= '".$weekdata[0]."' AND t3.plan_date <= '".$weekdata[1]."'";

									}

													$query9="SELECT sum(t4.leads)leads,sum(t4.conversion)conversion,sum(t4.conversion_rate)conversion_rate,sum(t4.clp)cpl,sum(t4.cpa)cpa,sum(t4.volume)volume,sum(t4.cost)cost FROM `te_ba_batch` INNER JOIN te_utm on te_utm.te_ba_batch_id_c=te_ba_batch.id AND te_ba_batch.id='".$_REQUEST['batch_val']."' AND te_utm.utm_status='Live'INNER JOIN te_utm_te_budgeted_campaign_1_c AS t3 on t3.te_utm_te_budgeted_campaign_1te_utm_ida=te_utm.id
													INNER JOIN te_budgeted_campaign AS t4 on t4.id=t3.te_utm_te_budgeted_campaign_1te_budgeted_campaign_idb AND t4.deleted=0 $where";
													$row9 =$db->query($query9);
													$reco9 =$db->fetchByAssoc($row9);


						//@Get Actual Lead,Converted Lead Based on Batch 3

										  $query3="SELECT count(l.id)total_leads,count(l2.id)converted FROM leads l inner join leads_cstm lc ON l.id = lc.id_c AND lc.te_ba_batch_id_c='".$_REQUEST['batch_val']."' AND  l.status IN('Alive','Warm','Duplicate','Dead','Converted','Dropout') AND l.deleted=0 left join leads l2 on l2.id=l.id AND l2.status='Converted' AND l2.deleted=0 $whereActual";
                                        $row3 =$db->query($query3);
            	                        $reco3 =$db->fetchByAssoc($row3);

									//	echo "Total Leads".$reco3['total_leads'].'<br>';
										//echo "Total Converted".$reco3['converted'];

						//@Get Actual Rate,Volume,Total Cost 4

										$query4="SELECT sum(t3.rate)rate,sum(t3.volume)volume,sum(t3.total_cost)total_cost FROM `te_ba_batch` INNER JOIN te_utm t1 on t1.te_ba_batch_id_c=te_ba_batch.id AND te_ba_batch.id='".$_REQUEST['batch_val']."'AND t1.utm_status='Live' INNER JOIN te_utm_te_actual_campaign_1_c AS t2 on t2.te_utm_te_actual_campaign_1te_utm_ida=t1.id INNER JOIN te_actual_campaign as t3 on t3.id=t2.te_utm_te_actual_campaign_1te_actual_campaign_idb AND t3.deleted=0 AND t3.type='paid' $whereActual1";
                                        $row4 =$db->query($query4);
            	                        $reco4 =$db->fetchByAssoc($row4);
            	                        $cpl = $reco4['total_cost']/$reco3['total_leads'];
            	                        $cpa= $reco4['total_cost']/$reco3['converted'];
            	                        $cr= $reco3['converted']/$reco3['total_leads']*100;
										// echo "Rate".'<b>'.$reco4['rate'].'<br>';
										// echo "Volume".$reco4['volume'].'<br>';
										// echo "Cost".$reco4['total_cost'].'<br>';

	         $fetcht="SELECT id,name FROM te_ba_batch WHERE batch_status='enrollment_in_progress' And id='".$_REQUEST['batch_val']."'";
             $rowfill =$db->query($fetcht);
             $filler =$db->fetchByAssoc($rowfill);
             if(empty($filler['name'])){

				 //echo "<h3><b> Please Select Batch</h3></b>";
		 echo '<script>';
         echo "alert('Please Select Batch')";
         echo '</script>';
				 }
				 else{
						echo " Search Result For Batch-:<h3><b> ".$filler['name']."</h3></b>";

	if(count($_POST['utm_val'])>0){

	echo "UTM-<h3><b>".str_replace("'","",$whereUtm)."</h3></b>";
}
?>

	<table width="100%" style="padding:0px;" border="0" cellpadding="0" cellspacing="0">

  <tr>
    <td style="border:0px; padding:0px;"  valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <th>&nbsp;</th>
      </tr>
      <tr>
        <th>Lead</th>
      </tr>
      <tr>
        <th>Conversion</th>
      </tr>
      <tr>
        <th>CPL</th>
      </tr>
      <tr>
        <th>CPA</th>
      </tr>
      <tr>
        <th>Conversion Rate(%)</th>
      </tr>
      <tr>
        <th>Total Cost</th>
      </tr>
      <tr>
        <th>Volume</th>
      </tr>

    </table></td>

    <td style="border:0px; padding:0px;" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <th>Budgeted</th>
      </tr>
      <tr>
        <td style="padding:0px;  border:0px;"  ><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td><?php if($reco9['leads']==''){
				echo 0;} else { echo round($reco9['leads']); } ?>&nbsp;</td>
          </tr>
          <tr>
            <td><?php if($reco9['conversion']==''){echo 0;}else {echo round($reco9['conversion']);}?>&nbsp;</td>
          </tr>
					
          <tr>
            <td><?php if($reco9['cost']=='' || $reco9['leads']==''){echo 0;}else {echo round($reco9['cost']/$reco9['leads'],2);}?>&nbsp;</td>
          </tr>
          <tr>
            <td><?php if($reco9['cost']=='' || $reco9['conversion']==''){echo 0;}else { echo round($reco9['cost']/$reco9['conversion'],2);}?>&nbsp;</td>
          </tr>
          <tr>
						<td><?php if($reco9['leads']=='' || $reco9['conversion']==''){echo 0;}else {echo round(($reco9['conversion']/$reco9['leads'])*100,2);}?>&nbsp;</td>

          </tr>
          <tr>
            <td><?php if($reco9['cost']==''){echo 0;} else{echo round($reco9['cost'],2);}?>&nbsp;</td>
          </tr>
          <tr>
            <td><?php if($reco9['volume']==''){echo 0;}else {echo round($reco9['volume'],2);}?>&nbsp;</td>
          </tr>

        </table></td>
      </tr>
    </table></td>
    <td valign="top" style="padding:0px; border:0px;" ><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <th>Actual</th>
      </tr>
      <tr>

        <td  valign="top" style="padding:0px; border:0px;" ><table width="100%" border="0" cellpadding="0" cellspacing="0">

          <tr>
           <td><?php if($reco3['total_leads']==''){echo 0;} else {echo $reco3['total_leads'];}?>&nbsp;</td>
          </tr>
          <tr>
           <td><?php if($reco3['converted']==''){echo 0;} else {echo $reco3['converted'];}?>&nbsp;</td>
          </tr>
          <tr>
            <td><?php if($cpl){echo round($cpl,2);}else{echo '0.00';}?>&nbsp;</td>
          </tr>
          <tr>
            <td><?php if($cpa){echo round($cpa,2);}else{echo '0.00';}?>&nbsp;</td>
          </tr>
          <tr>
            <td><?php if($cr){echo round($cr,2);}else{echo '0.00';}?>&nbsp;</td>
          </tr>
          <tr>
            <td><?php if($reco4['total_cost']==''){ echo 0;} else {echo round($reco4['total_cost'],2);}?>&nbsp;</td>
          </tr>
            <tr>
            <td><?php if($reco4['volume']==''){ echo 0;} else {echo round($reco4['volume'],2);}?>&nbsp;</td>
          </tr>

        </table></td>
      </tr>
    </table></td>
  </tr>
</table>


	<?php
  }
    }

	?>

	<script>
$(function(){
	$("#batch_val").change(function(){
		$("#utm_val").html('');
		if($(this).val()!=''){
			$.ajax({url: "index.php?entryPoint=budgtedvsactual&batch_val="+$(this).val()+"", success: function(result){
				var result = JSON.parse(result);
				if(result.status=='ok'){
				var utm='';
				 for(var i=0;i<result.res.length;i++){
						var id = result.res[i].id;
						var name = result.res[i].name;
						utm+='<option value="'+name+'">'+name+'</option>'
				 }
				 $("#utm_val").html(utm);
				}
			}});
		}
	});
});
</script>
			</body>
					</html>
