<!DOCTYPE html>
<?php 
	include 'db.php';
	


?>	
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Import Target for IP Tracker</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Import Target for IP Tracker">

		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/bootstrap-responsive.min.css">
		<link rel="stylesheet" href="css/bootstrap-custom.css">


	</head>
	<body>    

	<!-- Navbar
    ================================================== -->

	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container"> 
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="#">Talentedge Import Target</a>
				
			</div>
		</div>
	</div>

	<div id="wrap">
	<div class="container">
		<div class="row">
			<div class="span3 hidden-phone"></div>
			<div class="span6" id="form-login">
                             <a href="actualupload.php">Actual</a> | <a href="targetupload.php">Target</a>
                            <form class="form-horizontal well" action="targetsave.php" method="post" name="upload_excel" enctype="multipart/form-data">
					<fieldset>
						<legend>Import CSV/Excel file</legend>
						<div class="control-group">
							<div class="control-label">
								<label>CSV/Excel File:</label>
							</div>
							<div class="controls">
								<input type="file" name="file" id="file" class="input-large">
							</div>
						</div>
						
						<div class="control-group">
							<div class="controls">
							<button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Upload</button>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
			<div class="span3 hidden-phone"></div>
		</div>
		

		<table class="table table-bordered" width="60%">
			<thead>
				  	<tr>
				  		<th>User ID</th>
				  		<th>User name</th>
                         <th>target_gsv</th>
                                                <th>target_unit</th>
                                       
				  	<th>batch_code</th>
                                       <th>month</th>
                                       <th>year</th>
                                       <th>target_pitched</th>
                                       <th>target_prospects</th>
                                       <th>conversion_rate</th>
                                       <th>connected_calls</th>
                                       <th>talk_time</th>
                                       <th>quality_score</th>
                                       <th>working_days</th>
				 										

				 
				  	</tr>	
				  </thead>
			<?php
				$SQLSELECT = "SELECT * FROM agent_productivity_report order by id DESC limit 3";
				$result_set =  mysqli_query($conn,$SQLSELECT);
				while($row = mysqli_fetch_array($result_set))
				{
				?>
			
					<tr>
						<td><?php echo $row['user_id']; ?></td>
						<td><?php echo $row['user_name']; ?></td>
						<td><?php echo $row['target_gsv']; ?></td>
						<td><?php echo $row['target_unit']; ?></td>
						<th><?php echo $row['batch_code']; ?></th>
                                       <th><?php echo $row['month']; ?></th>
                                       <th><?php echo $row['year']; ?></th>
                                       <th><?php echo $row['target_pitched']; ?></th>
                                       <th><?php echo $row['target_prospects']; ?></th>
                                       <th><?php echo $row['conversion_rate']; ?></th>
                                       <th><?php echo $row['connected_calls']; ?></th>
                                       <th><?php echo $row['talk_time']; ?></th>
                                       <th><?php echo $row['quality_score']; ?></th>
                                       <th><?php echo $row['working_days']; ?></th>
                                                
					</tr>
				<?php
				}
			?>
		</table>
	</div>

	</div>

	</body>
</html>