<?php
	//See all errors and warnings
	 error_reporting(E_ALL);
	 ini_set('error_reporting', E_ALL);

	 include_once 'config.php';
	// //$mysqli = mysqli_connect("localhost", "u20422475", "jrvnghln", "u20422475");
	// $mysqli = mysqli_connect("localhost", "root", "", "u20422475");

	// $name = $_POST["fname"];
	// $surname = $_POST["lname"];
	// $email = $_POST["email"];
	// $date = $_POST["date"];
	// $pass = $_POST["pass"];

	// $query = "INSERT INTO users (name, surname, email, birthday, password) VALUES ('$name', '$surname', '$email', '$date', '$pass');";

	// $res = mysqli_query($mysqli, $query) == TRUE;

	$error_handler = '';
    $error_occured = false;
    $profile_image = 'none';
    $friends = 'none';
    $about_me = 'Click here to add information!';
    $requests = 'none';
    $work = 'Click here to add information!';
    $relationship = 'Rather not say';

	if(isset($_POST['submit'])){
        $name = $_POST['fname'];
        $surname = $_POST['lname'];
		$bDate = $_POST['date'];
        $email = $_POST['email'];
        $password = $_POST['pass'];
		$password2 = $_POST['pass2'];

        if(empty($_POST['fname'])){
            $error_handler = $error_handler . 'emptyname';
            header("location: index.php?error=" . $error_handler);
            $error_occured = true;
        }

        if(empty($_POST['lname'])){
            $error_handler = $error_handler . 'emptysurname';
            header("location: index.php?error=" . $error_handler);
            $error_occured = true;
        }

		if(empty($_POST['date'])){
            $error_handler = $error_handler . 'emptydate';
            header("location: index.php?error=" . $error_handler);
            $error_occured = true;
        }

        if(empty($_POST['email'])){
            $error_handler = $error_handler . 'emptyemail';
            header("location: index.php?error=" . $error_handler);
            $error_occured = true;
        }

        if(empty($_POST['pass'])){
            $error_handler = $error_handler . 'emptypassword';
            header("location: index.php?error=" . $error_handler);
            $error_occured = true;
        }

		if(empty($_POST['pass2'])){
            $error_handler = $error_handler . 'emptypassword2';
            header("location: index.php?error=" . $error_handler);
            $error_occured = true;
        }

        if(!preg_match("/^([\.\_a-zA-Z0-9]+)@([a-zA-Z]+)\.([a-zA-Z]){2,8}$/", $email) AND !preg_match("/^([\.\_a-zA-Z0-9]+)@([a-zA-Z]+)\.([a-zA-Z]){2,3}\.[a-zA-Z]{1,3}$/", $email)){
            $error_handler = $error_handler . 'wrongemail';
           	header("location: index.php?error=" . $error_handler);
            $error_occured = true;
        }
		
		if(strtotime($bDate) > strtotime('now')){
			$error_handler = $error_handler . 'wrongdate';
            header("location: index.php?error=" . $error_handler);
            $error_occured = true;
		}

        if(strlen($password) < 8){
            $error_handler = $error_handler . 'passlength';
           	header("location: index.php?error=" . $error_handler);
            $error_occured = true;
        }

		if($password != $password2){
			$error_handler = $error_handler . 'passmatch';
            header("location: index.php?error=" . $error_handler);
            $error_occured = true;
		}

        if($error_occured == true){
           header("location: index.php?error=" . $error_handler);
           exit();
        }else{
			//nothing
		}

        //CHECK IF EMAIL EXISTS//
        $sql = "SELECT * FROM users WHERE email = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
           header("location: index.php?error=stmtfailed");
           exit();
        }

        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        if(mysqli_fetch_assoc($resultData)){
           header("location: index.php?error=emailtaken");
        	exit();
        }else{
            //user not taken
        }
        mysqli_stmt_close($stmt);

        //IF USER DOES NOT EXIST://
        $sql = "INSERT INTO users (`name`,surname,email,`password`,birthday, `profile_image`, `friends`, `about_me`, `requests`, `work`, `relationship`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
           header("location: index.php?error=stmtfailed");
           exit();
        }else{
            //inserting
        }

        mysqli_stmt_bind_param($stmt, "sssssssssss", $name, $surname, $email, $password, $bDate, $profile_image, $friends, $about_me, $requests, $work, $relationship);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
       	header("location: index.php?error=none&login=true");
        mysqli_close($conn);
        exit();
    }else{
       header("location: index.php");
       exit();
    }

?>