<?php
require_once("config.php");
require_once("header.php");
require_once("Section.php");
require_once("Teacher.php");
$Section = new Section();
?>

<!DOCTYPE html>
<html>
<head>
<style>
.container{
	margin-top: 60px;	
}
</style>
</head>
<body>
	<div class="container">
		<table class="table table-hover">
			<thead>
				<tr>
					<th scope="col">Section ID</th>
					<th scope="col">Title</th>
					<th scope="col">Semester</th>
					<th scope="col">Location</th>
					<th scope="col">Day</th>
					<th scope="col">Start</th>
					<th scope="col">End</th>
					<th scope="col">Available Spots</th>
				</tr>
			</thead>
			<tbody>
			<!-- Retrieve all course sections by instructor  -->
			<?php
			$teacher = new Teacher();
			$getTeacher = $teacher->pullTeacherInfo($_SESSION["userID"]);
			$teacher = $getTeacher->fetch_assoc();
			//pull course section details by assigned instructor 
			$classSections = $Section->pullSectionByTeacher($teacher["id"]);
			if (!empty($classSections)){
				while($section = $classSections->fetch_assoc()){
					//get class details associated with current section
					$class = $Section->pullClassBySection($section['class_id']);
					$currClass = $class->fetch_assoc();
					?>
					<tr>
						<th scope="row"><?php echo $section['id'];?></th>
						<td><?php echo $currClass['title'];?></td>
						<td><?php echo $section['semester'];?></td>
						<td><?php echo $section['location'];?></td>
						<td><?php echo $section['day'];?></td>
						<td><?php echo $section['start_time'];?></td>
						<td><?php echo $section['end_time'];?></td>
						<td><?php echo $section['availability'];?></td>
					</tr>
			<?php
				}
			}
			?>
			</tbody>
		</table>
	</div>
</body>
</html>