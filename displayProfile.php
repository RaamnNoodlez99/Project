<?php
    include_once 'config.php';
    session_start();

    if(!isset($_SESSION['userEmail'])){
        header("location: index.php?error=loginFirst");
    }

    $userID = '';
    $userName = '';
    $userSurname = '';
    $userEmail = '';
    $userBirthday = '';
    $userProfileImage = '';
    $userFriends = '';
    $userAbout = '';
    $userWork = '';
    $userRelationship = '';
    $userTotalFriends = 0;
    $userFriendsArr = '';

    $userProfilePictureDisplay = 'none';
    $userDefaultProfilePicture = 'block';

    if(isset($_GET['id'])){
        $userID = $_GET['id'];
    }

    //get ALL user information//
    $sql = "SELECT * FROM users WHERE `user_id` = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: home.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $userID);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    
    if($row = mysqli_fetch_assoc($resultData)){
        $userName = $row['name'];
        $userSurname = $row['surname'];
        $userEmail = $row['email'];
        $userBirthday = $row['birthday'];
        $userProfileImage = $row['profile_image'];
        $userFriends = $row['friends'];
        $userAbout = $row['about_me'];
        $userWork = $row['work'];
        $userRelationship = $row['relationship'];
    }else{
        // header("location: home.php?error=nosession");
        exit();
    }
    mysqli_stmt_close($stmt);
    if($userProfileImage == 'none'){
        $userProfileImage = '';
    }else{
        $userDefaultProfilePicture = 'none';
        $userProfilePictureDisplay = 'block';
    }
    // end sql

    if($userFriends != 'none'){
        $userFriendsArr = str_split($userFriends);
    }

    foreach($userFriendsArr as $element){
        if($element != " "){
            $userTotalFriends++;
        }
    }

    if($userAbout == 'Click here to add information!' || $userAbout == ""){
        $userAbout = 'No information';
    }

    if($userWork == 'Click here to add information!' || $userWork == ""){
        $userWork = 'No information';
    }
    ///////////////////////////


    //logged in user profile picture//
    // GET USER PROFILE PICTURE//
    $myUserID = '';

    if(isset($_SESSION['user_id'])){
        $myUserID = $_SESSION['user_id'];
    }

    $sql = "SELECT profile_image FROM users WHERE `user_id` = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: home.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $myUserID);
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
    /** PROFILE PICTURE END **/

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Ashir Butt, u20422475">
    <title>Exhibo | User</title>
    <link rel="icon" type="image/x-icon" href="images/logo.svg">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/c25dad79f1.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <link rel="stylesheet" href="css/style.css">
</head>
<body>
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

        <div class="profile-outer-wrapper">
            <div class="profile-inner-wrapper">

                <div class="profile-header-wrapper">
                    <form method="POST" id="profileImageForm">
                        <input type="file" name="profileToUpload" id="profileToUpload" style="display:none">
                        <div class="profile-image no-pointer">
                            <img src="<?php echo $userProfileImage;?>" alt="profile-image" id="uploaded-image" style="display:<?php echo $userProfilePictureDisplay;?>">
                            <i class="fa-solid fa-user" style="display:<?php echo $userDefaultProfilePicture?>"></i>
                            <span class="showOnHover visibiltyHidden" id="editSpanShow">Edit</span>
                        </div>
                    </form>

                    <div class="header-text">
                        <p><?php echo $userName;?>'s Profile</p>
                        <h1> <?php echo $userName . " " . $userSurname;?> </h1>

                        <p class="upper">About me</p>
                        <p contenteditable="false" class="canEditProfile no-pointer" id="aboutMe"><?php echo $userAbout;?></p>
                        <p><?php echo $userTotalFriends;?> Followers</p>
                    </div>
                </div>

                <div class="additional-info-outer">
                    <div class="additional-info-inner">
                        <p>Additional Information</p>

                        <div class="row">
                            <div class="col-sm-6">
                                <p class="upper">Birthday</p>
                                <p contenteditable="false" class="canEditProfile no-pointer" id="birthdayProfile" style="cursor: auto;"><?php echo $userBirthday;?></p>
                            </div>

                            <div class="col-sm-6">
                                <p class="upper">Work</p>
                                <p contenteditable="false" class="canEditProfile no-pointer" id="workProfile"><?php echo $userWork;?>
                                </p>
                            </div>

                            <div class="col-sm-6">
                                <p class="upper topMargin">Relationship status</p>
                                <p contenteditable="false" class="canEditProfile no-pointer" id="relationshipUserProfile"><?php echo $userRelationship;?>
                            </div>

                            <div class="col-sm-6">
                                <p class="upper topMargin">Email</p>
                                <p contenteditable="false" class="canEditProfile no-pointer" id="emailProfile"><?php echo $userEmail;?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="user-info">
                    <p>Friends</p>

                    <!--STORE MY USER ID FOR JS-->
                    <input type="hidden" name="myUid" id="myUid" value="<?php echo $myUserID;?>">

                    <div class="friends-list row">

                    <?php

                        foreach($userFriendsArr as $element){
                            if($element != " "){
                                $friendName = '';
                                $friendImage = '';
                                $friendBirth = '';

                                $sql = "SELECT `name`, `surname`, `birthday`, `profile_image` FROM users WHERE `user_id` = ?;";
                                $stmt = mysqli_stmt_init($conn);
                                if(!mysqli_stmt_prepare($stmt, $sql)){
                                    header("location: displayProfile.php?error=stmtfailed");
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
                                    header("location: displayProfile.php?error=sqlFail");
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
                                <div class="friend-box col-sm-6" id="viewUserProfile-' . $element . '">
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
                                    </div>
                                </div>';
                            }
                        }

                        echo `</div>`;

                        if($userFriends == 'none'){
                            echo '
                            <div class="noFriendsDiv">
                                <p class="noFriendsPara">User has no friends</p>
                            </div>
                            ';
                        }


                    ?>
                </div>
                
            </div>
        </div>
        
        <div class="background-images">
            <div class="gradient"></div>
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

    <script src="js/displayProfile.js"></script>
</body>
</html>