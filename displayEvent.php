<?php
    include_once 'config.php';
    session_start();

    //logged in user profile picture//
    // GET USER PROFILE PICTURE//
    $myUserID = '';

    $profilePictureURL = '';
    $profilePictureDisplay = 'none';
    $defaultProfilePicture = 'block';

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

    //GETTING EVENT ID//
    $eventID = '';
    if(isset($_GET['id'])){
        $eventID = $_GET['id'];
    }
    //END GET EVENT ID//

    //GETTING ALL EVENT INFORMATION FROM DATABASE//
    $user_id = '';
    $eventName = '';
    $eventImage = '';
    $eventDescription = '';
    $eventDate = '';
    $eventLocation = '';
    $eventHashtags = '';

    $sql = "SELECT * FROM events WHERE `event_id` = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: home.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $eventID);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)){
        $user_id = $row["user_id"];
        $eventName = $row["name"];
        $eventImage = $row["image"];
        $eventDescription = $row["description"];
        $eventDate = $row["date"];
        $eventLocation = $row["location"];
        $eventHashtags = $row["hashtags"];
    }else{
        header("location: profile.php?error=sqlFail");
        exit();
    }
    mysqli_stmt_close($stmt);
    //end sql
    //END GETTING EVENT INFO FROM DB//

    //GETTING NAME, SURNAME OF AUTHOR INFORMATION FROM DATABASE//
    $authorName = '';
    $authorSurname = '';

    $sql = "SELECT `name`, `surname` FROM `users` WHERE `user_id` = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: home.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $user_id);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)){
        $authorName = $row["name"];
        $authorSurname = $row["surname"];
    }else{
        header("location: profile.php?error=sqlFail");
        exit();
    }
    mysqli_stmt_close($stmt);
    //END GETTING AUTHOR INFO FROM DB//




    //CHECK IF EVENT ALREADY EXISTS IN DB and CHECK RATING//
    $eventExists = false;
    $rating = 'none';

    $sql = "SELECT * FROM `eventInfo` WHERE `event_id` = ? AND `user_id` = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: home.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $eventID, $myUserID);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)){
        //event exists so dont add it
        $eventExists = true;
        $rating = $row['rating'];
    }else{
        $eventExists = false;
    }
    mysqli_stmt_close($stmt);

    $liked = '';
    $unliked = '';

    if($rating != 'none'){
        if($rating == 'like'){
            $liked = 'liked';
        }else if($rating == 'unlike'){
            $unliked = 'unliked';
        }
    }
    //END CHECK IF EVENT ALREADY EXISTS IN DB//

    //INSERT EVENT int Eventinfo TABLE if not already in table//
    if($eventExists == false){
        $tempRating = 'none';

        $sql = "INSERT INTO `eventInfo` (`event_id`, `user_id`,`rating`) VALUES (?, ?, ?);";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: home.php?error=stmtfailed");
            exit();
        }else{
            //inserting
        }

        mysqli_stmt_bind_param($stmt, "sss", $eventID, $myUserID, $tempRating);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        //ENDSQL//
    }
    //END INSERT EVENT int Eventinfo TABLE if not already in table//
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Ashir Butt, u20422475">
    <title>Exhibo | Event</title>
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

        <div class="event-outer-wrapper">
            <div class="event-inner-wrapper">
                <div class="event-image-wrapper">

                    <div class="event-like-wrapper">
                        <div class="event-like <?php echo $liked; ?>" id="likeButton"><i id="likeHeart" class="fa-solid fa-heart <?php echo $liked; ?>"></i></div>
                        <div class="event-dislike <?php echo $unliked; ?>" id="unlikeButton"><i id="unlikeHeart" class="fa-solid fa-heart-crack <?php echo $unliked; ?>"></i></div>
                        <input type="hidden" name="rating" id="rating" value="<?php echo $rating; ?>">
                        <input type="hidden" name="eID" id="eID" value="<?php echo $eventID; ?>">
                        <input type="hidden" name="myID" id="myID" value="<?php echo $myUserID; ?>">
                    </div>

                    <img src="images/events/<?php echo $eventImage; ?>" alt="an event image">
                    <div class="event-gradient"></div>

                    <div class="event-header-wrapper">
                        <h1><?php echo $eventName ?></h1>
                        <p style="text-transform: capitalize;"><?php echo $eventLocation ?> <i style="padding-left: 0.5em;" class="fa-solid fa-location-dot"></i></p>
                        <p style="text-transform: capitalize;"><?php echo $authorName . " " . $authorSurname ?> <i style="padding-left: 0.5em;" class="fa-solid fa-user"></i></p>
                        <p><?php echo $eventDate ?> <i style="padding-left: 0.5em;" class="fa-solid fa-calendar-days"></i></p>                   
                    </div>

                    <div class="event-description">
                        <p><?php echo $eventDescription?></p>

                        <?php
                            $hashArr = explode(" ", $eventHashtags);
                            
                            echo '<div class="event-hashtags">';
                            foreach($hashArr as $element){
                                if($element != ""){
                                    echo '<div class="single-hash">' . $element . '</div>';
                                }
                            }
                            echo '</div>';
                        ?>
                    </div>
                </div>

                <hr class="event-hr"/>

                <h2 class="commentHeading">Comment</h2>
                <div class="make-comment">
                    <form action="addComment.php" method="POST">
                        <div class="write-comment">
                            <input type="text" name="comment" placeholder="Comment...">
                            <button name="commentSubmit" type="submit" id="commentSubmit" class="btn">Post</button>

                            <input type="hidden" name="commentEventID" id="commentEventID" value="<?php echo $eventID; ?>">
                            <input type="hidden" name="commentUserID" id="commentUserID" value="<?php echo $myUserID; ?>">
                        </div>
                    </form>
                </div>

                <?php
                    echo '<div class="comments row">';
                    
                    //GETTING ALL COMMENTS FOR CURRENT EVENT//
                    $totalComments = 0;
                    $commentAuthor_id = '';
                    $userComment = '';
                    $commentDate = '';

                    $sql = "SELECT * FROM `comments` WHERE `event_id` = ?;";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $sql)){
                        header("location: home.php?error=stmtfailed");
                        exit();
                    }

                    mysqli_stmt_bind_param($stmt, "s", $eventID);
                    mysqli_stmt_execute($stmt);

                    $resultData = mysqli_stmt_get_result($stmt);

                    while($row = mysqli_fetch_array($resultData)){
                        //comments have been made
                        $commentAuthor_id = $row["user_id"];
                        $userComment = $row["comment"];
                        $commentDate = $row["date"];
                        $totalComments++;

                        //GETTING COMMENT AUTHORS USER INFORMATION//
                        $commentorName = '';
                        $commentorSurname = '';
                        $commentorPicture = '';

                        $sql2 = "SELECT * FROM `users` WHERE `user_id` = ?;";
                        $stmt2 = mysqli_stmt_init($conn);
                        if(!mysqli_stmt_prepare($stmt2, $sql2)){
                            header("location: home.php?error=stmtfailed");
                            exit();
                        }

                        mysqli_stmt_bind_param($stmt2, "s", $commentAuthor_id);
                        mysqli_stmt_execute($stmt2);
                        $resultData2 = mysqli_stmt_get_result($stmt2);

                        if($row2 = mysqli_fetch_assoc($resultData2)){
                            $commentorName = $row2['name'];
                            $commentorSurname = $row2['surname'];
                            $commentorPicture = $row2['profile_image'];
                        }else{
                            header("location: home.php?error=sqlFail");
                            exit();
                        }
                        mysqli_stmt_close($stmt2);
                        //END GETTING COMMENT AUTHORS USER INFORMATION//

                        $defaultCommentorPicture = 'block';
                        $commentorPictureDisplay = 'none';

                        if($commentorPicture == 'none'){
                            $commentorPicture = '';
                        }else{
                            $defaultCommentorPicture = 'none';
                            $commentorPictureDisplay = 'block';
                        }


                        echo '
                        <div class="comment col-sm-12">
                            <div class="comment-img-side">
                                <div class="user-profile-picture">
                                    <img src="' . $commentorPicture . '" alt="commentor picture" style="display:' . $commentorPictureDisplay . '"/>
                                    <i class="fa-solid fa-user" style="display:' . $defaultCommentorPicture . '"></i>
                                </div>
                            </div>

                            <div class="comment-text-side">
                                <p class="commentUsername"><i class="fa-solid fa-user"></i> ' . $commentorName . " " . $commentorSurname . '</p>
                                <p class="commentDescription">' . $userComment . '</p>
                                <p class="commentDate">' . $commentDate . '</p>
                            </div>
                        </div>
                        ';
                    }


                        //no comments yet
                        if($totalComments == 0){
                            echo '
                            <div class="no-comments-wrapper">
                                <div class="no-comments">
                                    <p>Be the first to comment!</p>
                                </div>
                            </div>
                            ';
                        }
                        
                    mysqli_stmt_close($stmt);
                    //END GETTING ALL COMMENTS FOR CURRENT EVENT//
                    echo '</div>';
                ?>

                <!-- <div class="comments">
                    <div class="comment">
                        <div class="comment-img-side">
                            <div class="user-profile-picture">
                                <i class="fa-solid fa-user" style="display:<?php echo $something?>"></i>
                            </div>
                        </div>

                        <div class="comment-text-side">
                            <p class="commentUsername"><i class="fa-solid fa-user"></i> Username</p>
                            <p class="commentDescription">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Blanditiis doloribus assumenda ipsum cupiditate, autem voluptatibus totam atque, aspernatur iusto dolor</p>
                            <p class="commentDate">2011-01-01</p>
                        </div>
                    </div>
                </div> -->

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

    <script src="js/displayEvent.js"></script>
</body>
</html>