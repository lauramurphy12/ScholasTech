<?php
require_once("config.php");
require_once("dbConnection.php");
session_start();
require_once("User.php");
?>

<?php
$_SESSION['authenticated']='';
$_SESSION['userID'] = '';
$_SESSION['usertype'] = '';
$_SESSION['email'] = '';

class Authentication extends dbConnection {
	private $email;
	private $password;
	private $conn;
	
	function __construct() {
		$this->conn = $this->establishConnection();
    	}
	
	function getLoginInfo(){
		if(empty(trim($_POST['email'])) && empty(trim($_POST['password']))){
			header('Location: login.html');
			exit('Please fill out the email and password fields.');
		}else{
			$this->email = trim($_POST['email']);
			$this->password = trim($_POST['password']);
			
		}
	}
	function checkCredentials(){
		//Check if email address exists, if yes verify password
		$user = new User();
		$userDetails =  $user->pullUserInfoByEmail($this->email);
		$uniqueRecords = $userDetails->num_rows;
		if($uniqueRecords == 1){
			$authUser = $userDetails->fetch_assoc();
			//get password hash from user account
			$getHash = $this->conn->prepare("SELECT password_hash FROM Account WHERE user_id = ?");
			$getHash->bind_param("i",$authUser['id']);
			$getHash->execute();
			$hash = $getHash->get_result();
			$account = $hash->fetch_assoc();
			//verify the submitted password from login matches the stored hash
			$verify = password_verify($this->password, $account['password_hash']);
			if($verify){
				// create user session
				$this->establishSession($authUser);
			}else{
				header('Location: login.html');
				exit('Could not verify password you supplied');
			}
		}
	}
	function establishSession($authUser){
		//store user information in session variables
		$_SESSION['userID'] = $authUser['id'];
		$_SESSION['email'] = $authUser['email'];
		$_SESSION['usertype'] = $authUser['usertype'];
		$_SESSION['authenticated'] = TRUE;
	}
	function redirectView(){
		switch ($_SESSION['usertype']) {
			// redirect to Student Profile view
			case 'contact':
				header("Location: " ."StudentProfile.php?" .SID );
				exit();
			// redirect to Staff/Instructor view
			case 'teacher':
				header("Location: " ."StaffProfile.php?" .SID );
				exit();
			case 'admin':
			// redirect to Administrator View
				header("Location: " ."adminDashboard.php?" .SID );
				exit();
			default
		}
	}
	function login(){	
		$this->getLoginInfo();
		$this->checkCredentials();
		$this->redirectView();
		$this->conn->close();
	}			
}
$authenticate = new Authentication();
$authenticate->login();
?>
