<?php
require_once("config.php");
require_once("dbConnection.php");
session_start();
require_once("User.php");
require_once("Account.php");
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
	
	function pullUserInfo(){
		try{
			$user =User::create();
			$authUser =  $user->pullUserInfoByEmail($this->email);
			return $authUser;
		}catch (Exception $e){
			echo 'Caught exception: ',  $e->getMessage(), "\n";
			header('Location: registerForm.html');
			exit();
		}
	}
	
	function verifyAccount($par_AuthUser){
		try{
			$userAccount = Account::create();
			$accountDetails=$userAccount->pullAccountInfoByUser($par_AuthUser['id']);
			$passwordVerify=$userAccount->verifyPassword($this->password,$accountDetails['password_hash']);
			return $passwordVerify;
		}catch (Exception $e){
			echo 'Caught exception: ',  $e->getMessage(), "\n";
			header('Location: registerForm.html');
			exit();
		}	
	}
	
	function checkCredentials(){
		$this->conn = $this->establishConnection();
		$authUser = $this->pullUserInfo();
		$verifyPassword = $this->verifyAccount($authUser);
		if($verifyPassword){
			// create user session
			$this->establishSession($authUser);
		}else{
			header('Location: login.html');
			exit('Could not verify password you supplied');
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
		switch($_SESSION['usertype']){
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
