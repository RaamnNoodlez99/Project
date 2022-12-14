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

        ///CHECK THE FRIENDS FIELD
        $friendWrite;

        if($friendsArr == "none"){
            $friendWrite = $requestId;
        }else{
            $friendWrite = $friendsArr . " " . $requestId;
        }
        //end check

        ///UPDATE THE FRIENDS FIELD
        $sql = "UPDATE `users` SET `friends`= ? WHERE `user_id`= ?";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: index.php?login=quick&error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ss", $friendWrite, $userID);

        mysqli_stmt_execute($stmt);
        //end UPDATE


        //NOW WE NEED TO APPEND MY CURR USER ID TO NEW FIRENDS' ID
        $sendersFriends;
        $sendersFriendsToWrite;
        $sendersCount = 0;

        $sql = "SELECT * FROM users WHERE `user_id` = ?;";
         $stmt = mysqli_stmt_init($conn);
         if(!mysqli_stmt_prepare($stmt, $sql)){
             header("location: index.php?login=quick&error=stmtfailed");
             exit();
         }
     
         mysqli_stmt_bind_param($stmt, "s", $requestId);
         mysqli_stmt_execute($stmt);
     
         $resultData = mysqli_stmt_get_result($stmt);
     
         if($row = mysqli_fetch_assoc($resultData)){

            $sendersFriends = explode(" ", $row["friends"]);

            foreach($sendersFriends as $element){
                $sendersCount++;
            }

         }else{
             header("location: home.php?error=stmtFailed");
             exit();
         }
         mysqli_stmt_close($stmt);
         //end sql

        if($sendersCount != 1){
            foreach($sendersFriends as $element){
                $sendersFriendsToWrite .= $element . ' ';
            }
            $sendersFriendsToWrite .= $userID;
        }else{
            $sendersFriendsToWrite = $userID;
        }

        $sql = "UPDATE `users` SET `friends`= ? WHERE `user_id`= ?";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: index.php?login=quick&error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ss", $sendersFriendsToWrite, $requestId);

        mysqli_stmt_execute($stmt);



        echo json_encode(array('success'=>'true'));
    }else{
        echo json_encode(array('success'=>'false'));
    }
    
?>