<?php
    session_start();

    error_reporting(E_ALL);
    ini_set('error_reporting', E_ALL);

    if(isset($_POST['addSubmit'])){
        //do error validation
        
        include_once 'config.php';

        $name = '';
        $image = '';
        $description = '';
        $date = '';
        $location = '';
        $hashtags = '';
        $userID = 0;

        $addOrEdit = '';

        $email = '';

        if(isset($_SESSION['userEmail'])){
            $email = $_SESSION['userEmail'];
        }

        if(isset($_POST['name'])){
            $name = $_POST['name'];
        }

        if(!empty($_FILES)){
            if($_FILES['picToUpload']['name'] != ""){
                $image = $_FILES['picToUpload']['name'];
                $target_dir = "images/events/";
                $target_file = $target_dir . basename($_FILES["picToUpload"]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                $check = getimagesize($_FILES["picToUpload"]["tmp_name"]);
                if($check !== false) {
                    $uploadOk = 1;
                } else {
                    header("location: home.php?error=invalidFormat");
                    $uploadOk = 0;
                    exit();
                }
    
                if (file_exists($target_file)) {
                    $uploadOk = 0;
                }
    
                if($uploadOk == 1){
                    move_uploaded_file($_FILES["picToUpload"]["tmp_name"], $target_file);
                }
            }else{
                $image = '';
            }
        }

        if(isset($_POST['description'])){
            $description = $_POST['description'];
        }

        if(isset($_POST['date'])){
            $date = $_POST['date'];
        }

        if(isset($_POST['location'])){
            $location = $_POST['location'];
        }

        if(isset($_POST['hashtags'])){
            $hashtags = $_POST['hashtags'];
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
            header("location: home.php?error=nosession");
            exit();
        }
        mysqli_stmt_close($stmt);
        //end sql//



        if(isset($_POST['addOrEditForm'])){
            $addOrEdit = $_POST['addOrEditForm'];
        }

        if($addOrEdit == "add"){
            //INSERT EVENT INTO EVENTS TABLE//
            $sql = "INSERT INTO events (`user_id`, `name`,`image`,`description`,`date`,`location`, hashtags) VALUES (?, ?, ?, ?, ?, ?, ?);";
            $stmt = mysqli_stmt_init($conn);

            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("location: home.php?error=stmtfailed");
                exit();
            }else{
                //inserting
            }

            mysqli_stmt_bind_param($stmt, "sssssss", $userID, $name, $image, $description, $date, $location, $hashtags);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            header("location: home.php?error=none&add=true");
            mysqli_close($conn);
            exit();
            //ENDSQL//
        }else{
            //EDIT EVENT IN EVENTS TABLE
            $eventID = '';

            if(isset($_POST['editNumber'])){
                $eventID = $_POST['editNumber'];
            }

            if($image != ''){
                $sql = "UPDATE `events` SET `name`= ? , `image`= ? , `description`= ? , `date`= ? , `location`= ?, `hashtags`= ? WHERE `event_id`= ?";
                $stmt = mysqli_stmt_init($conn);

                if(!mysqli_stmt_prepare($stmt, $sql)){
                    header("location: index.php?login=quick&error=stmtfailed");
                    exit();
                }

                mysqli_stmt_bind_param($stmt, "sssssss", $name, $image, $description, $date, $location, $hashtags, $eventID);

                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                header("location: home.php?error=none&edit=true");
                mysqli_close($conn);
                exit();
                //ENDSQL//
            }else{
                $sql = "UPDATE `events` SET `name`= ? , `description`= ? , `date`= ? , `location`= ?, `hashtags`= ? WHERE `event_id`= ?";
                $stmt = mysqli_stmt_init($conn);

                if(!mysqli_stmt_prepare($stmt, $sql)){
                    header("location: index.php?login=quick&error=stmtfailed");
                    exit();
                }

                mysqli_stmt_bind_param($stmt, "ssssss", $name, $description, $date, $location, $hashtags, $eventID);

                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                header("location: home.php?error=none&edit=true");
                mysqli_close($conn);
                exit();
                //ENDSQL//
            }


        
        }


    }else{
        header("location: home.php");
    }
?>