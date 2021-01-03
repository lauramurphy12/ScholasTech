<?php
session_start();
//If the cart is set and the cart is not empty
if(isset($_SESSION['cart']) && !empty($_SESSION["cart"])) {
	$num_of_items = array_sum($_SESSION["cart"]);
}
else{
	$num_of_items = 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>ScholasTech</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
</head>
<body>
	<!-- Navigation Bar -->
	<nav class="navbar navbar-expand navbar-light p-3" style="background-color: #ff0000;">
		<ul class="navbar-nav">
			<h1 style="color:white;"> ScholasTech </h1>
		</ul>
		<ul class="navbar-nav ml-auto">
			<li class="nav-item">
				<?php 
				if(isset($_SESSION['authenticated'])){
					if($_SESSION['usertype'] == "contact"){ ?>
					<h3><a class="nav-link" href="StudentProfile.php" style="color:white">Profile</a></h3>
				<?php 
					}
				} ?>
			</li>
			<li class="nav-item">
				<?php 
				if(isset($_SESSION['authenticated'])){
					if($_SESSION['usertype'] == "teacher"){ ?>
					<h3><a class="nav-link" href="StaffProfile.php" style="color:white">Profile</a></h3>
				<?php 
					}
				} ?>
			</li>
			<li class="nav-item">
				<h3><a class="nav-link" href="catalogSelection.php" style="color:white">Classes</a></h3>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="displayCart.php" style="color:white"><i class="fa fa-shopping-cart fa-3x" style="color:white"></i><?php echo " (" .$num_of_items .")";?></a>
			</li>
			<li class="nav-item">
				<?php if(isset($_SESSION['authenticated'])){ ?>
					<h3><a class="nav-link" a href="LogoutModal" data-toggle="modal" data-target="#logout" style="color:white">Logout</a></h3>
			   <?php   } 
					 else { ?>
						<a class="nav-link" href="login.html"><i class="fa fa-user fa-3x" style="color:white"></i></a>
				<?php
					 }
				?>
			</li>
		</ul>
	</nav>
	<br>
	<!-- Modal -->
	<div class="modal fade" id="logout" tabindex="-1" role="dialog" aria-labelledby="LogoutModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title" id="LogoutModalLongTitle">Logout</h3>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<h5>Are you sure you want to logout?</h5>
				</div>
				<div class="modal-footer">
					<form action="logout.php" method="post">
						<button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Close</button>
						<input type="submit" class="btn btn-lg btn-default" name="action" value="Logout"></input>
				  </form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
