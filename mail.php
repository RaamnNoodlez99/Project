<?php
    session_start();
    include_once 'config.php';

    if(!isset($_SESSION['userEmail'])){
        header("location: index.php?error=loginFirst");
    }

    $profilePictureURL = '';
    $profilePictureDisplay = 'none';
    $defaultProfilePicture = 'block';

    $requests = 'none';

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
        $requests = $row['requests'];
    }else{
        // header("location: home.php?error=nosession");
        exit();
    }
    mysqli_stmt_close($stmt);
    //end sql//

    // GET USER PROFILE PICTURE AND REQUSETS//
    $sql = "SELECT profile_image, requests FROM users WHERE `user_id` = ?;";
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
        $requests = $row['requests'];
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

    $requestsArr = '';

    if($requests != 'none'){
        $requestsArr = str_split($requests);
    }
    // end sql


    //FRIEND REQUEST RESPONSE MESSAGES:
    if(isset($_GET["friend"])){
        if($_GET["friend"] == "added"){
            $add_css = 'no-error added_animation';
            $no_error_text = 'New friend added!';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Ashir Butt, u20422475">
    <title>Exhibo | Mail</title>
    <link rel="icon" type="image/x-icon" href="images/logo.svg">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/c25dad79f1.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <link rel="stylesheet" href="css/style.css">
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

        <div class="<?php echo $add_css?>"><span class="no_error_text"><?php echo $no_error_text?></span></div>

        <div class="mail-outer-wrapper">
            <div class="mail-inner-wrapper">
                <?php
                    if($requests == 'none'){
                        echo '<div class="noMail"><p>You have no new mail</p></div>';
                    }else{

                        echo '<div class="newMail"><p>You have new friend requests!</p></div>';
                        foreach($requestsArr as $element){
                            if($element != " "){

                                $sql = "SELECT `name`, `surname`, `birthday`, `profile_image` FROM users WHERE `user_id` = ?;";
                                $stmt = mysqli_stmt_init($conn);
                                if(!mysqli_stmt_prepare($stmt, $sql)){
                                    header("location: index.php?login=quick&error=stmtfailed");
                                    exit();
                                }

                                mysqli_stmt_bind_param($stmt, "s", $element);
                                mysqli_stmt_execute($stmt);

                                $resultData = mysqli_stmt_get_result($stmt);

                                if($row = mysqli_fetch_assoc($resultData)){
                                    $friendName = $row["name"] . " " . $row["surname"];
                                    $friendImage = $row["profile_image"];
                                    $friendBirth = $row["birthday"];
                                }else{
                                    header("location: profile.php?error=sqlFail");
                                    exit();
                                }
                                mysqli_stmt_close($stmt);
                                //end sql

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

                                echo '
                                <div class="friend-box col-sm-12" id="viewUserProfile-' . $element . '">
                                    <div class="inner-friend-box">
                                        <div class="friend-img-side">
                                            <img src="' . $friendImage .'" alt="friend profile image" class="' . $setFriendImage . '"/>
                                            <i class="fa-solid fa-user ' . $defaultFriendImage . '"></i>
                                        </div>
                                        <div class="friend-text-side">
                                            <h3>' . $friendName . '</h3>
                                            <p>Birthday: ' . $friendBirth . '</p>
                                            <p>Mutual friends: John</p>
                                        </div>
                                        <div class="button-side">
                                            <button class="btn-mail accBtnClass" id="accBtn' . $element . '">Accept</button>
                                            <button class="btn-mail reject-mail rejBtnClass" id="rejBtn' . $element . '">Reject</button>
                                        </div>
                                    </div>
                                </div>';
                            }
                        }
                    }
                ?>
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
    </div>
</div>

<script src="js/mail.js"></script>
</body>
</html>

