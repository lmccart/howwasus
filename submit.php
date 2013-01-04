
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php include('header.php'); ?>

<body>

Thank you for your feedback!

<?php echo $_SERVER['HTTP_HOST']; ?>


</body>
</html>



<?php
	//Start session
	session_start();
	
	
	
	//Include database connection details
	require_once('config.php');
	
	//Array to store validation errors
	$errmsg_arr = array();
	
	//Validation error flag
	$errflag = false;
	
	//Connect to mysql server
	$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
	if(!$link) {
		die('Failed to connect to server: ' . mysql_error());
	}
	
	//Select database
	$db = mysql_select_db(DB_DATABASE);
	if(!$db) {
		die("Unable to select database");
	}
	
	//Function to sanitize values received from the form. Prevents SQL injection
	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}
	
	//Sanitize the POST values
	$login = clean($_POST['login']);
	$password = clean($_POST['password']);
	
	//Input Validations
	if($login == '') {
		$errmsg_arr[] = 'Please enter username.';
		$errflag = true;
	}
	if($password == '') {
		$errmsg_arr[] = 'Please enter password.';
		$errflag = true;
	}
	
	//If there are input validations, redirect back to the login form
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		header("location: login-form.php");
		exit();
	}
	
	//Create query
	$qry="SELECT * FROM members WHERE login='$login' AND passwd='".md5($_POST['password'])."'";
	$result=mysql_query($qry);
	
	//Check whether the query was successful or not
	if($result) {
		if(mysql_num_rows($result) == 1) {
			//Login Successful
			session_regenerate_id();
			$member = mysql_fetch_assoc($result);
			$_SESSION['SESS_EMAIL'] = $member['email'];
			$_SESSION['SESS_FIRST_NAME'] = $member['firstname'];
			$_SESSION['SESS_LAST_NAME'] = $member['lastname'];
			$_SESSION['SESS_BIRTHYEAR'] = $member['birthyear'];
			$_SESSION['SESS_GENDER'] = $member['gender'];
			$_SESSION['SESS_ASKNUM'] = $member['asknum'];
			$_SESSION['SESS_ASKPERIOD'] = $member['askperiod'];
			$_SESSION['SESS_ASKSTART_HOUR'] = $member['askstart_hour'];
			$_SESSION['SESS_ASKEND_HOUR'] = $member['askend_hour'];
			$_SESSION['SESS_PRIVACY'] = $member['privacy'];
			$_SESSION['SESS_USERNAME'] = $member['login'];
			$_SESSION['SESS_CONTACTS'] = array();
			$contacts = unserialize($member['contacts']);
			foreach($contacts as $c){
				array_push($_SESSION['SESS_CONTACTS'], $c);
			}
			
			
			$_SESSION['SESS_WHO_VIEW'] = 'own';
			$_SESSION['SESS_WHO_ELSE_VIEW'] = 'none'; //nobody
			
			
			
			session_write_close();
			header("location: ./");
			exit();
		}else {
			//Login failed
			$errmsg_arr[] = 'Login ID and password don\'t match.';
			$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			session_write_close();
			header("location: login-form.php");
			exit();
		}
	}else {
		die("Query failed");
	}
?>
