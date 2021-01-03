<?php
require_once("config.php");
require_once("dbConnection.php");
require_once("header.php");
?>

<!DOCTYPE html>
<html lang="en">
	<head>
	  <title>ScholasTech</title>
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	  <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
	  <style>
		.card {
			border-radius: 10px;
			float: none; 
			margin-top: 100px;
			margin-bottom: 10px; 
		}
		&-body {
			text-align: center;
		}

	  </style>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<div class="card text-center">
						<div class="card-header">
						<h3><b>Fall Classes</b></h3>
						</div>
						<img src="./photos/fall.jpg" class="card-img-top" alt="...">
						<div class="card-body">
							<a href="fallCatalog.php" class="btn btn-primary">View</a>
						</div>
						<div class="card-footer text-muted">
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="card text-center">
						<div class="card-header">
						 <h3><b>Winter Classes</b></h3>
						</div>
						<img src="./photos/winter.jpg" class="card-img-top" alt="...">
						<div class="card-body">
							<a href="winterCatalog.php" class="btn btn-primary">View</a>
						</div>
						<div class="card-footer text-muted">
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="card text-center">
						<div class="card-header">
						<h3><b>Spring Classes</b></h3>
						</div>
						<img src="./photos/spring.jpg" class="card-img-top" alt="...">
						<div class="card-body">
							<a href="springCatalog.php" class="btn btn-primary">View</a>
						</div>
						<div class="card-footer text-muted">
						</div>
					</div>
				</div>
			</div>
	</body>
 </html>