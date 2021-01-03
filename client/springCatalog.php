<?php
require_once("config.php");
require_once("dbConnection.php");
require_once("header.php");
require_once("classModel.php");
?>

<!DOCTYPE html>
<html lang="en">
	<head>
	  <title>ScholasTech</title>
	  <meta charset="utf-8">
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
			<!-- Retrieve all classes for the Spring Semester  -->
			<?php
			$class = new classModel();
			$springClasses = $class->getClassesBySemester('Spring');
			if (!empty($springClasses)){
				while($springClass = $springClasses->fetch_assoc()){	
			?>
					<div class="col-md-4">
						<div class="card text-center">
							<div class="card-header">
							<h3><b><?php echo $springClass['title'];?></b></h3>
							</div>
							<?php echo "<img class=\"card-img-top\" src=\"{$springClass['photo']}\" alt=\"Card image\">";?>
							<div class="card-body">
								<h1 class="card-title pricing-card-title" style="font-family: 	'Lato', sans-serif">$<?php echo($springClass['price']);?><small class="text-muted">/semester</small></h1>
								<br>
								<h1 style="font-family:'Lato', sans-serif"><?php echo($springClass['availability']);?><small class="text-muted"> open spots</small></h1>
							</div>
							<div class="card-footer text-muted">
								<!-- If spots are available in the class  -->
								<?php
								if($springClass['availability'] > 0){
								?>
								<!-- Add class from the current semester to shopping cart. Submit a post request to add class with the classID and the availability.-->
								<form action="cartController.php" method="post">
										<input type="hidden" name="classID" value="<?php echo $springClass['class_id'];?>">
										<input type="hidden" name="availability" value="<?php echo springClass['availability'];?>">
										 <input type="submit" class="btn btn-lg btn-block btn-primary" style="font-family: 'Lato', sans-serif" name="action" value="Add Spring Class"> 
								</form>
						<?php } ?>
							
							
							
							</div>
						</div>
					</div>
				<?php
				}
			}
				?>
			</div>
		</div>
	</body>
 </html>