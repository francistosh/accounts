<!DOCTYPE html>

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<meta name="keywords" content="Anjuman-e-Burhani,Dawoodi,Bohra,Community,Mombasa,jamaat">
		<meta name="description" content="A Non-Profit Corporation administering & managing the affairs of the Dawoodi Bohra Community of Mombasa">
		<link rel="icon" href="images/favicon.ico">
		
	   <title>Anjuman-e-Burhani | MSA</title>
		<?php include 'links.php';
        ?>
		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/main.css" rel="stylesheet">
		
		<script>
		$(document).ready(function(){
				  var options={
			format: 'dd/mm/yyyy',
			todayHighlight: true,
			autoclose: true,
		  };
		  $(".date").datepicker(options);
		  $("#tabs").tabs();
		  $("detname").val($("#name").html());
		</script>
	</head>
	<body>
	<div class="container">
		<img src="images/logo.png" class="logo">
		<div class="row main">
			<div class="row top">
				<div class="col-md-3">
					<p>You are logged in as Admin</p>
				</div>	
			</div>
			<div class="col-md-2 menu">
				<div class="title">
					<center><strong><p>Menu</p></strong></center>
				</div>
				<a href="reports.php" style="text-decoration:none;">
					<div class="link">
					<center><p><b>Back</b></p></center>
					</div>
				</a>
				<a href="reports.php" style="text-decoration:none;">
					<div class="link">
					<center><p><b>Home</b></p></center>
					</div>
				</a>
			</div>
			<div class="col-md-10 reports">
				<div class="title">
					<strong><p>Database</p></strong>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="checkbox">
						  <label>
							<input type="checkbox" value="" style="margin-top:8px">
							<p class="p">Financial Reports</p>
						  </label>
						</div>
						<div class="tick">
							<div class="checkbox">
							  <label>
								<input type="checkbox" value="">
								<p> Reports</p>
							  </label>
							</div>
							<div class="checkbox">
							  <label>
								<input type="checkbox" value="">
								<p> Reports</p>
							  </label>
							</div>
							<div class="checkbox">
							  <label>
								<input type="checkbox" value="">
								<p> Reports</p>
							  </label>
							</div>
						</div>	
					</div>
					<div class="col-md-6">
						<div class="checkbox">
						  <label>
							<input type="checkbox" value="" style="margin-top:8px">
							<p class="p">Statistical Reports</p>
						  </label>
						</div>
						<div class="tick">
							<div class="checkbox">
							  <label>
								<input type="checkbox" value="">
								<p> Reports</p>
							  </label>
							</div>
							<div class="checkbox">
							  <label>
								<input type="checkbox" value="">
								<p> Reports</p>
							  </label>
							</div>
							<div class="checkbox">
							  <label>
								<input type="checkbox" value="">
								<p> Reports</p>
							  </label>
							</div>
						</div>	
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<label class="control-label" for="date">From</label>
						<input class="form-control date" id="anjuman_fromdate" name="date" placeholder="MM/DD/YYY" type="text" value="<?php echo date('d/m/Y');?>"/>
					</div>
					<div class="col-md-6">
						<label class="control-label" for="date">To</label>
						<input class="form-control date" id="anjuman_todate" name="date" placeholder="MM/DD/YYY" type="text" value="<?php echo date('d/m/Y');?>"/><br>
					</div>
				</div>	
				<button type="button" class="btn btn-default" id="anjumanok "aria-label="Left Align">Okay
					<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
				</button>                       
				<span id="anjumanloading" hidden>&nbsp;&nbsp;&nbsp;<img src="images/loading.gif"/> Please Wait</span>
			</div>
		</div>
		
		
	
		<footer class="footer">
			<br>
			<b>© JIMS <?php echo date('Y');?> - All Rights Reserved.</b>
		</footer>
	</div>
	
	</body>	
</html>	