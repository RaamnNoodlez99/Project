<?php
    session_start();
    include_once 'config.php';

    $toWrite = 'nothing';
    $user_id;
    $user_email;
    $inboxFull;

    if(!isset($_SESSION['userEmail'])){
        header("location: index.php?error=loginFirst");
    }

    if(isset($_SESSION["user_id"])){
        $user_id = $_SESSION["user_id"];
    }

    if(isset($_SESSION["userEmail"])){
        $user_email = $_SESSION["userEmail"];
    }

    if(isset($_POST['friendEmail'])){
        $friendEmail = $_POST['friendEmail'];

        if($friendEmail == $user_email){
            header("location: profile.php?error=selfRequest");
        }else{
            //CHECK THE CURRENT REQUESTS TO APPEND THE NEW REQUEST TO EXISTING ONES
            $sql = "SELECT * FROM users WHERE `email` = ?;";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("location: index.php?login=quick&error=stmtfailed");
                exit();
            }
        
            mysqli_stmt_bind_param($stmt, "s", $friendEmail);
            mysqli_stmt_execute($stmt);
        
            $resultData = mysqli_stmt_get_result($stmt);
        
            if($row = mysqli_fetch_assoc($resultData)){
                if($row["requests"] == "none"){
                    $toWrite = $user_id;
                }else{
                    $allCurrRequests = explode(" ", $row["requests"]);

                    foreach($allCurrRequests as $element){
                        if($element == $user_id){
                            $inboxFull = true;
                            header("location: profile.php?error=inboxFull");
                        }
                    }

                    if($inboxFull == false){
                        $toWrite = $row["requests"] . " " . $user_id;
                    }
                }
            }else{
                header("location: profile.php?error=noEmail");
                exit();
            }
            mysqli_stmt_close($stmt);

            //end sql

            //APPEND THE NEW REQUEST
            if($toWrite != 'nothing'){
                $sql = "UPDATE `users` SET `requests`= ? WHERE `email`= ?";
                $stmt = mysqli_stmt_init($conn);

                if(!mysqli_stmt_prepare($stmt, $sql)){
                    header("location: index.php?login=quick&error=stmtfailed");
                    exit();
                }

                mysqli_stmt_bind_param($stmt, "ss", $toWrite, $friendEmail);

                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                header("location: profile.php?response=sent");
                mysqli_close($conn);
                exit();
            }
            //ENDSQL//
        }
        

    }
?>