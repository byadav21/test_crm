<?php 
global $db; 
$sessionIds=session_id();
$db->query("insert into session_call set session_id='" . $_REQUEST['crtObjectId'] ."', lead_id='".  $records['id']   ."', call_start='". date('Y-m-d H:i:s') . "'");
/*$obj=new te_neox_call_details();
if($_REQUEST['phone']) $obj->phone_number= $_REQUEST['phone'];
$obj->userid= $_REQUEST['crtObjectId'];
$obj->list_id=  $records['id'] ;
$obj->save();*/
?>
<style>
.col-sm-4,.row{overflow:hidden;display:block}.col-sm-4,.row,button{display:block}.row{width:750px;font-family:sans-serif}.col-sm-4{width:45%;float:left;font-size:14px}.overview{background:#F6F6F6;padding:12px;margin:25px 11px;border-radius:5px;color:#595959}button{background-color:#232c42;border-radius:4px;-moz-border-radius:4px;border:none;color:#fff;cursor:pointer;font-size:15px!important;padding:5px 8px;float:right}h2{margin:0 0 14px;font-weight:400;font-size:22px;color:#666;text-transform:uppercase;padding-top:5px}  
</style>

<body  >
<div class="row" style="width:780px;margin: 0 14px">	
	<h2> <?php echo $records['first_name'] . ' ' . $records['last_name'] ?> </h2>
    <hr>
</div>    
<div class="row overview" style="margin-top: 4px;">

	<div class="col-sm-4 rowpadd">
		<b class="name"><?php echo $records['first_name'] . ' ' . $records['last_name'] ?></b>
		<p># <?php echo $_REQUEST['phone'] ?> </p>
		<p><label>BATCH</label> : 
		<?php 
		
			$sql="SELECT te_ba_batch.name FROM `leads_cstm` inner join te_ba_batch on te_ba_batch.id=leads_cstm.`te_ba_batch_id_c` WHERE  `id_c`='".  $records['id'] ."'";
			$batchrs=$db->query($sql);
			$barches=$db->fetchByAssoc($batchrs);
			echo $barches['name'];
		 ?> 
		</p>
		
		
	</div>

	<div class="col-sm-4 rowpadd" style="float:right;text-align:right">
		<label>Status</label>: 
		<p style="color:limegreen;font-weight:bold;display:inline"> <?php echo $records['status'] ?></p>
		<p> <label>Status Detail  </label>: <?php echo $records['status_description'] ?></p>
		<a href="index.php?module=Leads&action=EditView&record=<?php echo $records['id']?>">  <button>Edit</button> </a>
		<a href="index.php?module=Leads&action=DetailView&record=<?php echo $records['id']?>">  <button>View Detail</button> </a>
	</div>
 
</div>
</body>
