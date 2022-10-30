<?php
    include_once '../config.php';
    session_start();

    //GET LAST MESSAGE TO ADD AS AJAX
    $outgoing_id;
    $incoming_id;
    $time;
    $message;

    $sql = "SELECT * FROM `messages` ORDER BY msg_id DESC";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: index.php?login=quick&error=stmtfailed");
        exit();
    }
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)){
        $message = $row['message'];
        $outgoing_id = $row['outgoing_id'];
        $incoming_id = $row['incoming_id'];
        $time = $row['timestamp'];
    }
    mysqli_stmt_close($stmt);
    //end sql

    echo json_encode(array('message'=>$message, 'outgoing_id'=>$outgoing_id, 'incoming_id'=>$incoming_id, 'timestamp'=>$time));
?>