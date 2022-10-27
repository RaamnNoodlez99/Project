<?php
	// See all errors and warnings
    session_set_cookie_params(0);
    session_start();
    
	error_reporting(E_ALL);
	ini_set('error_reporting', E_ALL);

    include_once 'config.php';

    $error_occured = false;
    $error_handler = '';

    $userName = '';
    $userSurname = '';
    $profile_image = '';
    $user_id = '';

    if(isset($_POST["logSubmit"])){
        $email = $_POST["logEmail"];
        $password = $_POST["logPass"];

        if(empty($_POST['logEmail'])){
            $error_handler = $error_handler . 'emptyLogEmail';
            header("location: index.php?login=quick&error=" . $error_handler);
            $error_occured = true;
        }

        if(empty($_POST['logPass'])){
            $error_handler = $error_handler . 'emptyLogPassword';
            header("location: index.php?login=quick&error=" . $error_handler);
            $error_occured = true;
        }

        if(!preg_match("/^([\.\_a-zA-Z0-9]+)@([a-zA-Z]+)\.([a-zA-Z]){2,8}$/", $email) AND !preg_match("/^([\.\_a-zA-Z0-9]+)@([a-zA-Z]+)\.([a-zA-Z]){2,3}\.[a-zA-Z]{1,3}$/", $email)){
            $error_handler = $error_handler . 'wrongLogEmail';
            header("location: index.php?login=quick&error=" . $error_handler);
            $error_occured = true;
        }

        if($error_occured == true){
            header("location: index.php?login=quick&error=" . $error_handler);
            exit();
        }else{
           //nothing
        }

        //CHECK IF EMAIL EXISTS//
        $sql = "SELECT * FROM users WHERE email = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: index.php?login=quick&error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        if($row = mysqli_fetch_assoc($resultData)){
            //user exists
            $userName = $row['name'];
            $userSurname = $row['surname'];
            $profile_image = $row['profile_image'];
            $user_id = $row['user_id'];
        }else{
            header("location: index.php?login=quick&error=emailnotexist");
            exit();
        }
        mysqli_stmt_close($stmt);
        //end sql

        $checkPassword = $row["password"];

        if($checkPassword != $password){
            header("location: index.php?login=quick&error=wrongpassword");
            exit();
        }else{
            $_SESSION["userEmail"] = $email;
            $_SESSION["userName"] = $userName;
            $_SESSION["userSurname"] = $userSurname;
            $_SESSION["profile_image"] = $profile_image;
            $_SESSION["user_id"] = $user_id;

            header("location: home.php?error=none");
            exit();
        }

    }else{
        header("location: index.php?error=none&login=quick");
        exit();
    }
?>