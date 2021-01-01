<?php
require_once("dbConnection.php");
?>

<?php
class User extends dbConnection {
	private $firstname;
	private $lastname;
	private $usertype;
	private $address;
	private $phone;
	private $email;
	private $conn; 
	
	function __construct(){
	}
	
	public function setFirstName($par_firstname) {
        	$this->firstname= $par_firstname;
        	return $this;
        }
	public function setLastName($par_lastname) {
        	$this->lastname = $par_lastname;
        	return $this;
   	}
	public function setAddress($par_address) {
        	$this->address = $par_address;
        	return $this;
    	}
	public function setPhone($par_phone) {
       		$this->phone = $par_phone;
        	return $this;
    	}
	public function setEmail($par_email) {
        	$this->email = $par_email;
       		return $this;
    	}
	public function setUsertype($par_usertype){
        	$this->usertype = $par_usertype;
        	return $this;
    	}
	public function __toString(){
       		$userInfo = 'First Name: ' . $this->firstname . PHP_EOL;
        	$userInfo .= 'Last Name: ' . $this->lastname . PHP_EOL;
        	$userInfo .= 'Address: ' . $this->address . PHP_EOL;
		$userInfo .= 'Phone: ' . $this->phone . PHP_EOL;
		$userInfo .= 'Email: ' . $this->email . PHP_EOL;
		$userInfo .= 'Type of User: ' . $this->usertype . PHP_EOL;
        	return $userInfo;
   	 }
	
	function pushUserInfo(){
		$this->conn = $this->establishConnection();
		$pushUserSQL = $this->conn->prepare("INSERT INTO User (first_name, last_name, address, phone_number, email, usertype) VALUES (?,?,?,?,?,?)");
		$pushUserSQL->bind_param('ssssss',$this->firstname, $this->lastname, $this->address, $this->phone, $this->email, $this->usertype);
		$userAdded = $pushUserSQL->execute();
		if(!$userAdded){
			throw new Exception('Could not add user');
		}
		return $userAdded;
	}
	
	function pullUserInfoByID($userID){
		$this->conn = $this->establishConnection();
		$pullUserSQL = $this->conn->prepare("SELECT * FROM User WHERE user_id = ?");
		$pullUserSQL->bind_param("i",$userID);
		$pullUserSQL->execute();
		$result = $pullUserSQL->get_result();
		if($result!=null){
			return $result;
		}else{
			throw new Exception('Could not pull user info');
		}
	}	
	function pullUserInfoByEmail($email){
		$pullUserSQL = $this->conn->prepare("SELECT * FROM User WHERE email = ?");
		$pullUserSQL->bind_param("s",$email);
		$pullUserSQL->execute();
		$result = $pullUserSQL->get_result();
		if($result!=null){
			return $result;
		}else{
			throw new Exception('Could not pull user info');
		}
	}
}
