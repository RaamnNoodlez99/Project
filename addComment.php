<?php
    include_once 'config.php';
    session_start();

    if(!isset($_SESSION['userEmail'])){
        header("location: index.php?error=loginFirst");
    }

    if(isset($_POST['commentSubmit'])){
        
        $event_id = '';
        $user_id = '';
        $comment = '';

        $date = date('Y-m-d H:i:s');

        if(isset($_POST['comment'])){
            $comment = $_POST['comment'];
        }

        if(isset($_POST['commentEventID'])){
            $event_id = $_POST['commentEventID'];
        }

        if(isset($_POST['commentUserID'])){
            $user_id = $_POST['commentUserID'];
        }

        //INSERT COMMENT INTO COMMENTS TABLE//
        $sql = "INSERT INTO `comments` (`user_id`, `event_id`,`comment`, `date`) VALUES (?, ?, ?, ?);";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: home.php?error=stmtfailed");
            exit();
        }else{
            //inserting
        }

        mysqli_stmt_bind_param($stmt, "ssss", $user_id, $event_id, $comment, $date);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header('location: displayEvent.php?id=' . $event_id);
        exit();
        //ENDSQL//
        //END INSERT COMMENT INTO COMMENTS TABLE//  
    }
?>