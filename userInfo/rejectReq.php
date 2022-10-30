<?php

    include_once '../config.php';
    session_start();

    $requestId = '';
    $userID;
    $reqCount = 0;
    $allCurrRequests;
    $friendsArr;

    $requestId = $_POST["requestId"];

    if(isset($_SESSION['user_id'])){
        $userID = $_SESSION['user_id'];

        //CHECK THE REMAINING REQ TO UPDATE REQUEST FIELD APPROPRIATELY
        $sql = "SELECT * FROM users WHERE `user_id` = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: index.php?login=quick&error=stmtfailed");
            exit();
        }
    
        mysqli_stmt_bind_param($stmt, "s", $userID);
        mysqli_stmt_execute($stmt);
    
        $resultData = mysqli_stmt_get_result($stmt);
    
        if($row = mysqli_fetch_assoc($resultData)){

           $allCurrRequests = explode(" ", $row["requests"]);
           $friendsArr = $row["friends"];

           foreach($allCurrRequests as $element){
               $reqCount++;
           }
        }else{
            header("location: home.php?error=stmtFailed");
            exit();
        }
        mysqli_stmt_close($stmt);
        //end sql
        $toWrite = '';

        if($reqCount == 1){
            $toWrite = "none";
        }else{
            foreach($allCurrRequests as $element){
                if($element != $requestId){
                    $toWrite .= $element . ' ';
                }
            }
            $toWrite = substr($toWrite, 0, -1);
        }
         //end check

         ///UPDATE THE REQUESTS FIELD
        $sql = "UPDATE `users` SET `requests`= ? WHERE `user_id`= ?";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: index.php?login=quick&error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ss", $toWrite, $userID);

        mysqli_stmt_execute($stmt);
        //end UPDATE
        echo json_encode(array('success'=>'true'));
    }else{
        echo json_encode(array('success'=>'false'));
    }

?>