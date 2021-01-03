 <?php
require_once("config.php");
require_once("header.php");
?>

<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
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
							<h3><b>Edit Profile</b></h3>
						</div>
						<div class="card-body">
							<a href="editStaffProfile.php" class="btn btn-primary">Update</a>
						</div>
						<div class="card-footer text-muted">
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="card text-center">
						<div class="card-header">
						 <h3><b>Your Classes</b></h3>
						</div>
						<div class="card-body">
							<a href="classList.php" class="btn btn-primary">View</a>
						</div>
						<div class="card-footer text-muted">
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="card text-center">
						<div class="card-header">
						<h3><b>Class Rosters</b></h3>
						</div>
						<div class="card-body">
							<a href="classRoster.php" class="btn btn-primary">View</a>
						</div>
						<div class="card-footer text-muted">
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html> 