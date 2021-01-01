<?php
require_once("dbConnection.php");
require_once("config.php");
session_start();
require_once("Teacher.php");
?>

<?php
if(isset($_POST["update"])){
	$startDate = isset($_POST['startDate']) ? $_POST['startDate'] : null;
	$yearsTeaching = isset($_POST['yearsTeaching']) ? $_POST['yearsTeaching'] : null;
	$yearsTeaching = intval($yearsTeaching);
	$specialty = isset($_POST['specialty']) ? $_POST['specialty'] : null;
	$endDate = isset($_POST['endDate']) ? $_POST['endDate'] : null;
	$userID = $_SESSION['userID'];
	$teacher = (new Teacher())
                ->setStartDate($startDate)
                ->setYearsTeaching($yearsTeaching)
		->setSpecialty($specialty)
                ->setEndDate($endDate);
	if($teacher->pushTeacherInfo($userID)){
		header('Location: StaffProfile.php');
		exit();
	}else{
		header('Location: editStaffProfile.php');
		exit();
	}
}
