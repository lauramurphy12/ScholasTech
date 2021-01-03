<?php
require_once("dbConnection.php");
session_start();
require_once("User.php");
require_once("Account.php");

class Registration extends dbConnection {
	private $firstname;
	private $lastname;
	private $usertype;
	private $email;
	private $address;
	private $phone;
	private $password;
	private $conn;
	
	function __construct(){
		
    }
	
	function getRegistrationInfo(){
		if(empty(trim($_POST['firstname'])) || empty(trim($_POST['lastname'])) || empty(trim($_POST['usertype'])) || empty(trim($_POST['phoneNumber'])) || empty(trim($_POST['address'])) || empty(trim($_POST['email'])) || empty(trim($_POST['password']))){
				header('Location: registerForm.html');
				exit('Please fill out the registration fields.');
		}else{
				$this->firstname = trim($_POST['firstname']);
				$this->lastname = trim($_POST['lastname']);
				$this->usertype = trim($_POST['usertype']);
				$this->phone = trim($_POST['phoneNumber']);
				$this->address = trim($_POST['address']);
				$this->email = trim($_POST['email']);
				$this->password = trim($_POST['password']);
		}
	}

	function createValidUser(){
		try{
			//instantiate user object with values from register form
			$registerUser = User::create()->setFirstName($this->firstname)->setLastName($this->lastname)->setUsertype($this->usertype)->setAddress($this->address)->setPhone($this->phone)->setEmail($this->email);
			return $registerUser;
		}catch (Exception $e){
			echo 'Caught exception: ',  $e->getMessage(), "\n";
			header('Location: registerForm.html');
			exit();
		}	
	}
	function insertUser($par_registerUser){
		try{
			$par_registerUser->pushUserInfo();
		}catch (Exception $e){
			echo 'Caught exception: ',  $e->getMessage(), "\n";
			header('Location: registerForm.html');
			exit();
		}	
	}
	function createUserAccount($userID){
		try{
			$userAccount = Account::create()->setHash($this->password);
			$accountAdded = $userAccount->pushAccountInfo($userID);
		}catch (Exception $e){
			echo 'Caught exception: ',  $e->getMessage(), "\n";
			header('Location: registerForm.html');
			exit();
		}	
	}
	function registerAccount(){
		$this->conn = $this->establishConnection();
		$validUser = $this->createValidUser();
		$this->insertUser($validUser);
		$registerUser = $validUser->pullUserInfoByEmail($this->email);
		$userID = intval($registerUser['id']);
		$this->createUserAccount($userID);
		//set usertype(parental guardian, admin, and instructor/staff) by id of user
		switch ($this->usertype) {
			case 'contact':
				$setGuardian = $this->conn->prepare("INSERT INTO Contact (guardian, user_id) VALUES (?, ?)");
				$setGuardian->bind_param('ii', $isGuardian=1, $userID);
				$setGuardian->execute();
				header('Location: login.html');
				exit();
			case 'teacher':
				$setTeacher = $this->conn->prepare("INSERT INTO Teacher(user_id) VALUES (?)");
				$setTeacher->bind_param('i', $userID);
				$setTeacher->execute();
				header('Location: login.html');
				exit();
			case 'admin':
				header('Location: login.html');
				exit();
			default:
				header('Location: registerForm.html');
				exit();
		}	
	}
	function registerUser(){
		$this->getRegistrationInfo();
		$this->registerAccount();
		$this->conn->close();				
	}			
}
$registration = new Registration();
$registration->registerUser();

?>

