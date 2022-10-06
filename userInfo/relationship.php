<?php
    include_once '../config.php';
    session_start();

    $relationshipText = '';
    $userID;

    $relationshipText = $_POST["relationship"];

    if(isset($_SESSION['user_id'])){
        $userID = $_SESSION['user_id'];
        $sql = "UPDATE `users` SET `relationship`= ? WHERE `user_id`= ?";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: profile.php?error=sqlfail");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ss", $relationshipText, $userID);

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        exit();
        //ENDSQL//
        echo json_encode(array('success'=>'true'));
    }else{
        echo json_encode(array('success'=>'false'));
    }
    
?>