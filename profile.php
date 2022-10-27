<?php
    $userName = 'Error retrieving data';
    $userSurname = '';
    $profile_image = '';
    $profileImageDisplay = 'none';

    session_start();

    if(!isset($_SESSION['userEmail'])){
        header("location: index.php?error=loginFirst");
    }else{
        if(isset($_SESSION['userName'])){
            $userName = $_SESSION['userName'];
        }
    
        if(isset($_SESSION['userSurname'])){
            $userSurname = $_SESSION['userSurname'];
        }
    
        if(isset($_SESSION['profile_image'])){
            $profile_image = $_SESSION['profile_image'];
    
            if($profile_image == 'none'){
                $profile_image = '';
            }else{
                $profileImageDisplay = 'block';
            }
        }
    
        include_once 'config.php';
    
        //CHECK FOR FRIENDS and ABOUT_ME//
        $user_id = '';
        $friendsList = '';
        $totalFriends = 0;
        $about_me = '';
    
        if(isset($_SESSION["user_id"])){
            $user_id = $_SESSION["user_id"];
        }
    
        $sql = "SELECT friends, `about_me` FROM users WHERE `user_id` = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: index.php?login=quick&error=stmtfailed");
            exit();
        }
    
        mysqli_stmt_bind_param($stmt, "s", $user_id);
        mysqli_stmt_execute($stmt);
    
        $resultData = mysqli_stmt_get_result($stmt);
    
        if($row = mysqli_fetch_assoc($resultData)){
            $friendsList = $row["friends"];
            $about_me = $row["about_me"];
        }else{
            header("location: profile.php?error=sqlFail");
            exit();
        }
        mysqli_stmt_close($stmt);
        //end sql
    
        if($friendsList != 'none'){
            $arr = str_split($friendsList);
        }
    
        foreach($arr as $element){
            if($element != " "){
                $totalFriends++;
            }
        }
    
    
    
    
        /** PROFILE PICTURE and BIRTHDAY and WORK**/
        $profilePictureURL = '';
        $profilePictureDisplay = 'none';
        $defaultProfilePicture = 'block';
    
        $email = '';
        $userID = '';
    
        $birthday = '';
        $work = '';
    
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
            $birthday = $row['birthday'];
            $work = $row['work'];
        }else{
            // header("location: home.php?error=nosession");
            exit();
        }
        mysqli_stmt_close($stmt);
        //end sql//
    
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
        /** PROFILE PICTURE END **/


        //FRIEND REQUEST RESPONSE MESSAGES:
        $reShowForm = '';

        if(isset($_GET["error"]) || isset($_GET["response"])){
            if($_GET["error"] == "selfRequest"){
                $add_css = 'no-error added_animation';
                $no_error_text = 'You cannot friend yourself';
                $reShowForm = 'overwriteShow';
            }else if($_GET["error"] == "inboxFull"){
                $add_css = 'no-error added_animation';
                $no_error_text = 'Your request has already been sent';
                $reShowForm = 'overwriteShow';
            }else if($_GET["error"] == "noEmail"){
                $add_css = 'no-error added_animation';
                $no_error_text = 'User does not exist';
                $reShowForm = 'overwriteShow';
            }else if($_GET["response"] == "sent"){
                $add_css = 'no-error added_animation';
                $no_error_text = 'Request has been sent';
            }
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
    <title>Exhibo | Profile</title>
    <link rel="icon" type="image/x-icon" href="images/logo.svg">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/c25dad79f1.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <link  href="node_modules/cropperjs/dist/cropper.css" rel="stylesheet">
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

        <div class="profile-outer-wrapper">
            <div class="profile-inner-wrapper">

                <div class="profile-header-wrapper">
                    <form method="POST" id="profileImageForm">
                        <input type="file" name="profileToUpload" id="profileToUpload" style="display:none">
                        <div class="profile-image">
                            <img src="<?php echo $profilePictureURL;?>" alt="profile-image" id="uploaded-image" style="display:<?php echo $profilePictureDisplay;?>">
                            <i class="fa-solid fa-user" style="display:<?php echo $defaultProfilePicture?>"></i>
                            <span class="showOnHover visibiltyHidden" id="editSpanShow">Edit</span>
                        </div>
                    </form>

                    <form action="uploadProfileToDB.php" method="POST" id="dbForm">
                        <input type="hidden" name="hiddenProfileName" value="none" id="hiddenProfileImage">
                    </form>

                    <div class="header-text">
                        <p>Your Profile</p>
                        <h1> <?php echo $userName . " " . $userSurname;?> </h1>

                        <p class="upper">About me</p>
                        <p contenteditable="true" class="tooltips canEditProfile" id="aboutMe"><?php echo $about_me;?>
                            <span class="tooltipstext">Edit!</span>
                        </p>
                        <p><?php echo $totalFriends;?> Followers</p>
                    </div>

                    <div class="add-friend-div tooltips" id="add-friend-button">
                        <span class="tooltipstext">Add friend!</span>
                        <i class="fa-solid fa-user-plus"></i>
                    </div>


                </div>

                <div class="additional-info-outer">
                    <div class="additional-info-inner">
                        <p>Additional Information</p>

                        <div class="row">
                            <div class="col-sm-6">
                                <p class="upper">Birthday</p>
                                <p contenteditable="false" class="canEditProfile" id="birthdayProfile" style="cursor: auto;"><?php echo $birthday;?></p>
                            </div>

                            <div class="col-sm-6">
                                <p class="upper">Work</p>
                                <p contenteditable="true" class="tooltips canEditProfile" id="workProfile"><?php echo $work;?>
                                    <span class="tooltipstext">Edit!</span>
                                </p>
                            </div>

                            <div class="col-sm-6">
                                <label for="relationshipProfile" class="upper topMargin">Relationship status</label>
                                <br>
                                <div class="tooltips canEditProfile">
                                    <select name="relationshipState" id="relationshipProfile">
                                        <option value="ratherNotSay">Rather not say</option>
                                        <option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                        <option value="Widowed">Widowed</option>
                                        <option value="Divorced">Divorced</option>
                                        <option value="Seperated">Seperated</option>
                                        <option value="complicated">Its complicated</option>
                                    </select>
                                    <span class="tooltipstext">Edit!</span>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label for="emailProfile" class="upper topMargin">Email</label>
                                <br>
                                <div class="tooltips fullWidth">
                                    <input type="email" name="emailProfile" id="emailProfile" value="<?php echo $email;?>">
                                    <span class="tooltipstext">Edit!</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="user-info">
                    <p>Friends</p>
                    <div class="friends-list row">

                    <?php

                        foreach($arr as $element){
                            if($element != " "){
                                $friendName = '';
                                $friendImage = '';
                                $friendBirth = '';

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

                        if($friendsList == 'none'){
                            echo '
                            <div class="noFriendsDiv">
                                <p class="noFriendsPara">No friends currently. Add more friends!</p>
                            </div>
                            ';
                        }

                    ?>
                </div>
            </div>
        </div>

        <div class="crop-image-tool">
            <div class="crop-image-tool-inner-box">
                <i class="fa-solid fa-xmark profileX" id="exit"></i>

                <h2>Crop image before upload</h2>
                <div class="imagesToShow">
                    <div class="whole-image-preview">
                        <img src="" alt="choose profile image" id="sampleImage">
                    </div>
                    <div class="cropped-image-preview">
                        <div class="preview-crop"></div>
                    </div>
                </div>

                <button type="button" id="cropButton" class="btn">Crop</button>
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

        <div id="friendForm" class="add-event-form <?php echo $reShowForm ?>">
            <div class="add-cover" style="height: 30%">
                <h1>Add a new friend</h1>
                <i class="fa-solid fa-xmark" id="exit-friend"></i>

                <form action="sendFriendRequest.php" method="POST" enctype="multipart/form-data">
                        <fieldset>
                            <div class="row">
                                <div class="col-12">
                                    <label for="email">Friends' email address<sup>*</sup></label>
                                    <input type="email" id="email" class="form-control" placeholder="john.doe@gmail.com" name="friendEmail">
                                    <span class="formspan" id="emailSpan"></span>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12" style="margin-top: 0.3em">
                                    <button name="addSubmit" type="submit" id="addSubmit" class="btn">Add Friend</button>
                                    <span class="formspan" id="errorSpan"></span>
                                </div>
                            </div>
                        </fieldset>
                </form>
            </div>
        </div>
    </div>

    <script src="node_modules/cropperjs/dist/cropper.js"></script>
    <script src="js/profile.js"></script>

</body>
</html>