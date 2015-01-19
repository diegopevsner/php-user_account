<?php
/*****************************
	File: includes/functions.php
	Written by: Frost of Slunked.com
	Tutorial: User Registration and Login System
******************************/

/***********
	bool createAccount (string $pUsername, string $pPassword)
		Attempt to create an account for the passed in 
		username and password.
************/
function createAccount($pUsername, $pPassword) {
	
	
	global $connect;
	
	
	if (!empty($pUsername) && !empty($pPassword)) {
		$uLen = strlen($pUsername);
		$pLen = strlen($pPassword);
		
				
		
		$query = $connect->prepare("SELECT username FROM users WHERE username = 
     :esc LIMIT 1");
        $query->execute(array(':esc' =>$pUsername ));
		//$rowCount = $query->fetchColumn(0);
		$rowCount = $query->rowCount();
				
		
		if ($uLen <= 4 || $uLen >= 11) {
			$_SESSION['error'] = "Username must be between 4 and 11 characters.";
		}elseif ($pLen < 6) {
			$_SESSION['error'] = "Password must be longer then 6 characters.";
		}elseif ($rowCount  == 1) {
			$_SESSION['error'] = "Username already exists.";
		}else {
			
			
			
			$query = $connect->prepare("INSERT INTO users (`username`, `password`) VALUES (:esc,'" . hashPassword($pPassword, SALT1, SALT2) . "');");
        $query->execute(array(':esc' =>$pUsername ));
					
			
			
			if ($query) {
				return true;
			}	
		}
	}
	
	return false;
}

/***********
	string hashPassword (string $pPassword, string $pSalt1, string $pSalt2)
		This will create a SHA1 hash of the password
		using 2 salts that the user specifies.
************/
function hashPassword($pPassword,
 $pSalt1="2345#$%@3e", $pSalt2="taesa%#@2%^#") {
	return sha1(md5($pSalt2 . $pPassword . $pSalt1));
}

/***********
	bool loggedIn
		verifies that session data is in tack
		and the user is valid for this session.
************/
function loggedIn() {
	// check both loggedin and username to verify user.
	if (isset($_SESSION['loggedin']) &&
   isset($_SESSION['username'])) {
		return true;
	}
	
	return false;
}

/***********
	bool logoutUser 
		Log out a user by unsetting the session variable.
************/
function logoutUser() {
	// using unset will remove the variable
	// and thus logging off the user.
	unset($_SESSION['username']);
	unset($_SESSION['loggedin']);
	
	return true;
}

/***********
	bool validateUser
		Attempt to verify that a username / password
		combination are valid. If they are it will set
		cookies and session data then return true. 
		If they are not valid it simply returns false. 
************/
function validateUser($pUsername, $pPassword) {
	
	
	
	global $connect;
	
	
	// See if the username and password are valid.
	
	
	$query = $connect->prepare("SELECT username FROM users	WHERE username = :esc AND password = '" . hashPassword($pPassword, SALT1, SALT2) ."'  LIMIT 1");
       
     $query->execute(array(':esc' =>$pUsername ));
	 $rowCount = $query->rowCount();
		

	if ( $rowCount == 1) {
		$row = $query->fetch(PDO::FETCH_ASSOC);
		
		$_SESSION['username'] = $row['username'];
		$_SESSION['loggedin'] = true;	// If one row was returned
			
		return true;
	}
	
	
	return false;
}
?>