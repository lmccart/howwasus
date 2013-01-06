<?php
	
	//Include database connection details
	require_once('config.php');
	
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
	
	$host = $_SERVER['HTTP_HOST'];
	$my_rate = 0;
	if ($host == "howwas.us") $my_rate = 5;
	else if ($host == "review.howwas.us") $my_rate = 4;
	else if ($host == "rate.howwas.us") $my_rate = 3;
	else if ($host == "eval.howwas.us") $my_rate = 2;
	else if ($host == "feedback.howwas.us") $my_rate = 1;
	 
	$their_rate = $_POST['their_rate'];
	$their_predicted_rate = $_POST['their_predicted_rate'];
	$description = clean($_POST['description']);
	

	//Create INSERT query
	$qry = "INSERT INTO ratings(my_rate, their_rate, their_predicted_rate, description) VALUES('$my_rate', '$their_rate', '$their_predicted_rate', '$description')";
	$result = mysql_query($qry);
	
	
	//Check whether the query was successful or not
	if($result) {
		header("location: ./thankyou.php");
	}else {
		die("Query failed");
	}
?>
