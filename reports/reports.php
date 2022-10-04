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

		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/reports.css" rel="stylesheet">
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
					<a href="#" style="text-decoration:none;">
						<div class="link">
						<center><p><b>Back</b></p></center>
						</div>
					</a>
                                    <a href="../finance/" style="text-decoration:none;">
						<div class="link">
						<center><p><b>Accounts</b></p></center>
						</div>
					</a>
				</div>
				<div class="col-md-10 reports">
					<div class="title">
						<strong><p>Database</p></strong>
					</div>
						<a href="anjuman.php"><button type="button" class="btn btn-primary btn-lg" id="report1"><h4>Anjuman</h4></button></a>
						<a href="prop.php"><button type="button" class="btn btn-primary btn-lg" id="report2"><h4>Properties</h4></button></a>
						<a href="qardhan.php"><button type="button" class="btn btn-primary btn-lg" id="report3"><h4>Qardhan</h4></button></a>
						<a href="fmb.php"><button type="button" class="btn btn-primary btn-lg" id="report4"><h4>FMB</h4></button></a>
				</div>
			</div>
			<footer class="footer">
				<br>
				<b>© JIMS <?php echo date('Y');?> - All Rights Reserved.</b>
			</footer>
		</div>
	</body>	
</html>	