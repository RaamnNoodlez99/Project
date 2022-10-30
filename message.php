<?php
    session_start();

    if(!isset($_SESSION['userEmail'])){
        header("location: index.php?error=loginFirst");
    }

    include_once 'config.php';

    $email = '';
    $userID = '';
    if(isset($_SESSION['userEmail'])){
        $email = $_SESSION['userEmail'];
    }

    //GET USER ID//
    $sql = "SELECT * FROM users WHERE email = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: index.php?login=quick&error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)){
        $userID = $row['user_id'];
    }else{
        // header("location: home.php?error=nosession");
        exit();
    }
    mysqli_stmt_close($stmt);
    //end sql//

    $profilePictureURL = '';
    $profilePictureDisplay = 'none';
    $defaultProfilePicture = 'block';

    // GET USER PROFILE PICTURE//
    $sql = "SELECT profile_image FROM users WHERE `user_id` = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: index.php?login=quick&error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $userID);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    
    if($row = mysqli_fetch_assoc($resultData)){
        $profilePictureURL = $row['profile_image'];
    }else{
        // header("location: home.php?error=nosession");
        exit();
    }
    mysqli_stmt_close($stmt);

    if($profilePictureURL == 'none'){
        $profilePictureURL = '';
    }else{
        $defaultProfilePicture = 'none';
        $profilePictureDisplay = 'block';
    }
    // end sql


  



    //new stuff
    $friendId;
    $friendImage = '';


    if(isset($_GET["msg-friend"])){
        if(isset($_GET["friend-id"])){
            $friendId = $_GET["friend-id"];
        }
    }

    // GET FRIEND PROFILE PICTURE//
    $sql = "SELECT profile_image FROM users WHERE `user_id` = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: index.php?login=quick&error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $friendId);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    
    if($row = mysqli_fetch_assoc($resultData)){
        $friendImage = $row['profile_image'];
    }else{
        // header("location: home.php?error=nosession");
        // exit();
    }
    mysqli_stmt_close($stmt);

    $noneDisplay = 'noneDisplay';
    $blockDisplay = 'blockDisplay';
    
    $defaultFriendImage = '';
    $setFriendImage = 'none';

    if($friendImage == 'none'){
        $defaultFriendImage = $blockDisplay;
        $setFriendImage = $noneDisplay;
        $friendImage = "";
    }else{
        $defaultFriendImage = $noneDisplay;
        $setFriendImage = $blockDisplay;
    }
    // end sql

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Ashir Butt, u20422475">
    <title>Exhibo | Message</title>
    <link rel="icon" type="image/x-icon" href="images/logo.svg">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="css/style.css">

    <script src="https://kit.fontawesome.com/c25dad79f1.js" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</head>
<body class="">
    <div class="container-fluid">

        <div class="header">
            <div class="nav">
                <a href="home.php">
                    <div class="logo-banner">
                        <img class="logo-img" src="images/logo.svg" alt="website logo">
                        <h1>exhibo</h1>
                    </div>
                </a>
                <div class="page-links">
                    <a href='logout.php'>Logout</a>
                    <a href="mail.php" id="mailLink">
                        <div title="mail">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                    </a>
                    <a href="profile.php" id="profileImageLink">
                        <div title="Profile">
                            <img src="<?php echo $profilePictureURL;?>" alt="profile picture" style="display:<?php echo $profilePictureDisplay;?>"/>
                            <i class="fa-solid fa-user" style="display:<?php echo $defaultProfilePicture?>"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>


        <div class="background-images">

            <div class="gradient-home"></div>
            <div class="row">
                <div class="column">
                  <img src="images/background/img1.jpeg" alt="background-img">
                  <img src="images/background/img2.jpg" alt="background-img">
                  <img src="images/background/img4.jpg" alt="background-img">
                  <img src="images/background/img32.jpg" alt="background-img">
                  <img src="images/background/img36.jpg" alt="background-img">
                </div>
                <div class="column">
                    <img src="images/background/img5.jpg" alt="background-img">
                    <img src="images/background/img19.jpg" alt="background-img">
                    <img src="images/background/img33.jpg" alt="background-img">
                    <img src="images/background/img30.jpg" alt="background-img">
                    <img src="images/background/img37.jpg" alt="background-img">
                </div>
                <div class="column">
                    <img src="images/background/img10.jpg" alt="background-img">
                    <img src="images/background/img7.jpg" alt="background-img">
                    <img src="images/background/img9.jpg" alt="background-img">
                    <img src="images/background/img34.jpg" alt="background-img">
                    <img src="images/background/img39.jpg" alt="background-img">
                </div>
                <div class="column">
                  <img src="images/background/img11.jpg" alt="background-img">
                  <img src="images/background/img12.jpg" alt="background-img">
                  <img src="images/background/img13.jpg" alt="background-img">
                  <img src="images/background/img35.jpg" alt="background-img">
                  <img src="images/background/img38.jpg" alt="background-img">
                </div>
                <div class="column">
                  <img src="images/background/img15.jpg" alt="background-img">
                  <img src="images/background/img31.jpg" alt="background-img">
                  <img src="images/background/img29.jpg" alt="background-img">
                  <img src="images/background/img8.jpg" alt="background-img">
                  <img src="images/background/img14.jpg" alt="background-img">
                </div>
                <div class="column">
                  <img src="images/background/img23.jpg" alt="background-img">
                  <img src="images/background/img24.jpg" alt="background-img">
                  <img src="images/background/img25.jpg" alt="background-img">
                  <img src="images/background/img27.jpg" alt="background-img">
                  <img src="images/background/img21.jpg" alt="background-img">
                </div>
              </div>
        </div>

        <div class="message-outer-wrap">
            <div class="message-inner-wrapper">

                <div class="message-area" id="messageArea">

                    <?php
                        $chatHistory = false;
                        
                        //GET ALL MESSAGES BETWEEN THE TWO FRIENDS//
                        $sql = "SELECT * FROM messages WHERE (outgoing_id = ? AND incoming_id = ?) OR (outgoing_id = ? AND incoming_id = ?)";
                        $stmt = mysqli_stmt_init($conn);
                        if(!mysqli_stmt_prepare($stmt, $sql)){
                            header("location: index.php?login=quick&error=stmtfailed");
                            exit();
                        }

                        mysqli_stmt_bind_param($stmt, "ssss", $userID, $friendId, $friendId, $userID);
                        mysqli_stmt_execute($stmt);

                        $resultData = mysqli_stmt_get_result($stmt);
                        
                        while($row = mysqli_fetch_assoc($resultData)){
                            $chatHistory = true;

                            $theTime = substr($row['timestamp'], 0, 16);

                            if($row['outgoing_id'] == $userID){
                                echo '
                                <div class="my-msg-wrapper">
                                    <div class="my-msg">' . $row["message"] . '</div>
                                    <div class="friend-img-side">
                                        <img src="' . $profilePictureURL . '" alt="profile picture" style="display:' . $profilePictureDisplay . '"/>
                                        <i class="fa-solid fa-user" style="display:' . $defaultProfilePicture . '"></i>
                                    </div>
                                    <span class="msg-time">' . $theTime . '</span>
                                </div>
                                ';
                            }

                            if($row['incoming_id'] == $userID){
                                echo '
                                <div class="their-msg-wrapper">
                                    <div class="friend-img-side">
                                        <img src="' . $friendImage . '" alt="profile picture" class="' . $setFriendImage . '"/>
                                        <i class="fa-solid fa-user ' . $defaultFriendImage . '"></i>
                                    </div>
                                    <div class="their-msg">' . $row["message"] . '</div>
                                    <span class="msg-time">' . $theTime . '</span>
                                </div>
                                ';
                            }
                        }
                        mysqli_stmt_close($stmt);
                        //end sql//

                    ?>



                </div>

                
                
                <div class="message-box">
                    <div id="messageForm">
                        <input type="text" name="inputBox" id="inputBox">
                        <button id="sendButton">Send</button>
                        <input id="friendHidden" type="hidden" name="friendID" value="<?php echo $friendId?>">

                        <input id="profilePictureURL" type="hidden" name="profilePictureURL" value="<?php echo $profilePictureURL?>">
                        <input id="profilePictureDisplay" type="hidden" name="profilePictureDisplay" value="<?php echo $profilePictureDisplay?>">
                        <input id="defaultProfilePicture" type="hidden" name="defaultProfilePicture" value="<?php echo $defaultProfilePicture?>">
                        <input id="friendImage" type="hidden" name="friendImage" value="<?php echo $friendImage?>">
                        <input id="setFriendImage" type="hidden" name="setFriendImage" value="<?php echo $setFriendImage?>">
                        <input id="defaultFriendImage" type="hidden" name="defaultFriendImage" value="<?php echo $defaultFriendImage?>">
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="js/message.js"></script>
</body>
</html>