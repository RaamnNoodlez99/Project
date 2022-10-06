<?php
    include_once '../config.php';
    session_start();

    $like = $_POST["like"];
    $event_id = $_POST["eventID"];
    $user_id = $_POST["myID"];

    if($like == 'true'){
        $like = 'like';
    }else{
        $like = 'unlike';
    }

    $sql = "UPDATE `eventInfo` SET `rating`= ? WHERE `event_id`= ? AND `user_id` = ?";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: home.php?error=sqlfail");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $like, $event_id, $user_id);

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    //ENDSQL//

    echo json_encode(array('success'=>'true'));
?>