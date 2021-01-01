<?php
require_once("dbConnection.php");
?>

<?php
class Teacher extends dbConnection {
	private $startDate;
	private $yearsTeaching;
	private $specialty;
	private $endDate;
	private $conn; 

	function __construct(){
		
	}
	public function setStartDate($startDate) {
        	$this->startDate= $startDate;
        	return $this;
    	}
	public function setYearsTeaching($yearsTeaching) {
        	$this->yearsTeaching = $yearsTeaching;
        	return $this;
    	}
	public function setSpecialty($specialty) {
        	$this->specialty = $specialty;
        	return $this;
    	}
	public function setEndDate($endDate) {
        	$this->endDate = $endDate;
        	return $this;
    	}
	public function __toString(){
        	$teacherInfo = 'Start Date: ' . $this->startDate . PHP_EOL;
        	$teacherInfo .= 'Years Teaching: ' . $this->yearsTeaching . PHP_EOL;
        	$teacherInfo .= 'Specialty: ' . $this->specialty . PHP_EOL;
		$teacherInfo .= 'End Date: ' . $this->endDate . PHP_EOL;
        	return $teacherInfo;
    	}
	public function pushTeacherInfo($userID){
		$this->conn = $this->establishConnection();
		$updateTeacherSQL = $this->conn->prepare("UPDATE Teacher SET start_date= ?, years_teaching= ?, specialty= ?, end_date= ? WHERE user_id=?");
		$updateTeacherSQL->bind_param('sissi',$this->startDate, $this->yearsTeaching, $this->specialty, $this->endDate, $userID);
		$isUpdated = $updateTeacherSQL->execute();
		if(!$isUpdated){
			throw new Exception('Could not update teacher credentials');
		}
		return $isUpdated;
	}
	public function pullTeacherInfo($userID){
		$this->conn = $this->establishConnection();
		$pullTeacherSQL = $this->conn->prepare("SELECT * FROM Teacher WHERE user_id = ?");
		$pullTeacherSQL->bind_param("i",$userID);
		$pullTeacherSQL->execute();
		$result = $pullTeacherSQL->get_result();
		if($result!=null){
			return $result;
		}else{
			throw new Exception('Could not pull teacher credentials');
		}
	}	
}
