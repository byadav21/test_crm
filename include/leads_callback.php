<?php if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
if(isset($_REQUEST['redirect']) && !empty($_REQUEST['redirect']) && isset($_REQUEST['id']) && !empty($_REQUEST['id']) && isset($_REQUEST['lead_id']) && !empty($_REQUEST['lead_id'])){
	global $db;
	$id = $_REQUEST['id'];
	$lead_id = $_REQUEST['lead_id'];
	$call_backSql     = "UPDATE callback_log SET is_seen=1 WHERE id=$id";
	$call_backObj     = $db->query($call_backSql);
	header("Location: index.php?module=Leads&action=DetailView&record=$lead_id");
	die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"> 
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
<div class="container">

  <div class="panel panel-primary">
    <div class="panel-heading">Callback Remainder</div>
    <div class="panel-body">
	<p>Hi you have a callback schedule</p>
	<p><?php if(isset($_REQUEST['first_name']) && !empty($_REQUEST['first_name'])) echo $_REQUEST['first_name'];?></p>
	<p><?php if(isset($_REQUEST['callback_date_time']) && !empty($_REQUEST['callback_date_time'])) echo $_REQUEST['callback_date_time'];?></p>
    </div>
    <div class="panel-footer">
	<!--<button class="btn btn-danger" onClick="window.close();"><i class="fa fa-close"></i> Close</button>-->
	 <a href="index.php?entryPoint=leads_callback&redirect=true&id=<?php echo $_REQUEST['id']; ?>&lead_id=<?php echo $_REQUEST['lead_id']; ?>"><button class="btn btn-success"><i class="fa fa-check"></i> OK ,Redirect Me</button></a>
	</br>
    </div>
  </div>
</div>
</body>
</html>
