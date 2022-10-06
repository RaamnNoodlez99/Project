<?php
    session_start();

    $user_id = '';
    $file = '';

    include_once 'config.php';

    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
    }

    if(isset($_POST['hiddenProfileName'])){
        $_SESSION['profile_image'] = $_POST['hiddenProfileName'];

        $file = $_POST['hiddenProfileName'];

         //UPLOAD FILE NAME TO DB//
        $sql = "UPDATE `users` SET `profile_image`= ? WHERE `user_id`= ?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: home.php");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ss", $file, $user_id);

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("location: profile.php?error=none");
        mysqli_close($conn);
        exit();
    }else{
        header("location: profile.php?error=dbError");
    }
   
?>