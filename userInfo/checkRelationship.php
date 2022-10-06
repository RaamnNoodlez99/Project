<?php
    include_once '../config.php';
    session_start();

    $relationship = '';
    $userID;

    if(isset($_SESSION['user_id'])){
        $userID = $_SESSION['user_id'];

        $sql = "SELECT `relationship` FROM users WHERE `user_id`= ?";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: profile.php?error=sqlfail");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "s", $userID);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);
        
        if($row = mysqli_fetch_assoc($resultData)){
            $relationship = $row['relationship'];
        }else{
            // header("location: home.php?error=nosession");
            exit();
        }
        mysqli_stmt_close($stmt);

        echo json_encode(array('success'=>$relationship));
        // mysqli_stmt_close($stmt);
        // mysqli_close($conn);
        // exit();
        // //ENDSQL//
    }else{
        echo json_encode(array('success'=>'false'));
    }
    
?>