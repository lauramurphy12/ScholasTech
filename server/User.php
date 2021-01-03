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
	
	public static function create(){
		$instance = new self();
		return $instance; 
	}
	public function setFirstName($par_firstname) {
		$validRegex = array("options"=>array("regexp"=>"/[\w'-]{2,20}/"));
		if(filter_var($par_firstname, FILTER_VALIDATE_REGEXP,$validRegex)){
			   $this->firstname= $par_firstname;
				return $this;
		}
		throw new Exception('invalid firstname');
    }
	public function setLastName($par_lastname) {
		$validRegex = array("options"=>array("regexp"=>"/[\w'-]{2,20}/"));
		if(!filter_var($par_lastname, FILTER_VALIDATE_REGEXP,$validRegex)){
			throw new Exception('invalid lastname');
		}
        $this->lastname = $par_lastname;
        return $this;
    }
	public function setAddress($par_address) {
        $this->address = $par_address;
        return $this;
    }
	public function setPhone($par_phone) {
		if(!preg_match("/\d{3}-\d{3}-\d{4}/", $par_phone)) {
			throw new Exception('invalid phone number');
		}
        $this->phone = $par_phone;
        return $this;
    }
	public function setEmail($par_email) {
		if(!filter_var($par_email, FILTER_VALIDATE_EMAIL)){
			throw new Exception('invalid email address');
		}
        $this->email = $par_email;
        return $this;
    }
	public function setUsertype($par_usertype) {
        $this->usertype = $par_usertype;
        return $this;
    }
	public function __toString()
    {
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
		$this->conn = $this->establishConnection();
		$pullUserSQL = $this->conn->prepare("SELECT * FROM User WHERE email = ?");
		$pullUserSQL->bind_param("s",$email);
		$pullUserSQL->execute();
		$result = $pullUserSQL->get_result();
		
		if($result!=null && $result->num_rows==1){
			return $result->fetch_assoc();
		}else{
			throw new Exception('Could not pull user info');
		}
	}
}