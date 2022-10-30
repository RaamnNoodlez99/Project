<?php
    include_once '../config.php';
    session_start();

    $userId;
    $friendId;
    $msg;
    $msgTime;

    if(isset($_SESSION['user_id'])){
        $userId = $_SESSION['user_id'];

        $friendId = $_POST['friendId'];
        $msg = $_POST['msg'];
        $msgTime = $_POST['time'];



        //ADD MSG TO MESSAGE TABLE//
        $sql = "INSERT INTO `messages` (`incoming_id`,`outgoing_id`, `message`, `timestamp`) VALUES (?, ?, ?, ?);";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: home.php?error=stmtfailed");
            exit();
        }else{
            //inserting
        }
        mysqli_stmt_bind_param($stmt, "ssss", $friendId, $userId, $msg, $msgTime);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        //ENDSQL//

        echo json_encode(array('success'=>'true'));
    }else{
        echo json_encode(array('success'=>'false'));
    }
?>