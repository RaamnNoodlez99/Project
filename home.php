<?php

    session_start();

    if(!isset($_SESSION['userEmail'])){
        header("location: index.php");
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



    $error_error = '';

    $add_css = '';
    $no_error_text = '';

    if(isset($_GET['error'])){
        if($_GET['error'] == 'none'){
            if(isset($_GET['add'])){
                if($_GET['add'] == 'true'){
                    


                }
            }
        }else{
            if($_GET['error'] == 'invalidFormat'){
                $add_css = 'no-error added_animation';
                $no_error_text = 'Invalid file format';
            }
        }
    }

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

    //GETTING FRIENDS LIST//
    $friendsList = '';
    $totalFriends = 0;

    $sql = "SELECT friends FROM users WHERE `user_id` = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: home.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $userID);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)){
        $friendsList = $row["friends"];
    }else{
        header("location: home.php?error=sqlFail");
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
    /////////////

    //SETTING GLOBAL AND LOCAL FEEDS//
    $feedType = 'Local';

    if(isset($_SESSION['feedType'])){
        $feedType = $_SESSION['feedType'];
    }

    $localSelected = '';
    $globalSelected = '';

    if($feedType == 'Local'){
        $localSelected = 'selected';
        $globalSelected = '';
    }else{
        $globalSelected = 'selected';
        $localSelected = '';
    }
    /////////////////////////////////
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Ashir Butt, u20422475">
    <title>Exhibo | Home</title>
    <link rel="icon" type="image/x-icon" href="images/logo.svg">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="css/style.css">

    <script src="https://kit.fontawesome.com/c25dad79f1.js" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body class="">
    <div class="container-fluid">
        <div class="<?php echo $add_css?>"><span class="no_error_text"><?php echo $no_error_text?></span></div>

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

        <div class="feed-wrapper-outer">
            <div class="feed-wrapper-inner">
                <label for="feedHome">Showing </label>
                <div class="tooltips">
                    <select name="feedType" id="feedType">
                        <option value="Local" <?php echo $localSelected;?>>Local</option>
                        <option value="Global" <?php echo $globalSelected;?>>Global</option>
                    </select>
                    <span class="tooltipstext">Edit!</span>
                </div>
                <label for="feedHome"> feed</label>
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

    <div id="add-event-button" class="add-event-button">
    <i class="fa-solid fa-plus"></i>
    </div>

    <div id="eventForm" class="add-event-form">
            <div class="add-cover">
            <h1 id="addOrEditHeading">Add an artwork</h1>
            <i class="fa-solid fa-xmark" id="exit"></i>

            <form action="addEvent.php" method="POST" enctype="multipart/form-data">
                <fieldset>
                    <input type="hidden" name="addOrEditForm" id="addOrEditForm" value="add">
                    <input type="hidden" name="editNumber" id="editNumber" value="-1">
                    <div class="row">
                        <div class="col-12">
                            <label for="name">Artwork Name<sup>*</sup></label>
                            <input type="text" id="name" class="form-control" name="name">
                            <span class="formspan" id="nameSpan"></span>
                        </div>
                        <div class="col-12">
                            <label for="description">Artwork Description<sup>*</sup></label><br/>
                            <textarea class="form-control" name="description" id="description"></textarea>
                            <span class="formspan" id="descriptionSpan"></span>
                        </div>
                        <div class="col-12">
                            <label for="date">Creation Date<sup>*</sup></label><br/>
                            <input type="date" id="date" class="form-control" name="date">
                            <span class="formspan" id="dateSpan"></span>
                        </div>
                        <div class="col-12">
                            <label for="location">Creation Location<sup>*</sup></label>
                            <input type="text" id="location" class="form-control" name="location">
                            <span class="formspan" id="locationSpan"></span>
                        </div>
                        <div class="col-12">
                            <label for="hashtags">Hashtags<sup>*</sup></label>
                            <input type="text" id="hashtags" class="form-control" name="hashtags">
                            <span class="formspan" id="hashtagSpan"></span>
                        </div>
                        <label name="image" id="picLabel" for="picToUpload">Upload Artwork</label>
                        <input type='file' class='form-control' name='picToUpload' id='picToUpload'/>
                        <p style="margin:0" id="currentImage">Currently uploaded image: </p>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <button name="addSubmit" type="submit" id="addSubmit" class="btn">Add Artwork</button>
                            <span class="formspan" id="errorSpan"><?php echo $error_error?></span>
                        </div>
                    </div>
                </fieldset>
            </form>

            </div>
        </div>

        <div class="all-events">

            <?php

                $query = '';

                if($feedType == 'Local'){
                    $query = "SELECT * FROM events WHERE `user_id` = $userID";

                    foreach($arr as $element){
                        if($element != " "){
                            $query .= " OR `user_id` = " . $element;
                        }
                    }

                    $query .= " ORDER BY date DESC";
                }else{
                    $query = "SELECT * FROM events ORDER BY date DESC;";
                }

                $response = $conn->query($query);

                $eventsArray = array();
				$countEvents = 0;

                if($response->num_rows > 0){
					while($row = $response->fetch_assoc()){
						$eventsArray[$countEvents++] = $row; 
					}
				}

                if(!empty($eventsArray)){
                    foreach($eventsArray as $row){

                        $showEdit = 'none';

						$tempEventID = $row['event_id'];
                        $imgName = $row['image'];
                        $hashtags = $row['hashtags'];
                        $postAuthor = $row['user_id'];

                        if($postAuthor == $userID){
                            $showEdit = 'flex';
                        }
                        
                        //get author name
                        $sqlQuery = "SELECT `name` FROM users WHERE `user_id`= ?";
                        $statement = mysqli_stmt_init($conn);

                        if(!mysqli_stmt_prepare($statement, $sqlQuery)){
                            header("location: home.php?error=sqlfail");
                            exit();
                        }

                        mysqli_stmt_bind_param($statement, "s", $postAuthor);
                        mysqli_stmt_execute($statement);

                        $results = mysqli_stmt_get_result($statement);
                        
                        if($rows = mysqli_fetch_assoc($results)){
                            $postAuthor = $rows['name'];
                        }else{
                            // header("location: home.php?error=nosession");
                            exit();
                        }
                        mysqli_stmt_close($statement);
                        //////////////

                        $hashArr = explode(" ", $hashtags);

						echo '<div class="an-event" id="an-event-' . $tempEventID . '">
                                <div class="img-side">
                                    <img id="eImage-' . $tempEventID . '" src="images/events/' . $imgName . '" alt="event">
                                </div>
                                <div class="text-side">
                                    <div class="edit-event-button" id="edit-' . $tempEventID . '" style="display:' . $showEdit . '">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </div>
                                    <h1 class="eName" id="eName-' . $tempEventID . '">' . $row['name'] . '</h1>
                                    <hr class="mar-bot">
                                    <p class="eDescription" id="eDescription-' . $tempEventID . '">' . $row['description'] . '</p>
                                    <p class="lighter eDate">Creation date: <span class="darker" id="eDate-' . $tempEventID . '">' . $row['date'] . '</span></p>
                                    <p class="lighter eLocation">Location: <span class="darker" id="eLocation-' . $tempEventID . '">' . $row['location'] . '</span></p>
                                    <p class="lighter eAuthor">Author: <span class="darker" id="eAuthor-"' . $tempEventID . '">' . $postAuthor . '</span></p>
                                    <div class="eHashtags" id="eHashtags-' . $tempEventID . '">';

                                    foreach($hashArr as $hash){
                                        if($hash != ""){
                                            echo '<div class="eHashtag">' . $hash . '</div>';
                                        }
                                    }

                        echo        '</div>
                                </div>
                            </div>';
					}
                }
            ?>
   
        </div>

        <script src="js/home.js"></script>
</body>
</html>