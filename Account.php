<?php
require_once("dbConnection.php");
?>

<?php
class Account extends dbConnection {
	private $hashPass;
	private $conn; 
	
	function __construct(){
	}
	
	public static function create(){
		$instance = new self();
		return $instance; 
	}
	
	public function setHash($par_pass) {
		//hash password using the bcrypt hashing function
		$this->hashPass = password_hash($par_pass, PASSWORD_BCRYPT);
		return $this;
    }
	
	public function verifyPassword($password, $pass_hash){
		return password_verify($password, $pass_hash);
	}
	
	public function pushAccountInfo($userID){
		$this->conn = $this->establishConnection();
		$pushAccountSQL = $this->conn->prepare("INSERT INTO Account (password_hash, user_id) VALUES (?,?)");
		$pushAccountSQL->bind_param('si',$this->hashPass, $userID);
		$accountAdded = $pushAccountSQL->execute();
		if(!$accountAdded){
			throw new Exception('Could not add account data');
		}
		return $accountAdded;
	}
	
	public function pullAccountInfoByUser($userID){
		$this->conn = $this->establishConnection();
		$pullAccountSQL = $this->conn->prepare("SELECT password_hash FROM Account WHERE user_id = ?");
		$pullAccountSQL->bind_param("i",$userID);
		$pullAccountSQL->execute();
		$result = $pullAccountSQL->get_result();
		if($result!=null){
			return $result->fetch_assoc();
		}else{
			throw new Exception('Could not pull account info');
		}
	}	
}